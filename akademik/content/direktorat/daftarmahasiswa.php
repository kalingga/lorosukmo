<?php
$idpage='13';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p']) && ($_GET['p'] != "refresh")) {
		$MySQL->Select("msmhsupy.IDX,msmhsupy.KDPSTMSMHS,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,msmhsupy.TPLHRMSMHS,msmhsupy.TGLHRMSMHS,msmhsupy.KDJEKMSMHS,msmhsupy.TAHUNMSMHS,msmhsupy.ASSMAMSMHS,msmhsupy.STPIDMSMHS,msmhsupy.SKSDIMSMHS,msmhsupy.ASNIMMSMHS,msmhsupy.ASPTIMSMHS,msmhsupy.ASJENMSMHS,msmhsupy.ASPSTMSMHS,mhsdtlupy.KDBLJMSMHS,mhsdtlupy.KLBLJMSMHS,mhsdtlupy.KBLHRMSMHS,mhsdtlupy.PRLHRMSMHS,mhsdtlupy.ISWNIMSMHS,mhsdtlupy.NEGRAMSMHS,mhsdtlupy.AGAMAMSMHS,mhsdtlupy.STSPLMSMHS,mhsdtlupy.ALMATMSMHS,mhsdtlupy.KLRHNMSMHS,mhsdtlupy.KCMTNMSMHS,mhsdtlupy.KOTAAMSMHS,mhsdtlupy.PRMHSMSMHS,mhsdtlupy.KDPOSMSMHS,mhsdtlupy.TELPOMSMHS,mhsdtlupy.ALDIYMSMHS,mhsdtlupy.KLDIYMSMHS,mhsdtlupy.KCDIYMSMHS,mhsdtlupy.KTDIYMSMHS,mhsdtlupy.PSDIYMSMHS,mhsdtlupy.TLDIYMSMHS,mhsdtlupy.TTSKSMSMHS,mhsdtlupy.JMSKSMSMHS,mhsdtlupy.THASLMSMHS,mhsdtlupy.NMSMUMSMHS,mhsdtlupy.LLSMUMSMHS,mhsdtlupy.STSMUMSMHS,mhsdtlupy.JNSMKMSMHS,mhsdtlupy.JRSMUMSMHS,mhsdtlupy.LKSMUMSMHS,mhsdtlupy.ALSMUMSMHS,mhsdtlupy.PRSMUMSMHS,mhsdtlupy.KTSMUMSMHS,mhsdtlupy.NMAYHMSMHS,mhsdtlupy.NMIBUMSMHS,mhsdtlupy.STAYHMSMHS,mhsdtlupy.STIBUMSMHS,mhsdtlupy.ALORTMSMHS,mhsdtlupy.KLORTMSMHS,mhsdtlupy.KCORTMSMHS,mhsdtlupy.KTORTMSMHS,mhsdtlupy.PRORTMSMHS,mhsdtlupy.PSORTMSMHS,mhsdtlupy.TLORTMSMHS,mhsdtlupy.PDAYHMSMHS,mhsdtlupy.PDIBUMSMHS,mhsdtlupy.KRAYHMSMHS,mhsdtlupy.KRIBUMSMHS,mhsdtlupy.KOSTMMSMHS,mhsdtlupy.KRJMHMSMHS,mhsdtlupy.NIPMHMSMHS,mhsdtlupy.NMKRJMSMHS,mhsdtlupy.ALKRJMSMHS,mhsdtlupy.IPGRIMSMHS,mhsdtlupy.NOANGMSMHS,mhsdtlupy.TXBOKMSMHS,mhsdtlupy.PERPUMSMHS,mhsdtlupy.AKTVSMSMHS,mhsdtlupy.OLHRGMSMHS,mhsdtlupy.SENIAMSMHS,mhsdtlupy.SMBYAMSMHS,mhsdtlupy.NMBYAMSMHS,mhsdtlupy.BSSWAMSMHS,mhsdtlupy.ALSRTMSMHS,mhsdtlupy.KLSRTMSMHS,mhsdtlupy.KCSRTMSMHS,mhsdtlupy.KTSRTMSMHS,mhsdtlupy.PRSRTMSMHS,mhsdtlupy.PSSRTMSMHS,mhsdtlupy.TLSRTMSMHS,mhsdtlupy.EMAILMSMHS","msmhsupy","LEFT OUTER JOIN mhsdtlupy ON (msmhsupy.NIMHSMSMHS = mhsdtlupy.NIMHSMSMHS) WHERE msmhsupy.IDX='".$_GET['id']."'","","1");
		$show=$MySQL->fetch_array();
		//Form 1
		$edtNIM=$show["NIMHSMSMHS"];
		$cbProdi=$show["KDPSTMSMHS"];
		$edtJenjang=$show["KDJENMSMHS"];
		$cbFakultas=LoadFakultas_X("",substr($cbProdi,0,1));
		$rbKelBelajar=$show["KDBLJMSMHS"];
		$edtKelBelajar=$show["KLBLJMSMHS"];
		$edtNama=$show["NMMHSMSMHS"];
		$rbJK=LoadKode_X("",$show["KDJEKMSMHS"],"08"); 
		$edtTglLahir=DateStr($show["TGLHRMSMHS"]);
		$edtTempatLahir=$show["TPLHRMSMHS"];
		$edtKabLahir=$show["KBLHRMSMHS"];
		$cbPropLahir=LoadPropinsi_X("",$show["PRLHRMSMHS"]);
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
	<p align="center"><b>DETAIL MAHASISWA</b></p>
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
						echo LoadProdi_X("",$cbProdi);
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
					if ($rbKelBelajar == 'P') {
						echo "Pusat";
					} elseif($rbKelBelajar == 'K') {
						echo "Kelompok Belajar, di ".$edtKelBelajar;
					} else {
						echo "";
					}
?>
				  </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>5.</td>
				    <td colspan="2">Nama Lengkap</td>
				    <td class="mandatory">
					: <?php echo $edtNama; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>6.</td>
				  <td colspan="2">Jenis Kelamin</td>
				  <td>: 
<?php 
						echo $rbJK; 
?>
				   </td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>7.</td>
				  <td colspan="2">Tanggal Lahir </td>
				  <td>: <?php echo $edtTglLahir; ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>8.</td>
				  <td colspan="2">Tempat Lahir </td>
				  <td>: <?php echo $edtTempatLahir; ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>9.</td>
				  <td colspan="2">Kabupaten</td>
				  <td>: <?php echo $edtKabLahir; ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>10.</td>
				  <td colspan="2">Propinsi</td>
				  <td>: 
<?php 
					echo $cbPropLahir; 
?>
				  </td>
			  </tr>
			  <tr>
				  <td>&nbsp;</td>
				  <td>11.</td>
				  <td colspan="2">Negara</td>
				  <td>: <?php echo $edtNegara; ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>12.</td>
				  <td colspan="2">Agama</td>
				  <td>:
                  <?php echo LoadKode_X("","$cbAgama","94"); ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>13.</td>
				  <td colspan="2">Status Sipil</td>
				  <td>:
                  <?php echo LoadKode_X("","$cbStatusSipil","93"); ?></td>
			  </tr>
				<tr><td colspan="5">&nbsp;</td></tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>14.</td>
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
				    <td>: <?php echo $edtAlamat; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Desa/Kelurahan</td>
				  <td>: <?php echo $edtKelurahan; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kecamatan</td>
				  <td>: <?php echo $edtKecamatan; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kabupaten/Kota</td>
				  <td>: <?php echo $edtKota; ?></td>
			    </tr>			    
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>Propinsi</td>
				    <td>: <?php echo LoadPropinsi_X("","$cbPropinsi"); ?></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>Kode Pos</td>
				    <td>: <?php echo $edtKodePos; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>Telepon / HP.</td>
				    <td>: <?php echo $edtTelpon; ?></td>
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
				  <td>: <?php echo $edtAlamatDIY; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Desa/Kelurahan</td>
				  <td>: <?php echo $edtKelurahanDIY; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kecamatan</td>
				  <td>: <?php echo $edtKecamatanDIY; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kabupaten/Kota</td>
				  <td>: <?php echo $edtKotaDIY; ?></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Kode Pos</td>
				  <td>: <?php echo $edtKodePosDIY; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Telepon / HP.</td>
				  <td>: <?php echo $edtTelponDIY; ?></td>
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
					: <?php echo LoadPropinsi_X("","$cbPropinsiAsal"); ?></td>
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
					if ($rbPindahan == 'P') {
						echo "Ya";
					} elseif($rbPindahan == 'B') {
						echo "Tidak";
					} else {
						echo "";
					}
?>
				</td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Tahun Masuk PT Asal</td>
			  	  <td> : <?php echo $edtTahunMasukAsal; ?></td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Nama PT. Asal </td>
			  	  <td>: 
<?php
					echo LoadPT_X("","$cbPerguruanTinggi");
?>					
				  </td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">NIM PT. Asal</td>
			  	  <td> : <?php echo $edtNimAsal; ?></td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Program Studi Asal </td>
			  	  <td>: 
<?php 
						echo LoadProdiDikti_X("","$cbProdiAsal");
?>
				  </td>
		  	    </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Jenjang Studi PT. Asal</td>
			  	  <td> : 
<?php 
						echo LoadKode_X("","$cbJenjang","04");
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
			  	  <td>: <?php echo $edtSMU; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>6.</td>
			  	  <td colspan="2">Tahun Lulus SMU / SMK Asal </td>
			  	  <td>: <?php echo $edtThnLulusSMU; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>7.</td>
			  	  <td colspan="2">Status SMU / SMK Asal </td>
			  	  <td>: 
<?php 
					echo LoadKode_X("","$cbStatusSMU","84");
?>
				  </td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>8.</td>
			  	  <td colspan="2">Jenis SMK, bila berasal dari SMK (Misal SMEA,STN,dsb.)</td>
			  	  <td>: <?php echo $edtJenisSMK; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>9.</td>
			  	  <td colspan="2">Bagian/Jurusan</td>
			  	  <td>: <?php echo $edtJurusanSMU; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>10.</td>
			  	  <td colspan="2">Lokasi SMU / SMTA Kejuruan </td>
			  	  <td>: <?php echo $edtLokasiSMU; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Alamat SMTA Asal </td>
			  	  <td>: <?php echo $edtAlamatSMU; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Kota /Kabupaten SMTA Asal </td>
			  	  <td>: <?php echo $edtKotaSMU; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Propinsi  SMTA Asal</td>
			  	  <td>: <?php echo LoadPropinsi_X("","$cbPropinsiSMU"); ?></td>
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
					: <?php echo $edtAyah; ?></td>
					<td width="1%"></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Ayah Masih Hidup</td>
				    <td>
					: 
<?php
					if ($rbAyah == '1') {
						echo "Hidup";
					} elseif($rbAyah == '0') {
						echo "Meninggal";
					} else {
						echo "";
					}
?>
		</td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>2.</td>
				    <td>Nama Lengkap Ibu</td>
				    <td>: <?php echo $edtIbu; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Ibu Masih Hidup</td>
				    <td>
					: 
<?php
					if ($rbIbu == '1') {
						echo "Hidup";
					} elseif($rbIbu == '0') {
						echo "Meninggal";
					} else {
						echo "";
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
				    <td>: <?php echo $edtAlamatOrtu; ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Desa/Kelurahan</td>
				    <td colspan="2">: <?php echo $edtKelurahanOrtu; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kecamatan</td>
				    <td colspan="2">: <?php echo $edtKecamatanOrtu; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kabupaten/Kota</td>
				    <td colspan="2">: <?php echo $edtKotaOrtu; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Propinsi</td>
				    <td>: <?php echo LoadPropinsi_X("","$cbPropinsiOrtu"); ?></td>
			    </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				    <td>Kode Pos</td>
				    <td>: <?php echo $edtKodePosOrtu; ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Telepon/HP.</td>
				    <td>: <?php echo $edtTelponOrtu; ?></td>
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
				  <td>: <?php echo LoadKode_X("","$cbPendidikanAyah","88") ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Ibu</td>
				  <td>: <?php echo LoadKode_X("","$cbPendidikanIbu","88") ?></td>
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
				  <td>: <?php echo LoadKode_X("","$cbPekerjaanAyah","96") ?></td>
			    </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Ibu</td>
				    <td>: <?php echo LoadKode_X("","$cbPekerjaanIbu","96") ?></td>
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
				    <td colspan="2">
					: <?php echo LoadKode_X("","$cbTempatTinggal","92")?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>2.</td>
				    <td>Pekerjaan</td>
				    <td colspan="2">
					: <?php echo LoadKode_X("","$cbPekerjaan","96"); ?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>3.</td>
				  <td>NIP / NIS </td>
				  <td colspan="2">:	<?php echo $edtNIP; ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>3.</td>
				    <td>Nama Kantor / Instansi</td>
				    <td colspan="2">: <?php echo $edtInstansi; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>4.</td>
				    <td>Alamat Kantor / Instansi</td>
				    <td colspan="2">: <?php echo $edtAlamatInstansi; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>5.</td>
				    <td>Merupakan Alumni PGRI</td>
					<td colspan="2">
					: 
<?php
					if ($rbAlumni == '1') {
						echo "Ya";
					} elseif($rbAlumni == '0') {
						echo "Tidak";
					} else {
						echo "";
					}

?>
					</td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>6.</td>
				    <td>No. Keanggotaan</td>
				    <td colspan="2">: <?php echo $edtNoAnggota ?></td>
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
			      <td>: <?php echo LoadKode_X("","$cbTextBook","91"); ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>8.</td>
				    <td colspan="2">Kunjungan ke Perpustakaan</td>
				    <td width="49%">: <?php echo LoadKode_X("","$cbKunjunganKePerpustakaan","90"); ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>9.</td>
				    <td colspan="2">Keterlibatan dalam kegiatan akademis di luar kuliah</td>
				    <td>: <?php echo LoadKode_X("","$cbKegiatan","89"); ?></td>
				</tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>10.</td>
			  	  <td colspan="2">Keterlibatan dalam kegiatan keolahragaan</td>
			  	  <td>: <?php echo LoadKode_X("","$cbOlahRaga","89"); ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>11.</td>
			  	  <td colspan="2">Keterlibatan dalam kegiatan keseniaan</td>
			  	  <td>:
                  <?php echo LoadKode_X("","$cbKesenian","89"); ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>12.</td>
			  	  <td colspan="2">Sumber Biaya Terbesar untuk Studi </td>
			  	  <td>: <?php echo LoadKode_X("","$cbSumberBiayaStudi","86"); ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>&nbsp;</td>
			  	  <td colspan="2">Nama Penanggung Biaya </td>
			  	  <td>: <?php echo $edtPenanggungBiaya; ?></td>
		  	  </tr>
			  	<tr>
			  	  <td>&nbsp;</td>
			  	  <td>14.</td>
			  	  <td colspan="2">Status Beasiswa (Bila Saudara Menerima beasiswa/tunjangan)</td>
		  	      <td>: <?php echo LoadKode_X("","$cbBeasiswa","85"); ?></td>
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
				    <td colspan="2">: <?php echo $edtAlamatSurat; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Desa/Kelurahan</td>
				    <td colspan="2">: <?php echo $edtKelurahanSurat; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kecamatan</td>
				    <td colspan="2">: <?php echo $edtKecamatanSurat; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Kabupaten/Kota</td>
				    <td colspan="2">: <?php echo $edtKotaSurat; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				    <td>Propinsi</td>
				    <td colspan="2">
					: <?php echo LoadPropinsi_X("","$cbPropinsiSurat"); ?></td>
		        </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
				    <td>Kode Pos</td>
				    <td colspan="2">: <?php echo $edtKodePosSurat; ?></td>
		        </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Telpon / HP. </td>
				  <td colspan="2">: <?php echo $edtTelponSurat; ?></td>
			  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>Email</td>
				  <td colspan="2">: <?php echo $edtEmail; ?></td>
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
		<button type='button' onClick=window.location.href='./?page=daftarmahasiswa' /><img src='images/b_back.png' class='btn_img'>&nbsp;Kembali</button>
	</center>
	<br>
	<script type="text/javascript">
	//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
	fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler", 0, 50)
	</script>
<?php
	} else {
		if (!isset($_GET['pos'])) $_GET['pos']=1;
		$page=$_GET['page'];
		$URLa="page=".$page;
		$sel="";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		echo "<form action='./?page=daftarmahasiswa' method='post' >";
		echo "<tr><td colspan='4'>Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='NIMHSMSMHS') $sel1="selected='selected'";
		if ($field=='NMMHSMSMHS') $sel2="selected='selected'";
	    if ($field=='mspstupy.NMPSTMSPST') $sel3="selected='selected'";
	
	    echo "<option value='NIMHSMSMHS' $sel1 >NP MAHASISWA</option>";
	    echo "<option value='NMMHSMSMHS' $sel2 >NAMA MAHASISWA</option>";
	    echo "<option value='mspstupy.NMPSTMSPST' $sel3 >PROGRAM STUDI</option>";
	     
	    echo "</select>";
	    echo "<input type='text' size='50' name='key' value='".$key."' />\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "</td><td colspan='3' align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=daftarmahasiswa&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";
	    echo "</td></tr></form>";
	
	  	$qry ="LEFT OUTER JOIN mspstupy mspstupy on (msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST) WHERE msmhsupy.STMHSMSMHS IN ('A','C','N')";
		if ($level_user=='1') {
			$pst=GetProdiInFakultas($akses_user);
			$qry .= " AND msmhsupy.KDPSTMSMHS IN $pst";
		}

		if ($level_user=='2') {
			$pst=$akses_user;
			$qry .= " AND msmhsupy.KDPSTMSMHS = '".$pst."'";
		}

		if (!empty($key)) {
			if ($level_user == '0') {
	  			$qry .= " AND ".$field." like '".$key."'";
	  		} else {
	  			$qry .= " AND ".$field." like '".$key."'";
			}
		}
		
		$MySQL->Select("msmhsupy.IDX,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST AS PROGRAMSTUDI,msmhsupy.STMHSMSMHS","msmhsupy",$qry,"TAHUNMSMHS DESC,KDPSTMSMHS ASC,NIMHSMSMHS ASC","","0");
	   	$total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
	
		$MySQL->Select("msmhsupy.IDX,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST AS PROGRAMSTUDI,msmhsupy.STMHSMSMHS","msmhsupy",$qry,"TAHUNMSMHS DESC,KDPSTMSMHS ASC,NIMHSMSMHS ASC","$start,$perpage","0");
	
	     echo "<tr><th colspan='7' style='background-color:#EEE'>DAFTAR MAHASISWA</th></tr>";
	     echo "<tr>
	     <th style='width:20px;'>NO</th> 
	     <th style='width:100px;'>NPM</th> 
	     <th style='width:350px;'>NAMA MAHASISWA</th> 
	     <th colspan='2'>PROGRAM STUDI</th>
	     <th style='width:10px;'>STATUS</th> 
	     <th style='width:20px;'>ACT</th>
	     </tr>";
	     $no=1;
		 if ($MySQL->Num_Rows() > 0){
		     while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
				if ($no % 2 == 1) $sel="sel";
				//$PILIHAN2= LoadProdi_X("",$show['PLHN2TBPMB']);
		     	echo "<tr>";
		     	echo "<td class='$sel'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['NIMHSMSMHS']."</td>";
		     	echo "<td class='$sel'>".$show['NMMHSMSMHS']."</td>";
		    	echo "<td class='$sel' colspan='2'>".$show['PROGRAMSTUDI']."</td>";
		    	echo "<td class='$sel tac'>".$show['STMHSMSMHS']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=daftarmahasiswa&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
		     }
		} else {
		     	echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
		}
     	echo "<tr><td colspan='7' class='fwb'>Keterangan : A=Aktif, C=Cuti, N=Non-Aktif</td></tr>";
		echo "<tr><td colspan='7'>";
	 	include "navigator.php";
		echo "</td></tr>";
	    echo "</table>";
	}
}
?>
