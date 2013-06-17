<?
include "include/pay_config.php";
?>

<style type="text/css">
<!--
body {
	background-color: #111111;
}
.style1 {color: #CCCCCC}
.style3 {	color: #999999;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
</style>
<span class="style1">
<p>&nbsp;</p>
<p><br>
  <?php 
 $namaFile = basename( $_FILES['uploaded']['name']);
 $pwd = $_POST['pwd'];
 $target = "excel_file/"; 
 $target = $target . "data_sks.xls" ; 
 $ok=1; 

 //echo "<center>";
 if($pwd == "pembayaranupy2011adi" ){ 
   if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)){
	 
    	 require_once 'Excel/reader.php';
       // ExcelFile($filename, $encoding);
       $data = new Spreadsheet_Excel_Reader();
      
       // Set output Encoding.
       $data->setOutputEncoding('CP1251');
    	 $data->read($target);
    	 error_reporting(E_ALL ^ E_NOTICE);
       
        for ($i = 5; $i <= $data->sheets[0]['numRows']; $i++) {
        	/*for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
        		echo " | ".$data->sheets[0]['cells'][$i][$j]." | ";
        	}
        	*/
        	$nim = $data->sheets[0]['cells'][$i][2];
          $nominal =  $data->sheets[0]['cells'][$i][9];
          $tglBayar = substr($data->sheets[0]['cells'][$i][22],4,4)."-".substr($data->sheets[0]['cells'][$i][22],2,2)."-".substr($data->sheets[0]['cells'][$i][22],0,2);  
        	$MySQL->Insert("pembayaran","bayarNim,bayarNominal,bayarTanggal,bayarTanggalUpload","'$nim','$nominal','$tglBayar',now()");
  //echo $MySQL->qry;
  //echo "<br>";
        }
  	 
  	    echo "File <b> $namaFile </b> berhasil di upload";
 
    }else { // ============= JIKA GAGAL UPLOAD ====//
	     echo "Maaf, file gagal di upload.";
    }
 }else{
    echo "ERROR : unauthorized";
 }   
 
 echo "</span>";
 ?> 
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br>
  <br>
</p>
<p>&nbsp;</p>
<p align="center" class="style3">&copy; PPTIK 2011<br>
  Universitas PGRI Yogyakarta </p>
