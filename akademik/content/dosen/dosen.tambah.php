<form name="form1" action="./?page=dosen" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
		<th colspan="2">Form Tambah Data</th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>	
		<tr>
		  <td width="35%">Kode</td>
		  <td class="mandatory">: <input size="10" type="text" name="edtKode" id="edtKode" maxlength="10"></td>
		</tr>	      
		<tr>
		    <td>Nama</td>
		    <td class="mandatory">
			: 
		    <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30"></td>
	    </tr>
		<tr>
		    <td>NIDN</td>
		    <td>
			: 
		    <input size="10" type="text" name="edtNIDN" maxlength="10"></td>
	    </tr>
		<tr>
		    <td>NIP</td>
		    <td>
			: 
		    <input size="9" type="text" name="edtNIP" maxlength="9"></td>
	    </tr>
		<tr>
		    <td>No. KTP </td>
		    <td>
			: 
		    <input size="25" type="text" name="edtKTP" maxlength="25"></td>
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
			<td>Jenis Kelamin </td>
			<td>: <?php LoadJK_X("rbJK",""); ?></td>
		</tr>    
		<tr>
		    <td>Jabatan Akademik </td>
		    <td>
			: <?php LoadKode_X("cbJabatan","","02"); ?>
	    </tr>
		<tr>
		    <td>Ikatan Kerja Dosen di PTS Bersangkutan</td>
		    <td class="mandatory">: 
		    <?php LoadKode_X("cbKerja","","03")?>
		    </td>
		</tr>
		<tr>
		    <td>Status</td>
		    <td class="mandatory">: 
		    <?php LoadKode_X("cbStatus","","15")?>
		    </td>
		</tr>
		<tr>
		    <td>Tahun Semester Mulai Hapus </td>
		    <td class="mandatory">: 
		    <input size="4" type="text" name="edtTahun" id="edtTahun" maxlength="4">
			<?php LoadSemester_X("cbSemester",""); ?>
			&nbsp;<span style='font-size:10px; font-weight:normal;'>Diisi Apabila Dosen berstatus Keluar/Pensiun/Alm</span></td>
		</tr>
		<tr>
		    <td>Tercatat Sbg Dosen di Fakultas : </td>
		    <td>:
			<?php LoadFakultas_X("cbFakultas","") ?></td>
	    </tr>				
		<tr>
		    <td>Instansi Induk Tempat Dosen Bernaung</td>
		    <td class="mandatory">: 
			<input size="6" type="text" name="edtInstansi" id="edtInstansi" maxlength="6">
			&nbsp;<span style='font-size:10px; font-weight:normal;'>Diisi Dengan Kode Perguruan Tinggi</span>
	    </td>
		</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
	    	<td colspan="2" align="center">
			        <button type="button" onClick=window.location.href="./?page=<? echo $page; ?>" /><img src="images/b_reset.gif" class="btn_img">&nbsp;Batal</button>
			<input type="submit" name="submit" value="Simpan" />
			</td>
		</tr>
	</table>
</form>