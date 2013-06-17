<?php
$idpage='35';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	/***** Cari Awal Masuk Mahasiswa ***********/
	$MySQL->Select("SMAWLMSMHS","msmhsupy","where NIMHSMSMHS='".$user_admin."'","","1");
	$show=$MySQL->fetch_array();
	$thn_masuk=$show["SMAWLMSMHS"];
	$tahun_akademik= ((substr($ThnSemester,0,4) - substr($thn_masuk,0,4)) * 2) + 
				((substr($ThnSemester,4,1)- substr($thn_masuk,4,1)) + 1) ;
	
?>
	<br>
	<center>
	<div id="whatnewstoggler" class="fadecontenttoggler" style="width:90%;">
	<a href="#" class="toc">Sedang Berjalan</a>
	<a href="#" class="toc">Per Semester</a>
	</div>

	<div id="whatsnew" class="fadecontentwrapper" style="width:90%;">
	<!********** Form 1 ******************>
	<div class="fadecontent">
<?php
		$MySQL->Select("trnlmupy.IDXMKSAJI","trnlmupy","WHERE trnlmupy.THSMSTRNLM = '".$ThnSemester."' AND trnlmupy.NIMHSTRNLM = '".$user_admin."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM <> '1'","","");
		$i=0;
		$jml_mk=$MySQL->num_rows();
		while($show=$MySQL->fetch_array()) {
			$id_mk[$i]=$show["IDXMKSAJI"];
			$i++;
		}


		echo "<div class='tac fwb' >JADWAL UTS/UAS TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." Sem. ".LoadSemester_X("",substr($ThnSemester,4,1))."</div><br>";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th style='width:75px;'>KODE MK</th>
			<th style='width:300px;'>MATAKULIAH</th>
			<th style='width:100px;'>KELAS</th> 
			<th style='width:30px;'>JENIS UJIAN</th> 
			<th>WAKTU PELAKSANAAM</th> 
			<th style='width:100px;'>RUANG</th> 
			</tr>";	

		if ($jml_mk > 0) {
			$no=1;
			for ($i=0;$i < $jml_mk; $i++) {
				$sel1="sel";
				if ($no % 2 == 1) $sel1="";
				$MySQL->Select("jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.KELASUTSUAS,jwlutsuas.JENISUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.RUANGUTSUAS","jwlutsuas","LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) WHERE jwlutsuas.IDXMKSAJI = '".$id_mk[$i]."'","","");
				$show=$MySQL->fetch_array();
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
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
		}
		echo "</table>";
?>
			</div>
			<div class="fadecontent">
<?php
		echo "<div class='tac fwb' >JADWAL UTS/UAS</div><br>";
		$thn_berjalan = $thn_masuk;
		for ($i=1; $i <= $tahun_akademik;$i++) {
			if ($i > 1) {
				$thn_berjalan += 1;
				if (substr($thn_berjalan,4,1) > 2) {
					$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
				}
			}
			$MySQL->Select("trnlmupy.IDXMKSAJI","trnlmupy","WHERE trnlmupy.THSMSTRNLM = '".$thn_berjalan."' AND trnlmupy.NIMHSTRNLM = '".$user_admin."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM <> '1'","","");
			$j=0;
			$jml_detail[$i]=$MySQL->num_rows();
			while($show=$MySQL->fetch_array()) {
				$id_mk_detail[$i][$j]=$show["IDXMKSAJI"];
				$j++;
			}
		}
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th style='width:75px;'>KODE MK</th>
			<th style='width:300px;'>MATAKULIAH</th>
			<th style='width:100px;'>KELAS</th> 
			<th style='width:30px;'>JENIS UJIAN</th> 
			<th>WAKTU PELAKSANAAM</th> 
			<th style='width:100px;'>RUANG</th> 
			</tr>";
			for ($i=1;$i <= $tahun_akademik; $i++) {
				echo "<tr><td style='width:75px;' colspan='7'><b>SEMESETER ".$i."</b></td></tr>";
				if ($jml_detail[$i] > 0) {
					$no=1;
					for ($j=0;$j < $jml_detail[$i];$j++) {
						$sel1="sel";
						if ($no % 2 == 1) $sel1="";
						$MySQL->Select("jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.KELASUTSUAS,jwlutsuas.JENISUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.RUANGUTSUAS","jwlutsuas","LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) WHERE jwlutsuas.IDXMKSAJI = '".$id_mk_detail[$i][$j]."'","","");
						$show=$MySQL->fetch_array();
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
				} else {
					echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
				}
			}
			echo "</table>";
?>
			</div>
		</div>
		</center>		
		<script type="text/javascript">
		//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
		fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler",0, 100)
		</script>
<?php
}
?>