<?php
$idpage='26';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p'])) {
		$edtID= $_GET['id'];
		$MySQL->Select("*","tbpmbupy","where IDX='".$edtID."'");
		$show=$MySQL->Fetch_Array();
		$edtDaftar=$show['NODTRTBPMB'];
		$edtNama=$show['NMPMBTBPMB'];
		$rbJK=$show['KDJEKTBPMB'];
		$edtLahir=$show['TPLHRTBPMB'];
		$edtTglLahir=DateStr($show['TGLHRTBPMB']);	
		$edtAlamat=$show['ALMT1TBPMB'];
		$edtKelurahan=$show['KELRHTBPMB'];
		$edtKota=$show['KABPTTBPMB'];
		$cbPropinsi=$show['PROPITBPMB'];
		$edtKodePos=$show['KDPOSTBPMB'];
		$edtTelp=$show['TELPOTBPMB'];
		$cbProdi1=$show['PLHN1TBPMB'];
		$cbProdi2=$show['PLHN2TBPMB'];
		$cbProgram=$show['PROGRTBPMB'];
		$cbStatusCMB=$show['STPIDTBPMB'];
		$cbStatus=$show['STTRMTBPMB'];
		$rbDiterima=$show['DTRMATBPMB'];
?>
	<form name="form1" action="./?page=seleksicmb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
	<input type="hidden" name="edtID" value="<?php echo $edtID; ?>">
	<input type="hidden" name="edtDaftar" value="<?php echo $edtDaftar; ?>">	
	<table style="width:99%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		<th colspan="2">PROSES SELEKSI CALON MAHASISWA BARU</th>
		</tr>
		<tr>
		<td colspan="2">&nbsp;</td>
		</tr>
		<tr><td colspan="2"><b>Identitas Diri Calon Mahasiswa</b></td></tr>
		<tr>
		    <td width="30%" >No. Pendaftaran</td>
		    <td>: <?php echo $edtDaftar; ?></td>
	    </tr>
		<tr>
		    <td>Nama Lengkap</td>
		    <td>
			: <?php echo $edtNama; ?></td>
	    </tr>
		<tr>
			<td>Jenis Kelamin</td>
			<td>: <?php echo LoadJK_X("","$rbJK"); ?></td>
		</tr>
		<tr>
		    <td>Tempat/Tanggal Lahir </td>
			<td>
			: <?php echo $edtLahir.", ".$edtTglLahir; ?></td>
	    </tr>
	  	<tr>
		    <td>Alamat</td>
		    <td>: <?php echo $edtAlamat." ".$edtKelurahan." ".$edtKota." ".LoadPropinsi_X("","$cbPropinsi")." ".$edtKodePos." Telp. ".$edtTelp; ?></td>
	    </tr>
        <tr>
          <td>Status Saat Mendaftar Sebagai</td>
          <td>:
            <?php echo LoadKode_X("","$cbStatusCMB","06") ?></td>
        </tr>
        <tr>
          <td>Program/Kelas yang Akan Diikuti</td>
          <td>:
            <?php echo LoadKode_X("","$cbProgram","97") ?></td>
        </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">Telah Mengikuti Semua Tahapan Seleksi PMB di Universitas PGRI Yogyakarta dan dinyatakan : <?php echo "<b>".LoadKode_X("","$cbStatus","83","")."</b>"; ?></td></tr>
		<tr>
		    <td>pada Program Studi</td>
		    <td>: 
<?php 
			$Pil1="";
			$Pil2="";
			if ($rbDiterima==$cbProdi1){
				$Pil1="Checked";	
			}
			if ($rbDiterima==$cbProdi2){
				$Pil2="Checked";	
			}					
		    echo "<input name='rbDiterima' type='radio' value='$cbProdi1' $Pil1 />".LoadProdi_X("","$cbProdi1","")."&nbsp;&nbsp;&nbsp;";
		    echo "<input name='rbDiterima' type='radio' value='$cbProdi2' $Pil2 />".LoadProdi_X("","$cbProdi2","");

?>
			</td>
	    </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
	    	<td colspan="2" align="center">
<button type='button' onClick=window.location.href='./?page=seleksicmb'><img src='images/b_back.png' class='btn_img'/>&nbsp;Kembali</button>		    	
			</td>
		</tr>
	</table>
	</form>
	<br>
<?php
	} else {
		echo "<form action='./?page=seleksicmb' method='post' >";
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Mahasiswa Baru TA. Sebelumnya : ";
	    echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester","$cbSemester");			
	    echo "&nbsp;&nbsp;Gel. : <input type='text' size='4' maxlength='4' name='gelombang' value='".$gelombang."'/>&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
	    echo "</tr></table></form>";
				
	 	echo "<form action='./?page=seleksicmb' method='post' ><table><tr><td style='width:550px'>";
	 	echo "Pencarian Berdasarkan : <select name='field'>";
     	if ($field=='NODTRTBPMB') $sel1="selected='selected'";
     	if ($field=='NMPMBTBPMB') $sel2="selected='selected'";
     	if ($field=='DTRMATBPMB') $sel3="selected='selected'";

     	echo "<option value='NODTRTBPMB' $sel1 >NO PENDAFTARAN</option>";
     	echo "<option value='NMPMBTBPMB' $sel2 >CALON MAHASISWA</option>";
     	echo "<option value='mspstupy2.NMPSTMSPST' $sel3 >DITERIMA DI</option>";

     
     	echo "</select>";
     	echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
     	echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
	 	echo "</td><td align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
	 	echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=seleksicmb&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 

     	echo "</td></tr></table></form>";
     	
  		$qry ="LEFT JOIN mspstupy mspstupy on tbpmbupy.PLHN1TBPMB = mspstupy.IDPSTMSPST";
		$qry .=" LEFT JOIN mspstupy mspstupy1 on tbpmbupy.PLHN2TBPMB = mspstupy1.IDPSTMSPST";
		$qry .=" LEFT JOIN mspstupy mspstupy2 on tbpmbupy.DTRMATBPMB = mspstupy2.IDPSTMSPST";
		$qry .=" WHERE (tbpmbupy.THDTRTBPMB = '$ThSms_pmb' AND tbpmbupy.GLDTRTBPMB = '$gelombang' AND tbpmbupy.STREGTBPMB = '1')";
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
   			$qry .= " and ".$field." like '".$key."'";
		}
		$MySQL->Select("tbpmbupy.*,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2,mspstupy2.NMPSTMSPST AS DITERIMA","tbpmbupy",$qry,"IDX ASC","","0");
     	$total=$MySQL->Num_Rows();
     	$perpage=$_REQUEST['limit'];
     	$totalpage=ceil($total/$perpage);
     	$start=($_GET['pos']-1)*$perpage;	

	 	$MySQL->Select("tbpmbupy.*,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2,mspstupy2.NMPSTMSPST AS DITERIMA","tbpmbupy",$qry,"IDX ASC","$start,$perpage");
     	echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th colspan='7' style='background-color:#EEE'>HASIL SELEKSI CALON MAHASISWA BARU TA. ".$ThnAjaran."/".($ThnAjaran+1)." SEM. ".$cbSemester." GEL. ".$gelombang."</th></tr>";
     	echo "<tr>
     	<th style='width:100px;' rowspan='2'>NO. PENDAFTARAN</th> 
     	<th rowspan='2' style='width:100px;'>CALON MAHASISWA</th> 
     	<th colspan=2 style='width:150px;'>PROGRAM STUDI PILIHAN</th> 
     	<th style='width:20px;' rowspan='2'>STATUS</th>
     	<th style='width:75px;' rowspan='2'>PROGRAM STUDI</th>
     	<th style='width:20px;' rowspan='2'>ACT</th>
     	</tr>";
     	echo "<tr>
     	<th style='width:75px;'>Pilihan I</th> 
     	<th style='width:75px;'>Pilihan II</th> 
     	</tr>";
     	$i=0;
     	$jumlah_row=$MySQL->Num_Rows();
     	while ($show=$MySQL->Fetch_Array()){
	     		$row[$i][0]=$show['IDX'];
	     		$row[$i][1]=$show['NODTRTBPMB'];
				$row[$i][2]=$show['NMPMBTBPMB'];
				$row[$i][3]=$show['PILIHAN1'];
				$row[$i][4]=$show['PILIHAN2'];
				$row[$i][5]=$show['STTRMTBPMB'];
				$row[$i][6]=$show['DITERIMA'];
	     		$data[$i][0]=$show['NODTRTBPMB'];
				$data[$i][1]=$show['NMPMBTBPMB'];
				$data[$i][2]=$show['STTRMTBPMB'];
				$data[$i][3]=$show['DITERIMA'];
				$i++;
     	}
     	
	 	if ($jumlah_row > 0){	
     		for ($i=0; $i < $jumlah_row;$i++) {
				$status[$i]=LoadKode_X("",$row[$i][5],"83");
			}

	 		for ($i=0; $i < $jumlah_row; $i++) {
	     		$sel="";
				if ($no % 2 == 1) $sel="sel";
			//$PILIHAN2= LoadProdi_X("",$show['PLHN2TBPMB']);
	     		echo "<tr>";
	     		echo "<td class='$sel'>".$row[$i][1]."</td>";
	     		echo "<td class='$sel'>".$row[$i][2]."</td>";
	    		echo "<td class='$sel'>".$row[$i][3]."</td>";     	
	     		echo "<td class='$sel'>".$row[$i][4]."</td>";
	     		echo "<td class='$sel'>".$status[$i]."</td>";
	     		echo "<td class='$sel'>".$row[$i][6]."</td>";
	     		echo "<td class='$sel tac'>";
				echo "<a href='./?page=seleksicmb&amp;p=view&amp;id=".$row[$i][0]."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
	     		echo "</td>";
	     		echo "</tr>";
	     		$no++;
	     	}
		} else {
	     	echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
		}
    	echo "</table>";
 		include "navigator.php";
		echo "<br>"; 
		echo "<br>"; 
	}
}
?>