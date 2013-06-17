<?php
class Ujian_model extends Model
	{
		function Ujian_model()
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
    
    function getError(){
      return $this->db->_error_message();
    }
    
    
    function getAvailableRoom($tgl, $waktu, $durasi, $berakhir, $prodi){   //
            
        $used = $this->db->query("SELECT DISTINCT RUANGUTSUAS, RUANG2, RUANG3        
          FROM jwlutsuas
          WHERE TGPELUTSUAS = ".$this->db->escape($tgl)."
          AND DATE_FORMAT(DATE_ADD(CONCAT(TGPELUTSUAS,' ',WKPELUTSUAS) , INTERVAL DURSIUTSUAS MINUTE), '%H:%i:%s') > ".$this->db->escape($waktu)."
          AND WKPELUTSUAS < ".$this->db->escape($berakhir));
       //echo $this->db->last_query();    
        //$i = 1;
        $usedroom = "'x'";
        foreach($used->result() as $row){
          $usedroom .= ",'".$row->RUANGUTSUAS."'";    
          $usedroom .= ",'".$row->RUANG2."'";    
          $usedroom .= ",'".$row->RUANG3."'";        
        }                
       //echo "<br />$usedroom"; 
        
        $res = $this->db->query("
        (SELECT DISTINCT ruangId, ruangNama
        FROM
        ruang_kuliah
        LEFT JOIN ruang_prodi ON ruangId = rpRuangId
        WHERE ruangId NOT IN
        ($usedroom    
         )
         AND rpIdProdi = ".$this->db->escape($prodi)." 
         ORDER BY rpPrioritas
         ) 
  
  
        UNION
        
        (SELECT DISTINCT ruangId, ruangNama
        FROM
        ruang_kuliah
        LEFT JOIN ruang_prodi ON ruangId = rpRuangId
        WHERE ruangId NOT IN
        ($usedroom
        )
        AND rpIdProdi <> ".$this->db->escape($prodi)." 
        LIMIT 5)
        
  
        ");
     //echo "<span style='display:none'>".$this->db->last_query()."</span>";
       return $res;
       //return $this->db->last_query();
    }               
    
       
    function getKelas($id){
        $res = $this->db->query("SELECT KELASMKSAJI AS kls,
            SEMESMKSAJI AS smt,
            KDPSTMKSAJI AS prodi FROM jwlutsuas  
            LEFT JOIN tbmksajiupy ON jwlutsuas.IDXMKSAJI = tbmksajiupy.IDX          
            WHERE jwlutsuas.IDX = ".$this->db->escape($id));
       //echo $this->db->last_query()."<br />";
       return $res;  
    
    }    
    
    function cekKelas($kelas, $semester, $prodi, $tgl, $waktu, $durasi, $berakhir, $id){    
	$q = "";
       
       $arr = explode(",",$kelas);
       foreach($arr as $row){
          $q .= " OR KELASMKSAJI = ".$this->db->escape($row);
       }
          
       $res = $this->db->query("SELECT jwlutsuas.IDX FROM tbmksajiupy  
            LEFT JOIN jwlutsuas ON jwlutsuas.IDXMKSAJI = tbmksajiupy.IDX              
            WHERE (KELASMKSAJI = ".$this->db->escape($kelas)."
	     $q	
	     )	
            AND SEMESMKSAJI = ".$this->db->escape($semester)."
            AND KDPSTMKSAJI = ".$this->db->escape($prodi)."
            AND TGPELUTSUAS = ".$this->db->escape($tgl)."           
            AND DATE_FORMAT(DATE_ADD(CONCAT(TGPELUTSUAS,' ',WKPELUTSUAS) , INTERVAL DURSIUTSUAS MINUTE), '%H:%i:%s') > ".$this->db->escape($waktu)."
          AND WKPELUTSUAS < ".$this->db->escape($berakhir)."
          AND jwlutsuas.IDX <> ".$this->db->escape($id));
       //return $this->db->last_query()."<br />";
       return $res;  
    }
    
    function updateUjian($id, $jenis, $tgl, $hari, $waktu, $durasi, $ruang, $ruang2, $ruang3){

       $this->db->query("UPDATE jwlutsuas
        SET RUANGUTSUAS = ".$this->db->escape($ruang)." ,
        RUANG2 = ".$this->db->escape($ruang2)." ,
        RUANG3 = ".$this->db->escape($ruang3)." ,
          HRPELUTSUAS = ".$this->db->escape($hari)." ,
          TGPELUTSUAS = ".$this->db->escape($tgl)." ,
          WKPELUTSUAS = ".$this->db->escape($waktu)." ,
          DURSIUTSUAS = ".$this->db->escape($durasi)." ,
          JENISUTSUAS = ".$this->db->escape($jenis)." 
        WHERE IDX = ".$this->db->escape($id) ); 
      //echo $this->db->last_query()."<br /><br />";                
    
    }
    
    function updateinfo($id, $kelas, $nodos, $nmdos, $kapasitas){

       $this->db->query("UPDATE tbmksajiupy   
              SET 
              KELASMKSAJI = ".$this->db->escape($kelas).",
              NODOSMKSAJI = ".$this->db->escape($nodos).",
              NMDOSMKSAJI = ".$this->db->escape($nmdos).",
              KAPASITAS = ".$this->db->escape($kapasitas)."
            WHERE IDX = ".$this->db->escape($id)); 
      //echo $this->db->last_query()."<br /><br />";                
    
    }
    
    function getUjian($id){
       $res = $this->db->query("SELECT jwlutsuas.IDX AS ID,KDKMKUTSUAS,KELASUTSUAS, NAMKTBLMK, KDKMKUTSUAS,ruangNama,
            HRPELUTSUAS,TGPELUTSUAS,WKPELUTSUAS,DURSIUTSUAS,NMDOSMKSAJI, JENISUTSUAS
            FROM jwlutsuas
            LEFT JOIN tblmkupy ON KDKMKUTSUAS = KDMKTBLMK
            LEFT JOIN tbmksajiupy ON jwlutsuas.IDXMKSAJI = tbmksajiupy.IDX
            LEFT JOIN ruang_kuliah ON RUANGUTSUAS = ruangId 
            WHERE jwlutsuas.IDX = ".$this->db->escape($id));
       //echo $this->db->last_query()."<br />";
       return $res;  
    
    }
        
   
}
