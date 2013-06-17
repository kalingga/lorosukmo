<?php
$idpage='25';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$MySQL->Select("IDX,SHIFTSETPMB,WAKTUSETPMB,DURWKSETPMB","setpmbdtl","where setpmbdtl.IDPMBSETPMB='".$idpmb_pmb."'","setpmbdtl.SHIFTSETPMB ASC","");
	$jml_shift_pmb=$MySQL->num_rows();
	$i=0;
	while ($show=$MySQL->fetch_array()) {
		$shift[$i][0]=$show['IDX'];
		$shift[$i][1]=$show['SHIFTSETPMB'];
		$shift[$i][2]=substr($show['WAKTUSETPMB'],0,5);
		$durasi=($show['DURWKSETPMB'] * 60);
		$waktuujian=New Time($shift[$i][2]);
		$shift[$i][3]=$waktuujian->add($durasi);
		$i++;
	}	
	
	$durasi=($duras_pmb * 60);
	$waktuujian= New Time($waktu_pmb);
	$selesaiujian=$waktuujian->add($durasi);	

	if ((isset($_GET['p']) && ($_GET['p']=='edit')) || (isset($_POST['submit']))) {
		$edtID=$_GET['id'];
		if (isset($_POST['submit'])){
			$edtID=$_POST['edtID'];
			if ($_POST['submit']=='acc'){
				$NoDaftar=$_POST['NoDaftar'];
				$passwd=RandomKey("8","");
				$MySQL->Update("tbpmbupy","STREGTBPMB='1',PSUJITBPMB='$passwd'","where IDX=".$edtID,"1");
				$msg ="<div id='msg_err' class='diverr m5 p5 tac'>Data Calon Mahasiswa Bersangkutan, Gagal Disetujui</div>";
				$act_log="Regristrasi ID='$edtID' Pada Tabel 'tbpmbupy' File 'daftarcmb.php ";
				if ($MySQL->exe){
					$msg ="<div id='msg_err' class='divsucc m5 p5 tac'>Data Calon Mahasiswa Bersangkutan, Berhasil Disetujui</div>";
					$succ=1;
				}			
				// perintah SQL berhasil dijalankan
			} else {
				$edtFormulir=substr(strip_tags($_POST["edtFormulir"]),0,14);
				$edtNama= strtoupper(substr(strip_tags($_POST["edtNama"]),0,30));
				$rbJK= substr(strip_tags($_POST["rbJK"]),0,1);
				$edtLahir= substr(strip_tags($_POST["edtLahir"]),0,20);
				$edtTglLahir= substr(strip_tags($_POST["edtTglLahir"]),0,10);
				$edtTglLahir= @explode("-",$edtTglLahir);
				$edtTglLahir= $edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
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
				$cbShift= $_POST["cbShift"];
				$OldTgl= $_POST["OldTgl"];
				$OldShift= $_POST["OldShift"];
				//Cek batasan keberhasilan untuk input data meliputi pemilihan tanggal ujian dan kapasitas maksimal tiap gelombang pelaksanaan pmb tiap-tiap tahun semester berjalan
			
				if ($metod_pmb==0) {
					$cek=Cek_Submit($edtTglUji,$mulai_pmb,$akhir_pmb,$kpsts_pmb,$cbShift,$OldTgl,$OldShift);
					if ($cek) {
						$edtTglUji=@explode("-",$edtTglUji);
						$edtTglUji=$edtTglUji[2]."-".$edtTglUji[1]."-".$edtTglUji[0];	
						//Lakukan proses submit
						//Cari No Pendaftaran secara otomatis
		
						$NoDaftar=$_POST["NoDaftar"];
						$edtID=$_POST['edtID'];
						$MySQL->Update("tbpmbupy","NMPMBTBPMB=UPPER('$edtNama'),KDJEKTBPMB='$rbJK',TPLHRTBPMB='$edtLahir',TGLHRTBPMB='$edtTglLahir',KDWNITBPMB='$rbNegara',NEGRATBPMB='$edtNegara',ALMT1TBPMB='$edtAlamat',KELRHTBPMB='$edtKelurahan',KABPTTBPMB='$edtKota',PROPITBPMB='$cbPropinsi',TELPOTBPMB='$edtTelp',KDPOSTBPMB='$edtKodePos',KDJENTBPMB='$cbJenjang',SKASLTBPMB='$edtNamaPT',JURSNTBPMB='$edtJurusan',ALTSKTBPMB='$edtAlamat1',KABSKTBPMB='$edtKota1',PROSKTBPMB='$cbPropinsi1',STKRJTBPMB='$cbPekerjaan',NMKRJTBPMB='$edtNamaKerja',ALKRJTBPMB='$edtAlamatKerja',ALMNITBPMB='$rbAlumni',ANGGTTBPMB='$edtAnggota',PLHN1TBPMB='$cbProdi1',PLHN2TBPMB='$cbProdi2',PROGRTBPMB='$cbProgram',INFORTBPMB='$cbInformasi',STPIDTBPMB='$cbStatus',TGUJITBPMB='$edtTglUji', SHIFTTBPMB='$cbShift'","where IDX='".$edtID."'","1");
						$msg=$msg_edit_data;
						$act_log="Update ID='$edtID' Pada Tabel 'tbpmbupy' File 'daftarcmb.php ";
						if ($MySQL->exe){
							$succ=1;
						}				
					}
				}
			}
	  		if ($succ==1) {
				$act_log .="Sukses!";
				AddLog($id_admin,$act_log);
				echo $msg;
		  		$submited = "Update";
			} else {
				$edtTglLahir=DateStr($edtTglLahir);
				$edtTglUji=DateStr($edtTglUji);
				$act_log .="Gagal!";
				AddLog($id_admin,$act_log);
				echo $msg_update_0;
				$new=0;
			}				
		}		
		
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
		$edtTglUji=@explode("-",$edtTglUji);
		$edtTglUji=$edtTglUji[2]."-".$edtTglUji[1]."-".$edtTglUji[0];	
		$cbShift= $show["SHIFTTBPMB"];
		if (($edtTglUji=="00-00-0000") || ($edtTglUji=="0000-00-00")) $edtTglUji="";
		$TglUji=DateStr($show["TGUJITBPMB"]);		
		$passwd=$show["PSUJITBPMB"];
		$reg=$show["STREGTBPMB"];
		$OldTgl=$show["TGUJITBPMB"];
		$OldTgl=@explode("-",$OldTgl);
		$OldTgl=$OldTgl[2]."-".$OldTgl[1]."-".$OldTgl[0];
		$OldShift= $show["SHIFTTBPMB"];

		$submited="Update";

		$MySQL->Select("tbpmbupy.IDX,setpmbdtl.SHIFTSETPMB,setpmbdtl.WAKTUSETPMB,setpmbdtl.DURWKSETPMB","tbpmbupy","left join setpmbdtl on tbpmbupy.SHIFTTBPMB=setpmbdtl.IDX where tbpmbupy.IDX='".$edtID."'","","1");
		$show=$MySQL->fetch_array();
		$id=$show["IDX"];
		$durasi=($show['DURWKSETPMB'] * 60);
		$waktuujian=substr($show['WAKTUSETPMB'],0,5);
		$waktuujian=New Time($waktuujian);
		$selesaiujian=$waktuujian->add($durasi);
		
	//Tampilkan form cetak
		echo "<form action=\"cetak_formulir_pmb.php\" method=\"post\" target=\"pdf_target\">";
		echo "<table style='width:95%' border='0' cellpadding='1' cellspacing='1'>";
		echo "<tr><td rowspan='3' style='width:10%' >";
		echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" /></td>";
    	echo "<td colspan='2' align='center'><b>FORM PENDAFTARAN CALON MAHASISWA BARU</b></td></tr>";
  		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
  		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		$report_title="KARTU UJIAN SELEKSI CALON MAHASISWA BARU ";			
		$data[$i][0]="No Pendaftaran";
		$data[$i][1]=": ".$NoDaftar;
		$i++;
		$data[$i][0]="Nama Lengkap";
		$data[$i][1]=": ".$edtNama;
		$i++;
		$data[$i][0]="Alamat";
		$data[$i][1]=": ".$edtAlamat." ".$edtKelurahan." ".$edtKota." ".LoadPropinsi_X("",$cbPropinsi)." ".$edtKodePos;//."   Telp. ".$edtTelp;
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
		$data[$i][1]=": ".$edtTglUji;
		$i++;
		$data[$i][0]="Jam";
		$data[$i][1]=": ".substr($show['WAKTUSETPMB'],0,5)."  s.d. ".substr($selesaiujian,0,5).", Shift ".$show["SHIFTSETPMB"]."";

		$style_width1="style='width:200px;'";
		$style_width2="style='width:250px;'";
		$buktidaftar="0";
		$sub_title = "TA ".substr($ThSms_pmb,0,4)."/".(substr($ThSms_pmb,0,4) + 1)."";	
		$sub_title .= " Sem. ".LoadKode_X("",substr($ThSms_pmb,4,1),"95")."";		
		$sub_title .= " Gel. ".$gelombang."";		
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
 
		echo "<input type=\"hidden\" name=\"sub_title\" value=\"".$sub_title."\" /
>";
		echo "<input type=\"hidden\" name=\"passwd\" value=\"".$passwd."\" /
>";
		echo "</table></form>";
		//Cetak Bukti Pembayaran Ujian			
?>
		<form name="form1" action="./?page=daftarcmb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
		<input type="hidden" name="NoDaftar" value="<?php echo $NoDaftar; ?>" />
		<input type="hidden" name="OldTgl" value="<?php echo $OldTgl; ?>" />
		<input type="hidden" name="OldShift" value="<?php echo $OldShift; ?>" />
		<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
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
		        <?php LoadPropinsi_X("cbPropinsi","$cbPropinsi"); ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Kode Pos</td>
		      <td>:
		        <input size="5" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>" /></td>
		    </tr>
<?
/*
		    echo '<tr>
		      <td colspan="2">Telepon</td>
		      <td> :
		        <input size="20" type="text" name="edtTelp" maxlength="20" value="" /></td>
		    </tr>'; // <?php echo $edtTelp; ?>
*/
?>
		    <tr>
		      <td colspan="3">&nbsp;</td>
		    </tr>
		    <tr>
		      <td colspan="3"><b>Sekolah/Pendidikan Asal <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></b></td>
		    </tr>
		    <tr>
		      <td colspan="2">Jenjang</td>
		      <td  required="1" exclude="-1"> :
		        <?php LoadKode_X("cbJenjang","$cbJenjang","99") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Nama Sekolah/Perguruan Tinggi</td>
		      <td> :
		        <input size="30" type="text" name="edtNamaPT" maxlength="30" value="<?php echo $edtNamaPT; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Program Studi/Jurusan</td>
		      <td> :
		        <input size="30" type="text" name="edtJurusan" maxlength="30" value="<?php echo $edtJurusan; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Alamat Sekolah</td>
		      <td>:
		        <input size="30" type="text" name="edtAlamat1" maxlength="30" value="<?php echo $edtAlamat1; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Kabupaten/Kota</td>
		      <td>:
		        <input size="20" type="text" name="edtKota1" maxlength="20" value="<?php echo $edtKota1; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">Propinsi</td>
		      <td> :
		        <?php LoadPropinsi_X("cbPropinsi1","$cbPropinsi"); ?></td>
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
		        <?php LoadProdi_X("cbProdi1","$cbProdi1") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Pilihan Kedua</td>
		      <td>:
		        <?php LoadProdi_X("cbProdi2","$cbProdi2") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Program/Kelas Kuliah yang Akan Diikuti</td>
		      <td>:
		        <?php LoadKode_X("cbProgram","$cbProgram","97") ?></td>
		    </tr>
		    <tr>
		      <td colspan="2">Memperoleh Informasi Tentang UPY dari</td>
		      <td class="mandatory">:
		        <?php LoadKode_X("cbInformasi","$cbInformasi","98") ?></td>
		    </tr>
		    <tr>
				<td colspan="2">Status Saat Mendaftar Sebagai</td>
				<td>: <?php LoadKode_X("cbStatus","$cbStatus","06") ?>
				</td>			
			</tr>	            
		    <tr>
				<td colspan="2">Bersedia Mengikuti Seleksi pada Tanggal</td>
		        <td>: <input type="text" name="edtTglUji" size="10"  maxlength="10" value="<?php echo $edtTglUji; ?>" required = "1"  realname = "Tanggal Lahir" />
		          <a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglUji',document.form1.edtTglUji.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle" /></a> dd-mm-yyyy
<?php
/*					echo "&nbsp;&nbsp;&nbsp;Shift : 
						<select name='cbShift' id='cbShift' required = '1' exclude='0' err='Pilih Salah Satu Dari Daftar Shift yang Ada!' >
						<option value='0'> -- Shift -- </option>";
						for ($i=0;$i < $jml_shift_pmb;$i++) {
							$sel[$i]="";
							if ($shift[$i][0]==$cbShift) $sel[$i]="selected='selected'";
							echo "<option value='".$shift[$i][0]."' $sel[$i]>Shift ".$shift[$i][1]."  [".$shift[$i][2]." s.d. ".$shift[$i][3]."]</option>";
						}
					echo "</select>";*/

?>		
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
		 	  <button type="reset"  onClick=window.location.href="./?page=daftarcmb"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;		      
			  <button type="submit"  name="submit"  value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img"/>&nbsp;<?php echo $submited; ?></button>
<?php
			 if ($reg=="0" || $reg=="" || is_null($reg)) {
			 	echo "<button type='submit' name='submit' value='acc' /><img src='images/b_save.gif' class='btn_img'/>&nbsp;Disetujui</button>";
			 }
?>			  
			  </td>
		    </tr>            
		</table>
		<br>
		</form>
<?php				
	} else {
		echo "<form action='./?page=daftarcmb' method='post' >";
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Mahasiswa Baru TA Sebelumnya : ";
	    echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester","$cbSemester");			
	    echo "&nbsp;&nbsp;Gel. : <input type='text' size='4' maxlength='4' name='gelombang' value='".$gelombang."'/>&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
	    echo "</tr></table></form>";
		echo "<form action='./?page=daftarcmb' method='post' ><table><tr><td style='width:550px'>";
		echo "Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='NODTRTBPMB') $sel1="selected='selected'";
		if ($field=='NMPMBTBPMB') $sel2="selected='selected'";
		if ($field=='mspstupy.NMPSTMSPST') $sel3="selected='selected'";
		if ($field=='mspstupy1.NMPSTMSPST') $sel4="selected='selected'";
	    if ($field=='TGUJITBPMB') $sel5="selected='selected'";
	
	    echo "<option value='NODTRTBPMB' $sel1 >NO PENDAFTARAN</option>";
	    echo "<option value='NMPMBTBPMB' $sel2 >CALON MAHASISWA</option>";
	    echo "<option value='mspstupy.NMPSTMSPST' $sel3 >PILIHAN 1</option>";
	    echo "<option value='mspstupy1.NMPSTMSPST' $sel4 >PILIHAN 2</option>";
	    echo "<option value='TGUJITBPMB' $sel5 >TANGGAL SELEKSI</option>";
	     
	    echo "</select>";
	    echo "<input type='text' name='key' size='35' value='".$_REQUEST['key']."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "<td align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=daftarcmb&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	    echo "</td></tr></table></form>";
	
	  	$qry="LEFT OUTER JOIN mspstupy ON (tbpmbupy.PLHN1TBPMB = mspstupy.IDPSTMSPST) 
		  LEFT OUTER JOIN mspstupy mspstupy1 ON (tbpmbupy.PLHN2TBPMB = mspstupy1.IDPSTMSPST) 
		  WHERE tbpmbupy.THDTRTBPMB = '$ThSms_pmb' AND tbpmbupy.GLDTRTBPMB = '$gelombang'";
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
			if ($field=="TGUJITBPMB"){
				$key= rtrim($key);
				$tgl=$key;
				$key=@explode("-",$key);
				$key=$key[2]."-".$key[1]."-".$key[0];
			}
	  		$qry .= " and ".$field." like '".$key."'";			
		}
		$MySQL->Select("tbpmbupy.*,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2","tbpmbupy",$qry,"IDX ASC","","0");
	    $total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
		$MySQL->Select("tbpmbupy.IDX,tbpmbupy.NODTRTBPMB,tbpmbupy.NMPMBTBPMB,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2,tbpmbupy.TGUJITBPMB,tbpmbupy.STREGTBPMB","tbpmbupy",$qry,"tbpmbupy.IDX ASC","$start,$perpage");
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
	    echo "<tr><th colspan='7' style='background-color:#EEE'>Daftar Calon Mahasiswa TA. ".$ThnAjaran."/".($ThnAjaran+1)." Sem. ".$cbSemester." Gel. ".$gelombang."</th></tr>";
	    echo "<tr>
	    <th style='width:75px;' rowspan='2'>NO. PENDAFTARAN</th> 
	    <th rowspan='2'>CALON MAHASISWA</th> 
	    <th colspan=2>PROGRAM STUDI PILIHAN</th> 
	    <th rowspan='2' style='width:100px;'>TANGGAL SELEKSI</th>
	    <th style='width:50px;' rowspan='2'>KARTU UJIAN</th>
	    <th style='width:20px;' rowspan='2'>ACT</th>
	    </tr>";
	    echo "<tr>
	    <th style='width:200px;'>Pilihan I</th> 
	    <th style='width:200px;'>Pilihan II</th> 
	    </tr>";
		if ($MySQL->Num_Rows() > 0){
		    while ($show=$MySQL->Fetch_Array()){
		    	$sel="";
				if ($no % 2 == 1) $sel="sel";
				//$PILIHAN2= LoadProdi_X("",$show['PLHN2TBPMB']);
		     	$ico_check="";
				if ($show["STREGTBPMB"]=="1") $ico_check="<img border='0' src='images/ico_check.png' title='REG DISETUJUI' />";
				echo "<tr>";
		     	echo "<td class='$sel'>".$show['NODTRTBPMB']."</td>";
		     	echo "<td class='$sel'>".$show['NMPMBTBPMB']."</td>";
		    	echo "<td class='$sel'>".$show['PILIHAN1']."</td>";     	
		     	echo "<td class='$sel'>".$show['PILIHAN2']."</td>";
		     	echo "<td class='$sel'>".DateStr($show['TGUJITBPMB'])."</td>";
		     	echo "<td class='$sel tac'>".$ico_check."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=daftarcmb&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;   		     	
		     }
		} else {
		   	 echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
		}
	    echo "</table>";
	 	include "navigator.php";
		echo "<br>"; 
		echo "<br>";
	}
}
?>