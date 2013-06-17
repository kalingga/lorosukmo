<?php
$idpage='23';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	if (!isset($_SESSION[$PREFIX.'id_admin'])) $id_admin="0";

	$reg="";
	$passwd="";
	$buktidaftar="1";	
	$report_title="BUKTI PENDAFTARAN CALON MAHASISWA BARU ";
	if (isset($_SESSION[$PREFIX.'user_admin'])) {
		$reg="1";
		$passwd=RandomKey("8","");
		$report_title="KARTU UJIAN SELEKSI CALON MAHASISWA BARU ";
		$buktidaftar="0";
	}
	$curr_date= date("Y-m-d",$_SERVER['REQUEST_TIME']);	
	$new=1;
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
	$kpsts_pmb=$curr_pmb[13];
	$idpmb_pmb=$curr_pmb[13];

//	$jml_shift_pmb=$MySQL->num_rows();
//	$i=0;
	
	while ($show=$MySQL->fetch_array()) {
		$shift[]= $show;
/*		$shift[$i][0]=$show['IDX'];
		$shift[$i][1]=$show['SHIFTSETPMB'];
		$shift[$i][2]=substr($show['WAKTUSETPMB'],0,5);
		$durasi=($show['DURWKSETPMB'] * 60);
		$waktuujian=New Time($shift[$i][2]);
		$shift[$i][3]=$waktuujian->add($durasi);
		$i++;*/
	}
	
	$submited="Simpan";
	$succ=0;
	if (isset($_POST['submit'])){
		$edtFormulir=substr(strip_tags($_POST["edtFormulir"]),0,14);
		$edtNama= strtoupper(substr(strip_tags($_POST["edtNama"]),0,30));
		$rbJK= substr(strip_tags($_POST["rbJK"]),0,1);
		$edtLahir= substr(strip_tags($_POST["edtLahir"]),0,20);
		$edtTglLahir= substr(strip_tags($_POST["edtTglLahir"]),0,10);
		$rbNegara= substr(strip_tags($_POST["rbNegara"]),0,1);
		$edtNegara= substr(strip_tags($_POST["edtNegara"]),0,20);
		$edtAlamat= substr(strip_tags($_POST["edtAlamat"]),0,30);
		$edtKelurahan= substr(strip_tags($_POST["edtKelurahan"]),0,20);
		$edtKota= substr(strip_tags($_POST["edtKota"]),0,20);
		$cbPropinsi= substr(strip_tags($_POST["cbPropinsi"]),0,2);
		$edtKodePos= substr(strip_tags($_POST["edtKodePos"]),0,5);
		$edtTelp= substr(strip_tags($_POST["edtTelp"]),0,20);
		$cbJenjang= substr(strip_tags($_POST["cbJenjang"]),0,1);
		$edtNamaPT= substr(strip_tags($_POST["edtNamaPT"]),0,30);
		$edtJurusan= substr(strip_tags($_POST["edtJurusan"]),0,30);
		$edtAlamat1= substr(strip_tags($_POST["edtAlamat1"]),0,30);
		$edtKota1= substr(strip_tags($_POST["edtKota1"]),0,20);
		$cbPropinsi1= substr(strip_tags($_POST["cbPropinsi1"]),0,2);
		$cbPekerjaan= substr(strip_tags($_POST["cbPekerjaan"]),0,1);
		$edtNamaKerja= substr(strip_tags($_POST["edtNamaKerja"]),0,30);
		$edtAlamatKerja= substr(strip_tags($_POST["edtAlamatKerja"]),0,30);
		$rbAlumni= substr(strip_tags($_POST["rbAlumni"]),0,1);
		$edtAnggota= substr(strip_tags($_POST["edtAnggota"]),0,11);
		$cbProdi1= substr(strip_tags($_POST["cbProdi1"]),0,2);
		$cbProdi2= substr(strip_tags($_POST["cbProdi2"]),0,2);
		$cbProgram= substr(strip_tags($_POST["cbProgram"]),0,1);
		$cbInformasi= substr(strip_tags($_POST["cbInformasi"]),0,1);
		$cbStatus= substr(strip_tags($_POST["cbStatus"]),0,1);
		$edtTglUji= substr(strip_tags($_POST["edtTglUji"]),0,10);
		$cbShift=$_POST["cbShift"];
		$OldTgl= substr(strip_tags($_POST["OldTgl"]),0,10);
		$OldShift=$_POST["OldShift"];
		
		//Cek batasan keberhasilan untuk input data meliputi pemilihan tanggal ujian dan kapasitas maksimal tiap gelombang pelaksanaan pmb tiap-tiap tahun semester berjalan
		
		if ($metod_pmb==0) {
			$cek=Cek_Submit($edtTglUji,$mulai_pmb,$akhir_pmb,$kpsts_pmb,$cbShift,$OldTgl,$OldShift);
			if ($cek) {
				$edtTglLahir= @explode("-",$edtTglLahir);
				$edtTglLahir= $edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
				$edtTglUji=@explode("-",$edtTglUji);
				$edtTglUji=$edtTglUji[2]."-".$edtTglUji[1]."-".$edtTglUji[0];
				//Lakukan proses submit
				//Cari No Pendaftaran secara otomatis
				if ($_POST['submit'] == 'Simpan'){
					$NoDaftar=GetNoDaftar($ThSms_pmb,$gelom_pmb,$kdpmb_pmb);
					$MySQL->Insert("tbpmbupy","NOFRMTBPMB,THDTRTBPMB,GLDTRTBPMB,NODTRTBPMB,NMPMBTBPMB,KDJEKTBPMB,TPLHRTBPMB,TGLHRTBPMB,KDWNITBPMB,NEGRATBPMB,ALMT1TBPMB,KELRHTBPMB,KABPTTBPMB,PROPITBPMB,TELPOTBPMB,KDPOSTBPMB,KDJENTBPMB,SKASLTBPMB,JURSNTBPMB,ALTSKTBPMB,KABSKTBPMB,PROSKTBPMB,STKRJTBPMB,NMKRJTBPMB,ALKRJTBPMB,ALMNITBPMB,ANGGTTBPMB,PLHN1TBPMB,PLHN2TBPMB,PROGRTBPMB,INFORTBPMB,STPIDTBPMB,TGUJITBPMB,SHIFTTBPMB,STREGTBPMB,PSUJITBPMB","'$edtFormulir','$ThSms_pmb','$gelom_pmb','$NoDaftar',UPPER('$edtNama'),'$rbJK','$edtLahir','$edtTglLahir','$rbNegara','$edtNegara','$edtAlamat','$edtKelurahan','$edtKota','$cbPropinsi','$edtTelp','$edtKodePos','$cbJenjang','$edtNamaPT','$edtJurusan','$edtAlamat1','$edtKota1','$cbPropinsi1','$cbPekerjaan','$edtNamaKerja','$edtAlamatKerja','$rbAlumni','$edtAnggota','$cbProdi1','$cbProdi2','$cbProgram','$cbInformasi','$cbStatus','$edtTglUji','$cbShift','$reg','$passwd'");
					$act_log="Tambah Data Calon Mahasiswa Baru ";
					$msg="Tambah Data Calon Mahasiswa Baru ";
				} else {
					
					$NoDaftar=$_POST["NoDaftar"];
					$edtID=$_POST['edtID'];
					$MySQL->Update("tbpmbupy","NMPMBTBPMB=UPPER('$edtNama'),KDJEKTBPMB='$rbJK',TPLHRTBPMB='$edtLahir',TGLHRTBPMB='$edtTglLahir',KDWNITBPMB='$rbNegara',NEGRATBPMB='$edtNegara',ALMT1TBPMB='$edtAlamat',KELRHTBPMB='$edtKelurahan',KABPTTBPMB='$edtKota',PROPITBPMB='$cbPropinsi',TELPOTBPMB='$edtTelp',KDPOSTBPMB='$edtKodePos',KDJENTBPMB='$cbJenjang',SKASLTBPMB='$edtNamaPT',JURSNTBPMB='$edtJurusan',ALTSKTBPMB='$edtAlamat1',KABSKTBPMB='$edtKota1',PROSKTBPMB='$cbPropinsi1',STKRJTBPMB='$cbPekerjaan',NMKRJTBPMB='$edtNamaKerja',ALKRJTBPMB='$edtAlamatKerja',ALMNITBPMB='$rbAlumni',ANGGTTBPMB='$edtAnggota',PLHN1TBPMB='$cbProdi1',PLHN2TBPMB='$cbProdi2',PROGRTBPMB='$cbProgram',INFORTBPMB='$cbInformasi',STPIDTBPMB='$cbStatus',TGUJITBPMB='$edtTglUji',SHIFTTBPMB='$cbShift',STREGTBPMB='$reg',PSUJITBPMB='$passwd'","where IDX='".$edtID."'","1");
					$act_log="Update Data Calon Mahasiswa Baru ";
					$msg="Update Data Calon Mahasiswa Baru ";
				}
				if ($MySQL->exe){
					$succ=1;
				}				
		  		if ($succ==1) {
					$msg .="Berhasil!, Pastikan Anda Untuk Mencetak Bukti Pendaftaran!";
					echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
					echo $msg;
					echo "</div>";
			  		$act_log .="Sukses!";
				} else {
					$edtTglLahir=DateStr($edtTglLahir);
					$edtTglUji=DateStr($edtTglUji);
					$msg .="Gagal!, Pastikan Data Yang Anda Masukkan Benar!";
					echo "<div id='msg_err' class='diverr m5 p5 tac'>";
					echo $msg;
					echo "</div>";
					$act_log .="Gagal!";
					$new=0;
				}				
				AddLog($id_admin,$act_log);					
			} else {
				$new=0;
			}
		} else {
			$edtTglLahir= @explode("-",$edtTglLahir);
			$edtTglLahir= $edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
			$edtTglUji=@explode("-",$edtTglUji);
			$edtTglUji=$edtTglUji[2]."-".$edtTglUji[1]."-".$edtTglUji[0];
			//Lakukan proses submit
			//Cari No Pendaftaran secara otomatis
			if ($_POST['submit'] == 'Simpan'){
				$NoDaftar=GetNoDaftar($ThSms_pmb,$gelom_pmb,$kdpmb_pmb);
				$MySQL->Insert("tbpmbupy","NOFRMTBPMB,THDTRTBPMB,GLDTRTBPMB,NODTRTBPMB,NMPMBTBPMB,KDJEKTBPMB,TPLHRTBPMB,TGLHRTBPMB,KDWNITBPMB,NEGRATBPMB,ALMT1TBPMB,KELRHTBPMB,KABPTTBPMB,PROPITBPMB,TELPOTBPMB,KDPOSTBPMB,KDJENTBPMB,SKASLTBPMB,JURSNTBPMB,ALTSKTBPMB,KABSKTBPMB,PROSKTBPMB,STKRJTBPMB,NMKRJTBPMB,ALKRJTBPMB,ALMNITBPMB,ANGGTTBPMB,PLHN1TBPMB,PLHN2TBPMB,PROGRTBPMB,INFORTBPMB,STPIDTBPMB,TGUJITBPMB,SHIFTTBPMB,STREGTBPMB,PSUJITBPMB","'$edtFormulir','$ThSms_pmb','$gelom_pmb','$NoDaftar',UPPER('$edtNama'),'$rbJK','$edtLahir','$edtTglLahir','$rbNegara','$edtNegara','$edtAlamat','$edtKelurahan','$edtKota','$cbPropinsi','$edtTelp','$edtKodePos','$cbJenjang','$edtNamaPT','$edtJurusan','$edtAlamat1','$edtKota1','$cbPropinsi1','$cbPekerjaan','$edtNamaKerja','$edtAlamatKerja','$rbAlumni','$edtAnggota','$cbProdi1','$cbProdi2','$cbProgram','$cbInformasi','$cbStatus','$edtTglUji','$cbShift','$reg','$passwd'");
				$act_log="Tambah Data Calon Mahasiswa Baru ";
				$msg="Tambah Data Calon Mahasiswa Baru ";
			} else {
				$NoDaftar=$_POST["NoDaftar"];
				$edtID=$_POST['edtID'];
				$MySQL->Update("tbpmbupy","NMPMBTBPMB=UPPER('$edtNama'),KDJEKTBPMB='$rbJK',TPLHRTBPMB='$edtLahir',TGLHRTBPMB='$edtTglLahir',KDWNITBPMB='$rbNegara',NEGRATBPMB='$edtNegara',ALMT1TBPMB='$edtAlamat',KELRHTBPMB='$edtKelurahan',KABPTTBPMB='$edtKota',PROPITBPMB='$cbPropinsi',TELPOTBPMB='$edtTelp',KDPOSTBPMB='$edtKodePos',KDJENTBPMB='$cbJenjang',SKASLTBPMB='$edtNamaPT',JURSNTBPMB='$edtJurusan',ALTSKTBPMB='$edtAlamat1',KABSKTBPMB='$edtKota1',PROSKTBPMB='$cbPropinsi1',STKRJTBPMB='$cbPekerjaan',NMKRJTBPMB='$edtNamaKerja',ALKRJTBPMB='$edtAlamatKerja',ALMNITBPMB='$rbAlumni',ANGGTTBPMB='$edtAnggota',PLHN1TBPMB='$cbProdi1',PLHN2TBPMB='$cbProdi2',PROGRTBPMB='$cbProgram',INFORTBPMB='$cbInformasi',STPIDTBPMB='$cbStatus',TGUJITBPMB='$edtTglUji',SHIFTTBPMB='$cbShift',,STREGTBPMB='$reg',PSUJITBPMB='$passwd'","where IDX='".$edtID."'","1");
				$act_log="Update Data Calon Mahasiswa Baru ";
				$msg="Update Data Calon Mahasiswa Baru ";
			}
			if ($MySQL->exe){
				$succ=1;
			}				
	  		if ($succ==1) {
				$msg .="Berhasil!, Pastikan Anda Untuk Mencetak Bukti Pendaftaran!";
				echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
				echo $msg;
				echo "</div>";
		  		$act_log .="Sukses!";
		  		$submited = "Update";
			} else {
				$edtTglLahir=DateStr($edtTglLahir);
				$edtTglUji=DateStr($edtTglUji);
				$msg .="Gagal!, Pastikan Data Yang Anda Masukkan Benar!";
				echo "<div id='msg_err' class='diverr m5 p5 tac'>";
				echo $msg;
				echo "</div>";
				$act_log .="Gagal!";
				$new=0;
			}				
			AddLog($id_admin,$act_log);				
		}
	}
	
	if (($_POST['submit']=="Update") && ($succ==0)) {
		$submited="Update";
		$NoDaftar=$_POST['NoDaftar'];	
	}	
	if ($succ==1){
		$MySQL->Select("tbpmbupy.IDX,setpmbdtl.SHIFTSETPMB,setpmbdtl.WAKTUSETPMB,setpmbdtl.DURWKSETPMB","tbpmbupy","left join setpmbdtl on tbpmbupy.SHIFTTBPMB=setpmbdtl.IDX where NODTRTBPMB='".$NoDaftar."'","","1");
		$show=$MySQL->fetch_array();
		$id=$show["IDX"];
		$durasi=($show['DURWKSETPMB'] * 60);
		$waktuujian=substr($show['WAKTUSETPMB'],0,5);
		$waktuujian=New Time($waktuujian);
		$selesaiujian=$waktuujian->add($durasi);

	//Tampilkan form konfirmasi	
		echo "<form action=\"cetak_formulir_pmb.php\" method=\"post\" target=\"pdf_target\">";
		echo "<table style='width:95%' border='0' cellpadding='1' cellspacing='1'>";
		echo "<tr><td rowspan='3' style='width:10%' >";
		echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" /></td>";
    	echo "<td colspan='2' align='center'><b>Form Pendaftaran Calon Mahasiswa Baru</b></td></tr>";
  		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
  		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		$data[$i][0]="No Pendaftaran";
		$data[$i][1]=": ".$NoDaftar;
		$i++;
		$data[$i][0]="Nama Lengkap";
		$data[$i][1]=": ".$edtNama;
		$i++;
		$data[$i][0]="Alamat";
		$data[$i][1]=": ".$edtAlamat." ".$edtKelurahan." ".$edtKota." ".LoadPropinsi_X("",$cbPropinsi)." ".$edtKodePos."   Telp. ".$edtTelp;
		$i++;
		$data[$i][0]="";
		$data[$i][1]="";
		$i++;		
		$data[$i][0]="Program Studi Pilihan I";
		$data[$i][1]=": ".LoadProdi_X("",$cbProdi1);
		$i++;
		$data[$i][0]="Program Studi Pilihan II";
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
		$data[$i][1]=": ".DateStr($edtTglUji);
		$i++;
		$data[$i][0]="Jam";
		$data[$i][1]=": ".substr($show['WAKTUSETPMB'],0,5)."  s.d. ".substr($selesaiujian,0,5).", Shift ".$show["SHIFTSETPMB"]."";

		$style_width1="style='width:200px;'";
		$style_width2="style='width:250px;'";
		$sub_title = "TA ".substr($ThSms_pmb,0,4)."/".(substr($ThSms_pmb,0,4) + 1)."";	
		$sub_title .= " Sem. ".LoadKode_X("",substr($ThSms_pmb,4,1),"95")."";		
		$sub_title .= " Gel. ".$gelom_pmb."";		
		$width1="45,5,110"; // 160
		$_SESSION[PREFIX.'data1']=$data;

		$_SESSION[$PREFIX.'lembaga_instansi']=$lembg_pmb;
		$_SESSION[$PREFIX.'nip_penandatangan']=$nokyw_pmb;	
		$_SESSION[$PREFIX.'nama_penandatangan']=$nmkyw_pmb;
		echo "<input type=\"hidden\" name=\"lembaga_instansi\" value=\"".$lembg_pmb."\" />";
		echo "<input type=\"hidden\" name=\"nip_penandatangan\" value=\"".$nokyw_pmb."\" />";
		echo "<input type=\"hidden\" name=\"nama_penandatangan\" value=\"".$nmkyw_pmb."\" />";
		echo "<input type=\"hidden\" name=\"width1\" value=\"".$width1."\" />";
		echo "<input type=\"hidden\" name=\"report_title\" value=\"".$report_title."\" /
>";
		echo "<input type=\"hidden\" name=\"buktidaftar\" value=\"".$buktidaftar."\" />"; 
		echo "<input type=\"hidden\" name=\"passwd\" value=\"".$passwd."\" />";
 
		echo "<input type=\"hidden\" name=\"sub_title\" value=\"".$sub_title."\" /
>";
		echo "</table></form>";
		//Cetak Bukti Pembayaran Ujian		
?>
		  <table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
            <tr>
              <td colspan="3"><b>Identitas Diri</b> <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></td>
            </tr>
            <tr>
              <td colspan="2">No Pendaftaran</td>
              <td width="60%"> : <b><?php echo $NoDaftar; ?></b>
			  </td>
            </tr>
            <tr>
              <td colspan="2">Nama Lengkap</td>
              <td> : <?php echo $edtNama; ?></td>
            </tr>
            <tr>
              <td colspan="2">Jenis Kelamin</td>
              <td>: <?php echo LoadJK_X("","$rbJK"); ?></td>
            </tr>
            <tr>
              <td colspan="2">Tempat Lahir </td>
              <td> : <?php echo $edtLahir; ?></td>
            </tr>
            <tr>
              <td colspan="2">Tanggal Lahir </td>
              <td> : <?php echo DateStr($edtTglLahir); ?>
            </tr>
            <tr>
              <td colspan="2">Negara</td>
              <td> : <?php echo $edtNegara; ?></td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><b>Tempat Tinggal Saat Ini</b></td>
            </tr>
            <tr>
              <td colspan="2">Alamat</td>
              <td>: <?php echo $edtAlamat; ?></td>
            </tr>
            <tr>
              <td colspan="2">Kelurahan/Desa-Kecamatan</td>
              <td>: <?php echo $edtKelurahan; ?></td>
            </tr>
            <tr>
              <td colspan="2">Kabupaten/Kota</td>
              <td>: <?php echo $edtKota; ?></td>
            </tr>
            <tr>
              <td colspan="2">Propinsi</td>
              <td> :
                <?php echo LoadPropinsi_X("","$cbPropinsi"); ?></td>
            </tr>
            <tr>
              <td colspan="2">Kode Pos</td>
              <td>: <?php echo $edtKodePos; ?></td>
            </tr>
            <tr>
              <td colspan="2">Telepon</td>
              <td> : <?php echo $edtTelp; ?></td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><b>Sekolah/Pendidikan Asal <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></b></td>
            </tr>
            <tr>
              <td colspan="2">Jenjang</td>
              <td> : <?php echo LoadKode_X("","$cbJenjang","99") ?></td>
            </tr>
            <tr>
              <td colspan="2">Nama Sekolah/Perguruan Tinggi</td>
              <td> : <?php echo $edtNamaPT; ?></td>
            </tr>
            <tr>
              <td colspan="2">Program Studi/Jurusan</td>
              <td> : <?php echo $edtJurusan; ?></td>
            </tr>
            <tr>
              <td colspan="2">Alamat Sekolah</td>
              <td>: <?php echo $edtAlamat1; ?></td>
            </tr>
            <tr>
              <td colspan="2">Kabupaten/Kota</td>
              <td>: <?php echo $edtKota1; ?></td>
            </tr>
            <tr>
              <td colspan="2">Propinsi</td>
              <td> : <?php echo LoadPropinsi_X("","$cbPropinsi"); ?></td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">Pekerjaan</td>
              <td>: <?php echo LoadKode_X("","$cbPekerjaan","96") ?></td>
            </tr>
            <tr>
              <td colspan="2" >Nama Institusi Pekerjaan</td>
              <td>: <?php echo $edtNamaKerja; ?></td>
            </tr>
            <tr>
              <td colspan="2">Alamat Institusi Pekerjaan</td>
              <td>: <?php echo $edtAlamatKerja; ?></td>
            </tr>
            <tr>
              <td colspan="2">No. Anggota</td>
              <td>: <?php echo $edtAnggota; ?></td>
            </tr>
            <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><b>Program Studi Pilihan</b></td>
            </tr>
            <tr>
              <td colspan="2">Pilihan Pertama</td>
              <td>:
                <?php echo LoadProdi_X("","$cbProdi1") ?></td>
            </tr>
            <tr>
              <td colspan="2">Pilihan Kedua</td>
              <td>: <?php echo LoadProdi_X("","$cbProdi2") ?></td>
            </tr>
            <tr>
              <td colspan="2">Program/Kelas Kuliah yang Akan Diikuti</td>
              <td>: <?php echo LoadKode_X("","$cbProgram","97") ?></td>
            </tr>
            <tr>
              <td colspan="2">Memperoleh Informasi Tentang UPY dari</td>
              <td>: <?php echo LoadKode_X("","$cbInformasi","98") ?></td>
            </tr>
            <tr>
				<td colspan="2">Status Saat Mendaftar Sebagai</td>
				<td>: <?php echo LoadKode_X("","$cbStatus","06") ?>
				</td>			
			</tr>            
            <tr>
				<td colspan="2">Bersedia Mengikuti Seleksi pada Tanggal</td>
				<td>: <?php echo DateStr($edtTglUji)." &nbsp;&nbsp;&nbsp;Jam : ".substr($show['WAKTUSETPMB'],0,5)."  s.d. ".substr($selesaiujian,0,5).", Shift ".$show["SHIFTSETPMB"] ?>
				</td>			
			</tr>		
            <tr>
              <td colspan="3" >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center">
		 	  	<button type="reset"  onClick=window.location.href="./"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;              
			 	<button name="button"  onClick=window.location.href="./?page=pmbonline&amp;p=edit&amp;id=<?php echo $id; ?>"><img src="images/b_edit.png" class="btn_img"/>&nbsp;Edit&nbsp;</button>              
            </tr>            
		</table>		
<?php		
	} else {
	if (isset($_GET['p']) && $_GET['p']=='edit') {
		$edtID=$_GET['id'];
		$MySQL->Select("*","tbpmbupy","where IDX='".$edtID."'","","1");
		$show=$MySQL->fetch_array();
		$edtID=$show['IDX'];
		$edtFormulir=$show['NOFRMTBPMB'];
		$NoDaftar=$show['NODTRTBPMB'];
		$edtNama= $show["NMPMBTBPMB"];
		$rbJK= $show["KDJEKTBPMB"];
		$edtLahir= $show["TPLHRTBPMB"];
		$edtTglLahir= $show["TGLHRTBPMB"];
		$edtTglLahir= @explode("-",$edtTglLahir);
		$edtTglLahir= $edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
		$rbNegara= $show["KDWNITBPMB"];
		$edtNegara= $show["NEGRATBPMB"];
		$edtAlamat= $show["ALMT1TBPMB"];
		$edtKelurahan= $show["KELRHTBPMB"];
		$edtKota= $show["KABPTTBPMB"];
		$cbPropinsi= $show["PROPITBPMB"];
		$edtKodePos= $show["KDPOSTBPMB"];
		$edtTelp= $show["TELPOTBPMB"];
		$cbJenjang= $show["KDJENTBPMB"];
		$edtNamaPT= $show["SKASLTBPMB"];
		$edtJurusan= $show["JURSNTBPMB"];
		$edtAlamat1 = $show["ALTSKTBPMB"];
		$edtKota1=$show["KABSKTBPMB"];
		$cbPropinsi1= $show["PROSKTBPMB"];
		$cbPekerjaan= $show["STKRJTBPMB"];
		$edtNamaKerja= $show["NMKRJTBPMB"];
		$edtAlamatKerja= $show["ALKRJTBPMB"];
		$rbAlumni= $show["ALMNITBPMB"];
		$edtAnggota= $show["ANGGTTBPMB"];
		$cbProdi1= $show["PLHN1TBPMB"];
		$cbProdi2= $show["PLHN2TBPMB"];
		$cbProgram= $show["PROGRTBPMB"];
		$cbInformasi= $show["INFORTBPMB"];
		$cbStatus=$show["STPIDTBPMB"];
		$edtTglUji= $show["TGUJITBPMB"];
		$cbShift= $show["SHIFTTBPMB"];
		$mulaiujian=$currpmb[11];
		$durasi=($currpmb[12]*60);
		$TglUji=DateStr($show["TGUJITBPMB"]);		
		$edtTglUji=@explode("-",$edtTglUji);
		$edtTglUji=$edtTglUji[2]."-".$edtTglUji[1]."-".$edtTglUji[0];	
		$OldTgl= $show["TGUJITBPMB"];
		$OldTgl=@explode("-",$OldTgl);
		$OldTgl=$OldTgl[2]."-".$OldTgl[1]."-".$OldTgl[0];
		$OldShift= $show["SHIFTTBPMB"];
		$submited="Update";
		$new=0;
	}
	$Get_Akses_PMB=Get_Akses_PMB($curr_date);
	if ($Get_Akses_PMB) {
		if (($new==1)){
			$edtFormulir=SetNoForm($kdfrm_pmb);
			//$NoDaftar="";
			$edtNama="";
			$rbJK="";
			$edtLahir="";
			$edtTglLahir="";
			$rbNegara="";
			$edtNegara="";
			$edtAlamat="";
			$edtKelurahan="";
			$edtKota="";
			$cbPropinsi="";
			$edtKodePos="";
			$edtTelp="";
			$cbJenjang="";
			$edtNamaPT="";
			$edtJurusan="";
			$edtAlamat1="";
			$edtKota1="";
			$cbPropinsi1="";
			$cbPekerjaan="";
			$edtNamaKerja="";
			$edtAlamatKerja="";
			$rbAlumni="";
			$edtAnggota="";
			$cbProdi1="";
			$cbProdi2="";
			$cbProgram="";
			$cbInformasi="";
			$cbStatus="";
			$edtTglUji="";
			$cbShift="";
			$OldTgl="";
			$OldShift="";
			$submited="Simpan";			
		}
		if ($metod_pmb==0){	
			$TglSeleksi = "<input type='text' name='edtTglUji' size='10'  maxlength='10'  value='$edtTglUji' required = '1' realname = 'Tanggal Ujian' />";
			$TglSeleksi .= "<a href=\"javascript:show_calendar('document.form1.edtTglUji','document.form1.edtTglUji',document.form1.edtTglUji.value);\"> <img src='include/calendar/cal.gif' alt='CAL' title='Klik untuk memunculkan kalender' border='0' height='16' width='16' align='absMiddle'></a> dd-mm-yyyy";
		} else {
			$ujian_pmb=@explode("-",$ujian_pmb);
			$ujian_pmb=$ujian_pmb[2]."-".$ujian_pmb[1]."-".$ujian_pmb[0];
			$TglSeleksi="<input type='text' name='edtTglUji' size='10' maxlength='10' value='$ujian_pmb' readonly />";
		}		
?>

		<form name="form1" action="./?page=pmbonline" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
		<input type="hidden" name="NoDaftar" value="<?php echo $NoDaftar; ?>" />
		<input type="hidden" name="OldTgl" value="<?php echo $OldTgl; ?>" />
		<input type="hidden" name="OldShift" value="<?php echo $OldShift; ?>" />
		<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan='3' >FORMULIR PENDAFTARAN CALON MAHASISWA BARU</th></tr>
			<tr><td colspan='3' >&nbsp;</td>
			</tr>
			<tr><td colspan='3' >&nbsp;</td></tr>
			<tr>
				<td colspan="3" align="right">No Formulir : <?php echo $edtFormulir; ?>
				<input size="14" maxlength="14" type="hidden" name="edtFormulir" value="<?php echo $edtFormulir; ?>" />
				</td>
			</tr>
		    <tr>
		      <td colspan="3"><b>Identitas Diri</b> <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></td>
		    </tr>
		    <tr>
		      <td colspan="2">Nama Lengkap</td>
		      <td class="mandatory"> :
		        <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30" value="<?php echo $edtNama; ?>" required = "1"  regexp ="/^\w/" realname = "Nama" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Jenis Kelamin</td>
		      <td>:
		        <?php LoadJK_X("rbJK","$rbJK"); ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Tempat Lahir </td>
		      <td> :
		        <input size="20" type="text" name="edtLahir" maxlength="20" value="<?php echo $edtLahir; ?>" required = "1"  regexp ="/^\w/" realname = "Tempat Lahir" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Tanggal Lahir </td>
		      <td> :
		        <input type="text" name="edtTglLahir" size="10"  maxlength="10" value="<?php echo $edtTglLahir; ?>" required = "1"  realname = "Tanggal Lahir" />
		          <a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglLahir',document.form1.edtTglLahir.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle" /></a> dd-mm-yyyy </td>
		    </tr>
		    <tr>
		      <td colspan="2">Kewarganegaraan</td>
		      <td> :
		<?php
					$WN1="";
					$WN0="";
					if ($rbNegara=="1"){
						$WN1="Checked";	
					}
					if ($rbNegara=="0"){
						$WN0="Checked";	
					}					
				    echo "<input name='rbNegara' type='radio' value='1' $WN1 required = '1' realname='Kewarganegaraan'; />WNI&nbsp;";
				    echo "<input name='rbNegara' type='radio' value='0' $WN0 />WNA";
		?>
		     </td>
		    </tr>
		    <tr>
		      <td colspan="2">Negara</td>
		      <td> :
		        <input size="20" type="text" name="edtNegara" maxlength="20" value="<?php echo $edtNegara; ?>" />
		          <span style='font-size:11px; font-weight:normal;'>Diisi Apabila status kewarganegaraan WNA</span></td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		    </tr>
		    <tr>
		      <td colspan="2"><b>Tempat Tinggal Saat Ini</b></td>
		    </tr>
		    <tr>
		      <td colspan="2">Alamat</td>
		      <td>:
		        <input size="30" type="text" name="edtAlamat" maxlength="30" value="<?php echo $edtAlamat; ?>" required = "1"  regexp ="/^\w/" realname = "Alamat Tempat Tinggal" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Kelurahan/Desa-Kecamatan</td>
		      <td>:
		        <input size="20" type="text" name="edtKelurahan" maxlength="20" value="<?php echo $edtKelurahan; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Kabupaten/Kota</td>
		      <td>:
		        <input size="20" type="text" name="edtKota" maxlength="20" value="<?php echo $edtKota; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Propinsi</td>
		      <td> :
		        <?php LoadPropinsi_X("cbPropinsi","$cbPropinsi","required = '1' exclude='-1' err='Pilih Salah Satu Dari Daftar Propinsi yang Ada!'"); ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Kode Pos</td>
		      <td>:
		        <input size="5" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Telepon</td>
		      <td> :
		        <input size="20" type="text" name="edtTelp" maxlength="20" value="<?php echo $edtTelp; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		    </tr>
		    <tr>
		      <td colspan="3"><b>Sekolah/Pendidikan Asal <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></b></td>
		    </tr>
		    <tr>
		      <td colspan="2">Jenjang</td>
		      <td> :
		        <?php LoadKode_X("cbJenjang","$cbJenjang","99","required = '1' exclude='-1' err='Pilih Salah Satu Dari Daftar Jenjang Studi yang Ada!'") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Nama Sekolah/Perguruan Tinggi</td>
		      <td> :
		        <input size="30" type="text" name="edtNamaPT" maxlength="30" value="<?php echo $edtNamaPT; ?>" required = '1' realname ='Nama Sekolah/PT Asal' regexp ="/^\w/"  /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Program Studi/Jurusan</td>
		      <td> :
		        <input size="30" type="text" name="edtJurusan" maxlength="30" value="<?php echo $edtJurusan; ?>"  required = '1' realname ='Jurusan/Program Studi Sekolah Asal' regexp ="/^\w/" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Alamat Sekolah</td>
		      <td>:
		        <input size="30" type="text" name="edtAlamat1" maxlength="30" value="<?php echo $edtAlamat1; ?>"  required = '1' realname ='Alamat Sekolah' regexp ="/^\w/"  /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Kabupaten/Kota</td>
		      <td>:
		        <input size="20" type="text" name="edtKota1" maxlength="20" value="<?php echo $edtKota1; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Propinsi</td>
		      <td> :
		        <?php LoadPropinsi_X("cbPropinsi1","$cbPropinsi","required = '1' exclude='-1' err='Pilih Salah Satu Dari Daftar Propinsi yang Ada!'"); ?></td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		    </tr>
		    <tr>
		      <td colspan="2">Pekerjaan</td>
		      <td>:
		        <?php LoadKode_X("cbPekerjaan","$cbPekerjaan","96") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2" >Nama Institusi Pekerjaan</td>
		      <td class="mandatory">:
		        <input size="30" type="text" name="edtNamaKerja" maxlength="30" value="<?php echo $edtNamaKerja; ?>" />
		          <span style='font-size:10px; font-weight:normal;'>Biarkan Kosong Bila Tidak Sedang Bekerja</span></td>
		    </tr>
		    <tr>
		      <td colspan="2">Alamat Institusi Pekerjaan</td>
		      <td class="mandatory">:
		        <input size="30" type="text" name="edtAlamatKerja" maxlength="30" value="<?php echo $edtAlamatKerja; ?>" />
		          <span style='font-size:10px; font-weight:normal;'>Biarkan Kosong Bila Tidak Sedang Bekerja</span></td>
		    </tr>
		    <tr>
		      <td colspan="2">Alumni Sekolah PGRI/Anggota PGRI</td>
		      <td>:
		<?php
					$AL1="";
					$AL0="";
					if ($rbAlumni=="1"){
						$AL1="Checked";	
					}
					if ($rbAlumni=="0"){
						$AL0="Checked";	
					}					
				    echo "<input name='rbAlumni' type='radio' value='1' $AL1 required = '1' realname='Alumni Sekolah PGRI';  />Ya&nbsp;";
				    echo "<input name='rbAlumni' type='radio' value='0' $AL0 />Tidak";
		?>
			  </td>
		    </tr>
		    <tr>
		      <td colspan="2">No. Anggota</td>
		      <td class="mandatory">:
		        <input size="11" type="text" name="edtAnggota" maxlength="11" value="<?php echo $edtAnggota; ?>" />
		          <span style='font-size:10px; font-weight:normal;'>Diisi Apabila Tercatat sebagai Anggota PGRI</span></td>
		    </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		    </tr>
		    <tr>
		      <td colspan="3"><b>Program Studi Pilihan</b></td>
		    </tr>
		    <tr>
		      <td colspan="2">Pilihan Pertama</td>
		      <td>:
		        <?php LoadProdi_X("cbProdi1","$cbProdi1","","required='1' exclude='-1' err = 'Pilih Salah Satu Program Studi yang Ada!'") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Pilihan Kedua</td>
		      <td>:
		        <?php LoadProdi_X("cbProdi2","$cbProdi2") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Program/Kelas Kuliah yang Akan Diikuti</td>
		      <td>:
		        <?php LoadKode_X("cbProgram","$cbProgram","97","required = '1' exclude='-1' err='Pilih Salah Satu Dari Program yang Ada!'") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Memperoleh Informasi Tentang UPY dari</td>
		      <td class="mandatory">:
		        <?php LoadKode_X("cbInformasi","$cbInformasi","98","required = '1' exclude='-1' err='Pilih Salah Satu Dari Daftar Informasi yang Ada!'") ?></td>
		    </tr>
		    <tr>
				<td colspan="2">Status Saat Mendaftar Sebagai</td>
				<td>: <?php LoadKode_X("cbStatus","$cbStatus","06","required = '1' exclude='-1' err='Pilih Salah Satu Dari Daftar Status yang Ada!'") ?>
				</td>			
			</tr>	            
		    <tr>
				<td colspan="2">Bersedia Mengikuti Seleksi pada Tanggal</td>
				<td>: 
<?php
					echo $TglSeleksi;
?>
				</td>
			</tr>
			<tr>
				<td colspan="2">Shift</td>
				<td>:
<?php
	$sel0="";
	$sel1="";
	$sel2="";
	$sel3="";
if ($cbShift=="") {$sel0= 'selected="selected"';} 	
if ($cbShift=="26") {$sel1= 'selected="selected"';} 	
if ($cbShift=="27") {$sel2= 'selected="selected"';} 	
if ($cbShift=="28") {$sel3= 'selected="selected"';} 	
	
?>				 
				<select name="cbShift" id="cbShift"  required = "1"  realname = "Shift">
				<option value="" <?php echo $sel0; ?> >--- Shift ---</option>
				<option value="26" <?php echo $sel1; ?> >Shift 1 (08:00 - 10:00)</option>
				<option value="27" <?php echo $sel2; ?> >Shift 2 (10:30 - 12:30)</option>
				<option value="28" <?php echo $sel3; ?> >Shift 3 (13:00 - 15:00)</option>
				</select>
<?php
//					echo LoadShift_X('cbShift',"$cbShift","$idpmb_pmb");
?>
				</td>


			</tr>
		    <tr>
		      <td colspan="3" >&nbsp;</td>
		    </tr>
		    <tr>
		      <td colspan="3" align="center">
		 	  <button type="reset"  onClick=window.location.href="./"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;		      
			  <button type="submit"  name="submit"  value="<?php echo $submited; ?>"><img src="images/b_save.gif" class="btn_img"/>&nbsp;<?php echo $submited; ?></button></td>
		    </tr>            
		</table>
		<br />
		</form>
<?php
		}
	}
}

function Get_Akses_PMB($Tgl) {
	global $MySQL;
	$MySQL->Select("MIN(setpmbupy.TGAWLSETPMB) AS TGLAWAL,MAX(setpmbupy.TGAKHSETPMB) AS TGLAKHIR","setpmbupy","GROUP BY setpmbupy.TAPMBSETPMB","setpmbupy.TAPMBSETPMB DESC","1");
	$show=$MySQL->fetch_array();
	$curr_date = New Date($Tgl);
	$curr_akses=$curr_date->isBetween($show["TGLAWAL"],$show["TGLAKHIR"]);
	//Jika TglUji tidak diantara tanggal yang ditetapkan Mendapatkan Hak akses
	if ($curr_akses){
		return True;
	} else {
		echo "<div class='diverr m5 p5 tac'>";
		echo "MAAF!, Pendaftaran Untuk Tahun Semester Berjalan Tidak Diijinkan!";
		echo "</div>";
		echo "<div style='text-align:center; -moz-opacity:0.1;'>";
		echo "<img alt='gambar' style='margin:width:250px; height:250px; filter:alpha(opacity=10);'  src='";
		echo $_SESSION[$PREFIX.'LGPTIMSPTI']."' border='0' /></div>";
		return False;
	}
}


function Get_Curr_PMB($Tgl) {
	global $MySQL;
	$MySQL->Select("*","setpmbupy","where TGAWLSETPMB <= '".$Tgl."' and TGAKHSETPMB  >='".$Tgl."'","","1");
	$show=$MySQL->fetch_array();
	$curr_pmb=$show['KDPMBSETPMB'].",".$show['KDFRMSETPMB'].",".$show['TAPMBSETPMB'].",".$show['GEPMBSETPMB'].",".$show['TGAWLSETPMB'].",".$show['TGAKHSETPMB'].",".$show['TGREGSETPMB'].",".$show['LGPMBSETPMB'].",".$show['NIKKASETPMB'].",".$show['NMPMBSETPMB'].",".$show['METODSETPMB'].",".$show['TGUJISETPMB'].",".$show['KAPSTSETPMB'].",".$show['IDX'];
	return $curr_pmb;
}


function SetNoForm($kd) {
	global $MySQL;
	//Insert tabel frpmbupy untuk dijadikan pengontrol
	$MySQL->Select("count(*) as FORMULIR","frpmbupy","WHERE KDFRMFRPMB ='".$kd."'","","1");
    $show=$MySQL->Fetch_Array();
	$NoForm= $show["FORMULIR"] + 1;    
	$MySQL->Insert("frpmbupy","KDFRMFRPMB,NOFRMFRPMB","'$kd','$NoForm'");
//	Ambil no Formulir dan ditampilkan	
	$MySQL->Select("*","frpmbupy","where KDFRMFRPMB='$kd' and NOFRMFRPMB='$NoForm'","","1");
	$show=$MySQL->fetch_array();
	$curr_form=$show['KDFRMFRPMB']."-".$show['NOFRMFRPMB'];
	return $curr_form;
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
		$seleksi = New Date($TglUji);
		$Tgl_Uji=$seleksi->isBetween($mulaipmb,$akhirpmb);
		if (!$Tgl_Uji){
			echo "<div id='msg_err' class='diverr m5 p5 tac'>Pelaksanaan Test Masuk Perguruan Tinggi dimulai ".DateStr($mulaipmb)." s.d ".DateStr($akhirpmb)."<br>Pastikan Anda Untuk Merubah Tanggal Kesediaan Anda Untuk Mengikuti Test<br></div>";
			return false;
		} else {
			$MySQL->Select("COUNT(*) as jumlah","tbpmbupy","where (TGUJITBPMB='".$TglUji."' and SHIFTTBPMB='".$shift."')");
			$show=$MySQL->fetch_array();
			$jumlah=$show['jumlah'];
			print_r($jumlah);
			print_r($kapasitas);
			if ($jumlah < $kapasitas) {
				return true;
			} else {
				echo "<div id='msg_err' class='diverr m5 p5 tac'>Maaf, Kapasitas Tempat Pelaksanaan Test PMB Untuk Tanggal ".DateStr($TglUji)." Shift tersebut telah Terpenuhi!<br>Pastikan Anda Untuk Memasukkan Tanggal/Shift Lainnya</div>";
				//echo $MySQL->qry." -- $kapasitas";	
				return false;
			}
		}
	}
}

function GetNoDaftar($ThSms_pmb,$gelom_pmb,$kdpmb_pmb) {
	global $MySQL;
	$MySQL->Select("MAX(NODTRTBPMB) as LASTDAFTAR","tbpmbupy","WHERE (THDTRTBPMB='".$ThSms_pmb."' AND GLDTRTBPMB='".$gelom_pmb."')","","");
	$show=$MySQL->fetch_array();
	$last_daftar=$show['LASTDAFTAR'];
	$last_daftar=@explode("-",$last_daftar);
	$curr_daftar=$last_daftar[1] + 1;
	$nodaftar=$kdpmb_pmb."-".substr_replace('0000',$curr_daftar,(strlen('0000') - strlen($curr_daftar)),strlen($curr_daftar));
	return $nodaftar;
}

function LoadShift_X($nama="",$val="",$idpmb="") {
	global $MySQL;
	if ($nama != "") {
		$MySQL->Select("IDX,SHIFTSETPMB,WAKTUSETPMB,DURWKSETPMB","setpmbdtl","where setpmbdtl.IDPMBSETPMB='".$idpmb."'","setpmbdtl.SHIFTSETPMB ASC","");

		$shift_x = "<select name='$nama' id='$nama'>";
    	$sel0="";
		if ($val=="") $sel0="selected='selected'";
		$shift_x .= "<option value='' $sel0 >--- Shift ---</option>";
    	while ($show=$MySQL->Fetch_Array()) {
    		$sel="";
			$awalshift = substr($show['WAKTUSETPMB'],0,5);
			$timeshift = explode(':',$awalshift);
			$durasi = ($show['DURWKSETPMB'] * 60);
			$akhirshift = mktime($timeshift[0],$timeshift[1],0,0,0,0,99) + $durasi;
			if ($show["IDX"] == $val) $sel="selected='selected'";        		
        	$shift_x .= "<option value='".$show["IDX"]."' $sel >Shift ".$show["SHIFTSETPMB"]." (".$awalshift." - ".strftime('%H:%M',$akhirshift).")</option>";
    	}
    	
    	$shift_x .= "</select>";
	} else {
		$MySQL->Select("IDX,SHIFTSETPMB,WAKTUSETPMB,DURWKSETPMB","setpmbdtl","WHERE IDX='".$val."'","","1");
    	$show=$MySQL->Fetch_Array();
		$awalshift = substr($show['WAKTUSETPMB'],0,5);
		$timeshift = explode(':',$awalshift);
		$durasi = ($show['DURWKSETPMB'] * 60);
		$akhirshift = mktime($timeshift[0],$timeshift[1],0,0,0,0,99) + $durasi;
		$shift_x = 'Shift '.$show["SHIFTSETPMB"];
		$shift_x = ' ('.$awalshift.' - '.strftime('%H:%M',$akhirshift).')';
	}
	return $shift_x;
}
?>