<?php
class Sia_model extends Model
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
    
    // ==================== filler mode =======================
    function getBefore($periode, $prodi = ""){
       $res = $this->db->query("SELECT * FROM tbmksajiupy
          WHERE THSMSMKSAJI = '$periode' 
         
          AND KDPSTMKSAJI = '$prodi'
          AND KELASMKSAJI is not null 
          LIMIT 500"); 
          echo $this->db->last_query();
       return $res;          // -- AND KDPSTMKSAJI <> ''
          //                    -- AND KDPSTMKSAJI <> '11'
    
    }
    
    function sksPraktek($matkul){
       $res = $this->db->query("SELECT SKSPRTBKMK FROM tbkmkupy
        WHERE KDKMKTBKMK = '$matkul'");
       //echo $this->db->last_query();       
       foreach($res->result() as $row){
          return $row->SKSPRTBKMK;   
       }
    
    }
    
    // ===========================================================
    
    function decrypt($encprodi){
       $res = $this->db->query("SELECT IDPSTMSPST
            FROM mspstupy
            WHERE MD5(CONCAT('blanc',IDPSTMSPST)) = ".$this->db->escape($encprodi));
       //echo $this->db->last_query();       
       foreach($res->result() as $row){
          return $row->IDPSTMSPST;   
       }
    
    }
    
    function jadwalRapat($prodi){
        $res = $this->db->query(" SELECT rapatHari, rapatMulai, rapatSelesai
        FROM rapat_prodi
        WHERE rapatidProdi = ".$this->db->escape($prodi));
       //echo $this->db->last_query();       
       return $res;
    
    }
    
    function getError(){
      return $this->db->_error_message();
    }
    
    function getSKS($kodematkul){
       $res = $this->db->query("SELECT
          SKSMKMKSAJI          
          FROM tbmksajiupy
          WHERE KDKMKMKSAJI = ".$this->db->escape($kodematkul)." 
          ORDER BY IDX DESC LIMIT 1");
       //echo $this->db->last_query();      
       foreach($res->result() as $row){
          return $row->SKSMKMKSAJI;   
       }
    
    }
    
    function getListDosen(){		   
		   $res = $this->db->query(" SELECT nidn,nama_pegawai,gelar_akademik_pegawai 
           FROM simpeg.tb_pegawai 
           WHERE (simpeg.tb_pegawai.nidn IS NOT NULL AND simpeg.tb_pegawai.nidn <> '') 
           ORDER BY simpeg.tb_pegawai.nama_pegawai ASC");
       //echo $this->db->last_query();       
       return $res;
          		   
    }
    
    function getStatus($nidn){
       $res = $this->db->query(" SELECT status_jadwal 
           FROM simpeg.tb_pegawai 
           WHERE simpeg.tb_pegawai.nidn =".$this->db->escape($nidn));
       //echo $this->db->last_query();       
       foreach($res->result() as $row){
          return $row->status_jadwal;   
       }
    
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
    
    function cekRuang($prodi, $periode, $hari, $ruang1, $ruang2, $ruang3, $jamMulai, $jamBerakhir, $penanda){
       if($penanda == 0){
          $ruang = $ruang1;
       }elseif($penanda == 1){
          $ruang = $ruang2;  
       }else{
          $ruang = $ruang3;
       } 
       $res = $this->db->query("SELECT * FROM tbmksajiupy
            LEFT JOIN ruang_kuliah ON ruangId = RUANGMKSAJI
            WHERE  THSMSMKSAJI = ".$this->db->escape($periode)."
            AND KDPSTMKSAJI = ".$this->db->escape($prodi)."
            AND RUANGMKSAJI = ".$this->db->escape($ruang)."
            AND HRPELMKSAJI = ".$this->db->escape($hari)."            
            AND (SMPAIMKSAJI > ".$this->db->escape($jamMulai)." AND MULAIMKSAJI < ".$this->db->escape($jamBerakhir).")");
       //echo $this->db->last_query()."<br />";
       return $res;    
    
    }
    
    function cekManualRuang($prodi, $periode, $hari,$ruangId, $jamMulai, $jamBerakhir){
       $res = $this->db->query("SELECT * FROM tbmksajiupy
            LEFT JOIN ruang_kuliah ON ruangId = RUANGMKSAJI
            WHERE  THSMSMKSAJI = ".$this->db->escape($periode)."
            AND KDPSTMKSAJI = ".$this->db->escape($prodi)."
 	     AND tbmksajiupy.IDX <> ".$this->session->userdata('manual_id')." 
            AND RUANGMKSAJI = ".$this->db->escape($ruangId)."
            AND HRPELMKSAJI = ".$this->db->escape($hari)."            
            AND (SMPAIMKSAJI > ".$this->db->escape($jamMulai)." AND MULAIMKSAJI < ".$this->db->escape($jamBerakhir).")");
       //echo $this->db->last_query()."<br />";
       return $res;    
    
    }
    
    function cekDosen($periode, $dosen, $hari, $jamMulai, $jamBerakhir){
       //echo "Dosen : $hari - $jamMulai <br />";
       $res = $this->db->query("SELECT IDX, SMPAIMKSAJI FROM tbmksajiupy            
            WHERE THSMSMKSAJI = ".$this->db->escape($periode)."  
 	     AND tbmksajiupy.IDX <> ".$this->session->userdata('manual_id')." 
            AND NODOSMKSAJI = ".$this->db->escape($dosen)." 
	     AND NODOSMKSAJI NOT IN('0900000001','0000000200') 	            
            AND HRPELMKSAJI = ".$this->db->escape($hari)."            
            AND (SMPAIMKSAJI > ".$this->db->escape($jamMulai)." AND MULAIMKSAJI < ".$this->db->escape($jamBerakhir).")");
       //echo $this->db->last_query()."<br />";
       return $res;  
    }
    
    function cekKelas($periode, $prodi, $kelas, $semester, $hari, $jamMulai, $jamBerakhir){
       $q = "";
       /*
       if($this->session->userdata('gabungkelas1') <> ""){
         $q .= "OR KELASMKSAJI = ".$this->db->escape($this->session->userdata('gabungkelas1'));
       }
       
       if($this->session->userdata('gabungkelas2') <> ""){
         $q .= "OR KELASMKSAJI = ".$this->db->escape($this->session->userdata('gabungkelas2'));
       }
       
       if($this->session->userdata('gabungkelas3') <> ""){
         $q .= "OR KELASMKSAJI = ".$this->db->escape($this->session->userdata('gabungkelas3'));
       }
       */
       $arr = explode(",",$kelas);
       foreach($arr as $row){
          $q .= " OR KELASMKSAJI = ".$this->db->escape($row);
       }
        
       $res = $this->db->query("SELECT IDX, SMPAIMKSAJI FROM tbmksajiupy            
            WHERE THSMSMKSAJI = ".$this->db->escape($periode)." 
            AND KDPSTMKSAJI = ".$this->db->escape($prodi)."
            AND (KELASMKSAJI = ".$this->db->escape($kelas)." 
            $q 
            )
            AND SEMESMKSAJI = ".$this->db->escape($semester)." 
 	     AND tbmksajiupy.IDX <> ".$this->session->userdata('manual_id')." 	           
            AND HRPELMKSAJI = ".$this->db->escape($hari)."            
            AND (SMPAIMKSAJI > ".$this->db->escape($jamMulai)." AND MULAIMKSAJI < ".$this->db->escape($jamBerakhir).")");
       //echo $this->db->last_query()."<br />";
       return $res;  
    }
    
   
    function getListMK($kodeprodi,$periode){   // hanya matakuliah sesuai prodi yang diambil mahasiswa di periode sekarang    		   
	     if($kodeprodi == ""){
          $koma = "";
       }else{
          $koma = ",";
       }
		   $res = $this->db->query("SELECT DISTINCT
          KDKMKMKSAJI AS KODE,
          NAMKTBLMK AS NAMA           
          FROM tbmksajiupy
          LEFT JOIN tblmkupy ON KDMKTBLMK = KDKMKMKSAJI
          WHERE KDPSTMKSAJI = ".$this->db->escape($kodeprodi)." 
          AND THSMSMKSAJI = ".$this->db->escape($periode)."
          ORDER BY NAMA");
       //echo $this->db->last_query();         
		   return $res;    
    }
    
    function getKMK($prodi, $matkul){
       $res = $this->db->query("SELECT *
            FROM tbkmkupy
            WHERE THSMSTBKMK = (SELECT THAWLTBKUR FROM tbkurupy WHERE KDPSTTBKUR = ".$this->db->escape($prodi)." ORDER BY THAWLTBKUR DESC LIMIT 1)                        
            AND KDKMKTBKMK = ".$this->db->escape($matkul));
       //echo $this->db->last_query()."<br />";
       return $res;   
    
    }
    
    function getOnejadwal($id){
       $res = $this->db->query("SELECT *
            FROM tbmksajiupy
            WHERE IDX = ".$this->db->escape($id));
       //echo $this->db->last_query()."<br />";
       return $res;  
    
    }
    
    function insertjadwal($periode, $idkmk, $prodi, $matkul, $sksmk, 
         $semester, $kelas, $nodos, $nmdos, $ruang, $hr, $jamMulai, $jamBerakhir, $kapasitas){
       $this->db->query("INSERT INTO tbmksajiupy
            (THSMSMKSAJI,
             IDKMKMKSAJI,
             KDPSTMKSAJI,
             KDKMKMKSAJI,
             SKSMKMKSAJI,
             SEMESMKSAJI,
             KELASMKSAJI,
             NODOSMKSAJI,
             NMDOSMKSAJI,
             RUANGMKSAJI,
             HRPELMKSAJI,
             MULAIMKSAJI,
             SMPAIMKSAJI,
             KAPASITAS)
        values (".$this->db->escape($periode).",
                ".$this->db->escape($idkmk).",
                ".$this->db->escape($prodi).",
                ".$this->db->escape($matkul).",
                ".$this->db->escape($sksmk).",
                ".$this->db->escape($semester).",
                ".$this->db->escape($kelas).",
                ".$this->db->escape($nodos).",
                ".$this->db->escape($nmdos).",
                ".$this->db->escape($ruang).",
                ".$this->db->escape($hr).",
                ".$this->db->escape($jamMulai).",
                ".$this->db->escape($jamBerakhir).",
                ".$this->db->escape($kapasitas).")"); 
      //echo $this->db->last_query()."<br /><br />";                
    
    }
    
    function updatejadwal($id, $kelas, $nodos, $nmdos, $ruang, $hr, $jamMulai, $jamBerakhir, $kapasitas){

       $this->db->query("UPDATE tbmksajiupy   
              SET 
              KELASMKSAJI = ".$this->db->escape($kelas).",
              NODOSMKSAJI = ".$this->db->escape($nodos).",
              NMDOSMKSAJI = ".$this->db->escape($nmdos).",
              RUANGMKSAJI = ".$this->db->escape($ruang).",
              HRPELMKSAJI = ".$this->db->escape($hr).",
              MULAIMKSAJI = ".$this->db->escape($jamMulai).",
              SMPAIMKSAJI = ".$this->db->escape($jamBerakhir).",
              KAPASITAS = ".$this->db->escape($kapasitas)."
            WHERE IDX = ".$this->db->escape($id)); 
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
       $res = $this->db->query("SELECT jwlutsuas.IDX AS ID,KDKMKUTSUAS,KELASUTSUAS, KDPSTUTSUAS, NAMKTBLMK, KDKMKUTSUAS,ruangNama,
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
