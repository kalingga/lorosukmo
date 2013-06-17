<?php

class Schujian extends Controller {
  var $export;
  var $c_limit = 50; // 50 data per halaman
  var $c_offset;

	function Schujian(){
     parent::Controller();
      $this->load->library(array('pagination','session'));
      $this->load->helper('url');
      $this->load->model('sia_model');
      $this->load->model('ujian_model');
      $this->c_offset = $this->uri->segment(4);
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
    $id = $this->uri->segment(3);
    $data['detailUjian'] = $this->sia_model->getUjian($id);
    $data['listDosen'] = $this->sia_model->getListDosen();             
    $this->load->view('form_ujian_view',$data);
  
  }
  
  function showRuang(){
    $tgl = $this->input->post('edtTgl');
    $waktu = $this->input->post('edtWaktu');
    $durasi = $this->input->post('edtDurasi');    
    $berakhir = date('H:i:s', strtotime($waktu) + ($durasi * 60) );           
    
    $listRuang = $this->ujian_model->getAvailableRoom($tgl, $waktu, $durasi, $berakhir, $this->session->userdata('prodi_ujian'));
    //echo $listRuang;
    echo "<select name='edtRuang'>";
    echo "<option value=''> - </option>";
    foreach($listRuang->result() as $row){
        echo "<option value='".$row->ruangId."'>".$row->ruangNama."</option>";            
    }
    
    echo "</select>";          
                                                                         
  }
  
  function showRuang2(){
    $tgl = $this->input->post('edtTgl');
    $waktu = $this->input->post('edtWaktu');
    $durasi = $this->input->post('edtDurasi');    
    $berakhir = date('H:i:s', strtotime($waktu) + ($durasi * 60) );           
    
    $listRuang = $this->ujian_model->getAvailableRoom($tgl, $waktu, $durasi, $berakhir, $this->session->userdata('prodi_ujian'));
    //echo $listRuang;
    echo "<select name='edtRuang2'>";
    echo "<option value=''> - </option>";
    foreach($listRuang->result() as $row){
        echo "<option value='".$row->ruangId."'>".$row->ruangNama."</option>";            
    }
    
    echo "</select>";  
                                                                         
  }
  
  function showRuang3(){
    $tgl = $this->input->post('edtTgl');
    $waktu = $this->input->post('edtWaktu');
    $durasi = $this->input->post('edtDurasi');    
    $berakhir = date('H:i:s', strtotime($waktu) + ($durasi * 60) );           
    
    $listRuang = $this->ujian_model->getAvailableRoom($tgl, $waktu, $durasi, $berakhir, $this->session->userdata('prodi_ujian'));
    //echo $listRuang;
    echo "<select name='edtRuang3'>";
    echo "<option value=''> - </option>";
    foreach($listRuang->result() as $row){
        echo "<option value='".$row->ruangId."'>".$row->ruangNama."</option>";            
    }
    
    echo "</select>";  
                                                                         
  }
   
  function cekKelas(){
    $id = $this->input->post('edtID');
    $tgl = $this->input->post('edtTgl');
    $waktu = $this->input->post('edtWaktu');
    $durasi = $this->input->post('edtDurasi');
    $berakhir = date('H:i:s', strtotime($waktu) + ($durasi * 60) );  
    // cari kelas dan semester sesuai id jadwal
    $detail = $this->ujian_model->getKelas($id);
    
    foreach($detail->result() as $row){
        $kelas = $row->kls;
        $semester = $row->smt;
        $prodi = $row->prodi;
    }
    
    $cek = $this->ujian_model->cekKelas($kelas, $semester, $prodi, $tgl, $waktu, $durasi, $berakhir, $id);
    if($cek->num_rows() > 0)
      echo "1"; // tumbukan
    else
      echo "0"; 
        
  }
  
  function save(){ 
    $id = $this->input->post('edtID');
    $jenis = $this->input->post('cbJenis');
    $tgl = $this->input->post('edtTgl');
    $waktu = $this->input->post('edtWaktu');
    $durasi = $this->input->post('edtDurasi');
    $ruang = $this->input->post('edtRuang');
    $ruang2 = $this->input->post('edtRuang2');
    $ruang3 = $this->input->post('edtRuang3');
    $hari = "";
    
    $day = date('N',strtotime($tgl));
    switch($day){
      case 1 : $hari = "Senin"; break;
      case 2 : $hari = "Selasa"; break;
      case 3 : $hari = "Rabu"; break;
      case 4 : $hari = "Kamis"; break;
      case 5 : $hari = "Jumat"; break;
      case 6 : $hari = "Sabtu"; break;
      case 7 : $hari = "Minggu"; break;
    
    }
    // ruangan diupdate jadi 3 buah yaa.
    $this->ujian_model->updateUjian($id, $jenis, $tgl, $hari, $waktu, $durasi, $ruang, $ruang2, $ruang3); 
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

