<?php
$idpage='22';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p'])) {
		/*** 	Hapus matakuliah yang tidak disetujui *****/
		if ($_GET['p']=='del') {
			$mk=$_GET['mk'];
			$MySQL->Delete("trnlmupy","where IDX=".$mk,"1");
		    if ($MySQL->exe){
				$act_log="Hapus ID='$id' Pada Tabel 'trnlmupy' File 'heregristrasi.php' Sukses!";
				AddLog($id_admin,$act_log);
			    echo $msg_delete_data;
			} else {
				$act_log="Hapus ID='$id' Pada Tabel 'trnlmsupy' File 'heregristrasi.php' Gagal!";
				AddLog($id_admin,$act_log);
			    echo $msg_delete_data_0;
			}
		}	
	
		$id=$_GET['id'];
		//detail cari mahasiswa berdasarkan index
		$MySQL->Select("tbkrsupy.NIMHSTBKRS,msmhsupy.NMMHSMSMHS,msmhsupy.KDPSTMSMHS,msmhsupy.DSNPAMSMHS,tbkrsupy.THSMSTBKRS","tbkrsupy,msmhsupy","WHERE tbkrsupy.NIMHSTBKRS = msmhsupy.NIMHSMSMHS AND tbkrsupy.IDX = '".$id."'","","1");
		$show=$MySQL->fetch_array();
		$nim=$show['NIMHSTBKRS'];
		$mahasiswa=$show['NMMHSMSMHS'];
		$prodi=$show['KDPSTMSMHS'];
		$fakultas=substr($show['KDPSTMSMHS'],0,1);
		$dosenpa=LoadDosen_X("",$show['DSNPAMSMHS']);
		$nidn=$show['DSNPAMSMHS'];
		$ThnSemester=$show['THSMSTBKRS'];	
	
		//****** Tampilkan Formulir KRS untuk Persetujuan 
?>
		<table border='0' style='width:97%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1' >
		  <tr><td width="15%">Nama Mahasiswa</td>
		  	  <td width="45%">: <?php echo $mahasiswa; ?></td>
		  	  <td width="15%">No. Pokok Mhs</td>
		  	  <td>: <?php echo $nim; ?></td>
		  	  <td rowspan="4" align="right">
			  </td>
		  </tr>
		  <tr><td>Fakultas</td>
		      <td>: <?php echo LoadFakultas_X("",$fakultas); ?></td>
			  <td>Kel. Registrasi</td>  	  
			  <td>:&nbsp;</td>  	  
		  </tr>
		  <tr>
		  	  <td>Progran Strudi</td>
		  	  <td>: <?php echo LoadProdi_X("",$prodi);?></td>
		  	  <td>Semester</td>
		  	  <td>:&nbsp;<?php echo LoadKode_X("",substr($ThnSemester,4,1),"95"); ?></td>
		  </tr>
		  <tr><td>Nama Dosen PA.</td>
		  	  <td>:&nbsp;<?php echo $dosenpa; ?></td>
		  	  <td>Tahun Akademik</td>
		  	  <td>:&nbsp;<?php echo substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1); ?></td>
		  </tr>
		</table>
		<table border='0' style='width:97%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1' class='tblbrdr' >
		<tr>
			<th style="width:20px">No</th>
   			<th style="width:75px">Kode MK </th>
    		<th style="width:300px">Matakuliah</th>
   			<th style="width:20px">Kls</th>
   			<th style="width:20px">Sem</th>
    		<th style="width:20px">SKS</th>
    		<th style="width:20px">B/U/P</th>
    		<th>Nama Dosen</th>
    		<th style="width:20px">ACC</th>
		</tr>			
<?php		
		$MySQL->Select("trnlmupy.IDX,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.KELASTRNLM,trnlmupy.SEMESTRNLM,trnlmupy.SKSMKTRNLM,trnlmupy.STATUTRNLM,trnlmupy.STAMKTRNLM,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) LEFT OUTER JOIN tbmksajiupy ON (trnlmupy.IDXMKSAJI = tbmksajiupy.IDX) WHERE trnlmupy.THSMSTRNLM='".$ThnSemester."' and trnlmupy.NIMHSTRNLM='".$nim."' AND trnlmupy.ISKONTRNLM <> '1'","IDX ASC");
		$jmlSKS=0;
		$i=0;
		while ($show=$MySQL->fetch_array()){
			$data[$i][0]=$show["IDX"];
			$data[$i][1]=$show["KDKMKTRNLM"];
			$data[$i][2]=$show["NAMKTBLMK"];
			$data[$i][3]=$show["KELASTRNLM"];
			$data[$i][4]=$show["SEMESTRNLM"];
			$data[$i][5]=$show["SKSMKTRNLM"];
			$data[$i][6]=$show["NMDOSMKSAJI"]." [".$show["NODOSMKSAJI"]."]";
			$data[$i][7]=$show["STATUTRNLM"];
			$data[$i][8]=$show["STAMKTRNLM"];
			$jmlSKS += $data[$i][5];
			$flag[$i]="1";
			$i++;
		}				
		$no=1;
		for ($j=0;$j < 12;$j++ ){
			$sel1="sel";
			if ($no % 2 == 1) $sel1="";
			echo "<tr><td class='$sel1 tac'>".$no."</td>
				<td class='$sel1'>".$data[$j][1]."</td>
				<td class='$sel1'>".$data[$j][2]."</td>
				<td class='$sel1 tac'>".$data[$j][3]."</td>
				<td class='$sel1 tac'>".$data[$j][4]."</td>
				<td class='$sel1 tac'>".$data[$j][5]."</td>
				<td class='$sel1  tac'>".$data[$j][8]."</td>
				<td class='$sel1'>".$data[$j][6]."</td>";
				if ($flag[$j]=="1") {
					if ($data[$j][7] == "1") {
						echo "<td class='$sel1 tac'>";
						echo "<img border='0' src='images/ico_check.png' title='DISETUJUI' />";
						echo "</td>";
					} else {
						echo "<td class='$sel1 tac'>&nbsp;</td>";
					}
				} else {
					echo "<td class='$sel1 tac'>&nbsp;</td>";
				}
				echo "</tr>";
				$no++;
		}
		echo "<tr><th colspan='5'>Jumlah SKS :</th><th colspan='5'>".$jmlSKS." SKS</th></tr>";
		echo "</table>";
		
		echo "<table width='97%' align='center'>
		  	<tr>";	 
		echo "<td width='91%' align='center'>";
		echo "<button type='reset' name='reset' onClick=window.location.href='./?page=heregristrasi'><img src='images/b_back.png' class='btn_img'/>&nbsp;Kembali</button>";
		echo "</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>";
	} else {
		echo "<form action='./?page=heregristrasi' method='post' >";
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Regristrasi Ulang Mahasiswa TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		if ($level_user != '2') {
			echo "&nbsp;@&nbsp;";
			if ($level_user=='1') {
				LoadProdi_X("cbProdi",$cbProdi,$akses_user);
			} else {
				LoadProdi_X("cbProdi",$cbProdi);
			}
		}
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form>";	
			 	
		echo "<table border='0' style='width:100%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
		echo "<form action='./?$URLa' method='post' >";
		echo "<tr><td colspan='4'>";
		echo "Pencarian Berdasarkan : <select name='field'>";
		if ($field=='tbkrsupy.NIMHSTBKRS') $sel1="selected='selected'";
		if ($field=='msmhsupy.NMMHSMSMHS') $sel2="selected='selected'";
		
		echo "<option value='tbkrsupy.NIMHSTBKRS' $sel1 >NP MAHASISWA</option>";
		echo "<option value='msmhsupy.NMMHSMSMHS' $sel2 >NAMA MAHASISWA</option>";
		echo "</select>";
		echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
		echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>\n";
		echo "<td colspan='3' class='tar'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=heregristrasi'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
		echo "</td></tr></form>";
		
		$qry ="LEFT OUTER JOIN mspstupy ON (tbkrsupy.KDPSTTBKRS = mspstupy.IDPSTMSPST) ";
		$qry .="LEFT OUTER JOIN msmhsupy ON (tbkrsupy.NIMHSTBKRS = msmhsupy.NIMHSMSMHS) ";
		$qry .="WHERE tbkrsupy.THSMSTBKRS = '".$ThnSemester."' ";
	 	$qry .="and tbkrsupy.KDPSTTBKRS IN $prive_user ";			

		if (isset($cbProdi) && ($cbProdi != '-1')) {
		 	$qry .= "and tbkrsupy.KDPSTTBKRS ='".$cbProdi."' ";			
		}
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
		 	$qry .= "and ".$field." like '%".$_REQUEST['key']."%'";			
		}
	
		$MySQL->Select("tbkrsupy.IDX,tbkrsupy.NIMHSTBKRS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST,
	  tbkrsupy.DIACCTBKRS","tbkrsupy",$qry,"tbkrsupy.KDPSTTBKRS,tbkrsupy.NIMHSTBKRS ASC","");
		$total=$MySQL->Num_Rows();
		$perpage=$_REQUEST['limit'];
		$totalpage=ceil($total/$perpage);
		$start=($_GET['pos']-1)*$perpage;
			
		$MySQL->Select("tbkrsupy.IDX,tbkrsupy.NIMHSTBKRS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST,
	  tbkrsupy.DIACCTBKRS","tbkrsupy",$qry,"tbkrsupy.KDPSTTBKRS,tbkrsupy.NIMHSTBKRS ASC","$start,$perpage");
		echo "<tr><th colspan='7' style='background-color:#EEE'>DAFTAR REGRISTRASI ULANG MAHASISWA TA. '".$ThnAjaran."/".($ThnAjaran + 1)."' SEM. '".LoadSemester_X('',$cbSemester)."'</th></tr>";
		echo "<tr>
		<th style='width:30px;'>NO</th>
		<th style='width:75px;'>NPM</th> 
		<th colspan='2'>MAHASISWA</th> 
		<th style='width:350px;'>PROGRAM STUDI</th>
		<th style='width:20px;'>DISETUJUI</th> 
		<th style='width:20px;'>ACT</th> 
		</tr>";	
		$no=1;
		if ($MySQL->Num_Rows() > 0){
			while ($show=$MySQL->Fetch_Array()){
		    	echo "<tr>";
				$sel="";
				if ($no % 2 == 1) $sel="sel";
				$acc="";
		     	if ($show['DIACCTBKRS']=='1') $acc="<img border='0' src='images/ico_check.png' title='TELAH DISETUJUI' />";
				echo "<td class='$sel tar'>".$no."&nbsp;</td>";
		     	echo "<td class='$sel'>".$show['NIMHSTBKRS']."</td>";
		     	echo "<td class='$sel' colspan='2'>".$show['NMMHSMSMHS']."</td>";
		     	echo "<td class='$sel'>".$show['NMPSTMSPST']."</td>";
		    	echo "<td class='$sel tac'>".$acc."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=heregristrasi&amp;p=view&amp;id=".$show['IDX']."' ><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		        $no++;
		    }
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='7'  class='tal'>";
		include "navigator.php";
		echo "</td></tr>";
		echo "</table>";
		//********* Cetak **********
	}			
}
?>