<?php
$idpage='12';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user = GetLevelUser($id_admin);
	$akses_user = GetAksesUser($id_admin);

	if ($_GET['p'] && $_GET['p']=='refresh') {
		session_unregister("field");
		session_unregister("key");
	} else {
		if (isset($_REQUEST['field'])) $field = @$_REQUEST['field'];
		if (isset($_REQUEST['key'])) $key = @$_REQUEST['key'];
	
		if (!isset($field) && isset($_SESSION["field"])) $field = $_SESSION["field"];
		if (!isset($key) && isset($_SESSION["key"])) $key = $_SESSION["key"];
	
		if (isset($field)) {
			$_SESSION["field"] = $field;		
		} 
		if (isset($key)) {
			$_SESSION["key"] = $key;		
		}	
	}
	if (!isset($_REQUEST['limit'])){
    	$_REQUEST['limit']="20";
	}		

	switch ($id_group) {
		case '0'  : include "./content/admin/daftarmahasiswa.php";
					break;
		case '1'  : include "./content/admin/daftarmahasiswa.php";
					break;
		case '4'  : 
					if ($level_user == '0') { 
						include "./content/admin/daftarmahasiswa.php";
					} elseif ($level_user == '1') {
						include "./content/sba/daftarmahasiswa.php";
					} else {
						include "./content/sba/daftarmahasiswa.php";
					}
					break;
		case '5'  : include "./content/direktorat/daftarmahasiswa.php";
					break;
		default   : echo $msg_not_akses;
	}
}
?>
