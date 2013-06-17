<?php

class Ruang extends Controller {
  var $export;
  var $c_limit = 50; // 50 data per halaman
  var $c_offset;

	function Ruang(){
     parent::Controller();
      $this->load->library(array('pagination','session'));
      $this->load->helper('url');
      $this->load->model('ruang_model');
      $this->load->model('sia_model');
      $this->c_offset = $this->uri->segment(4);
      session_start();
      /*if(!isset($_SESSION['upy.ac.idakademikuser_admin']) OR 
      $_SESSION['upy.ac.idakademikuser_admin'] == "")
          redirect('http://upy.ac.id/akademik');
      */          
	}
		
  function index(){    
    $periode = $this->sia_model->getPeriode(); 
    
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
	  $data['pagination'] = $this->getPagination($jmlHal, 2,'ruang/index',3); 
        
    // ===========================================
    
    
    $hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    
    $jam = array('07:00:00',
                 '07:50:00',
                 '08:40:00',
                 '09:30:00',
                 '10:20:00',
                 '11:10:00',
                 '12:00:00',
                 '12:50:00',
                 '13:40:00',
                 '14:30:00',
                 '15:20:00',
                 '16:10:00',
                 '17:00:00',
                 '17:50:00');
    
    $data['tabel'] = '<table width="650" border="1">';
    $data['tabel'] .= '  <tr>
              <td rowspan="1" style="text-align:center;">Unit</td><td rowspan="1">Ruang</td>
              <td colspan="15">Penggunaan Ruang </td>
            </tr>';
    if($room->num_rows() > 0){
        foreach($room->result() as $row){               
            $data['tabel'] .=  '<tr>
                  <td rowspan="'.(count($hari) + 1).'"  style="text-align:center;">'.$row->ruangUnit.'</td>
                  <td rowspan="'.(count($hari) + 1).'"><span style="font-size:120%; font-weight:bold;">'.$row->ruangNama.'</span><br />Kapasitas : '.$row->ruangKapasitas.'</td>'; // /tr nanti di belakang
            $data['tabel'] .=  '<td style="background-color:#333; color:#eee;">Hari/Jam</td>
                      <td>07.00</td>
                      <td>07.50</td>
                      <td>08.40</td>
                      <td>09.30</td>
                      <td>10.20</td>
                      <td>11.10</td>
                      <td>12.00</td>
                      <td>12.50</td>
                      <td>13.40</td>
                      <td>14.30</td>
                      <td>15.20</td>
                      <td>16.10</td>
                      <td>17.00</td>
                      <td>17.50</td>
                    </tr>';
                        
            for($h=0;$h < count($hari);$h++){
                $data['tabel'] .=  '<td>'.$hari[$h].'</td>';
                $j = 0;
                while($j < count($jam)){            
      							$selesai=date('H:i:s',(strtotime($jam[$j]) + 3000));   							               
                        // ********************* CEK RUANG *************************
                        // ********************************************************* 
                        //echo "Ruang :".$jam[$j]." $j # "; 
                        $selesai=date('H:i:s',(strtotime($jam[$j]) + 3000));                 
                              $used = $this->ruang_model->cekRoom($periode, 
                              $hari[$h], $row->ruangId,$jam[$j], $selesai);
                              if($used->num_rows() > 0){
                                  // ===========================================
                                  foreach($used->result() as $rom){                                  
                                      $idtabel = $rom->IDX;
                                      // cek masih berapa lama dari waktu berakhir kuliah
                                      $sisadurasiRuang = (strtotime($rom->SMPAIMKSAJI) - strtotime($jam[$j]))/60; // durasi dalam menit                       
                                      if($sisadurasiRuang <= 0){
                                           $sisadurasiRuang = 50; // 50 menit
                                      }                                
                                      
                                  }
                                                                       
                                  $data['tabel'] .=  "<td colspan=".($sisadurasiRuang / 50)." style='max-width:5px; background-image:url(".base_url()."images/btn_red.jpg); color:white;'>
                                       </td>";
                                  $j = $j+($sisadurasiRuang / 50);
                              }else{
                                      // ************** RUANG AVAILABLE **********************                                                         
                                      // ******************************************************
                                     
                                      $data['tabel'] .=  "<td style='background-image:url(".base_url()."images/btn_green.jpg); max-width:5px;'></td>";
                                      $j++;
                                 
                                // ***********************************************   
                              } // ========= END OF ELSE  
                } // ======================= END OF LOOP JAM
                $data['tabel'] .=  "</tr>"; // nutup hari
             
            }// ============================ END OF LOOP HARI
            $data['tabel'] .=  "</tr>"; // nutup ruang
                    
        } // === END OF FOREACH
    }else{// ==== IF No Room specified
        $data['tabel'] .= "<tr><td colspan=19 style='text-align:center; font-size:100%; font-weight:bold; color:red;'> Tidak ada ruang yang sesuai pencarian </td></tr>";
    }
    $data['tabel'] .= "</table>";
    $data['status'] = "add";        
    
    $this->load->view('penggunaan_ruang_view', $data);
    
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
  
  
  
 
} // ========= EOF =================	
