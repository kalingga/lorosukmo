<?php
$idpage='15';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);

	$action = UpdateData($id_group);
	switch ($id_group) {
		case '0'  : include "./content/admin/kurikulum.php";
					break;
		case '1'  : include "./content/admin/kurikulum.php";
					break;
		case '2'  : include "./content/mahasiswa/kurikulum.php";
					break;
		case '3'  : include "./content/umum/kurikulum.php";
					break;
		case '4'  : 
					if ($level_user == '0') { 
						include "./content/admin/kurikulum.php";
					} elseif ($level_user == '1') {
						include "./content/sba/kurikulum.php";
					} else {
						include "./content/sba/kurikulum.php";
					}
					break;
		case '5'  : include "./content/direktorat/kurikulum.php";
					break;
		case '6'  : include "./content/umum/kurikulum.php";
					break;
		default   : include "./content/umum/kurikulum.php";
		
	}
}
?>

