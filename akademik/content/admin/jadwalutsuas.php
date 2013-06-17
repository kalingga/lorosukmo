<?php
$idpage='35';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit'])) {
		$succ=0;
		if ($_POST['submit']=='simpan') {
			$cbJenis=substr(strip_tags($_POST['cbJenis']),0,3);
	  		$id_mk_arr=$_POST['id_mk_arr']; 
	  		$succ=array();
	  		$fail=array();
	  
	  		if (count($id_mk_arr)>0){
	  			$i=0;
		  		foreach($id_mk_arr as $id_mk=>$value){
		  			$MySQL->Select("tbmksajiupy.THSMSMKSAJI,tbmksajiupy.KDPSTMKSAJI,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI","tbmksajiupy","where tbmksajiupy.IDX='".$id_mk."'");
		  			$show=$MySQL->fetch_array();
		  			$id[$i]=$id_mk;
		  			$thn[$i]=$show['THSMSMKSAJI'];
		  			$prodi[$i]=$show['KDPSTMKSAJI'];
		  			$mk[$i]=$show['KDKMKMKSAJI'];
		  			$kls[$i]=$show['KELASMKSAJI'];
		  			$dsn[$i]=$show['NODOSMKSAJI'];
					$i++;	
		  		}
		  		for ($j=0; $j < $i; $j++){
					$MySQL->Insert("jwlutsuas","IDXMKSAJI,THSMSUTSUAS,KDPSTUTSUAS,KDKMKUTSUAS,KELASUTSUAS,JENISUTSUAS,NODOSUTSUAS","'$id[$j]','$thn[$j]','$prodi[$j]','$mk[$j]','$kls[$j]','$cbJenis','$dsn[$j]'");
					if ($MySQL->exe) $succ[]=$mk[$j]; else $fail[]=$mk[$j];
				}
	  		}   
	  		if (count($succ)>0){
	    		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
	    		echo "Transfer Data Matakuliah<br>".implode(',',$succ)."<br>Sukses!";
	    		echo "</div>";
	  		}
	  		if (count($fail)>0){
	    		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
	    		echo "Transfer Data Matakuliah<br>".implode(',',$fail)."<br>Gagal! / Data Sudah Di proses";
	    		echo "</div>";
	  		}



/*			$matakuliah=strip_tags($_POST['cbMatakuliah']);
			$matakuliah=@explode(",",$matakuliah);
			$cbProdi=$matakuliah[0];
			$cbIdMKSaji=$matakuliah[1];
			$cbMatakuliah=$matakuliah[2];
			$edtKelas=$matakuliah[3];
			$MySQL->Insert("jwlutsuas","IDXMKSAJI,THSMSUTSUAS,KDPSTUTSUAS,KDKMKUTSUAS,KELASUTSUAS,RUANGUTSUAS,HRPELUTSUAS,TGPELUTSUAS,WKPELUTSUAS,DURSIUTSUAS,JENISUTSUAS,NODOSUTSUAS,PENG1UTSUAS,PENG2UTSUAS,PENG3UTSUAS,PENG4UTSUAS","'$cbIdMKSaji','$ThnSemester','$cbProdi','$cbMatakuliah','$edtKelas','$edtRuang','$cbHari','$edtTglAwl1','$edtWaktu','$edtDurasi','$cbJenis','$cbDosen','$cbPengawas1','$cbPengawas2','$cbPengawas3','$cbPengawas4'");
			$act_log="Tambah Data Pada Tabel 'jwlutsuas' File 'jadwalutsuas.php' ";
			$msg=$msg_insert_data;*/
			
		} else {
			$edtID=$_POST['edtID'];
			$cbDosen=substr(strip_tags($_POST['cbDosen']),0,10);
			$cbJenis=substr(strip_tags($_POST['cbJenis']),0,3);
			$edtRuang=substr(strip_tags($_POST['edtRuang']),0,10);
			$cbHari=substr(strip_tags($_POST['cbHari']),0,6);
			$edtTglAwl1=substr(strip_tags($_POST['edtTglAwl1']),0,10);
			$edtTglAwl1=@explode("-",$edtTglAwl1);
			$edtTglAwl1=$edtTglAwl1[2]."-".$edtTglAwl1[1]."-".$edtTglAwl1[0];
			$edtWaktu=substr(strip_tags($_POST['edtWaktu']),0,5);
			$edtDurasi=substr(strip_tags($_POST['edtDurasi']),0,3);
			$cbPengawas1=substr(strip_tags($_POST['cbPengawas1']),0,10);
			$cbPengawas2=substr(strip_tags($_POST['cbPengawas2']),0,10);
			$cbPengawas3=substr(strip_tags($_POST['cbPengawas3']),0,10);
			$cbPengawas4=substr(strip_tags($_POST['cbPengawas4']),0,10);			
			$MySQL->Update("jwlutsuas","RUANGUTSUAS='$edtRuang',HRPELUTSUAS='$cbHari',TGPELUTSUAS='$edtTglAwl1',WKPELUTSUAS='$edtWaktu',DURSIUTSUAS='$edtDurasi',JENISUTSUAS='$cbJenis',NODOSUTSUAS='$cbDosen',PENG1UTSUAS='$cbPengawas1',PENG2UTSUAS='$cbPengawas2',PENG3UTSUAS='$cbPengawas3',PENG4UTSUAS='$cbPengawas4'","where IDX='".$edtID."'","1");
			$act_log="Update ID='$edtID' Pada Tabel 'jwlutsuas' File 'jadwalutsuas.php' ";
			$msg=$msg_edit_data;
		}

		if ($MySQL->exe){
			$succ=1;
		}
		
		if ($succ==1) {
			echo $msg;
			$act_log .="Sukses!";			
		} else {
			echo $msg_update_0;
			$act_log .="Gagal!";			
		}
		AddLog($id_admin,$act_log);		
	}	

	if (isset($_GET['p']) && ($_GET['p']=='delete')) {
		$id=$_GET['id']; 
		$MySQL->Delete("jwlutsuas","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'jwlutsuas' File 'jadwalutsuas.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'jwlutsuas' File 'jadwalutsuas.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}				

	if ((isset($_GET['p']) && ($_GET['p']!='delete')) || isset($_POST['p'])) {
		if ($_GET['p']=='edit') {
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
 ?> 		
			<form name="form1" action="./?page=jadwalutsuas" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<input type="hidden" name="edtID" size="11" maxlength="11" value="<?php echo $edtID; ?>" />
			<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan="2">FORM EDIT DATA JADWAL UJIAN</th></tr>
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
			 <td>: <?php  LoadDosen_X("cbDosen",$cbDosen); ?></td>
			</tr>		
			<tr>		
			 <td>Jenis Ujian</td>
			 <td>: 
<?php 
					$sel0="selected='selected'";
		    		if ($cbJenis=="UTS") $sel1="selected='selected'";
		    		if ($cbJenis=="UAS") $sel2="selected='selected'";
	    			echo "<select name='cbJenis' id='cbJenis' >";
		        	echo "<option value='-1' $sel0>--- Jenis Ujian ---</option>";
	            	echo "<option value='UTS' $sel1>UTS</option>";
	            	echo "<option value='UAS' $sel2>UAS</option>";
		        	echo "</select>";
?>
			</td>
			</tr>		
			<tr>
			 <td>Ruang</td>
			 <td>: <input type="text" name="edtRuang" size="10" maxlength="10" value="<?php echo $edtRuang; ?>" /></td>
			</tr>
			<tr>
			 <td>Hari</td>
			 <td>: <?php  LoadHari_X("cbHari",$cbHari); ?></td>
			</tr>
		  	<tr>
		    	<td>Tanggal Pelaksanaan</td>
		    	<td>: 
				<input type="text" name="edtTglAwl1" size="10"  maxlength="10" value="<?php echo $edtTglAwl1; ?>" /> 
		<a href="javascript:show_calendar('document.form1.edtTglAwl1','document.form1.edtTglAwl1',document.form1.edtTglAwl1.value);">
		<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
				</td>
			</tr>
			<tr>
			 <td>Waktu</td>
			 <td>: <input type="text" name="edtWaktu" size="5"  maxlength="5" value="<?php echo $edtWaktu; ?>" /> [hh:mm]</td>
			</tr>
			<tr>
			 <td>Durasi</td>
			 <td>: <input type="text" name="edtDurasi" size="3"  maxlength="3" value="<?php echo $edtDurasi; ?>" /> dalam menit</td>
			</tr>
			<tr>
			 <td>Pengawas I</td>
			 <td>: <?php  LoadPegawai_X("cbPengawas1",$cbPengawas1); ?></td>
			</tr>
			<tr>
			 <td>Pengawas II</td>
			 <td>: <?php  LoadPegawai_X("cbPengawas2",$cbPengawas2); ?></td>
			</tr>
			<tr>
			 <td>Pengawas III</td>
			 <td>: <?php  LoadPegawai_X("cbPengawas3",$cbPengawas3); ?></td>
			</tr>
			<tr>
			 <td>Pengawas IV</td>
			 <td>: <?php  LoadPegawai_X("cbPengawas4",$cbPengawas4); ?></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			 <td colspan="2" align="center">
			 <button type="reset"  onClick=window.location.href="./?page=jadwalutsuas" ><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
			 <button type="submit" name="submit" value="update" /><img src="images/b_save.gif" class="btn_img">&nbsp;Update</button>
			 </td>
			</tr>
			</table>
			</form>
			<br>
<?php
		} elseif ($_GET['p']=='add') {
?>
			<form name="form1" action="./?page=jadwalutsuas" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan="2">FORM TAMBAH DATA JADWAL UJIAN</th></tr>
			<tr><th colspan="2">&nbsp;</th></tr>
			<tr><td colspan="2">Klik Tombol Proses Untuk Mengambil Matakuliah Saji</td></tr>
			<tr><td>Program Studi</td>
			 <td> : 
<?php 
			LoadProdi_X("cbProdi","","","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Program Studi yang Ada!'");			
?>
			 </td>
			</tr>
			<tr>		
			 <td>Jenis Ujian</td>
			 <td>: 
<?php 
	    			echo "<select name='cbJenis' id='cbJenis' required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Jenis Ujian yang Ada!'>";
		        	echo "<option value='-1'>--- Jenis Ujian ---</option>";
	            	echo "<option value='UTS'>UTS</option>";
	            	echo "<option value='UAS'>UAS</option>";
		        	echo "</select>";
?>
			</td>
			</tr>		
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			 <td colspan="2" align="center">
			 <button type="reset"  onClick=window.location.href="./?page=jadwalutsuas" ><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
			 <button type="submit" name="p" value="submit" /><img src="images/b_go.png" class="btn_img">&nbsp;Submit</button>
			 </td>
			</tr>
			</table>
			</form>
			<br>
<?php			
		} else {
?>
			<center>
			<div class="fadecontenttoggler" style="width: 100%;">
			<a class="toc">DETAIL MATAKULIAH SAJI</a>
			</div>
			<div class="fadecontentwrapper" style="width: 100%; height: 5px;" ></div>
<?php
			//Tampilkan daftar matakuliah saji
			$cbProdi=substr(strip_tags($_POST['cbProdi']),0,2);
			$cbJenis=substr(strip_tags($_POST['cbJenis']),0,3);
			echo "<form name='form1' action='./?page=jadwalutsuas' method='post' >";
			echo "<table border='0' style='width:95%; margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
			echo "<input type='hidden' size='3' maxlength='3' name='cbJenis' value='$cbJenis'>";
			$qry ="LEFT JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK)";
			$qry .=" WHERE tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."' AND tbmksajiupy.KDPSTMKSAJI='".$cbProdi."'";
			$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI","tbmksajiupy",$qry,"tbmksajiupy.KDPSTMKSAJI ASC,tbmksajiupy.KDKMKMKSAJI ASC","","0");
//echo $MySQL->qry;			
$row=$MySQL->Num_Rows();
			if ($row > 0) {
				$i=0;
				while ($show=$MySQL->Fetch_Array()){
					$data[$i][0]=$show['KDKMKMKSAJI'];
					$data[$i][1]=$show['NAMKTBLMK'];
					$data[$i][2]=$show['SKSMKMKSAJI'];
					$data[$i][3]=$show['SEMESMKSAJI'];
					$i++;	
				}
				echo "<table border='0' style='width:100%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
				echo "<tr>
					<th style='width:20px;'>NO</th> 
					<th style='width:40px;'>KODE MK</th> 
					<th style='width:175px;'>MATAKULIAH</th> 
					<th style='width:20px;'>SKS</th> 
					<th style='width:20px;'>SEM</th>
					<th colspan='2'>DETAIL MATAKULIAH</th>
					</tr>";
				$no=1;
				for ($i=0;$i < $row; $i++){
			    	echo "<tr>";
					$sel="";
					if ($no % 2 == 1) $sel="sel"; 
		     		echo "<td class='$sel tar'>".$no."&nbsp;</td>";
		     		echo "<td class='$sel'>".$data[$i][0]."</td>";
			    	echo "<td class='$sel'>".$data[$i][1]."</td>";
			    	echo "<td class='$sel tac'>".$data[$i][2]."</td>";
			    	echo "<td class='$sel tac'>".$data[$i][3]."</td>";
			     	echo "<td class='$sel' colspan='2'>";
					//********** Tabel Detail
			     	$MySQL->Select("tbmksajiupy.IDX,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI,tbmksajiupy.RUANGMKSAJI,
             tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.SMPAIMKSAJI, ruangNama","tbmksajiupy",
				"LEFT JOIN ruang_kuliah ON ruangId = tbmksajiupy.RUANGMKSAJI 
        WHERE tbmksajiupy.KDKMKMKSAJI = '".$data[$i][0]."' AND tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."' AND HRPELMKSAJI IS NOT NULL" ,"tbmksajiupy.KELASMKSAJI ASC","");
			     	//echo $MySQL->qry;
				echo "<table border='0' style='width:100%;' cellpadding='2' cellspacing='1' class='tblbrdr' >";
			     	$no1=0;
				    echo "<tr>";
			   		echo "<th style='width:40px;'>KLS</th> 
			   			<th style='width:200px;'>JADWAL</th> 
						<th style='width:200px;'>DOSEN PENGAMPU</th>
			   			<th style='width:20px;'>ACT</th>";
				    echo "</tr>";	
					while ($detail=$MySQL->fetch_array()){
						$sel1="sel";
						$durasi=($detail['DURSIMKSAJI']*60);
						$mulai= New Time($detail['MULAIMKSAJI']);
						$selesai=$mulai->add($durasi);
						if ($no1 % 2 == 1) $sel1="";
				     	echo "<tr><td class='$sel1 tac'>".$detail['KELASMKSAJI']."</td>";
				    	echo "<td class='$sel1' style='width:20px;'>".$detail['HRPELMKSAJI']." ";
				    	echo "".substr($detail['MULAIMKSAJI'],0,5)." - ".substr($detail['SMPAIMKSAJI'],0,5).", ";
				     	echo "".$detail['ruangNama']."</td>";
				    	echo "<td class='$sel1' style='width:250px;'>".$detail['NMDOSMKSAJI']." - ".$detail['NODOSMKSAJI']."</td>";			    	
				     	echo "<td class='tac $sel1'>";
						echo "<input type='checkbox' class='cbx' name='id_mk_arr[".$detail['IDX']."]' />";
			 			echo "</td></tr>";
						$no1++;	
					}
			     	echo "</table>";
			     	echo "</td></tr>";
			        $no++;
			    }
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td class='tar' colspan='7'><input type='checkbox' class='cbx' onclick='flipflop(this.form,this)' /> Check/UnCheck All
			&nbsp;&nbsp;<button type='submit' name='submit' value='simpan' />Proses&nbsp;<img src='images/b_go.png' class='btn_img'></button></td></tr>";		
			echo "</table><br>";
			echo "</form>";
			echo "<button type='button' onClick=window.location.href='./?page=jadwalutsuas&amp;p=add' /><img src='images/b_back.png' class='btn_img'>&nbsp;Kembali</button></center><br>";
		}	
	} else {	
		echo "<form action='./?page=jadwalutsuas' method='post' >";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Jadwal Ujian TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		echo "&nbsp;<b>@</b>&nbsp;";
		LoadProdi_X("cbProdi","");
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form>";	
			 	
		echo "<table align='center' border='0' align='center' style='width:95%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
			echo "<tr><td colspan='9'><button type=\"button\" onClick=window.location.href='./?page=jadwalutsuas&amp;p=add' ><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
		for ($i=0; $i < $jml_master;$i++) {
			echo "<tr><td colspan='9' class='fwb'>PROGRAM STUDI : ".$nm_pst[$i]."</td></tr>";
			echo "<tr>
				<th style='width:50px;'>KODE MK</th>
				<th>MATAKULIAH</th>
				<th style='width:50px;'>KELAS</th>
				<th style='width:30px;'>JENIS UJIAN</th> 
				<th style='width:100px;'>HARI/TANGGAL</th> 
				<th style='width:100px;'>WAKTU</th> 
				<th style='width:100px;'>RUANG</th> 
				<th colspan='2' style='width:40px;'>ACT</th> 
				</tr>";	
			$qry ="LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) ";
			$qry .="LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
    	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
    	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId ";
			$qry .="where jwlutsuas.THSMSUTSUAS='".$ThnSemester."' ";
			$qry .="AND jwlutsuas.KDPSTUTSUAS = '".$id_pst[$i]."'";
			$MySQL->Select("jwlutsuas.IDX,jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.KELASUTSUAS,jwlutsuas.JENISUTSUAS,jwlutsuas.HRPELUTSUAS,
            jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3,jwlutsuas.NODOSUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS",
            "jwlutsuas",$qry,"jwlutsuas.JENISUTSUAS ASC,jwlutsuas.KDKMKUTSUAS ASC,jwlutsuas.KELASUTSUAS ASC","");
//echo "<input type=hidden value=".$MySQL->qry." >";
//echo $MySQL->qry;			
if ($MySQL->num_rows() > 0) {
				$no=1;
			 	while ($show=$MySQL->fetch_array()) {
			 	  $ruangUjian = $show["R1"];
			 	  if($show["R2"] <> ""){
             $ruangUjian .= "/".$show["R2"];
          }
          
          if($show["R3"] <> ""){
             $ruangUjian .= "/".$show["R3"];
          
          }
			 	  
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
					echo "<td class='$sel1 tac'>".$ruangUjian."</td>";
					echo "<td class='$sel1 tac'><a class='fancy' href='./jadwal/schujian/form/".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></td>";
					echo "<td class='$sel1 tac'><a href='./?page=jadwalutsuas&amp;p=delete&amp;id=".$show['IDX']."'><img border='0' src='images/b_drop.png' title='HAPUS DATA' /></td></tr>";
					$no++;
				}
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='9'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td colspan='9'>&nbsp;</td></tr>";
		}
		echo "</table>";
	}
}
?>