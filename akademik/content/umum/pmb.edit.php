<?php
if (isset($_SESSION[$PREFIX.'user'])) {
	$MySQL->Select("*","tbpmbupy","where IDX=".$_GET['id']."","","1");
} else {
	$MySQL->Select("*","tbpmbupy","where THNSMTBPMB='$thn' and NODTRTBPMB='$NoDaftar'","","1");
}
	$show=$MySQL->fetch_array();
	$edtID=$show['IDX'];
	$thn=$show['THNSMTBPMB'];
	$NoDaftar=$show['NODTRTBPMB'];
	$edtFormulir=$show['NOFRMTBPMB'];
	$edtNama=$show['NMPMBTBPMB'];
	$rbJK=$show['KDJEKTBPMB'];
	$edtLahir=$show['TPLHRTBPMB'];
	$edtTglLahir=DateStr($show['TGLHRTBPMB']);	
	$rbNegara=$show['KDWNITBPMB'];
	$edtNegara=$show['NEGRATBPMB'];
	$edtAlamat=$show['ALMT1TBPMB'];
	$edtKelurahan=$show['KELRHTBPMB'];
	$edtKota=$show['KABPTTBPMB'];
	$cbPropinsi=$show['PROPITBPMB'];
	$edtKodePos=$show['KDPOSTBPMB'];
	$edtTelp=$show['TELPOTBPMB'];
	$cbJenjang=$show['KDJENTBPMB'];
	$edtNamaPT=$show['SKASLTBPMB'];
	$edtJurusan=$show['JURSNTBPMB'];
	$edtAlamat1=$show['ALTSKTBPMB'];
	$edtKota1=$show['KABSKTBPMB'];
	$cbPropinsi1=$show['PROSKTBPMB'];
	$cbKerja=$show['STKRJTBPMB'];
	$edtKerja=$show['NMKRJTBPMB'];
	$edtAlamat2=$show['ALKRJTBPMB'];
	$rbAlumni=$show['ALMNITBPMB'];
	$edtAnggota=$show['ANGGTTBPMB'];
	$cbProdi1=$show['PLHN1TBPMB'];
	$cbProdi2=$show['PLHN2TBPMB'];
	$cbProgram=$show['PROGRTBPMB'];
	$cbStatus=$show['STPIDTBPMB'];
	$cbInformasi=$show['INFORTBPMB'];
?>
<form name="form1" action="./?page=pmb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" readonly>
	<input type="hidden" name="thn" value="<?php echo $thn; ?>" readonly>
	<input type="hidden" name="NoDaftar" value="<?php echo $NoDaftar; ?>" readonly>
	<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		<th rowspan="4" width="5%" align="left">&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
		<tr>
		<th colspan="2">Form Update Pendaftaran Mahasiswa Baru</th>
		</tr>
		<tr>
		<th>&nbsp;</th>
		</tr>
		<tr>
		<th>&nbsp;</th>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3" align="right">No Formulir : <input type="text" name="edtFormulir" value="<?php echo $edtFormulir; ?>" readonly></td></tr>
		<tr><td colspan="3"><b>Identitas Diri</b>
<span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></td><tr>
		    <td colspan="2">Nama Lengkap</td>
		    <td class="mandatory">
			: 
		    <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30" value="<?php echo $edtNama; ?>"></td>
	    </tr>
		<tr>
			<td colspan="2">Jenis Kelamin</td>
			<td>: <?php LoadJK_X("rbJK","$rbJK"); ?></td>
		</tr>
		<tr>
		    <td colspan="2">Tempat Lahir </td>
			<td>
			: 
		    <input size="20" type="text" name="edtLahir" maxlength="20" value="<?php echo $edtLahir; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Tanggal Lahir </td>
		    <td>
			:	
			<input type="text" name="edtTglLahir" size="10"  maxlength="10"  value="<?php echo $edtTglLahir; ?>"/>
			<a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglLahir',document.form1.edtTglLahir.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
	    </tr>
		<tr>
		    <td colspan="2">Kewarganegaraan</td>
			<td>
			: 
			<?php
				$WN1="";
				$WN2="";
				if ($rbAlumni=='1') {
					$WN1="Checked";
				} else {
					$WN2="Checked";					
				}
			?> 
		    <input name='rbNegara' type='radio' value='1' <?php echo $WN1; echo $WN2; ?> />WNI&nbsp;
		    <input name='rbNegara' type='radio' value='0' <?php echo $WN1; echo $WN2; ?> />WNA
	    </tr>
		<tr>
		    <td colspan="2">Negara</td>
			<td>
			: 
		    <input size="20" type="text" name="edtNegara" maxlength="20" value="<?php echo $edtNegara; ?>">
			<span style='font-size:11px; font-weight:normal;'>Diisi Apabila status kewarganegaraan WNA</span></td>
	    </tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="2"><b>Tempat Tinggal Saat Ini</b></td></tr>		
	  	<tr>
		    <td colspan="2">Alamat</td>
		    <td>:
			<input size="30" type="text" name="edtAlamat" maxlength="30" value="<?php echo $edtAlamat; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Kelurahan/Desa-Kecamatan</td>
		    <td>:
			<input size="20" type="text" name="edtKelurahan" maxlength="20" value="<?php echo $edtKelurahan; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Kabupaten/Kota</td>
		    <td>:
			<input size="20" type="text" name="edtKota" maxlength="20" value="<?php echo $edtKota; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Propinsi</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsi","$cbPropinsi"); ?></td>
	    </tr>
	    <tr>
		    <td colspan="2">Kode Pos</td>
		    <td>: 
	        <input size="5" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>"></td>
		</tr>
		<tr>
		    <td colspan="2">Telepon</td>
		    <td>
			: 
		    <input size="20" type="text" name="edtTelp" maxlength="20" value="<?php echo $edtTelp; ?>"></td>
	    </tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><b>Sekolah/Pendidikan Asal <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></b></td></tr>
		<tr>
		    <td colspan="2">Jenjang</td>
		    <td>
			: 
		    <?php LoadKode_X("cbJenjang","$cbJenjang","99") ?></td>
	    </tr>
		<tr>
		    <td colspan="2">Nama Sekolah/Perguruan Tinggi</td>
		    <td>
			: 
		    <input size="30" type="text" name="edtNamaPT" maxlength="30" value="<?php echo $edtNamaPT; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Program Studi/Jurusan</td>
		    <td>
			: 
		    <input size="30" type="text" name="edtJurusan" maxlength="30" value="<?php echo $edtJurusan; ?>"></td>
	    </tr>
	  	<tr>
		    <td colspan="2">Alamat Sekolah</td>
		    <td>:
			<input size="30" type="text" name="edtAlamat1" maxlength="30" value="<?php echo $edtAlamat1; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Kabupaten/Kota</td>
		    <td>:
			<input size="20" type="text" name="edtKota1" maxlength="20" value="<?php echo $edtKota1; ?>"></td>
	    </tr>
		<tr>
		    <td colspan="2">Propinsi</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsi1","$cbPropinsi"); ?></td>
	    </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		    <td colspan="2">Status Kerja</td>
		    <td>: <?php LoadKode_X("cbKerja","$cbKerja","96") ?></td>
	    </tr>
		<tr>
		    <td colspan="2">Nama Institusi Pekerjaan</td>
		    <td class="mandatory">: 
			<input size="30" type="text" name="edtKerja" maxlength="30" value="<?php echo $edtKerja; ?>">
			<span style='font-size:10px; font-weight:normal;'>Biarkan Kosong Bila Tidak Sedang Bekerja</span></td>
		</tr>
		<tr>
		    <td colspan="2">Alamat Institusi Pekerjaan</td>
		    <td class="mandatory">: 
			<input size="30" type="text" name="edtAlamat2" maxlength="30" value="<?php echo $edtAlamat2; ?>">
			<span style='font-size:10px; font-weight:normal;'>Biarkan Kosong Bila Tidak Sedang Bekerja</span></td>
		</tr>
		<tr>
		    <td colspan="2">Alumni Sekolah PGRI/Anggota PGRI</td>
		    <td>:
			<?php
				$Alumni1="";
				$Alumni2="";
				if ($rbAlumni=='1') {
					$Alumni1="Checked";
				} else {
					$Alumni2="Checked";					
				}
			?> 
		    <input name='rbAlumni' type='radio' value='1' <?php echo $Alumni1; echo $Alumni2; ?> />Ya&nbsp;
		    <input name='rbAlumni' type='radio' value='0' <?php echo $Alumni1; echo $Alumni2; ?> />Tidak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    </td>
		</tr>
		<tr>
		    <td colspan="2">No. Anggota</td>
		    <td class="mandatory">: 
		    <input size="12" type="text" name="edtAnggota" maxlength="12" value="<?php echo $edtAnggota; ?>">
			<span style='font-size:10px; font-weight:normal;'>Diisi Apabila Tercatat sebagai Anggota PGRI</span></td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3"><b>Program Studi Pilihan</b></td></tr>
		<tr>
		    <td colspan="2">Pilihan Pertama</td>
		    <td>: <?php LoadProdi_X("cbProdi1","$cbProdi1") ?></td>
	    </tr>
		<tr>
		    <td colspan="2">Pilihan Kedua</td>
		    <td>: <?php LoadProdi_X("cbProdi2","$cbProdi2") ?></td>
	    </tr>
		<tr>
		    <td colspan="2">Program/Kelas Kuliah yang Akan Diikuti</td>
			<td>: <?php LoadKode_X("cbProgram","$cbProgram","97") ?></td>
	    </tr>
		<tr>
		    <td colspan="2">Status Ketika Mendaftar di UPY</td>
			<td>: <?php LoadKode_X("cbStatus","$cbStatus","06") ?></td>
	    </tr>	    
		<tr>
		    <td colspan="2">Memperoleh Informasi Tentang UPY dari</td>
		    <td class="mandatory">: <?php LoadKode_X("cbInformasi","$cbInformasi","98") ?></td>
		</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
	    	<td colspan="3" align="center">
			<button type="button" onClick=window.location.href="./?page=pmb&amp;p=print&amp;id=<?php echo $edtID; ?>" />Cetak Kartu</button>
			<button type="reset" onClick=window.location.href="./?page=pmb" /><img src="images/b_reset.gif" class="btn_img" >&nbsp;Batal</button>
			<input type="submit" name="submit" value="Update" />
			</td>
		</tr>
	</table>
	</div>	
</form>