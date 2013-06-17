<?php
$idpage='30';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
?>
	<br>
	<center>
    <div class="fadecontenttoggler" style="width: 50%;">
	<a class="toc">Detail Mahasiswa</a>
	</div>
	<div class="fadecontentwrapper" style="width: 50%; height: 10px;" ></div>
<?php
	$MySQL->Select("msmhsupy.NMMHSMSMHS,msmhsupy.DSNPAMSMHS,tbkodupy.NMKODTBKOD,mspstupy.SKSTTMSPST,msmhsupy.SMAWLMSMHS","msmhsupy","LEFT OUTER JOIN mspstupy ON (msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST) LEFT OUTER JOIN tbkodupy ON (msmhsupy.STMHSMSMHS = tbkodupy.KDKODTBKOD) where msmhsupy.NIMHSMSMHS='".$user_admin."' AND tbkodupy.KDAPLTBKOD='05'");
	$show=$MySQL->Fetch_Array();
	$nama_mhs=$show["NMMHSMSMHS"];
	$nidn_dsn=$show['DSNPAMSMHS'];
	$nama_dsn=LoadDosen_X("",$nidn_dsn);
	$stat_mhs=$show["NMKODTBKOD"];
	$sks_diselesaikan=$show["SKSTTMSPST"];
	$thn_masuk=$show["SMAWLMSMHS"];
	$tahun_akademik=(((substr($ThnSemester,0,4) - substr($thn_masuk,0,4)) * 2) + ((substr($ThnSemester,4,1) - substr($thn_masuk,4,1)) + 1));

	/** Mencari Jumlah SKS yang telah diambil - HIJACKED****/ 
	/*
	$MySQL->Select("MAX(trnlmupy.BOBOTTRNLM) AS FIELD_1,trnlmupy.KDKMKTRNLM,trnlmupy.SKSMKTRNLM","trnlmupy","WHERE trnlmupy.NIMHSTRNLM = '".$user_admin."' AND trnlmupy.STATUTRNLM = '1' GROUP BY trnlmupy.KDKMKTRNLM,trnlmupy.SKSMKTRNLM","");
	$sks_diperoleh=0;
	while ($show=$MySQL->Fetch_Array()){
		$sks_diperoleh += $show["SKSMKTRNLM"];
	}
	*/
	/*** Mencari IPK Sementara dari Mahasiswa Bersangkutan - HIJACKED*****/
	$ipk_semu = 0;
	
	
	$MySQL->Select("SUM(SKS) AS JML_SKS,
      SUM(MUTU) AS JML_MUTU"," 
      (SELECT  trnlmupy.SKSMKTRNLM AS SKS,                  
      IFNULL((trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM),0) AS MUTU
      FROM trnlmupy 
      LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
      WHERE
      trnlmupy.NIMHSTRNLM ='$user_admin'
      AND trnlmupy.STATUTRNLM = '1'           
      GROUP BY trnlmupy.KDKMKTRNLM
      ORDER BY trnlmupy.IDX) AS nilai");      
      
      while($show=$MySQL->fetch_array()){          
            $skstt_mhs = $show["JML_SKS"];            
            $ipk_semu = substr(($show["JML_MUTU"] / $show["JML_SKS"]),0,4);            
      }
	// =========== edit 
	/*
	$MySQL->Select("MAX(trakmupy.THSMSTRAKM) AS FIELD_1,trakmupy.NIMHSTRAKM,trakmupy.NLIPKTRAKM",
  "trakmupy",
  "WHERE trakmupy.NIMHSTRAKM = '".$user_admin."' 
  AND trakmupy.THSMSTRAKM < '".$ThnSemester."' 
  GROUP BY trakmupy.NIMHSTRAKM,trakmupy.NLIPKTRAKM","","1");
  */
  // ===================================
  
	//$show=$MySQL->fetch_array();
	//$ipk_semu += $show["NLIPKTRAKM"];
	
	echo "<table align='center' border='0' style='width:50%; cellpadding='0' cellspacing='0' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<tr><td style='width:50%' class='fwb'>Nama</td><td >: ".$nama_mhs."</td></tr>";
	echo "<tr><td class='sel  fwb'>NPM</td><td class='sel'>: ".$user_admin."</td></tr>";
	echo "<tr><td class='fwb'>Pembimbing Akademis</td><td>: ".$nama_dsn." - ".$nidn_dsn."</td></tr>";
	echo "<tr><td class='sel fwb'>Semester saat ini</td><td class='sel'>: ".$tahun_akademik."</td></tr>";
	echo "<tr><td class='fwb'>Status</td><td>: ".$stat_mhs."</td></tr>";
	echo "<tr><td class='fwb'>Jumlah SKS diperoleh</td><td>: ".$skstt_mhs."</td></tr>";
	echo "<tr><td class='sel fwb'>Jumlah SKS yang harus diselesaikan</td><td class='sel'>: ".$sks_diselesaikan."</td></tr>";
	echo "<tr><td class='fwb'>IPK SEMENTARA</td><td>: ".$ipk_semu."</td></tr>";
	echo "</table>";
?>
	<div class="fadecontentwrapper" style="width: 50%; height: 10px;" ></div>
    <br><br>
	<div class="fadecontenttoggler" style="width: 80%;">
	<a class="toc">Statistik Nilai</a>
	</div>
	<div class="fadecontentwrapper" style="width: 80%; height: 10px;" ></div>
	<table style="width: 80%;"><tr><td style="width: 15%;">
	<tr><td style="width:5%;">
<?php
	/*** Mencari nilai yang ditetapkan universitas *******/ 
	$MySQL->Select("*","tbbnlupy","","BOBOTTBBNL DESC");
	$jml_data=$MySQL->num_rows();
	if ($jml_data > 0) {
		$i=0;
		while ($show=$MySQL->fetch_array()) {
			$nilai[$i]=$show["NLAKHTBBNL"];
			$i++;
		}
	}
	
	echo "<table border='0' cellpadding='2' cellspacing='1' overflow:scroll' class='tblbrdr' >";
	echo "<tr><th style='width:50%'>NILAI</th><th>JML</th></tr>";
	for ($i=0; $i < $jml_data; $i ++) {
		$sel="";
		if ($i % 2 == 1) $sel="sel";			
		$MySQL->Select("NILAI,COUNT(NILAI) AS JML_NILAI","(SELECT trnlmupy.KDKMKTRNLM AS MK,MAX(trnlmupy.NLAKHTRNLM) AS NILAI,MAX(trnlmupy.BOBOTTRNLM) AS BOBOT FROM trnlmupy WHERE trnlmupy.NIMHSTRNLM = '".$user_admin."' GROUP BY trnlmupy.KDKMKTRNLM) AS TABLE_1","WHERE TABLE_1.NILAI ='".$nilai[$i]."' GROUP BY TABLE_1.NILAI");
		$show=$MySQL->fetch_array();
		echo "<tr><td class='$sel'>&nbsp;&nbsp;&nbsp;&nbsp;".$nilai[$i]."</td>
		<td class='$sel tar'>".SetNullValue($show["JML_NILAI"])."&nbsp;&nbsp;</td></tr>";
	}
	echo "</table>";
?>		
	</td>
	<td style="width: 30%;">
<?php
	//*** Set Bobot Max *********/
	$MySQL->Select("MAX(BOBOTTBBNL) AS MAX_BOBOT","tbbnlupy","","1");
	echo "<table border='0' cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<tr><th style='width:10%'>SEM</th>
		<th style='width:10%'>JML SKS</th>
		<th style='width:10%'>IP SEM</th>
		<th style='width:10%'>IP KUM</th>
		<th style='width:10%'>JML MK</th>
		</tr>";
		/**** Mencari Nilai IPK hasil konversi ***/
		$MySQL->Select("SUM(trnlmupy.SKSMKTRNLM) AS JMLSKS,COUNT(trnlmupy.KDKMKTRNLM) AS JMLMK,((trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM) / trnlmupy.SKSMKTRNLM) AS IPSEM,trnlmupy.NIMHSTRNLM","trnlmupy","WHERE trnlmupy.NIMHSTRNLM = '".$user_admin."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM = '1' GROUP BY IPSEM,trnlmupy.NIMHSTRNLM","","1");
		$show=$MySQL->fetch_array();
	echo "<tr><td class='sel tac'>Konversi</td>
		<td class='sel tar'>".SetNullValue($show["JMLSKS"])."&nbsp;</td>
		<td class='sel tar'>0&nbsp;</td>
		<td class='sel tar'>".SetNullValue(substr($show["IPSEM"],0,4))."&nbsp;</td>
		<td class='sel tar'>".SetNullValue($show["JMLMK"])."&nbsp;</td>
		</tr>";
		
	/**** Mencari Nilai IPK per Semester ***/
	$thn_berjalan = $thn_masuk;
	$ips="";
	$ipk="";
		$bufferSKS = 0;
    $bufferMUTU = 0;
	
	for ($i=1; $i <= $tahun_akademik;$i++) {
     
		if ($i > 1) {
			$thn_berjalan += 1;
			if (substr($thn_berjalan,4,1) > 2) {
				$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
			}
		}
		$sel="";
		if ($i % 2 != 1) $sel="sel";
		$thn_sms=($tahun_masuk + $thn).$sms;
		
		$MySQL->Select("SUM(SKS) AS JML_SKS,
      SUM(MUTU) AS JML_MUTU"," 
      (SELECT  trnlmupy.SKSMKTRNLM AS SKS,                  
      IFNULL((trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM),0) AS MUTU
      FROM trnlmupy 
      LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
      WHERE
      trnlmupy.NIMHSTRNLM ='$user_admin'
      AND trnlmupy.THSMSTRNLM = '$thn_berjalan'
      AND trnlmupy.STATUTRNLM = '1'           
      GROUP BY trnlmupy.KDKMKTRNLM
      ORDER BY trnlmupy.IDX) AS nilai");
		/* hijacked
    $MySQL->Select("NLIPSTRAKM,SKSEMTRAKM,NLIPKTRAKM","trakmupy",
			"where NIMHSTRAKM = '".$user_admin."' AND THSMSTRAKM='".$thn_berjalan."'","","1");
		*/	
		while($show=$MySQL->fetch_array()){
  		$ip_sem=substr(($show["JML_MUTU"] / $show["JML_SKS"]),0,4);
  		$sks_sem=SetNullValue($show["JML_SKS"]);
  		$bufferSKS += $show["JML_SKS"];
      $bufferMUTU += $show["JML_MUTU"]; 
    }
    
    $ipk_sem = substr($bufferMUTU / $bufferSKS,0,4);
    
		$MySQL->Select("COUNT(trnlmupy.SKSMKTRNLM) AS JMLMK","trnlmupy","WHERE 
			trnlmupy.THSMSTRNLM = '".$thn_berjalan."' AND trnlmupy.NIMHSTRNLM = '".$user_admin."' 
      AND trnlmupy.STATUTRNLM = '1' 
      AND trnlmupy.ISKONTRNLM <> '1'","","1");
		$show=$MySQL->fetch_array();
		$jml_mk=SetNullValue($show["JMLMK"]);  			
		echo "<tr><td class='tac $sel'>".$i."</td>
			<td class='tar $sel'>".$sks_sem."&nbsp;</td>
			<td class='tar $sel'>".$ip_sem."&nbsp;</td>
			<td class='tar $sel'>".$ipk_sem."&nbsp;</td>
			<td class='tar $sel'>".$jml_mk."&nbsp;</td>
			</tr>";
		if ($i==1) {
			$ipsem .= $ip_sem;
			$ipkum .= $ipk_sem;
			$term1 .= "Sem ".$i;
		} else {
			$ipsem .= ",".$ip_sem;
			$ipkum .= ",".$ipk_sem;
			$term1 .= ",Sem ".$i;
		}
	}
	echo "</table>";
?>
	</td>
	<td align="center">
<?php
	$ipsem=@explode(",",$ipsem);
	$ipkum=@explode(",",$ipkum);

	$term1=@explode(",",$term1);

	require "./include/htmlgraph/class.htmlgraph.php";
    
    $gr = new HTMLGraph("95%", "250", "IP SEM/IP KUM per SEMESTER");
    $plot = new HTMLGraph_BarPlot();
    $plot->bars->color = "#AAAAFF";
    $plot->add($ipsem, $term1);
    $plot2 = new HTMLGraph_BarPlot();
    $plot2->bars->color = "#63CF89";
    $plot2->add($ipkum);
    $group = new HTMLGraph_BarPlotGroup();
    $group->add($plot);
    $group->add($plot2);
    $gr->add($group);
    $gr->footnote->caption = "SEMESTER";
    $gr->render();
?>
	</td>
	</tr></table>				
	<div class="fadecontentwrapper" style="width: 80%; height: 10px;" ></div>
	</center>		
<?php
}
?>