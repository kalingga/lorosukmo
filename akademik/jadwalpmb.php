<?php
$idpage='29';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
//	$edtID=$_GET['id'];
	$submited="addshift";
	$substr="Simpan";
	if (isset($_GET['kd'])){
		$edtKd=$_GET['kd'];
		$MySQL->Select("setpmbdtl.*","setpmbdtl","where setpmbdtl.IDX='".$edtKd."'","1");
		$show=$MySQL->fetch_array();
		$edtID=$show['IDPMBSETPMB'];
		$edtShift=$show['SHIFTSETPMB'];
		$edtJam=$show['WAKTUSETPMB'];
		$edtDurasi=$show['DURWKSETPMB'];
		$submited="editshift";
		$substr="Update";
	}
?>
	<form name="form1" action="./?page=setpmb&amp;p=edit&amp;id=<?php echo $edtID; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	<input type="hidden" name="edtID" size="11" maxlength="11" value="<?php echo $edtID; ?>" />
	<input type="hidden" name="edtKd" size="11" maxlength="11" value="<?php echo $edtKd; ?>" />
	<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
	<th colspan="2">Form Tambah Data Shift PMB</th>
	</tr>
	<tr>
		<th colspan="2">TA. <?php echo $edtThnAjaran."/".($edtThnAjaran+1); ?>&nbsp;
		Sem. <?php echo LoadSemester_X("","$cbSemester"); ?>
		Gel. <?php echo $edtGelombang; ?>
		</th>
	</tr>
	<tr>
	<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
	 <td style="width:150px;" >Shift</td>
	 <td>: <input type="text" name="edtShift" size="5" maxlength="5" value="<?php echo $edtShift; ?>"/></td>
	</tr>
	 <td>Waktu Pelaksanaan</td>
	 <td>: <input type="text" name="edtJam" size="5" maxlength="5" value="<?php echo $edtJam; ?>" />&nbsp;hh:mm</td>
	</tr>
	<tr>
	 <td>Durasi Waktu</td>
	 <td>: <input type="text" name="edtDurasi" size="3" maxlength="3"  value="<?php echo $edtDurasi; ?>"/>&nbsp;menit</td>
	</tr>
	<tr>
	 <td colspan="2" align="center">
	 	<button type="reset"  onClick=window.location.href="./?page=setpmb&amp;p=edit&amp;id=<?php echo $edtID; ?>"><img src="images/b_reset.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;
        <button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $substr; ?></button>
	 </td>
	</tr>
	</table>
	</form>
	<br>
<?php
}
?>