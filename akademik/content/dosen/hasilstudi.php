<?
$idpage='30'; 
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']); 
if ($sm_akses_arr[$idpage] == 0) { 
  echo $msg_not_akses; 
} else {  
  //****** Default tahun semester berjalan 
    echo "<form action='./?page=hasilstudi' method='post' >"; 
    echo "<table align='center' border='0' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>"; 
    echo "Hasil Studi Mahasiswa TA Sebelumnya : "; 
    echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n"; 
    LoadSemester_X("cbSemester",$cbSemester); 
    echo " <button type=\"submit\">GO <img src=\"images/b_go.png\" class=\"btn_img\"/></button> <button type=\"button\" onClick=window.location.href='./?page=hasilstudi'>
    <img src=\"images/b_refresh.png\" class=\"btn_img\"/> Refresh</button>\n</th>"; 
    echo "</tr></table></form>"; 
    echo "<table border='0' style='width:99%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1' class='tblbrdr' >"; 
    echo "<tr><th colspan='10' style='background-color:#EEE'>Hasil Studi Mahasiswa TA. '".substr($ThnSemester,0,4)."/".(substr($ThnSemester,0,4) + 1)."' Sem. '".LoadSemester_X('',substr($ThnSemester,4,1))."'</th></tr>"; 
    echo "<tr> 
      <th style='width:10px;'>NO</th> 
      <th style='width:10px;'>Sem.</th> 
      <th style='width:70px;'>NPM</th> 
      <th>Nama Mahasiswa</th> 
      <th style='width:40px;'>Jumlah MK</th> 
      <th style='width:40px;'>SKS Sem.</th> 
      <th style='width:40px;'>IP. Sem</th>
      <th style='width:40px;'>SKS Kum.</th>     
      <th style='width:40px;'>IP. Kum</th> 
      <th style='width:40px;'>Max SKS diambil</th> 
      </tr>"; 
      
      // hijack
      // dari data mahasiswa yg dibimbing dosen ini
      $MySQL->Select("NIMHSMSMHS AS NIM,NMMHSMSMHS AS NAMA,TAHUNMSMHS AS ANGKATAN,SMAWLMSMHS AS SMT_AWAL",
          "msmhsupy",
          "WHERE DSNPAMSMHS = '$user_admin'");            //  0512057302      
       
      $n = 0;            
      if ($MySQL->Num_Rows() > 0){
          while ($dataMhs=$MySQL->Fetch_Array()){
            $nim[$n] = $dataMhs["NIM"];
    				$nama[$n] = $dataMhs["NAMA"];
    				$akt[$n] = $dataMhs["ANGKATAN"];
    				$smt_awal[$n] = $dataMhs["SMT_AWAL"];
            $n++;    
          } 
      }else{
            echo "<tr><td align='center' style='color:red;' colspan='10'>".$msg_data_empty."</td></tr>";    
      }
      
      for($x=0;$x < $n;$x++){
          $MySQL->Select("SUM(SKS) AS JML_SKS_SEM,            
         	SUM(MUTU)/SUM(SKS) AS IP,
         	COUNT(NAMA) AS JML_MK","
              (SELECT  trnlmupy.SKSMKTRNLM AS SKS,      
              msmhsupy.NMMHSMSMHS AS NAMA, 
              TAHUNMSMHS AS ANGKATAN,            
              IFNULL((trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM),0) AS MUTU      
              FROM trnlmupy 
              LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
              LEFT JOIN msmhsupy ON trnlmupy.NIMHSTRNLM = NIMHSMSMHS
              WHERE
              trnlmupy.NIMHSTRNLM = '".$nim[$x]."'               
              AND THSMSTRNLM = '$ThnSemester'
              AND trnlmupy.STATUTRNLM = '1'           
              GROUP BY trnlmupy.KDKMKTRNLM
              ORDER BY trnlmupy.IDX) AS iii");   
              
           $no=1; 
           if ($MySQL->Num_Rows() > 0){ 
                while ($show=$MySQL->Fetch_Array()){ 
                   echo "<tr>"; $sel=""; 
                   if ($no % 2 == 1) $sel="sel";                 
                       $semester_mhs = $tahun_akademik=(((substr($ThnSemester,0,4) - substr($smt_awal[$x],0,4)) * 2) + ((substr($ThnSemester,4,1) - substr($smt_awal[$x],4,1)) + 1));                 
                   echo "<td class='$sel tar'>".$no." </td>"; 
                   echo "<td class='$sel tac'>".$semester_mhs."</td>"; 
                   echo "<td class='$sel'>".$nim[$x]."</td>"; 
                   echo "<td class='$sel'><a href='./?page=hasilstudi&p=view&nim=".$nim[$x]."'>".$nama[$x]."</a></td>";               
                   echo "<td class='$sel tac'>".SetNullValue($show['JML_MK'])."</td>"; 
                   echo "<td class='$sel tac'>".SetNullValue($show['JML_SKS_SEM'])."</td>"; 
                   echo "<td class='$sel tac'>".SetNullValue(substr($show['IP'],0,4))."</td>";
                   echo "<td class='$sel tac'>".SetNullValue($show['SKSTTTRAKM'])."</td>";                     
                   echo "<td class='$sel tac'>".SetNullValue($show['NLIPKTRAKM'])."</td>"; 
                   echo "<td class='$sel tac'>".SetNullValue($show['MAKRSTRAKM'])."</td>"; 
                   echo "</tr>"; $no++; } 
          } else { 
                   echo "<tr><td align='center' style='color:red;' colspan='10'>".$msg_data_empty."</td></tr>"; 
          }  
      
      } //end of loop get data nilai                                              
            
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
//echo "<tr>"; 
//echo "<td> </td>"; 
//echo "<td><input name='report_title' type='radio' value='1'>KARTU HASIL STUDI</td>"; 
//echo "</tr>"; 
echo "<tr>"; 
echo " <td colspan=\"3\">"; 
echo " <input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />"; 
echo " </td>"; 
echo "</tr>"; 
echo "</table>"; 
echo "</form>"; } 

?>