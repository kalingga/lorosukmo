<?php
$idpage='26';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	session_unregister('ThnAjaran');
	session_unregister('cbSemester');

 	include "./include/classes/pmb/pmb.class.php";
  	$id_admin=$_SESSION[$PREFIX.'id_admin'];
 	$id_group=$_SESSION[$PREFIX.'id_group'];
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
	$nmkyw_pmb=$curr_pmb[8];
	$metod_pmb=$curr_pmb[10];
	$ujian_pmb=$curr_pmb[11];
	$waktu_pmb=$curr_pmb[12];
	$duras_pmb=$curr_pmb[13];
	$kpsts_pmb=$curr_pmb[14];
	$durasi=($duras_pmb * 60);
	$waktuujian= New Time($waktu_pmb);
	$selesaiujian=$waktuujian->add($durasi);

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
		case '0'  : include "./content/admin/seleksicmb.php";
					break;
		case '1'  : include "./content/admin/seleksicmb.php";
					break;
		case '4'  : include "./content/admin/seleksicmb.php";
					break;
		case '5'  : include "./content/direktorat/seleksicmb.php";
					break;
		case '6'  : include "./content/umum/seleksicmb.php";
					break;
		default   : include "./content/admin/seleksicmb.php";
					break;
	}	

if ($id_group != '6') {
	if (!isset($_GET['p']) || (isset($_GET['p']) && ($_GET['p'] !='edit') && ($_GET['p'] !='view'))) {	
		/* Set Cetak File ke Bentuk PDF */
		$report_title="HASIL SELEKSI PENERIMAAN MAHASISWA BARU";
		$sub_title = "TA ".$ThnAjaran."/".($ThnAjaran+1)."";		
		$sub_title .= " Sem. ".$cbSemester." Gel. ".$gelombang;
		echo "<form action=\"cetak_seleksi_pmb.php\" method=\"post\" target=\"pdf_target\">";
		$width1="30,65,35,65"; // 160
		$_SESSION[PREFIX.'data1']=$data;
		$MySQL->Select("LGPMBSETPMB,NIKKASETPMB,NMPMBSETPMB","setpmbupy","where KDPMBSETPMB='".$curr_pmb_kd."'","","1");
	
		$sign=$MySQL->Fetch_Array();
		$_SESSION[$PREFIX.'lembaga_instansi']=$sign['LGPMBSETPMB'];
		$_SESSION[$PREFIX.'nip_penandatangan']=$sign['NIKKASETPMB'];	
		$_SESSION[$PREFIX.'nama_penandatangan']=$sign['NMPMBSETPMB'];
		echo "<input type=\"hidden\" name=\"width1\" value=\"".$width1."\" />";
		echo "<input type=\"hidden\" name=\"report_title\" value=\"".$report_title."\" /
>";
		echo "<input type=\"hidden\" name=\"sub_title\" value=\"".$sub_title."\" /
>";
		echo "<input type=\"hidden\" name=\"header_table\" value=\"".$header_table."\" /
>";
		echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" /></td>";
		echo "</table>";
		echo "</form>";	
	}
}
}

function Get_Curr_PMB($Tgl) {
	global $MySQL;
	$MySQL->Select("*","setpmbupy","where TGAWLSETPMB <= '".$Tgl."' and TGAKHSETPMB  >='".$Tgl."'","","1");
	$show=$MySQL->fetch_array();
	$curr_pmb=$show['KDPMBSETPMB'].",".$show['KDFRMSETPMB'].",".$show['TAPMBSETPMB'].",".$show['GEPMBSETPMB'].",".$show['TGAWLSETPMB'].",".$show['TGAKHSETPMB'].",".$show['TGREGSETPMB'].",".$show['LGPMBSETPMB'].",".$show['NIKKASETPMB'].",".$show['NMPMBSETPMB'].",".$show['METODSETPMB'].",".$show['TGUJISETPMB'].",".$show['WKUJISETPMB'].",".$show['DURWKSETPMB'].",".$show['KAPSTSETPMB'];
	return $curr_pmb;
}

?>