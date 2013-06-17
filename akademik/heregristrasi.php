<?php
$idpage='22';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	session_unregister('ThnAjaran');
	session_unregister('cbSemester');

	$id_admin=$_SESSION[$PREFIX.'id_admin'];
 	$id_group=$_SESSION[$PREFIX.'id_group'];
 	$level_user= GetLevelUser($id_admin);
	$akses_user= GetAksesUser($id_admin);

	$ThnSemester=GetLastKRS();

	$prive_user=GetProdiInFakultas("");
	if ($level_user!='0') {
		if ($level_user=='1') {
			$prive_user=GetProdiInFakultas($akses_user);
		} else {
			$prive_user="('".$akses_user."')";
		}
	}
	
 	if (isset($_POST['ThnAjaran'])) $ThnAjaran = @$_POST['ThnAjaran'];
	if (isset($_POST['cbSemester'])) $cbSemester = @$_POST['cbSemester'];
	if (isset($_POST['cbProdi'])) $cbProdi=@$_POST['cbProdi'];		
	if (!isset($ThnAjaran) && isset($_SESSION["ThnAjaran"])) $ThnAjaran = $_SESSION["ThnAjaran"];
	if (!isset($cbSemester) && isset($_SESSION["cbSemester"])) $cbSemester = $_SESSION["cbSemester"];
	if (!isset($cbProdi) && isset($_SESSION["cbProdi"])) $cbProdi = $_SESSION["cbProdi"];

  	if (isset($ThnAjaran) && isset($cbSemester)) { 
	  	$_SESSION["ThnAjaran"] = $ThnAjaran;
		$_SESSION["cbSemester"] = $cbSemester;
		$ThnSemester=$ThnAjaran.$cbSemester;
	}
	$ThnAjaran = substr($ThnSemester,0,4);
	$cbSemester = substr($ThnSemester,4,1);
	
  	if (isset($cbProdi) && ($cbProdi != '-1')) {
		$_SESSION["cbProdi"] = $cbProdi;
		$prive_user="('".$cbProdi."')";		
	} else {
		$cbProdi = $cbProdi;
		$_SESSION["cbProdi"] = $cbProdi;		
	}

 	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
    $sel="";	
	
    $field=$_REQUEST['field'];
	if (!isset($_REQUEST['limit'])){
	   $_REQUEST['limit']="20";
	}
	if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
	
/*	if (isset($p) && $p!=''){
		$URLa="page=".$page."&amp;p=".$p;	
	} else{*/
		$URLa="page=".$page;		
//	}

	$pst=trim($prive_user,"()");
	$pst=@explode(",",$pst);
	$jml_akses=count($pst);
	$p="";
	for ($i=0;$i < $jml_akses;$i++) {
		if ($i == '0') {
			$p .= trim($pst[$i],"'");
		} else {
			$p .= ",".trim($pst[$i],"'");
		}
	}

	switch ($id_group) {
		case '0'  : include "./content/admin/heregristrasi.php";
					break;
		case '1'  : include "./content/admin/heregristrasi.php";
					break;
		case '4'  : include "./content/sba/heregristrasi.php";
					break;
		case '5'  : include "./content/direktorat/heregristrasi.php";
					break;
		default   : echo $msg_not_akses;
	}	
}

function GetLastKRS(){
	global $MySQL;
	$MySQL->Select("DISTINCT MAX(setkrsupy.TASMSSETKRS) AS LASTKRS","setkrsupy","","","1");
	$show=$MySQL->fetch_array();
	return $show["LASTKRS"];	
}

function GetKur($cbProdi) {
	global $MySQL;
	$MySQL->Select("MAX(tbkmkupy.THSMSTBKMK) AS LASTKUR","tbkmkupy","tbkmkupy.KDPSTTBKMK ='".$cbProdi."'","","1");
	$show=$MySQL->fetch_array();
	return $show["LASTKUR"];
}
?>