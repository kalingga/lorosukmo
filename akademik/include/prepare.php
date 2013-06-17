<?php
if (isset($_POST['login_admin'])){
	$login_result=ProcLogin( trim($_POST['user']) , trim($_POST['pass']) );
	$_SESSION[$PREFIX.'hak_akses_arr']=explode(",",$_SESSION[$PREFIX.'hak_akses_admin']);
}
else if ($_GET['act']=='logout'){
	if (isset($_SESSION[$PREFIX.'user_admin'])){
		ProcLogout();
	}
}
//Menampilkan setting awal dari aplikasi
//menentukan hak akses atas user umum
$MySQL->Select("*","msptiupy");
$show=$MySQL->Fetch_Array();
$_SESSION[$PREFIX.'NMPTIMSPTI']=$show['NMPTIMSPTI'];
$_SESSION[$PREFIX.'ALMT1MSPTI']=$show['ALMT1MSPTI'];
$_SESSION[$PREFIX.'ALMT2MSPTI']=$show['ALMT2MSPTI'];
$_SESSION[$PREFIX.'KOTAAMSPTI']=$show['KOTAAMSPTI'];
$_SESSION[$PREFIX.'TELPOMSPTI']=$show['TELPOMSPTI'];
$_SESSION[$PREFIX.'FAKSIMSPTI']=$show['FAKSIMSPTI'];
$_SESSION[$PREFIX.'LGPTIMSPTI']=$show['LGPTIMSPTI'];
?>
