<?php
$idpage='18';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	echo "<form action='./?page=mksaji' method='post' >";
	echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<tr><th>Matakuliah Saji TA. Sebelumnya : ";
	echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
	LoadSemester_X("cbSemester","$cbSemester");			
	echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
	echo "</tr></table></form>";	
	echo "<table border='0' align='center' style='width:90%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
	echo "<tr><th colspan='7' style='background-color:#EEE'>MATAKULIAH SAJI TA. '".$ThnAjaran."/".($ThnAjaran + 1)."' SEM. '".LoadSemester_X('',$cbSemester)."'</th></tr>";
	for ($i=0;$i < $jml_master; $i++) {
		$qry ="LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) ";
		$qry .="LEFT OUTER JOIN tbkmkupy ON (tbmksajiupy.IDKMKMKSAJI = tbkmkupy.IDX) ";
		$qry .="WHERE tbmksajiupy.THSMSMKSAJI ='".$ThnSemester."' ";     
		$qry .="AND tbmksajiupy.KDPSTMKSAJI ='".$id_pst[$i]."'";	     
		echo "<tr><td colspan='7' class='fwb'>PROGRAM STUDI : ".$nm_pst[$i]."</td></tr>";
		$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NODOSTBKMK,tbkmkupy.NMDOSTBKMK","tbmksajiupy",$qry,"tbkmkupy.SEMESTBKMK,tbmksajiupy.KDKMKMKSAJI","");
		echo "<tr>
		<th style='width:40px;'>NO</th>
		<th style='width:75px;'>KODE MK</th> 
		<th>MATAKULIAH</th> 
		<th style='width:30px;'>SKS</th> 
		<th style='width:30px;'>SEM</th>
		<th style='width:250px;'>DOSEN PENGAMPU</th>
		</tr>";	

		$no=1;
		if ($MySQL->Num_Rows() > 0){
			while ($show=$MySQL->Fetch_Array()){
		    	echo "<tr>";
				$sel="";
				if ($no % 2 == 1) $sel="sel"; 
		     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
		     	echo "<td class='$sel'>".$show['KDKMKMKSAJI']."</td>";
		     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
		    	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
		    	echo "<td class='$sel tac'>".$show['SEMESTBKMK']."</td>";
		    	echo "<td class='$sel'>".$show['NODOSTBKMK']." - ".$show['NMDOSTBKMK']."</td>";
		     	echo "</tr>";
		        $no++;
		    }
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='6'  class='tal'>&nbsp;</td></tr>";
	}
	echo "</table><br>";
}
?>