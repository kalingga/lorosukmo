<?php
$idpage='11';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$pst=$_GET['pst'];
	$cbAkreditasi="";
	$edtBAN="";
	$edtTglBAN1="";
	$edtTglBAN2="";
	$submited="Simpan";
	$HeaderTitle="Tambah";
	$MySQL->Select("NMPSTMSPST","mspstupy","where IDX='".$pst."'","","1");
	$show=$MySQL->fetch_array();
	$prodi=$show["NMPSTMSPST"];

	if (isset($_GET['act']) && ($_GET['act']=='edit')) {
		$edtID=$_GET['id'];
		$MySQL->Select("*","akpstupy","where IDX='".$edtID."'","","1");
		$show=$MySQL->Fetch_Array();
		$cbAkreditasi=$show['KDSTAMSPST'];
		$edtBAN=$show['NOMBAMSPST'];
		$edtTglBAN1=$show['TGLBAMSPST'];
		$edtTglBAN2=$show['TGLABMSPST'];
		$submited="Update";
		$HeaderTitle="Edit";
	}
?>
<form name="form1" action="./?page=prodi&amp;p=edit&amp;id=<?php echo $pst; ?>" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
<input type="hidden" name="pst" value="<?php echo $pst; ?>">
<input type="hidden" name="edtID" value="<?php echo $edtID; ?>">
<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
	<th colspan="2">Form  <?php echo $HeaderTitle; ?> Data Riwayat Akreditasi Program Studi <?php echo $prodi; ?></th>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	<tr><td width="20%">Status Akreditasi</td>
		<td class="inputtext">: 
	  <?php LoadKode_X("cbAkreditasi","$cbAkreditasi","07"); ?></td>
	  </tr>
	<tr>
		<td>No. SK. Akreditasi</td>
		<td>: <input size="40" type="text" name="edtBAN" maxlength="40" value="<?php echo $edtBAN; ?>"></td>
	</tr>
    <tr>
	    <td>Tgl SK. Akreditasi</td>
	    <td colspan="3">: <input type="text" name="edtTglBAN1" size="10"  maxlength="10" value="<?php echo DateStr($edtTglBAN1); ?>" /> 
<a href="javascript:show_calendar('document.form1.edtTglBAN1','document.form1.edtTglBAN1',document.form1.edtTglBAN1.value);">
<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
		</td>
	</tr>
    <tr>
	    <td>Berlaku s.d.</td>
	    <td>: 
		<input type="text" name="edtTglBAN2" size="10"  maxlength="10" value="<?php echo DateStr($edtTglBAN2); ?>" /> 
<a href="javascript:show_calendar('document.form1.edtTglBAN2','document.form1.edtTglBAN2',document.form1.edtTglBAN2.value);">
<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
		</td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
    <tr>
	    <td colspan="2" align="center">
            <button type="button" onClick=window.location.href="./?page=prodi&amp;p=edit&amp;id=<?php echo $pst ?>" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
            <button type="submit" name="submit_1" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
		</td>
    </tr>
	</table>
</form>
<br>
<?php
}
?>