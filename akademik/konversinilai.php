<?php
$idpage='28';
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

	$ThnSemester=Get_Curr_PMB();
	$prive_user=GetProdiInFakultas("");

	if ($level_user!='0') {
		if ($level_user=='1') {
			$prive_user=GetProdiInFakultas($akses_user);
		} else {
			$prive_user="('".$akses_user."')";
		}
	}
	
 	if (isset($_POST['ThnAjaran'])) $ThnAjaran = @$_POST['ThnAjaran'];
	if (isset($_POST['cbSemester'])) $cbSemester = @$_POST['cbSemester'];
	if (isset($_POST['cbProdi'])) $cbProdi=@$_POST['cbProdi'];		
	if (!isset($ThnAjaran) && isset($_SESSION["ThnAjaran"])) $ThnAjaran = $_SESSION["ThnAjaran"];
	if (!isset($cbSemester) && isset($_SESSION["cbSemester"])) $cbSemester = $_SESSION["cbSemester"];
	if (!isset($cbProdi) && isset($_SESSION["cbProdi"])) $cbProdi = $_SESSION["cbProdi"];

  	if (isset($ThnAjaran) && isset($cbSemester)) { 
	  	$_SESSION["ThnAjaran"] = $ThnAjaran;
		$_SESSION["cbSemester"] = $cbSemester;
		$ThnSemester=$ThnAjaran.$cbSemester;
	}
	$ThnAjaran = substr($ThnSemester,0,4);
	$cbSemester = substr($ThnSemester,4,1);

  	if (isset($cbProdi) && ($cbProdi != '-1')) {
		$_SESSION["cbProdi"] = $cbProdi;
		$prive_user="('".$cbProdi."')";
	} else {
		$cbProdi = $cbProdi;
		$_SESSION["cbProdi"] = $cbProdi;
	}

 	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
    $sel="";	

	$field=$_REQUEST['field'];
	if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];

	if (!isset($_REQUEST['limit'])){
    	$_REQUEST['limit']="20";
	}
	
	
/*	if (isset($p) && $p!=''){
		$URLa="page=".$page."&amp;p=".$p;	
	} else{*/
	$URLa="page=".$page;		
//	}

	$pst=trim($prive_user,"()");
	$pst=@explode(",",$pst);
	$jml_akses=count($pst);
	$p="";
	for ($i=0;$i < $jml_akses;$i++) {
		if ($i == '0') {
			$p .= trim($pst[$i],"'");
		} else {
			$p .= ",".trim($pst[$i],"'");
		}
	}

	switch ($id_group) {
		case '0'  : include "./content/admin/konversinilai.php";
					break;
		case '1'  : include "./content/admin/konversinilai.php";
					break;
		case '2'  : include "./content/mahasiswa/konversinilai.php";
					break;
		case '3'  : include "./content/dosen/konversinilai.php";
					break;
		case '4'  : 
					if ($level_user != '0') {
						include "./content/sba/konversinilai.php";
					} else {
						include "./content/admin/konversinilai.php";						
					}
					break;
		case '5'  : include "./content/direktorat/konversinilai.php";
					break;
		default   : echo $msg_not_akses;
	}
	
	if (!isset($_GET['p'])) {
		$_SESSION[PREFIX.'data1']=$data;
		echo "<form action='cetak_konversi_nilai.php' method='post' >";
		echo "<table>";
		echo "<tr>";
		echo "<td>Cetak :</td>";
		$report_title="KONVERSI NILAI";
		echo "<td><input name='report_title' size='40' type='text' value='$report_title'></td>";
		echo "</tr>";
		echo "<tr>";
		echo "	<td colspan=\"3\">";
		echo "	<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />";
		echo "	</td>";
		echo "</tr>";
		echo "</table>";		
		echo "</form>";
	}		
}

function Get_Curr_PMB() {
	global $MySQL;
	$MySQL->Select("MAX(setpmbupy.TAPMBSETPMB) AS CURR_PMB","setpmbupy","","","1");
	$show=$MySQL->fetch_array();
	$curr_pmb=$show['CURR_PMB'];
	return $curr_pmb;
}

function Get_Curr_kurikulum($pst) {
	global $MySQL;
	$MySQL->Select("MAX(tbkmkupy.THSMSTBKMK) AS THNKURIKULUM","tbkmkupy","WHERE tbkmkupy.KDPSTTBKMK = '".$pst."'","","1");
	$show=$MySQL->fetch_array();
	$curr_kurikulum=$show['THNKURIKULUM'];
	return $curr_kurikulum;
}
?>
