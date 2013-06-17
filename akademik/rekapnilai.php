<?php
$idpage='37';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	require "./include/htmlgraph/class.htmlgraph.php";
	session_unregister('ThnAjaran');
	session_unregister('cbSemester');
	
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);
	$prive_user=GetProdiInFakultas("");
	if ($level_user != '0') {
		if ($level_user=='1') {
			$prive_user=GetProdiInFakultas($akses_user);
		} else {
			$prive_user="(".$akses_user.")";
		}
	}
	
	$last_pmb = GetLastPMB();

 	if (isset($_POST['ThnAjaran'])) $ThnAjaran = @$_POST['ThnAjaran'];
	if (isset($_POST['cbSemester'])) $cbSemester = @$_POST['cbSemester'];
	if (!isset($ThnAjaran) && isset($_SESSION["ThnAjaran"])) $ThnAjaran = $_SESSION["ThnAjaran"];
	if (!isset($cbSemester) && isset($_SESSION["cbSemester"])) $cbSemester = $_SESSION["cbSemester"];

  	if (isset($ThnAjaran) && isset($cbSemester)) { 
	  	$_SESSION["ThnAjaran"] = $ThnAjaran;
		$_SESSION["cbSemester"] = $cbSemester;
		$last_pmb =$ThnAjaran.$cbSemester;
	}
	$ThnAjaran = substr($last_pmb,0,4);
	$cbSemester = substr($last_pmb,4,1);
	
	switch ($id_group) {
		case '0' :	include "./Laporan/rekapnilai.php";
					break;
		case '1' :	include "./Laporan/rekapnilai.php";
					break;
		case '4' :	include "./Laporan/rekapnilai.php";
					break;
		case '5' :	include "./Laporan/rekapnilai.php";
					break;
		default : echo $msg_not_akses;

	}
}

function GetLastPMB(){
	global $MySQL;
	$MySQL->Select("DISTINCT TAPMBSETPMB","setpmbupy","","TAPMBSETPMB DESC","1");
	$show=$MySQL->Fetch_Array();
	return $show["TAPMBSETPMB"];
}
?>