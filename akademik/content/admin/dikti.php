<?php
$idpage='9';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (!isset($_GET['p']) || ($_GET['p'] == 'delete')) {
	/************ Tampilan depan / default form ***********/		
?>
	<form name="form1" action="./?page=dikti" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
		<tr><th colspan="4">FORM UPDATE DATA PERGURUAN TINGGI</th></tr>
		<tr><th colspan="4">&nbsp;</th></tr>
		<tr><td>Kode PT.</td>
		    <td colspan="3" class="mandatory">: 
			<input size="6" type="text" name="edtKode" id="edtKode" maxlength="6" value="<?php echo $edtKode; ?>"></td>
	    </tr>
		<tr>
		    <td>Nama Perguruan Tinggi</td>
		    <td colspan="3" class="mandatory">: 
		    <input size="50" type="text" name="edtNama" id="edtNama" maxlength="50" value="<?php echo $edtNama; ?>"></td>
	    </tr>
		<tr>
		    <td>Alamat</td>
		    <td colspan="3">:
			<input size="30" type="text" name="edtAlamat1" maxlength="30" value="<?php echo $edtAlamat1; ?>"></td>
	    </tr>
		<tr>
		    <td>&nbsp;</td>
		    <td colspan="3">&nbsp;
			<input class="inputbox" size="30" type="text" name="edtAlamat2" maxlength="30" value="<?php echo $edtAlamat2; ?>"></td>
	    </tr>
		<tr>
		    <td width="27%">Kota</td>
		    <td width="34%">:
			<input size="20" type="text" name="edtKota" maxlength="20" value="<?php echo $edtKota; ?>"></td>
		    <td width="11%">Kode Pos</td>
		    <td width="28%">: 
	        <input class="inputbox" size="5" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>"></td>
	    </tr>
		<tr>
		    <td>Telepon</td>
		    <td colspan="3">: 
		    <input size="20" type="text" name="edtTelp" maxlength="20" value="<?php echo $edtTelp; ?>"></td>
	    </tr>
		<tr>
		    <td>Fax.</td>
		    <td colspan="3">: 
		    <input size="20" type="text" name="edtFax" maxlength="20" value="<?php echo $edtFax; ?>"></td>
	    </tr>
		<tr>
		    <td>Email</td>
			<td colspan="3" class="mandatory">: 
		    <input size="40" type="text" name="edtEmail" id="edtEmail" maxlength="40" value="<?php echo $edtEmail; ?>"></td>
	    </tr>
		<tr>
		    <td>Website</td>
		    <td colspan="3">: 
		    <input size="40" type="text" name="edtWeb" maxlength="40" value="<?php echo $edtWeb; ?>"></td>
	    </tr>
		<tr>
		    <td>Awal Berdiri</td>
		    <td colspan="3">: 
			<input type="text" name="edtBerdiri" size="10"  maxlength="10" value="<?php echo DateStr($edtBerdiri); ?>"/> 
<a href="javascript:show_calendar('document.form1.edtBerdiri','document.form1.edtBerdiri',document.form1.edtBerdiri.value);">
<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
			</td>
      	</tr>
		<tr><td colspan="4" align="center">&nbsp;</td></tr>
		<tr>
			<td colspan="4" class='fwb'>Pejabat Rektor</td>
	    </tr>
		<tr>
			<td>Rektor</td><td>: <input size="40" type="text" name="edtRektor" maxlength="40" value="<?php echo $edtRektor; ?>"></td>
			<td>NIDN</td><td>: <input size="10" type="text" name="edtNoRektor" maxlength="10" value="<?php echo $edtNoRektor; ?>"></td>
	    </tr>
		<tr>
			<td>Pembantu Rektor I</td><td>: <input size="40" type="text" name="edtPR1" maxlength="40" value="<?php echo $edtPR1; ?>"></td>
			<td>NIDN</td><td>: <input size="10" type="text" name="edtNoPR1" maxlength="10" value="<?php echo $edtNoPR1; ?>"></td>
	    </tr>
		<tr>
			<td>Pembantu Rektor II</td><td>: <input size="40" type="text" name="edtPR2" maxlength="40" value="<?php echo $edtPR2; ?>"></td>
			<td>NIDN</td><td>: <input size="10" type="text" name="edtNoPR2" maxlength="10" value="<?php echo $edtNoPR2; ?>"></td>
	    </tr>
		<tr>
			<td>Pembantu Rektor III</td><td>: <input size="40" type="text" name="edtPR3" maxlength="40" value="<?php echo $edtPR3; ?>"></td>
			<td>NIDN</td><td>: <input size="10" type="text" name="edtNoPR3" maxlength="10" value="<?php echo $edtNoPR3; ?>"></td>
	    </tr>
		<tr><td colspan="4" align="center">&nbsp;</td></tr>
		<tr>
		    <td colspan="4" align="center">
            <button type="submit" name="submit" value="Update" /><img src="images/b_save.gif" class="btn_img">&nbsp;Update</button>
			</td>
      	</tr>
	</table>
	</form>
	<br>
<?php
	}
/************** Data Badan Hukum **********************/
	 echo "<table align='center' border='0' align='center' style='width:80%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
     echo "<tr><th colspan='6' align='left' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=dikti&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></th></tr>";     
     echo "<tr><th colspan='6' style='background-color:#EEE'>RIWAYAT AKTA/SK PERGURUAN TINGGI</th></tr>";
     echo "<tr>
     <th colspan='2'>NO</th> 
     <th style='width:300px;'>NO AKTA/SK</th> 
     <th style='width:300px;'>TGL AKTA/SK</th> 
     <th colspan='2'>ACT</th> 
     </tr>";
     $MySQL->Select("*","tbskptupy","where IDXPTMSPTI='".$edtIdPT."'","TGPTIMSPTI DESC","","0");
	 if (($MySQL->Num_Rows()) > 0){
     $no=1;
     while ($show=$MySQL->Fetch_Array()){
     	$sel="";
     	if ($no==1){
			$default="<img border='0' src='images/ico_check.png' title='DEFAULT' />";
		} else {
			$default='';
		}
		if ($no % 2 == 1) $sel="sel";	     	
     	echo "<tr>";
     	echo "<td class='$sel tac'  style='width:50px;'>".$default."</td>";
     	echo "<td class='$sel tac'  style='width:50px;'>".$no."</td>";
     	echo "<td class='$sel'>".$show['NOMSKMSPTI']."</td>";
     	echo "<td class='$sel'>".DateStr($show['TGPTIMSPTI'])."</td>";
   		echo "<td class='$sel tac' style='width:20px;'><a href='./?page=dikti&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a></td>";
     	echo "<td class='$sel tac' style='width:20px;'><a href='./?page=dikti&amp;p=delete&amp;id=".$show['IDX']."'>
     	<img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/>
     	</a></td>";
     	echo "</tr>";
     	$no++;
    	}
     } else {
     	echo "<tr><td colspan='6' class='$sel tac' style='color:red'>".$msg_data_empty."</td></tr>";
	 }
     echo "</table><br>";
}
?>
