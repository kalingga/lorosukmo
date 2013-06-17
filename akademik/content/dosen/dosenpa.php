<?php
$idpage='16';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
 	 if (!isset($_GET['pos'])) $_GET['pos']=1;
	 $page=$_GET['page'];
     $sel="";

     $field=$_REQUEST['field'];
	 if (!isset($_REQUEST['limit'])){
	    $_REQUEST['limit']="20";
	 }
	 if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];	 
	 $URLa="page=".$page;		
	 echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
	 echo "<form action='./?page=dosenpa' method='post' >";
	/*********** From Pencarian ************/
	 echo "<tr><td colspan='3'>";
	 echo "Pencarian Berdasarkan : <select name='field'>";
     if ($field=='KDPSTTBPST') $sel1="selected='selected'";
     if ($field=='NMPSTTBPST') $sel2="selected='selected'";

     echo "<option value='THSMSDSNPA' $sel1 >TAHUN AKADEMIK</option>";
     echo "<option value='NMPSTMSPST' $sel2 >PROGRAM STUDI</option>";
     
     echo "</select>";
     echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
     echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>";
	 
	 echo "<td align='right' colspan='3'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
	 echo "&nbsp;<button type=\"button\" style='tar' onClick=window.location.href='./?page=dosenpa'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>";	 
     echo "</td></tr></form>";
       echo "<tr><th colspan='6' style='background-color:#EEE'>DAFTAR DOSEN PEMBIMBING AKADEMIK</th></tr>";
     echo "<tr>
     <th style='width:100px;'>TAHUN AKADEMIK</th> 
     <th style='width:50px;'>SEMESTER</th> 
     <th style='width:300px;'>PROGRAM STUDI</th> 
     <th style='width:50px;'>KELAS</th> 
     <th>DOSEN PA</th> 
     </tr>";
      $qry="left join mspstupy on dsnpaupy.KDPSTDSNPA=mspstupy.IDPSTMSPST";
	  if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
	   		$qry .= " WHERE ".$field." like '%".$key."%'";
	  }
			
			
      $MySQL->Select("mspstupy.NMPSTMSPST,dsnpaupy.THSMSDSNPA,dsnpaupy.NODOSDSNPA,dsnpaupy.NMDOSDSNPA,dsnpaupy.GELARDSNPA","dsnpaupy",$qry,"dsnpaupy.THSMSDSNPA,mspstupy.NMPSTMSPST DESC","","0");
      $total=$MySQL->Num_Rows();
      $perpage=$_REQUEST['limit'];
      $totalpage=ceil($total/$perpage);
      $start=($_GET['pos']-1)*$perpage;
      $MySQL->Select("dsnpaupy.IDX,dsnpaupy.THSMSDSNPA,dsnpaupy.KELASDSNPA,dsnpaupy.NODOSDSNPA,dsnpaupy.NMDOSDSNPA,dsnpaupy.GELARDSNPA,mspstupy.NMPSTMSPST","dsnpaupy",$qry,"dsnpaupy.THSMSDSNPA,mspstupy.NMPSTMSPST DESC","$start,$perpage");
      $no=1;
      if ($MySQL->Num_Rows() > 0){
	      while ($show=$MySQL->Fetch_Array()){
	     	$sel="";
	     	$ThnSemester=$show["THSMSDSNPA"];
	     	$sms=substr($ThnSemester,4,1);
	     	$semester="GASAL";
	     	if ($sms=="2") $semester="GENAP";
			if ($no % 2 == 1) $sel="sel";     	
	     	echo "<tr>";
	     	echo "<td class='$sel'>".substr($ThnSemester,0,4)."/".(substr($ThnSemester,0,4)+1)."</td>";
	     	echo "<td class='$sel tac'>".$semester."</td>";
	     	echo "<td class='$sel'>".$show["NMPSTMSPST"]."</td>";
	     	echo "<td class='$sel'>".$show["KELASDSNPA"]."</td>";
	     	echo "<td class='$sel'>".$show["NODOSDSNPA"]." - ".$show["NMDOSDSNPA"].", ".$show["GELARDSNPA"]."</td>";
	     	echo "</tr>";
	     	$no++;
	     }
	} else {
	 	echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";
	}
     /********* Tab Navigator ***************/
 	echo "<tr><td colspan='6'>";
	include "navigator.php";	         
 	echo "</td></tr>";
    echo "</table>";
}
?>

