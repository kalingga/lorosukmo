<?php
$idpage='16';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
//************** Simpan Data ***********************
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user = GetLevelUser($id_admin);
	$action = UpdateData($id_group);
	switch ($id_group) {
		case '0'  : include "./content/admin/dosenpa.php";
					break;
		case '1'  : include "./content/admin/dosenpa.php";
					break;
		case '2'  : include "./content/umum/prodi.php";
					break;
		case '3'  : include "./content/dosen/dosenpa.php";
					break;
		case '4'  : 
					if ($level_user == '0') { 
						include "./content/admin/dosenpa.php";
					} elseif ($level_user == '1') {
						include "./content/sba/dosenpa.php";
					} else {
						include "./content/sba/dosenpa.php";
					}
					break;
		case '5'  : include "./content/direktorat/dosenpa.php";
					break;
	}
}
?>

