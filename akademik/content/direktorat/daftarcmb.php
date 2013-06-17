<?php
$idpage='25';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	echo "<form action='./?page=daftarcmb' method='post' >";
	echo "<table border='0' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
	echo "Mahasiswa Baru TA Sebelumnya : ";
	echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
	LoadSemester_X("cbSemester","$cbSemester");			
	echo "&nbsp;&nbsp;Gel. : <input type='text' size='4' maxlength='4' name='gelombang' value='".$gelombang."'/>&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
	echo "</tr></table></form><br>";
	$qry="LEFT OUTER JOIN mspstupy ON (tbpmbupy.PLHN1TBPMB = mspstupy.IDPSTMSPST) 
	  LEFT OUTER JOIN mspstupy mspstupy1 ON (tbpmbupy.PLHN2TBPMB = mspstupy1.IDPSTMSPST) 
	  WHERE tbpmbupy.THDTRTBPMB = '$ThSms_pmb' AND tbpmbupy.GLDTRTBPMB = '$gelombang'";
	if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
		if ($field=="TGUJITBPMB"){
			$key= rtrim($key);
			$tgl=$key;
			$key=@explode("-",$key);
			$key=$key[2]."-".$key[1]."-".$key[0];
		}
		$qry .= " and ".$field." like '".$key."'";			
	}
	$MySQL->Select("tbpmbupy.*,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2","tbpmbupy",$qry,"IDX ASC","","0");
	$total=$MySQL->Num_Rows();
	$perpage=$_REQUEST['limit'];
	$totalpage=ceil($total/$perpage);
	$start=($_GET['pos']-1)*$perpage;	
	$MySQL->Select("tbpmbupy.IDX,tbpmbupy.NODTRTBPMB,tbpmbupy.NMPMBTBPMB,mspstupy.NMPSTMSPST AS PILIHAN1,mspstupy1.NMPSTMSPST AS PILIHAN2,tbpmbupy.TGUJITBPMB,tbpmbupy.STREGTBPMB","tbpmbupy",$qry,"tbpmbupy.IDX ASC","$start,$perpage");
	echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<form action='./?page=daftarcmb' method='post' >
		<tr><td style='width:550px' colspan='3'>";
	echo "Pencarian Berdasarkan : <select name='field'>";
	if ($field=='NODTRTBPMB') $sel1="selected='selected'";
	if ($field=='NMPMBTBPMB') $sel2="selected='selected'";
	if ($field=='mspstupy.NMPSTMSPST') $sel3="selected='selected'";
	if ($field=='mspstupy1.NMPSTMSPST') $sel4="selected='selected'";
	if ($field=='TGUJITBPMB') $sel5="selected='selected'";
	
	echo "<option value='NODTRTBPMB' $sel1 >NO PENDAFTARAN</option>";
	echo "<option value='NMPMBTBPMB' $sel2 >CALON MAHASISWA</option>";
	echo "<option value='mspstupy.NMPSTMSPST' $sel3 >PILIHAN 1</option>";
	echo "<option value='mspstupy1.NMPSTMSPST' $sel4 >PILIHAN 2</option>";
	echo "<option value='TGUJITBPMB' $sel5 >TANGGAL SELEKSI</option>";
	 
	echo "</select>";
	echo "<input type='text' name='key' size='35' value='".$_REQUEST['key']."'/>\n";
	echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
	echo "<td colspan=3>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
	echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=daftarcmb&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	echo "</td></tr></form>";	
	echo "<tr><th colspan='6' style='background-color:#EEE'>DAFTAR CALON MAHASISWA TA. ".$ThnAjaran."/".($ThnAjaran+1)." SEM. ".$cbSemester." GEL. ".$gelombang."</th></tr>";
	echo "<tr>
	<th style='width:75px;' rowspan='2'>NO. PENDAFTARAN</th> 
	<th rowspan='2'>CALON MAHASISWA</th> 
	<th colspan=2>PROGRAM STUDI PILIHAN</th> 
	<th rowspan='2' style='width:100px;'>TANGGAL SELEKSI</th>
	<th style='width:50px;' rowspan='2'>KARTU UJIAN</th>
	</tr>";
	echo "<tr>
	<th style='width:200px;'>Pilihan I</th> 
	<th style='width:200px;'>Pilihan II</th> 
	</tr>";
	if ($MySQL->Num_Rows() > 0){
	    while ($show=$MySQL->Fetch_Array()){
	    	$sel="";
			if ($no % 2 == 1) $sel="sel";
			//$PILIHAN2= LoadProdi_X("",$show['PLHN2TBPMB']);
	     	$ico_check="";
			if ($show["STREGTBPMB"]=="1") $ico_check="<img border='0' src='images/ico_check.png' title='REG DISETUJUI' />";
			echo "<tr>";
	     	echo "<td class='$sel'>".$show['NODTRTBPMB']."</td>";
	     	echo "<td class='$sel'>".$show['NMPMBTBPMB']."</td>";
	    	echo "<td class='$sel'>".$show['PILIHAN1']."</td>";     	
	     	echo "<td class='$sel'>".$show['PILIHAN2']."</td>";
	     	echo "<td class='$sel'>".DateStr($show['TGUJITBPMB'])."</td>";
	     	echo "<td class='$sel tac'>".$ico_check."</td>";
	     	echo "</tr>";
	     	$no++;   		     	
	     }
	} else {
	   	 echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
	}
	echo "</table>";
	include "navigator.php";
	echo "<br>"; 
	echo "<br>";
}
?>