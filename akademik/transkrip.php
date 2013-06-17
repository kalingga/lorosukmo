<?php
$idpage='31';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
 	$level_user= GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);
	$prive_user=GetProdiInFakultas("");
	if ($level_user != '0') {
		if ($level_user == '1') {
			$prive_user=GetProdiInFakultas($akses_user);
		} else {
			$prive_user = "(".$akses_user.")";
		}
	}
	
	if (isset($_GET['p']) && ($_GET['p'] == 'refresh')) {
		session_unregister('field');
		session_unregister('key');
	}			

	if (isset($_POST['field'])) $field = @$_POST['field'];
	if (isset($_POST['key'])) $key = @$_POST['key'];
	if (!isset($field) && isset($_SESSION["field"])) $field = $_SESSION["field"];
	if (!isset($key) && isset($_SESSION["key"])) $key = $_SESSION["key"];
		
	if (isset($field) && ($key != "")) { 
	  	$_SESSION["field"] = $field;
		$_SESSION["key"] = $key;
	}
	
	$ThnSemester=GetLastKRS();

	switch ($id_group) {
		case '0'  : include "./content/admin/transkrip.php";
					break;
		case '1'  : include "./content/admin/transkrip.php";
					break;
		case '2'  : include "./content/mahasiswa/transkrip.php";
					break;
		case '3'  : include "./content/dosen/transkrip.php";
					break;
		case '4'  : include "./content/admin/transkrip.php";
					break;
		case '5'  : include "./content/admin/transkrip.php";
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
?>