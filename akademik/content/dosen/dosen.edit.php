<form name="form1" action="./?page=<?php echo $page; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
<input type="hidden" name="edtID" value="<?php echo $id; ?>">
	<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
		<th colspan="2">Form Tambah Data</th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>	
		<tr>
		  <td width="40%">Kode</td>
		  <td class="mandatory">: <input size="10" type="text" name="edtKode" id="edtKode" maxlength="10" value="<?php echo $edtKode; ?>"></td>
		</tr>	      
		<tr>
		    <td>Nama</td>
		    <td class="mandatory">
			: 
		    <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30" value="<?php echo $edtNama; ?>"></td>
	    </tr>
		<tr>
		    <td>NIDN</td>
		    <td>
			: 
		    <input size="10" type="text" name="edtNIDN" maxlength="10" value="<?php echo $edtNIDN; ?>"></td>
	    </tr>
		<tr>
		    <td>No. KTP </td>
		    <td>
			: 
		    <input size="25" type="text" name="edtKTP" maxlength="25" value="<?php echo $edtKTP; ?>"></td>
	    </tr>
		<tr>
		    <td>Tempat Lahir </td>
			<td>
			: 
		    <input size="20" type="text" name="edtLahir" maxlength="20" value="<?php echo $edtLahir; ?>"></td>
	    </tr>
		<tr>
		    <td>Tanggal Lahir </td>
		    <td>
			:	
			<input type="text" name="edtTglLahir" size="10"  maxlength="10" value="<?php echo $edtTglLahir; ?>" />
			<a href="javascript:show_calendar('document.form1.edtTglLahir','document.form1.edtTglLahir',document.form1.edtTglLahir.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
	    </tr>
		<tr>
			<td>Jenis Kelamin </td>
			<td>: <?php LoadJK_X("rbJK","$rbJK"); ?></td>
		</tr>    
		<tr>
		    <td>Jabatan Akademik </td>
		    <td>
			: <?php LoadKode_X("cbJabatan","$cbJabatan","02"); ?>
	    </tr>
		<tr>
		    <td>Ikatan Kerja Dosen di PTS Bersangkutan</td>
		    <td class="mandatory">: 
		    <?php LoadKode_X("cbKerja","$cbKerja","03")?>
		    </td>
		</tr>
		<tr>
		    <td>Status</td>
		    <td class="mandatory">: 
		    <?php LoadKode_X("cbStatus","$cbStatus","15")?>
		    </td>
		</tr>
		<tr>
		    <td>Tahun Semester Mulai Hapus </td>
		    <td class="mandatory">: 
		    <input size="4" type="text" name="edtTahun" id="edtTahun" maxlength="4" value="<?php echo $edtTahun; ?>"><?php LoadSemester_X("cbSemester","$cbSemester"); ?>
			&nbsp;<span style='font-size:10px; font-weight:normal;'>Diisi Apabila Dosen berstatus Keluar/Pensiun/Alm</span></td>
		</tr>
		<tr>
		    <td>Tercatat Sbg Dosen di Fakultas : </td>
		    <td>:
			<?php LoadFakultas_X("cbFakultas","$cbFakultas") ?></td>
	    </tr>				
		<tr>
		    <td>Instansi Induk Tempat Dosen Bernaung</td>
		    <td class="mandatory">: 
			<input size="6" type="text" name="edtInstansi" id="edtInstansi" maxlength="6" value="<?php echo $edtInstansi; ?>">
			&nbsp;<span style='font-size:10px; font-weight:normal;'>Diisi Dengan Kode Perguruan Tinggi</span>
	    </td>
		</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
	    	<td colspan="2" align="center">
			<button type="button" onClick=window.location.href="./?page=<? echo $page; ?>" /><img src="images/b_reset.gif" class="btn_img">&nbsp;Batal</button>
			<input type="submit" name="submit" value="Update" />
			</td>
		</tr>
	</table>
</form>
<?php
		/********** Riwayat Status Akreditasi ********************/
			echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr><th colspan='6' style='background-color:#EEE'>Riwayat Akreditasi</th></tr>";
			echo "<tr>
			     <th style='width:150px;'>Status Akreditasi</th> 
			     <th style='width:150px;'>Nomor SK Akreditasi</th> 
			     <th style='width:150px;'>Tanggal SK Akreditasi</th> 
			     <th style='width:150px;'>Berlaku S.d.</th> 
			     <th colspan='2' style='width:20px;'>ACT</th> 
			     </tr>";
			$MySQL->Select("*","akpstupy","where IDPSTMSPST='".$id."'","TGLBAMSPST DESC","","0");
			if ($MySQL->Num_Rows() > 0){
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tac'>".$show['KDSTAMSPST']."</td>";
			     	echo "<td class='$sel'>".$show['NOMBAMSPST']."</td>";
			     	echo "<td class='$sel tac'>".DateStr($show['TGLBAMSPST'])."</td>";
			     	echo "<td class='$sel'>".DateStr($show['TGLABMSPST'])."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=akreditasi&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=".$page."&amp;subpage=akreditasi&amp;p=delete&amp;id=".$id."&amp;sk=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;	     	
		     	}
			} else {
		 		echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";
			}
		    echo "</table>";
		
			/********** Riwayat SK Penetapan Program Studi ********************/
			echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr>";
			echo "<tr><th colspan='5' style='background-color:#EEE'>Riwayat Surat Keputusan Dikti</th></tr>";
			echo "<tr>
			     <th style='width:200px;'>Nomor SK Dikti</th> 
			     <th style='width:200px;'>Tanggal SK Dikti</th> 
			     <th style='width:200px;'>Berlaku S.d.</th> 
			     <th colspan='2' style='width:20px;'>ACT</th> 
			     </tr>";
			$MySQL->Select("*","skpstupy","where IDPSTMSPST='".$id."'","TGLSKMSPST DESC","","0");
			if ($MySQL->Num_Rows() > 0){
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel'>".$show['NOMSKMSPST']."</td>";
			     	echo "<td class='$sel tac'>".DateStr($show['TGLSKMSPST'])."</td>";
			     	echo "<td class='$sel'>".DateStr($show['TGLAKMSPST'])."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=skprodi&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=".$page."&amp;subpage=skprodi&amp;p=delete&amp;id=".$id."&amp;sk=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;
				}
			} else {
		 		echo "<td colspan='5' align='center' style='color:red;'>".$msg_data_empty."</td>";
			}
		     	echo "</table>";
?>
