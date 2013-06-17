<?php
$idpage='35';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
 	session_unregister('ThnAjaran');
	session_unregister('cbSemester');
	
 	//include "./include/classes/kurikulum/kurikulum.class.php";
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);

	$ThnSemester=GetLastThnSemester();
	$prive_user=GetProdiInFakultas("");

/*	if ($level_user!='0') {
		if ($level_user=='1') {
			$prive_user=GetProdiInFakultas($akses_user);
		} else {
			$prive_user="('".$akses_user."')";
		}
	}*/
	
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
	
	$qry="";
	if ($level_user != '0') {
		if ($level_user == '1') {
			$prive_user = GetProdiInFakultas($akses_user);
		} else {
			$prive_user = "(".$akses_user.")";
		}
		$qry = "WHERE IDPSTMSPST IN $prive_user";
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

  	if (isset($cbProdi) && ($cbProdi != '-1')) {
  		$i=0;
		$_SESSION["cbProdi"] = $cbProdi;
		$prive_user="('".$cbProdi."')";
		$MySQL->Select("IDPSTMSPST,NMPSTMSPST","mspstupy","WHERE IDPSTMSPST IN $prive_user","","1");
		$jml_master=$MySQL->num_rows();
		$show=$MySQL->fetch_array();
		$id_pst[$i] = $show["IDPSTMSPST"];
		$nm_pst[$i] = $show["NMPSTMSPST"];
	} else {
		$cbProdi = $cbProdi;
		$_SESSION["cbProdi"] = $cbProdi;
	}

 	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
    $sel="";	
	
	
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
		case '0'  : include "./content/admin/jadwalutsuas.php";
					break;
		case '1'  : include "./content/admin/jadwalutsuas.php";
					break;
		case '2'  : include "./content/mahasiswa/jadwalutsuas.php";
					break;
		case '3'  : include "./content/dosen/jadwalutsuas.php";
					break;
		case '4'  : 
					if ($level_user != '0') {
						include "./content/sba/jadwalutsuas.php";
					} else {
						include "./content/admin/jadwalutsuas.php";						
					}
					break;
		case '5'  : include "./content/direktorat/jadwalutsuas.php";
					break;
		default   : echo $msg_not_akses;
	}
	
	if ((!isset($_GET['p'])) && (!isset($_POST['p']))) {
		if (($id_group == '0') || ($id_group=='1') || ($id_group=='4')) {
		//********* Cetak **********
		echo "<form action='cetak_jadwal_uts_uas.php' method='post' >";
		echo "<input type='hidden' name='tahun_akademik' value='".$ThnSemester."'/>";
		echo "<input type='hidden' size='50' name='program_studi' value='".$p."'/>";
		echo "<table>";
		echo "<tr><td>Jenis Ujian :</td>";
		echo "<td colspan='2'><select name='jenis_ujian' >";
	   	echo "<option value='0' $sel1>UTS</option>";
	   	echo "<option value='1' $sel2>UAS</option>";
		echo "</select></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Cetak :</td>";
		echo "<td><input name='report_title' type='radio' value='0' checked>PRESENSI UJIAN</td>";
		echo "<td><input name='report_title' type='radio' value='1'>NASKAH PEKERJAAN</td>";
		echo "<td><input name='report_title' type='radio' value='4'>JADWAL PELAKSANAAN UJIAN (Matakuliah)</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td><input name='report_title' type='radio' value='2'>PRESENSI PENGAWAS UJIAN</td>";
		echo "<td><input name='report_title' type='radio' value='3'>BERITA ACARA PELAKSANAAN UJIAN</td>";
		echo "<td><input name='report_title' type='radio' value='5'>JADWAL PELAKSANAAN UJIAN (Hari)</td>";
		echo "<td>&nbsp;</td>";
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