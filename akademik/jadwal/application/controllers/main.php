<?php

class Main extends Controller {
  var $export;
  var $c_limit = 50; // 50 data per halaman
  var $c_offset;

	function Main(){
     parent::Controller();
      $this->load->library(array('pagination','session'));
      $this->load->helper('url');
      $this->load->model('sia_model');
      //$this->export = $this->uri->segment(4); // jika terisi 'export' berarti tidak view tp export XLS
      $this->c_offset = $this->uri->segment(4);
      //$this->session->set_userdata('parentMenu','pooling');
      session_start();
      /*if(!isset($_SESSION['upy.ac.idakademikuser_admin']) OR 
      $_SESSION['upy.ac.idakademikuser_admin'] == "")
          redirect('http://upy.ac.id/akademik');
      */          
	}
		
  function index(){ 
    // nothing
  }  
  
  function form(){
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
    $this->load->view('view_form',$data);
  
  }
  
  function create(){
    $prodi = $_SESSION['jadwal_kodeprodi'];
    $periode = $this->sia_model->getPeriode();

    $matkul = $this->input->post('matkul');
    // ============ CARI JUMLAH SKS ===========================
    $sks = $this->sia_model->getSKS($matkul);//2; 
    // ====== ADA SKS yang 0 bikin error, handle it! =======
      if($sks < 1){
         $sks = 1;
      }
    // ========================================================
    $ds = explode(" # ",$this->input->post('dosen')); 
    $dosen = $ds[0];
    $kelas = $this->input->post('kelas');
    $kapasitas = $this->input->post('kapasitas');
    $status = $this->input->post('status');
    $perlujadwal = $this->input->post('perlujadwal');
    $jenisruang = $this->input->post('jenisruang');        
    

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
      $nodos = $kmk->NODOSTBKMK;  
      $nmdos = $kmk->NMDOSTBKMK;        
    }
    
    
    
     // ===== KALO TANPA JADWAL, LANGSUNG INSERT ========
    if($perlujadwal <> "on"){
      //echo "Ga perlu jadwal";
        $this->pilihManual($periode, $idkmk, $prodi, $matkul, $sks, 
          $semester, $kelas, $ds[0], $ds[1], $kapasitas); // setelah $ds[1] : $ruang, $hr, $jamMulai, $jamselesai
        exit;
        /*
        $this->sia_model->insertjadwal($periode, $idkmk, $prodi, $matkul, $sks, 
          $semester, $kelas, $ds[0], $ds[1], "", "-", "", "", $kapasitas);
        //echo "Tanpa Jadwal Khusus";   
        echo "<script>parent.jQuery.fancybox.close();</script>";
        exit; // langsung keluar aja biar ga ribet  
        */
    }
    
    // =================================================

    // cari dari tiap : hari, jam, ruang
    $ruangProdi = array();
    $ruangTetangga = array();
    $ruangKampus = array();
    
    // =========================== ISI ARRAY RUANG =============================
    $listruang = $this->sia_model->getPrivRuang($prodi, $kapasitas, $jenisruang);
    if($listruang->num_rows() > 0){
      foreach($listruang->result() as $row){
         array_push($ruangProdi,$row->rpRuangId);
      }
    }else{      
      array_push($ruangProdi,"xxx");
    }
    
    $rt = $this->sia_model->getRuangTetangga($prodi, $kapasitas, $jenisruang);
    if($rt->num_rows() > 0){
      foreach($rt->result() as $rte){
         array_push($ruangTetangga,$rte->rpRuangId);
      }
    }else{
      array_push($ruangTetangga,"yyy");
    }
    
    $rk = $this->sia_model->getRuangKampus($prodi, $kapasitas, $jenisruang);
    if($rk->num_rows() > 0){
      foreach($rk->result() as $rka){
         array_push($ruangKampus,$rka->ruangId);
      }
    }else{
      array_push($ruangKampus,"zzz");
    }
    // =========================================================================        
    
    /*
    print_r($ruangProdi);
    print_r($ruangTetangga);
    print_r($ruangKampus);
    */
    // ============= PEJABAT TIDAK NGAJAR HARI SENIN ==============
    $loop = 1;
    $isPejabat = $this->sia_model->getStatus($ds[0]);
    if($isPejabat > 0){
        $hari = array('Selasa','Rabu', 'Kamis', 'Jumat');
    }else{
        $hari = array('Senin','Selasa','Rabu', 'Kamis', 'Jumat');
    }
         
    // ============= JADWAL RAPAT PRODI =========
    $rapat = $this->sia_model->jadwalRapat($prodi);
    $rapatHari = "";
    $rapatMulai = "";
    $rapatSelesai = "";
    
    foreach($rapat->result() as $row){
        $rapatHari = $row->rapatHari;
        $rapatMulai = $row->rapatMulai;
        $rapatSelesai = $row->rapatSelesai;    
    }

    $a = 0;     // array hari
    $penanda = 0; // flag penanda tipe ruang (prodi, tetangga, atau kampus)
    $b = 0;     // array ruangProdi
    $c = 0;    // array ruang tetangga
    $d = 0;    // array ruang sekampus
    $index_ttg_oke = true; // penanda index dari array masih ada atau tidak
    $index_kampus_oke = true; // penanda index dari array masih ada atau tidak
    $flag1 = 0; // penanda kalo tipe ruangTetangga sudah masuk query, menghindari array -1
    $flag2 = 0; // penanda kalo tipe ruangKampus sudah masuk query
    if($status == "R"){
      $jamMulai = '07:00:00';                     // date('h:i:s',strtotime($jamMulai)+7200) // tambah 2 jam
    }else{
      $jamMulai = '14:00:00';
    }
    
    //echo "$matkul<br />$dosen<br />$kelas<br />$kapasitas<br />$status<br />";
        
    while($loop == 1){
      
      // ============================ CEK RUANG ================================
      // untuk ruang tetangga dan ruang kampus terdapat perlakuan yang berbeda, karena array-nya increase dulu sebelum tereksekusi, 
      // sehingga index harus di cek ada atau tidaknya melalui variabel $index...oke
      // 
      
      // KALO PAS JUMATAN, KULIAH DIKOSONGKAN
      if(($hari[$a] == "Jumat") AND (strtotime($jamMulai) < strtotime("13:00:00")) AND (strtotime($jamMulai)+($sks*3600) > strtotime("11:00:00"))){
          $jamMulai = "13:00:00";  
      
      }
      
      // SAAT RAPAT PRODI, KULIAH DIKOSONGKAN
      if(($hari[$a] == $rapatHari) AND (strtotime($jamMulai) < strtotime($rapatSelesai)) AND (strtotime($jamMulai)+($sks*3600) > strtotime($rapatMulai))){
          $jamMulai = $rapatSelesai;    
      }
      
      // REKTORAT (dengan status jabatan 2) rapat juga hari kamis pagi
      if($isPejabat ==2 and ($hari[$a] == "Kamis") AND (strtotime($jamMulai) < strtotime("10:00:00")) AND (strtotime($jamMulai)+($sks*3600) > strtotime("07:00:00"))){
         $jamMulai = "10:00:00";    
   
      }

	// cek availability dosen
      $dos = $this->sia_model->cekDosen($periode, $dosen, $hari[$a], $jamMulai, date('H:i:s',strtotime($jamMulai)+($sks * 3600))); 
      // cek kelas tubrukan atau tidak 
      $cekKelas = $this->sia_model->cekKelas($periode, $prodi, $kelas, $semester, $hari[$a], $jamMulai, date('H:i:s',strtotime($jamMulai)+($sks * 3600))); 

      // =======================================================================
      if($index_ttg_oke){
          //echo "index oke<br />";
          $res = $this->sia_model->cekRuang($prodi, $periode, $hari[$a], $ruangProdi[$b],$ruangTetangga[$c],$ruangKampus[$d],$jamMulai, date('H:i:s',strtotime($jamMulai)+($sks * 3600)), $penanda);
          $index_rt = $c;

          // buat langsung lompat ke ruang tetangga
          if(($penanda == 0) AND ($ruangProdi[$b] == "xxx") or ($penanda == 1) AND ($ruangTetangga[$c] == "yyy")){   
              $jamMulai ='18:00:00';
              $a = count($hari)-1;
              $b = count($ruangProdi)-1;
              $imaginerRoom = 1; // jangan anggap dapet ruang
          }else{
              $imaginerRoom = 0;
          }
                      
          
      }elseif(!$index_ttg_oke AND $index_kampus_oke ){
          //echo "mlebu kene ra kwi?<br />";
          $res = $this->sia_model->cekRuang($prodi, $periode, $hari[$a], $ruangProdi[$b],$ruangTetangga[$c-1],$ruangKampus[$d],$jamMulai, date('H:i:s',strtotime($jamMulai)+($sks * 3600)), $penanda);
          $index_rt = $c-1;
          $index_rk = $d;
          
          
          // buat lompat ke ruang kampus
          if(($penanda == 0) AND ($ruangProdi[$b] == "xxx") or ($penanda == 1) AND ($ruangTetangga[$c-1] == "yyy")){
              $jamMulai ='18:00:00';
              $b = count($ruangProdi)-1;
              $a = count($hari)-1;
              $c = count($ruangTetangga); 
              $imaginerRoom = 1; // jangan anggap dapet ruang
          
          }else{
              $imaginerRoom = 0;
          }
      }elseif(!$index_ttg_oke AND !$index_kampus_oke ){
          $res = $this->sia_model->cekRuang($prodi, $periode, $hari[$a], $ruangProdi[$b],$ruangTetangga[$c-1],$ruangKampus[$d-1],$jamMulai, date('H:i:s',strtotime($jamMulai)+($sks * 3600)), $penanda);
          $index_rk = $d-1;
          
          if(($penanda == 0) AND ($ruangProdi[$b] == "xxx") or ($penanda == 1) AND ($ruangTetangga[$c-1] == "yyy") or ($penanda == 2) AND ($ruangKampus[$d-1] == "zzz")){    // buat langsung lompat ke no room
              $jamMulai ='18:00:00';
              $b = count($ruangProdi)-1;
              $a = count($hari)-1;
              $c = count($ruangTetangga); 
              $d = count($ruangKampus);
              $imaginerRoom = 1; // jangan anggap dapet ruang  
              
          }else{
              $imaginerRoom = 0;
          }      
      }     
      
      
      // ======================= CEK AVAILABILITY ===================================================== 
      if(($res->num_rows() > 0) OR ($dos->num_rows() > 0) OR ($cekKelas->num_rows() > 0) OR ($imaginerRoom == 1)){      // kalo ruang atau dosen sedang isi  atau tidak tersedia
            // kalo masih ada jam, increase jamnya aja                            
           if(strtotime($jamMulai)+($sks * 3600) <= strtotime('18:00:00')){
              $jamMulai = date('H:i:s',strtotime($jamMulai)+($sks*3600));            
               
           }// sampai jam terakhir, tapi masih ada ruangProdinya : cek ruang lain
           elseif((strtotime($jamMulai)+($sks * 3600) > strtotime('18:00:00')) AND (($b+1) < count($ruangProdi))){ //count($ruangProdi)                               
              if($status == "R"){
                $jamMulai = '07:00:00';  // jam direset
              }else{
                $jamMulai = '14:00:00';
              }
              $b++;                   // ruang selanjutnya
              
           // sampai jam terakhir, ruangProdinya habis, tapi masih ada hari : ganti hari selanjutnya     
           }elseif((strtotime($jamMulai)+($sks * 3600) > strtotime('18:00:00')) AND ($b == count($ruangProdi)-1 ) AND ($a < (count($hari)-1))){              
              //echo "ganti hari<br />";
              $b = 0;                     // ruang direset
              if($status == "R"){
                $jamMulai = '07:00:00';  // jam direset
              }else{
                $jamMulai = '14:00:00';
              } 
              $a++;                      // hari selanjutnya 
            
           // jam, ruangProdi dan hari telah habis, ganti ke ruang tetangga
           }elseif((strtotime($jamMulai)+($sks * 3600) > strtotime('18:00:00')) AND ($b == count($ruangProdi)-1 ) AND ($a == (count($hari)-1)) AND ($c < count($ruangTetangga))){              
              //echo "ganti ruang tetangga<br />";
              
              if($status == "R"){
                $jamMulai = '07:00:00';  // jam direset
              }else{
                $jamMulai = '14:00:00';
              } 
              $a = 0;                      // hari direset
               // ruang prodi tidak direset, agar tidak ikut loop lagi 
              $penanda = 1;                // aktifkan ruang tetangga
              
              if($flag1 > 0){ // kalo sudah lebih dari 0 baru ditambah index ruangnya, supaya yang index 0 dicek dulu
                $c++;
                if(($c+1) < count($ruangTetangga)){ //index masih ada setelah di increase 
                  $index_ttg_oke = true;
                }else{
                  $index_ttg_oke = false;
                }
                 
              }
              $flag1 = 1;
              
            
           // jam, ruangProdi dan hari telah habis, ruang tetangga juga habis, pindah ke ruang yg ada di kampus
           }elseif((strtotime($jamMulai)+($sks * 3600) > strtotime('18:00:00')) AND ($b == count($ruangProdi)-1 ) AND ($a == (count($hari)-1)) AND (($c+1) >= count($ruangTetangga)) AND($d < count($ruangKampus) )){ 
               // cari di semua ruang kampus
               //echo "ganti ruang kampus<br />";
               if($status == "R"){
                $jamMulai = '07:00:00';  // jam direset
               }else{
                  $jamMulai = '14:00:00';
               } 
               $a = 0;                      // hari direset
               // ruangProdi dan ruangTetangga tidak direset, agar tidak ikut loop lagi 
               $penanda = 2;                // aktifkan ruang kampus
               if($flag2 > 0){
                $d++;
                if(($d+1) < count($ruangKampus)){ //index masih ada setelah di increase 
                  $index_kampus_oke = true;
                }else{
                  $index_kampus_oke = false;
                } 
               }
               $flag2 = 1;
            
           }else{ // kalo habis semuanya              
              $loop = 0; // stop the loop
              echo "Tidak ada ruang yang tersedia, coba kurangi kapasitas atau ganti dosen pengajar";
             
           }
           
        
      }else{  // ====== kalo sudah nemu ruang yang kosong dan dosen available
          $hr = $hari[$a];
          // $jamMulai udah di set dalam loop
          if($penanda == 0){
            $ruang = $ruangProdi[$b];
          }elseif($penanda == 1){
            $ruang = $ruangTetangga[$index_rt];
          }else{
            $ruang = $ruangKampus[$index_rk];
          } 
          $loop = 0; // stop the loop
          
          //echo $penanda."  -  ".$ruang;exit;        
                                      
          // INSERT jadwal
          if(($ruang == "xxx") OR ($ruang == "yyy") OR ($ruang == "zzz") ){
              echo "Tidak ada ruang yang tersedia, coba ganti jenis ruang!";
          }else{
              $this->sia_model->insertjadwal($periode, $idkmk, $prodi, $matkul, $sks, 
              $semester, $kelas, $ds[0], $ds[1], $ruang, $hr, $jamMulai, date('H:i:s',strtotime($jamMulai)+($sks*3600)), $kapasitas);
          }
          
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
          
          
          //echo "JADWAL<br />Hari : $hr, Jam : $jamMulai, Ruang : $ruang, jadwal? : $perlujadwal, Jenis Ruang : $jenisruang";
           
      }
    } // END OF LOOP WHILE
  
  } // END OF FUNCTION
  
  function pilihManual($periode, $idkmk, $prodi, $matkul, $sks, $semester, $kelas, $nodos, $namados, $kapasitas){   // Jika mau pilih jadwal manual, milih dari tabel
    // ==================== simpan di session dulu aja
    $this->session->set_userdata('manual_periode',$periode);
    $this->session->set_userdata('manual_idkmk',$idkmk);
    $this->session->set_userdata('manual_prodi',$prodi);
    $this->session->set_userdata('manual_matkul',$matkul);
    $this->session->set_userdata('manual_sks',$sks);
    $this->session->set_userdata('manual_semester',$semester);
    $this->session->set_userdata('manual_kelas',$kelas);
    $this->session->set_userdata('manual_nodos',$nodos);
    $this->session->set_userdata('manual_namados',$namados);
    $this->session->set_userdata('manual_kapasitas',$kapasitas);
    // =================================================================
    $this->load->model('ruang_model');
    
    // ================ PAGINATION ===============
    $offset = $this->uri->segment(3,0);
    $jmlHal =  $this->ruang_model->getCountAll();
	  $data['nomor'] = $offset+1;
	  $room = $this->ruang_model->getAllRoom($offset, 10);	  
	  $data['pagination'] = $this->getPagination($jmlHal, 10,'ruang/index/',3); 
    
    
    // ===========================================
    
    $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat');
    //$periode = $this->ruang_model->getPeriode();
    
    $data['tabel'] = '<table width="600" border="1">';
    $data['tabel'] .= '  <tr>
              <td rowspan="1" style="text-align:center;">Unit</td><td rowspan="1">Ruang</td>
              <td colspan="17">Penggunaan Ruang </td>
            </tr>';

    foreach($room->result() as $row){               
        $data['tabel'] .=  '<tr>
              <td rowspan="6"  style="text-align:center;">'.$row->ruangUnit.'</td>
              <td rowspan="6">'.$row->ruangNama.'<br />Kapasitas : '.$row->ruangKapasitas.'</td>'; // /tr nanti di belakang
        $data['tabel'] .=  '<td style="background-color:#333; color:#eee;">Hari/Jam</td>
                  <td>07</td>
                  <td>08</td>
                  <td>09</td>
                  <td>10</td>
                  <td>11</td>
                  <td>12</td>
                  <td>13</td>
                  <td>14</td>
                  <td>15</td>
                  <td>16</td>
                  <td>17</td>
                  <td>18</td>
                  <td>19</td>
                  <td>20</td>
                  <td>21</td>
                  <td>22</td>
                </tr>';
        
        $bufTabel = "";        
        for($h=0;$h<5;$h++){
          
          $data['tabel'] .=  '<td>'.$hari[$h].'</td>';
          //$bufTabel .=  '<td>'.$hari[$h].'</td>';
          $flagkosong = 0;
          $jmlKosong = 0;
          
          for($j=7;$j<23;$j++){
            // cek penggunaan ruang
            $used = $this->ruang_model->cekRoom($periode, $hari[$h], $row->ruangId,($j.":00:00"), (($j+1).":00:00"));
            if($used->num_rows() > 0){
                $data['tabel'] .=  "<td style='background:#aaa;'></td>";
                //$bufTabel =  "<td style='background:#aaa;'></td>";
                $flagkosong = 0;
                $jmlKosong = 0;      
            }else{
                // perlu filter utk menampilkan ruang di hari yg available saja, pake counter utk yg kosong berturut2, sesuaikan dengan sks
                $flagkosong = 1;
                $jmlKosong++;
                $data['tabel'] .=  "<td style='background:yellow;'><a href='".base_url()."main/savemanual/".$hari[$h]."/".$row->ruangId."/".$j."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>";
                //$bufTabel =  "<td style='background:yellow;'><a href='".base_url()."main/savemanual/".$hari[$h]."/".$row->ruangId."/".$j."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td>";                  
            }  
          }
          /*
          if(($flagkosong == 1) AND ($jmlKosong >= $sks)){
              $data['tabel'] .= $bufTabel;
          }else{
              // print nothing
          }
          $bufTabel = ""; // reset lagi 
           */
          $data['tabel'] .=  "</tr>";
         
        }
        
        $data['tabel'] .=  "</tr>";
                
    } // === END OF FOREACH
    $data['tabel'] .= "</table>";
    // ============================== tampilan tabel 
    echo '<html>
      <head>
      <link rel="stylesheet" href="'.base_url().'css/ui/jquery.ui.all.css">
      <style>
      table, table tr, table td{
      font-family:Tahoma;
      font-size : 90%;
      padding-top: 2px;
      padding-bottom: 2px;
      border-collapse:collapse; 
      margin:auto;
      }
      
      form {
      font-family:Tahoma;
      font-size : 80%;
      }
      
      h1{
      font-family:Tahoma;
      font-size : 100%;
      text-align:center;
      }
      
      a{
      font-family:Tahoma;
      font-size : 90%;
      text-decoration:none;
      }
      </style>
      
      </head>
      <body>
      <h1>Silakan pilih ruang yang masih belum digunakan</h1>
      <div style="width:600px; margin:auto;">
      Halaman : '.$data['pagination'].'
      </div>
      
      <div style="width:600px; margin:auto;">
      '.$data['tabel'].'
      </div>"
      
      <div style="width:600px; margin:auto;">
      Halaman : '.$data['pagination'].'
      </div>
      </body>
      </html>';
    
    
    // ==============================
    //$this->load->view('ruang_pilih_manual', $data);     
  
  
  }
  
  function getPagination($total, $per_page, $url, $uri_segment){
        $config['base_url'] = base_url().$url;
        $config['uri_segment'] = $uri_segment;          
        $config['next_link'] = '<img src="'.base_url().'images/next.gif" width ="16" align ="top" border ="0">';
        $config['prev_link'] = '<img src="'.base_url().'images/before.gif" width ="16" align ="top" border ="0">';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['num_links'] = 3;
        $config['total_rows'] = $total;
        $config['per_page'] = $per_page;

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
  }
  
  function savemanual(){
      // encrypt, cek availability
      $hari = $this->uri->segment(3);
      $ruangId = $this->uri->segment(4);
      $jam = $this->uri->segment(5);
      // setelah $ds[1] : $ruang, $hr, $jamMulai, $jamselesai
      $this->sia_model->insertjadwal($this->session->userdata('manual_periode'), 
      $this->session->userdata('manual_idkmk'), 
      $this->session->userdata('manual_prodi'), 
      $this->session->userdata('manual_matkul'), 
      $this->session->userdata('manual_sks'), 
      $this->session->userdata('manual_semester'), 
      $this->session->userdata('manual_kelas'), 
      $this->session->userdata('manual_nodos'), 
      $this->session->userdata('manual_namados'), 
      $ruangId, $hari, $jam.":00:00", ($jam+$this->session->userdata('manual_sks')).":00:00", 
      $this->session->userdata('manual_kapasitas'));
  }
  
 
} // ========= EOC =================	
