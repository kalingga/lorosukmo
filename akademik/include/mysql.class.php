<?php
   class MySQL{
      var $qry='';
	  var $exe;
      var $conn;
          
	  function MySQL($conn='',$no=0){
	  	 $this->conn[$no]=$conn;
	  }
	  	  
	  function Connect($host,$user,$pass,$no=0){
	     $this->conn[$no]=@mysql_connect($host,$user,$pass);
		 return ($this->conn[$no]); 
	  }
	   	 
	  function Database($name,$no=0){
		 $this->qry='USE '.$name;
	     $this->Execute($no);
		 return ($this->exe); 
	  }
	    	  
      function Select($sel="*",$tbl,$txt="",$ord="",$lmt="",$no=0){
         if ($ord!="") $ord="ORDER BY ".$ord;
         if ($lmt!="") $lmt="LIMIT ".$lmt;
         $this->qry="SELECT ".$sel." FROM ".$tbl." ".$txt." ".$ord." ".$lmt;
         $this->Execute($no);
      }

      function Insert($tbl,$sel="",$vls,$txt="",$lmt="",$no=0){
         if ($sel!="") $sel="(".$sel.")";
         if ($lmt!="") $lmt="LIMIT ".$lmt;
         $this->qry="INSERT INTO ".$tbl." ".$sel." VALUES(".$vls.") ".$txt." ".$lmt;
         $this->Execute($no);
      }
	  				
      function Update($tbl,$set,$txt="",$lmt="",$no=0){
         if ($lmt!="") $lmt="LIMIT ".$lmt;
         $this->qry="UPDATE ".$tbl." SET ".$set." ".$txt." ".$lmt;
         $this->Execute($no);
      }

      function Delete($tbl,$txt="",$lmt="",$no=0){
         if ($lmt!="") $lmt="LIMIT ".$lmt;
         $this->qry="DELETE FROM ".$tbl." ".$txt." ".$lmt;
         $this->Execute($no);
      }
	  
      function Drop($obj,$name,$no=0){
	     $this->qry="DROP ".$obj." ".$name."";
		 $this->Execute($no);
	  }  
      
	  function Execute($no=0){
         $this->exe=@mysql_query($this->qry,$this->conn[$no]);		          		  
      }
	  
	  function Fetch_Array(){
         return @mysql_fetch_array($this->exe,MYSQL_BOTH);		          		  
      }
	  
      function Num_Rows(){
		 return @mysql_num_rows($this->exe);		          		  
      }
	  
	  function Row_Result($no=0){
		 return @mysql_affected_rows($this->conn[$no]);		          		  
      }	 
	  	  		
      function Show_Error($no=0){
	     if (mysql_errno($this->conn[$no])!=0)
            return "#".mysql_errno($this->conn[$no])." ".mysql_error($this->conn[$no]);
		 else
		    return "No Error Found";
      }  
   }	
?>