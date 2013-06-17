<?php
$idpage='33';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);
	$ThnSemester= GetLastKRS();

	$action = UpdateData($id_group);
	
 	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
	$sel="";
	$field=$_REQUEST['field'];
	if (!isset($_REQUEST['limit'])){
	    $_REQUEST['limit']="20";
	 }
	 if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];

	$URLa="page=".$page;		

    $qry = "";
	if(!empty($_REQUEST['key'])){
      	$qry .= " where ".$field." like '%".$key."%'";
  	}
	
	switch ($id_group) {
		case '0'  : include "./content/admin/jadwalkrs.php";
					break;
		case '1'  : include "./content/admin/jadwalkrs.php";
					break;
		case '2'  : include "./content/mahasiswa/jadwalkrs.php";
					break;
		case '3'  : include "./content/direktorat/jadwalkrs.php";
					break;
		case '4'  : 
					if ($level_user == '0') { 
						include "./content/admin/jadwalkrs.php";
					} elseif ($level_user == '1') {
						include "./content/direktorat/jadwalkrs.php";
					} else {
						include "./content/direktorat/jadwalkrs.php";
					}
					break;
		case '5'  : include "./content/direktorat/jadwalkrs.php";
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

