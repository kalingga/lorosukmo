<?php
$idpage='8';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	/************ Tampilan depan / default form ***********/
?>
<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
	<tr><th colspan="4">DATA YAYASAN</th></tr>
	<tr><th colspan="4">&nbsp;</th></tr>
	<tr><td>Kode Badan Hukum.</td><td colspan="3">: <?php echo $edtKode; ?></td>
	</tr>
	<tr><td>Nama Badan Hukum/Yayasan</td><td colspan="3">: <?php echo $edtNama; ?></td>
	</tr>
	<tr>
	<td>Alamat</td><td colspan="3">: <?php echo $edtAlamat1; ?></td>
	</tr>
	<tr><td>&nbsp;</td><td colspan="3">&nbsp;&nbsp;<?php echo $edtAlamat2; ?></td>
	</tr>
	<tr><td width="27%">Kota</td><td width="34%">: <?php echo $edtKota; ?></td>
	<td width="11%">Kode Pos</td><td width="28%">: <?php echo $edtKodePos; ?></td>
	</tr>
	<tr><td>Telepon</td><td colspan="3">: <?php echo $edtTelp; ?></td>
	</tr>
	<tr><td>Fax.</td><td colspan="3">: <?php echo $edtFax; ?></td>
	</tr>
	<tr><td>Email</td><td colspan="3">: <?php echo $edtEmail; ?></td>
	</tr>
	<tr><td>Website</td><td colspan="3">: <?php echo $edtWeb; ?></td>
	</tr>
	<tr><td>Awal Berdiri</td><td colspan="3">: <?php echo DateStr($edtBerdiri); ?></td>
	</tr>
	<tr><td colspan="4" align="center">&nbsp;</td></tr>
	</table>
	<br>
<?php
	/************** Data Badan Hukum **********************/
echo "<table border='0' align='center' style='width:80%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
     echo "<tr><th colspan='6' style='background-color:#EEE'>RIWAYAT BADAN HUKUM YAYASAN</th></tr>";
     echo "<tr>
     <th colspan='2'>NO</th> 
     <th style='width:200px;'>NO AKTA/SK</th> 
     <th style='width:75px;'>TGL AKTA/SK</th> 
     <th style='width:200px;'>NO PN/BERITA NEGARA</th> 
     <th style='width:75px;'>TGL PN/BN</th> 
     </tr>";
     $MySQL->Select("*","tbhkmupy","where IDYYSMSYYS='".$edtIdYys."'","TGYYSMSYYS DESC","","0");
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
     	echo "<td class='$sel tac'  style='width:20px;'>".$default."</td>";
     	echo "<td class='$sel tac'  style='width:30px;'>".$no."</td>";
     	echo "<td class='$sel'>".$show['NOMSKMSYYS']."</td>";
     	echo "<td class='$sel'>".DateStr($show['TGYYSMSYYS'])."</td>";
     	echo "<td class='$sel'>".$show['NOMBNMSYYS']."</td>";
     	echo "<td class='$sel'>".DateStr($show['TGLBNMSYYS'])."</td>";
     	echo "</tr>";
     	$no++;
    	}
     } else {
     	echo "<tr><td colspan='6' class='$sel tac' style='color:red'>".$msg_data_empty."</td></tr>";
	 }
     echo "</table><br>";    
}
?>
