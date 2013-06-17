<script type="text/javascript">
//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler", 0, 50)
</script>
<?php
$idpage='13';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit'])) {
		//Form 1
		$edtNoDaftar=substr(strip_tags($_POST['edtNoDaftar']),0,17);
		$edtNIM=substr(strip_tags($_POST['edtNIM']),0,15);
		$cbProdi=substr(strip_tags($_POST['cbProdi']),0,2);
		$edtKelBelajar=substr(strip_tags($_POST['edtKelBelajar']),0,10);
		$edtNama=substr(strip_tags($_POST['edtNama']),0,30);
		$rbJK=substr(strip_tags($_POST['rbJK']),0,1);
		$edtTglLahir=substr(strip_tags($_POST['edtTglLahir']),0,10);
		$edtTglLahir=@explode("-",$edtTglLahir);
		$edtTglLahir=$edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
		$edtTempatLahir=substr(strip_tags($_POST['edtTempatLahir']),0,20);
		$edtKabLahir=substr(strip_tags($_POST['edtKabLahir']),0,20);
		$cbPropLahir=substr(strip_tags($_POST['cbPropLahir']),0,2);
		$rbNegara=substr(strip_tags($_POST['rbNegara']),0,1);
		$edtNegara=substr(strip_tags($_POST['edtNegara']),0,20);
		$cbAgama=substr(strip_tags($_POST['cbAgama']),0,1);
		$cbStatusSipil=substr(strip_tags($_POST['cbStatusSipil']),0,1);
		$edtAlamat=substr(strip_tags($_POST['edtAlamat']),0,30);
		$edtKelurahan=substr(strip_tags($_POST['edtKelurahan']),0,20);
		$edtKecamatan=substr(strip_tags($_POST['edtKecamatan']),0,20);
		$edtKota=substr(strip_tags($_POST['edtKota']),0,20);
		$cbPropinsi=substr(strip_tags($_POST['cbPropinsi']),0,2);
		$edtKodePos=substr(strip_tags($_POST['edtKodePos']),0,5);
		$edtTelpon=substr(strip_tags($_POST['edtTelpon']),0,20);
		$edtAlamatDIY=substr(strip_tags($_POST['edtAlamatDIY']),0,30);
		$edtKelurahanDIY=substr(strip_tags($_POST['edtKelurahanDIY']),0,20);
		$edtKecamatanDIY=substr(strip_tags($_POST['edtKecamatanDIY']),0,20);
		$edtKotaDIY=substr(strip_tags($_POST['edtKotaDIY']),0,20);
		$edtKodePosDIY=substr(strip_tags($_POST['edtKodePosDIY']),0,5);
		$edtTelponDIY=substr(strip_tags($_POST['edtTelponDIY']),0,20);
		//Form 2
		$edtTahunMasuk=substr(strip_tags($_POST['edtTahunMasuk']),0,4);
		$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
		$edtThnSemester=$edtTahunMasuk.$cbSemester;
		$edtTahunBatas=substr(strip_tags($_POST['edtTahunBatas']),0,4);
		$cbSemester2=substr(strip_tags($_POST['cbSemester2']),0,1);
		$edtThnBatas=$edtTahunBatas.$cbSemester2;
		$edtTglMasuk=substr(strip_tags($_POST['edtTglMasuk']),0,10);
		$edtTglMasuk=@explode("-",$edtTglMasuk);
		$edtTglMasuk=$edtTglMasuk[2]."-".$edtTglMasuk[1]."-".$edtTglMasuk[0];
		$cbPropinsiAsal=substr(strip_tags($_POST['cbPropinsiAsal']),0,2);
		$rbPindahan=substr(strip_tags($_POST['rbPindahan']),0,1);
		$edtTahunMasukAsal=substr(strip_tags($_POST['edtTahunMasukAsal']),0,4);
		$cbPerguruanTinggi=substr(strip_tags($_POST['cbPerguruanTinggi']),0,6);
		$edtNimAsal=substr(strip_tags($_POST['edtNimAsal']),0,15);
		$cbProdiAsal=substr(strip_tags($_POST['cbProdiAsal']),0,5);
		$cbJenjang=substr(strip_tags($_POST['cbJenjang']),0,1);
		$edtSKSdiakui=substr(strip_tags($_POST['edtSKSdiakui']),0,3);
		$edtSMU=substr(strip_tags($_POST['edtSMU']),0,40);
		$edtThnLulusSMU=substr(strip_tags($_POST['edtThnLulusSMU']),0,4);
		$cbStatusSMU=substr(strip_tags($_POST['cbStatusSMU']),0,1);
		$edtJenisSMK=substr(strip_tags($_POST['edtJenisSMK']),0,20);
		$edtJurusanSMU=substr(strip_tags($_POST['edtJurusanSMU']),0,30);
		$edtLokasiSMU=substr(strip_tags($_POST['edtLokasiSMU']),0,30);
		$edtAlamatSMU=substr(strip_tags($_POST['edtAlamatSMU']),0,40);
		$edtKotaSMU=substr(strip_tags($_POST['edtKotaSMU']),0,20);
		$cbPropinsiSMU=substr(strip_tags($_POST['cbPropinsiSMU']),0,2);
		//Form 3
	    $edtAyah=substr(strip_tags($_POST['edtAyah']),0,30);
	    $rbAyah=substr(strip_tags($_POST['rbAyah']),0,1);
	    $edtIbu=substr(strip_tags($_POST['edtIbu']),0,30);
	    $rbIbu=substr(strip_tags($_POST['rbIbu']),0,1);
	    $edtAlamatOrtu=substr(strip_tags($_POST['edtAlamatOrtu']),0,30);
	    $edtKelurahanOrtu=substr(strip_tags($_POST['edtKelurahanOrtu']),0,20);
		$edtKecamatanOrtu=substr(strip_tags($_POST['edtKecamatanOrtu']),0,20);
	    $edtKotaOrtu=substr(strip_tags($_POST['edtKotaOrtu']),0,20);
	    $cbPropinsiOrtu=substr(strip_tags($_POST['cbPropinsiOrtu']),0,2);
	    $edtKodePosOrtu=substr(strip_tags($_POST['edtKodePosOrtu']),0,5);
	    $edtTelponOrtu=substr(strip_tags($_POST['edtTelponOrtu']),0,20);
	    $cbPendidikanAyah=substr(strip_tags($_POST['cbPendidikanAyah']),0,1);
	    $cbPendidikanIbu=substr(strip_tags($_POST['cbPendidikanIbu']),0,1);
	    $cbPekerjaanAyah=substr(strip_tags($_POST['cbPekerjaanAyah']),0,1);
	    $cbPekerjaanIbu=substr(strip_tags($_POST['cbPekerjaanIbu']),0,1);
		//Form 4
		$cbTempatTinggal=substr(strip_tags($_POST["cbTempatTinggal"]),0,1);
	    $cbPekerjaan=substr(strip_tags($_POST["cbPekerjaan"]),0,1);
		$edtNIP=substr(strip_tags($_POST["edtNIP"]),0,30);
  		$edtInstansi=substr(strip_tags($_POST["edtInstansi"]),0,30);
  		$edtAlamatInstansi=substr(strip_tags($_POST["edtAlamatInstansi"]),0,30);
  		$rbAlumni=substr(strip_tags($_POST["rbAlumni"]),0,1);
  		$edtNoAnggota=substr(strip_tags($_POST["edtNoAnggota"]),0,11);
	    $cbTextBook=substr(strip_tags($_POST["cbTextBook"]),0,1);
	    $cbKunjunganKePerpustakaan=substr(strip_tags($_POST["cbKunjunganKePerpustakaan"]),0,1);
	    $cbKegiatan=substr(strip_tags($_POST["cbKegiatan"]),0,1);
	    $cbOlahRaga=substr(strip_tags($_POST["cbOlahRaga"]),0,1);
	    $cbKesenian=substr(strip_tags($_POST["cbKesenian"]),0,1);
		$cbSumberBiayaStudi==substr(strip_tags($_POST["cbSumberBiayaStudi"]),0,1);
		$edtPenanggungBiaya==substr(strip_tags($_POST["edtPenanggungBiaya"]),0,30);
		$cbBeasiswa==substr(strip_tags($_POST["cbBeasiswa"]),0,1);
	    $edtAlamatSurat=substr(strip_tags($_POST["edtAlamatSurat"]),0,30);
	    $edtKelurahanSurat=substr(strip_tags($_POST["edtKelurahanSurat"]),0,20);
		$edtKecamatanSurat=substr(strip_tags($_POST['edtKecamatanSurat']),0,20);
	    $edtKotaSurat=substr(strip_tags($_POST["edtKotaSurat"]),0,20);
	    $cbPropinsiSurat=substr(strip_tags($_POST["cbPropinsiSurat"]),0,2);
	    $edtKodePosSurat=substr(strip_tags($_POST["edtKodePosSurat"]),0,5);
		$edtTelponSurat=substr(strip_tags($_POST["edtTelponSurat"]),0,20);
	    $edtEmail=substr(strip_tags($_POST["edtEmail"]),0,40);

		$MySQL->Insert("msmhsupy","NODFRMSMHS,KDPSTMSMHS,NIMHSMSMHS,NMMHSMSMHS,TPLHRMSMHS,TGLHRMSMHS,KDJEKMSMHS,TAHUNMSMHS,SMAWLMSMHS,BTSTUMSMHS,ASSMAMSMHS,TGMSKMSMHS,STMHSMSMHS,STPIDMSMHS,SKSDIMSMHS,ASNIMMSMHS,ASPTIMSMHS,ASJENMSMHS,ASPSTMSMHS","'$edtNoDaftar','$cbProdi','$edtNIM','$edtNama','$edtTempatLahir','$edtTglLahir','$rbJK','$edtTahunMasuk','$edtThnSemester','$edtThnBatas','$cbPropinsiAsal','$edtTglMasuk','A','$rbPindahan','$edtSKSdiakui','$edtNimAsal','$cbPerguruanTinggi','$cbJenjang','$cbProdiAsal'");
		
		$MySQL->Insert("mhsdtlupy","NIMHSMSMHS,KLBLJMSMHS,KBLHRMSMHS,PRLHRMSMHS,ISWNIMSMHS,NEGRAMSMHS,AGAMAMSMHS,STSPLMSMHS,ALMATMSMHS,KLRHNMSMHS,KCMTNMSMHS,KOTAAMSMHS,PRMHSMSMHS,KDPOSMSMHS,TELPOMSMHS,ALDIYMSMHS,KLDIYMSMHS,KCDIYMSMHS,KTDIYMSMHS,PSDIYMSMHS,TLDIYMSMHS,THASLMSMHS,NMSMUMSMHS,LLSMUMSMHS,STSMUMSMHS,JNSMKMSMHS,JRSMUMSMHS,LKSMUMSMHS,ALSMUMSMHS,KTSMUMSMHS,PRSMUMSMHS,NMAYHMSMHS,NMIBUMSMHS,STAYHMSMHS,STIBUMSMHS,ALORTMSMHS,KLORTMSMHS,KCORTMSMHS,KTORTMSMHS,PRORTMSMHS,PSORTMSMHS,TLORTMSMHS,PDAYHMSMHS,PDIBUMSMHS,KRAYHMSMHS,KRIBUMSMHS,KOSTMMSMHS,KRJMHMSMHS,NIPMHMSMHS,NMKRJMSMHS,ALKRJMSMHS,IPGRIMSMHS,NOANGMSMHS,TXBOKMSMHS,PERPUMSMHS,AKTVSMSMHS,OLHRGMSMHS,SENIAMSMHS,SMBYAMSMHS,NMBYAMSMHS,BSSWAMSMHS,ALSRTMSMHS,KLSRTMSMHS,KCSRTMSMHS,KTSRTMSMHS,PRSRTMSMHS,PSSRTMSMHS,TLSRTMSMHS,EMAILMSMHS","'$edtNIM','$edtKelBelajar','$edtKabLahir','$cbPropLahir','$rbNegara','$edtNegara','$cbAgama','$cbStatusSipil','$edtAlamat','$edtKelurahan','$edtKecamatan','$edtKota','$cbPropinsi','$edtKodePos','$edtTelpon','$edtAlamatDIY','$edtKelurahanDIY','$edtKecamatanDIY','$edtKotaDIY','$edtKodePosDIY','$edtTelponDIY','$edtTahunMasukAsal','$edtSMU','$edtThnLulusSMU','$cbStatusSMU','$edtJenisSMK','$edtJurusanSMU','$edtLokasiSMU','$edtAlamatSMU','$edtKotaSMU','$cbPropinsiSMU','$edtAyah','$edtIbu','$rbAyah','$rbIbu','$edtAlamatOrtu','$edtKelurahanOrtu','$edtKecamatanOrtu','$edtKotaOrtu','$cbPropinsiOrtu','$edtKodePosOrtu','$edtTelponOrtu','$cbPendidikanAyah','$cbPendidikanIbu','$cbPekerjaanAyah','$cbPekerjaanIbu','$cbTempatTinggal','$cbPekerjaan','$edtNIP','$edtInstansi','$edtAlamatInstansi','$rbAlumni','$edtNoAnggota','$cbTextBook','$cbKunjunganKePerpustakaan','$cbKegiatan','$cbOlahRaga','$cbKesenian','$cbSumberBiayaStudi','$edtPenanggungBiaya','$cbBeasiswa','$edtAlamatSurat','$edtKelurahanSurat','$edtKecamatanSurat','$edtKotaSurat','$cbPropinsiSurat','$edtKodePosSurat','$edtTelponSurat','$edtEmail'");
		
		$act_log="Tambah Data Pada Tabel 'msmhsupy,mhsdtlupy' File 'isiandatamahasiswa.php' ";
	  	if ($MySQL->exe){
			$succ=1;
		}
	  	if ($succ==1){
			$act_log .= "Sukses!";
	    	echo $msg_insert_data;
	  	} else {
			$act_log .= "Gagal!";
			echo $msg_update_0;
		}
		AddLog($id_admin,$act_log);
	}
?>

	<!-- jika administrator -->
	<p class="tac fwb">ISIAN DATA MAHASISWA</p>
    <div id="whatnewstoggler" class="fadecontenttoggler">
		<a href="#" class="toc">FORM 1</a>
		<a href="#" class="toc">FORM 2</a>
		<a href="#" class="toc">FORM 3</a> 
		<a href="#" class="toc">FORM 4</a>
	</div>
	<div id="whatsnew" class="fadecontentwrapper" style="height:800px">
	<form name="form1" action="./?page=isiandatamahasiswa" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">

	<div class="fadecontent">
	<table align='center' style="width:100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		  <td width="3%">I.</td>
		  <td colspan="4">IDENTITAS DIRI</td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td width="3%">1.</td>
		    <td colspan="2">No. Pendaftaran</td>
		    <td width="57%">: <input size="17" type="text" name="edtNoDaftar" id="edtNoDaftar" maxlength="17" required ="1" regexp ="/^\w*$/" realname = "No. Pendaftaran">
			</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td width="3%">2.</td>
		    <td colspan="2">NPM. Mahasiswa </td>
		    <td width="57%">: <input size="10" type="text" name="edtNIM" id="edtNIM" maxlength="15" required ="1" regexp ="/^\w*$/" realname = "NP. Mahasiswa">
			</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>3.</td>
		    <td colspan="2">Program Studi</td>
		    <td>: 
<?php 
				LoadProdi_X("cbProdi","","","required ='1' exclude = '-1' err = 'Pilih Salah Satu dari Daftar Program Studi yang Ada!'");
?>
			</td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>4.</td>
		  <td colspan="2">Kelas/Basis Adm</td>
		  <td>:&nbsp;<input size="10" type="text" name="edtKelBelajar" id="edtKelBelajar" maxlength="10">				  
		  </td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>5.</td>
		    <td colspan="2">Nama Lengkap</td>
		    <td class="mandatory">
			: <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30" required ="1" regexp ="/^\w/" realname = "Nama"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>6.</td>
		  <td colspan="2">Jenis Kelamin</td>
		  <td>: 
<?php 
				LoadJK_X("rbJK",""); 
?>
		   </td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>7.</td>
		  <td colspan="2">Tanggal Lahir </td>
		  <td>:
            <input type="text" name="edtTglLahir" size="10"  maxlength="10" />
            <a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglLahir',document.form1.edtTglLahir.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>8.</td>
		  <td colspan="2">Tempat Lahir </td>
		  <td>:
          <input size="20" type="text" name="edtTempatLahir" maxlength="20"></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>9.</td>
		  <td colspan="2">Kabupaten</td>
		  <td>: 
	      <input name="edtKabLahir" type="text" id="edtKabLahir" size="20" maxlength="20"></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>10.</td>
		  <td colspan="2">Propinsi</td>
		  <td>: 
<?php 
			LoadPropinsi_X("cbPropLahir",""); 
?>
		  </td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>11.</td>
		  <td colspan="2">Kewarganegaraan</td>
		  <td>: 
<?php
				$isWNI[1]="WNI";
				$isWNI[0]="WNA";
				for ($i=1;$i >= 0 ; $i--){
					echo "<input type='radio' name='rbNegara' value='$i' ".$checkstr." >".$isWNI[$i]."&nbsp;&nbsp;";
				}
?>
		 </td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>12.</td>
		  <td colspan="2">Negara</td>
		  <td>:
            <input size="20" type="text" name="edtNegara" maxlength="20">
            <span style='font-size:11px; font-weight:normal; color:red'>Diisi Apabila status kewarganegaraan WNA</span></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>13.</td>
		  <td colspan="2">Agama</td>
		  <td>:
          <?php LoadKode_X("cbAgama","","94"); ?></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>14.</td>
		  <td colspan="2">Status Sipil</td>
		  <td>:
          <?php LoadKode_X("cbStatusSipil","","93"); ?></td>
	  </tr>
		<tr><td colspan="5">&nbsp;</td></tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>15.</td>
	  	  <td colspan="2">Alamat Mahasiswa </td>
	  	  <td>&nbsp;</td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td width="3%">a.</td>
	  	  <td width="34%">Alamat Asal </td>
	  	  <td>(DIISI DENGAN LENGKAP SESUAI KTP atau SIM)</td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>Alamat Lengkap </td>
		    <td>:
			<input name="edtAlamat" type="text" id="edtAlamat" size="30" maxlength="30"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Desa/Kelurahan</td>
		  <td>: 
	         <input size="20" type="text" name="edtKelurahan" maxlength="20" ></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Kecamatan</td>
		  <td>: 
	         <input size="20" type="text" name="edtKecamatan" maxlength="20" ></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Kabupaten/Kota</td>
		  <td>: 
	         <input size="20" type="text" name="edtKota" maxlength="20" ></td>
	    </tr>			    
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>Propinsi</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsi",""); ?></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>Kode Pos</td>
		    <td>: 
	        <input size="5" type="text" name="edtKodePos" maxlength="5" ></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>Telepon / HP.</td>
		    <td>
			: 
		    <input name="edtTelpon" type="text" id="edtTelpon" size="20" maxlength="20"></td>
        </tr>
		<tr><td colspan="5">&nbsp;</td></tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td>b.</td>
	  	  <td>Alamat Tempat Tinggal di DIY </td>
	  	  <td>(DIISI DENGAN LENGKAP SESUAI KTP atau SIM)</td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Alamat Lengkap</td>
		  <td>: 
		  <input name="edtAlamatDIY" type="text" id="edtAlamatDIY" size="30" maxlength="30"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Desa/Kelurahan</td>
		  <td>: 
	         <input size="20" type="text" name="edtKelurahanDIY" maxlength="20" ></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Kecamatan</td>
		  <td>: 
	         <input size="20" type="text" name="edtKecamatanDIY" maxlength="20" ></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Kabupaten/Kota</td>
		  <td>:
			<input size="20" type="text" name="edtKotaDIY" maxlength="20" ></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Kode Pos</td>
		  <td>: 
	        <input size="5" type="text" name="edtKodePosDIY" maxlength="5" ></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Telepon / HP.</td>
		  <td>: 
		    <input name="edtTelponDIY" type="text" id="edtTelponDIY" size="20" maxlength="20">
		  </td>
        </tr>
		</table>
    </div>
	<div class="fadecontent">
	<table align='center' style="width:100%" border="0" cellpadding="1" cellspacing="1">
	 <tr>
	  	  <td width="4%">II.</td>
	  	  <td colspan="4">PENDIDIKAN</td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td width="2%">1.</td>
	  	  <td colspan="2">Tahun Masuk UPY </td>
	  	  <td width="57%">: <input name="edtTahunMasuk" type="text" id="edtTahunMasuk"  size="4" maxlength="4" required="1" regexp ="/^\d/" realname ="Tahun">&nbsp;
		   <?php  LoadSemester_X("cbSemester","","required='1' exclude='-1' err='Pilih Salah Satu dari daftar Semester yang Ada!'") ?> 
		  </td>
  	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2">Tanggal Masuk</td>
		  <td>:
            <input type="text" name="edtTglMasuk" size="10"  maxlength="10" />
            <a href="javascript:show_calendar('document.form1.edtTglMasuk','document.form1.edtTglMasuk',document.form1.edtTglMasuk.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
		<tr>
		  <td>&nbsp;</td>
		  <td>2.</td>
		    <td colspan="2">Propinsi Pendidikan Terakhir</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsiAsal",""); ?></td>
        </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td width="2%">3.</td>
	  	  <td colspan="2">Batas Studi</td>
	  	  <td width="57%">: <input name="edtTahunBatas" type="text" id="edtTahunBatas"  size="4" maxlength="4">&nbsp;
		   <?php  LoadSemester_X("cbSemester2","") ?> 
		  </td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>4.</td>
	  	  <td colspan="3">Apakah Saudara pindahan dari/pernah terdaftar pada perguruan tinggi lain? 
  	      <?php
				$isPindah[1]="Ya";
				$isPindah[0]="Tidak";
				for ($i=1;$i >= 0 ; $i--){
					echo "<input type='radio' name='rbPindahan' value='$i'>".$isPindah[$i]."&nbsp;&nbsp;";
				}
?></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Tahun Masuk PT Asal</td>
	  	  <td> : 
	  	    <input name="edtTahunMasukAsal" type="text" id="edtTahunMasukAsal" size="4" maxlength="4"></td>
  	    </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Nama PT. Asal </td>
	  	  <td>: 
<?php
			LoadPT_X("cbPerguruanTinggi","");
?>					
		  </td>
  	    </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">NIM PT. Asal</td>
	  	  <td> : 
	  	    <input name="edtNimAsal" type="text" id="edtNimAsal" size="15" maxlength="15"></td>
  	    </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Program Studi Asal </td>
	  	  <td>: 
<?php 
				LoadProdiDikti_X("cbProdiAsal","");
?>
		  </td>
  	    </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Jenjang Studi PT. Asal</td>
	  	  <td> : 
<?php 
				LoadKode_X("cbJenjang","","04");
?>
		  </td>
  	    </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
  	      <td colspan="2">Total SKS yang telah diakui (terkonversi)</td>
  	      <td>: <input name="edtSKSdiakui" type="text" id="edtSKSdiakui" size="3" maxlength="3">
		</td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>5.</td>
	  	  <td colspan="2">Nama SMU / SMK asal </td>
	  	  <td>: 
	  	    <input name="edtSMU" type="text" id="edtSMU" maxlength="40"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>6.</td>
	  	  <td colspan="2">Tahun Lulus SMU / SMK Asal </td>
	  	  <td>: 
	  	    <input name="edtThnLulusSMU" type="text" id="edtThnLulusSMU" size="4" maxlength="4"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>7.</td>
	  	  <td colspan="2">Status SMU / SMK Asal </td>
	  	  <td>: 
<?php 
			LoadKode_X("cbStatusSMU","","84");
?>
		  </td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>8.</td>
	  	  <td colspan="2">Jenis SMK, bila berasal dari SMK (Misal SMEA,STN,dsb.)</td>
	  	  <td>: 
	  	    <input name="edtJenisSMK" type="text" id="edtJenisSMK" size="20" maxlength="20"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>9.</td>
	  	  <td colspan="2">Bagian/Jurusan</td>
	  	  <td>: 
	  	    <input name="edtJurusanSMU" type="text" id="edtJurusanSMU" size="30" maxlength="30"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>10.</td>
	  	  <td colspan="2">Lokasi SMU / SMTA Kejuruan </td>
	  	  <td>: 
	  	    <input name="edtLokasiSMU" type="text" id="edtLokasiSMU" size="30" maxlength="30"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Alamat SMTA Asal </td>
	  	  <td>: 
	  	    <input name="edtAlamatSMU" type="text" id="edtAlamatSMU" size="40" maxlength="40"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Kota /Kabupaten SMTA Asal </td>
	  	  <td>: 
	  	    <input name="edtKotaSMU" type="text" id="edtKotaSMU" size="20" maxlength="20"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Propinsi  SMTA Asal</td>
	  	  <td>: <?php LoadPropinsi_X("cbPropinsiSMU",""); ?></td>
  	  </tr>
	</table>	
  	</div>

	<div class="fadecontent">
	<table align='center' style="width:100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		  <td width="3%">III.</td>
		  <td colspan="3">KELUARGA</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td width="4%">1.</td>
		    <td width="36%">Nama Lengkap Ayah</td>
		    <td width="56%">
			: <input size="30" type="text" name="edtAyah" id="edtAyah" maxlength="30" ></td>
			<td width="1%"></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Ayah Masih Hidup</td>
		    <td>
			: 
<?php
				$hdp[1] = "Hidup";
				$hdp[0] = "Meninggal";					
				$hd[1]="1";
				$hd[0]="0";
				for ($i=1;$i >= 0 ; $i--){
					echo "<input type='radio' name='rbAyah' value='$i'>".$hdp[$i]."&nbsp;&nbsp;";
				}
?>
</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>2.</td>
		    <td>Nama Lengkap Ibu</td>
		    <td>
			: 
		    <input size="30" type="text" name="edtIbu" id="edtIbu" maxlength="30"></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Ibu Masih Hidup</td>
		    <td>
			: 
<?php
				$hdp[1] = "Hidup";
				$hdp[0] = "Meninggal";					
				$hd[1]="1";
				$hd[0]="0";
				for ($i=1;$i >= 0 ; $i--){
					echo "<input type='radio' name='rbIbu' value='$i'>".$hdp[$i]."&nbsp;&nbsp;";
				}
?>
</td>
	    </tr>
	    <tr><td colspan="4">&nbsp;</td></tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>3.</td>
		    <td>Alamat Orang Tua </td>
			<td>(DIISI DENGAN LENGKAP DAN JELAS) </td>
	    </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
		    <td>Alamat Lengkap</td>
		    <td>:
			<input size="30" type="text" name="edtAlamatOrtu" maxlength="30"></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Desa/Kelurahan</td>
		    <td colspan="2">:
			<input size="20" type="text" name="edtKelurahanOrtu" maxlength="20"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Kecamatan</td>
		    <td colspan="2">:
			<input size="20" type="text" name="edtKecamatanOrtu" maxlength="20"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Kabupaten/Kota</td>
		    <td colspan="2">:
			<input size="20" type="text" name="edtKotaOrtu" maxlength="20"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Propinsi</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsiOrtu",""); ?></td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
		    <td>Kode Pos</td>
		    <td>: 
	        <input size="5" type="text" name="edtKodePosOrtu" maxlength="5"></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Telepon/HP.</td>
		    <td>: 
		    <input name="edtTelponOrtu" type="text" id="edtTelponOrtu" size="20" maxlength="20"></td>
	    </tr>
		<tr><td colspan="4">&nbsp;</td></tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>4.</td>
		    <td>Pendidikan Terakhir Orang Tua </td>
		    <td>: </td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Ayah</td>
		  <td>: <?php LoadKode_X("cbPendidikanAyah","","88") ?></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Ibu</td>
		  <td>: <?php LoadKode_X("cbPendidikanIbu","","88") ?></td>
	    </tr>
		<tr>
		  <td colspan="6">&nbsp;</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>5.</td>
		  <td colspan="2">Pekerjaan Orang Tua (Kalau sudah meninggal, isi dengan pekerjaan terakhir semasa hidupnya) </td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Ayah</td>
		  <td>: <?php LoadKode_X("cbPekerjaanAyah","","96") ?></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Ibu</td>
		    <td>: <?php LoadKode_X("cbPekerjaanIbu","","96") ?></td>
	    </tr>
	  </table>
	</div>

	<div class="fadecontent">
	<table style="width:100%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		  <td width="3%">IV.</td>
		  <td colspan="4">UMUM</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td width="3%">1.</td>
		    <td width="29%">Jenis Tempat Tinggal Saat Ini</td>
		    <td colspan="2" class="mandatory">
			: <?php  LoadKode_X("cbTempatTinggal","","92")?>
			</td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>2.</td>
		    <td>Pekerjaan</td>
		    <td colspan="2" class="mandatory">
			: <?php LoadKode_X("cbPekerjaan","","96"); ?>
			</td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>3.</td>
		  <td>NIP / NIS </td>
		  <td colspan="2" class="mandatory">:	
		    <input size="30" type="text" name="edtNIP" id="edtNIP" maxlength="30"></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>4.</td>
		    <td>Nama Kantor / Instansi</td>
		    <td colspan="2" class="mandatory">
			:	
			  <input size="30" type="text" name="edtInstansi" id="edtInstansi" maxlength="30"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>5.</td>
		    <td>Alamat Kantor / Instansi</td>
		    <td colspan="2" class="mandatory">
			: 
		    <input size="40" type="text" name="edtAlamatInstansi" id="edtAlamatInstansi" maxlength="40"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>6.</td>
		    <td>Merupakan Alumni PGRI</td>
			<td colspan="2">
			: 
<?php
			$isAlumni[1] = "Ya";
			$isAlumni[0] = "Tidak";					
			$Alumni[1]="1";
			$Alumni[0]="0";
			for ($i=1;$i >= 0 ; $i--){
				echo "<input type='radio' name='rbAlumni' value='$i'>".$isAlumni[$i]."&nbsp;&nbsp;";
			}
?>
			</td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>7.</td>
		    <td>No. Keanggotaan</td>
		    <td colspan="2">
			: 
	          <input size="11" type="text" name="edtNoAnggota" maxlength="11"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>8.</td>
			<td colspan="3">Kemampuan memahami text book bahasa asing (khususnya yang</td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td colspan="2">   bersangkutan dengan bidang studi)</td>
	      <td>: <?php LoadKode_X("cbTextBook","","91"); ?></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>9.</td>
		    <td colspan="2">Kunjungan ke Perpustakaan</td>
		    <td width="49%">: <?php LoadKode_X("cbKunjunganKePerpustakaan","","90"); ?></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>10.</td>
		    <td colspan="2">Keterlibatan dalam kegiatan akademis di luar kuliah</td>
		    <td> : <?php LoadKode_X("cbKegiatan","","89"); ?></td>
		</tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>11.</td>
	  	  <td colspan="2">Keterlibatan dalam kegiatan keolahragaan</td>
	  	  <td>:
          <?php LoadKode_X("cbOlahRaga","","89"); ?></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>12.</td>
	  	  <td colspan="2">Keterlibatan dalam kegiatan keseniaan</td>
	  	  <td>:
          <?php LoadKode_X("cbKesenian","","89"); ?></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>13.</td>
	  	  <td colspan="2">Sumber Biaya Terbesar untuk Studi </td>
	  	  <td>:
          <?php LoadKode_X("cbSumberBiayaStudi","","86"); ?></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
	  	  <td colspan="2">Nama Penanggung Biaya </td>
	  	  <td>: 
  	      <input size="30" type="text" name="edtPenanggungBiaya" maxlength="30"></td>
  	  </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>14.</td>
	  	  <td colspan="2">Status Beasiswa (Bila Saudara Menerima beasiswa/tunjangan)</td>
  	      <td>:
          <?php LoadKode_X("cbBeasiswa","","85"); ?></td>
	  	</tr>
		<tr><td colspan="5">&nbsp;</td></tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>15.</td>
  	      <td>Alamat Surat Menyurat</td>
  	      <td colspan="2">(DIISI DENGAN LENGKAP DAN JELAS) </td>
        </tr>
	  	<tr>
	  	  <td>&nbsp;</td>
	  	  <td>&nbsp;</td>
		    <td>Alamat Lengkap</td>
		    <td colspan="2">:
			<input name="edtAlamatSurat" type="text" id="edtAlamatSurat" size="30" maxlength="30"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Desa/Kelurahan</td>
		    <td colspan="2">:
			<input size="20" type="text" name="edtKelurahanSurat" maxlength="20"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Kecamatan</td>
		    <td colspan="2">:
			<input size="20" type="text" name="edtKecamatanSurat" maxlength="20"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Kabupaten/Kota</td>
		    <td colspan="2">:
			<input size="20" type="text" name="edtKotaSurat" maxlength="20"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		    <td>Propinsi</td>
		    <td colspan="2">
			: <?php LoadPropinsi_X("cbPropinsiSurat",""); ?></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
		    <td>Kode Pos</td>
		    <td colspan="2">: 
	        <input size="5" type="text" name="edtKodePosSurat" maxlength="5"></td>
        </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Telpon / HP. </td>
		  <td colspan="2">: 
	      <input name="edtTelponSurat" type="text" id="edtTelponSurat" size="20" maxlength="20"></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Email</td>
		  <td colspan="2">:
          <input size="40" type="text" name="edtEmail" maxlength="40"></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
		    <td colspan="2">&nbsp;</td>
        </tr>	        
	  </table>
	</div>
	</form>
</div>
<?php		
}
?>
