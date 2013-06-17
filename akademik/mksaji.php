<?php
$idpage='18';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
 	//include "./include/classes/kurikulum/kurikulum.class.php";
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);
	$GetLastThnSemester=GetLastThnSemester();
	$ThnSemester = $GetLastThnSemester;
	
	$qry="";
	if ($level_user != '0') {
		if ($level_user == '1') {
			$pst = GetProdiInFakultas($akses_user);
		} else {
			$pst = "(".$akses_user.")";
		}
		$qry = "WHERE IDPSTMSPST IN $pst";
	}
	$MySQL->Select("IDPSTMSPST,NMPSTMSPST","mspstupy",$qry,"IDPSTMSPST ASC","");
	$i=0;
	$jml_master=$MySQL->num_rows();
	if ($jml_master > 0) {
		while ($show=$MySQL->fetch_array()) {
			$id_pst[$i] = $show["IDPSTMSPST"];
			$nm_pst[$i] = $show["NMPSTMSPST"];
			$i++;
		}
	}

 	if (isset($_POST['ThnAjaran'])) $ThnAjaran = @$_POST['ThnAjaran'];
	if (isset($_POST['cbSemester'])) $cbSemester = @$_POST['cbSemester'];
	if (!isset($ThnAjaran) && isset($_SESSION["ThnAjaran"])) $ThnAjaran = $_SESSION["ThnAjaran"];
	if (!isset($cbSemester) && isset($_SESSION["cbSemester"])) $cbSemester = $_SESSION["cbSemester"];

  	if (isset($ThnAjaran) && isset($cbSemester)) { 
	  	$_SESSION["ThnAjaran"] = $ThnAjaran;
		$_SESSION["cbSemester"] = $cbSemester;
		$ThnSemester=$ThnAjaran.$cbSemester;
	}
	$ThnAjaran = substr($ThnSemester,0,4);
	$cbSemester = substr($ThnSemester,4,1);

	switch ($id_group) {
		case '0'  : include "./content/admin/mksaji.php";
					break;
		case '1'  : include "./content/admin/mksaji.php";
					break;
		case '2'  : include "./content/mahasiswa/mksaji.php";
					break;
		case '3'  : include "./content/dosen/mksaji.php";
					break;
		case '4'  : include "./content/admin/mksaji.php";
					break;
		case '5'  : include "./content/direktorat/mksaji.php";
					break;
		default   : echo $msg_not_akses;
		
	}	
}

function GetLastThnSemester() {
	global $MySQL;
	$MySQL->Select("MAX(tbmksajiupy.THSMSMKSAJI) AS THNSEMESTER","tbmksajiupy","","","1");
	$show=$MySQL->fetch_array();
	return $show['THNSEMESTER'];
}

function GetKur($cbProdi) {
	global $MySQL;
	$MySQL->Select("MAX(tbkmkupy.THSMSTBKMK) AS LASTKUR","tbkmkupy","tbkmkupy.KDPSTTBKMK ='".$cbProdi."'","","1");	
$show=$MySQL->fetch_array();
	return $show["LASTKUR"];
}
?>