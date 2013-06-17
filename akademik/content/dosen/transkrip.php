<?php
$idpage='31';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
	if (isset($_GET['p']) && ($_GET['p'] != 'refresh')) {
		$id=$_GET['id'];
?>
		<br>
		<center>
	    <div class="fadecontenttoggler" style="width: 80%;">
		<a class="toc">Detail Mahasiswa</a>
		</div>
		<div class="fadecontentwrapper" style="width: 80%; height: 10px;" ></div>
<?php
			$MySQL->Select("msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,msmhsupy.TGLHRMSMHS,msmhsupy.KDPSTMSMHS,msmhsupy.TGLLSMSMHS,msmhsupy.SMAWLMSMHS","msmhsupy","where msmhsupy.IDX='".$id."'");
			$show=$MySQL->Fetch_Array();
			$nim_mhs=$show["NIMHSMSMHS"];
			$nama_mhs=$show["NMMHSMSMHS"];
			$lahir_mhs=DateStr($show["TGLHRMSMHS"]);
			$prodi_mhs=$show['KDPSTMSMHS'];
			$fak_mhs=substr($prodi_mhs,0,1);
			$tgl_lls=DateStr($show['TGLLSMSMHS']);
			$thn_masuk=$show['SMAWLMSMHS'];
			$tahun_akademik=(((substr($ThnSemester,0,4) - substr($thn_masuk,0,4)) * 2) + ((substr($ThnSemester,4,1) - substr($thn_masuk,4,1)) + 1));
		
			echo "<table align='center' style='width:80%' border='0' cellpadding='2' cellspacing='1' overflow:scroll'>";
			echo "<tr><td style='width:15%'>NPM</td>
				<td style='width:50%'>: ".$nim_mhs."</td>
				<td style='width:15%'>Tanggal Lulus</td>
				<td style='width:20%'>: ".$tgl_lls."</td></tr>";
			echo "<tr><td>Nama</td>
				<td>: ".$nama_mhs."</td>
				<td>Nomor Ijazah</td>
				<td>: </td></tr>";
			echo "<tr><td>Tanggal Lahir</td>
				<td colspan='3'>: ".$lahir_mhs."</td></tr>";
			echo "<tr><td>Fakultas</td>
				<td colspan='3'>: ".LoadFakultas_X("",$fak_mhs)."</td></tr>";
			echo "<tr><td>Program Studi</td>
				<td colspan='3'>: ".LoadProdi_X("",$prodi_mhs)."</td></tr>";
			echo "<tr><td colspan='4' class='tac'><button type=\"button\" onClick=window.location.href='./?page=transkrip'><img src=\"images/b_back.png\" class=\"btn_img\"/>&nbsp;Kembali</button></td></tr>";
			echo "</table>";
?>
		<br>
		<div id="whatnewstoggler" class="fadecontenttoggler" style="width:80%;">
		<a href="#" class="toc">LAPORAN PER SEMESTER</a>
		<a href="#" class="toc">LAPORAN PER MATAKULIAH</a>
		</div>
	
		<div id="whatsnew" class="fadecontentwrapper" style="width:80%; height: 1250px;">
			<div class="fadecontent">
<?php
			echo "<table align='center' style='width:95%' border='0' cellpadding='2' cellspacing='1' overflow:scroll' class='tblbrdr'>";
			echo "<tr><th style='width:15%'>KODE MK</th>
					<th>MATAKULIAH</th>
					<th style='width:5%'>SKS</th>
					<th style='width:5%'>NILAI</th>
					<th style='width:5%'>BOBOT</th>
					<th style='width:5%'>MUTU</th>
				</tr>";
			echo "<tr><td colspan='6' class='fwb' style='background-color:#EEE'>SETARA</td></tr>";
			$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SKSMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM,(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM) AS MUTU","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE
		  trnlmupy.NIMHSTRNLM ='".$nim_mhs."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM='1'","trnlmupy.KDKMKTRNLM");
		  	if ($MySQL->num_rows() > 0) {
		  		$no=1;
		  		while ($show=$MySQL->fetch_array()) {
		  			$sel="";
		  			if ($no % 2 == '1') $sel='sel';
					echo "<tr><td class='$sel'>".$show["KDKMKTRNLM"]."</td>";
					echo "<td class='$sel'>".$show["NAMKTBLMK"]."</td>";
					echo "<td class='$sel tac'>".$show["SKSMKTRNLM"]."</td>";
					echo "<td class='$sel tac'>".$show["NLAKHTRNLM"]."</td>";
					echo "<td class='$sel tac'>".$show["BOBOTTRNLM"]."</td>";
					echo "<td class='$sel tac'>".$show["MUTU"]."</td></tr>";
					$no++;
				}
			} else {
		   	 echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
			}
			$thn_berjalan = $thn_masuk;
			for ($i=1; $i <= $tahun_akademik;$i++) {
				if ($i > 1) {
					$thn_berjalan += 1;
					if (substr($thn_berjalan,4,1) > 2) {
						$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
					}
				}
				echo "<tr><td colspan='6' class='fwb' style='background-color:#EEE'>SEMESTER : ".$i."</td></tr>";
				$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SKSMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM,(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM) AS MUTU","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE
		  trnlmupy.NIMHSTRNLM ='".$nim_mhs."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM <> '1' AND THSMSTRNLM = '".$thn_berjalan."'","trnlmupy.KDKMKTRNLM");		
				if ($MySQL->num_rows() > 0) {
			  		$no=1;
			  		while ($show=$MySQL->fetch_array()) {
			  			$sel="";
			  			if ($no % 2 == '1') $sel='sel';
						echo "<tr><td class='$sel'>".$show["KDKMKTRNLM"]."</td>";
						echo "<td class='$sel'>".$show["NAMKTBLMK"]."</td>";
						echo "<td class='$sel tac'>".$show["SKSMKTRNLM"]."</td>";
						echo "<td class='$sel tac'>".$show["NLAKHTRNLM"]."</td>";
						echo "<td class='$sel tac'>".$show["BOBOTTRNLM"]."</td>";
						echo "<td class='$sel tac'>".$show["MUTU"]."</td></tr>";
						$no++;
					}
				} else {
				 echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
				}
			}
			echo "</table>";
?>
		</div>
		<div class="fadecontent">
<?php
			$MySQL->Select("DISTINCT trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SKSMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM,(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM) AS MUTU","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE
	  trnlmupy.NIMHSTRNLM ='".$nim_mhs."' AND trnlmupy.STATUTRNLM = '1'","trnlmupy.KDKMKTRNLM");		
			$jml_mk=$MySQL->num_rows();
			$i=0;
	  		while ($show=$MySQL->fetch_array()) {
				$kd_mk[$i] = $show["KDKMKTRNLM"];
				$nm_mk[$i] = $show["NAMKTBLMK"];
				$sk_mk[$i] = $show["SKSMKTRNLM"];
				$nl_mk[$i] = $show["NLAKHTRNLM"];
				$bb_mk[$i] = $show["BOBOTTRNLM"];
				$mt_mk[$i] = $show["MUTU"];
				$i++;
			}
	
			echo "<table align='center' style='width:95%' border='0' cellpadding='2' cellspacing='1' overflow:scroll' class='tblbrdr'>";
		echo "<tr><th style='width:10%'>KODE MK</th>
				<th>MATAKULIAH</th>
				<th style='width:5%'>SKS</th>
				<th style='width:5%'>NILAI</th>
				<th style='width:5%'>BOBOT</th>
				<th style='width:5%'>MUTU</th>
				<th colspan ='".($tahun_akademik + 1)."'>SEMESTER</th>
			</tr>";
		echo "<tr>
			<td colspan='6'>&nbsp;</td>
			<th style='width:5%'>#</th>";
		for ($i=1; $i <= $tahun_akademik;$i++) {
			if ($i > 1) {
				$thn_berjalan += 1;
				if (substr($thn_berjalan,4,1) > 2) {
					$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
				}
			}
			echo "<th style='width:5%'>$i</th>";
		}
		echo "</tr>";
		for ($i=0; $i < $jml_mk;$i++) {
			$sel="";
	 		if ($i % 2 == '1') $sel='sel';
			echo "<tr><td class='$sel'>".$kd_mk[$i]."</td>";
			echo "<td class='$sel'>".$nm_mk[$i]."</td>";
			echo "<td class='$sel tac'>".$sk_mk[$i]."</td>";
			echo "<td class='$sel tac'>".$nl_mk[$i]."</td>";
			echo "<td class='$sel tac'>".$bb_mk[$i]."</td>";
			echo "<td class='$sel tac'>".$mt_mk[$i]."</td>";
			$MySQL->Select("trnlmupy.NLAKHTRNLM","trnlmupy","WHERE trnlmupy.NIMHSTRNLM ='".$nim_mhs."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM = '1' AND trnlmupy.KDKMKTRNLM='".$kd_mk[$i]."'","");
			$show=$MySQL->fetch_array();
			echo "<td class='$sel tac'>".$show["NLAKHTRNLM"]."</td>";
			$thn_berjalan = $thn_masuk;
			for ($j=1;$j <= $tahun_akademik;$j++) {
				if ($j > 1) {
					$thn_berjalan += 1;
					if (substr($thn_berjalan,4,1) > 2) {
						$thn_berjalan = (substr($thn_berjalan,0,4) + 1)."1";
					}
				}
				$MySQL->Select("trnlmupy.NLAKHTRNLM","trnlmupy","WHERE THSMSTRNLM = '".$thn_berjalan."' AND trnlmupy.NIMHSTRNLM ='".$nim_mhs."' AND trnlmupy.STATUTRNLM = '1' AND trnlmupy.ISKONTRNLM <> '1' AND trnlmupy.KDKMKTRNLM='".$kd_mk[$i]."'","");
				$show=$MySQL->fetch_array();
				echo "<td class='$sel tac'>".$show["NLAKHTRNLM"]."</td>";
			}		
			echo "</tr>";		
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
	} else {	
		if (!isset($_GET['pos'])) $_GET['pos']=1;
		$page=$_GET['page'];
		$URLa="page=".$page;
    	$sel="";
//    	$field=$_REQUEST['field'];
//		if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];

		if (!isset($_REQUEST['limit'])){
	    	$_REQUEST['limit']="20";
		}
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		echo "<form action='./?page=transkrip' method='post' >";
		echo "<tr><td colspan='4'>Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='NIMHSMSMHS') $sel1="selected='selected'";
		if ($field=='NMMHSMSMHS') $sel2="selected='selected'";
	
	    echo "<option value='NIMHSMSMHS' $sel1 >NP MAHASISWA</option>";
	    echo "<option value='NMMHSMSMHS' $sel2 >NAMA MAHASISWA</option>";
	     
	    echo "</select>";
	    echo "<input type='text' size='50' name='key' value='".$key."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "</td><td colspan='5' align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=transkrip&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";
	    echo "</td></tr></form>";
	
	  	$qry ="LEFT OUTER JOIN mspstupy mspstupy on (msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST) WHERE msmhsupy.STMHSMSMHS IN ('A','C','N') AND msmhsupy.DSNPAMSMHS ='".$user_admin."'";
		if (!empty($key)) {
	  		$qry .= " AND ".$field." like '".$key."'";			
		}
			
		$MySQL->Select("msmhsupy.IDX,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST AS PROGRAMSTUDI","msmhsupy",$qry,"KDPSTMSMHS ASC,NIMHSMSMHS ASC","","0");
	   	$total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
	
		$MySQL->Select("msmhsupy.IDX,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST AS PROGRAMSTUDI","msmhsupy",$qry,"KDPSTMSMHS ASC,NIMHSMSMHS ASC","$start,$perpage","0");
	
	     echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR MAHASISWA</th></tr>";
	     echo "<tr>
	     <th style='width:20px;'>NO</th> 
	     <th style='width:100px;'>NPM</th> 
	     <th style='width:300px;'>NAMA MAHASISWA</th> 
	     <th colspan='2'>PROGRAM STUDI</th>
	     <th style='width:20px;'>ACT</th>
	     </tr>";
	     $no=1;
		 if ($MySQL->Num_Rows() > 0){
		     while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
				if ($no % 2 == 1) $sel="sel";
				//$PILIHAN2= LoadProdi_X("",$show['PLHN2TBPMB']);
		     	echo "<tr>";
		     	echo "<td class='$sel'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['NIMHSMSMHS']."</td>";
		     	echo "<td class='$sel'>".$show['NMMHSMSMHS']."</td>";
		    	echo "<td class='$sel' colspan='2'>".$show['PROGRAMSTUDI']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=transkrip&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
		     }
		} else {
		     	echo "<tr><td align='center' style='color:red;' colspan='9'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='9'>";
	 	include "navigator.php";
		echo "</td></tr>";
	    echo "</table>";		
	}
}
?>