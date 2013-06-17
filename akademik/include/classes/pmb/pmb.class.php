<?php
/*	untuk memunculkan no formulir */
function GetMaxDate(){
	global $MySQL;
	$MySQL->Select("MAX(setpmbupy.TGAWLSETPMB) AS MAXDATE","setpmbupy","","1");
	$show=$MySQL->fetch_array();
	$maxdate=$show['MAXDATE'];
	return $maxdate;
}

function GetCurrPMB(){
	global $MySQL;
	$MySQL->Select("*","setpmbupy","where setpmbupy.TGAWLSETPMB = '".GetMaxDate()."'","","1");
	$show=$MySQL->fetch_array();
	$currpmb=$show['KDPMBSETPMB'].",".$show['KDFRMSETPMB'].",".$show['TAPMBSETPMB'].",".$show['GEPMBSETPMB'].",".$show['TGAWLSETPMB'].
",".$show['TGAKHSETPMB'].",".$show['LGPMBSETPMB'].",".$show['NIKKASETPMB'].
",".$show['NMPMBSETPMB'].",".$show['METODSETPMB'].",".$show['TGUJISETPMB'].",".$show['WKUJISETPMB'].",".$show['DURWKSETPMB'].",".$show['KAPSTSETPMB'];	
	return $currpmb;
}

function SetNoForm() {
	global $MySQL;
	$currpmb=GetCurrPMB();
	$currpmb=@explode(",",$currpmb);
	$formulir=$currpmb[1];
	$MySQL->Select("count(*) as FORMULIR","frpmbupy","WHERE KDFRMFRPMB ='".$formulir."'","","1");
    $show=$MySQL->Fetch_Array();
	$currform= $show["FORMULIR"] + 1;
//	Insert frmpmbupy untuk handle no formulir;
	$MySQL->Insert("frpmbupy","KDFRMFRPMB,NOFRMFRPMB","'$formulir','$currform'");
//	Ambil no Formulir dan ditampilkan	
	$MySQL->Select("*","frpmbupy","where KDFRMFRPMB='$formulir' and NOFRMFRPMB='$currform'","","1");
	$show=$MySQL->fetch_array();
	$currnoform=$show['KDFRMFRPMB']."-".$show['NOFRMFRPMB'];
	return $currnoform;
}

function GetAjaran() {
	$thn=date("Y",$_SERVER['REQUEST_TIME']); 
	return $thn;
}

function GetNoDaftar() {
	global $MySQL;
	$currdaftar=GetCurrPMB();
	$currdaftar=@explode(",",$currdaftar);
	$currdaftar_thn=$currdaftar[2];
	$currdaftar_gel=$currdaftar[3];
	$currdaftar_kd=$currdaftar[0];
	$MySQL->Select("count(*) as JMLDAFTAR","tbpmbupy","WHERE THDTRTBPMB ='".$currdaftar_thn."' and GLDTRTBPMB='".$currdaftar_gel."'","","1");
    $show=$MySQL->Fetch_Array();
	$jmldaftar= $show["JMLDAFTAR"] + 1;
	$nodaftar=$currdaftar_kd."-".substr_replace('0000',$jmldaftar,(strlen('0000') - 1),strlen($jmldaftar));
	return $nodaftar;
}

function CekTglUjiPMB($Tgl) {
	$curruji=GetCurrPMB();
	$curruji=@explode(",",$curruji);
	$mulaiuji=DateStr($curruji[4]);
	$akhiruji=DateStr($curruji[5]);
//	$Tgl=@explode("-",$Tgl);
//	$Tgl=$Tgl[2]."-".$Tgl[1]."-".$Tgl[0];	
	$Tgl = New Date($Tgl);
	$TglUji= $Tgl->isBetween($mulaiuji,$akhiruji);
	//Jika TglUji tidak diantara tanggal yang ditetapkan maka input data gagal
	if (!$TglUji){
		echo "<div id='msg_err' class='diverr m5 p5 tac'>Pelaksanaan Test Masuk Perguruan Tinggi dimulai ".$mulaiuji." s.d ".$akhiruji."<br>Pastikan Anda Untuk Merubah Tanggal Kesediaan Anda Untuk Mengikuti Test<br></div>";
		return false;
	} else {
		return true;
	}
}

function CekKapasitasUji($Tgl){
	global $MySQL;
	$kapasitas=GetCurrPMB();
	$kapasitas=@explode(",",$kapasitas);
	$kapasitas=$kapasitas[13];

	$TglUji=@explode("-",$Tgl);
	$TglUji=$TglUji[2]."-".$TglUji[1]."-".$TglUji[0];	
	$MySQL->Select("COUNT(*) as jumlah","tbpmbupy","where TGUJITBPMB='".$TglUji."'");
	$show=$MySQL->fetch_array();
	$jumlah=$show['jumlah'];
	//Cek Kapasitas Max untuk pelaksanaan ujian seleksi berdasarkan kesediaan mengikuti tes seleksi
	if ($show['jumlah'] >= $kapasitas) {
			echo "<div id='msg_err' class='diverr m5 p5 tac'>Maaf, Kapasitas Tempat Pelaksanaan Test PMB Untuk Tanggal ".DateStr($Tgl)." Sudah Terpenuhi!<br>Pastikan Anda Untuk Memasukkan Tanggal Lainnya</div>";
		return false;
	} else {
		return true;
	}
}

/*function PrintPMB($edtNoDaftar,$edtNama,$edtAlamat,$edtKelurahan,$edtKota,$cbPropinsi,$edtKodePos,$edtTelp,$cbProdi1,$cbProdi2,$cbProgram,$TglUji,$mulaiujian,$durasi,$ThnSemester,$curr_pmb_kd,$id_admin=""){
	global $MySQL, $PREFIX;

	$ThnAjaran=substr($ThnSemester,0,4);	
	$waktuujian= New Time($mulaiujian);
	$selesaiujian=$waktuujian->add($durasi);
	echo "<form action=\"cetak_formulir.php\" method=\"post\" target=\"pdf_target\">";
	echo "<table style='width:95%' border='0' cellpadding='1' cellspacing='1'>";
	echo "<tr><td rowspan='3' style='width:10%' >";
	echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" /></td>";
    echo "<td colspan='2' align='center'><b>Form Pendaftaran Calon Mahasiswa Baru</b></td></tr>";
  	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
  	echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		$report_title="BUKTI PENDAFTARAN MAHASISWA BARU ";
		if ($id_admin != "") {
			$report_title="KARTU UJIAN PENDAFTARAN MAHASISWA BARU ";			
		}					
		$data[$i][0]="No Pendaftaran";
		$data[$i][1]=": ".$edtNoDaftar;
		$i++;
		$data[$i][0]="Nama Lengkap";
		$data[$i][1]=": ".$edtNama;
		$i++;
		$data[$i][0]="Alamat";
		$data[$i][1]=": ".$edtAlamat." ".$edtKelurahan." ".$edtKota." ".LoadPropinsi_X("",$cbPropinsi)." ".$edtKodePos;
		$i++;
		$data[$i][0]="Telpon";
		$data[$i][1]=": ".$edtTelp;		
		$i++;		
		$data[$i][0]="";
		$data[$i][1]="";
		$i++;		
		$data[$i][0]="Program Studi Pilihan";
		$i++;		
		$data[$i][0]="Pilihan I";
		$data[$i][1]=": ".LoadProdi_X("",$cbProdi1);
		$i++;
		$data[$i][0]="Pilihan II";
		$data[$i][1]=": ".LoadProdi_X("",$cbProdi2);
		$i++;
		$data[$i][0]="Program/Kelas";
		$data[$i][1]=": ".LoadKode_X("",$cbProgram,"97");
		$i++;		
		$data[$i][0]="";
		$data[$i][1]="";
		$i++;		
		$data[$i][0]="Waktu Pelaksanaan Test";
		$i++;	
		$data[$i][0]="Tanggal";
		$data[$i][1]=": ".DateStr($TglUji);
		$i++;
		$data[$i][0]="Jam";
		$data[$i][1]=": ".$mulaiujian."  s.d. ".$selesaiujian;

		$style_width1="style='width:200px;'";
		$style_width2="style='width:250px;'";		
		$report_title .= "Tahun Ajaran ".$ThnAjaran."/".($ThnAjaran+1)."";
/*		for ($j=0;$j<=$i;$j++){
			echo "<tr><td>&nbsp;</td>";
			echo "<td $style_width1 >";
			echo $data[$j][0];
			echo "</td>";
			echo "<td $style_width2 >";
			echo $data[$j][1];
			echo "</td>";
			echo "<td>&nbsp;</td></tr>";
			$style_width1="";
			$style_width2="";
		}*/
/*		$width1="45,5,110"; // 160
		$_SESSION[PREFIX.'data1']=$data;
		$edtNoDaftar=@explode("-",$edtNoDaftar);
		$edtNoDaftar=$edtNoDaftar[0];
	$MySQL->Select("LGPMBSETPMB,NIKKASETPMB,NMPMBSETPMB","setpmbupy","where KDPMBSETPMB='".$curr_pmb_kd."'","","1");

	$sign=$MySQL->Fetch_Array();
	$_SESSION[$PREFIX.'lembaga_instansi']=$sign['LGPMBSETPMB'];
	$_SESSION[$PREFIX.'nip_penandatangan']=$sign['NIKKASETPMB'];	
	$_SESSION[$PREFIX.'nama_penandatangan']=$sign['NMPMBSETPMB'];
		echo "<input type=\"hidden\" name=\"lembaga_instansi\" value=\"".$sign['LGPMBSETPMB']."\" />";
		echo "<input type=\"hidden\" name=\"nip_penandatangan\" value=\"".$sign['NIKKASETPMB']."\" />";
		echo "<input type=\"hidden\" name=\"nama_penandatangan\" value=\"".$sign['NMPMBSETPMB']."\" />";
		echo "<input type=\"hidden\" name=\"width1\" value=\"".$width1."\" />";
		echo "<input type=\"hidden\" name=\"report_title\" value=\"".$report_title."\" /
>";  	
	echo "</table></form>";
}*/
?>