<?php
$idpage='13';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$user_admin=$_SESSION[$PREFIX.'user_admin'];		
	if (isset($_POST['submit'])) {
		$edtID=$_POST['edtID'];
		//Form 1
		$rbKelBelajar=substr(strip_tags($_POST['rbKelBelajar']),0,1);
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
		$edtThnSemester=substr(strip_tags($_POST['edtThnSemester']),0,5);
		$edtTahunMasuk=substr($edtThnSemester,0,4);
		$cbPropinsiAsal=substr(strip_tags($_POST['cbPropinsiAsal']),0,2);
		$rbPindahan=substr(strip_tags($_POST['rbPindahan']),0,1);
		$edtTahunMasukAsal=substr(strip_tags($_POST['edtTahunMasukAsal']),0,4);
		$cbPerguruanTinggi=substr(strip_tags($_POST['cbPerguruanTinggi']),0,6);
		$edtNimAsal=substr(strip_tags($_POST['edtNimAsal']),0,15);
		$cbProdiAsal=substr(strip_tags($_POST['cbProdiAsal']),0,5);
		$cbJenjang=substr(strip_tags($_POST['cbJenjang']),0,1);
		$edtSKSdiakui="0";
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
					
		$MySQL->Update("msmhsupy","NMMHSMSMHS='$edtNama',TPLHRMSMHS='$edtTempatLahir',TGLHRMSMHS='$edtTglLahir',KDJEKMSMHS='$rbJK',ASSMAMSMHS='$cbPropinsiAsal',ASNIMMSMHS='$edtNimAsal',ASPTIMSMHS='$cbPerguruanTinggi',ASJENMSMHS='$cbJenjang',ASPSTMSMHS='$cbProdiAsal'","where IDX='".$edtID."'","1");
		$MySQL->Update("mhsdtlupy","KDBLJMSMHS='$rbKelBelajar',KLBLJMSMHS='$edtKelBelajar',KBLHRMSMHS='$edtKabLahir',PRLHRMSMHS='$cbPropLahir',ISWNIMSMHS='$rbNegara',NEGRAMSMHS='$edtNegara',AGAMAMSMHS='$cbAgama',STSPLMSMHS='$cbStatusSipil',ALMATMSMHS='$edtAlamat',KLRHNMSMHS='$edtKelurahan',KCMTNMSMHS='$edtKecamatan',KOTAAMSMHS='$edtKota',PRMHSMSMHS='$cbPropinsi',KDPOSMSMHS='$edtKodePos',TELPOMSMHS='$edtTelpon',ALDIYMSMHS='$edtAlamatDIY',KLDIYMSMHS='$edtKelurahanDIY',KCDIYMSMHS='$edtKecamatanDIY',KTDIYMSMHS='$edtKotaDIY',PSDIYMSMHS='$edtKodePosDIY',TLDIYMSMHS='$edtTelponDIY',THASLMSMHS='$edtTahunMasukAsal',NMSMUMSMHS='$edtSMU',LLSMUMSMHS='$edtThnLulusSMU',STSMUMSMHS='$cbStatusSMU',JNSMKMSMHS='$edtJenisSMK',JRSMUMSMHS='$edtJurusanSMU',LKSMUMSMHS='$edtLokasiSMU',ALSMUMSMHS='$edtAlamatSMU',KTSMUMSMHS='$edtKotaSMU',PRSMUMSMHS='$cbPropinsiSMU',NMAYHMSMHS='$edtAyah',NMIBUMSMHS='$edtIbu',STAYHMSMHS='$rbAyah',STIBUMSMHS='$rbIbu',ALORTMSMHS='$edtAlamatOrtu',KLORTMSMHS='$edtKelurahanOrtu',KCORTMSMHS='$edtKecamatanOrtu',KTORTMSMHS='$edtKotaOrtu',PRORTMSMHS='$cbPropinsiOrtu',PSORTMSMHS='$edtKodePosOrtu',TLORTMSMHS='$edtTelponOrtu',PDAYHMSMHS='$cbPendidikanAyah',PDIBUMSMHS='$cbPendidikanIbu',KRAYHMSMHS='$cbPekerjaanAyah',KRIBUMSMHS='$cbPekerjaanIbu',KOSTMMSMHS='$cbTempatTinggal',KRJMHMSMHS='$cbPekerjaan',NIPMHMSMHS='$edtNIP',NMKRJMSMHS='$edtInstansi',ALKRJMSMHS='$edtAlamatInstansi',IPGRIMSMHS='$rbAlumni',NOANGMSMHS='$edtNoAnggota',TXBOKMSMHS='$cbTextBook',PERPUMSMHS='$cbKunjunganKePerpustakaan',AKTVSMSMHS='$cbKegiatan',OLHRGMSMHS='$cbOlahRaga',SENIAMSMHS='$cbKesenian',SMBYAMSMHS='$cbSumberBiayaStudi',NMBYAMSMHS='$edtPenanggungBiaya',BSSWAMSMHS='$cbBeasiswa',ALSRTMSMHS='$edtAlamatSurat',KLSRTMSMHS='$edtKelurahanSurat',KCSRTMSMHS='$edtKecamatanSurat',KTSRTMSMHS='$edtKotaSurat',PRSRTMSMHS='$cbPropinsiSurat',PSSRTMSMHS='$edtKodePosSurat',TLSRTMSMHS='$edtTelponSurat',EMAILMSMHS='$edtEmail'","where NIMHSMSMHS='".$user_admin."'","1");			
		
		$act_log="Update ID='$edtID' Pada Tabel 'msmhsupy,mhsdtlupy' File 'daftarmahasiswa.php,datamahasiswa.php' ";
	  	if ($MySQL->exe){
			$succ=1;
		}
	  	if ($succ==1){
			$act_log .= "Sukses!";
	    	echo $msg_edit_data;
	  	} else {
			$act_log .= "Gagal!";
			echo $msg_update_0;
		}
		AddLog($id_admin,$act_log);
	}

	$qry="LEFT OUTER JOIN mhsdtlupy ON (msmhsupy.NIMHSMSMHS = mhsdtlupy.NIMHSMSMHS)";
	$qry .= " WHERE msmhsupy.NIMHSMSMHS = '".$user_admin."'";
	$canceled="./";
	$MySQL->Select("msmhsupy.IDX,msmhsupy.KDPSTMSMHS,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,msmhsupy.TPLHRMSMHS,msmhsupy.TGLHRMSMHS,msmhsupy.KDJEKMSMHS,msmhsupy.TAHUNMSMHS,msmhsupy.ASSMAMSMHS,msmhsupy.STPIDMSMHS,msmhsupy.SKSDIMSMHS,msmhsupy.ASNIMMSMHS,msmhsupy.ASPTIMSMHS,msmhsupy.ASJENMSMHS,msmhsupy.ASPSTMSMHS,mhsdtlupy.KDBLJMSMHS,mhsdtlupy.KLBLJMSMHS,mhsdtlupy.KBLHRMSMHS,mhsdtlupy.PRLHRMSMHS,mhsdtlupy.ISWNIMSMHS,mhsdtlupy.NEGRAMSMHS,mhsdtlupy.AGAMAMSMHS,mhsdtlupy.STSPLMSMHS,mhsdtlupy.ALMATMSMHS,mhsdtlupy.KLRHNMSMHS,mhsdtlupy.KCMTNMSMHS,mhsdtlupy.KOTAAMSMHS,mhsdtlupy.PRMHSMSMHS,mhsdtlupy.KDPOSMSMHS,mhsdtlupy.TELPOMSMHS,mhsdtlupy.ALDIYMSMHS,mhsdtlupy.KLDIYMSMHS,mhsdtlupy.KCDIYMSMHS,mhsdtlupy.KTDIYMSMHS,mhsdtlupy.PSDIYMSMHS,mhsdtlupy.TLDIYMSMHS,mhsdtlupy.TTSKSMSMHS,mhsdtlupy.JMSKSMSMHS,mhsdtlupy.THASLMSMHS,mhsdtlupy.NMSMUMSMHS,mhsdtlupy.LLSMUMSMHS,mhsdtlupy.STSMUMSMHS,mhsdtlupy.JNSMKMSMHS,mhsdtlupy.JRSMUMSMHS,mhsdtlupy.LKSMUMSMHS,mhsdtlupy.ALSMUMSMHS,mhsdtlupy.PRSMUMSMHS,mhsdtlupy.KTSMUMSMHS,mhsdtlupy.NMAYHMSMHS,mhsdtlupy.NMIBUMSMHS,mhsdtlupy.STAYHMSMHS,mhsdtlupy.STIBUMSMHS,mhsdtlupy.ALORTMSMHS,mhsdtlupy.KLORTMSMHS,mhsdtlupy.KCORTMSMHS,mhsdtlupy.KTORTMSMHS,mhsdtlupy.PRORTMSMHS,mhsdtlupy.PSORTMSMHS,mhsdtlupy.TLORTMSMHS,mhsdtlupy.PDAYHMSMHS,mhsdtlupy.PDIBUMSMHS,mhsdtlupy.KRAYHMSMHS,mhsdtlupy.KRIBUMSMHS,mhsdtlupy.KOSTMMSMHS,mhsdtlupy.KRJMHMSMHS,mhsdtlupy.NIPMHMSMHS,mhsdtlupy.NMKRJMSMHS,mhsdtlupy.ALKRJMSMHS,mhsdtlupy.IPGRIMSMHS,mhsdtlupy.NOANGMSMHS,mhsdtlupy.TXBOKMSMHS,mhsdtlupy.PERPUMSMHS,mhsdtlupy.AKTVSMSMHS,mhsdtlupy.OLHRGMSMHS,mhsdtlupy.SENIAMSMHS,mhsdtlupy.SMBYAMSMHS,mhsdtlupy.NMBYAMSMHS,mhsdtlupy.BSSWAMSMHS,mhsdtlupy.ALSRTMSMHS,mhsdtlupy.KLSRTMSMHS,mhsdtlupy.KCSRTMSMHS,mhsdtlupy.KTSRTMSMHS,mhsdtlupy.PRSRTMSMHS,mhsdtlupy.PSSRTMSMHS,mhsdtlupy.TLSRTMSMHS,mhsdtlupy.EMAILMSMHS","msmhsupy",$qry,"","1");
	$show=$MySQL->fetch_array();
	$edtID=$show["IDX"];
	//Form 1
	$edtNIM=$show["NIMHSMSMHS"];
	$cbProdi=$show["KDPSTMSMHS"];
	$edtJenjang=$show["KDJENMSMHS"];
	$cbFakultas=LoadFakultas_X("",substr($cbProdi,0,1));
	$rbKelBelajar=$show["KDBLJMSMHS"];
	$edtKelBelajar=$show["KLBLJMSMHS"];
	$edtNama=$show["NMMHSMSMHS"];
	$rbJK=$show["KDJEKMSMHS"]; 
	$edtTglLahir=DateStr($show["TGLHRMSMHS"]);
	$edtTempatLahir=$show["TPLHRMSMHS"];
	$edtKabLahir=$show["KBLHRMSMHS"];
	$cbPropLahir=$show["PRLHRMSMHS"];
	$rbNegara=$show["ISWNIMSMHS"];
	$edtNegara=$show["NEGRAMSMHS"];
	$cbAgama=$show["AGAMAMSMHS"];
	$cbStatusSipil=$show["STSPLMSMHS"];
	$edtAlamat=$show["ALMATMSMHS"];
	$edtKelurahan=$show["KLRHNMSMHS"];
	$edtKecamatan=$show["KCMTNMSMHS"];
	$edtKota=$show["KOTAAMSMHS"];
	$cbPropinsi=$show["PRMHSMSMHS"];
	$edtKodePos=$show["KDPOSMSMHS"];
	$edtTelpon=$show["TELPOMSMHS"];
	$edtAlamatDIY=$show["ALDIYMSMHS"];
	$edtKelurahanDIY=$show["KLDIYMSMHS"];
	$edtKecamatanDIY=$show["KCDIYMSMHS"];
	$edtKotaDIY=$show["KTDIYMSMHS"];
	$edtKodePosDIY=$show["PSDIYMSMHS"];
	$edtTelponDIY=$show["TLDIYMSMHS"];
	//Form 2
	$edtThnSemester=$show["TAHUNMSMHS"];
	$edtTahunMasuk=substr($edtThnSemester,0,4);
	$cbPropinsiAsal=$show["ASSMAMSMHS"];
	$edtSKS1=$show["TTSKSMSMHS"]; 
	$edtSKS2=$show["JMSKSMSMHS"]; 
	$rbPindahan=$show["STPIDMSMHS"];
	$edtTahunMasukAsal=$show["THASLMSMHS"];
	$cbPerguruanTinggi=$show["ASPTIMSMHS"];
	$edtNimAsal=$show["ASNIMMSMHS"];
	$cbJenjang=$show["ASJENMSMHS"];
	$cbProdiAsal=$show["ASPSTMSMHS"];
	$edtSKSdiakui=$show["SKSDIMSMHS"];
	$edtSMU=$show["NMSMUMSMHS"];
	$edtThnLulusSMU=$show["LLSMUMSMHS"];
	$cbStatusSMU=$show["STSMUMSMHS"];
	$edtJenisSMK=$show["JNSMKMSMHS"];
	$edtJurusanSMU=$show["JRSMUMSMHS"];
	$edtLokasiSMU=$show["LKSMUMSMHS"];
	$edtAlamatSMU=$show["ALSMUMSMHS"];
	$edtKotaSMU=$show["KTSMUMSMHS"];
	$cbPropinsiSMU=$show["PRSMUMSMHS"];
	//Form 3
	$edtAyah=$show["NMAYHMSMHS"];
	$rbAyah=$show["STAYHMSMHS"];
	$edtIbu=$show["NMIBUMSMHS"];
	$rbIbu=$show["STIBUMSMHS"];
	$edtAlamatOrtu=$show["ALORTMSMHS"];
	$edtKelurahanOrtu=$show["KLORTMSMHS"];
	$edtKecamatanOrtu=$show["KCORTMSMHS"];
	$edtKotaOrtu=$show["KTORTMSMHS"];
	$cbPropinsiOrtu=$show["PRORTMSMHS"];
	$edtKodePosOrtu=$show["PSORTMSMHS"];
	$edtTelponOrtu=$show["TLORTMSMHS"];
	$cbPendidikanAyah=$show["PDAYHMSMHS"];
	$cbPendidikanIbu=$show["PDIBUMSMHS"];
	$cbPekerjaanAyah=$show["KRAYHMSMHS"];
	$cbPekerjaanIbu=$show["KRIBUMSMHS"];
	//Form 4
	$cbTempatTinggal=$show["KOSTMMSMHS"];
	$cbPekerjaan=$show["KRJMHMSMHS"];
	$edtNIP=$show["NIPMHMSMHS"];
	$edtInstansi=$show["NMKRJMSMHS"];
	$edtAlamatInstansi=$show["ALKRJMSMHS"];
	$rbAlumni=$show["IPGRIMSMHS"];
	$edtNoAnggota=$show["NOANGMSMHS"];
	$cbTextBook=$show["TXBOKMSMHS"];
	$cbKunjunganKePerpustakaan=$show["PERPUMSMHS"];
	$cbKegiatan=$show["AKTVSMSMHS"];
	$cbOlahRaga=$show["OLHRGMSMHS"];
	$cbKesenian=$show["SENIAMSMHS"];
	$cbSumberBiayaStudi=$show["SMBYAMSMHS"];
	$edtPenanggungBiaya=$show["NMBYAMSMHS"];
	$cbBeasiswa=$show["BSSWAMSMHS"];
	$edtAlamatSurat=$show["ALSRTMSMHS"];
	$edtKelurahanSurat=$show["KLSRTMSMHS"];
	$edtKecamatanSurat=$show["KCSRTMSMHS"];
	$edtKotaSurat=$show["KTSRTMSMHS"];
	$cbPropinsiSurat=$show["PRSRTMSMHS"];
	$edtKodePosSurat=$show["PSSRTMSMHS"];
	$edtTelponSurat=$show["TLSRTMSMHS"];
	$edtEmail=$show["EMAILMSMHS"];
	
?>
	<center>
	<p align="center"><b>ISIAN DATA MAHASISWA</b></p>
	<form name="form1" action="./?page=isiandatamahasiswa" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
	    <div id="whatnewstoggler" class="fadecontenttoggler" style="width:900px">
		<a href="#" class="toc">FORM 1</a>
		<a href="#" class="toc">FORM 2</a>
		<a href="#" class="toc">FORM 3</a> 
		<a href="#" class="toc">FORM 4</a>
		</div>
		
		<div id="whatsnew" class="fadecontentwrapper" style="width:900px">
			<!********** Form 1 ******************>
			<div class="fadecontent">
			<table style="width:99%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="3%" class="mandatory">I.</td>
				  <td colspan="4" class="mandatory">IDENTITAS DIRI</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="3%">1.</td>
				    <td colspan="2">NPM. Mahasiswa </td>
				    <td width="57%">: <?php echo $edtNIM; ?>
					</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>2.</td>
				    <td colspan="2">Fakultas</td>
				    <td>: 
<?php 
						echo $cbFakultas;
?>
				</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>3.</td>
				    <td colspan="2">Program Studi</td>
				    <td>: 
<?php 
						echo LoadProdi_X("","$cbProdi");
?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>4.</td>
				  <td colspan="2">Kelompok Belajar </td>
				  <td>: 
<?php
						//P= PUSAT k=KELOMPOK
						$KLB[1]="Pusat";
						$KLB[0]="Kelompok Belajar";
						$KB[1]="P";
						$KB[0]="K";
						for ($i=1;$i >= 0 ; $i--){
							$checkstr="";
							if ($KB[$i]==$rbKelBelajar) $checkstr="checked";
		echo "<input type='radio' name='rbKelBelajar' value='$KB[$i]' ".$checkstr." >".$KLB[$i]."&nbsp;&nbsp;&nbsp;";
						}
?>
						di&nbsp;:&nbsp;<input size="10" type="text" name="edtKelBelajar" id="edtKelBelajar" maxlength="10" value="<?php echo $edtKelBelajar; ?>">				  
				  </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>5.</td>
				    <td colspan="2">Nama Lengkap</td>
				    <td class="mandatory">
					: <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30" value="<?php echo $edtNama; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>6.</td>
				  <td colspan="2">Jenis Kelamin</td>
				  <td>: 
<?php 
						LoadJK_X("rbJK","$rbJK"); 
?>
				   </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>7.</td>
				  <td colspan="2">Tanggal Lahir </td>
				  <td>:
                    <input type="text" name="edtTglLahir" size="10"  maxlength="10"  value="<?php echo $edtTglLahir; ?>"/>
                    <a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglLahir',document.form1.edtTglLahir.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>8.</td>
				  <td colspan="2">Tempat Lahir </td>
				  <td>:
                  <input size="20" type="text" name="edtTempatLahir" maxlength="20" value="<?php echo $edtTempatLahir; ?>"></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>9.</td>
				  <td colspan="2">Kabupaten</td>
				  <td>: 
			      <input name="edtKabLahir" type="text" id="edtKabLahir" value="<?php echo $edtKabLahir; ?>" size="20" maxlength="20"></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>10.</td>
				  <td colspan="2">Propinsi</td>
				  <td>: 
<?php 
					LoadPropinsi_X("cbPropLahir","$cbPropLahir"); 
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
						$WNI[1]="1";
						$WNI[0]="0";
						for ($i=1;$i >= 0 ; $i--){
							$checkstr="";
							if ($WNI[$i]==$rbNegara) $checkstr="checked";
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
                    <input size="20" type="text" name="edtNegara" maxlength="20" value="<?php echo $edtNegara; ?>">
                    <span style='font-size:11px; font-weight:normal; color:red'>Diisi Apabila status kewarganegaraan WNA</span></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>13.</td>
				  <td colspan="2">Agama</td>
				  <td>:
                  <?php LoadKode_X("cbAgama","$cbAgama","94"); ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>14.</td>
				  <td colspan="2">Status Sipil</td>
				  <td>:
                  <?php LoadKode_X("cbStatusSipil","$cbStatusSipil","93"); ?></td>
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
					<input name="edtAlamat" type="text" id="edtAlamat" value="<?php echo $edtAlamat; ?>" size="30" maxlength="30"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Desa/Kelurahan</td>
				  <td>: 
			         <input size="20" type="text" name="edtKelurahan" maxlength="20" value="<?php echo $edtKelurahan; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kecamatan</td>
				  <td>: 
			         <input size="20" type="text" name="edtKecamatan" maxlength="20" value="<?php echo $edtKecamatan; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kabupaten/Kota</td>
				  <td>: 
			         <input size="20" type="text" name="edtKota" maxlength="20" value="<?php echo $edtKota; ?>"></td>
			    </tr>			    
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>Propinsi</td>
				    <td>
					: <?php LoadPropinsi_X("cbPropinsi","$cbPropinsi"); ?></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>Kode Pos</td>
				    <td>: 
			        <input size="5" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>Telepon / HP.</td>
				    <td>
					: 
				    <input name="edtTelpon" type="text" id="edtTelpon" value="<?php echo $edtTelpon; ?>" size="20" maxlength="20"></td>
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
				  <input name="edtAlamatDIY" type="text" id="edtAlamatDIY" value="<?php echo $edtAlamatDIY; ?>" size="30" maxlength="30"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Desa/Kelurahan</td>
				  <td>: 
			         <input size="20" type="text" name="edtKelurahanDIY" maxlength="20" value="<?php echo $edtKelurahanDIY; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kecamatan</td>
				  <td>: 
			         <input size="20" type="text" name="edtKecamatanDIY" maxlength="20" value="<?php echo $edtKecamatanDIY; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kabupaten/Kota</td>
				  <td>:
					<input size="20" type="text" name="edtKotaDIY" maxlength="20" value="<?php echo $edtKotaDIY; ?>"></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kode Pos</td>
				  <td>: 
			        <input size="5" type="text" name="edtKodePosDIY" maxlength="5" value="<?php echo $edtKodePosDIY; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Telepon / HP.</td>
				  <td>: 
				    <input name="edtTelponDIY" type="text" id="edtTelponDIY" value="<?php echo $edtTelponDIY; ?>" size="20" maxlength="20">
				  </td>
		        </tr>
				</table>
		    </div>

			<!********** Form 2 ******************>
			<div class="fadecontent">
			<table style="width:99%" border="0" cellpadding="1" cellspacing="1">
			 <tr>
			  	  <td width="2%" class="mandatory">II.</td>
			  	  <td colspan="4" class="mandatory">PENDIDIKAN</td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td width="2%">1.</td>
			  	  <td colspan="2">Tahun Masuk UPY </td>
			  	  <td width="57%">: 
<?php
					echo $edtTahunMasuk;
?>
				  </td>
		  	  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>2.</td>
				    <td colspan="2">Propinsi Pendidikan Terakhir</td>
				    <td>
					: <?php LoadPropinsi_X("cbPropinsiAsal","$cbPropinsiAsal"); ?></td>
		        </tr>

			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>3.</td>
			  	  <td colspan="3">Tingkat Kemajuan Akademis</td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Total SKS yang harus diselesaikan </td>
			  	  <td>: 
<?php 
					echo $edtSKS1; 
?>
				  </td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
		  	      <td colspan="2">Total SKS yang sudah di selesaikan s/d Saat ini </td>
		  	      <td>:	<?php echo $edtSKS2; ?>
				 </td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>4.</td>
			  	  <td colspan="3">Apakah Saudara pindahan dari/pernah terdaftar pada perguruan tinggi lain? 
		  	      <?php
						$isPindah[1]="Ya";
						$isPindah[0]="Tidak";
						$Pindah[1]="P";
						$Pindah[0]="B";
						for ($i=1;$i >= 0 ; $i--){
							$checkstr="";
							if ($Pindah[$i]==$rbPindahan) $checkstr="checked";
		echo "<input type='radio' name='rbPindahan' value='$Pindah[$i]' ".$checkstr." >".$isPindah[$i]."&nbsp;&nbsp;";						}
		?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Tahun Masuk PT Asal</td>
			  	  <td> : 
			  	    <input name="edtTahunMasukAsal" type="text" id="edtTahunMasukAsal" value="<?php echo $edtTahunMasukAsal; ?>" size="4" maxlength="4"></td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Nama PT. Asal </td>
			  	  <td>: 
<?php
					LoadPT_X("cbPerguruanTinggi","$cbPerguruanTinggi");
?>					
				  </td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">NIM PT. Asal</td>
			  	  <td> : 
			  	    <input name="edtNimAsal" type="text" id="edtNimAsal" value="<?php echo $edtNimAsal; ?>" size="15" maxlength="15"></td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Program Studi Asal </td>
			  	  <td>: 
<?php 
						LoadProdiDikti_X("cbProdiAsal","$cbProdiAsal");
?>
				  </td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Jenjang Studi PT. Asal</td>
			  	  <td> : 
<?php 
						LoadKode_X("cbJenjang","$cbJenjang","04");
?>
				  </td>
		  	    </tr>



			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
		  	      <td colspan="2">Total SKS yang telah diakui (terkonversi)</td>
		  	      <td>: <?php echo $edtSKSdiakui; ?>	
				</td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>5.</td>
			  	  <td colspan="2">Nama SMU / SMK asal </td>
			  	  <td>: 
			  	    <input name="edtSMU" type="text" id="edtSMU" value="<?php echo $edtSMU; ?>" size="40" maxlength="40"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>6.</td>
			  	  <td colspan="2">Tahun Lulus SMU / SMK Asal </td>
			  	  <td>: 
			  	    <input name="edtThnLulusSMU" type="text" id="edtThnLulusSMU" value="<?php echo $edtThnLulusSMU; ?>" size="4" maxlength="4"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>7.</td>
			  	  <td colspan="2">Status SMU / SMK Asal </td>
			  	  <td>: 
<?php 
					LoadKode_X("cbStatusSMU","$cbStatusSMU","84");
?>
				  </td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>8.</td>
			  	  <td colspan="2">Jenis SMK, bila berasal dari SMK (Misal SMEA,STN,dsb.)</td>
			  	  <td>: 
			  	    <input name="edtJenisSMK" type="text" id="edtJenisSMK" value="<?php echo $edtJenisSMK; ?>" size="20" maxlength="20"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>9.</td>
			  	  <td colspan="2">Bagian/Jurusan</td>
			  	  <td>: 
			  	    <input name="edtJurusanSMU" type="text" id="edtJurusanSMU" value="<?php echo $edtJurusanSMU; ?>" size="30" maxlength="30"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>10.</td>
			  	  <td colspan="2">Lokasi SMU / SMTA Kejuruan </td>
			  	  <td>: 
			  	    <input name="edtLokasiSMU" type="text" id="edtLokasiSMU" value="<?php echo $edtLokasiSMU; ?>" size="30" maxlength="30"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Alamat SMTA Asal </td>
			  	  <td>: 
			  	    <input name="edtAlamatSMU" type="text" id="edtAlamatSMU" value="<?php echo $edtAlamatSMU; ?>" size="40" maxlength="40"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Kota /Kabupaten SMTA Asal </td>
			  	  <td>: 
			  	    <input name="edtKotaSMU" type="text" id="edtKotaSMU" value="<?php echo $edtKotaSMU; ?>" size="20" maxlength="20"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Propinsi  SMTA Asal</td>
			  	  <td>: <?php LoadPropinsi_X("cbPropinsiSMU","$cbPropinsiSMU"); ?></td>
		  	  </tr>
			</table>	
		  	</div>
			<!********** Form 3 ******************>
			<div class="fadecontent">
			<table style="width:99%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="3%" class="mandatory">III.</td>
				  <td colspan="3" class="mandatory">KELUARGA</td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="4%">1.</td>
				    <td width="36%">Nama Lengkap Ayah</td>
				    <td width="56%">
					: <input size="30" type="text" name="edtAyah" id="edtAyah" maxlength="30" value="<?php echo $edtAyah; ?>"></td>
					<td width="1%"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Ayah Masih Hidup</td>
				    <td>
					: 
	<?php
						$hdp[1]="Hidup";
						$hdp[0]="Meninggal";
						$hd[1]="1";
						$hd[0]="0";
						for ($i=1;$i >= 0 ; $i--){
							$checkstr="";
							if ($hd[$i]==$rbAyah) $checkstr="checked";
		echo "<input type='radio' name='rbAyah' value='$i' ".$checkstr." >".$hdp[$i]."&nbsp;&nbsp;";
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
				    <input size="30" type="text" name="edtIbu" id="edtIbu" maxlength="30" value="<?php echo $edtIbu; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Ibu Masih Hidup</td>
				    <td>
					: 
	<?php
						$hdp[1]="Hidup";
						$hdp[0]="Meninggal";
						$hd[1]="1";
						$hd[0]="0";
						for ($i=1;$i >= 0 ; $i--){
							$checkstr="";
							if ($hd[$i]==$rbIbu) $checkstr="checked";
		echo "<input type='radio' name='rbIbu' value='$i' ".$checkstr." >".$hdp[$i]."&nbsp;&nbsp;";
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
					<input size="30" type="text" name="edtAlamatOrtu" maxlength="30" value="<?php echo $edtAlamatOrtu; ?>"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Desa/Kelurahan</td>
				    <td colspan="2">:
					<input size="20" type="text" name="edtKelurahanOrtu" maxlength="20" value="<?php echo $edtKelurahanOrtu; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kecamatan</td>
				    <td colspan="2">:
					<input size="20" type="text" name="edtKecamatanOrtu" maxlength="20" value="<?php echo $edtKecamatanOrtu; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kabupaten/Kota</td>
				    <td colspan="2">:
					<input size="20" type="text" name="edtKotaOrtu" maxlength="20" value="<?php echo $edtKotaOrtu; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Propinsi</td>
				    <td>
					: <?php LoadPropinsi_X("cbPropinsiOrtu","$cbPropinsiOrtu"); ?></td>
			    </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				    <td>Kode Pos</td>
				    <td>: 
			        <input size="5" type="text" name="edtKodePosOrtu" maxlength="5" value="<?php echo $edtKodePosOrtu; ?>"></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Telepon/HP.</td>
				    <td>
					: 
				    <input name="edtTelponOrtu" type="text" id="edtTelponOrtu" value="<?php echo $edtTelponOrtu; ?>" size="20" maxlength="20"></td>
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
				  <td>: <?php LoadKode_X("cbPendidikanAyah","$cbPendidikanAyah","88") ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Ibu</td>
				  <td>: <?php LoadKode_X("cbPendidikanIbu","$cbPendidikanIbu","88") ?></td>
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
				  <td>: <?php LoadKode_X("cbPekerjaanAyah","$cbPekerjaanAyah","96") ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Ibu</td>
				    <td>: <?php LoadKode_X("cbPekerjaanIbu","$cbPekerjaanIbu","96") ?></td>
			    </tr>
			  </table>
			</div>			
			<!********** Form 4 ******************>
			<div class="fadecontent">
			<table style="width:99%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="3%" class="mandatory">IV.</td>
				  <td colspan="4" class="mandatory">UMUM</td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="3%">1.</td>
				    <td width="29%">Jenis Tempat Tinggal Saat Ini</td>
				    <td colspan="2" class="mandatory">
					: <?php  LoadKode_X("cbTempatTinggal","$cbTempatTinggal","92")?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>2.</td>
				    <td>Pekerjaan</td>
				    <td colspan="2" class="mandatory">
					: <?php LoadKode_X("cbPekerjaan","$cbPekerjaan","96"); ?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>3.</td>
				  <td>NIP / NIS </td>
				  <td colspan="2" class="mandatory">:	
				    <input size="30" type="text" name="edtNIP" id="edtNIP" maxlength="30" value="<?php echo $edtNIP; ?>"></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>3.</td>
				    <td>Nama Kantor / Instansi</td>
				    <td colspan="2" class="mandatory">
					:	
					  <input size="30" type="text" name="edtInstansi" id="edtInstansi" maxlength="30" value="<?php echo $edtInstansi; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>4.</td>
				    <td>Alamat Kantor / Instansi</td>
				    <td colspan="2" class="mandatory">
					: 
				    <input size="40" type="text" name="edtAlamatInstansi" id="edtAlamatInstansi" maxlength="40" value="<?php echo $edtAlamatInstansi; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>5.</td>
				    <td>Merupakan Alumni PGRI</td>
					<td colspan="2">
					: 
	<?php
								$isAlumni[1]="Ya";
								$isAlumni[0]="Tidak";
								$Alumni[1]="1";
								$Alumni[0]="0";
								for ($i=1;$i >= 0 ; $i--){
									$checkstr="";
									if ($Alumni[$i]==$rbAlumni) $checkstr="checked";
		echo "<input type='radio' name='rbAlumni' value='$i' ".$checkstr." >".$isAlumni[$i]."&nbsp;&nbsp;";
								}
	?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>6.</td>
				    <td>No. Keanggotaan</td>
				    <td colspan="2">
					: 
			          <input size="11" type="text" name="edtNoAnggota" maxlength="11" value="<?php echo $edtNoAnggota ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>7.</td>
					<td colspan="3">Kemampuan memahami text book bahasa asing (khususnya yang</td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td colspan="2">   bersangkutan dengan bidang studi)</td>
			      <td>: <?php LoadKode_X("cbTextBook","$cbTextBook","91"); ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>8.</td>
				    <td colspan="2">Kunjungan ke Perpustakaan</td>
				    <td width="49%">: <?php LoadKode_X("cbKunjunganKePerpustakaan","$cbKunjunganKePerpustakaan","90"); ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>9.</td>
				    <td colspan="2">Keterlibatan dalam kegiatan akademis di luar kuliah</td>
				    <td> : <?php LoadKode_X("cbKegiatan","$cbKegiatan","89"); ?></td>
				</tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>10.</td>
			  	  <td colspan="2">Keterlibatan dalam kegiatan keolahragaan</td>
			  	  <td>:
                  <?php LoadKode_X("cbOlahRaga","$cbOlahRaga","89"); ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>11.</td>
			  	  <td colspan="2">Keterlibatan dalam kegiatan keseniaan</td>
			  	  <td>:
                  <?php LoadKode_X("cbKesenian","$cbKesenian","89"); ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>12.</td>
			  	  <td colspan="2">Sumber Biaya Terbesar untuk Studi </td>
			  	  <td>:
                  <?php LoadKode_X("cbSumberBiayaStudi","$cbSumberBiayaStudi","86"); ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Nama Penanggung Biaya </td>
			  	  <td>: 
		  	      <input size="30" type="text" name="edtPenanggungBiaya" maxlength="30" value="<?php echo $edtPenanggungBiaya; ?>"></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>14.</td>
			  	  <td colspan="2">Status Beasiswa (Bila Saudara Menerima beasiswa/tunjangan)</td>
		  	      <td>:
                  <?php LoadKode_X("cbBeasiswa","$cbBeasiswa","85"); ?></td>
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
					<input name="edtAlamatSurat" type="text" id="edtAlamatSurat" value="<?php echo $edtAlamatSurat; ?>" size="30" maxlength="30"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Desa/Kelurahan</td>
				    <td colspan="2">:
					<input size="20" type="text" name="edtKelurahanSurat" maxlength="20" value="<?php echo $edtKelurahanSurat; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kecamatan</td>
				    <td colspan="2">:
					<input size="20" type="text" name="edtKecamatanSurat" maxlength="20" value="<?php echo $edtKecamatanSurat; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kabupaten/Kota</td>
				    <td colspan="2">:
					<input size="20" type="text" name="edtKotaSurat" maxlength="20" value="<?php echo $edtKotaSurat; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Propinsi</td>
				    <td colspan="2">
					: <?php LoadPropinsi_X("cbPropinsiSurat","$cbPropinsiSurat"); ?></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				    <td>Kode Pos</td>
				    <td colspan="2">: 
			        <input size="5" type="text" name="edtKodePosSurat" maxlength="5" value="<?php echo $edtKodePosSurat; ?>"></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Telpon / HP. </td>
				  <td colspan="2">: 
			      <input name="edtTelponSurat" type="text" id="edtTelponSurat" value="<?php echo $edtTelponSurat; ?>" size="20" maxlength="20"></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Email</td>
				  <td colspan="2">:
                  <input size="40" type="text" name="edtEmail" maxlength="40" value="<?php echo $edtEmail; ?>"></td>
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
		</div>
	<center>
		<button type='button' onClick=window.location.href='<?php echo $canceled; ?>' /><img src='images/b_cancel.gif' class='btn_img'>&nbsp;Batal</button>&nbsp;
		<button type='submit' name='submit' value='Update' /><img src='images/b_save.gif' class='btn_img'>&nbsp;Update</button>
	</center>
	<br>
	</form>
	<script type="text/javascript">
	//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
	fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler", 0, 50)
	</script>
	</center>
<?php
}
?>
