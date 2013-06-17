<style>
.blanc{
background-image: url(images/btn5.jpg);
}

</style>

<?php
$idpage='34';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	//session_unregister('ThnAjaran');
	//session_unregister('cbSemester');
	//session_unregister('cbProdi');
		
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);
	$ThnSemester=GetLastThnSemester();
	$prive_user=GetProdiInFakultas("");

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
	} /*else {
		$cbProdi = $cbProdi;
		$_SESSION["cbProdi"] = $cbProdi;		
	}*/

 	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
    $sel="";
	
    $field=$_REQUEST['field'];
	if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
	
	if (isset($p) && $p!=''){
		$URLa="page=".$page;		
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
		case '0'  : include "./content/admin/jadwalmk.php";
					break;
		case '1'  : include "./content/admin/jadwalmk.php";
					break;
		case '2'  : include "./content/mahasiswa/jadwalmk.php";
					break;
		case '3'  : include "./content/dosen/jadwalmk.php";
					break;
		case '4'  : include "./content/sba/jadwalmk.php";
					break;
		case '5'  : include "./content/direktorat/jadwalmk.php";
					break;
		default   : echo $msg_not_akses;
	}
	
	if ((($id_group=='0')||($id_group=='1')||($id_group=='4')) && !isset($_GET['p'])) {
		//********* Cetak **********
		$qry ="LEFT OUTER JOIN mspstupy ON (tbmksajiupy.KDPSTMKSAJI = mspstupy.IDPSTMSPST)";
		$qry .=" LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK)";
		$qry .=" LEFT JOIN ruang_kuliah ON ruangId = tbmksajiupy.RUANGMKSAJI";
		$qry .=" WHERE tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."' AND tbmksajiupy.KDPSTMKSAJI IN $prive_user 
    AND HRPELMKSAJI IS NOT NULL";
    	     
		echo "<form action='cetak_jadwal_mk.php' method='post' >";
		$MySQL->Select("mspstupy.NMPSTMSPST,tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,
        tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI,tbmksajiupy.KELASMKSAJI,
        ruangNama AS RUANGMKSAJI,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,
        tbmksajiupy.SMPAIMKSAJI,tbmksajiupy.DURSIMKSAJI,  tbmksajiupy.SEMESMKSAJI","tbmksajiupy",$qry,
        "tbmksajiupy.KDPSTMKSAJI ASC,tbmksajiupy.KDKMKMKSAJI ASC,tbmksajiupy.KELASMKSAJI ASC","");
		$i=0;
		$row=$MySQL->num_rows();
		while ($show=$MySQL->fetch_array()) {
			$durasi=($show['DURSIMKSAJI']*60);
			$mulai= New Time($show['MULAIMKSAJI']);
			$selesai=$mulai->add($durasi);

			$dt[$i][0]=$show["NMPSTMSPST"];
			$dt[$i][1]=$show["KDKMKMKSAJI"];
			$dt[$i][2]=$show["NAMKTBLMK"];
			$dt[$i][3]=$show["SKSMKMKSAJI"];
			$dt[$i][4]=$show["NODOSMKSAJI"];

			$dt[$i][5]=$show["NMDOSMKSAJI"];
			$dt[$i][6]=$show["KELASMKSAJI"];
			$dt[$i][7]=$show["RUANGMKSAJI"];
			$dt[$i][8]=$show["HRPELMKSAJI"];
			$dt[$i][9]=substr($show["MULAIMKSAJI"],0,5);
			$dt[$i][10]=substr($show["SMPAIMKSAJI"],0,5);
			$dt[$i][11]=$show["SEMESMKSAJI"];
			$i++;
		}

		for ($i=0;$i < $row;$i++) {
			$data[$i][0]="Program Studi";
			$data[$i][1]="Tahun Akademik";
			$data[$i][2]="Semester";
			$data[$i][3]="Kode Matakuliah";
			$data[$i][4]="Matakuliah";
			$data[$i][5]="Bobot";
			$data[$i][6]="Dosen";
			$data[$i][7]="Semester";
			$data[$i][8]="Hari";
			$data[$i][9]="Pukul";
			$data[$i][10]="Ruang";
			$data[$i][11]="Kelas";
			$data[$i][12]=$dt[$i][0];
			$data[$i][13]= substr($ThnSemester,0,4)."/".(substr($ThnSemester,0,4) + 1);
			$data[$i][14]= LoadSemester_X("",substr($ThnSemester,4,1));
			$data[$i][15]=$dt[$i][1];
			$data[$i][16]=$dt[$i][2];
			$data[$i][17]=$dt[$i][3]." SKS";
			$data[$i][18]=$dt[$i][5]." [".$dt[$i][4]."]";
			$data[$i][19]=$dt[$i][11];
			$data[$i][20]=$dt[$i][8];
			$data[$i][21]=$dt[$i][9]." s.d. ".$dt[$i][10];
			$data[$i][22]=$dt[$i][7];
			$data[$i][23]=$dt[$i][6];
		}
		$_SESSION[PREFIX.'data']=$data;
		echo "<input type='hidden' name='tahun_akademik' value='".$ThnSemester."'/>";
		echo "<input type='hidden' size='50' name='program_studi' value='$p' />";
		echo "<table>";
		echo "<tr>";
		echo "<td>Cetak :</td>";
		echo "<td><input name='report_title' type='radio' value='0' checked>PRESENSI DOSEN MENGAJAR</td>";
		echo "<td><input name='report_title' type='radio' value='2'>JADWAL KULIAH (SEMESTER)</td>";
		echo "<td><input name='report_title' type='radio' value='3'>JADWAL KULIAH (HARI)</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td><input name='report_title' type='radio' value='1'>DAFTAR HADIR KULIAH</td>";
		echo "<td><input name='report_title' type='radio' value='4'>JADWAL KULIAH (DOSEN)</td>";
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

function GetLastThnSemester() {
	global $MySQL;
	$MySQL->Select("MAX(tbmksajiupy.THSMSMKSAJI) AS THNSEMESTER","tbmksajiupy","","","1");
	$show=$MySQL->fetch_array();
	return $show['THNSEMESTER'];
}
?>