<?php
//require('fpdf.php'); //extends FPDF

class PDF 
{
    var $NIM = "";
    var $arrData = array();       
    var $arrNo = 0;
    
  function curPageURL() {
     $pageURL = 'http';
     if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
        $pageURL .= $_SERVER["SERVER_NAME"];//.$_SERVER["REQUEST_URI"];
     }
     return $pageURL."/transkrip/";
  }  
   
  function LoadDataTranskrip($nim)
  {  
    $dbhost = '192.168.0.250';
    $dbuser = 'akademik';
    $dbpass = 'akademikupyoke2009secure';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
    mysql_select_db('akademikupy');    

    /*
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
    mysql_select_db('akd_090511');
    */
	// ========== DATA MAHASISWA =====================//
    $nama ="";
    $tgllhr = "";
    $prodi = "";
    $fak = "";
    
    $dataMhs = mysql_query("SELECT
          NIMHSMSMHS AS NIM,
          NMMHSMSMHS AS NAMA,
          TGLHRMSMHS AS TGL_LHR,
          NMPSTMSPST AS PRODI,
          NMFAKMSFAK AS FAK
          FROM msmhsupy LEFT JOIN mspstupy ON KDPSTMSMHS=IDPSTMSPST
          LEFT JOIN msfakupy ON KDFAKMSPST=KDFAKMSFAK
          WHERE NIMHSMSMHS='$nim'");
    while($row = mysql_fetch_array($dataMhs)){
          $nama = $row['NAMA'];
          $tgllhr = date('d F Y',strtotime($row['TGL_LHR']));
          $prodi = $row['PRODI'];
          $fak = $row['FAK'];
    }        

    // nilai konversi
    $result1 = mysql_query("SELECT KODE,NAMA_MK, SKS, NILAI, BOBOT, MUTU
             FROM
          	 (SELECT trnlmupy.IDX as ID,
                 trnlmupy.KDKMKTRNLM AS KODE,
                 tblmkupy.NAMKTBLMK AS NAMA_MK,		
                 trnlmupy.SKSMKTRNLM AS SKS,
                 IFNULL(MAX(trnlmupy.BOBOTTRNLM),0) AS BOBOT,          
                 IFNULL((trnlmupy.SKSMKTRNLM * MAX(trnlmupy.BOBOTTRNLM)),0) AS MUTU
                 FROM trnlmupy 
                 LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
          	   LEFT JOIN tbbnlupy ON BOBOTTBBNL = trnlmupy.BOBOTTRNLM
                 WHERE
                 trnlmupy.NIMHSTRNLM ='$nim'  -- 09144600047
                 AND trnlmupy.STATUTRNLM = '1'
                 AND trnlmupy.ISKONTRNLM = '1'                            
          	     GROUP BY trnlmupy.KDKMKTRNLM
                 ORDER BY trnlmupy.IDX) AS data_nilai
            LEFT JOIN
          	(SELECT NLAKHTBBNL AS NILAI, BOBOTTBBNL AS BOBOT_REF
          	  FROM tbbnlupy) AS ref_nilai
            ON BOBOT = BOBOT_REF
            WHERE BOBOT > 0
            GROUP BY KODE
            ORDER BY ID;");
            
	
    // nilai di UPY
    $result2 = mysql_query("SELECT KODE,NAMA_MK, SKS, NILAI, BOBOT, MUTU
             FROM
          	 (SELECT trnlmupy.IDX as ID, 
                 trnlmupy.KDKMKTRNLM AS KODE,
                 tblmkupy.NAMKTBLMK AS NAMA_MK,		
                 trnlmupy.SKSMKTRNLM AS SKS,
                 IFNULL(MAX(trnlmupy.BOBOTTRNLM),0) AS BOBOT,          
                 IFNULL((trnlmupy.SKSMKTRNLM * MAX(trnlmupy.BOBOTTRNLM)),0) AS MUTU
                 FROM trnlmupy 
                 LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
          	   LEFT JOIN tbbnlupy ON BOBOTTBBNL = trnlmupy.BOBOTTRNLM
                 WHERE
                 trnlmupy.NIMHSTRNLM ='$nim'  -- 09144600047
                 AND trnlmupy.STATUTRNLM = '1'
                 AND trnlmupy.ISKONTRNLM = '0'           
          	     GROUP BY trnlmupy.KDKMKTRNLM
                 ORDER BY trnlmupy.IDX) AS data_nilai
            LEFT JOIN
          	(SELECT NLAKHTBBNL AS NILAI, BOBOTTBBNL AS BOBOT_REF
          	  FROM tbbnlupy) AS ref_nilai
            ON BOBOT = BOBOT_REF
            WHERE BOBOT > 0
            GROUP BY KODE
            ORDER BY ID;");
                     
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=transkrip_".date('d.i.s').".xls");
  header("Pragma: no-cache");
  header("Expires: 0");
    
    //echo "<table style='font-size:80%;'>";
	echo "<table>";
  echo "<tr><td></td><td rowspan='4' colspan='2'><img  align=CENTER src='http://upy.ac.id/upywarna.gif' width='80' height='80'>";
  echo "</td><td colspan='6'><b>UNIVERSITAS PGRI YOGYAKARTA</b></td></tr>";
  echo "<tr><td colspan='4'></td><td colspan='6'>Jl PGRI I Sonosewu No 117 Kotak Pos 1123 Yogyakarta 55182</td></tr>";
  echo "<tr><td colspan='4'></td><td colspan='6'>Telp. (0274) 376808, 373198, 373038 Fax. (0274) 3736808</td></tr>";
  echo "</table>";
  echo "<hr>";                  
    
  echo "<TABLE><TR><TD></TD><TD colspan='11' align='center'><h3>TRANSKRIP NILAI</h3></TD></TR>";
  echo "<tr><td colspan='3' ></td><td colspan='4'>NPM</td><td colspan='5' align='left'>&nbsp;".$nim."</td></tr>";
  echo "<tr><td colspan='3' ></td><td colspan='4'>Nama</td><td colspan='5' align='left'>$nama</td></tr>";
  echo "<tr><td colspan='3' ></td><td colspan='4'>Tanggal Lahir</td><td colspan='5' align='left'>".$tgllhr."</td></tr>";
  echo "<tr><td colspan='3' ></td><td colspan='4'>Fakultas</td><td colspan='5' align='left'>$fak</td></tr>";
  echo "<tr><td colspan='3' ></td><td colspan='4'>Program Studi</td><td colspan='5' align='left'>$prodi</td></tr>";
  echo "</TABLE>";
  echo "<br>";

  echo "<table border='1' style='font-size:50%;'>
    <th>NO</th><th>KODE</th><th width='100px'>MATA KULIAH</th>
    <th>SKS</th><th>NILAI</th><th>MUTU</th>
	  <th>NO</th><th>KODE</th><th width='100px'>MATA KULIAH</th>
    <th>SKS</th><th>NILAI</th><th>MUTU</th>";
				
	$no = 1;
	$baris = array();
	$i = 0;
  
  $baris[$i] = "";
  
  // kalo ada nilai konversi
  if(mysql_num_rows($result1) > 0){		
		$baris[$i] .= "<td colspan='6'><center><b>Nilai Konversi</b></center></td>";		
		$i++;
	}		
	
	while($row = mysql_fetch_array($result1)){		      
      $baris[$i] =  "<td>".$no. "</td>";
      $baris[$i] .=  "<td>".$row['KODE'] . "</td>";  
      $baris[$i] .=  "<td>".$row['NAMA_MK'] . "</td>";  
      $baris[$i] .=  "<td>".$row['SKS'] . "</td>";  
      $baris[$i] .=  "<td>".$row['NILAI'] . "</td>";  
      $baris[$i] .=  "<td align='right'>".$row['MUTU'] . "</td>"; 
      $no++;
      $i++;
  }
	
	// ====== Nilai di UPY ============
	// buat baris sendiri ya
	if(mysql_num_rows($result1) > 0){		
		$baris[$i] .= "<td colspan='6'><center><b>Nilai di UPY</b></center></td>";		
		$i++;
	}
		  
  while($row = mysql_fetch_array($result2)){  	        
    $baris[$i] =  "<td>".$no. "</td>";
    $baris[$i] .=  "<td>".$row['KODE'] . "</td>";  
      $baris[$i] .=  "<td>".$row['NAMA_MK'] . "</td>";  
      $baris[$i] .=  "<td>".$row['SKS'] . "</td>";  
      $baris[$i] .=  "<td>".$row['NILAI'] . "</td>";      
    $baris[$i] .=  "<td align='right'>".$row['MUTU']. "</td>";     
    $no++;
    $i++;
  }

          
  if(($i % 2)){
    $i++; 
  }
  $jmlBaris = $i/2;
	
	// ============ Write it down ==========
  for($x=0; $x < $jmlBaris; $x++){     
    echo "<tr>";
    echo $baris[$x];
    echo $baris[$x+$jmlBaris];
    echo "</tr>";
  }
    
  $result3 = mysql_query("SELECT SUM(SKS) AS JML_SKS,
      SUM(MUTU) AS JML_MUTU      
      FROM
        (SELECT  trnlmupy.SKSMKTRNLM AS SKS,                  
        IFNULL((trnlmupy.SKSMKTRNLM * MAX(trnlmupy.BOBOTTRNLM)),0) AS MUTU
        FROM trnlmupy 
        LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
        WHERE
        trnlmupy.NIMHSTRNLM ='$nim'
        AND trnlmupy.STATUTRNLM = '1'
        AND BOBOTTRNLM IS NOT NULL           
        GROUP BY trnlmupy.KDKMKTRNLM
        ORDER BY trnlmupy.IDX) AS nilai        
      ");
    
  while($row2 = mysql_fetch_array($result3)){ 
    echo "<br>"; 
    echo "<td align='right' colspan='6'></td><td align='right' colspan='3'><b>TOTAL</b></td><td  align='right'><b>".$row2['JML_SKS']."</td>";
    echo "<td></td>";  
    echo "<td  align='right'><b>".$row2['JML_MUTU']."</td>";        
    //echo "<td  align='right'><b>".substr($row2['IPK'],0,4)."</td>";
    $ipk = substr(($row2['JML_MUTU'] / $row2['JML_SKS']),0,4);   
  }  
  
  echo "</table>";
  echo "<br>";
  echo "<b>IPK : ".substr($ipk,0,4)."</b>";
  echo "<br>";    
  echo "<br>";
  echo "<br>";
  echo "<table>";
  echo "<TR><TD colspan='12' align='right'>Yogyakarta, ".date('d F Y')."</TD></TR>";
  echo "<TR><TD colspan='11' align='right'>Mengetahui,</TD></TR>";
  echo "<TR><TD colspan='5' align='center'>Dekan</TD><TD colspan='6' align='right'>Ka. Prodi    </TD></TR>";
  echo "</table>";
    
	//echo "<br><br><br> <i>Signature : ".substr(md5($nim.$prodi.date('dmY')),3,10)."</i>";
	
  
  mysql_close($conn);
}
}

// ======================================================
$nim = $_POST['NIM'];
if(!isset($nim)){
    ?>
	<TITLE>TRANSKRIP NILAI</TITLE>
	<CENTER>
	<p><img src="http://upy.ac.id/upywarna.gif" width="101" height="101"></p>
    <TABLE border="1">
	<TR>
	<TD>

    <form method="post" action="">
        <center><strong>TRANSKRIP NILAI</strong></center>
		<br><br><br>
        <table>
			<tr><td>
			Masukan NPM </td><td>
			<input type="text" name="NIM"/></td>
			<!--- <td><i>* empty means all</i></td> --->
			</tr>
			
<!--
			<tr>
			<td>
			Password </td><td>		
			<input type="password" name="pwd"/></td></tr> -->
			
			<tr>
			<td>
			<input type="submit" name="submit" value="Download xls"/>
			</td></tr>
		</table>
     
    </form>
    
	</TD>
	</TR>
	</TABLE>
	</CENTER>
    <?
}else{
    $nim = $_POST['NIM'];
	$pwd = $_POST['pwd'];

	//if($pwd == "tes"){
		$xls=new PDF();
		$data=$xls->LoadDataTranskrip($nim);
	//}else{
	//	echo "<center>Password salah!</center>";	
	//}

}


?>
