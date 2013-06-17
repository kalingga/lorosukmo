<?php
$MySQL->Select("IDPSTMSPST,NMPSTMSPST","mspstupy","WHERE STATUMSPST='A' AND IDPSTMSPST IN $prive_user","IDPSTMSPST ASC","");
$i=0;
$jml_prodi=$MySQL->Num_Rows();
while ($show=$MySQL->Fetch_Array()) {
	$id_pst[$i] = $show["IDPSTMSPST"];
	$nm_pst[$i] = $show["NMPSTMSPST"];
	$i++;
}

echo "<form action='./?page=rekapnilai' method='post' >";
echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
echo "Mahasiswa Baru TA Sebelumnya : ";
echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
LoadSemester_X("cbSemester","$cbSemester");			
echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
echo "</tr></table></form>";
?>
<br>
<center>
<div id="whatnewstoggler" class="fadecontenttoggler" style="width:97%;">
<a class="toc">STATISTIK PEROLEHAN NILAI AKHIR MAHASISWA</a>
</div>

<div id="whatsnew" class="fadecontentwrapper" style="width:97%; height: 10px;"></div>
<?php
	echo "<table border='0' style='width:95%'>
		<tr><td style='width:50%'>";
		/***** NILAI RATA-RATA  *********/
		$thn_berjalan = $last_pmb;
		echo "<table border='0' style='width:100%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th colspan='12'>RATA RATA IP SEM/IP KUM MAHASISWA per PROGRAM STUDI</th></tr>";
		echo "<tr><th rowspan='3' style='width:3%'>NO</th>
			 <th rowspan='3'>PROGRAM STUDI</th>
			 <th colspan='10'>TAHUN AKADEMIK</th></tr>
			 <tr>";
			for ($i=4; $i >= 0;$i--) {
				if ($i < 4) {
					$thn_berjalan -= 1;
					if (substr($thn_berjalan,4,1) < 1) {
						$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
					}
				}
				echo "<th colspan='2' style='width:10%'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)." ".LoadSemester_X("",substr($thn_berjalan,4,1))."</th>";
			}
			echo "</tr><tr>";
			for ($i=4; $i >= 0;$i--) {
				echo "<th>IP SEM</th><th>IP KUM</th>";
			}
			echo "</tr>";
			
		$no=1;
		for ($i=0;$i < $jml_prodi;$i++) {
			$sel="";
			if ($i % 2 == 1) $sel="sel";			
			echo "<tr>
				<td class='$sel tar'>".$no."&nbsp</td>
				<td class='$sel'>".$nm_pst[$i]." [".$id_pst[$i]."]</td>";
			$thn_berjalan = $last_pmb;
			for ($j=4; $j >= 0;$j--) {
				if ($j < 4) {
					$thn_berjalan -= 1;
					if (substr($thn_berjalan,4,1) < 1) {
						$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
					}
				}
				$MySQL->Select("AVG(trakmupy.NLIPSTRAKM) AS RATAIPS,AVG(trakmupy.NLIPKTRAKM) AS RATAIPK","msmhsupy","LEFT OUTER JOIN trakmupy ON (msmhsupy.NIMHSMSMHS = trakmupy.NIMHSTRAKM) WHERE trakmupy.THSMSTRAKM = '".$thn_berjalan."' AND msmhsupy.KDPSTMSMHS = '".$id_pst[$i]."'");
				$show=$MySQL->Fetch_Array();
				echo "<td class='$sel tac'>".$show["RATAIPS"]."</td>";
				echo "<td class='$sel tac'>".$show["RATAIPK"]."</td>";
			}
			echo "</tr>";
			$no++;
		}
		echo "</table>";
	echo "</td>";
	echo "<td align='center'>";
	/********* Chart RATA-RATA *****************/


	for ($i=0;$i < $jml_prodi;$i++) {
		$MySQL->Select("AVG(trakmupy.NLIPSTRAKM) AS RATAIPS,AVG(trakmupy.NLIPKTRAKM) AS RATAIPK","msmhsupy","LEFT OUTER JOIN trakmupy ON (msmhsupy.NIMHSMSMHS = trakmupy.NIMHSTRAKM) WHERE trakmupy.THSMSTRAKM = '".$last_pmb."' AND msmhsupy.KDPSTMSMHS = '".$id_pst[$i]."'");
		$show=$MySQL->Fetch_Array();
		$rata_ips[$i]= $show["RATAIPS"];
		$rata_ipk[$i]= $show["RATAIPK"];
	}
	$gr = new HTMLGraph("95%", "250", "RATA RATA IP SEM/IP KUM MAHASISWA per PROGRAM STUDI");
	$plot = new HTMLGraph_BarPlot();
	$plot->bars->color = "yellow";
	$plot->add($rata_ips,$id_pst);
	$plot1 = new HTMLGraph_BarPlot();
	$plot1->bars->color = "#63CF89";
	$plot1->add($rata_ipk,"");
	$group = new HTMLGraph_BarPlotGroup();
	$group->add($plot);
	$group->add($plot1);
	$gr->add($group);
	$gr->footnote->caption = "PROGRAM STUDI";
	$gr->render();

	echo "</td>";	
	echo "<tr><td collspan='2'>&nbsp;</td></tr>";
	echo "<tr><td style='width:50%'>";
		/***** MAX IP SEM/IP KUM *********/
		$thn_berjalan = $last_pmb;
		echo "<table border='0' style='width:100%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th colspan='12'>IP SEM/IP KUM TERTINGGI per PROGRAM STUDI</th></tr>";
		echo "<tr><th rowspan='3' style='width:3%'>NO</th>
			 <th rowspan='3'>PROGRAM STUDI</th>
			 <th colspan='10'>TAHUN AKADEMIK</th></tr>
			 <tr>";
			for ($i=4; $i >= 0;$i--) {
				if ($i < 4) {
					$thn_berjalan -= 1;
					if (substr($thn_berjalan,4,1) < 1) {
						$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
					}
				}
				echo "<th colspan='2' style='width:10%'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)." ".LoadSemester_X("",substr($thn_berjalan,4,1))."</th>";
			}
			echo "</tr><tr>";
			for ($i=4; $i >= 0;$i--) {
				echo "<th>IP SEM</th><th>IP KUM</th>";
			}
			echo "</tr>";
			
		$no=1;
		for ($i=0;$i < $jml_prodi;$i++) {
			$sel="";
			if ($i % 2 == 1) $sel="sel";			
			echo "<tr>
				<td class='$sel tar'>".$no."&nbsp</td>
				<td class='$sel'>".$nm_pst[$i]." [".$id_pst[$i]."]</td>";
			$thn_berjalan = $last_pmb;
			for ($j=4; $j >= 0;$j--) {
				if ($j < 4) {
					$thn_berjalan -= 1;
					if (substr($thn_berjalan,4,1) < 1) {
						$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
					}
				}
				$MySQL->Select("MAX(trakmupy.NLIPSTRAKM) AS MAXIPS,MAX(trakmupy.NLIPKTRAKM) AS MAXIPK","msmhsupy","LEFT OUTER JOIN trakmupy ON (msmhsupy.NIMHSMSMHS = trakmupy.NIMHSTRAKM) WHERE trakmupy.THSMSTRAKM = '".$thn_berjalan."' AND msmhsupy.KDPSTMSMHS = '".$id_pst[$i]."'");
				$show=$MySQL->Fetch_Array();
				echo "<td class='$sel tac'>".$show["MAXIPS"]."</td>";
				echo "<td class='$sel tac'>".$show["MAXIPK"]."</td>";
			}
			echo "</tr>";
			$no++;
		}
		echo "</table>";
	echo "</td>";
	echo "<td align='center'>";
	/********* NILAI MAX *****************/
	for ($i=0;$i < $jml_prodi;$i++) {
		$MySQL->Select("MAX(trakmupy.NLIPSTRAKM) AS MAXIPS,MAX(trakmupy.NLIPKTRAKM) AS MAXIPK","msmhsupy","LEFT OUTER JOIN trakmupy ON (msmhsupy.NIMHSMSMHS = trakmupy.NIMHSTRAKM) WHERE trakmupy.THSMSTRAKM = '".$last_pmb."' AND msmhsupy.KDPSTMSMHS = '".$id_pst[$i]."'");
		$show=$MySQL->Fetch_Array();
		$max_ips[$i]= $show["MAXIPS"];
		$max_ipk[$i]= $show["MAXIPK"];
	}
	$gr1 = new HTMLGraph("95%", "250", "IP SEM/IP KUM TERTINGGI per PROGRAM STUDI");
	$plot = new HTMLGraph_BarPlot();
	$plot->bars->color = "yellow";
	$plot->add($max_ips,$id_pst);
	$plot1 = new HTMLGraph_BarPlot();
	$plot1->bars->color = "#63CF89";
	$plot1->add($max_ipk,"");
	$group = new HTMLGraph_BarPlotGroup();
	$group->add($plot);
	$group->add($plot1);
	$gr1->add($group);
  	$gr1->footnote->caption = "PROGRAM STUDI";
	$gr1->render();
	echo "</td>";	
	echo "<tr><td collspan='2'>&nbsp;</td></tr>";	
	echo "<tr><td>";	
		/***** MIN IP SEM/IP KUM *********/
		$thn_berjalan = $last_pmb;
		echo "<table border='0' style='width:100%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th colspan='12'>IP SEM/IP KUM TERENDAH per PROGRAM STUDI</th></tr>";
		echo "<tr><th rowspan='3' style='width:3%'>NO</th>
			 <th rowspan='3'>PROGRAM STUDI</th>
			 <th colspan='10'>TAHUN AKADEMIK</th></tr>
			 <tr>";
			for ($i=4; $i >= 0;$i--) {
				if ($i < 4) {
					$thn_berjalan -= 1;
					if (substr($thn_berjalan,4,1) < 1) {
						$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
					}
				}
				echo "<th colspan='2' style='width:10%'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)." ".LoadSemester_X("",substr($thn_berjalan,4,1))."</th>";
			}
			echo "</tr><tr>";
			for ($i=4; $i >= 0;$i--) {
				echo "<th>IP SEM</th><th>IP KUM</th>";
			}
			echo "</tr>";
			
		$no=1;
		for ($i=0;$i < $jml_prodi;$i++) {
			$sel="";
			if ($i % 2 == 1) $sel="sel";			
			echo "<tr>
				<td class='$sel tar'>".$no."&nbsp</td>
				<td class='$sel'>".$nm_pst[$i]." [".$id_pst[$i]."]</td>";
			$thn_berjalan = $last_pmb;
			for ($j=4; $j >= 0;$j--) {
				if ($j < 4) {
					$thn_berjalan -= 1;
					if (substr($thn_berjalan,4,1) < 1) {
						$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
					}
				}
				$MySQL->Select("MIN(trakmupy.NLIPSTRAKM) AS MINIPS,MIN(trakmupy.NLIPKTRAKM) AS MINIPK","msmhsupy","LEFT OUTER JOIN trakmupy ON (msmhsupy.NIMHSMSMHS = trakmupy.NIMHSTRAKM) WHERE trakmupy.THSMSTRAKM = '".$thn_berjalan."' AND msmhsupy.KDPSTMSMHS = '".$id_pst[$i]."'");
				$show=$MySQL->Fetch_Array();
				echo "<td class='$sel tac'>".$show["MINIPS"]."</td>";
				echo "<td class='$sel tac'>".$show["MINIPK"]."</td>";
			}
			echo "</tr>";
			$no++;
		}
		echo "</table>";
	echo "</td>";
	echo "<td align='center'>";
	/********* NILAI MIN *****************/
		for ($i=0;$i < $jml_prodi;$i++) {
			$MySQL->Select("MIN(trakmupy.NLIPSTRAKM) AS MINIPS,MAX(trakmupy.NLIPKTRAKM) AS MINIPK","msmhsupy","LEFT OUTER JOIN trakmupy ON (msmhsupy.NIMHSMSMHS = trakmupy.NIMHSTRAKM) WHERE trakmupy.THSMSTRAKM = '".$last_pmb."' AND msmhsupy.KDPSTMSMHS = '".$id_pst[$i]."'");
			$show=$MySQL->Fetch_Array();
			$min_ips[$i]= $show["MINIPS"];
			$min_ipk[$i]= $show["MINIPK"];
		}
		$gr2 = new HTMLGraph("95%", "250", "IP SEM/IP KUM TERENDAH per PROGRAM STUDI");
		$plot = new HTMLGraph_BarPlot();
		$plot->bars->color = "yellow";
		$plot->add($min_ips,$id_pst);
		$plot1 = new HTMLGraph_BarPlot();
		$plot1->bars->color = "#63CF89";
		$plot1->add($min_ipk,"");
		$group = new HTMLGraph_BarPlotGroup();
		$group->add($plot);
		$group->add($plot1);
		$gr2->add($group);
	   	$gr2->footnote->caption = "PROGRAM STUDI";
		$gr2->render();
		echo "</td>";	
	echo "</table>";
?>