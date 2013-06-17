<form name="form1" action="./?page=pmb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
		<th colspan="2">Form Pendaftaran Mahasiswa Baru</th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2" align="right">No Formulir : <input type="text" name="edtFormulir" value="<?php echo $noForm; ?>" readonly></td></tr>
		<tr><td colspan="2"><b>Identitas Diri</b>
<span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></td><tr>
		    <td width="35%">Nama Lengkap</td>
		    <td class="mandatory">
			: 
		    <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30"></td>
	    </tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>: <?php LoadJK_X("rbJK",""); ?></td>
		</tr>
		<tr>
		    <td>Tempat Lahir </td>
			<td>
			: 
		    <input size="20" type="text" name="edtLahir" maxlength="20"></td>
	    </tr>
		<tr>
		    <td>Tanggal Lahir </td>
		    <td>
			:	
			<input type="text" name="edtTglLahir" size="10"  maxlength="10" />
			<a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglLahir',document.form1.edtTglLahir.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
	    </tr>
		<tr>
		    <td>Kewarganegaraan</td>
			<td>
			: 
		    <input name='rbNegara' type='radio' value='1' />WNI&nbsp;
		    <input name='rbNegara' type='radio' value='0' />WNA
	    </tr>
		<tr>
		    <td>Negara</td>
			<td>
			: 
		    <input size="20" type="text" name="edtNegara" maxlength="20">
			<span style='font-size:11px; font-weight:normal;'>Diisi Apabila status kewarganegaraan WNA</span></td>
	    </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><b>Tempat Tinggal Saat Ini</b></td></tr>		
	  	<tr>
		    <td>Alamat</td>
		    <td>:
			<input size="30" type="text" name="edtAlamat" maxlength="30"></td>
	    </tr>
		<tr>
		    <td>Kelurahan/Desa-Kecamatan</td>
		    <td>:
			<input size="20" type="text" name="edtKelurahan" maxlength="20"></td>
	    </tr>
		<tr>
		    <td>Kabupaten/Kota</td>
		    <td>:
			<input size="20" type="text" name="edtKota" maxlength="20"></td>
	    </tr>
		<tr>
		    <td>Propinsi</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsi",""); ?></td>
	    </tr>
	    <tr>
		    <td>Kode Pos</td>
		    <td>: 
	        <input size="5" type="text" name="edtKodePos" maxlength="5"></td>
		</tr>
		<tr>
		    <td>Telepon</td>
		    <td>
			: 
		    <input size="20" type="text" name="edtTelp" maxlength="20"></td>
	    </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2"><b>Sekolah/Pendidikan Asal <span style='font-size:10px; font-weight:normal;'>(Sesuai Ijazah Terakhir)</span></b></td></tr>
		<tr>
		    <td>Jenjang</td>
		    <td>
			: 
		    <?php LoadKode_X("cbJenjang","","99") ?></td>
	    </tr>
		<tr>
		    <td>Nama Sekolah/Perguruan Tinggi</td>
		    <td>
			: 
		    <input size="30" type="text" name="edtNamaPT" maxlength="30"></td>
	    </tr>
		<tr>
		    <td>Program Studi/Jurusan</td>
		    <td>
			: 
		    <input size="30" type="text" name="edtJurusan" maxlength="30"></td>
	    </tr>
	  	<tr>
		    <td>Alamat Sekolah</td>
		    <td>:
			<input size="30" type="text" name="edtAlamat1" maxlength="30"></td>
	    </tr>
		<tr>
		    <td>Kabupaten/Kota</td>
		    <td>:
			<input size="20" type="text" name="edtKota1" maxlength="20"></td>
	    </tr>
		<tr>
		    <td>Propinsi</td>
		    <td>
			: <?php LoadPropinsi_X("cbPropinsi1",""); ?></td>
	    </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		    <td>Status Kerja</td>
		    <td>: <?php LoadKode_X("cbKerja","","96") ?></td>
	    </tr>
		<tr>
		    <td>Nama Institusi Pekerjaan</td>
		    <td class="mandatory">: 
			<input size="30" type="text" name="edtKerja" maxlength="30">
			<span style='font-size:10px; font-weight:normal;'>Biarkan Kosong Bila Tidak Sedang Bekerja</span></td>
		</tr>
		<tr>
		    <td>Alamat Institusi Pekerjaan</td>
		    <td class="mandatory">: 
			<input size="30" type="text" name="edtAlamat2" maxlength="30">
			<span style='font-size:10px; font-weight:normal;'>Biarkan Kosong Bila Tidak Sedang Bekerja</span></td>
		</tr>
		<tr>
		    <td>Alumni Sekolah PGRI/Anggota PGRI</td>
		    <td>: 
		    <input name='rbAlumni' type='radio' value='1' />Ya&nbsp;
		    <input name='rbAlumni' type='radio' value='0' />Tidak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    </td>
		</tr>
		<tr>
		    <td>No. Anggota</td>
		    <td class="mandatory">: 
		    <input size="12" type="text" name="edtAnggota" maxlength="12">
			<span style='font-size:10px; font-weight:normal;'>Diisi Apabila Tercatat sebagai Anggota PGRI</span></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="4"><b>Program Studi Pilihan</b></td></tr>
		<tr>
		    <td>Pilihan Pertama</td>
		    <td>: <?php LoadProdi_X("cbProdi1","") ?></td>
	    </tr>
		<tr>
		    <td>Pilihan Kedua</td>
		    <td>: <?php LoadProdi_X("cbProdi2","") ?></td>
	    </tr>
		<tr>
		    <td>Program/Kelas Kuliah yang Akan Diikuti</td>
			<td>: <?php LoadKode_X("cbProgram","","97") ?></td>
	    </tr>
		<tr>
		    <td>Status Ketika Mendaftar di UPY</td>
			<td>: <?php LoadKode_X("cbStatus","","06") ?></td>
	    </tr>	    
		<tr>
		    <td>Memperoleh Informasi Tentang UPY dari</td>
		    <td class="mandatory">: <?php LoadKode_X("cbInformasi","","98") ?></td>
		</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
	    	<td colspan="2" align="center">
	    	<?php
	    		$click="";
	    		if (isset($_SESSION[$PREFIX.'id_group']) && ($_SESSION[$PREFIX.'id_group']!= 0 || $_SESSION[$PREFIX.'id_group'] == 1)) {
					$click="onClick=window.location.href='./?page=pmb'";
				}
	    	?>
			<button type="reset" onClick=window.location.href='./?page=pmb' /><img src="images/b_reset.gif" class="btn_img">&nbsp;Batal</button>
			<input type="submit" name="submit" value="Simpan" />
			</td>
		</tr>
	</table>
</form>