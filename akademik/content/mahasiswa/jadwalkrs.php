<?php
$idpage='33';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	/***** Cari Awal Masuk Mahasiswa ***********/
	$MySQL->Select("SMAWLMSMHS","msmhsupy","where NIMHSMSMHS='".$user_admin."'","","1");
	$show=$MySQL->fetch_array();
	$thn_masuk=$show["SMAWLMSMHS"];
 	$tahun_akademik= ((substr($ThnSemester,0,4) - substr($thn_masuk,0,4)) * 2) + 
				((substr($ThnSemester,4,1)- substr($thn_masuk,4,1)) + 1) ;
	
?>
	<br>
	<center>
	<div id="whatnewstoggler" class="fadecontenttoggler" style="width:95%;">
	<a href="#" class="toc">Sedang Berjalan</a>
	<a href="#" class="toc">Per Semester</a>
	</div>

	<div id="whatsnew" class="fadecontentwrapper" style="width:95%;  height:200px">
	<!********** Form 1 ******************>
	<div class="fadecontent">
<?php
		$MySQL->Select("setkrsupy.TASMSSETKRS,setkrsupy.MLKRSSETKRS,setkrsupy.BTKRSSETKRS,(DATEDIFF(setkrsupy.BTKRSSETKRS,setkrsupy.MLKRSSETKRS)+1) AS JMLHARI,setkrsupy.TGAWLSETKRS,setkrsupy.TGAKHSETKRS,(DATEDIFF(setkrsupy.TGAKHSETKRS,setkrsupy.TGAWLSETKRS)+1) AS JMLHARI1","setkrsupy","","setkrsupy.TASMSSETKRS DESC","1");
		$show=$MySQL->fetch_array();
		echo "<div class='tac fwb' >JADWAL PENGAJUAN KRS TA. ".substr($show['TASMSSETKRS'],0,4)."/".((substr($show['TASMSSETKRS'],0,4))+1)." SEM. ".LoadSemester_X("",substr($show['TASMSSETKRS'],4,1))."</div><br>";
		echo "<table border='0' align='center' style='width:50%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll'>";
		echo "<tr><td colspan='2' class='fwb' style='background-color:#EEE'>.: MASA PENGISIAN KRS</td></tr>";
		echo "<tr><td style='width:30%;background-color:#FEFCED;'>Tanggal</td><td>: ".DateStr($show["MLKRSSETKRS"]).
			"&nbsp;s.d&nbsp;".DateStr($show["BTKRSSETKRS"])."</td></tr>";
		echo "<tr><td style='width:30%;background-color:#FEFCED;'>Lama Hari</td><td>: ".$show["JMLHARI"]." hari</td></tr>";
		echo "<tr><td colspan='2'>&nbsp;</td></tr>";
		echo "<tr><td colspan='2' class='fwb' style='background-color:#EEE'>.: MASA PERUBAHAN KRS</td></tr>";
		echo "<tr><td style='width:30%;background-color:#FEFCED;'>Tanggal</td><td>: ".DateStr($show["TGAWLSETKRS"]).
			"&nbsp;s.d&nbsp;".DateStr($show["TGAKHSETKRS"])."</td></tr>";
		echo "<tr><td style='width:30%;background-color:#FEFCED;' >Lama Hari</td><td>: ".$show["JMLHARI1"]." hari</td></tr>";
		echo "</table>";
?>
			</div>
			<div class="fadecontent">
<?php
		echo "<table border='0' style='width:95%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
    	echo "<tr><th colspan='7' style='background-color:#EEE'>JADWAL PENGAJUAN KRS</th></tr>";
		echo "<tr>
			<th style='width:75px;' rowspan='2'>TAHUN AKADEMIK</th> 
			<th style='width:30px; tac' rowspan='2'>SEM</th> 
			<th style='width:150px;' colspan='2'>PENGISIAN KRS</th> 
			<th style='width:150px;' colspan='2'>PERUBAHAN KRS</th>
			</tr>";
		echo "<tr>
			<th style='width:150px;'>TANGGAL</th> 
			<th style='width:30px;'>HARI</th> 
			<th style='width:150px;'>TANGGAL</th> 
			<th style='width:30px;'>HARI</th>
			</tr>";

		$thn_berjalan = $thn_masuk;
		for ($i=1; $i <= $tahun_akademik;$i++) {
			if ($i > 1) {
				$thn_berjalan += 1;
				if (substr($thn_berjalan,4,1) > 2) {
					$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
				}
			}
    		echo "<tr><td colspan='6' class='fwb'>SEMESTER : ".$i."</th></tr>";
			$MySQL->Select("setkrsupy.MLKRSSETKRS,setkrsupy.BTKRSSETKRS,(DATEDIFF(setkrsupy.BTKRSSETKRS,setkrsupy.MLKRSSETKRS)+1) AS JMLHARI,setkrsupy.TGAWLSETKRS,setkrsupy.TGAKHSETKRS,(DATEDIFF(setkrsupy.TGAKHSETKRS,setkrsupy.TGAWLSETKRS)+1) AS JMLHARI1","setkrsupy","WHERE setkrsupy.TASMSSETKRS ='20072'","","1");
			if ($MySQL->num_rows() > 0) {
				$show=$MySQL->fetch_array();
	     		$semester="Gasal";
	     		if (substr($thn_berjalan,4,1)=="2") $semester="Genap";
	     		echo "<tr>";
	     		echo "<td class='sel'>".substr($thn_berjalan,0,4)."/".(substr($thn_berjalan,0,4) + 1)."</td>";
	     		echo "<td class='sel tac'>".$semester."</td>";
	     		echo "<td class='sel tac'>".DateStr($show['MLKRSSETKRS'])." s.d. ".DateStr($show['BTKRSSETKRS'])."</td>";
	     		echo "<td class='sel tar'>".$show['JMLHARI']." hari</td>";	     	
	     		echo "<td class='sel tac'>".DateStr($show['TGAWLSETKRS'])." s.d. ".DateStr($show['TGAKHSETKRS'])."</td>";
	     		echo "<td class='sel tar'>".$show['JMLHARI1']." hari</td>";
	     		echo "</tr>";
			} else {
				echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";			   }
		}
		echo "</table>";
?>
			</div>
		</div>
		</center>		
		<script type="text/javascript">
		//SYNTAX: fadecontentviewer.init("maincontainer_id", "content_classname", "togglercontainer_id", selectedindex, fadespeed_miliseconds)
		fadecontentviewer.init("whatsnew", "fadecontent", "whatnewstoggler",0, 100)
		</script>
<?php
}
?>	
