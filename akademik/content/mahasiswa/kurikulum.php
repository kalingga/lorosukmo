<?php
$idpage='15';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p'])) {
		$id=$_GET['id'];
		$MySQL->Select("tbkmkupy.*,tblmkupy.KDKLTBLMK","tbkmkupy","LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.IDX=".$id,"1");
		$show=$MySQL->fetch_array();
		$cbMatakuliah=$show['KDKMKTBKMK'];
		$edtSKS=$show['SKSMKTBKMK'];
		$edtSKSTM=$show['SKSTMTBKMK'];
		$edtSKSPR=$show['SKSPRTBKMK'];
		$edtSKSLP=$show['SKSLPTBKMK'];

		$edtSemester=$show['SEMESTBKMK'];
		$cbJenisMK=$show['KDWPLTBKMK'];
		$cbLingkupMK=$show['KDKURTBKMK'];
		$cbPrasyarat=$show['KDSYATBKMK'];
		$cbDosen=$show['NODOSTBKMK'];
		$rbSilabus=$show['SLBUSTBKMK'];
		$rbAcaraKuliah=$show['SAPPPTBKMK'];
		$rbBahanAjar=$show['BHNAJTBKMK'];
		$rbDiktat=$show['DIKTTTBKMK'];
		$kel_mk = $show['KDKLTBLMK'];
?>
		<center>					
	    <div id="whatnewstoggler" class="fadecontenttoggler" style="width:80%">
		<a href="#" class="toc">DETAIL MATAKULIAH</a></div>
		<div id="whatsnew" class="fadecontentwrapper" style="width:80%; height: 2px;"></div>
		<table style="width:80%" border="0" cellpadding="1" cellspacing="1">
			<tr><td colspan="2">&nbsp;</td></tr>	
			<tr>
			    <td  style="width:25%" >Matakuliah</td>
			    <td class="mandatory">
				: <?php echo LoadMatakuliah_X("","$cbMatakuliah"); ?>
		    </tr>
			<tr>
			    <td>Kelompok Matakuliah</td>
			    <td>: <?php echo LoadKode_X("","$kel_mk","10") ?>

		    </tr>
			<tr>
			    <td>Bobot SKS Matakuliah</td>
			    <td>: <?php echo $edtSKS; ?>&nbsp;SKS

		    </tr>
			<tr>
			    <td>SKS Tatap Muka</td>
			    <td>: <?php echo $edtSKSTM; ?>&nbsp;SKS

		    </tr>
			<tr>
			    <td>SKS Praktikum</td>
			    <td>: <?php echo $edtSKSPR; ?>&nbsp;SKS
		    </tr>
			<tr>
			    <td>SKS Praktek Lapangan</td>
			    <td>: <?php echo $edtSKSLP; ?>&nbsp;SKS
			</tr>
			<tr>
			    <td>Untuk Semester</td>
			    <td>: <?php echo $edtSemester; ?>

		    </tr>
			<tr>
			    <td>Jenis Matakuliah</td>
			    <td>: 
				<?php echo LoadKode_X("","$cbJenisMK","28"); ?>
		    </tr>
			<tr>
			    <td>Lingkup Matakuliah</td>
			    <td>: <?php echo LoadKode_X("","$cbLingkupMK","11"); ?>
		    </tr>
			<tr>
			    <td>Nama Dosen Pengampu</td>
			    <td>: <?php echo LoadDosen_X("","$cbDosen"); ?>
		    </tr>
			<tr>
			    <td>Prasyarat Matakuliah</td>
			    <td>: <?php echo LoadMatakuliah_X("","$cbPrasyarat"); ?>
		    </tr>
			<tr>
		    <td>Silabus</td>
			<td>
			: 
<?php
			$opt="Tidak - ada";
			if ($rbSilabus=='1') $opt="Ya - ada";
			echo $opt;
					
?>
	    	</td>
			</tr>
			<tr>
		    <td>Satuan Acara Perkuliahan</td>
			<td>
			: 
<?php
				$opt="Tidak - ada";
				if ($rbAcaraKuliah=='1') $opt="Ya - ada";
				echo $opt;
?>
	    	</td>
			</tr>
			<tr>
		    <td>Bahan Ajar</td>
			<td>
			: 
<?php
			$opt="Tidak - ada";
			if ($rbBahanAjar=='1') $opt="Ya - ada";
			echo $opt;
?>
	    	</td>
			</tr>
			<tr>
		    <td>Diktat</td>
			<td>
			: 
<?php
			$opt="Tidak - ada";
			if ($rbDiktat=='1') $opt="Ya - ada";
			echo $opt;
?>
	    	</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			    <td colspan="2" align="center">
		        <button type="button" onClick=window.location.href="./?page=kurikulum" /><img src="images/b_back.png" class="btn_img">&nbsp;Kembali</button>
				</td>
			</tr>
		</table>
		</center>		
<?php		
	} else {
		$user_admin=$_SESSION[$PREFIX.'user_admin'];
		$MySQL->Select("KDPSTMSMHS","msmhsupy","WHERE NIMHSMSMHS = '".$user_admin."'","","1");
		$show=$MySQL->fetch_array();
		$qry ="WHERE tbkurupy.STATUTBKUR = 'A' AND tbkurupy.KDPSTTBKUR = '".$show["KDPSTMSMHS"]."'";
		$qry .=" GROUP BY tbkurupy.KDPSTTBKUR";
		$MySQL->Select("tbkurupy.IDX,tbkurupy.KDKURTBKUR,tbkurupy.NMKURTBKUR,tbkurupy.KDPSTTBKUR,MAX(tbkurupy.THAWLTBKUR) AS LAST_KUR","tbkurupy",$qry,"tbkurupy.KDPSTTBKUR ASC","");
		$i=0;
		$jml=$MySQL->num_rows();
		while ($show=$MySQL->Fetch_array()) {
		$id_kur[$i] = $show["IDX"];
		$kd_kur[$i] = $show["KDKURTBKUR"];
		$nm_kur[$i] = $show["NMKURTBKUR"];
		$ps_kur[$i] = $show["KDPSTTBKUR"];
		$lk_kur[$i] = $show["LAST_KUR"];
			$i++;
		}
		echo "<center>";
		for ($i=0;$i < $jml;$i++) {
?>
		    <div id="whatnewstoggler" class="fadecontenttoggler" style="width:99%">
			<a href="#" class="toc"><?php  echo LoadProdi_X("",$ps_kur[$i]); ?></a></div>
			<div id="whatsnew" class="fadecontentwrapper" style="width:99%; height: 2px;"></div>		
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
				<tr><td colspan="2">&nbsp;</td></tr>	
				<tr>
				    <td style="width:10%">Kode</td>
				    <td>: <?php echo $kd_kur[$i]; ?></td>
			    </tr>
				<tr>
				    <td style="width:10%">Kurikulum</td>
				    <td>: <?php echo $nm_kur[$i]; ?></td>
			    </tr>
				<tr>
				    <td style="width:10%">Tahun</td>
				    <td>: <?php echo substr($lk_kur[$i],0,4); ?></td>
			    </tr>
			</table><br>
<?php
			/******* Tampilkan daftar matakuliah ****************/
			echo "<table border='0' align='center' style='width:95%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr>
				<th style='width:20px;'>NO</th>
				<th style='width:75px;'>KODE</th>
				<th style='width:250px;'>MATAKULIAH</th>
				<th style='width:50px; tac'>SKS</th>
				<th style='width:30px; tac'>SEM</th>
				<th tac'>DOSEN</th>
				<th style='width:10px; tac'>ACT</th>
				</tr>";
			$MySQL->Select("tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NMDOSTBKMK","tbkmkupy","LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.IDKURTBKMK = '".$id_kur[$i]."'","tbkmkupy.SEMESTBKMK,tbkmkupy.KDKMKTBKMK","");
			$no=1;
			$sksTotal=0;
			if ($MySQL->num_rows() > 0) {
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tac'>".$no."</td>";
			     	echo "<td class='$sel'>".$show['KDKMKTBKMK']."</td>";
			     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
			     	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
			     	echo "<td class='$sel tac'>".$show['SEMESTBKMK']."</td>";
			     	echo "<td class='$sel'>".$show['NMDOSTBKMK']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=kurikulum&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$sksTotal += $show['SKSMKTBKMK'];
			     	$no++;
				}
				echo "<tr><td class='tar fwb' colspan='3'>SKS Total &nbsp;&nbsp;</td>";
				echo "<td class='tac fwb'>".$sksTotal." SKS</td><td colspan='4'>&nbsp;</td></tr>";			   } else {
				echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";	
			}
			echo "</table><br>";
		}
		echo "</center>";
	}
}
?>

