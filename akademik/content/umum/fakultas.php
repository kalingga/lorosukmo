<?php
$idpage='10';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<tr><th colspan='8' style='background-color:#EEE'>DAFTAR FAKULTAS</th></tr>";
	echo "<tr>
		<th style='width:75px;'>KODE</th> 
		<th style='width:300px;'>FAKULTAS</th> 
		<th colspan='2'>ALAMAT</th> 
		<th style='width:100px;'>TELEPON</th> 
		<th style='width:10px;'>ACT</th> 
		</tr>";

	 $MySQL->Select("IDX,KDFAKMSFAK,NMFAKMSFAK,ALMT1MSFAK,ALMT2MSFAK,KOTAAMSFAK,KDPOSMSFAK,TELPOMSFAK","msfakupy","WHERE STATUMSFAK = '1'","KDFAKMSFAK ASC","");
     $no=1;
     if ($MySQL->num_rows()) {
	     while ($show=$MySQL->Fetch_Array()){
			$sel="";
			if ($no % 2 == 1) $sel="sel";     	
	     	$alamat=$show['ALMT1MSFAK']." ".$show['ALMT2MSFAK']." ".$show['KOTAAMSFAK']." ".$show['KDPOSMSFAK'];
			echo "<tr>";
	     	echo "<td class='$sel tac'>".$show['KDFAKMSFAK']."</td>";
	     	echo "<td class='$sel'>".$show['NMFAKMSFAK']."</td>";
	     	echo "<td class='$sel' colspan='2'>".$alamat."</td>";
	     	echo "<td class='$sel'>".$show['TELPOMSFAK']."</td>";
	     	echo "<td class='$sel tac'>";
			echo "<a href='./?page=".$page."&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
	     	echo "</td>";
	     	echo "</tr>";
	     	$no++;
		}
	} else {
		echo "<tr><td align='center' style='color:red;' colspan='8'>".$msg_data_empty."</td></tr>";
	}
	echo "<tr><td colspan='8'>&nbsp;</td></tr>";
	echo "</table>";
}
?>

