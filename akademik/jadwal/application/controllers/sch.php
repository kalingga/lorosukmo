<?php

class Sch extends Controller {
  var $export;
  var $c_limit = 50; // 50 data per halaman
  var $c_offset;

	function Sch(){
     parent::Controller();
      $this->load->library(array('pagination','session'));
      $this->load->helper('url');
      $this->load->model('sia_model');
      //$this->export = $this->uri->segment(4); // jika terisi 'export' berarti tidak view tp export XLS
      $this->c_offset = $this->uri->segment(4);
      //$this->session->set_userdata('parentMenu','pooling');
      session_start();
      if(!isset($_SESSION['upy.ac.idakademikuser_admin']) OR 
        $_SESSION['upy.ac.idakademikuser_admin'] == ""){
          exit;
          
      }
                 
	}
		
  function index(){ 
    // nothing
  }  
  
  function form(){
    // clear session
    $this->session->set_userdata('gabungkelas1', "");
    $this->session->set_userdata('gabungkelas2', "");
    $this->session->set_userdata('gabungkelas3', "");
      
    $this->session->set_userdata('manual_edit',0); // tambah data baru
    $encprodi = $this->uri->segment(3);//"32";
    $kodeprodi = $this->sia_model->decrypt($encprodi); 
    if($kodeprodi == ""){
      exit; 
    }else{
      $_SESSION['jadwal_kodeprodi'] = $kodeprodi;
    }
    
    $smt = $this->sia_model->getPeriode(); 
    $data['listDosen'] = $this->sia_model->getListDosen();         
    $data['listMatkul'] = $this->sia_model->getListMK($kodeprodi, $smt);
    $this->load->view('form_view',$data);
  
  }
  
  function edit(){ 
      // clear session
      $this->session->set_userdata('gabungkelas1', "");
      $this->session->set_userdata('gabungkelas2', "");
      $this->session->set_userdata('gabungkelas3', ""); 
       
      $this->session->set_userdata('manual_edit',1);  // edit data  
      // ************ START FILL DATA FOR EDITING ********************************
      $idmksaji = $this->uri->segment(4);    
      // get detail 
      $detailJadwal = $this->sia_model->getOneJadwal($idmksaji);
      
      if($detailJadwal->num_rows() > 0){    
          foreach($detailJadwal->result() as $row){
              $matkul = $row->KDKMKMKSAJI;
              $kelas = $row->KELASMKSAJI;
              $nodos = $row->NODOSMKSAJI;
              $kapasitas = $row->KAPASITAS;
              $prodi = $row->KDPSTMKSAJI;
          }
      }else{
          exit; // kalo ga ada berarti hacking
      }
      // ==================== simpan di session dulu aja  
      $_SESSION['jadwal_kodeprodi'] = $prodi;
      $this->session->set_userdata('manual_id',$idmksaji);
      $this->session->set_userdata('manual_matkul',$matkul);
      $this->session->set_userdata('manual_kelas',$kelas);
      $this->session->set_userdata('manual_nodos',$nodos);
      $this->session->set_userdata('manual_kapasitas',$kapasitas);
      // ******************* END OF FILL EDIT DATA *******************************
      
      // SETELAH TAMPIL FORM EDIT, POST KE FUNCTION CREATE
      $smt = $this->sia_model->getPeriode();
      $data['listDosen'] = $this->sia_model->getListDosen();         
      $data['listMatkul'] = $this->sia_model->getListMK($prodi, $smt);      
      $this->load->view('edit_form_view',$data);   
    
  }
  
  
  // utk edit maupun tambah, akan diarahkan ke function ini
  function create(){
    $simpan = $this->input->post('simpan');
    $matkul = $this->input->post('matkul');    
    $kelas = str_replace(" ","",$this->input->post('kelas'));
    //echo $kelas; exit;
    $kapasitas = $this->input->post('kapasitas');
    $menitPerSKS = $this->input->post('durasi');
    
    //echo $simpan; exit;
    if(!isset($_SESSION['jadwal_kodeprodi'])){
      $prodi = $this->session->userdata('manual_prodi');     // cadangan, sepertinya sudah unused 
    }else{
      $prodi = $_SESSION['jadwal_kodeprodi'];  
    }

    $periode = $this->sia_model->getPeriode();

    // ============ CARI JUMLAH SKS ===========================
    $sks = $this->sia_model->getSKS($matkul);//2; 
    // ====== ADA SKS yang 0 bikin error, handle it! =======
      if($sks < 1){
         $sks = 1;
      }
    // ========================================================
    $ds = explode(" # ",$this->input->post('dosen')); 
    $dosen = $ds[0];
         
    // Data Pelengkap
    $idkmk = "";
    $skskmk = "";
    $semester = "";
    $nodos = "";
    $nmdos = "";
        
    $kmk = $this->sia_model->getKMK($prodi, $matkul);
    foreach($kmk->result() as $kmk){
      $idkmk = $kmk->IDX;
      $skskmk = $kmk->SKSMKTBKMK;
      $semester = $kmk->SEMESTBKMK;       
    }
    // ==================== simpan di session dulu aja
    $this->session->set_userdata('manual_periode',$periode);
    $this->session->set_userdata('manual_idkmk',$idkmk);
    $this->session->set_userdata('manual_prodi',$prodi);
    $this->session->set_userdata('manual_matkul',$matkul);
    $this->session->set_userdata('manual_sks',$sks);
    $this->session->set_userdata('manual_semester',$semester);
    $this->session->set_userdata('manual_kelas',$kelas);
    $this->session->set_userdata('manual_nodos',$ds[0]);
    $this->session->set_userdata('manual_namados',$ds[1]);
    $this->session->set_userdata('manual_kapasitas',$kapasitas);
    $this->session->set_userdata('manual_menitPerSKS',$menitPerSKS);
    // =================================================================
    // kalo simpan = "Simpan Tanpa Jadwal" berarti langsung simpan tanpa jadwal : untuk kelas baru
    // kalo simpan = "Simpan" berarti update dosen, kelas, dan kapasitas saja   : untuk edit kelas
    // kalo simpan = "Pilih Ruang" berarti ke function pilihManual
    
    if($simpan == "Simpan Tanpa Jadwal"){
      $this->savenull();
    }else if($simpan == "Simpan"){
      $this->updateInfoOnly();  
    }else{
      $this->pilihManual();
    }
    
  } // END OF FUNCTION  
  
  
  function pilihManual(){   // Jika mau pilih jadwal manual, milih dari tabel
    $durasiSKS = $this->session->userdata('manual_menitPerSKS');
    $this->load->model('ruang_model');
    
    // ================== search form =================
    if($this->input->post('search_form') <> ""){
        $namaruang = $this->input->post('namaruang');
        $this->session->set_userdata('filter_ruang', $namaruang);
    }
     
    // ================ PAGINATION ===============
    $offset = $this->uri->segment(3,0);
    $jmlHal =  $this->ruang_model->getCountRoom($this->session->userdata('manual_kapasitas'), $this->session->userdata('filter_ruang')); 
	  $data['nomor'] = $offset+1;
	  $room = $this->ruang_model->getRoomProdi($this->session->userdata('manual_prodi'), $this->session->userdata('manual_kapasitas'), 
          $this->session->userdata('filter_ruang'), $offset, 2);	  
	  $data['pagination'] = $this->getPagination($jmlHal, 2,'sch/pilihmanual/',3); 
        
    // ===========================================
    
    if(($this->session->userdata('manual_prodi') == '41') OR ($this->session->userdata('manual_prodi') == '11') 
		OR ($this->session->userdata('manual_prodi') == '44') OR ($this->session->userdata('manual_prodi') == '46')){
        $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    }else{
        $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');        
    }
    //**********************************************    
    
    $jam = array();        
    
    if($durasiSKS == "50"){
        $jamKuliahPertama = "07:00";
        $jamKuliahTerakhir = "18:00";    
        $curJam = "07:00:00"; // initial value
    }else if($durasiSKS == "40"){
        $jamKuliahPertama = "07:00";
        $jamKuliahTerakhir = "18:00";    
        $curJam = "07:00:00"; // initial value
    }else{
        $jamKuliahPertama = "14:00";
        $jamKuliahTerakhir = "20:00";    
        $curJam = "14:00:00"; // initial value
    }
    $sesi = 0; 
    
    while(strtotime($curJam) < strtotime($jamKuliahTerakhir)){
        $curJam =  date('H:i', strtotime($jamKuliahPertama) + ($durasiSKS* $sesi * 60) );
        array_push($jam,$curJam);
        $sesi++;
    }
    
    //print_r($jam);
    //exit;
    // ***********************************************      
    
    $data['tabel'] = '<table width="600" border="1">';
    $data['tabel'] .= '  <tr>
              <td rowspan="1" style="text-align:center;">Unit</td><td rowspan="1">Ruang</td>
              <td colspan="'.(count($jam)+1).'">Penggunaan Ruang </td>
            </tr>';
    if($room->num_rows() > 0){
        foreach($room->result() as $row){               
            $data['tabel'] .=  '<tr>
                  <td rowspan="'.(count($hari) + 1).'"  style="text-align:center;">'.$row->ruangUnit.'</td>
                  <td rowspan="'.(count($hari) + 1).'"><span style="font-size:120%; font-weight:bold;">'.$row->ruangNama.'</span><br />Kapasitas : '.$row->ruangKapasitas.'</td>'; // /tr nanti di belakang
            $data['tabel'] .=  '<td style="background-color:#333; color:#eee;">Hari/Jam</td>';
            
            for($i = 0; $i< count($jam); $i++){
                $data['tabel'] .=  "<td>".$jam[$i]."</td>";
            
            }
             $data['tabel'] .=  "</tr>";
             
           //echo $data['tabel']; 
           //exit;  
                        
            for($h=0;$h < count($hari);$h++){
              
            $data['tabel'] .=  '<td>'.$hari[$h].'</td>';
            $j = 0;
            while($j < count($jam)){            
            // ================ CEK DOSEN ==================== 
                          
  		  $selesai=date('H:i:s',(strtotime($jam[$j]) + (60 * $durasiSKS)));   							
                $cekDosen = $this->sia_model->cekDosen($this->session->userdata('manual_periode'), $this->session->userdata('manual_nodos'), $hari[$h], ($jam[$j]), $selesai);   // increase 50 menit
                if($cekDosen->num_rows() > 0){
                    // ===========================================
                    foreach($cekDosen->result() as $res){
                        $idtabel = $res->IDX;
                        // cek masih berapa lama dari waktu berakhir kuliah
                        $sisadurasiDosen = (strtotime($res->SMPAIMKSAJI) - strtotime($jam[$j]))/60; // durasi dalam menit                       
                        if($sisadurasiDosen <= 0){
                             $sisadurasiDosen = $durasiSKS; // durasi 1 sks dalam menit
                        }                
                        
                    } 
                    // create whitespace link
                    $lnk = "";
                    $d = $durasiSKS;
                    while($d <= $sisadurasiDosen ){
                      $lnk .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                      $d = $d + $durasiSKS;
                    }
                //    echo round($sisadurasiDosen / $durasiSKS)."<br />"; //exit;                 
                    $data['tabel'] .=  "<td colspan=".ceil($sisadurasiDosen / $durasiSKS)." style='max-width:5px; background-image:url(".base_url()."images/btn_black.jpg); color:white;'>
                        <a class='fancy jadwal' href='".base_url()."info/dosen/".$idtabel."'> $lnk</a></td>";
                    $j = $j+ ceil($sisadurasiDosen / $durasiSKS);
                    
                    // ==================^^^^^^^^^=================
                }else{
                    // ********************* CEK RUANG *************************
                    // ********************************************************* 
                    //echo "Ruang :".$jam[$j]." $j # "; 
                    $selesai=date('H:i:s',(strtotime($jam[$j]) + (60 * $durasiSKS)));                 
                          $used = $this->ruang_model->cekRoom($this->session->userdata('manual_periode'), $hari[$h], $row->ruangId,$jam[$j], $selesai);
                          if($used->num_rows() > 0){
                              // ===========================================
                              foreach($used->result() as $rom){                                  
                                  $idtabel = $rom->IDX;
                                  // cek masih berapa lama dari waktu berakhir kuliah
                                  $sisadurasiRuang = (strtotime($rom->SMPAIMKSAJI) - strtotime($jam[$j]))/60; // durasi dalam menit         
                                                
                                  if($sisadurasiRuang <= 0){
                                       $sisadurasiRuang = $durasiSKS; // 
                                  }                                
                                  
                              }
                              // create whitespace link
                              $lnk3 = "";
                              $r = $durasiSKS;
                              while($r <= $sisadurasiRuang ){
                                $lnk3 .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                $r = $r + $durasiSKS;
                              }
                                 
                              $data['tabel'] .=  "<td colspan=".ceil($sisadurasiRuang / $durasiSKS)." style='max-width:5px; background-image:url(".base_url()."images/btn_red.jpg); color:white;'>
                                   <a class='fancy jadwal' href='".base_url()."info/ruang/".$idtabel."'> $lnk3</a></td>";
                              $j = $j+ ceil($sisadurasiRuang / $durasiSKS);
                          }else{
                              // ************** CEK KELAS, TERMASUK JIKA KELAS GABUNGAN (COMMA SEPARATED) ****                                                         
                              // *****************************************************************************                              
                              $selesai=date('H:i:s',(strtotime($jam[$j]) + (60 * $durasiSKS)));
                              // KELAS GABUNGAN LANGSUNG DICEK DI MODEL AJA
                              $cekKelas = $this->sia_model->cekKelas($this->session->userdata('manual_periode'), $this->session->userdata('manual_prodi'), 
                                          $this->session->userdata('manual_kelas'), $this->session->userdata('manual_semester'), 
                                          $hari[$h], $jam[$j], $selesai); 
                              if($cekKelas->num_rows() > 0){
                                  // ===========================================
                                  foreach($cekKelas->result() as $kls){ 
                                      $idtabel = $kls->IDX;                                 
                                      // cek masih berapa lama dari waktu berakhir kuliah
                                      $sisadurasiKelas = (strtotime($kls->SMPAIMKSAJI) - strtotime($jam[$j]))/60; // durasi dalam menit                       
                                      if($sisadurasiKelas <= 0){
                                           $sisadurasiKelas = $durasiSKS; // 50 menit
                                      }                                 
                                      
                                  }
                                  // create whitespace link
                                  $lnk2 = "";
                                  $k = $durasiSKS;
                                  while($k <= $sisadurasiKelas ){
                                    $lnk2 .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                    $k = $k + $durasiSKS;
                                  }
                                  
                                  $data['tabel'] .=  "<td colspan=".ceil($sisadurasiKelas / $durasiSKS)." style='max-width:5px; background-image:url(".base_url()."images/btn_blue.jpg); xbackground:blue; color:white;'>
                                      <a class='fancy jadwal' href='".base_url()."info/kelas/".$idtabel."'>$lnk2</a></td>";
                                  $j = $j+ ceil($sisadurasiKelas / $durasiSKS);
                              }else{
                                  // ************** JADWAL AVAILABLE **********************                                                         
                                  // ******************************************************
                                 
                                  $data['tabel'] .=  "<td style='background-image:url(".base_url()."images/btn_green.jpg); max-width:5px;'><a class='jadwal' 
                                        href='".base_url()."sch/saveManual/".$hari[$h]."/".$row->ruangId."/".str_replace(":","-",$jam[$j])."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>";
                                  $j++;
                              }
                              
                            // ***********************************************   
                          } // ========= END OF CEK KELAS
                }  // ================== END OF CEK RUANG  
            } // ======================= END OF LOOP JAM
            $data['tabel'] .=  "</tr>";
             
            }
            $data['tabel'] .=  "</tr>";
                    
        } // === END OF FOREACH
    }else{// ==== IF No Room specified
        $data['tabel'] .= "<tr><td colspan=19 style='text-align:center; font-size:100%; font-weight:bold; color:red;'> Tidak ada ruang yang sesuai pencarian </td></tr>";
    }
    $data['tabel'] .= "</table>";
    $data['status'] = "add";
    
    $this->load->view('ruang_pilih_manual', $data);
  
  }
  
  function savemanual(){
    $durasiSKS = $this->session->userdata('manual_menitPerSKS');
    // clear filter
    $this->session->set_userdata('filter_ruang', "");
        
    $hari = $this->uri->segment(3);
    $ruangId = $this->uri->segment(4);
    $jam = str_replace("-",":",$this->uri->segment(5));//.":00:00";

    // ============= CEK DOSEN ==========================================
    $dos = $this->sia_model->cekDosen($this->session->userdata('manual_periode'), $this->session->userdata('manual_nodos'), $hari, $jam,
            date('H:i:s',strtotime($jam)+($this->session->userdata('manual_sks') * (60 * $durasiSKS)))); 
    // ============= CEK KELAS ========================================== 
    $cekKelas = $this->sia_model->cekKelas($this->session->userdata('manual_periode'), $this->session->userdata('manual_prodi'), 
            $this->session->userdata('manual_kelas'), $this->session->userdata('manual_semester'), $hari, $jam, 
            date('H:i:s',strtotime($jam)+($this->session->userdata('manual_sks') * (60 * $durasiSKS))));
    
    // ============= CEK RUANG ==========================================
    $res = $this->sia_model->cekManualRuang($this->session->userdata('manual_prodi'), $this->session->userdata('manual_periode'), $hari, 
           $ruangId, $jam, date('H:i:s',strtotime($jam)+($this->session->userdata('manual_sks') * (60 * $durasiSKS))));
           
    // ============= JADWAL RAPAT PRODI ================================= 
    $rapat = $this->sia_model->jadwalRapat($this->session->userdata('manual_prodi'));
    $rapatHari = "";
    $rapatMulai = "";
    $rapatSelesai = "";
    
    foreach($rapat->result() as $row){
        $rapatHari = $row->rapatHari;
        $rapatMulai = $row->rapatMulai;
        $rapatSelesai = $row->rapatSelesai;    
    }        
     
      // ================ KALO ADA YANG TUMBUKAN, EXIT ===========================
      // =========================================================================
      if($res->num_rows() > 0){
          $d['warning'] = "Durasi kuliah bertumbukan dengan jadwal lain";
          //echo "Ruang digunakan kuliah lain";
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;
      }
      
      if($dos->num_rows() > 0){
          $d['warning'] =  "Jadwal dosen pengajar tumbukan dengan jadwal lain";
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;
      }
      
      if($cekKelas->num_rows() > 0){
          $d['warning'] =  "Jadwal bertumbukan untuk kelas ".$this->session->userdata('manual_kelas').", semester ".$this->session->userdata('manual_semester');
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;
      }
         
      // ============= PEJABAT TIDAK NGAJAR HARI SENIN ==============   
      $isPejabat = $this->sia_model->getStatus($this->session->userdata('manual_nodos'));
      if(($isPejabat > 0) AND ($hari == "Senin")){
          $d['warning'] =  "Dosen tidak dapat mengajar hari Senin dikarenakan rapat dengan rektorat";
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;
      }         
      //echo "aaaaaaaaaa";
     // KALO PAS JUMATAN, KULIAH DIKOSONGKAN
      if(($hari == "Jumat") AND (strtotime($jam) < strtotime("13:00:00")) AND (strtotime($jam)+($this->session->userdata('manual_sks')*(60 * $durasiSKS)) > strtotime("11:10:00"))){
          $d['warning'] =  "Waktu yang dipilih tumbukan dengan waktu ibadah sholat Jum'at";
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;        
      
      }
      
      // SAAT RAPAT PRODI, KULIAH DIKOSONGKAN
      if(($hari == $rapatHari) AND (strtotime($jam) < strtotime($rapatSelesai)) AND (strtotime($jam)+($this->session->userdata('manual_sks')*(60 * $durasiSKS)) > strtotime($rapatMulai))){
          $d['warning'] =  "Waktu yang dipilih tumbukan dengan jadwal rapat prodi";
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;    
      }
      
      // REKTORAT (dengan status jabatan 2) rapat juga hari kamis pagi
      if($isPejabat == 2 and ($hari == "Kamis") AND (strtotime($jam) < strtotime("10:00:00")) AND (strtotime($jam)+($this->session->userdata('manual_sks')*(60 * $durasiSKS)) > strtotime("07:00:00"))){
          $d['warning'] =  "Waktu yang dipilih tumbukan dengan jadwal rapat rutin rektorat";
          $fff = $this->load->view('notifikasi',$d, true);
          echo $fff;          
         
          exit;      
      }
    
      if($this->session->userdata('manual_edit') == 1){ // update data
          $this->sia_model->updatejadwal($this->session->userdata('manual_id'),
          $this->session->userdata('manual_kelas'), 
          $this->session->userdata('manual_nodos'), 
          $this->session->userdata('manual_namados'), 
          $ruangId, $hari, $jam, date('H:i:s',strtotime($jam)+($this->session->userdata('manual_sks') * (60 * $durasiSKS))), 
          $this->session->userdata('manual_kapasitas'));
     
      }else{
          $this->sia_model->insertjadwal($this->session->userdata('manual_periode'), 
          $this->session->userdata('manual_idkmk'), 
          $this->session->userdata('manual_prodi'), 
          $this->session->userdata('manual_matkul'), 
          $this->session->userdata('manual_sks'), 
          $this->session->userdata('manual_semester'), 
          $this->session->userdata('manual_kelas'), 
          $this->session->userdata('manual_nodos'), 
          $this->session->userdata('manual_namados'), 
          $ruangId, $hari, $jam, date('H:i:s',strtotime($jam)+($this->session->userdata('manual_sks') * (60 * $durasiSKS))), 
          $this->session->userdata('manual_kapasitas'));
      }           
     
      $error_msg = $this->sia_model->getError(); 
          if($error_msg == ""){
              echo "<script>parent.jQuery.fancybox.close();</script>";
          }else{
              if(strstr($error_msg, 'Duplicate entry')){
                echo "Data telah ada, cek kembali matakuliah dan kelas!";
                //$this->load->view('notifikasi',$d);
              }else{
                echo "Pesan Error :<br />".$error_msg ;
                //$this->load->view('notifikasi',$d);
              }
          }    
  }
  
  function savenull(){
      $this->sia_model->insertjadwal($this->session->userdata('manual_periode'), 
      $this->session->userdata('manual_idkmk'), 
      $this->session->userdata('manual_prodi'), 
      $this->session->userdata('manual_matkul'), 
      $this->session->userdata('manual_sks'), 
      $this->session->userdata('manual_semester'), 
      $this->session->userdata('manual_kelas'), 
      $this->session->userdata('manual_nodos'), 
      $this->session->userdata('manual_namados'), 
      "", "-", "", "", 
      $this->session->userdata('manual_kapasitas'));
     
      $error_msg = $this->sia_model->getError(); 
      if($error_msg == ""){
          echo "<script>parent.jQuery.fancybox.close();</script>";
      }else{
          if(strstr($error_msg, 'Duplicate entry')){
            echo "Data telah ada, cek kembali matakuliah dan kelas!";            
          }else{
            echo "Pesan Error :<br />".$error_msg ;
          }
      }
  }
  
  function updatenull(){   // $id, $kelas, $nodos, $nmdos, $ruang, $hr, $jamMulai, $jamBerakhir, $kapasitas){
      $this->sia_model->updatejadwal($this->session->userdata('manual_id'), 
      $this->session->userdata('manual_kelas'), 
      $this->session->userdata('manual_nodos'), 
      $this->session->userdata('manual_namados'), 
      "", "-", "", "", 
      $this->session->userdata('manual_kapasitas'));
     
      echo "<script>parent.jQuery.fancybox.close();</script>";
  }
  
  function updateInfoOnly(){
      $this->sia_model->updateinfo($this->session->userdata('manual_id'), 
      $this->session->userdata('manual_kelas'), 
      $this->session->userdata('manual_nodos'), 
      $this->session->userdata('manual_namados'),
      $this->session->userdata('manual_kapasitas'));
     
      echo "<script>parent.jQuery.fancybox.close();</script>";
  
  }  
  
  function getPagination($total, $per_page, $url, $uri_segment){
        $config['base_url'] = base_url().$url;
        $config['uri_segment'] = $uri_segment;          
        $config['next_link'] = '<img src="'.base_url().'images/next.gif" width ="16" align ="middle" border ="0" style="padding-bottom:8px;">';
        $config['prev_link'] = '<img src="'.base_url().'images/before.gif" width ="16" align ="middle" border ="0" style="padding-bottom:8px;">';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['num_links'] = 2;
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
  }
  
 
} // ========= EOC =================

