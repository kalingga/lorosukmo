<?php
	function sqlstr($val){
  		return str_replace("'", "''", $val);
	}
	
	function FormatDateTime($datetime,$format){
		if ($format==1){
			// Jum'at, 30 - April - 2008
			$day=DayToIndo(date("w"),$datetime); 
			$date=date("j",$datetime); 
			$month=MonthToIndo(date("n",$datetime)); 
			$year=date("Y",$datetime); 
			$datetime=$day.", ".$date." - ".$month." - ".$year; 
			return $datetime;
			//M j G:i:s T Y");               // Sat Mar 10 15:16:08 MST 2001			
		}
		if ($format==2){
			// Jum'at, 30 - April - 2008
			$date=date("j",$datetime); 
			$month=MonthToIndo(date("n",$datetime)); 
			$year=date("Y",$datetime); 
			$datetime=$date."  ".$month."  ".$year; 
			return $datetime;
			//M j G:i:s T Y");               // Sat Mar 10 15:16:08 MST 2001			
		}
	}
	
	function DateStr($date){
	  	if (($date=="00-00-0000") || ($date=="") || is_null($date) || ($date=="0000-00-00")){
			$tgl="";
		} else {
			$tgl_arr=@explode("-",$date);
	  		$tgl=$tgl_arr[2]."-".$tgl_arr[1]."-".$tgl_arr[0];
		}
		return $tgl;
	}
	
	function DayToIndo($day){
		if ($day==0) return "Minggu";
		if ($day==1) return "Senin";
		if ($day==2) return "Selasa";
		if ($day==3) return "Rabu";
		if ($day==4) return "Kamis";
		if ($day==5) return "Jum'at";
		if ($day==6) return "Sabtu";
	}
	
	function MonthToIndo($month){
		if ($month==1) return "Januari";
		if ($month==2) return "Februari";
		if ($month==3) return "Maret";
		if ($month==4) return "April";
		if ($month==5) return "Mei";
		if ($month==6) return "Juni";
		if ($month==7) return "Juli";
		if ($month==8) return "Agustus";
		if ($month==9) return "September";
		if ($month==10) return "Oktober";
		if ($month==11) return "November";
		if ($month==12) return "Desember";
	}
	
    function ProcLogin($user,$pass){
    	global $MySQL,$PREFIX;
		$err=0;
		$user=mysql_real_escape_string($user);
		$pass=md5(mysql_real_escape_string($pass));
		$MySQL->Select("*","tbuser","where USERNAME='".$user."' and PASSWORD='".$pass."' ","","1",0);
		//echo $MySQL->qry;
		$show=$MySQL->Fetch_Array();
		$act_log="Login User='".$user."' Pada Tabel 'tbuser' File 'function.php' ";
		if ($MySQL->Num_Rows()==0) $err=1; //user tidak ditemukan
		else {
			/* hapus hak akses dari group umum ******/
			/***** Set session dari user login *****/
			unset($_SESSION[$PREFIX.'hak_akses_admin']);
			unset($_SESSION[$PREFIX.'sm_akses_admin']);

			$_SESSION[$PREFIX.'id_admin']=$show['USERID'];
			$_SESSION[$PREFIX.'user_admin']=$user;
			$_SESSION[$PREFIX.'nama_admin']=$show['NAMAUSER'];
			$_SESSION[$PREFIX.'id_group']=$show['GROUPUSER'];
			/***** Cari Hak Akses dari user login *****/			
			$MySQL->Select("*","groupop","where IDGROUPOP=".$show['GROUPUSER'],"","1",0);
			$show=$MySQL->Fetch_Array();
			$_SESSION[$PREFIX.'nama_group']=$show['NMGROUPOP'];
			$_SESSION[$PREFIX.'hak_akses_admin']=$show['HKGROUPOP'];
			$_SESSION[$PREFIX.'sm_akses_admin']=$show['SMGROUPOP'];
			$act_log="Login User='".$user."' Pada Tabel 'groupop' File 'function.php'";
			$id=$_SESSION[$PREFIX.'id_admin'];
			$group=$_SESSION[$PREFIX.'id_group'];
			
			if ($group=="2") {
				$MySQL->Select("KDPSTMSMHS","msmhsupy","where NIMHSMSMHS='".$user."'","","1");
				$show=$MySQL->fetch_array();
				$_SESSION['pst_admin'] = $show['KDPSTMSMHS'];
//echo "$PREFIX ".$show['KDPSTMSMHS']." - ".$_SESSION['pst_admin'];
			}
		}
		if ($err>0) $act_log=$act_log." Gagal!"; else $act_log=$act_log." Sukses!";
		if (empty($id)) $id=-1;
		AddLog($id,$act_log);
//echo $PREFIX." xxxxxxxxxx ".$_SESSION['upy.ac.idakademikuser_admin']; 
		return $err;
   }
   
   function ProcLogout(){
    	global $MySQL,$PREFIX;
		unset($_SESSION[$PREFIX.'id_admin']);
		unset($_SESSION[$PREFIX.'user_admin']);
		unset($_SESSION[$PREFIX.'nama_admin']);
		unset($_SESSION[$PREFIX.'id_group']);
//		unset($_SESSION[$PREFIX.'id_unit_kerja']);
		unset($_SESSION[$PREFIX.'hak_akses_admin']);
		unset($_SESSION[$PREFIX.'sm_akses_admin']);
		unset($_SESSION[$PREFIX.'pst_admin']);
		unset($_SESSION[$PREFIX.'ThnAjaran']);
		unset($_SESSION[$PREFIX.'cbSemester']);
		unset($_SESSION[$PREFIX.'cbProdi']);
		unset($_SESSION[$PREFIX.'gelombang']);
		$act_log="lOGOUT ID='".$_SESSION[$PREFIX.'id_admin']."' Pada Tabel 'tbuser' File 'function.php'";
		AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
		session_destroy();
   }
     
   function AddLog($id,$act){
    	global $MySQL,$PREFIX,$datetimeServer;
			$MySQL->Insert("tb_log","","\"\",$id,\"$act\",\"$datetimeServer\"");
		//echo $MySQL->qry;
   }
   
   function RandomKey($length=15,$type=1){
	  $key="";
	  if ($type==1){
	     $pattern = "1234567890";
		 $len=9;
      }
	  else if ($type==2){
	     $pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	     $len=24;
      }
	  else{ 
	     $pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	     $len=34;
	  }
   	  for($i=0;$i<$length;$i++){
        $key .= $pattern{rand(0,$len)};
      }
      return $key;
   }
  
  	function GetLevelUser($id_admin) {
		global $MySQL;
		$MySQL->Select("tbuser.LEVELUSER","tbuser","WHERE tbuser.USERID='".$id_admin."'","","1");
		$show=$MySQL->Fetch_Array();
		return $show["LEVELUSER"];
	}

  	function GetAksesUser($id_admin) {
		global $MySQL;
		$MySQL->Select("tbuser.PRIVEUSER","tbuser","WHERE tbuser.USERID='".$id_admin."'","","1");
		$show=$MySQL->Fetch_Array();
		return $show["PRIVEUSER"];
	}

   	function SendMail($to, $from, $subj, $msg, $type="1", $cc="", $bcc=""){
		$headers="";
   		if ($type=="1"){ //HTML
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
		}
		$headers .= 'To: '.$to."\r\n";
		$headers .= 'From: '.$from."\r\n";
		if ($cc!="") $headers .= 'Cc: '.$cc."\r\n";
		if ($bcc!="") $headers .= 'Bcc: '.$bcc."\r\n";
		if (@mail($to, $subj, $msg, $headers))
			return true;
		else
			return false;
   	}
	
	function CheckVisitor(){
		global $MySQL,$PREFIX;
		$datetime=date("Y-n-j H:i:s");
		if (!isset($_SESSION[$PREFIX.'idVisitor'])){
			$ipvisitor=$_SERVER['REMOTE_ADDR'];
			$reffvisitor=$_SERVER['HTTP_REFERER'];
			$MySQL->Insert("visitor","","'','$ipvisitor','$reffvisitor','$datetime'");
			$MySQL->Select("id_visitor","visitor","","id_visitor desc");
			$show=$MySQL->Fetch_Array();
			$_SESSION[$PREFIX.'idVisitor']=$show['id_visitor'];
		}	
		else{
			$MySQL->Update("visitor","datetime_visit=NOW()","where id_visitor=".$_SESSION[$PREFIX.'idVisitor']);
		}
		
		if (isset($_SESSION[$PREFIX.'user_member'])) {
			$MySQL->Update("member","last_access_member=NOW()","where user_member='".$_SESSION[$PREFIX.'user_member']."'");
		}
		
		$MySQL->Select("*","member","where status_member='active' or status_member='pending'");
		$_SESSION[$PREFIX.'countMember']=$MySQL->Num_Rows();
		$MySQL->Select("*","visitor");
		$_SESSION[$PREFIX.'countVisitor']=$MySQL->Num_Rows();
		$anti="group by ip_visitor";	
		$MySQL->Select("*","visitor","where datetime_visit>NOW()- INTERVAL 2 MINUTE ".$anti);
		$_SESSION[$PREFIX.'countOnline']=$MySQL->Num_Rows();
		$MySQL->Select("*","member","where last_access_member>NOW()- INTERVAL 2 MINUTE ");
		$_SESSION[$PREFIX.'countMemberOnline']=$MySQL->Num_Rows();
		if (empty($_SESSION[$PREFIX.'countMemberOnline'])) $_SESSION[$PREFIX.'countMemberOnline']=0;
		$_SESSION[$PREFIX.'countGuestOnline']=$_SESSION[$PREFIX.'countOnline']-$_SESSION[$PREFIX.'countMemberOnline'];	
		
		if (!isset($_SESSION[$PREFIX.'aff_id'])){
			$id=$_GET['id'];
			$aff="no";
			if (!empty($id)){
				$MySQL->Select("*","member","WHERE id_member=$id","","1");
				if ($MySQL->Num_Rows()==1){
					$show=$MySQL->Fetch_Array();
					$_SESSION[$PREFIX.'aff_id']=$show['id_member'];
					$_SESSION[$PREFIX.'aff_name']=$show['name_member'];
					$_SESSION[$PREFIX.'aff_city']=$show['city_member'];
					$aff="ok";
				}
			}
			
			if ($aff=='no'){
				$MySQL->Select("*","member","","RAND()","1");
				$show=$MySQL->Fetch_Array();
				if (!empty($show['id_member'])){
					$_SESSION[$PREFIX.'aff_id']=$show['id_member'];
					$_SESSION[$PREFIX.'aff_name']=$show['name_member'];
					$_SESSION[$PREFIX.'aff_city']=$show['city_member'];
				}
				else{
					$_SESSION[$PREFIX.'aff_id']="1";
					$_SESSION[$PREFIX.'aff_name']="Hafid Mukhlasin";
					$_SESSION[$PREFIX.'aff_city']="Sleman";
				}
			}
		}	
	}
	
	function SetMoney($money,$id){
		$len = strlen($money); 
		
		if ($id==1){ //rupiah
			$msep=".";  //separator
			$mcap="Rp "; // mata uang
			$mback=",-";
		}
		else{ //dolar
			$msep=",";  //separator
			$mcap="US$ "; // mata uang
		}
		
		if ($len >9){
			return ($mcap).substr($money,0,$len-9).($msep).substr($money,-9,3).($msep).substr($money,-6,3).$msep.substr($money,-3,3).$mback;
		}
		else if ($len >6){
			return ($mcap).substr($money,0,$len-6).($msep).substr($money,-6,3).$msep.substr($money,-3,3).$mback;
		}
		else if (strlen($money)>3){
			return ($mcap).substr($money,0,$len-3).($msep).substr($money,-3,3).$mback;
		}
		else
			return ($mcap).$money.$mback;
	}

	function LoadPT_X($nama="",$val="") {
		global $MySQL;
		if ($nama != "") {
			$MySQL->Select("KDPTITBPTI,NMPTITBPTI","tbpti","","KDPTITBPTI ASC","","0");
    		$pti_x = print("<select name='$nama' id='$nama'>");
			$sel0="";
	    	if ($val=="") $sel0="selected='selected'";
        	$pti_x .= print("<option value='-1' $sel0 >--- Perguruan Tinggi ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
				$sel="";
	    		if ($show["KDPTITBPTI"]==$val) $sel="selected='selected'";        		
            	$pti_x .= print("<option value='".$show["KDPTITBPTI"]."' $sel >".$show["NMPTITBPTI"]."</option>");
	    	}
        	$pti_x .= print("</select>");
    	} else {
    		$MySQL->Select("NMPTITBPTI","tbpti","where KDPTITBPTI='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$pti_x = $show["NMPTITBPTI"];
		}
		return $pti_x;
	}


	function LoadFakultas_X($nama="",$val="") {
		global $MySQL;
    	if ($nama != "") {
			$MySQL->Select("KDFAKMSFAK,NMFAKMSFAK","msfakupy","","KDFAKMSFAK ASC","","0");
    		$fakultas_x = print("<select name='$nama' id='$nama'>");
        	$sel0="";
			if ($val=="") $sel0="selected='selected'";
			$fakultas_x .= print("<option value='0' $sel0 >--- Fakultas ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
        		$sel="";
				if ($show["KDFAKMSFAK"]==$val) $sel="selected='selected'";        		
            	$fakultas_x .= print("<option value='".$show["KDFAKMSFAK"]."' $sel>".$show["NMFAKMSFAK"]."</option>");
	    	}
        	$fakultas_x .= print("</select>");
    	} else {
    		$MySQL->Select("NMFAKMSFAK","msfakupy","WHERE KDFAKMSFAK='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$fakultas_x = $show["NMFAKMSFAK"];
		}
		return $fakultas_x;
	}
	
	function LoadProdi_X($nama="",$val="",$fak="",$txt="") {
		global $MySQL;
		if ($nama != "") {
			$qry="where STATUMSPST='A' ";
			if ($fak != ""){
				$qry .="and KDFAKMSPST ='".$fak."'";
			}
			$MySQL->Select("IDPSTMSPST,NMPSTMSPST,NMJENMSPST","mspstupy",$qry,"IDPSTMSPST ASC","","0");
			$sel0="";
	    	if ($val=="") $sel0="selected='selected'";
    		$prodi_x = print("<select name='$nama' id='$nama' $txt >");
        	$prodi_x .= print("<option value='-1' $sel0 >--- Program Studi ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
				$sel="";
	    		if ($show["IDPSTMSPST"]==$val) $sel="selected='selected'";        		
            	$prodi_x .= print("<option value='".$show["IDPSTMSPST"]."' $sel >".$show["NMPSTMSPST"]."  --  ".$show["NMJENMSPST"]."</option>");
	    	}
        	$prodi_x .= print("</select>");
    	} else {
    		$MySQL->Select("NMPSTMSPST,NMJENMSPST","mspstupy","where IDPSTMSPST='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$prodi_x = $show["NMPSTMSPST"]."  --  ".$show["NMJENMSPST"];
		}
		return $prodi_x;
	}
	
	function LoadProdiDikti_X($nama="",$val="") {
		global $MySQL;
		if ($nama != "") {
			$MySQL->Select("KDPSTTBPST,NMPSTTBPST","tbpst","","KDPSTTBPST ASC","","0");
			$sel0="";
	    	if ($val=="") $sel0="selected='selected'";
    		$prodi_x = print("<select name='$nama' id='$nama'>");
        	$prodi_x .= print("<option value='-1' $sel0 >--- Program Studi ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
				$sel="";
	    		if ($show["KDPSTTBPST"]==$val) $sel="selected='selected'";        		
            	$prodi_x .= print("<option value='".$show["KDPSTTBPST"]."' $sel >".$show["KDPSTTBPST"]." - ".$show["NMPSTTBPST"]."</option>");
	    	}
        	$prodi_x .= print("</select>");
    	} else {
    		$MySQL->Select("KDPSTTBPST,NMPSTTBPST","tbpst","where KDPSTTBPST='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$prodi_x = $show["KDPSTTBPST"]." - ".$show["NMPSTTBPST"];
		}
		return $prodi_x;
	}
	
	function GetFakultas($pst="") {
		global $MySQL;
		$qry="where AND IDPSTMSPST = '".$pst."'";
		$MySQL->Select("KDFAKMSPST","mspstupy",$qry,"","1","0");
		$show=$MySQL->Fetch_Array();
		$fak = $show["KDFAKMSFAK"];
		return $fak;
	}			

	function GetProdiInFakultas($fak="") {
		global $MySQL;
		$qry="where STATUMSPST = 'A' AND KDFAKMSPST = '".$fak."'";
		if ($fak=="") $qry="where STATUMSPST = 'A'";
		$MySQL->Select("IDPSTMSPST","mspstupy",$qry,"IDPSTMSPST ASC","","0");
		$pst="(";
		$i=0;
		while ($show=$MySQL->Fetch_Array()) {
			if ($i==0) {
				$pst .= "'".$show["IDPSTMSPST"]."'";
			} else {
				$pst .= ",'".$show["IDPSTMSPST"]."'";
			}
			$i++;
    	}
    	$pst .= ")";
		return $pst;
	}	
	
	function LoadKode_X($nama="",$val="",$kd,$txt="") {
		global $MySQL;
		if ($nama != "") {
			$MySQL->Select("KDKODTBKOD,NMKODTBKOD","tbkodupy","where KDAPLTBKOD='".$kd."'","KDKODTBKOD ASC","","0");
			$kode_X = print("<select name='$nama' id='$name' $txt>");
			$sel0="";
	    	if ($val=="") $sel0="selected='selected'";
	        $kode_X .= print("<option value='-1' $sel0 >--- ".substr($nama,2)." ---</option>");
	        $i=0;
	        while ($show=$MySQL->Fetch_Array()) {
				$sel="";
	    		if ($show["KDKODTBKOD"]==$val) $sel="selected='selected'";
				$kode_X .= print("<option value=".$show["KDKODTBKOD"]." $sel>".$show["NMKODTBKOD"]."</option>");
		    }
	     	$kode_X .= print("</select>");			
		} else {
		    $MySQL->Select("NMKODTBKOD","tbkodupy","WHERE (KDAPLTBKOD ='".$kd."' and KDKODTBKOD = '".$val."')");
		    $show=$MySQL->Fetch_Array();
			$kode_X = $show["NMKODTBKOD"];
		}
		return $kode_X;
	}	

	function LoadJK_X($nama="",$val="") {
		global $MySQL;
		if ($nama == "") {
			$MySQL->Select("NMKODTBKOD","tbkodupy","where KDAPLTBKOD='08' and KDKODTBKOD='".$val."'","","1");
			$show=$MySQL->Fetch_Array();
			$JK_X=$show["NMKODTBKOD"];
		} else {
			$MySQL->Select("KDKODTBKOD,NMKODTBKOD","tbkodupy","WHERE KDAPLTBKOD='08'","","","0");
			while ($show=$MySQL->Fetch_Array()) {
				if ($show["KDKODTBKOD"] == "L") {
					$img="male.gif";
				} else {
					$img="female.gif";
				}
				$chkstr="";			
				if ($val==$show["KDKODTBKOD"]) {
					$chkstr="checked";
				}
				$JK_X = print("<input name='$nama' type='radio' value='$show[KDKODTBKOD]' $chkstr  required = '1' realname='Jenis Kelamin'; />");
				$JK_X .= print("<img src='images/$img' border='0' height='14' width='14' class=\"btn_img\"'>".$show["NMKODTBKOD"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
			}
		}
		return $JK_X;
	}

	function LoadSemester_X($nama="",$val="",$txt="") {
	    if (($nama != "") && ($val=="")){
    		$semester_X = print("<select name='$nama' id='$nama' $txt >");
	        $semester_X .= print("<option value='-1'>--- ".substr($nama,2)." ---</option>");
            $semester_X .= print("<option value='1'>GASAL</option>");
            $semester_X .= print("<option value='2'>GENAP</option>");
	        $semester_X .= print("</select>");
	    }   elseif (($nama != "") && ($val!="")){
	    	$sel1="";
	    	$sel2="";
    		$semester_X = print("<select name='$nama' id='$nama'>");
		    if ($val=='1') $sel1="selected='selected'";
		    if ($val=='2') $sel2="selected='selected'";
			$semester_X .= print("<option value=''>--- Semester ---</option>");
		    $semester_X .= print("<option value='1' $sel1 >GASAL</option>");
		    $semester_X .= print("<option value='2' $sel2 >GENAP</option>");	    	
	        $semester_X .= print("</select>");
		} else {
		    if ($val=='') $str = "";
		    if ($val=='1') $str = "GASAL";
		    if ($val=='2') $str = "GENAP";
		    $semester_X = $str;
		}
		return $semester_X;
	}
	
	function GetSemester($val){
		$semester="(01,03,05,07,09)";
		if ($val=="2"){
			$semester="(02,04,06,08,10)";	
		}
		return $semester;
	}
	
	function LoadPropinsi_X($nama="",$val="",$txt="") {
		global $MySQL;
    	if ($nama != ""){
			$MySQL->Select("*","tbproupy","","KDKABTBPRO ASC");
			$sel0="";
			if ($val=="") $sel0="selected='selected'";
    		$propinsi_x = print("<select name='$nama' id='$nama' $txt>");
        	$propinsi_x .= print("<option value='-1' $sel0 >--- Propinsi ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
        		$sel="";
        		if ($show["KDKABTBPRO"]==$val) $sel="selected='selected'";
            	$propinsi_x .= print("<option value='".$show["KDKABTBPRO"]."' $sel>".$show["NMKABTBPRO"]."</option>");
	    	}
        	$propinsi_x .= print("</select>");
    	} else {
    		$MySQL->Select("NMKABTBPRO","tbproupy","WHERE KDKABTBPRO='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$propinsi_x = $show["NMKABTBPRO"];
		}
		return $propinsi_x;
	}
	
	function LoadMatakuliah_X($nama="",$val="") {
		global $MySQL;
    	if ($nama != ""){
			$MySQL->Select("*","tblmkupy","","KDMKTBLMK ASC");
			$sel0="";
			if ($val=="") $sel0="selected='selected'";
    		$matakuliah_x = print("<select name='$nama' id='$nama'>");
        	$matakuliah_x .= print("<option value='-1' $sel0 >--- Matakuliah ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
        		$sel="";
        		if ($show["KDMKTBLMK"]==$val) $sel="selected='selected'";
            	$matakuliah_x .= print("<option value='".$show["KDMKTBLMK"]."' $sel>".$show["KDMKTBLMK"]. " - ".$show["NAMKTBLMK"]."</option>");
	    	}
        	$matakuliah_x .= print("</select>");
    	} else {
    		$MySQL->Select("NAMKTBLMK","tblmkupy","WHERE KDMKTBLMK='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$matakuliah_x = $show["NAMKTBLMK"];
		}
		return $matakuliah_x;
	}
	
	function LoadMkKurikulum_X($nama,$val) {
		global $MySQL;
		$MySQL->Select("tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK","tbkmkupy","left join tblmkupy on tbkmkupy.KDKMKTBKMK=tblmkupy.KDMKTBLMK where tbkmkupy.IDKURTBKMK='".$val."'","tbkmkupy.KDKMKTBKMK ASC");
		$sel0="";
		if ($val=="") $sel0="selected='selected'";
   		$kmk_x = print("<select name='$nama' id='$nama'>");
       	$kmk .= print("<option value='-1' $sel0 >--- Matakuliah ---</option>");
       	while ($show=$MySQL->Fetch_Array()) {
       		$sel="";
       		if ($show["KDMKTBKMK"]==$val) $sel="selected='selected'";
           	$kmk_x .= print("<option value='".$show["KDKMKTBKMK"]."' $sel>".$show["KDKMKTBKMK"]. " - ".$show["NAMKTBLMK"]."</option>");
    	}
       	$kmk_x .= print("</select>");
		return $matakuliah_x;
	}			
	
	function LoadMKSaji($nama="",$val="",$thn,$pst){
		global $MySQL;
		//$sem = substr($sem,4,1);
		if ($nama != ""){
			$MySQL->Select("DISTINCT tbmksajiupy.IDKMKMKSAJI,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI,tblmkupy.NAMKTBLMK","tbmksajiupy","LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) WHERE tbmksajiupy.THSMSMKSAJI = '".$thn."'  AND tbmksajiupy.KDPSTMKSAJI = '".$pst."'","tbmksajiupy.KDKMKMKSAJI ASC");
			//echo $MySQL->qry;
			$sel0="";
			if ($val=="") $sel0="selected='selected'";
			$matakuliah_x = print("<select name='$nama' id='$nama' required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Matakuliah yang Ada!' >");
	    	$matakuliah_x .= print("<option value='-1' $sel0 >--- Matakuliah ---</option>");
	    	while ($show=$MySQL->Fetch_Array()) {
	    		$sel="";
	        	$matakuliah_x .= print("<option value='".$thn.",".$pst.",".$show["IDKMKMKSAJI"].",".$show["KDKMKMKSAJI"].",".$show["SKSMKMKSAJI"].",".$show["SEMESMKSAJI"]."' $sel>".$show["KDKMKMKSAJI"]. " - ".$show["NAMKTBLMK"]."</option>");
	    	}
	    	$matakuliah_x .= print("</select>");
		} else {
			$MySQL->Select("tblmkupy.NAMKTBLMK","tbmksajiupy","LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) WHERE tbmksajiupy.IDX = '".$val."'","","1");
			$show=$MySQL->fetch_array();
			$matakuliah_x = $show["NAMKTBLMK"];
//echo $pst." dddddddd";
		}
		return $matakuliah_x;
	}
	
	
	function LoadPegawai_X($nama="",$val="") {
		global $MySQL;
    	if ($nama != "") {
			$MySQL->Select("nis,nama_pegawai,gelar_akademik_pegawai","simpeg.tb_pegawai","","nis ASC","","0");
   
   			$sel0="";
   			if ($val=="") $sel0="selected='selected'";
    		$pegawai_x = print("<select name='$nama' id='$nama'>");
        	$pegawai_x .= print("<option value='-1' $sel0 >--- ".substr($nama,2)." ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
        		$sel="";
        		$gelar=@explode("|",$show["gelar_akademik_pegawai"]);
        		$gelar= $gelar[0]." ".$gelar[1];
        		if ($show["nis"]==$val && $show["nis"] != "") $sel="selected='selected'";
            	$pegawai_x .= print("<option value='".$show["nis"]."' $sel >".$show["nis"]." - ".$show["nama_pegawai"].", ".$gelar."</option>");
	    	}
        	$pegawai_x .= print("</select>");
    	} else {
    		if ($val!="" && $val!= "-1") {
	    		$MySQL->Select("nama_pegawai,gelar_akademik_pegawai","simpeg.tb_pegawai","WHERE nis='".$val."'","");
		    	$show=$MySQL->Fetch_Array();
       			$gelar=@explode("|",$show["gelar_akademik_pegawai"]);
       			$gelar= $gelar[0]." ".$gelar[1];
				$pegawai_x = $show["nama_pegawai"].", ".$gelar;
			}
		}
		return $pegawai_x;
	}

	function LoadDosen_X($nama="",$val="",$txt="") {
		global $MySQL;
    	if ($nama != "") {
			$MySQL->Select("nidn,nama_pegawai,gelar_akademik_pegawai","simpeg.tb_pegawai","WHERE (simpeg.tb_pegawai.nidn IS NOT NULL and simpeg.tb_pegawai.nidn <> '')","simpeg.tb_pegawai.nidn ASC","","0");
   
   			$sel0="";
   			if ($val=="") $sel0="selected='selected'";
    		$dosen_x = print("<select name='$nama' id='$nama' $txt >");
        	$dosen_x .= print("<option value='-1' $sel0 >--- ".substr($nama,2)." ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
        		$sel="";
        		$gelar=@explode("|",$show["gelar_akademik_pegawai"]);
        		$gelar= $gelar[0]." ".$gelar[1];
        		if ($show["nidn"]==$val && $show["nidn"] != "") $sel="selected='selected'";
            	$dosen_x .= print("<option value='".$show["nidn"]."' $sel >".$show["nidn"]." - ".$show["nama_pegawai"].", ".$gelar."</option>");
	    	}
        	$dosen_x .= print("</select>");
    	} else {
    		if ($val!="" && $val!= "-1") {
	    		$MySQL->Select("nama_pegawai,gelar_akademik_pegawai","simpeg.tb_pegawai","WHERE nidn='".$val."'","","1");
		    	$show=$MySQL->Fetch_Array();
	       		$gelar=@explode("|",$show["gelar_akademik_pegawai"]);
	       		$gelar= $gelar[0]." ".$gelar[1];
				$dosen_x = $show["nama_pegawai"].", ".$gelar;
			}
		}
		return $dosen_x;
	}

	function LoadNilai_X($nama="",$val="",$idx="",$sks="",$txt="") {
		global $MySQL;
    	if ($nama != "") {
			$MySQL->Select("NLAKHTBBNL,BOBOTTBBNL","tbbnlupy","","BOBOTTBBNL DESC","","0");
   			$sel0="";
   			if ($val=="") $sel0="selected='selected'";
    		$nilai_x = print("<select name='$nama' id='$nama' $txt >");
        	$nilai_x .= print("<option value='-1' $sel0 >--- Nilai ---</option>");
        	while ($show=$MySQL->Fetch_Array()) {
        		$sel="";
        		if ($idx!=""){
					if ($sks != "") {
        				if ($show["NLAKHTBBNL"]==$val) $sel="selected='selected'";
            			$nilai_x .= print("<option value='".$show["NLAKHTBBNL"].",".$show["BOBOTTBBNL"].",".$idx.",".$sks."' $sel >".$show["NLAKHTBBNL"]."</option>");
					} else {
	        			if ($show["NLAKHTBBNL"]==$val) $sel="selected='selected'";
	            		$nilai_x .= print("<option value='".$show["NLAKHTBBNL"].",".$show["BOBOTTBBNL"].",".$idx."' $sel >".$show["NLAKHTBBNL"]."</option>");
	            	}
            	} else {
        			if ($show["NLAKHTBBNL"]==$val) $sel="selected='selected'";
            		$nilai_x .= print("<option value='".$show["NLAKHTBBNL"].",".$show["BOBOTTBBNL"]."' $sel >".$show["NLAKHTBBNL"]."</option>");
 				}
	    	}
        	$nilai_x .= print("</select>");
    	} else {
    		$MySQL->Select("BOBOTTBBNL","tbbnlupy","WHERE NLAKHTBBNL='".$val."'","","1");
	    	$show=$MySQL->Fetch_Array();
			$nilai_x = $show["BOBOTTBBNL"];
		}
		return $nilai_x;
	}

	function GetMhsDetail_X($nim) {
		global $MySQL;
		$MySQL->Select("KDPSTMSMHS,NMMHSMSMHS,DSNPAMSMHS","msmhsupy","where NIMHSMSMHS='".$nim."'","","1");
       	$show=$MySQL->Fetch_Array();
 	    $mahasiswa_x=$show['NMMHSMSMHS'].",".$show['KDPSTMSMHS'].",".substr($show['KDPSTMSMHS'],0,1).",".$show["DSNPAMSMHS"];
		return $mahasiswa_x;
	}
	
	function GetMhsBaruDetail_X($id) {
		global $MySQL;
		$MySQL->Select("msmhsupy.NMMHSMSMHS,msmhsupy.NIMHSMSMHS,msmhsupy.TPLHRMSMHS,msmhsupy.TGLHRMSMHS,mspstupy.KDFAKMSPST,msmhsupy.ASPSTMSMHS,msmhsupy.ASPTIMSMHS,msmhsupy.KDPSTMSMHS,msmhsupy.TAHUNMSMHS,mspstupy.KDJENMSPST,mspstupy.KDSTAMSPST","msmhsupy","LEFT OUTER JOIN mspstupy ON (msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST) WHERE msmhsupy.NIMHSMSMHS ='".$id."'","","1");
	   	$show=$MySQL->Fetch_Array();
	    $mahasiswa_x=$show["NMMHSMSMHS"].",".$show["NIMHSMSMHS"].",".$show["TPLHRMSMHS"].",".$show["TGLHRMSMHS"].",".$show["KDFAKMSPST"].",".$show["ASPSTMSMHS"].",".$show["ASPTIMSMHS"].",".$show["KDPSTMSMHS"].",".$show["TAHUNMSMHS"].",".$show["KDJENMSPST"].",".$show["KDSTAMSPST"];
		return $mahasiswa_x;
	}	
	
	function GetCalonMhsBaru_X($id) {
		global $MySQL;
		$MySQL->Select("NMPMBTBPMB,
    NODTRTBPMB,
    TPLHRTBPMB,
    TGLHRTBPMB,
    KDFAKMSPST,
    JURSNTBPMB,
    SKASLTBPMB,
    DTRMATBPMB,
    THDTRTBPMB,
    mspstupy.KDJENMSPST,
    mspstupy.KDSTAMSPST",
    "tbpmbupy",
    "LEFT OUTER JOIN mspstupy ON (DTRMATBPMB = mspstupy.IDPSTMSPST) 
    WHERE NODTRTBPMB ='".$id."'","","1");
	   	$show=$MySQL->Fetch_Array();
	    $mahasiswa_x=$show["NMPMBTBPMB"].",".$show["NODTRTBPMB"].",".$show["TPLHRTBPMB"].
      ",".$show["TGLHRTBPMB"].",".$show["KDFAKMSPST"].",".$show["JURSNTBPMB"].
      ",".$show["SKASLTBPMB"].",".$show["DTRMATBPMB"].",".substr($show["THDTRTBPMB"],0,4).
      ",".$show["KDJENMSPST"].",".$show["KDSTAMSPST"];
		return $mahasiswa_x;
	}	

	function LoadHari_X($nama="",$val="",$txt="") {
  		$sel="";
  		$sel0="";
  		$sel1="";
  		$sel2="";
  		$sel3="";
  		$sel4="";
  		$sel5="";
  		$sel6="";
   		
		if ($val=="") $sel="selected='selected'";
		if ($val=="Minggu") $sel0="selected='selected'";
		if ($val=="Senin") $sel1="selected='selected'";
		if ($val=="Selasa") $sel2="selected='selected'";
		if ($val=="Rabu") $sel3="selected='selected'";
		if ($val=="Kamis") $sel4="selected='selected'";
		if ($val=="Jumat") $sel5="selected='selected'";
		if ($val=="Sabtu") $sel6="selected='selected'";

    	$hari_x = print("<select name='$nama' id='$nama' $txt >");
        $hari_x .= print("<option value='-1' $sel >--- ".substr($nama,2)." ---</option>");
        $hari_x .= print("<option value='Minggu' $sel0 >Minggu</option>");
        $hari_x .= print("<option value='Senin' $sel1 >Senin</option>");
        $hari_x .= print("<option value='Selasa' $sel2 >Selasa</option>");
        $hari_x .= print("<option value='Rabu' $sel3 >Rabu</option>");
        $hari_x .= print("<option value='Kamis' $sel4 >Kamis</option>");
        $hari_x .= print("<option value='Jum'at' $sel5 >Jum'at</option>");
        $hari_x .= print("<option value='Sabtu' $sel6 >Sabtu</option>");
		$hari_x .= print("</select>");
		return $hari_x;
	}
	
	function UpdateData($id_group) {
		switch ($id_group) {
			case '0' : return True;
					 break;
			case '1' : return True;
					 break;
			case '4' : return True;
					 break;
			default : return False;
		}
		
	}

	function PrintTableSeleksi($report_title,$width_col_table,$align_col_table,$header_table,$data,$show_header="yes",$report_sub_title="",$idpage=""){
		echo "<form action=\"print_table.php\" method=\"post\" target=\"pdf_target\">";
		echo "<input type=\"hidden\" name=\"report_sub_title\" value=\"".$report_sub_title."\" />";
		echo "<input type=\"hidden\" name=\"width_col_table\" value=\"".$width_col_table."\" />";
		echo "<input type=\"hidden\" name=\"align_col_table\" value=\"".$align_col_table."\" />";
		echo "<input type=\"hidden\" name=\"header_table\" value=\"".$header_table."\" />";
		echo "<input type=\"hidden\" name=\"data\" value=\"".$data."\" />";
		echo "<input type=\"hidden\" name=\"show_header\" value=\"".$show_header."\" />";
		echo "<input type=\"hidden\" name=\"idpage\" value=\"".$idpage."\" />";		
		echo "<input type=\"hidden\" name=\"$report_sub_title\" value=\"".$report_sub_title."\" />";
		echo "<table cellpadding=\"3\" cellspacing=\"3\">";
		echo "<tr>";
		echo "	<td>Judul Report</td>";
		echo "	<td> : </td>";
		echo "	<td>";
		echo "	<input type=\"text\" size=\"50\" name=\"report_title\" value=\"".$report_title."\" />";
		echo "	</td>";
		echo "</tr>";
		echo "<tr>";
		echo "	<td>Jarak TTD</td>";
		echo "	<td>:</td>";
		echo "	<td><input type=\"text\" name=\"space_ttd\" value=\"0\" size=\"5\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "	<td colspan=\"3\">";
		echo "	<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />";
		echo "	</td>";
		echo "</tr>";
		echo "</table>";		
		echo "</form>";
		echo "<iframe style='display:none' name='1pdf_target'></iframe>";
	}

	function FormPrintTable($report_title,$width_col_table,$align_col_table,$header_table,$field_name,$qry,$show_header="yes",$report_sub_title=""){
		echo "<form action=\"print_table.php\" method=\"post\" target=\"pdf_target\">";
		echo "<input type=\"hidden\" name=\"report_sub_title\" value=\"".$report_sub_title."\" />";
		echo "<input type=\"hidden\" name=\"width_col_table\" value=\"".$width_col_table."\" />";
		echo "<input type=\"hidden\" name=\"align_col_table\" value=\"".$align_col_table."\" />";
		echo "<input type=\"hidden\" name=\"header_table\" value=\"".$header_table."\" />";
		echo "<input type=\"hidden\" name=\"field_name\" value=\"".$field_name."\" />";
		echo "<input type=\"hidden\" name=\"qry_table\" value=\"".$qry."\" />";
		echo "<input type=\"hidden\" name=\"show_header\" value=\"".$show_header."\" />";
		echo "<input type=\"hidden\" name=\"$report_sub_title\" value=\"".$report_sub_title."\" />";

		echo "<table cellpadding=\"3\" cellspacing=\"3\">";
		echo "<tr>";
		echo "	<td>Judul Report</td>";
		echo "	<td> : </td>";
		echo "	<td>";
		echo "	<input type=\"text\" size=\"50\" name=\"report_title\" value=\"".$report_title."\" />";
		echo "	</td>";
		echo "</tr>";
		echo "<tr>";
		echo "	<td>Jarak TTD</td>";
		echo "	<td>:</td>";
		echo "	<td><input type=\"text\" name=\"space_ttd\" value=\"0\" size=\"5\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "	<td colspan=\"3\">";
		echo "	<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />";
		echo "	</td>";
		echo "</tr>";
		echo "</table>";		
		echo "</form>";
		echo "<iframe style='display:none' name='1pdf_target'></iframe>";
	}
	
	function Formulir($report_title,$width_col_table,$formulir_item,$table_name,$field_name,$qry,$sub_title){
		echo "<form action=\"Cetak_formulir.php\" method=\"post\" target=\"pdf_target\">";
		echo "<input type=\"hidden\" size=\"50\" name=\"report_title\" value=\"".$report_title."\" />";
		echo "<input type=\"hidden\" name=\"width_col_table\" value=\"".$width_col_table."\" />";
		echo "<input type=\"hidden\" name=\"formulir_item\" value=\"".$formulir_item."\" />";
		echo "<input type=\"hidden\" name=\"table_name\" value=\"".$table_name."\" />";
		echo "<input type=\"hidden\" name=\"field_name\" value=\"".$field_name."\" />";
		echo "<input type=\"hidden\" name=\"qry\" value=\"".$qry."\" />";
		echo "<input type=\"hidden\" name=\"sub_title\" value=\"".$sub_title."\" />";
		echo "<input type=\"hidden\" name=\"space_ttd\" value=\"0\" size=\"5\" />";
		echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />";
		echo "</form>";
		echo "<iframe style='display:none' name='1pdf_target'></iframe>";
	}		
?>