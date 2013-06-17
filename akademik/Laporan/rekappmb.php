<?php
$MySQL->Select("IDPSTMSPST,NMPSTMSPST","mspstupy","WHERE STATUMSPST='A' AND IDPSTMSPST IN $prive_user","IDPSTMSPST ASC","");
$i=0;
$jml_prodi=$MySQL->Num_Rows();
while ($show=$MySQL->Fetch_Array()) {
	$id_pst[$i] = $show["IDPSTMSPST"];
	$nm_pst[$i] = $show["NMPSTMSPST"];
	$i++;
}

echo "<form action='./?page=rekappmb' method='post' >";
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
<a href="#" class="toc">STATISTIK CALON MAHASISWA BARU</a>
<a href="#" class="toc">STATISTIK MAHASISWA BARU</a>
</div>

<div id="whatsnew" class="fadecontentwrapper" style="width:97%; height: 1250px;">
	<div class="fadecontent">
<?php
		echo "<table border='0' style='width:95%'>
			<tr><td style='width:50%'>";
			/***** DITERIMA *********/
			$thn_berjalan = $last_pmb;
			echo "<table border='0' style='width:100%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr><th rowspan='2' style='width:3%'>NO</th>
				 <th rowspan='2'>PROGRAM STUDI (DITERIMA)</th>
				 <th colspan='5'>TAHUN AKADEMIK</th></tr><tr>";
				for ($i=4; $i >= 0;$i--) {
					if ($i < 4) {
						$thn_berjalan -= 1;
						if (substr($thn_berjalan,4,1) < 1) {
							$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
						}
					}
					echo "<th style='width:10%'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)." ".LoadSemester_X("",substr($thn_berjalan,4,1))."</th>";
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
					$MySQL->Select("COUNT(tbpmbupy.DTRMATBPMB) AS DITERIMA","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$thn_berjalan."' AND tbpmbupy.DTRMATBPMB = '".$id_pst[$i]."'");
					$show=$MySQL->Fetch_Array();
					echo "<td class='$sel tac'>".$show["DITERIMA"]."</td>";
				}
				echo "</tr>";
				$no++;
			}
			echo "</table>";
		echo "</td>";
		echo "<td align='center'>";
		/********* Chart Diterima *****************/
			for ($i=0;$i < $jml_prodi;$i++) {
				$MySQL->Select("COUNT(tbpmbupy.DTRMATBPMB) AS DITERIMA","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.DTRMATBPMB = '".$id_pst[$i]."'");
				$show=$MySQL->Fetch_Array();
				$diterima[$i] = $show["DITERIMA"];
			}	
		
		   	$gr = new HTMLGraph("300","350","STATISTIK CALON MAHASISWA per PROGRAM STUDI DITERIMA TA. ".substr($last_pmb,0,4)."/".(substr($last_pmb,0,4)+1)." Sem. ".LoadSemester_X("",substr($last_pmb,4,1)));
		    $plot = new HTMLGraph_BarPlot();
		    $plot->add($diterima,$id_pst,"green");
		    $gr->add($plot);
	   		$gr->footnote->caption = "PROGRAM STUDI";
		    $gr->render();	
		echo "</td>";	
		echo "<tr><td collspan='2'>&nbsp;</td></tr>";
		echo "<tr><td style='width:50%'>";
			/***** Pilihan Pertama *********/
			$thn_berjalan = $last_pmb;
			echo "<table border='0' style='width:100%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr><th rowspan='2' style='width:3%'>NO</th>
				 <th rowspan='2'>PROGRAM STUDI (PILIHAN I)</th>
				 <th colspan='5'>TAHUN AKADEMIK</th></tr><tr>";
				for ($i=4; $i >= 0;$i--) {
					if ($i < 4) {
						$thn_berjalan -= 1;
						if (substr($thn_berjalan,4,1) < 1) {
							$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
						}
					}
					echo "<th style='width:10%'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)." ".LoadSemester_X("",substr($thn_berjalan,4,1))."</th>";
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
					$MySQL->Select("COUNT(tbpmbupy.PLHN1TBPMB) AS PILIHAN1","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$thn_berjalan."' AND tbpmbupy.PLHN1TBPMB = '".$id_pst[$i]."'");
					$show=$MySQL->Fetch_Array();
					echo "<td class='$sel tac'>".$show["PILIHAN1"]."</td>";
				}
				echo "</tr>";
				$no++;
			}
			echo "</table>";
		echo "</td>";
		echo "<td align='center'>";
		/********* Chart Pilihan I *****************/
			for ($i=0;$i < $jml_prodi;$i++) {
				$MySQL->Select("COUNT(tbpmbupy.PLHN1TBPMB) AS PILIHAN1","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.PLHN1TBPMB = '".$id_pst[$i]."'");
				$show=$MySQL->Fetch_Array();
				$pil_1[$i] = $show["PILIHAN1"];
			}	
		
		   	$gr1 = new HTMLGraph("300","350","STATISTIK CALON MAHASISWA per PROGRAM STUDI PILIHAN I TA. ".substr($last_pmb,0,4)."/".(substr($last_pmb,0,4)+1)." Sem. ".LoadSemester_X("",substr($last_pmb,4,1)));
		    $plot = new HTMLGraph_BarPlot();
		    $plot->add($pil_1,$id_pst,"#63CF89");
		    $gr1->add($plot);
	   		$gr1->footnote->caption = "PROGRAM STUDI";
		    $gr1->render();	
		echo "</td>";	
		echo "<tr><td collspan='2'>&nbsp;</td></tr>";	
		echo "<tr><td>";	
			/**** Pilihan 2 **********/
			$thn_berjalan = $last_pmb;
			echo "<table border='0' style='width:100%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr><th rowspan='2' style='width:3%'>NO</th>
				 <th rowspan='2'>PROGRAM STUDI (PILIHAN II)</th>
				 <th colspan='5'>TAHUN AKADEMIK</th></tr><tr>";
				for ($i=4; $i >= 0;$i--) {
					if ($i < 4) {
						$thn_berjalan -= 1;
						if (substr($thn_berjalan,4,1) < 1) {
							$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
						}
					}
					echo "<th style='width:10%'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)." ".LoadSemester_X("",substr($thn_berjalan,4,1))."</th>";
				}
				echo "</tr>";
			
			$no=1;	
			for ($i=0;$i < $jml_prodi;$i++) {
				$sel="";
				if ($i % 2 == 1) $sel="sel";			
				echo "<tr><td class='$sel tar'>".$no."&nbsp</td>
					<td class='$sel'>".$nm_pst[$i]." [".$id_pst[$i]."]</td>";
				$thn_berjalan = $last_pmb;
				for ($j=4; $j >= 0;$j--) {
					if ($j < 4) {
						$thn_berjalan -= 1;
						if (substr($thn_berjalan,4,1) < 1) {
							$thn_berjalan = (substr($thn_berjalan,0,4) - 1)."2";
						}
					}
					$MySQL->Select("COUNT(tbpmbupy.PLHN2TBPMB) AS PILIHAN2","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$thn_berjalan."' AND tbpmbupy.PLHN2TBPMB = '".$id_pst[$i]."'");
					$show=$MySQL->Fetch_Array();
					echo "<td class='$sel tac'>".$show["PILIHAN2"]."</td>";
				}
				echo "</tr>";
				$no++;
			}
			echo "</table>";	
			echo "</td>";
			echo "<td align='center'>";
			/********* Chart Pilihan 2 *****************/
				for ($i=0;$i < $jml_prodi;$i++) {
					$MySQL->Select("COUNT(tbpmbupy.PLHN2TBPMB) AS PILIHAN2","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.PLHN2TBPMB = '".$id_pst[$i]."'");
					$show=$MySQL->Fetch_Array();
					$pil_2[$i] = $show["PILIHAN2"];
				}	
			
			   	$gr2 = new HTMLGraph("300", "350","STATISTIK CALON MAHASISWA per PROGRAM STUDI PILIHAN II TA. ".substr($last_pmb,0,4)."/".(substr($last_pmb,0,4)+1)." Sem. ".LoadSemester_X("",substr($last_pmb,4,1)));
			    $plot2 = new HTMLGraph_BarPlot();
			    $plot2->add($pil_2,$id_pst,"#AAAAFF");
			    $gr2->add($plot2);
				$gr2->footnote->caption = "PROGRAM STUDI";
			    $gr2->render();
			echo "</td>";	
		echo "</table>";
?>
	</div>
	<div class="fadecontent">
<?php
		echo "<table border='0' style='width:95%' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th rowspan='2' style='width:3%'>NO</th>
			 <th rowspan='2'>PROGRAM STUDI</th>
			 <th colspan='4'>JUMLAH MAHASISWA BARU</th></tr>";
		echo "<tr><th>MENDAFTAR SBG MHS</th>
			 <th>LULUS SELEKSI</th>
			 <th>MENGUNDURKAN DIRI</th>
			 <th>MHS PINDAHAN</th>
			 </tr>";
			
		$no=1;
		for ($i=0;$i < $jml_prodi;$i++) {
			$MySQL->Select("COUNT(tbpmbupy.PLHN1TBPMB) AS PILIHAN1","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.PLHN1TBPMB = '".$id_pst[$i]."'");
			$show=$MySQL->Fetch_Array();
			$pilihan[$i] =  $show["PILIHAN1"];

			$MySQL->Select("COUNT(tbpmbupy.DTRMATBPMB) AS DITERIMA","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.DTRMATBPMB = '".$id_pst[$i]."'");
			$show=$MySQL->Fetch_Array();
			$diterima[$i] =  $show["DITERIMA"];

			$MySQL->Select("COUNT(tbpmbupy.DTRMATBPMB) AS UNDURDIRI","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.DTRMATBPMB = '".$id_pst[$i]."' AND tbpmbupy.HRREGTBPMB ='0'");
			$show=$MySQL->Fetch_Array();
			$undurdiri[$i] =  $show["UNDURDIRI"];

			$MySQL->Select("COUNT(tbpmbupy.DTRMATBPMB) AS PINDAHAN","tbpmbupy","WHERE tbpmbupy.THDTRTBPMB = '".$last_pmb."' AND tbpmbupy.DTRMATBPMB = '".$id_pst[$i]."' AND tbpmbupy.HRREGTBPMB ='1' AND tbpmbupy.STPIDTBPMB = 'P'");
			$show=$MySQL->Fetch_Array();
			$pindahan[$i] =  $show["PINDAHAN"];

			$sel="";
			if ($i % 2 == 1) $sel="sel";			
			echo "<tr>
				<td class='$sel tar'>".$no."&nbsp</td>
				<td class='$sel'>".$nm_pst[$i]." [".$id_pst[$i]."]</td>
				<td class='$sel tac'>".$pilihan[$i]."</td>
				<td class='$sel tac'>".$diterima[$i]."</td>
				<td class='$sel tac'>".$undurdiri[$i]."</td>
				<td class='$sel tac'>".$pindahan[$i]."</td>
			</tr>";
			$no++;
		}
		echo "</table><br>";
		
		$gr3 = new HTMLGraph("95%", "250", "STATISTIK MAHASISWA BARU per PROGRAM STUDI TA. ".substr($last_pmb,0,4)."/".(substr($last_pmb,0,4)+1)." Sem. ".LoadSemester_X("",substr($last_pmb,4,1)));
		$plot = new HTMLGraph_BarPlot();
		$plot->bars->color = "yellow";
		$plot->add($pilihan,"D");
		$plot1 = new HTMLGraph_BarPlot();
		$plot1->bars->color = "#63CF89";
		$plot1->add($diterima,"L");
		$plot2 = new HTMLGraph_BarPlot();
		$plot2->bars->color = "red";
		$plot2->add($undurdiri,"U");
		$plot3 = new HTMLGraph_BarPlot();
		$plot3->bars->color = "#AAAAFF";
		$plot3->add($pindahan,"P");
		$group = new HTMLGraph_BarPlotGroup();
		$group->add($plot);
		$group->add($plot1);
		$group->add($plot2);
		$group->add($plot3);
		$gr3->add($group);
		$gr3->footnote->caption = "D = MENDAFTAR SBG MHS, L = CALON MHS YG DINYATAKN LULUS SELEKSI, U = CALON MHS YG MENGUNDURKAN DIRI, P = SBG MHS PINDAHAN";
		$gr3->render();			
?>
	</div>
</div>
</center>		
<script type="text/javascript">
//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler",0, 100)
</script>

