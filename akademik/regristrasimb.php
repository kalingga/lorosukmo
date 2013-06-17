<?php
$idpage='27';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	if (!isset($_SESSION[$PREFIX.'id_admin'])) $id_admin="0";
	$gagal=1;
	$curr_date= date("Y-m-d",$_SERVER['REQUEST_TIME']);
	if (isset($_POST['submit'])){
		if ($_POST['submit']=="Submit") {
			$edtKode=substr(strip_tags($_POST['edtKode']),0,9);
			$edtNoDaftar=$edtKode."-".substr(strip_tags($_POST['edtNoDaftar']),0,4);
			//cek apakah calon mahasiswa bersangkutan benar-benar terdaftar sebagai calon mahasiswa
			$cek_Regristrasi=Cek_Regristrasi_CMB($edtNoDaftar);
			//jika serching oleh user umum;
			if ($cek_Regristrasi){
				$syarat=1;
				//lakukan cek tgl regristrasi apabila user umum
				$MySQL->Select("TGREGSETPMB","setpmbupy","where KDPMBSETPMB='".$edtKode."'","","1");
				$show=$MySQL->fetch_array();
				$batas_reg=$show["TGREGSETPMB"];
				if (!isset($_SESSION[$PREFIX.'user_admin'])){
					$curr_reg= New Date($curr_date);
					$curr_reg_1=$curr_reg->isGt($batas_reg);
					if ($curr_reg_1){
						echo "<div id='msg_err' class='diverr m5 p5 tac'>Batas Waktu Regristrasi Ulang Calon Mahasiswa Baru telah terlewati.<br>Silahkan Konfirmasi Ke Bagian Akademik Universitas Bersangkutan!</div>";
						$gagal=1;
						$syarat=0;
					} else {
					//Tampilkan Form Regristrasi Bila Memenuhi syarat diatas
						$syarat=1;
					}
				}
				
				if ($syarat==1) {
						$MySQL->Select("tbpmbupy.*,mspstupy.SKSTTMSPST","tbpmbupy","left outer join mspstupy on tbpmbupy.DTRMATBPMB=mspstupy.IDPSTMSPST where NODTRTBPMB='".$edtNoDaftar."'","","1");
						$show=$MySQL->fetch_array();
						$edtID=$show["IDX"];
						//Form 1
						$edtNoDaftar=$show["NODTRTBPMB"];
						$edtGelombang=$show["GLDTRTBPMB"];
						$cbProdi=$show["DTRMATBPMB"];
						$edtJenjang=$show["KDJENTBPMB"];
						$cbFakultas=LoadFakultas_X("",substr($cbProdi,0,1));
						$rbKelBelajar="";
						$edtKelBelajar="";
						$edtNama=$show["NMPMBTBPMB"];
						$rbJK=$show["KDJEKTBPMB"]; 
						$edtTglLahir=DateStr($show["TGLHRTBPMB"]);
						$edtTempatLahir=$show["TPLHRTBPMB"];
						$edtKabLahir="";
						$cbPropLahir="";
						$rbNegara=$show["KDWNITBPMB"];
						$edtNegara=$show["NEGRATBPMB"];
						$cbAgama="";
						$cbStatusSipil="";
						$edtAlamat=$show["ALMT1TBPMB"];
						$edtKelurahan=$show["KELRHTBPMB"];
						$edtKecamatan="";
						$edtKota=$show["KABPTTBPMB"];
						$cbPropinsi=$show["PROPITBPMB"];
						$edtKodePos=$show["KDPOSTBPMB"];
						$edtTelpon=$show["TELPOTBPMB"];
						$edtAlamatDIY="";
						$edtKelurahanDIY="";
						$edtKecamatanDIY="";
						$edtKotaDIY="";
						$edtKodePosDIY="";
						$edtTelponDIY="";
						//Form 2
						$edtThnSemester=$show["THDTRTBPMB"];
						$edtTahunMasuk=substr($edtThnSemester,0,4);
						$cbPropinsiAsal="";
						$edtSKS1=$show["SKSTTMSPST"]; 
						$edtSKS2="0"; 
						$rbPindahan=$show["STPIDTBPMB"];
						$edtTahunMasukAsal="";
						$cbPerguruanTinggi;
						$edtNimAsal="";
						$cbJenjang="";
						$cbProdiAsal="";
						$edtSKSdiakui="0"; 
						$edtSMU="";
						$edtThnLulusSMU="";
						$cbStatusSMU="";
						$edtJenisSMK="";
						$edtJurusanSMU="";
						$edtLokasiSMU="";
						$edtAlamatSMU="";
						$edtKotaSMU="";
						$cbPropinsiSMU="";
						//Form 3
						$edtAyah="";
						$rbAyah="";
						$edtIbu="";
						$rbIbu="";
						$edtAlamatOrtu="";
						$edtKecamatanOrtu="";
						$edtKelurahanOrtu="";
						$edtKotaOrtu="";
						$cbPropinsiOrtu="";
						$edtKodePosOrtu="";
						$edtTelponOrtu="";
						$cbPendidikanAyah="";
						$cbPendidikanIbu="";
						$cbPekerjaanAyah="";
						$cbPekerjaanIbu="";
						//Form 4
						$cbTempatTinggal="";
						$cbPekerjaan=$show["STKRJTBPMB"];
						$edtNIP="";
						$edtInstansi=$show["NMKRJTBPMB"];
						$edtAlamatInstansi=$show["ALKRJTBPMB"];
						$rbAlumni=$show["ALMNITBPMB"];
						$edtNoAnggota=$show["ANGGTTBPMB"];
						$cbTextBook="";
						$cbKunjunganKePerpustakaan="";
						$cbKegiatan="";
						$cbOlahRaga="";
						$cbKesenian="";
						$cbSumberBiayaStudi="";
						$edtPenanggungBiaya="";
						$cbBeasiswa="";
						$edtAlamatSurat="";
						$edtKelurahanSurat="";
						$edtKecamatanSurat="";
						$edtKotaSurat="";
						$cbPropinsiSurat="";
						$edtKodePosSurat="";
						$edtTelponSurat="";
						$edtEmail="";
						$gagal=0;					
				}
			} else {
				$gagal=1;
			}
		} else {
		//Jika Regristrasi
			$succ=0;
			$edtID=$_POST['edtID']."<br>";
			//Form 1
			$edtNoDaftar=$_POST['edtNoDaftar'];
			$cbProdi=$_POST['cbProdi'];
			$edtJenjang=$_POST['edtJenjang'];
			$edtGelombang=$_POST['edtGelombang'];
			$cbFakultas=LoadFakultas_X("",substr($cbProdi,0,1));
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
			$edtSKS1=$_POST['edtSKS1']; 
			$edtSKS2="0"; 
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
			$MySQL->Update("tbpmbupy","NMPMBTBPMB='$edtNama',KDJEKTBPMB='$rbJK',TPLHRTBPMB='$edtTempatLahir',TGLHRTBPMB='$edtTglLahir',KDWNITBPMB='$rbNegara',NEGRATBPMB='$edtNegara',ALMT1TBPMB='$edtAlamat',KELRHTBPMB='$edtKelurahan',KABPTTBPMB='$edtKota',PROPITBPMB='$cbPropinsi',TELPOTBPMB='$edtTelpon',KDPOSTBPMB='$edtKodePos',PROSKTBPMB='$cbPropinsiAsal',STKRJTBPMB='$cbPekerjaan',NMKRJTBPMB='$edtInstansi',ALKRJTBPMB='$edtAlamatInstansi',ALMNITBPMB='$rbAlumni',ANGGTTBPMB='$edtNoAnggota',STPIDTBPMB='$rbPindahan'","where IDX='".$edtID."'","1");
			if ($MySQL->exe){
				$succ=1;
			}				
	  		if ($succ==1) {
		  		$gagal=1;
		  		//jika berhasil maka input msmhsupy 
				$transfer_data=Input_Mhs($edtID,$edtJenjang,$edtNoDaftar,$edtGelombang,$cbProdi,$rbKelBelajar,$edtKelBelajar,$edtNama,$rbJK,$edtTglLahir,$edtTempatLahir,$edtKabLahir,$cbPropLahir,$rbNegara,$edtNegara,$cbAgama,$cbStatusSipil,$edtAlamat,$edtKelurahan,$edtKecamatan,$edtKota,$cbPropinsi,$edtKodePos,$edtTelpon,$edtAlamatDIY,$edtKelurahanDIY,$edtKecamatanDIY,$edtKotaDIY,$edtKodePosDIY,$edtTelponDIY,$edtThnSemester,$cbPropinsiAsal,$edtSKS1,$edtSKS2,$rbPindahan,$edtTahunMasukAsal,$cbPerguruanTinggi,$edtNimAsal,$cbJenjang,$cbProdiAsal,$edtSKSdiakui,$edtSMU,$edtThnLulusSMU,$cbStatusSMU,$edtJenisSMK,$edtJurusanSMU,$edtLokasiSMU,$edtAlamatSMU,$edtKotaSMU,$cbPropinsiSMU,$edtAyah,$rbAyah,$edtIbu,$rbIbu,$edtAlamatOrtu,$edtKelurahanOrtu,$edtKecamatanOrtu,$edtKotaOrtu,$cbPropinsiOrtu,$edtKodePosOrtu,$edtTelponOrtu,$cbPendidikanAyah,$cbPendidikanIbu,$cbPekerjaanAyah,$cbPekerjaanIbu,$cbTempatTinggal,$cbPekerjaan,$edtNIP,$edtInstansi,$edtAlamatInstansi,$rbAlumni,$edtNoAnggota,$cbTextBook,$cbKunjunganKePerpustakaan,$cbKegiatan,$cbOlahRaga,$cbKesenian,$cbSumberBiayaStudi,$edtPenanggungBiaya,$cbBeasiswa,$edtAlamatSurat,$edtKelurahanSurat,$edtKecamatanSurat,$edtKotaSurat,$cbPropinsiSurat,$edtKodePosSurat,$edtTelponSurat,$edtEmail,$curr_date,$id_admin);
				if (!($transfer_data)) {
		  			$gagal=0;
				}
			} else {
		  		$gagal=0;
			}				
		}
	}												

	if ($gagal != 1) {
		//Tampilan Form Regristrasi
?>		
		<p align="center"><b>Formulir Regristrasi Mahasiswa Baru</b></p>
		<form name="form1" action="./?page=regristrasimb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	    <input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
	    <input type="hidden" name="edtNoDaftar" value="<?php echo $edtNoDaftar; ?>" />
	    <input type="hidden" name="cbProdi" value="<?php echo $cbProdi; ?>" />
	    <input type="hidden" name="edtJenjang" value="<?php echo $edtJenjang; ?>" />
	    <input type="hidden" name="edtThnSemester" value="<?php echo $edtThnSemester; ?>" />
	    <input type="hidden" name="edtGelombang" value="<?php echo $edtGelombang; ?>" />
	    <input type="hidden" name="edtSKS1" value="<?php echo $edtSKS1; ?>" />
	    <div id="whatnewstoggler" class="fadecontenttoggler">
		<a href="#" class="toc">FORM 1</a>
		<a href="#" class="toc">FORM 2</a>
		<a href="#" class="toc">FORM 3</a> 
		<a href="#" class="toc">FORM 4</a>
		</div>
		
		<div id="whatsnew" class="fadecontentwrapper">
			<!********** Form 1 ******************>
			<div class="fadecontent">
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="3%">I.</td>
				  <td colspan="4">IDENTITAS DIRI</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="3%">1.</td>
				    <td colspan="2">Nomor Pendaftaran </td>
				    <td width="57%">: <?php echo $edtNoDaftar; ?>
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
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			 <tr>
			  	  <td width="2%">II.</td>
			  	  <td colspan="4">PENDIDIKAN</td>
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
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="3%">III.</td>
				  <td colspan="3">KELUARGA</td>
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
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="3%">IV.</td>
				  <td colspan="4">UMUM</td>
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
				  <td colspan="2">
					<button type='submit' name='submit' value='reg' /><img src='images/b_save.gif' class='btn_img'>&nbsp;REGISTRASI</button>
				  </td>
		        </tr>	        
			  </table>
			</div>
		</div>
		<center>
			<!-- <button type='submit' name='submit' value='reg' /><img src='images/b_save.gif' class='btn_img'>&nbsp;REGRISTRASI</button> -->
		</center>
		<br>
		</form>
		<script type="text/javascript">
		//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
		fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler", 0, 400)
		</script>
<?php
	}
	if (!isset($_POST['submit']) || ($gagal==1)){
?>
		<form name="form1" action="./?page=regristrasimb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr><th>Form Regristrasi Ulang Mahasiswa Baru</th>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>Silahkan Masukkan No Pendaftaran Anda : <input size="9" type="text" name="edtKode" maxlength="9">-<input size="4" type="text" name="edtNoDaftar" maxlength="4"></td>
		</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td align="center">
			<button type='Submit' name="submit" value="Submit"><b>Submit&nbsp;</b><img src='images/b_go.png' class='btn_img'/></button>		    	
			<tr><td>&nbsp;</td></tr>
		</table>
		</form>
<?php
	}
}

function Cek_Regristrasi_CMB($edtNoDaftar){
	global $MySQL;
	$MySQL->Select("IDX","tbpmbupy","where NODTRTBPMB='".$edtNoDaftar."'","","1");
	if ($MySQL->Num_rows() <= 0 ){
		echo "<div id='msg_err' class='diverr m5 p5 tac'>Data Tidak Ditemukan, Silahkan Konfirmasi Ke Bagian Akademik Universitas Bersangkutan</div>";
		return false;
	} else {
		$show=$MySQL->fetch_array();
		$edtID=$show["IDX"];
		//Cek apakah CMB bersangkutan mrpkn cmb yang dinyatakan diterima
		$MySQL->Select("STTRMTBPMB,HRREGTBPMB","tbpmbupy","where IDX='".$edtID."'","","1");
		$show=$MySQL->fetch_array();
		$diTerima=$show["STTRMTBPMB"];
		$regristrasi=$show["HRREGTBPMB"];
		if (($diTerima=="0") || is_null($diTerima) || ($diTerima=="")) {
			echo "<div id='msg_err' class='diverr m5 p5 tac'>Data Tidak Ditemukan, Silahkan Konfirmasi Ke Bagian Akademik Universitas Bersangkutan</div>";
			return False;
		} else {
			if ($regristrasi=="1") {			
				echo "<div id='msg_err' class='diverr m5 p5 tac'>Data Sudah Pernah Diproses, Silahkan Konfirmasi Ke Bagian Akademik Universitas Bersangkutan</div>";
				return False;
			} else {
				return True;
			}
		}
	}
}


function Input_Mhs($edtID,$edtJenjang,$edtNoDaftar,$edtGelombang,$cbProdi,$rbKelBelajar,$edtKelBelajar,$edtNama,$rbJK,$edtTglLahir,$edtTempatLahir,$edtKabLahir,$cbPropLahir,$rbNegara,$edtNegara,$cbAgama,$cbStatusSipil,$edtAlamat,$edtKelurahan,$edtKecamatan,$edtKota,$cbPropinsi,$edtKodePos,$edtTelpon,$edtAlamatDIY,$edtKelurahanDIY,$edtKecamatanDIY,$edtKotaDIY,$edtKodePosDIY,$edtTelponDIY,$edtThnSemester,$cbPropinsiAsal,$edtSKS1,$edtSKS2,$rbPindahan,$edtTahunMasukAsal,$cbPerguruanTinggi,$edtNimAsal,$cbJenjang,$cbProdiAsal,$edtSKSdiakui,$edtSMU,$edtThnLulusSMU,$cbStatusSMU,$edtJenisSMK,$edtJurusanSMU,$edtLokasiSMU,$edtAlamatSMU,$edtKotaSMU,$cbPropinsiSMU,$edtAyah,$rbAyah,$edtIbu,$rbIbu,$edtAlamatOrtu,$edtKelurahanOrtu,$edtKecamatanOrtu,$edtKotaOrtu,$cbPropinsiOrtu,$edtKodePosOrtu,$edtTelponOrtu,$cbPendidikanAyah,$cbPendidikanIbu,$cbPekerjaanAyah,$cbPekerjaanIbu,$cbTempatTinggal,$cbPekerjaan,$edtNIP,$edtInstansi,$edtAlamatInstansi,$rbAlumni,$edtNoAnggota,$cbTextBook,$cbKunjunganKePerpustakaan,$cbKegiatan,$cbOlahRaga,$cbKesenian,$cbSumberBiayaStudi,$edtPenanggungBiaya,$cbBeasiswa,$edtAlamatSurat,$edtKelurahanSurat,$edtKecamatanSurat,$edtKotaSurat,$cbPropinsiSurat,$edtKodePosSurat,$edtTelponSurat,$edtEmail,$curr_date,$id_admin){
	
	global $MySQL;
	$tahun=substr($edtThnSemester,0,4);
	$semester=substr($edtThnSemester,4,1);
	//Set NIM Mahasiswa
	$setno="0000";
	$digitset=strlen($setno);
	/*** set NIM berdasarkan program studi yang dipili **********/
	$MySQL->Select("COUNT(*) AS NIM","msmhsupy","where (KDPSTMSMHS='".$cbProdi."' and SMAWLMSMHS='".$edtThnSemester."')");
	$show=$MySQL->fetch_array();
	$nim=($show['NIM'] + 1);
	$digitnim=strlen($nim);
	$nim=substr_replace($setno,$nim,($digitset - $digitnim),$digitnim);
	$nim = substr($tahun,2,2).$semester.substr($cbProdi,0,1).$cbProdi.$edtJenjang.$nim;
	$MySQL->Insert("msmhsupy","NODFRMSMHS,GELOMMSMHS,KDPSTMSMHS,NIMHSMSMHS,NMMHSMSMHS,TPLHRMSMHS,TGLHRMSMHS,KDJEKMSMHS,TAHUNMSMHS,SMAWLMSMHS,ASSMAMSMHS,TGMSKMSMHS,STPIDMSMHS,ASNIMMSMHS,ASPTIMSMHS,ASJENMSMHS,ASPSTMSMHS","'$edtNoDaftar','$edtGelombang','$cbProdi','$nim','$edtNama','$edtTempatLahir','$edtTglLahir','$rbJK','$tahun','$edtThnSemester','$cbPropinsiAsal','$curr_date','$rbPindahan','$edtNimAsal','$cbPerguruanTinggi','$cbJenjang',$cbProdiAsal");
	
	$xxx = $MySQL->Show_Error();

	$act_log="Regristrasi Mahasiswa Baru No. Pendaftaran : ".$edtNoDaftar;
	$msg="Regristrasi Mahasiswa Baru No. Pendaftaran : ".$edtNoDaftar;
	if ($MySQL->exe){
		$succ=1;
	}				
	if ($succ==1) {
		$msg .=", Berhasil!";
		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
		echo $msg;
		echo "</div>";
  		$act_log .=", Sukses!";
  		$MySQL->insert("mhsdtlupy","NIMHSMSMHS,KDBLJMSMHS,KLBLJMSMHS,KBLHRMSMHS,PRLHRMSMHS,ISWNIMSMHS,NEGRAMSMHS,AGAMAMSMHS,STSPLMSMHS,ALMATMSMHS,KLRHNMSMHS,KCMTNMSMHS,KOTAAMSMHS,PRMHSMSMHS,KDPOSMSMHS,TELPOMSMHS,ALDIYMSMHS,KLDIYMSMHS,KCDIYMSMHS,KTDIYMSMHS,PSDIYMSMHS,TLDIYMSMHS,TTSKSMSMHS,JMSKSMSMHS,THASLMSMHS,NMSMUMSMHS,LLSMUMSMHS,STSMUMSMHS,JNSMKMSMHS,JRSMUMSMHS,LKSMUMSMHS,ALSMUMSMHS,KTSMUMSMHS,PRSMUMSMHS,NMAYHMSMHS,NMIBUMSMHS,STAYHMSMHS,STIBUMSMHS,ALORTMSMHS,KLORTMSMHS,KCORTMSMHS,KTORTMSMHS,PRORTMSMHS,PSORTMSMHS,TLORTMSMHS,PDAYHMSMHS,PDIBUMSMHS,KRAYHMSMHS,KRIBUMSMHS,KOSTMMSMHS,KRJMHMSMHS,NIPMHMSMHS,NMKRJMSMHS,ALKRJMSMHS,IPGRIMSMHS,NOANGMSMHS,TXBOKMSMHS,PERPUMSMHS,AKTVSMSMHS,OLHRGMSMHS,SENIAMSMHS,SMBYAMSMHS,NMBYAMSMHS,BSSWAMSMHS,ALSRTMSMHS,KLSRTMSMHS,KCSRTMSMHS,KTSRTMSMHS,PRSRTMSMHS,PSSRTMSMHS,TLSRTMSMHS,EMAILMSMHS","'$nim','$rbKelBelajar','$edtKelBelajar','$edtKabLahir','$cbPropLahir','$rbNegara','$edtNegara','$cbAgama','$cbStatusSipil','$edtAlamat','$edtKelurahan','$edtKecamatan','$edtKota','$cbPropinsi','$edtKodePos','$edtTelpon','$edtAlamatDIY','$edtKelurahanDIY','$edtKecamatanDIY','$edtKotaDIY','$edtKodePosDIY','$edtTelponDIY','$edtSKS1','$edtSKS2','$edtTahunMasukAsal','$edtSMU','$edtThnLulusSMU','$cbStatusSMU','$edtJenisSMK','$edtJurusanSMU','$edtLokasiSMU','$edtAlamatSMU','$edtKotaSMU','$cbPropinsiSMU','$edtAyah','$edtIbu','$rbAyah','$rbIbu','$edtAlamatOrtu','$edtKelurahanOrtu','$edtKecamatanOrtu','$edtKotaOrtu','$cbPropinsiOrtu','$edtKodePosOrtu','$edtTelponOrtu','$cbPendidikanAyah','$cbPendidikanIbu','$cbPekerjaanAyah','$cbPekerjaanIbu','$cbTempatTinggal','$cbPekerjaan','$edtNIP','$edtInstansi','$edtAlamatInstansi','$rbAlumni','$edtNoAnggota','$cbTextBook','$cbKunjunganKePerpustakaan','$cbKegiatan','$cbOlahRaga','$cbKesenian','$cbSumberBiayaStudi','$edtPenanggungBiaya','$cbBeasiswa','$edtAlamatSurat','$edtKelurahanSurat','$edtKecamatanSurat','$edtKotaSurat','$cbPropinsiSurat','$edtKodePosSurat','$edtTelponSurat','$edtEmail'");
  		$MySQL->Update("tbpmbupy","HRREGTBPMB='1'","where IDX='".$edtID."'","1");
		return True; 		
	} else {
		$msg .=", Gagal!, Pastikan Data yang Anda Masukkan Benar!<br>".$xxx;
		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
		echo $msg;
		echo "</div>";
		$act_log .=", Gagal!";
		return false;
	}				
	AddLog($id_admin,$act_log);	
}
?>