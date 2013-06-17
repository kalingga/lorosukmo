<?
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}

//$noSeri = $_POST['noSeri'];
$nim = $_POST['nim'];
$lulus = $_POST['tglLulus'];
$wisuda = $_POST['tglWisuda'];

$MySQL->Select("NIMHSMSMHS AS NIM,
        NMMHSMSMHS AS NAMA,
        TPLHRMSMHS AS TMPLHR,
        TGLHRMSMHS AS TGLLHR,
        TAHUNMSMHS AS AKTN,
        KDPSTMSMHS AS KODE_PRODI,
        SMAWLMSMHS AS SMT_MASUK,
        NMJENMSPST AS JENJANG,
        NMFAKMSFAK AS FAK,
	 mspstupy.IDX AS ID_PRODI,
        DEKANMSFAK AS DEKAN,
        NODKNMSFAK AS NO_DEKAN,
        NMPSTMSPST AS PRODI,          
        NOMOR_SK AS NOIJIN,
        TGL_SK AS TGL_IJIN",
        "msmhsupy","
        LEFT JOIN mspstupy ON KDPSTMSMHS = IDPSTMSPST
        LEFT JOIN msfakupy ON KDFAKMSFAK = KDFAKMSPST
        LEFT JOIN
        (SELECT IDPSTMSPST AS IDPS,NOMSKMSPST AS NOMOR_SK, TGLSKMSPST AS TGL_SK
      	 FROM skpstupy	
      	 ORDER BY skpstupy.IDX DESC) AS data_ijin
      	 ON IDPS = mspstupy.IDX
        WHERE NIMHSMSMHS = '$nim'
        ORDER BY mspstupy.IDX 
        LIMIT 1");      
      
while ($show=$MySQL->Fetch_Array()){
      $nama = $show["NAMA"];;
      $tplahir = $show["TMPLHR"];;
      $tgllahir = $show["TGLLHR"];;
      $aktn = $show["AKTN"];
      $smtawal = $show["SMT_MASUK"];
      $jjg = $show["JENJANG"];;
      $fak = $show["FAK"];;
      $dekan = $show["DEKAN"];
      $nisDekan = $show["NO_DEKAN"];
      $id_prodi = $show["ID_PRODI"];
      $kode_prodi = $show["KODE_PRODI"];
      $prodi = $show["PRODI"];;
      $noijin = $show["NOIJIN"];;
      $tglIjin = $show["TGL_IJIN"];
}


if($jjg =="S1"){
 $jenjang = "Strata Satu (S1)";
}else{
 $jenjang = "Strata Dua (S2)";
}


$MySQL->Select("NMRETMSPTI AS REKTOR,
        NORETMSPTI AS NIP_REKTOR",
        "msptiupy");
      
if($MySQL->Num_Rows() > 0){
    while ($rektorat=$MySQL->Fetch_Array()){
      $rektor = $rektorat["REKTOR"];
      $nipRektor = $rektorat["NIP_REKTOR"];
    }      
}else{
  $rektor = "kosong";
} 


$MySQL->Select("NOMBAMSPST AS NO_BAN,
KDSTAMSPST AS NILAI_AKRD,
TGLBAMSPST AS TGL_AKRD",
"akpstupy",
"WHERE IDPSTMSPST = '$id_prodi'
ORDER BY IDX DESC LIMIT 1");     

while ($ak=$MySQL->Fetch_Array()){
	$no_ban = $ak["NO_BAN"];
	$akreditasi = $ak["NILAI_AKRD"];
	$tglAkrd = $ak["TGL_AKRD"];
}

// no. seri akta mengajar = ijazah
// cari dulu sudah pernah di print atau belum, kalo belum buat baru

$MySQL->Select("ijazahNoUrut AS URUT",
        "ijazah", "WHERE ijazahNIM = '$nim' LIMIT 1");
        
if($MySQL->Num_Rows() > 0){ 
    while ($ak=$MySQL->Fetch_Array()){
      $count = $ak["URUT"];	
    }          
}else{        
    $MySQL->Select("ijazahNoUrut AS URUT", "ijazah",
        "ORDER BY ijazahId DESC LIMIT 1");
 
    while ($ak=$MySQL->Fetch_Array()){
      $count = $ak["URUT"];	
    }        
    $count++;      
} 

       
$a = $kode_prodi;
if ($aktn < 2008){
  $b = substr($nim,4,1);
}else{
  $b = substr($nim,6,1);
}

$urut = str_pad($count, 6, "0", STR_PAD_LEFT);
$noSeri = $a.$b.$urut."/051015/AM";

// =================================================================

$html = '<style type="text/css">
<!--
.style4 {
	font-size: 34px;
	font-weight: bold;
}
.style5 {font-size: 8px;font-weight: bold;}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif;}
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; text-transform: capitalize;}
.style9 {font-size: 17px;font-weight: bold; text-transform: capitalize;}
.style8 {font-size: 14px;font-weight: bold;}
.style12 {font-size: 24px;font-weight: bold; text-transform: uppercase;}
.style13 {font-size: 24px;font-weight: bold; text-transform: capitalize;}
-->
</style>
<div align="center" class="style5"> <br> </div>
<table border="0">
  <tr>
    <td width="127">&nbsp; </td><td><div align="center" class="style8">'.$noSeri.'<br/></div></td>
  </tr>
</table>
<div align="center" class="style8"> <br> </div>
<p align="center" class="style12"> <br> </p>
<div align="center" class="style4">  AKTA MENGAJAR</div>
<div align="center"><br><strong>Diberikan kepada:</strong></div>
<p align="center" class="style6"><span class="style12"><strong>'.$nama.'</strong></span> lahir di 
<span class="style9">'.$tplahir.'</span> pada tanggal <span class="style9">'.FormatDateTime(strToTime($tgllahir),2).'</span><br>
Nomor Pokok Mahasiswa :<span class="style9"> '.$nim.'</span> Tahun Masuk : <span class="style9">'.$aktn.'</span></p>
<p align="center"><span class="style6">setelah menyelesaikan dan memenuhi segala persyaratan jenjang pendidikan <span class="style9">'.$jenjang.'</span> pada<br>
  Fakultas <span class="style9">'.$fak.'</span> Program Studi <span class="style9">'.$prodi.'</span><br>
  Ijin Penyelenggaraan <span class="style9">Nomor '.$noijin.'</span> tanggal '.FormatDateTime(strToTime($tglIjin),2).'<br>
  Terakreditasi <b>'.$akreditasi.'</b> berdasarkan Keputusan BAN-PT <span class="style9">Nomor '.$no_ban.'</span> tanggal '.FormatDateTime(strToTime($tglAkrd),2).'.<br>
  yang bersangkutan dinyatakan lulus pada tanggal '.$lulus.' sehingga kepadanya dilimpahkan segala wewenang<br>
  dan hak mengajar yang berhubungan dengan ijazah yang dimilikinya.<br>
<br/>
    Diberikan di Yogyakarta, pada tanggal '.$wisuda.' </span><strong><br></br/>
    </strong><br><br>
</p>
<div align="center" class="style5"> <br> </div>
<div align="center">
  <table width="990" border="0" align="center">
    <tr>
      <td width="200">&nbsp;</td>
      <td width="440" style="align:center;"><p align="center" class="style7">Dekan<br>
          Fakultas '.$fak.'</p>
        <br>
          <br>
          <br>
          
          <br>
          <br>
          
          <br>
          <br>
        <center>'.$dekan.'<br>
          NIS. '.$nisDekan.'</span><br>
                          </center></p></td>
      <td width="280"><p align="center" class="style6"><center>Rektor</p><br>
          <br>
          <br>
          <br>
          <br>
          
          <br>
          <br>
          
          <br>
        <p align="center" class="style6">'.$rektor.'<br>
        NIP. '.$nipRektor.'<br> 
        </center></p>
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>';
  
include("lib/mpdf.php");

$mpdf = new mPDF('utf-8', 'A4-L', 0, '', 3, 3, 1, 1, 1, 1, 'L');
//$mpdf=new mPDF('utf-8', 'A4-L'); 

$mpdf->WriteHTML($html);
$mpdf->Output();

$MySQL->Insert("ijazah",
              "ijazahUserId,
              ijazahNIM,
              ijazahDateTime,
              ijazahNoUrut",
              $_SESSION[$PREFIX.'id_admin'].",
              '$nim',
              now(),
              $count");
exit;

?>
