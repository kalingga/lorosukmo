<?php
$idpage='11';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user = GetLevelUser($id_admin);
	$action = UpdateData($id_group);
	switch ($id_group) {
		case '0'  : include "./content/admin/prodi.php";
					break;
		case '1'  : include "./content/admin/prodi.php";
					break;
		case '2'  : include "./content/umum/prodi.php";
					break;
		case '3'  : include "./content/umum/prodi.php";
					break;
		case '4'  : 
					if ($level_user == '0') { 
						include "./content/admin/prodi.php";
					} elseif ($level_user == '1') {
						include "./content/sba/prodi.php";
					} else {
						include "./content/sba/prodi.php";
					}
					break;
		case '5'  : include "./content/direktorat/prodi.php";
					break;
		case '6'  : include "./content/umum/prodi.php";
					break;
		default   : include "./content/umum/prodi.php";
		
	}
}
?>

