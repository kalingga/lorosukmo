<?php
$idpage='34';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	echo "<form action='./?page=jadwalmk' method='post' >";
	echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
	echo "Jadwal Matakuliah TA Sebelumnya : ";
	echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
	LoadSemester_X("cbSemester",$cbSemester);
	if ($level_user != '2') {
		echo "&nbsp;@&nbsp;";
		if ($level_user == '1') {
			LoadProdi_X("cbProdi","",$akses_user);
		} else {
			LoadProdi_X("cbProdi","");
		}
	}
	echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>
		&nbsp;<button type=\"button\" onClick=window.location.href='./?page=jadwalmk'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;</th>";
	echo "</tr></table></form>";		
	
	/*** Tampilan Default Jadwal matakuliah semester berjalan, 
	**** per fakultas yang merupakan hak user, pada semester berjalan/semester 
	**** paling akhir yang ada pada data base ******/
	
	echo "<table border='0' align='center' style='width:99%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
	echo "<tr><th colspan='6' style='background-color:#EEE'>JADWAL PERKULIAHAN TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." SEM. ".LoadSemester_X("",substr($ThnSemester,4,1))."</th></tr>";
	for ($i=0;$i < $jml_master;$i++) {
		echo "<tr><th align='left' colspan='6'>PROGRAM STUDI : ".$nm_pst[$i]."</th></tr>";
		$qry ="LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) ";
		$qry .="WHERE tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."' AND tbmksajiupy.KDPSTMKSAJI ='".$id_pst[$i]."'";	     
		$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI","tbmksajiupy",$qry,"tbmksajiupy.KDPSTMKSAJI ASC,tbmksajiupy.KDKMKMKSAJI ASC","","0");
		$row[$i]=$MySQL->Num_Rows();
		if ($row[$i] > 0) {
			$j=0;
			while ($show=$MySQL->Fetch_Array()){
				$data[$j][1]=$show['KDKMKMKSAJI'];
				$data[$j][2]=$show['NAMKTBLMK'];
				$data[$j][3]=$show['SKSMKMKSAJI'];
				$data[$j][4]=$show['SEMESMKSAJI'];
				$j++;
			}
			echo "<tr>
			<th style='width:20px;'>NO</th> 
			<th style='width:50px;'>KODE MK</th> 
			<th style='width:250px;'>MATAKULIAH</th> 
			<th style='width:20px;'>SKS</th> 
			<th style='width:20px;'>SEM</th>
			<th>DETAIL MATAKULIAH</th>
			</tr>";
		
			$no=1;
			for ($j=0;$j < $row[$i]; $j++) {
		    	echo "<tr>";
				$sel="";
				if ($no % 2 == 1) $sel="sel"; 
		     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
		     	echo "<td class='$sel'>".$data[$j][1]."</td>";
		    	echo "<td class='$sel'>".$data[$j][2]."</td>";
		    	echo "<td class='$sel tac'>".$data[$j][3]."</td>";
		    	echo "<td class='$sel tac'>".$data[$j][4]."</td>";
		     	echo "<td class='$sel'>";
		     	$no++;
				
					/******** Tabel Detail ****************/
			     	$MySQL->Select("tbmksajiupy.IDX,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI,tbmksajiupy.RUANGMKSAJI,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI","tbmksajiupy","WHERE tbmksajiupy.KDKMKMKSAJI = '".$data[$j][1]."'","tbmksajiupy.KELASMKSAJI ASC","");
			     	echo "<table border='0' style='width:100%;' cellpadding='2' cellspacing='1' class='tblbrdr' >";
		     	 	$no1=0;
				    echo "<tr>";
			   		echo "<th style='width:20px;'>KLS</th> 
			   			<th style='width:200px;'>JADWAL</th> 
						<th style='width:200px;'>DOSEN PENGAMPU</th>";
				    echo "</tr>";	
					while ($detail=$MySQL->fetch_array()){
						$sel1="sel";
						$durasi=($detail['DURSIMKSAJI']*60);
						$mulai= New Time($detail['MULAIMKSAJI']);
						$selesai=$mulai->add($durasi);
						
						if ($no1 % 2 == 1) $sel1="";
				     	echo "<tr><td class='$sel1 tac'>".$detail['KELASMKSAJI']."</td>";
				    	echo "<td class='$sel1' style='width:20px;'>".$detail['HRPELMKSAJI']." ";
				    		echo "".substr($detail['MULAIMKSAJI'],0,5)." - ".substr($selesai,0,5).", ";
				     		echo "".$detail['RUANGMKSAJI']."</td>";
				    		echo "<td class='$sel1' style='width:250px;'>".$detail['NMDOSMKSAJI']." - ".$detail['NODOSMKSAJI']."</td>";			    	
			    	 		echo "</tr>";
							$no1++;	
					}
				echo "</table>";
				echo "</td></tr>";
			}
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='6'>&nbsp;</td></tr>";
	}
	echo "</table>";
}
?>