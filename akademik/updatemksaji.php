<?php
$idpage='19';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$MySQL->Select("LEVELUSER","tbuser","where USERID='".$id_admin."'","","1");
	$show=$MySQL->fetch_array();
	$fak=$show['LEVELUSER'];	
?>
<form name="form1" action="./?page=updatemksaji" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr><th colspan="2">Form Pendataan Matakuliah Saji</th>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td width="30%">Silahkan Masukkan Program Studi</td>
		<td>: 
<?php
			LoadProdi_X("cbProdi","$cbProdi","$fak");
?>			
		</td>
	</tr>
	<tr>
		<td>Tahun Semester</td>
		<td>: 
			<input type="text" name="edtTahun" id="edtTahun" size="4" maxlength="4" value="<?php echo $edtTahun; ?>" required="1" regexp = "/^\d*$/" realname = "Tahun Ajaran" />
<?php
			LoadSemester_X("cbSemester","$cbSemester");
?>			
		</td>
	</tr>
	<tr>
		<td colspan="2" class="tac">
			<br>
			<button type="submit" name="p" value="Submit" />Submit&nbsp;<img src="images/b_go.png" class="btn_img"></button>
		</td>
	</tr>	

</table>
</form>
<br>
<?php
}
?>