<?php
$idpage='35';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p'])) {
		$edtID=$_GET['id'];
		$MySQL->Select("jwlutsuas.KDKMKUTSUAS,jwlutsuas.KELASUTSUAS,jwlutsuas.NODOSUTSUAS,jwlutsuas.JENISUTSUAS,jwlutsuas.RUANGUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS","jwlutsuas","where jwlutsuas.IDX='".$edtID."'","","1");
		$show=$MySQL->fetch_array();
		$cbMatakuliah=$show["KDKMKUTSUAS"];
		$edtKelas=$show["KELASUTSUAS"];
		$cbDosen=$show["NODOSUTSUAS"];
		$cbJenis=$show["JENISUTSUAS"];
		$edtRuang=$show["RUANGUTSUAS"];
		$cbHari=$show["HRPELUTSUAS"];
		$edtTglAwl1=DateStr($show["TGPELUTSUAS"]);
		$edtWaktu=$show["WKPELUTSUAS"];
		$edtDurasi=$show["DURSIUTSUAS"];
		$cbPengawas1=$show["PENG1UTSUAS"];
		$cbPengawas2=$show["PENG2UTSUAS"];
		$cbPengawas3=$show["PENG3UTSUAS"];
		$cbPengawas4=$show["PENG4UTSUAS"];
		$mulai = New Time($edtWaktu);
		$durasi = ($edtDurasi * 60);
		$selesai = $mulai->add($durasi);
?> 		
		<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
		<tr><th colspan="2">DETAIL JADWAL UJIAN MATAKULIAH</th></tr>
		<tr><th colspan="2">&nbsp;</th></tr>
		<tr><td>Matakuliah</td>
		 <td> : 
<?php 		
			echo LoadMatakuliah_X("","$cbMatakuliah");			
?>
		 </td>
		</tr>
		<tr>		
		 <td>Kelas</td>
		 <td>: 
<?php 		
			echo $edtKelas;			
?>
		 </td>
		</tr>		
		<tr>		
		 <td>Dosen Penguji</td>
		 <td>: <?php  echo LoadDosen_X("",$cbDosen); ?></td>
		</tr>		
		<tr>		
		 <td>Jenis Ujian</td>
		 <td>: 
<?php 
				echo $cbJenis;
?>
		</td>
		</tr>		
		<tr>
		 <td>Ruang</td>
		 <td>: 
<?php 
			echo $edtRuang; 
?>
		</td>
		</tr>
		<tr>
		 <td>Hari</td>
		 <td>: 
<?php  
			echo $cbHari 
?>
		 </td>
		</tr>
	  	<tr>
	    	<td>Tanggal Pelaksanaan</td>
	    	<td>: 
<?php 
			echo $edtTglAwl1; 
?>
			</td>
		</tr>
		<tr>
		 <td>Waktu</td>
		 <td>: 
<?php 
			echo substr($edtWaktu,0,5)." s.d. ".substr($selesai,0,5); 
?>
		</td>
		</tr>
		<tr>
		 <td>Pengawas I</td>
		 <td>: 
<?php
			echo LoadPegawai_X("",$cbPengawas1); 
?>
		 </td>
		</tr>
		<tr>
		 <td>Pengawas II</td>
		 <td>: 
<?php  
			echo LoadPegawai_X("",$cbPengawas2); 
?>
		</td>
		</tr>
		<tr>
		 <td>Pengawas III</td>
		 <td>: 
<?php  
			echo LoadPegawai_X("",$cbPengawas3); 
?>
		 </td>
		</tr>
		<tr>
		 <td>Pengawas IV</td>
		 <td>: 
<?php  
			echo LoadPegawai_X("",$cbPengawas4); 
?>
		 </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		 <td colspan="2" align="center">
		 <button type="reset"  onClick=window.location.href="./?page=jadwalutsuas" ><img src="images/b_back.png" class="btn_img"/>&nbsp;Kembali</button>
		 </td>
		</tr>
		</table>
		<br>
<?php
	} else {	
		echo "<form action='./?page=jadwalutsuas' method='post' >";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Jadwal Ujian TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		if ($level_user != '2') {
			echo "&nbsp;<b>@</b>&nbsp;";
			if ($level_user=='1') {
				LoadProdi_X("cbProdi","",$akses_user);
			} else {
				LoadProdi_X("cbProdi","");
			}
		}
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form>";	
			 	
		echo "<table align='center' border='0' align='center' style='width:95%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
		for ($i=0; $i < $jml_master;$i++) {
			echo "<tr><td colspan='8' class='fwb'>PROGRAM STUDI : ".$nm_pst[$i]."</td></tr>";
			echo "<tr>
				<th style='width:50px;'>KODE MK</th>
				<th>MATAKULIAH</th>
				<th style='width:50px;'>KELAS</th>
				<th style='width:30px;'>JENIS UJIAN</th> 
				<th style='width:100px;'>HARI/TANGGAL</th> 
				<th style='width:100px;'>WAKTU</th> 
				<th style='width:100px;'>RUANG</th> 
				<th style='width:20px;'>ACT</th> 
				</tr>";	
			$qry ="LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) ";
			$qry .="where jwlutsuas.THSMSUTSUAS='".$ThnSemester."' ";
			$qry .="AND jwlutsuas.KDPSTUTSUAS = '".$id_pst[$i]."'";
			$MySQL->Select("jwlutsuas.IDX,jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.KELASUTSUAS,jwlutsuas.JENISUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.RUANGUTSUAS,jwlutsuas.NODOSUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS","jwlutsuas",$qry,"jwlutsuas.KDKMKUTSUAS ASC,jwlutsuas.KELASUTSUAS ASC","");
			if ($MySQL->num_rows() > 0) {
				$no=1;
			 	while ($show=$MySQL->fetch_array()) {
					$sel1="sel";
					$durasi=($show['DURSIUTSUAS']*60);
					$mulai= New Time($show['WKPELUTSUAS']);
					$selesai=$mulai->add($durasi);
					if ($no % 2 == 1) $sel1="";
					echo "<td class='$sel1'>".$show["KDKMKUTSUAS"]."</td>";
					echo "<td class='$sel1'>".$show["NAMKTBLMK"]."</td>";
					echo "<td class='$sel1 tac'>".$show["KELASUTSUAS"]."</td>";
					echo "<td class='$sel1 tac'>".$show["JENISUTSUAS"]."</td>";
					if ($show["HRPELUTSUAS"] == "" || $show["HRPELUTSUAS"]=='-1') {
						echo "<td class='$sel1'>".DateStr($show["TGPELUTSUAS"])."</td>";
						
					} else {
					echo "<td class='$sel1'>".$show["HRPELUTSUAS"]."/".DateStr($show["TGPELUTSUAS"])."</td>";
					}
					echo "<td class='$sel1'>".substr($show['WKPELUTSUAS'],0,5)." - ".substr($selesai,0,5)."</td>";
					echo "<td class='$sel1 tac'>".$show["RUANGUTSUAS"]."</td>";
					echo "<td class='$sel1 tac'><a href='./?page=jadwalutsuas&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></td></tr>";
					$no++;
				}
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='8'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td colspan='8'>&nbsp;</td></tr>";
		}
		echo "</table>";
	}
}
?>