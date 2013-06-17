<?php
$idpage='34';
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
	<div id="whatnewstoggler" class="fadecontenttoggler" style="width:95%">
	<a href="#" class="toc">Sedang Berjalan</a>
	<a href="#" class="toc">PerPeriode</a>
	</div>
	<div id="whatsnew" class="fadecontentwrapper" style="width:95%">
		<!********** Form 1 ******************>
		<div class="fadecontent">
<?php
	$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.KELASTRNLM,trnlmupy.SKSMKTRNLM,trnlmupy.SEMESTRNLM,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.RUANGMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","trnlmupy","LEFT OUTER JOIN tbmksajiupy ON (trnlmupy.IDXMKSAJI = tbmksajiupy.IDX) LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE trnlmupy.NIMHSTRNLM = '".$user_admin."' AND trnlmupy.THSMSTRNLM = '".$ThnSemester."' AND trnlmupy.STATUTRNLM = '1'","trnlmupy.KDKMKTRNLM ASC","");		
		echo "<div class='tac fwb'>JADWAL PERKULIAHAN TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." Sem. ".LoadSemester_X("",substr($ThnSemester,4,1))."</div><br>";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th style='width:10px;'>NO</th>
		<th style='width:75px;'>KODE MK</th>
		<th>MATAKULIAH</th>
		<th style='width:30px;'>KLS</th> 
		<th style='width:30px;'>SKS</th> 
		<th style='width:30px;'>SEM</th> 
		<th style='width:140px;'>JADWAL</th> 
		<th style='width:50px;'>RUANG</th> 
		<th style='width:250px;'>PENGAJAR</th> 
		</tr>";	
		if ($MySQL->num_rows() > 0) {
			$no=1;
	     	while ($show=$MySQL->fetch_array()) {
				$sel1="sel";
				$durasi=($show['DURSIMKSAJI']*60);
				$mulai= New Time($show['MULAIMKSAJI']);
				$selesai=$mulai->add($durasi);
				if ($no % 2 == 1) $sel1="";
				echo "<tr><td class='$sel1 tar'>".$no."&nbsp;</td>";
				echo "<td class='$sel1'>".$show["KDKMKTRNLM"]."</td>";
				echo "<td class='$sel1'>".$show["NAMKTBLMK"]."</td>";
				echo "<td class='$sel1 tac'>".$show["KELASTRNLM"]."</td>";
				echo "<td class='$sel1 tac'>".$show["SKSMKTRNLM"]."</td>";
				echo "<td class='$sel1 tac'>".$show["SEMESTRNLM"]."</td>";
				echo "<td class='$sel1'>".$show["HRPELMKSAJI"].", ".substr($show["MULAIMKSAJI"],0,5)." - ".substr($selesai,0,5)."</td>";
				echo "<td class='$sel1'>".$show['RUANGMKSAJI']."</td>";
				echo "<td class='$sel1'>".$show["NMDOSMKSAJI"]." - ".$show["NODOSMKSAJI"]."</td></tr>";
				$no++;
			}
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='8'>".$msg_data_empty."</td></tr>";
		}
		echo "</table>";
?>
		</div>
		<div class="fadecontent">			
<?php
		echo "<div class='tac fwb'>JADWAL PERKULIAHAN</div><br>";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th style='width:10px;'>NO</th>
			<th style='width:75px;'>KODE MK</th>
			<th>MATAKULIAH</th>
			<th style='width:30px;'>KLS</th> 
			<th style='width:30px;'>SKS</th> 
			<th style='width:30px;'>SEM</th> 
			<th style='width:140px;'>JADWAL</th> 
			<th style='width:50px;'>RUANG</th> 
			<th style='width:250px;'>PENGAJAR</th> 
			</tr>";	

		$thn_berjalan = $thn_masuk;
		for ($i=1; $i <= $tahun_akademik;$i++) {
			if ($i > 1) {
				$thn_berjalan += 1;
				if (substr($thn_berjalan,4,1) > 2) {
					$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
				}
			}
			/***** Jadwal Matakuliah *************/
			echo "<tr><td style='width:75px;' colspan='9'><b>SEMESETER ".$i."</b></td></tr>";
			$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.KELASTRNLM,trnlmupy.SKSMKTRNLM,trnlmupy.SEMESTRNLM,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.RUANGMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","trnlmupy","LEFT OUTER JOIN tbmksajiupy ON (trnlmupy.IDXMKSAJI = tbmksajiupy.IDX) LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE trnlmupy.NIMHSTRNLM = '".$user_admin."' AND trnlmupy.THSMSTRNLM = '".$thn_berjalan."' AND trnlmupy.STATUTRNLM = '1'","trnlmupy.KDKMKTRNLM ASC","");		
			if ($MySQL->num_rows() > 0) {
				$no=0;
		     	while ($show=$MySQL->fetch_array()) {
					$sel1="sel";
					$durasi=($show['DURSIMKSAJI']*60);
					$mulai= New Time($show['MULAIMKSAJI']);
					$selesai=$mulai->add($durasi);
					if ($no % 2 == 1) $sel1="";
					echo "<tr><td class='$sel1 tar'>".($no + 1)."&nbsp;</td>";
					echo "<td class='$sel1'>".$show["KDKMKTRNLM"]."</td>";
					echo "<td class='$sel1'>".$show["NAMKTBLMK"]."</td>";
					echo "<td class='$sel1 tac'>".$show["KELASTRNLM"]."</td>";
					echo "<td class='$sel1 tac'>".$show["SKSMKTRNLM"]."</td>";
					echo "<td class='$sel1 tac'>".$show["SEMESTRNLM"]."</td>";
					echo "<td class='$sel1'>".$show["HRPELMKSAJI"].", ".substr($show["MULAIMKSAJI"],0,5)." - ".substr($selesai,0,5)."</td>";
					echo "<td class='$sel1'>".$show['RUANGMKSAJI']."</td>";
					echo "<td class='$sel1'>".$show["NMDOSMKSAJI"]." - ".$show["NODOSMKSAJI"]."</td></tr>";
					$no++;
				}
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='9'>".$msg_data_empty."</td></tr>";
			}
		}
		echo "</table>";
?>
		</div>
	</div>
	<script type="text/javascript">
	//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
	fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler",0, 100)
	</script>
	</center>
<?php
}
?>