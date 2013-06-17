<?php
$idpage='25';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	session_unregister('ThnAjaran');
	session_unregister('cbSemester');

 	//nclude "./include/classes/pmb/pmb.class.php";
 	$id_admin=$_SESSION[$PREFIX.'id_admin'];
 	$id_group=$_SESSION[$PREFIX.'id_group'];
 	$level_user= GetLevelUser($id_admin);
	$curr_date= date("Y-m-d",$_SERVER['REQUEST_TIME']);	
	$curr_pmb=Get_Curr_PMB($curr_date);
	$curr_pmb=@explode(",",$curr_pmb);
	$kdpmb_pmb=$curr_pmb[0];
	$kdfrm_pmb=$curr_pmb[1];
	$ThSms_pmb=$curr_pmb[2];
	$gelom_pmb=$curr_pmb[3];
	$mulai_pmb=$curr_pmb[4];
	$akhir_pmb=$curr_pmb[5];
	$regis_pmb=$curr_pmb[6];
	$lembg_pmb=$curr_pmb[7];
	$nokyw_pmb=$curr_pmb[8];
	$nmkyw_pmb=$curr_pmb[9];
	$metod_pmb=$curr_pmb[10];
	$ujian_pmb=$curr_pmb[11];
	$kpsts_pmb=$curr_pmb[13];
	$idpmb_pmb=$curr_pmb[13];
//echo $kpsts_pmb;
 	if (isset($_POST['ThnAjaran'])) $ThnAjaran = @$_POST['ThnAjaran'];
	if (isset($_POST['cbSemester'])) $cbSemester = @$_POST['cbSemester'];
	if (isset($_POST['gelombang'])) $gelombang=@$_POST['gelombang'];		
	if (!isset($ThnAjaran) && isset($_SESSION["ThnAjaran"])) $ThnAjaran = $_SESSION["ThnAjaran"];
	if (!isset($cbSemester) && isset($_SESSION["cbSemester"])) $cbSemester = $_SESSION["cbSemester"];
	if (!isset($gelombang) && isset($_SESSION["gelombang"])) $gelombang = $_SESSION["gelombang"];

  	if (isset($ThnAjaran) && isset($cbSemester)) { 
	  	$_SESSION["ThnAjaran"] = $ThnAjaran;
		$_SESSION["cbSemester"] = $cbSemester;
		$ThSms_pmb=$ThnAjaran.$cbSemester;
	}
	$ThnAjaran = substr($ThSms_pmb,0,4);
	$cbSemester = substr($ThSms_pmb,4,1);
	
  	if (isset($gelombang)) {
		$_SESSION["gelombang"] = $gelombang;		
	} else {
		$gelombang = $gelom_pmb;
		$_SESSION["gelombang"] = $gelom_pmb;		
	}

 	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
    $sel="";	
	
    $field=$_REQUEST['field'];
	if (!isset($_REQUEST['limit'])){
	   $_REQUEST['limit']="20";
	}
	if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
	
	if (isset($p) && $p!=''){
		$URLa="page=".$page."&amp;p=".$p;	
	} else{
		$URLa="page=".$page;		
	}
	
	switch ($id_group) {
		case '0'  : include "./content/admin/daftarcmb.php";
					break;
		case '1'  : include "./content/admin/daftarcmb.php";
					break;
		case '4'  : include "./content/sba/daftarcmb.php";
					break;
		case '5'  : include "./content/direktorat/daftarcmb.php";
					break;
		default   : include "./content/sba/daftarcmb.php";
					break;
	}	
	
	if (!isset($_GET['p']) || (isset($_GET['p']) && ($_GET['p'] !='edit'))) {	
		$MySQL->Select("tbpmbupy.*,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2","tbpmbupy",$qry,"IDX ASC","","0");
	     $i=0;
		 while ($show=$MySQL->Fetch_Array()){
	 		$data[$i][0]=$show['NODTRTBPMB'];
			$data[$i][1]=$show['NMPMBTBPMB'];
			$data[$i][2]=$show['PILIHAN1'];
			$data[$i][3]=$show['PILIHAN2'];
			$data[$i][4]="";
			$i++;		     		     	
	     }	
		$report_title="DAFTAR PRESENSI CALON MAHASISWA BARU";
		$sub_title = "TA. ".$ThnAjaran."/".($ThnAjaran+1)."";		
		$sub_title .= " Sem. ".$semester."";		
		$sub_title .= " Gel. ".$gelombang."";		
		echo "<form action=\"cetak_rekap_pmb.php\" method=\"post\" target=\"pdf_target\">";
		for ($j=0;$j < $i; $j++){
			echo "<input type=\"hidden\" name=\"data[$j][0]\" value=\"".$data[$j][0]."\" />";	
			echo "<input type=\"hidden\" name=\"data[$j][1]\" value=\"".$data[$j][1]."\" />";
			echo "<input type=\"hidden\" name=\"data[$j][2]\" value=\"".$data[$j][2]."\" />";	
			echo "<input type=\"hidden\" name=\"data[$j][3]\" value=\"".$data[$j][3]."\" />";	
			echo "<input type=\"hidden\" name=\"data[$j][4]\" value=\"".$data[$j][4]."\" />";	
		}
		$width1="28,45,90,30"; // 160
		$_SESSION[PREFIX.'data1']=$data;
		$_SESSION[$PREFIX.'lembaga_instansi']=$lembg_pmb;
		$_SESSION[$PREFIX.'nip_penandatangan']=$nokyw_pmb;	
		$_SESSION[$PREFIX.'nama_penandatangan']=$nmkyw_pmb;
		echo "<input type=\"hidden\" name=\"width1\" value=\"".$width1."\" />";
		echo "<input type=\"hidden\" name=\"sub_title\" value=\"".$sub_title."\" /
	>";
		echo "<input type=\"hidden\" name=\"header_table\" value=\"".$header_table."\" /
	>";
		echo "Report Title : <input type=\"text\" size=\"75\" name=\"report_title\" value=\"".$report_title."\" /
	><br>";
		echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" /></td>";
		echo "<input type=\"hidden\" name=\"tgl\" value=\"".$tgl."\" /
	>";	
		echo "</table>";
		echo "</form>";
	}		
}

function Get_Curr_PMB($Tgl) {
	global $MySQL;
	$MySQL->Select("*","setpmbupy","where TGAWLSETPMB <= '".$Tgl."' and TGAKHSETPMB  >='".$Tgl."'","","1");
	$show=$MySQL->fetch_array();
	$curr_pmb=$show['KDPMBSETPMB'].",".$show['KDFRMSETPMB'].",".$show['TAPMBSETPMB'].",".$show['GEPMBSETPMB'].",".$show['TGAWLSETPMB'].",".$show['TGAKHSETPMB'].",".$show['TGREGSETPMB'].",".$show['LGPMBSETPMB'].",".$show['NIKKASETPMB'].",".$show['NMPMBSETPMB'].",".$show['METODSETPMB'].",".$show['TGUJISETPMB'].",".$show['KAPSTSETPMB'].",".$show['IDX'];
	return $curr_pmb;
}

function Cek_Submit($TglUji,$mulaipmb,$akhirpmb,$kapasitas,$shift,$OldTgl,$OldShift) {
//	include "./include/calendar/Date.class.php";
	if (($OldTgl==$TglUji)&&($OldShift==$shift)) {
		return true;
	} else {
		global $MySQL;
		//Cek Tanggal Uji
		$seleksi=$TglUji;
		$TglUji=@explode("-",$TglUji);
		$TglUji=$TglUji[2]."-".$TglUji[1]."-".$TglUji[0];
		;
		$seleksi = New Date($TglUji);
		$Tgl_Uji=$seleksi->isBetween($mulaipmb,$akhirpmb);
		if (!$Tgl_Uji){
			echo "<div id='msg_err' class='diverr m5 p5 tac'>Pelaksanaan Test Masuk Perguruan Tinggi dimulai ".DateStr($mulaipmb)." s.d ".DateStr($akhirpmb)."<br>Pastikan Anda Untuk Merubah Tanggal Kesediaan Anda Untuk Mengikuti Test<br></div>";
			return false;
		} else {
			$MySQL->Select("COUNT(*) as jumlah","tbpmbupy","where TGUJITBPMB='".$TglUji."' AND SHIFTTBPMB = $shift");
			$show=$MySQL->fetch_array();
			$jumlah=$show['jumlah'];
			if ($jumlah < $kapasitas) {
				return true;
			} else {
				echo "<div id='msg_err' class='diverr m5 p5 tac'>Maaf, Kapasitas Tempat Pelaksanaan Test PMB Untuk Tanggal ".DateStr($TglUji)." Sudah Terpenuhi!<br>Pastikan Anda Untuk Memasukkan Tanggal Lainnya</div>";
				return false;
			}		
		}
	}
}
?>