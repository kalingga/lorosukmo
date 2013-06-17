<?php
$idpage='35';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
?>
	<br>
	<center>
<?php
	$MySQL->Select("DISTINCT jwlutsuas.KDPSTUTSUAS","jwlutsuas","WHERE jwlutsuas.THSMSUTSUAS = '".$ThnSemester."' AND jwlutsuas.NODOSUTSUAS = '".$user_admin."'","jwlutsuas.KDPSTUTSUAS ASC","");
	$jml_data=$MySQL->num_rows();
	$i=0;
	while ($show=$MySQL->fetch_array()) {
		$prodi[$i]=$show["KDPSTUTSUAS"];
		$i++;
	}
		
	echo "<div class='tac fwb' >JADWAL UTS/UAS TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." Sem. ".LoadSemester_X("",substr($ThnSemester,4,1))."</div><br>";
	echo "<table border='0' align='center' style='width:90%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<tr><th style='width:75px;'>KODE MK</th>
		<th style='width:300px;'>MATAKULIAH</th>
		<th style='width:100px;'>KELAS</th> 
		<th style='width:30px;'>JENIS UJIAN</th> 
		<th>WAKTU PELAKSANAAN</th> 
		<th style='width:100px;'>RUANG</th> 
		</tr>";	

	if ($jml_data > 0) {
		for ($i=0;$i < $jml_data;$i++) {
			echo "<tr><td colspan='6' class='fwb'>PROGRAM STUDI : ".LoadProdi_X("",$prodi[$i])."</td></tr>";
			$MySQL->Select("jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.KELASUTSUAS,jwlutsuas.JENISUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.RUANGUTSUAS","jwlutsuas","LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) WHERE jwlutsuas.THSMSUTSUAS = '".$ThnSemester."' AND jwlutsuas.NODOSUTSUAS = '".$user_admin."' AND jwlutsuas.KDPSTUTSUAS = '".$prodi[$i]."'","jwlutsuas.KDKMKUTSUAS ASC","");
			$no=0;
			while ($show=$MySQL->fetch_array()) {
				$sel1="sel";
				if ($no % 2 == 1) $sel1="";
				$durasi=($show['DURSIUTSUAS']*60);
				$mulai= New Time($show['WKPELUTSUAS']);
				$selesai=$mulai->add($durasi);
				echo "<tr><td class='$sel1'>".$show["KDKMKUTSUAS"]."</td>";
				echo "<td class='$sel1'>".$show["NAMKTBLMK"]."</td>";
				echo "<td class='$sel1 tac'>".$show["KELASUTSUAS"]."</td>";
				echo "<td class='$sel1 tac'>".$show["JENISUTSUAS"]."</td>";
				echo "<td class='$sel1'>".$show["HRPELUTSUAS"].", ".
				DateStr($show["TGPELUTSUAS"])." ".
				substr($show['WKPELUTSUAS'],0,5)." - ".substr($selesai,0,5)."</td>";
				echo "<td class='$sel1 tac'>".$show["RUANGUTSUAS"]."</td></tr>";
				$no++;
			}
		}
	} else {
		echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
	}
	echo "</table>";
?>
	</center>		
<?php
}
?>