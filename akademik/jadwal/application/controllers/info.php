<?php

class Info extends Controller {
  var $export;
  var $c_limit = 50; // 50 data per halaman
  var $c_offset;

	function info(){
     parent::Controller();
      $this->load->library(array('pagination','session'));
      $this->load->helper('url');
      $this->load->model('info_model');      
      $this->c_offset = $this->uri->segment(4);
      session_start();
      /*if(!isset($_SESSION['upy.ac.idakademikuser_admin']) OR 
      $_SESSION['upy.ac.idakademikuser_admin'] == "")
          redirect('http://upy.ac.id/akademik');
      */          
	}
		
  function index(){ 
    
  }  
  
  function dosen(){     
     $id = $this->uri->segment(3);
     $data['info'] = $this->info_model->getInfo($id);
     $this->load->view('info_dosen_view',$data); 
     //echo "dosen $id";
  }
  
  function ruang(){
     $id = $this->uri->segment(3);
     $data['info'] = $this->info_model->getInfo($id);
     $this->load->view('info_ruang_view',$data); 
  }
  
  function kelas(){
     $id = $this->uri->segment(3);
     $data['info'] = $this->info_model->getInfo($id);
     $this->load->view('info_kelas_view',$data); 
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
