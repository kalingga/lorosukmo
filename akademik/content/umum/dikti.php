<?php
$idpage='9';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	/************ Tampilan depan / default form ***********/		
?>
	<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
	<tr><th colspan="4">DATA PERGURUAN TINGGI</th></tr>
	<tr><th colspan="4">&nbsp;</th></tr>
	<tr>
		<td>Kode PT.</td><td colspan="3">: <?php echo $edtKode; ?></td>
    </tr>
	<tr>
	    <td>Nama Perguruan Tinggi</td><td colspan="3">: <?php echo $edtNama; ?></td>
    </tr>
	<tr>
	    <td>Alamat</td><td colspan="3">: <?php echo $edtAlamat1; ?></td>
    </tr>
	<tr>
	    <td>&nbsp;</td><td colspan="3">&nbsp;&nbsp;<?php echo $edtAlamat2; ?></td>
    </tr>
	<tr>
	    <td width="27%">Kota</td><td width="34%">: <?php echo $edtKota; ?></td>
	    <td width="11%">Kode Pos</td>
	    <td width="28%">: <?php echo $edtKodePos; ?></td>
    </tr>
	<tr>
	    <td>Telepon</td>
	    <td colspan="3">: <?php echo $edtTelp; ?></td>
    </tr>
	<tr>
	    <td>Fax.</td>
	    <td colspan="3">: <?php echo $edtFax; ?></td>
    </tr>
	<tr>
	    <td>Email</td>
		<td colspan="3">: <?php echo $edtEmail; ?></td>
    </tr>
	<tr>
	    <td>Website</td>
	    <td colspan="3">: <?php echo $edtWeb; ?></td>
    </tr>
	<tr>
	    <td>Awal Berdiri</td>
	    <td colspan="3">: <?php echo DateStr($edtBerdiri); ?></td>
  	</tr>
	<tr><td colspan="4" align="center">&nbsp;</td></tr>
	<tr>
		<td colspan="4" class='fwb'>Pejabat Rektor</td>
    </tr>
	<tr>
			<td>Rektor</td><td>: <?php echo $edtRektor; ?></td>
			<td>NIDN</td><td>: <?php echo $edtNoRektor; ?></td>
    </tr>
	<tr>
			<td>Pembantu Rektor I</td><td>: <?php echo $edtPR1; ?></td>
			<td>NIDN</td><td>: <?php echo $edtNoPR1; ?></td>
    </tr>
	<tr>
			<td>Pembantu Rektor II</td><td>: <?php echo $edtPR2; ?></td>
			<td>NIDN</td><td>: <?php echo $edtNoPR2; ?></td>
    </tr>
	<tr>
			<td>Pembantu Rektor III</td><td>: <?php echo $edtPR3; ?></td>
			<td>NIDN</td><td>: <?php echo $edtNoPR3; ?></td>
    </tr>
	<tr><td colspan="4" align="center">&nbsp;</td></tr>
	</table>
	<br>
<?php
/************** Data Badan Hukum **********************/
	 echo "<table align='center' border='0' align='center' style='width:80%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
     echo "<tr><th colspan='4' style='background-color:#EEE'>RIWAYAT AKTA/SK PERGURUAN TINGGI</th></tr>";
     echo "<tr>
     <th colspan='2'>NO</th> 
     <th style='width:300px;'>NO AKTA/SK</th> 
     <th style='width:300px;'>TGL AKTA/SK</th>
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
     	echo "</tr>";
     	$no++;
    	}
     } else {
     	echo "<tr><td colspan='4' class='$sel tac' style='color:red'>".$msg_data_empty."</td></tr>";
	 }
     echo "</table><br>";
}
?>
