<?php
class Ruang_model extends Model
	{
		function Sia_model()
		{
			parent::Model();
		}
		
		function getPeriode(){
		   $res = $this->db->query("SELECT DISTINCT MAX(setkrsupy.TASMSSETKRS) AS LASTKRS FROM setkrsupy");
       //echo $this->db->last_query();
       foreach($res->result() as $row){
          return $row->LASTKRS;   
       }

    }
    
    
    function getRoomProdi($prodi, $kapasitas, $namaruang, $offset, $limit){
        $res = $this->db->query("SELECT DISTINCT ruangId, ruangNama, ruangUnit, ruangKapasitas, rpPrioritas
        FROM
            (SELECT ruangId, ruangNama, ruangUnit, ruangKapasitas, rpPrioritas FROM ruang_prodi
            LEFT JOIN ruang_kuliah ON ruangId = rpRuangId
            WHERE rpIdProdi = ".$this->db->escape($prodi)."            
            AND rpPrioritas = 1
            AND ruangKapasitas >= ".$this->db->escape($kapasitas)."            
            AND ruangNama LIKE '%".$this->db->escape_like_str($namaruang)."%'
            
            UNION
            
            SELECT ruangId, ruangNama, ruangUnit, ruangKapasitas, rpPrioritas FROM ruang_prodi
            LEFT JOIN ruang_kuliah ON ruangId = rpRuangId
            WHERE rpIdProdi = ".$this->db->escape($prodi)."  
            AND rpPrioritas = 2
            AND ruangKapasitas >= ".$this->db->escape($kapasitas)."                         
            AND ruangNama LIKE '%".$this->db->escape_like_str($namaruang)."%'
            
            UNION
            
            SELECT ruangId, ruangNama, ruangUnit, ruangKapasitas, '3' FROM ruang_kuliah
            WHERE ruangKapasitas >= ".$this->db->escape($kapasitas)."
            AND ruangId NOT IN(SELECT rpRuangId FROM ruang_prodi WHERE rpIdProdi =".$this->db->escape($prodi).")
            AND ruangNama LIKE '%".$this->db->escape_like_str($namaruang)."%')  
            AS DATA_RUANG          
            
            
            LIMIT $offset, $limit");
         //echo $this->db->last_query();   
         return $res;
    }            
       
    
    function getCountRoom($kapasitas, $namaruang){
        if($namaruang == ""){
            $res = $this->db->query("SELECT ruangId FROM ruang_kuliah WHERE ruangKapasitas >= ".$this->db->escape($kapasitas));
        }else{
            $res = $this->db->query("SELECT ruangId FROM ruang_kuliah WHERE ruangKapasitas >= ".$this->db->escape($kapasitas).
              " AND ruangNama LIKE '%".$this->db->escape_like_str($namaruang)."%'");    
        }    
        
        return $res->num_rows();    
    }    
    
    function cekRoom($periode, $hari, $ruang,$jamMulai, $jamBerakhir){
       //echo "Room : $ruang - $hari - $jamMulai <br />";
       $res = $this->db->query("SELECT IDX, SMPAIMKSAJI
            FROM tbmksajiupy
            LEFT JOIN ruang_kuliah ON ruangId = RUANGMKSAJI
            WHERE  THSMSMKSAJI = ".$this->db->escape($periode)."
 	     AND tbmksajiupy.IDX <> ".$this->session->userdata('manual_id')." 
            AND RUANGMKSAJI = ".$this->db->escape($ruang)."
            AND HRPELMKSAJI = ".$this->db->escape($hari)."            
            AND (SMPAIMKSAJI > ".$this->db->escape($jamMulai)." AND MULAIMKSAJI < ".$this->db->escape($jamBerakhir).") 
            LIMIT 1");
     //echo $this->db->last_query()."<br />";
       return $res;    
    
    }
        
    function decrypt($encprodi){
       $res = $this->db->query("SELECT IDPSTMSPST
            FROM mspstupy
            WHERE MD5(CONCAT('blanc',IDPSTMSPST)) = ".$this->db->escape($encprodi));
       //echo $this->db->last_query();       
       foreach($res->result() as $row){
          return $row->IDPSTMSPST;   
       }
    
    }
    
    function getError(){
      return $this->db->_error_message();
    }


    function getPrivRuang($prodi,$kapasitas, $jns){
       if($jns == "T"){
          $ruang = "AND ruangIsLabKomputer = 0 AND ruangIsLabBahasa = 0 AND ruangIsLabMicro = 0 AND ruangIsLabHukum = 0";
       }elseif($jns == "K"){
          $ruang = "AND ruangIsLabKomputer = 1";
       }elseif($jns == "B"){
          $ruang = "AND ruangIsLabBahasa = 1";
       }elseif($jns == "M"){
          $ruang = "AND ruangIsLabMicro = 1";
       }else{
          $ruang = "AND ruangIsLabHukum = 1";
       }
       $res = $this->db->query("SELECT * FROM ruang_prodi
            LEFT JOIN ruang_kuliah ON ruangId = rpRuangId
            WHERE rpIdProdi = ".$this->db->escape($prodi)." 
            $ruang 
            AND rpPrioritas = 1
            AND ruangKapasitas >= ".$this->db->escape($kapasitas)."
            ORDER BY ruangKapasitas
            ");
       //echo $this->db->last_query();
       return $res;
    
    }
    
    function getRuangTetangga($prodi,$kapasitas, $jns){
       if($jns == "T"){
          $ruang = "AND ruangIsLabKomputer = 0 AND ruangIsLabBahasa = 0 AND ruangIsLabMicro = 0 AND ruangIsLabHukum = 0";
       }elseif($jns == "K"){
          $ruang = "AND ruangIsLabKomputer = 1 AND ruangShared ='1'";
       }elseif($jns == "B"){
          $ruang = "AND ruangIsLabBahasa = 1";
       }elseif($jns == "M"){
          $ruang = "AND ruangIsLabMicro = 1";
       }else{
          $ruang = "AND ruangIsLabHukum = 1";
       }
       $res = $this->db->query("SELECT * FROM ruang_prodi
            LEFT JOIN ruang_kuliah ON ruangId = rpRuangId
            WHERE rpIdProdi = ".$this->db->escape($prodi)." 
            $ruang 
            AND rpPrioritas = 2
            AND ruangKapasitas >= ".$this->db->escape($kapasitas)."
            ORDER BY ruangKapasitas");
       //echo $this->db->last_query();
       return $res;
    
    }
    
    function getRuangKampus($prodi,$kapasitas, $jns){
       if($jns == "T"){
          $ruang = "AND ruangIsLabKomputer = 0 AND ruangIsLabBahasa = 0 AND ruangIsLabMicro = 0 AND ruangIsLabHukum = 0";
       }elseif($jns == "K"){
          $ruang = "AND ruangIsLabKomputer = 1 AND ruangShared = 1";
       }elseif($jns == "B"){
          $ruang = "AND ruangIsLabBahasa = 1";
       }elseif($jns == "M"){
          $ruang = "AND ruangIsLabMicro = 1";
       }else{
          $ruang = "AND ruangIsLabHukum = 1";
       }
       $res = $this->db->query("SELECT * FROM ruang_kuliah 
            WHERE ruangKapasitas >= ".$this->db->escape($kapasitas)."
            $ruang 
            AND ruangId NOT IN(SELECT rpRuangId FROM ruang_prodi WHERE rpIdProdi =".$this->db->escape($prodi).")
            ORDER BY ruangKapasitas");
       //echo $this->db->last_query()."<br />";
       return $res;
    
    }
    
    
    function getCountAll(){
        $res = $this->db->query("SELECT ruangId FROM ruang_kuliah");    
        return $res->num_rows();
    
    }
    
     
    function getAllRoom($offset, $limit){
        $res = $this->db->query("SELECT ruangId, ruangNama, ruangUnit, ruangKapasitas FROM ruang_kuliah LIMIT $offset, $limit");    
        //echo $this->db->last_query()."<br />";
        return $res;
    
    }
    /*
    function cekKelasx($periode, $prodi, $kelas, $semester, $hari, $jamMulai, $jamBerakhir){
       $res = $this->db->query("SELECT KDPSTMKSAJI,KDKMKMKSAJI,KELASMKSAJI
            FROM tbmksajiupy
            LEFT JOIN ruang_kuliah ON ruangId = RUANGMKSAJI
            WHERE  THSMSMKSAJI = ".$this->db->escape($periode)."
            AND KDPSTMKSAJI = ".$this->db->escape($prodi)."
            AND KELASMKSAJI = ".$this->db->escape($kelas)."
            AND SEMESMKSAJI = ".$this->db->escape($semester)."
            AND HRPELMKSAJI = ".$this->db->escape($hari)."            
            AND (SMPAIMKSAJI > ".$this->db->escape($jamMulai)." AND MULAIMKSAJI < ".$this->db->escape($jamBerakhir).") 
            LIMIT 1");
       //echo $this->db->last_query()."<br />";
       return $res;    
    
    } 
    */
    
    
    
	}
