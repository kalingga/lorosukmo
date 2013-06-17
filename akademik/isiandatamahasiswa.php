<?php
$idpage='13';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user = GetLevelUser($id_admin);
	switch ($id_group) {
		case '0'  : include "./content/admin/isiandatamahasiswa.php";
					break;
		case '1'  : include "./content/admin/isiandatamahasiswa.php";
					break;
		case '2'  : include "./content/mahasiswa/isiandatamahasiswa.php";
					break;
		case '4'  : 
					if ($level_user == '0') { 
						include "./content/admin/isiandatamahasiswa.php";
					} elseif ($level_user == '1') {
						include "./content/sba/isiandatamahasiswa.php";
					} else {
						include "./content/sba/isiandatamahasiswa.php";
					}
					break;
		default   : echo $msg_not_akses;
	}	
	
}
?>
