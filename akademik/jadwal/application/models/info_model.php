<?php
class Info_model extends Model
	{
		function Info_model()
		{
			parent::Model();
		}
		
		function getInfo($id){
		   $res = $this->db->query("SELECT * FROM tbmksajiupy
          LEFT JOIN tblmkupy ON KDMKTBLMK = KDKMKMKSAJI
          LEFT JOIN mspstupy ON IDPSTMSPST = KDPSTMKSAJI
          LEFT JOIN ruang_kuliah ON RUANGMKSAJI = ruangId
          WHERE tbmksajiupy.IDX = ".$this->db->escape($id));
       //echo $this->db->last_query();
      return $res;
    }
    
    
    function getError(){
      return $this->db->_error_message();
    }


	}
