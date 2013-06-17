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
	<table style="width:99%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		<th colspan="2">DETAIL CALON MAHASISWA BARU</th>
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
	<br>
<?php
	} else {
		$qry =" LEFT JOIN mspstupy on tbpmbupy.DTRMATBPMB = mspstupy.IDPSTMSPST";
		$qry .=" WHERE (tbpmbupy.THDTRTBPMB = '$ThSms_pmb' AND tbpmbupy.STREGTBPMB = '1')";
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
   			$qry .= " and ".$field." like '".$key."'";
		}
	 	$MySQL->Select("tbpmbupy.*,mspstupy.NMPSTMSPST AS DITERIMA","tbpmbupy",$qry,"IDX ASC","");
     	echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th colspan='7' style='background-color:#EEE'>HASIL SELEKSI CALON MAHASISWA BARU TA. ".$ThnAjaran."/".($ThnAjaran+1)." SEM. ".LoadSemester_X("",$cbSemester)."</th></tr>";
     	echo "<tr>
     		<th style='width:10%px;'>NO. PENDAFTARAN</th> 
     		<th style='width:35%;'>CALON MAHASISWA</th> 
     		<th style='width:10%;'>DITERIMA/TIDAK DITERIMA</th>
     		<th style='width:40%;'>KETERANGAN</th>
     		<th style='width:5%;'>ACT</th>
     		</tr>";
     	$i=0;
     	$jml_data=$MySQL->num_rows();
     	while ($show=$MySQL->Fetch_Array()){
			$row[$i][0] = $show['IDX'];
     		$row[$i][1] = $show['NODTRTBPMB'];
     		$row[$i][2] = $show['NMPMBTBPMB'];
    		$row[$i][3] = $show['STTRMTBPMB'];     	
     		$row[$i][4] = $show['DITERIMA'];
     		$i++;
     	}

		if ($jml_data > 0) {
			$no=1;
	     	for ($i=0; $i < $jml_data; $i++){
	     		$sel="";
				if ($no % 2 == 1) $sel="sel";
	     		echo "<tr>";
	     		echo "<td class='$sel'>".$row[$i][1]."</td>";
	     		echo "<td class='$sel'>".$row[$i][2]."</td>";
	    		echo "<td class='$sel'>".LoadKode_X("",$row[$i][3],83)."</td>";     	
	     		echo "<td class='$sel'>".$row[$i][4]."</td>";
	     		echo "<td class='$sel tac'>";
				echo "<a href='./?page=seleksicmb&amp;p=edit&amp;id=".$row[$i][0]."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
	     		echo "</td>";
	     		echo "</tr>";
	     		$no++;
	     	}
		} else {
	     	echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
		}
    	echo "</table>";
		echo "<br>"; 
	}
}
?>