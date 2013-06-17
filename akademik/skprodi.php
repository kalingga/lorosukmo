<?php
$idpage='11';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$pst=$_GET['pst'];
	$edtSK="";
	$edtTglSK1="";
	$edtTglSK2="";
	$submited="Simpan";
	$HeaderTitle="Tambah";
	$MySQL->Select("NMPSTMSPST","mspstupy","where IDX='".$pst."'","","1");
	$show=$MySQL->fetch_array();
	$prodi=$show["NMPSTMSPST"];

	if (isset($_GET['act']) && ($_GET['act']=='edit')) {
		$edtID=$_GET['id'];
		$MySQL->Select("*","skpstupy","where IDX='".$edtID."'","","1");
		$show=$MySQL->Fetch_Array();
		$edtSK=$show['NOMSKMSPST'];
		$edtTglSK1=$show['TGLSKMSPST'];
		$edtTglSK2=$show['TGLAKMSPST'];
		$submited="Update";
		$HeaderTitle="Edit";
	}	

?>
<form name="form1" action="./?page=prodi&amp;p=edit&amp;id=<?php echo $pst; ?>" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
<input type="hidden" name="pst" value="<?php echo $pst; ?>">
<input type="hidden" name="edtID" value="<?php echo $edtID; ?>">
<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
	<th colspan="2">Form <?php echo $HeaderTitle; ?> Data Riwayat SK Dikti</th>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>SK. Dikti Terakhir</td>
		<td>: <input size="40" type="text" name="edtSK" maxlength="40" value="<?php echo $edtSK; ?>"></td>
	</tr>
    <tr>
	    <td>Tgl SK. Dikti</td>
	    <td colspan="3">: <input type="text" name="edtTglSK1" size="10"  maxlength="10" value="<?php echo DateStr($edtTglSK1); ?>" /> 
<a href="javascript:show_calendar('document.form1.edtTglSK1','document.form1.edtTglSK1',document.form1.edtTglSK1.value);">
<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
		</td>
	</tr>
    <tr>
	    <td>Berlaku s.d.</td>
	    <td>: 
		<input type="text" name="edtTglSK2" size="10"  maxlength="10" value="<?php echo DateStr($edtTglSK2); ?>" /> 
<a href="javascript:show_calendar('document.form1.edtTglSK2','document.form1.edtTglSK2',document.form1.edtTglSK2.value);">
<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
		</td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
    <tr>
	    <td colspan="2" align="center">
            <button type="button" onClick=window.location.href="./?page=prodi&amp;p=edit&amp;id=<?php echo $pst ?>" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
            <button type="submit" name="submit_2" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
		</td>
    </tr>
	</table>
</form>
<br>
<?php
}
?>