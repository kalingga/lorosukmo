<?php
$idpage='34';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
?>
	<br>
	<center>
<?php
	$MySQL->Select("DISTINCT tbmksajiupy.KDPSTMKSAJI","tbmksajiupy","WHERE tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."' AND tbmksajiupy.NODOSMKSAJI = '".$user_admin."'","tbmksajiupy.KDPSTMKSAJI ASC","");
	$jml_data=$MySQL->num_rows();
	$i=0;
	while ($show=$MySQL->fetch_array()) {
		$prodi[$i]=$show["KDPSTMKSAJI"];
		$i++;
	}
		
	echo "<div class='tac fwb' >JADWAL PERKULIAHAN. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." Sem. ".LoadSemester_X("",substr($ThnSemester,4,1))."</div><br>";
	echo "<table border='0' align='center' style='width:90%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th style='width:30px;'>NO</th>
		<th style='width:75px;'>KODE MK</th>
		<th>MATAKULIAH</th>
		<th style='width:30px;'>KLS</th> 
		<th style='width:30px;'>SKS</th> 
		<th style='width:30px;'>SEM</th> 
		<th style='width:200px;'>JADWAL</th> 
		<th style='width:50px;'>RUANG</th> 
		</tr>";	

	if ($jml_data > 0) {
		for ($i=0;$i < $jml_data;$i++) {
			echo "<tr><td colspan='8' class='fwb'>PROGRAM STUDI : ".LoadProdi_X("",$prodi[$i])."</td></tr>";

			$MySQL->Select("tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.KELASMKSAJI,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.RUANGMKSAJI","tbmksajiupy","LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) WHERE tbmksajiupy.THSMSMKSAJI='".$ThnSemester."' AND tbmksajiupy.KDPSTMKSAJI='".$prodi[$i]."'","jwlutsuas.KDKMKMKSAJI ASC","");
			$no=0;
			while ($show=$MySQL->fetch_array()) {
				$sel1="sel";
				if ($no % 2 == 1) $sel1="";
				$durasi=($show['DURSIMKSAJI']*60);
				$mulai= New Time($show['MULAIMKSAJI']);
				$selesai=$mulai->add($durasi);
				echo "<tr><td class='$sel1'>".$show["KDKMKMKSAJI"]."</td>";
				echo "<td class='$sel1'>".$show["NAMKTBLMK"]."</td>";
				echo "<td class='$sel1 tac'>".$show["KELASMKSAJI"]."</td>";
				echo "<td class='$sel1 tac'>".$show["SKSMKMKSAJI"]."</td>";
				echo "<td class='$sel1 tac'>".$show["SEMESMKSAJI"]."</td>";
				echo "<td class='$sel1'>".$show["HRPELMKSAJI"].", ".substr($show['MULAIMKSAJI'],0,5)." - ".substr($selesai,0,5)."</td>";
				echo "<td class='$sel1 tac'>".$show["RUANGMKSAJI"]."</td></tr>";
				$no++;
			}
		}
	} else {
		echo "<tr><td align='center' style='color:red;' colspan='8'>".$msg_data_empty."</td></tr>";
	}
	echo "</table>";
?>
	</center>		
<?php
}
?>