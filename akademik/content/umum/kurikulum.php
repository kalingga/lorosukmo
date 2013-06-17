<?php
$idpage='15';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$MySQL->Select("tbkurupy.IDX,tbkurupy.KDKURTBKUR,tbkurupy.NMKURTBKUR,tbkurupy.KDPSTTBKUR,MAX(tbkurupy.THAWLTBKUR) AS LAST_KUR",
	"tbkurupy",
	" LEFT OUTER JOIN mspstupy ON tbkurupy.KDPSTTBKUR=mspstupy.IDPSTMSPST WHERE tbkurupy.KDPSTTBKUR NOT IN('47','48') AND STATUTBKUR='A' AND mspstupy.STATUMSPST='A' GROUP BY tbkurupy.KDPSTTBKUR","KDPSTTBKUR ASC","");
	$i=0;
	$jml=$MySQL->num_rows();
	while ($show=$MySQL->Fetch_array()) {
	$id_kur[$i] = $show["IDX"];
	$kd_kur[$i] = $show["KDKURTBKUR"];
	$nm_kur[$i] = $show["NMKURTBKUR"];
	$ps_kur[$i] = $show["KDPSTTBKUR"];
	$lk_kur[$i] = $show["LAST_KUR"];
		$i++;
	}
	echo "<center>";
	for ($i=0;$i < $jml;$i++) {
?>
	    <div id="whatnewstoggler" class="fadecontenttoggler" style="width:99%">
		<a href="#" class="toc"><?php  echo LoadProdi_X("",$ps_kur[$i]); ?></a></div>
		<div id="whatsnew" class="fadecontentwrapper" style="width:99%; height: 2px;"></div>
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr><td colspan="2">&nbsp;</td></tr>	
			<tr>
			    <td style="width:10%">Kode</td>
			    <td>: <?php echo $kd_kur[$i]; ?></td>
		    </tr>
			<tr>
			    <td style="width:10%">Kurikulum</td>
			    <td>: <?php echo $nm_kur[$i]; ?></td>
		    </tr>
			<tr>
			    <td style="width:10%">Tahun</td>
			    <td>: <?php echo substr($lk_kur[$i],0,4); ?></td>
		    </tr>
		</table><br>
<?php
		/******* Tampilkan daftar matakuliah ****************/
		echo "<table border='0' align='center' style='width:95%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr>
			<th style='width:20px;'>NO</th>
			<th style='width:75px;'>KODE</th>
			<th style='width:250px;'>MATAKULIAH</th>
			<th style='width:50px; tac'>SKS</th>
			<th style='width:30px; tac'>SEM</th>
			<th tac'>DOSEN</th>
			</tr>";
/*		$MySQL->Select("DISTINCT tbkmkupy.SEMESTBKMK","tbkmkupy","WHERE tbkmkupy.IDKURTBKMK ='".$id_kur[$i]."'","tbkmkupy.SEMESTBKMK");
		$row=$MySQL->Num_Rows();
		if ($row > 0){
			$j=0;
			while ($show=$MySQL->fetch_array()) {
				$master[$j]=$show['SEMESTBKMK'];
				$i++;
			}
	
			for ($j=0; $j < $row; $j++) {
				echo "<td colspan='8' class='fwb'>Semester ".$master[$i]."</td>";*/
		$MySQL->Select("tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NMDOSTBKMK","tbkmkupy","LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.IDKURTBKMK = '".$id_kur[$i]."'","tbkmkupy.SEMESTBKMK,tbkmkupy.KDKMKTBKMK","");
		$no=1;
		$sksTotal=0;
		if ($MySQL->num_rows() > 0) {
			while ($show=$MySQL->Fetch_Array()){
				$sel="";
				if ($no % 2 == 1) $sel="sel";     	
				echo "<tr>";
		     	echo "<td class='$sel tac'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['KDKMKTBKMK']."</td>";
		     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
		     	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
		     	echo "<td class='$sel tac'>".$show['SEMESTBKMK']."</td>";
		     	echo "<td class='$sel'>".$show['NMDOSTBKMK']."</td>";
		     	echo "</tr>";
		     	$sksTotal += $show['SKSMKTBKMK'];
		     	$no++;
			}
			echo "<tr><td class='tar fwb' colspan='3'>SKS Total &nbsp;&nbsp;</td>";
			echo "<td class='tac fwb'>".$sksTotal." SKS</td><td colspan='4'>&nbsp;</td></tr>";			   } else {
			echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";	
		}
		echo "</table><br>";
	}
	echo "</center>";
}
?>

