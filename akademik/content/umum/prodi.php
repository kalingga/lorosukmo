<?php
$idpage='11';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p'])) {
		$edtID=$_GET['id'];
		$MySQL->Select("*","mspstupy","where IDX='".$edtID."'","","1");
		$show=$MySQL->Fetch_Array();
		$edtKode=$show['IDPSTMSPST'];
		$cbProdi=$show['KDPSTMSPST'];
		$edtNama=$show['NMPSTMSPST'];
		$cbJenjang=$show['KDJENMSPST'];
		$cbFakultas=$show['KDFAKMSPST'];
		$edtTelp=$show['TELPOMSPST'];
		$edtFax=$show['FAKSIMSPST'];
		$edtEmail=$show['EMAILMSPST'];
		$edtBerdiri=$show['TGAWLMSPST'];
		$edtSKS=$show['SKSTTMSPST'];
		$edtKaProdi=$show['KAPSTMSPST'];
		$edtNIDN=$show['NOKPSMSPST'];
		$edtHP=$show['TELPSMSPST'];
		$edtOperator=$show['NMOPRMSPST'];
		$edtHP1=$show['TELPRMSPST'];
?>
		<center>
		<div class="fadecontenttoggler" style="width: 90%;">
		<a class="toc">DETAIL PROGRAM STUDI</a>
		</div>
		<div class="fadecontentwrapper" style="width: 90%; height: 10px;" ></div>
		<table style="width:90%" border="0" cellpadding="1" cellspacing="1">
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>	
		<tr><td width="35%">Kode Program Studi</td>
		  <td colspan="3">: <?php echo $edtKode; ?></td>
		</tr>	      
		<tr><td width="35%">Kode Dikti Program Studi</td>
		  <td colspan="3">: <?php echo $cbProdi; ?>			
		  </td>
		</tr>	      
		<tr>
		    <td>Program Studi</td>
		    <td colspan="3">: <?php echo $edtNama; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenjang &nbsp;&nbsp;:&nbsp;
		    <?php echo LoadKode_X("","$cbJenjang","04") ?></td>
	    </tr>
		<tr>
		    <td>Fakultas : </td>
		    <td colspan="3">: <?php echo LoadFakultas_X("","$cbFakultas") ?></td>
	    </tr>
		<tr>
		    <td>Telepon</td>
		    <td colspan="3">: <?php echo $edtTelp; ?></td>
	    </tr>
		<tr>
		    <td>Fax.</td>
		    <td colspan="3">: <?php echo $edtFax; ?></td>
	    </tr>
		<tr>
		    <td>Email</td>
			<td colspan="3">: <?php echo $edtEmail; ?></td>
	    </tr>
		<tr>
		    <td>Mulai Berdiri</td>
		    <td colspan="3">: <?php echo DateStr($edtBerdiri); ?></td>
	    </tr>
		<tr>
		    <td>Jumlah SKS Kelulusan </td>
		    <td colspan="3">: <?php echo $edtSKS; ?></td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr>
		    <td>Ka. Program Studi</td>
		    <td colspan="3">: <?php echo $edtKaProdi; ?></td>
		</tr>
		<tr>
		    <td>NIDN Ka. Program Studi</td>
		    <td colspan="3">: <?php echo $edtNIDN; ?></td>
		</tr>
		<tr>
		    <td>Telp./HP. Ka Program Studi</td>
		    <td colspan="3">: <?php echo $edtHP; ?></td>
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr>
		    <td>Operator</td>
		    <td colspan="3">: <?php echo $edtOperator; ?></td>
		</tr>
		<tr>
		    <td>Telp./HP. Operator</td>
		    <td colspan="3">: <?php echo $edtHP1; ?></td>
	  	</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
		<tr>
			<td colspan="4" align="center"><button type="button" onClick=window.location.href="./?page=prodi" /><img src="images/b_back.png" class="btn_img">&nbsp;Kembali</button>
			</td>
	    </tr>
		<tr><td colspan="4" align="center">&nbsp;</td></tr>
		</table>
<?php
		/********** Riwayat Status Akreditasi ********************/
		echo "<table border='0' style='width:90%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th colspan='4' style='background-color:#EEE'>RIWAYAT AKREDITASI</th></tr>";
		echo "<tr>
		     <th style='width:150px;'>Akreditasi</th> 
		     <th style='width:150px;'>Nomor SK.</th> 
		     <th style='width:150px;'>Tanggal SK.</th> 
		     <th style='width:150px;'>Berlaku s.d.</th> 
		     </tr>";
		$MySQL->Select("akpstupy.*,tbkodupy.NMKODTBKOD","akpstupy","LEFT OUTER JOIN tbkodupy ON akpstupy.KDSTAMSPST=tbkodupy.KDKODTBKOD where KDAPLTBKOD='07' AND IDPSTMSPST='".$edtID."'","TGLBAMSPST DESC","","0");
		if ($MySQL->Num_Rows() > 0){
			$no=1;
			while ($show=$MySQL->Fetch_Array()){
				$sel="";
				if ($no % 2 == 1) $sel="sel";     	
				echo "<tr>";
		     	echo "<td class='$sel tac'>".$show['NMKODTBKOD']."</td>";
		     	echo "<td class='$sel'>".$show['NOMBAMSPST']."</td>";
		     	echo "<td class='$sel tac'>".DateStr($show['TGLBAMSPST'])."</td>";
		     	echo "<td class='$sel tac'>".DateStr($show['TGLABMSPST'])."</td>";
		     	echo "</tr>";
		     	$no++;	     	
	     	}
		} else {
	 		echo "<td colspan='4' align='center' style='color:red;'>".$msg_data_empty."</td>";
		}
	    echo "</table>";
		
		/********** Riwayat SK Penetapan Program Studi ********************/
		echo "<br>";
		echo "<table border='0' style='width:90%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th colspan='3' style='background-color:#EEE'>RIWAYAT SK DIKTI</th></tr>";
		echo "<tr>
		     <th style='width:200px;'>No. SK.</th> 
		     <th style='width:200px;'>Tanggal SK.</th> 
		     <th style='width:200px;'>Berlaku s.d.</th> 
		     </tr>";
		$MySQL->Select("*","skpstupy","where IDPSTMSPST='".$edtID."'","TGLSKMSPST DESC","","0");
		if ($MySQL->Num_Rows() > 0){
			$no=1;
			while ($show=$MySQL->Fetch_Array()){
				$sel="";
				if ($no % 2 == 1) $sel="sel";     	
				echo "<tr>";
		     	echo "<td class='$sel'>".$show['NOMSKMSPST']."</td>";
		     	echo "<td class='$sel tac'>".DateStr($show['TGLSKMSPST'])."</td>";
		     	echo "<td class='$sel tac'>".DateStr($show['TGLAKMSPST'])."</td>";
		     	echo "</tr>";
		     	$no++;
			}
		} else {
	 		echo "<td colspan='3' align='center' style='color:red;'>".$msg_data_empty."</td>";
		}
	    echo "</table><br>";
?>
		</center>

<?php
	} else {
		$MySQL->Select("KDFAKMSFAK","msfakupy","WHERE STATUMSFAK='1'","KDFAKMSFAK ASC","");
		$i=0;
		$jml=$MySQL->num_rows();
		while ($show=$MySQL->fetch_array()) {
			$master[$i] = $show["KDFAKMSFAK"];
			$i++;
		}
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			/***** Default Tampilan **************/
		echo "<tr><th colspan='6' style='background-color:#EEE'>DAFTAR PROGRAM STUDI</th></tr>";
		echo "<tr>
				<th style='width:20px;'>KODE</th>
				<th>PROGRAM STUDI</th>
				<th style='width:5px;'>JENJANG</th>
				<th style='width:80px;'>TELP.</th>
				<th style='width:200px;'>EMAIL</th>
				<th colspan='2' style='width:20px;'>ACT</th></tr>";
	
		for ($i=0;$i < $jml;$i++) {
			echo "<tr><td colspan='6' class='fwb' style='background-color:#EEE'>FAKULTAS : ".LoadFakultas_X("",$master[$i])."</td></tr>";
			$MySQL->Select("mspstupy.IDX,mspstupy.IDPSTMSPST,mspstupy.NMPSTMSPST,mspstupy.NMJENMSPST,mspstupy.TELPOMSPST,mspstupy.EMAILMSPST",
			"mspstupy",
			"WHERE mspstupy.KDFAKMSPST ='".$master[$i]."' AND STATUMSPST='A' 
			AND mspstupy.IDPSTMSPST NOT IN('47','48') ","IDPSTMSPST ASC","");
			if ($MySQL->Num_Rows() > 0){
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tac'>".$show['IDPSTMSPST']."</td>";
			     	echo "<td class='$sel'>".$show['NMPSTMSPST']."</td>";
			     	echo "<td class='$sel tac'>".$show['NMJENMSPST']."</td>";
			     	echo "<td class='$sel'>".$show['TELPOMSPST']."</td>";
			     	echo "<td class='$sel'>".$show['EMAILMSPST']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=prodi&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;
				}
			} else {
				echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";	
			}
		}
		echo "</table><br>";
	}
}
?>

