<?
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}

$idpage='39';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {  
  echo $sm_akses_arr[$idpage]."  ".$idpage;  
	echo $msg_not_akses;
} else {
  // ========== DATA MAHASISWA =====================// 
  function curPageURL() {
     $pageURL = 'http';
     if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
        $pageURL .= $_SERVER["SERVER_NAME"];//.$_SERVER["REQUEST_URI"];
     }
     return $pageURL."/akademik/";
  }     

    $nama ="";
    $tgllhr = "";
    $prodi = "";
    $fak = "";
    $nim = $_POST['nim'];
    
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
            GROUP BY KODE
            ORDER BY ID;");
                     
  //header("Content-type: application/octet-stream");
  //header("Content-Disposition: attachment; filename=transkrip_".date('d.i.s').".xls");
  //header("Pragma: no-cache");
  //header("Expires: 0");

  $html = "";
    //$html .= "<table style='font-size:80%; margin: auto;'>";
	$html .= "<table style = 'margin: auto; '>";
  $html .= "<tr><td></td><td rowspan='4'><img  align=CENTER src='".curPageURL()."images/logo2.gif' width='80' height='80'>";
  $html .= "</td><td><b>UNIVERSITAS PGRI YOGYAKARTA</b></td></tr>";
  $html .= "<tr><td></td><td >Jl PGRI I Sonosewu No 117 Kotak Pos 1123 Yogyakarta 55182</td></tr>";
  $html .= "<tr><td></td><td >Telp. (0274) 376808, 373198, 373038 Fax. (0274) 3736808</td></tr>";
  $html .= "</table>";
  $html .= "<hr>";                  
    
  $html .= "<table style=\"margin: auto;\"><TR><TD colspan='3' align='center'><h3><u>TRANSKRIP AKADEMIK</u></h3></TD></TR>";
  $html .= "<tr><td >NPM</td><td  align='left'>&nbsp;".$nim."</td></tr>";
  $html .= "<tr><td >Nama</td><td align='left'>$nama</td></tr>";
  $html .= "<tr><td >Tanggal Lahir</td><td  align='left'>".$tgllhr."</td></tr>";
  $html .= "<tr><td >Fakultas</td><td align='left'>$fak</td></tr>";
  $html .= "<tr><td >Program Studi</td><td  align='left'>$prodi</td></tr>";
  $html .= "</TABLE>";
  $html .= "<br>";

  $html .= "<table border='1' style='font-size:87%; margin:auto; border-collapse:collapse;'>
    <tr>	
    <td>NO</td><td>KODE</td><td width='100px'>MATA KULIAH</td>
    <td>SKS</td><td>NILAI</td><td>MUTU</td>
	  <td>NO</td><td>KODE</td><td width='100px'>MATA KULIAH</td>
    <td>SKS</td><td>NILAI</td><td>MUTU</td>
    </tr>	";
				
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
         
  $jmlBaris = ceil($i/2);    
	
	// ============ Write it down ==========
  for($x=0; $x < $jmlBaris; $x++){     
    $html .= "<tr>";
    $html .= $baris[$x];
    $html .= $baris[$x+$jmlBaris];
    $html .= "</tr>";
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
        GROUP BY trnlmupy.KDKMKTRNLM
        ORDER BY trnlmupy.IDX) AS nilai        
      ");
    
  while($row2 = mysql_fetch_array($result3)){ 
    $html .= "<br>"; 
    $html .= "<tr><td align='right' colspan='6'></td><td align='right' colspan='3'><b>TOTAL</b></td><td  align='right'><b>".$row2['JML_SKS']."</td>";
    $html .= "<td></td>";  
    $html .= "<td  align='right'><b>".$row2['JML_MUTU']."</td>";        
    //$html .= "<td  align='right'><b>".substr($row2['IPK'],0,4)."</td></tr>";
    $ipk = substr(($row2['JML_MUTU'] / $row2['JML_SKS']),0,4);   
  }  
  
  $html .= "</table>";
  $html .= "<br>";
  $html .= "<b>IPK : ".substr($ipk,0,4)."</b>";
  $html .= "<br>";    
  $html .= "<br>";
  $html .= "<br>";
  //$html .= "<table>";
  //$html .= "<TR><TD colspan='11' align='right'>Yogyakarta, ".date('d F Y')."</TD></TR>";
  //$html .= "</table>";
 $html .= "<p align='right'>Yogyakarta, ".date('d F Y')."</p>";
    
//$html .= "<br><br><br> <i>Signature : ".substr(md5($nim.$prodi.date('dmY')),3,10)."</i>";
   
  include("lib/mpdf.php");

  $mpdf = new mPDF('utf-8', 'A4', 0, '', 2, 2, 3, 3, 3, 3, 'P');  //kertas, font-size, font-family, margin left,right,top,bottom,header,footer, orientation
  $mpdf->WriteHTML($html);
  $mpdf->Output();

//$mpdf=new mPDF('utf-8', 'A4-L'); 
//echo $html;

	
} 

?>
