<?php
$idpage='30';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	//****** Default tahun semester berjalan
	echo "<form action='./?page=hasilstudi' method='post' >";
	echo "<table align='center' border='0' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
	echo "TA : ";
	echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";	
	LoadSemester_X("cbSemester",$cbSemester);
//	echo "&nbsp;NPM : <input type='text' size='15' maxlength='15' name='NPM' value=''/>\n";
	if ($level_user == '0') {
		echo "&nbsp;<b>@</b>&nbsp;";
		LoadProdi_X("cbProdi",$cbProdi);
		
	} else {
		if ($level_user != '2') {
			echo "&nbsp;<b>@</b>&nbsp;";
			LoadProdi_X("cbProdi","",$akses_user);
		}
	}
	
	echo " Angkatan :&nbsp;<select name='angkatan'>";
  for($i=2003;$i <= date('Y');$i++){
      if($i == $_SESSION['angkatan']){
          $selected = "selected";          
      }else{
          $selected = "";
      }
      
      echo "<option value = '$i' $selected >$i</option>";       
  }    	
  echo "</select>";
	echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>&nbsp;<button type=\"button\" onClick=window.location.href='./?page=hasilstudi'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>\n</th>";
//echo "LEVELLLLL : ".$akses_user;	
echo "</tr></table></form>";	
		 	
	echo "<table border='0' style='width:99%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
	echo "<tr><th colspan='10' style='background-color:#EEE'>Hasil Studi Mahasiswa TA. '".substr($ThnSemester,0,4)."/".(substr($ThnSemester,0,4) + 1)."' Sem. '".LoadSemester_X('',substr($ThnSemester,4,1))."'</th></tr>";
	echo "<tr>
		<th style='width:10px;'>NO</th>
		<th style='width:10px;'>Sem.</th> 
		<th style='width:70px;'>NPM</th> 
		<th>Nama Mahasiswa</th>
		<th style='width:60px;'>Jumlah MK</th>
		<th style='width:60px;'>SKS Sem.</th>
		<!---<th style='width:40px;'>SKS Kum.</th>--->
		<th style='width:60px;'>IP. Sem</th>
		<!---<th style='width:40px;'>IP. Kum</th>--->
		<!---<th style='width:40px;'>Max SKS diambil</th>--->
	</tr>";
	
	for ($i=0; $i < $jml_master;$i++) {
		echo "<tr><th colspan='10' class='tal' style='background-color:#FFF'>&nbsp;</th></tr>";
		echo "<tr><th colspan='10' class='tal'>Program Studi : ".LoadProdi_X("",$id_pst[$i])."</th></tr>";
		
    /*
    $qry ="LEFT OUTER JOIN msmhsupy ON (trakmupy.NIMHSTRAKM = msmhsupy.NIMHSMSMHS)";
		$qry .=" LEFT OUTER JOIN trnlmupy ON (trakmupy.NIMHSTRAKM = trnlmupy.NIMHSTRNLM)";
		$qry .=" WHERE trakmupy.THSMSTRAKM = trnlmupy.THSMSTRNLM AND trakmupy.THSMSTRAKM = '".$ThnSemester."' 
      AND trnlmupy.STATUTRNLM = '1' AND msmhsupy.KDPSTMSMHS ='".$id_pst[$i]."'
      AND msmhsupy.TAHUNMSMHS = '".$_SESSION['angkatan']."' 
      GROUP BY trakmupy.NIMHSTRAKM,trakmupy.SKSEMTRAKM,trakmupy.SKSTTTRAKM,trakmupy.NLIPSTRAKM,
      trakmupy.NLIPKTRAKM,trakmupy.MAKRSTRAKM,
      msmhsupy.NMMHSMSMHS,msmhsupy.TAHUNMSMHS";
		
    $MySQL->Select("trakmupy.NIMHSTRAKM,trakmupy.SKSEMTRAKM,trakmupy.SKSTTTRAKM,
    trakmupy.NLIPSTRAKM,trakmupy.NLIPKTRAKM,trakmupy.MAKRSTRAKM,msmhsupy.NMMHSMSMHS,
    COUNT(trnlmupy.KDKMKTRNLM) AS JMLMK,msmhsupy.SMAWLMSMHS","trakmupy",$qry,"msmhsupy.KDPSTMSMHS,msmhsupy.NIMHSMSMHS","");	
    */
    
    if(isset($_POST['cbProdi'])){
        $addQuery = " AND msmhsupy.KDPSTMSMHS ='".$_POST['cbProdi']."'"; 
    }else{
        $addQuery = " AND msmhsupy.KDPSTMSMHS = $id_pst[$i]";
    }
    
    

    $MySQL->Select("NIM, NAMA, ANGKATAN, SMTAWAL,
        COUNT(*) AS JML_MK,
        SUM(SKSMKTRNLM) AS JML_SKS, 
        (SUM(MUTU) / SUM(SKSMKTRNLM)) AS IP",
        "(SELECT NIMHSTRNLM AS NIM,
            SMAWLMSMHS AS SMTAWAL, 
            NMMHSMSMHS AS NAMA,
            TAHUNMSMHS AS ANGKATAN,
            trnlmupy.SKSMKTRNLM,
            IFNULL(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM,0) AS MUTU
            FROM
            trnlmupy 
            LEFT JOIN msmhsupy ON NIMHSTRNLM = NIMHSMSMHS      
                  WHERE trnlmupy.ISKONTRNLM <> '1' 
                  AND trnlmupy.THSMSTRNLM = '".$ThnSemester."'
                  AND msmhsupy.TAHUNMSMHS = ".$_SESSION['angkatan']."
            	    AND BOBOTTRNLM IS NOT NULL
	           $addQuery 
            GROUP BY NIM, KDKMKTRNLM) AS nilai
        GROUP BY NIM");
//    echo $MySQL->qry;

		$no=1;
		if ($MySQL->Num_Rows() > 0){
			while ($show=$MySQL->Fetch_Array()){
		    	echo "<tr>";
				$sel="";
				if ($no % 2 == 1) $sel="sel";
				$semester_mhs=$tahun_akademik=(((substr($ThnSemester,0,4) - substr($show["SMTAWAL"],0,4)) * 2) + ((substr($ThnSemester,4,1) - substr($show["SMTAWAL"],4,1)) + 1));
				echo "<td class='$sel tar'>".$no."&nbsp;</td>";
		     	echo "<td class='$sel tac'>".$semester_mhs."</td>";
		     	echo "<td class='$sel'>".$show['NIM']."</td>";
		     	echo "<td class='$sel'><a href='./cetak_hasil_studi.php?report_title=1&smt=".$ThnSemester."&amp;ps=".$p."&amp;nim=".$show['NIM']."'>".$show['NAMA']."</a></td>";
		     	echo "<td class='$sel tac'>".SetNullValue($show['JML_MK'])."</td>";
		     	echo "<td class='$sel tac'>".SetNullValue($show['JML_SKS'])."</td>";
		     	//echo "<td class='$sel tac'>".SetNullValue($show['SKSTTTRAKM'])."</td>";
		     	echo "<td class='$sel tac'>".SetNullValue(substr($show['IP'],0,4))."</td>";
		     	//echo "<td class='$sel tac'>".SetNullValue($show['NLIPKTRAKM'])."</td>";
		     	//echo "<td class='$sel tac'>".SetNullValue($show['MAKRSTRAKM'])."</td>";
		     	//echo "<td class='$sel tac'>24</td>";
		     	echo "</tr>";
		        $no++;
		    }
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='10'>".$msg_data_empty."</td></tr>";
//echo $MySQL->qry;
//echo $_SESSION[$PREFIX.'hak_akses_admin'];
//echo	$_SESSION[$PREFIX.'sm_akses_admin'];

		}
	}
	echo "</table>";
	
	//********* Cetak **********
	echo "<form action='cetak_hasil_studi.php' method='post' >";
	echo "<input type='hidden' name='tahun_akademik' value='".$ThnSemester."'/>";
	echo "<input type='hidden' size='50' name='program_studi' value='".$p."'/>";
	echo "<table>";
	echo "<tr>";
	echo "<td>Cetak :</td>";
	echo "<td><input name='report_title' type='radio' value='0' checked>REKAP HASIL STUDI</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>&nbsp;</td>";
	echo "<td><input name='report_title' type='radio' value='1'>KARTU HASIL STUDI</td>";
	echo "</tr>";
	echo "<tr>";
	echo "	<td colspan=\"3\">";
	echo "	<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />";
	echo "	</td>";
	echo "</tr>";	
	echo "</table>";		
	echo "</form>";
}
?>