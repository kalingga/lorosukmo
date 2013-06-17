<?php
$idpage='28';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p']) && $_GET['p'] != 'refresh') {
		$id=$_GET['id'];
		$mahasiswa_dtl=GetMhsBaruDetail_X($id);
		$mahasiswa_dtl=@explode(",",$mahasiswa_dtl);
		
		$show["NMMHSMSMHS"].",".$show["NIMHSMSMHS"].",".$show["TPLHRMSMHS"].",".$show["TGLHRMSMHS"].",".$show["KDFAKMSPST"].",".$show["ASPSTMSMHS"].",".$show["ASPTIMSMHS"].",".$show["KDPSTMSMHS"].",".$show["TAHUNMSMHS"].",".$show["KDJENMSPST"].",".$show["KDSTAMSPST"];		
		$nama=$mahasiswa_dtl[0];
		$nim=$mahasiswa_dtl[1];
		$tplLahir=$mahasiswa_dtl[2];
		$tglLahir=$mahasiswa_dtl[3];
		$fakultas=$mahasiswa_dtl[4];
		$pst_asal=$mahasiswa_dtl[5];
		$pt_asal=$mahasiswa_dtl[6];
		$prodi=$mahasiswa_dtl[7];
		$thn_masuk=$mahasiswa_dtl[8];
		$jenjang=$mahasiswa_dtl[9];
		$akreditasi=$mahasiswa_dtl[10];
		$kurikulum=Get_Curr_kurikulum($prodi);

		echo "<table width=80% align='center'>";
		echo "<tr><td colspan='4' class='fwb tac'>KONVERSI NILAI</td></tr>";
		echo "<tr><td colspan='4'>&nbsp;</td></tr>";
		echo "<tr><td width='15%'>Nama Mahasiswa</td>";
		echo "<td>: ".$nama."</td>";
		echo "<td width='10%'>NPM</td>";
		echo "<td width='38%'>: ".$nim."</td><tr>";

		echo "<tr><td>Tempat, Tgl Lahir</td>";
		echo "<td>: ".$tplLahir.", ".DateStr($tglLahir)."</td>";
		echo "<td>Fakultas</td>";
		echo "<td>: ".LoadFakultas_X("",$fakultas)."</td><tr>";
		
		echo "<tr><td>Pendidikan Asal</td>";
		echo "<td>: ".LoadProdiDikti_X("",$pst_asal).".".LoadPT_X("",$pt_asal)."</td>";
		echo "<td>Program Studi</td>";
		echo "<td>: ".LoadProdi_X("",$prodi)."</td><tr>";


		echo "<tr><td>Tahun Masuk</td>";
		echo "<td>: ".$thn_masuk."</td>";
		echo "<td>Jenjang/Status</td>";
		echo "<td>: ".LoadKode_X("",$jenjang,"04")."/".LoadKode_X("",$akreditasi,"07")."</td><tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' style='width:80%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr>
			<th style='width:50px;'>NO</th>
			<th style='width:100px;'>KODE</th>
			<th>MATAKULIAH</th>
			<th style='width:60px;'>SKS</th>
			<th style='width:60px;'>NILAI</th></tr>";
	    
		$MySQL->Select("trnlmupy.IDX,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SKSMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE trnlmupy.ISKONTRNLM='1'AND trnlmupy.NIMHSTRNLM = '".$nim."'","trnlmupy.KDKMKTRNLM ASC","");
		$row=$MySQL->Num_Rows();
		if ($row > 0){
			$i=0;
			while ($show=$MySQL->Fetch_Array()){
				$data[$i][0] = $show['IDX'];
				$data[$i][1] = $show['KDKMKTRNLM'];
				$data[$i][2] = $show['NAMKTBLMK'];
				$data[$i][3] = $show['SKSMKTRNLM'];
				$data[$i][4] = $show['NLAKHTRNLM'];
				$data[$i][5] = $show['BOBOTTRNLM'];
				$i++;
			}
			
			$no=1;
			$jml_SKS=0;
			$jml_nilai = 0;
			for ($i=0; $i < $row ; $i++) {
				$sel="";
				if ($no % 2 == 1) $sel="sel";     	
				$name= 'cbNilai['.$i.']';
				$id_mk_arr=$data[$i][0];
				$sks_arr=$data[$i][3];
				$jml_SKS += $sks_arr;
				$jml_nilai += ($sks_arr * $data[$i][5]);
				echo "<tr>";
		     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
		     	echo "<td class='$sel tac'>".$data[$i][1]."</td>";
		     	echo "<td class='$sel'>".$data[$i][2]."</td>";
		     	echo "<td class='$sel tac'>".$data[$i][3]."</td>";
		     	echo "<td class='$sel tac'>".$data[$i][4]."</td>";
		     	echo "</tr>";
		     	$no++;
			}
			$ip_sem= 0;
			if ($jml_nilai > 0 ) {
				$ip_sem = ($jml_nilai / $jml_SKS);
			}
			echo "<tr><td colspan='2'>Jumlah SKS</td>";			     	
			echo "<td colspan='3'>: ".$jml_SKS." SKS</td></tr>";
			echo "<tr><td colspan='2'>Jumlah Nilai</td>";			     	
			echo "<td colspan='3'>: ".$jml_nilai."</td></tr>";
			echo "<tr><td colspan='2'>IP SEM</td>";			     	
			echo "<td colspan='3'>: ".$ip_sem."</td></tr>";
		} else {
			echo "<td colspan='5' align='center' style='color:red;'>".$msg_data_empty."</td>";		
		}
		echo "</table><br>";
		echo "<div class='tac'><button type='reset' onClick=window.location.href='./?page=konversinilai' /><img src='images/b_cancel.gif' class='btn_img'/>&nbsp;Batal</button></div>";
	} else {
		echo "<form action='./?page=konversinilai' method='post' >";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Mahasiswa Pindahan TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form><br>";	
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		echo "<form action='./?page=konversinilai' method='post' >";
		echo "<tr><td colspan='4'>Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='NIMHSMSMHS') $sel2="selected='selected'";
		if ($field=='NMMHSMSMHS') $sel3="selected='selected'";
	
	    echo "<option value='NIMHSMSMHS' $sel2 >NP MAHASISWA</option>";
	    echo "<option value='NMMHSMSMHS' $sel3 >NAMA MAHASISWA</option>";
	     
	    echo "</select>";
	    echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "</td><td colspan='5' align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=konversinilai&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";
	    echo "</td></tr></form>";
	
	  	$qry ="LEFT JOIN mspstupy mspstupy on msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST ";
		$qry .="where msmhsupy.SMAWLMSMHS = '".$ThnSemester."' AND msmhsupy.STPIDMSMHS = 'P' AND msmhsupy.DSNPAMSMHS = '".$user_admin."'";
	  		  	
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
		 	$qry .= "and ".$field." like '%".$_REQUEST['key']."%'";			
		}
			
		$MySQL->Select("msmhsupy.*,mspstupy.NMPSTMSPST AS PROGRAMSTUDI","msmhsupy",$qry,"msmhsupy.KDPSTMSMHS ASC,msmhsupy.NIMHSMSMHS ASC","","0");
	   	$total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
	
		$MySQL->Select("msmhsupy.*,mspstupy.NMPSTMSPST AS PROGRAMSTUDI","msmhsupy",$qry,"msmhsupy.KDPSTMSMHS ASC,msmhsupy.NIMHSMSMHS ASC","$start,$perpage","0");
	
	     echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR MAHASISWA PINDAHAN TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." SEM. ".LoadSemester_X("",substr($ThnSemester,4,1))."</th></tr>";
	     echo "<tr>
	     <th style='width:20px;'>NO</th> 
	     <th style='width:100px;'>NPM</th> 
	     <th style='width:300px;'>NAMA MAHASISWA</th> 
	     <th  colspan='2'>PROGRAM STUDI</th>
	     <th style='width:20px;'>ACT</th>
	     </tr>";
	     $no=1;
	     $i=0;
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
				echo "<a href='./?page=konversinilai&amp;p=view&amp;&amp;id=".$show['NIMHSMSMHS']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$data[$i] = $show['NIMHSMSMHS'];
		     	$no++;
		     	$i++;
		     }
		} else {
		     	echo "<tr><td align='center' style='color:red;' colspan='9'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='9'>";
	 	include "navigator.php";
		echo "</td></tr>";
	    echo "</table><br>";
	}
}
?>
