<?php
$idpage='34';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p']) && ($_GET['p']=='delete')) {
		$id=$_GET['id'];
		// cek apa udah diambil mhs atau belum - $ThnSemester, $id
		if(cekAmbil($ThnSemester, $id)){
         echo $msg_delete_data_jadwal;
    }else{
        $MySQL->Delete("tbmksajiupy","where IDX=".$id,"1");
    	  if ($MySQL->exe){
    			$act_log="Hapus ID='$id' Pada Tabel 'tbmksajiupy' File 'jadwalmk.php' Sukses!";
    			AddLog($id_admin,$act_log);
    		    echo $msg_delete_data;
    		} else {
    			$act_log="Hapus ID='$id' Pada Tabel 'tbmksajiupy' File 'jadwalmk.php' Gagal!";
    			AddLog($id_admin,$act_log);
    		    echo $msg_delete_data_0;
    		}
    }
				
	}
	if (isset($_POST['submit'])){
		$succ=0;
		$cbMatakuliah=strip_tags($_POST['cbMatakuliah']);
		$cbMatakuliah=@explode(",",$cbMatakuliah);
		$thn=$cbMatakuliah[0];
		$prodi=$cbMatakuliah[1];
		$id_mk=$cbMatakuliah[2];
		$kd_mk=$cbMatakuliah[3];
		$sks=$cbMatakuliah[4];
		$semes=$cbMatakuliah[5];
		$simpan=substr(strip_tags($_POST['simpan']),0,6);
		$cbDosen=substr(strip_tags($_POST['cbDosen']),0,15);
		$edtKelas=substr(strip_tags($_POST['edtKelas']),0,2);
		$edtRuang=substr(strip_tags($_POST['edtRuang']),0,10);
		$cbHari= substr(strip_tags($_POST['cbHari']),0,6);
		$edtJam=substr(strip_tags($_POST['edtJam']),0,5);
		$edtDurasi=substr(strip_tags($_POST['edtDurasi']),0,3);
		$NamaDosen=LoadDosen_X("",$cbDosen);

		if ($simpan=="Simpan"){
//			$MySQL->Insert("tbmksajiupy","IMKSJJWLMK,KELASJWLMK,NODOSJWLMK,NMDOSJWLMK,RUANGJWLMK,HRPELJWLMK,MULAIJWLMK,DURSIJWLMK","'$cbMatakuliah',UPPER('$edtKelas'),'$cbDosen','$NamaDosen',UPPER('$edtRuang'),'$cbHari','$edtJam','$edtDurasi'");
			$MySQL->Insert("tbmksajiupy","THSMSMKSAJI,KDPSTMKSAJI,IDKMKMKSAJI,KDKMKMKSAJI,SKSMKMKSAJI,SEMESMKSAJI,KELASMKSAJI,NODOSMKSAJI,NMDOSMKSAJI,RUANGMKSAJI,HRPELMKSAJI,MULAIMKSAJI,DURSIMKSAJI","'$thn','$prodi','$id_mk','$kd_mk','$sks','$semes',UPPER('$edtKelas'),'$cbDosen','$NamaDosen',UPPER('$edtRuang'),'$cbHari','$edtJam','$edtDurasi'");
			$msg=$msg_insert_data;
			$act_log="Tambah Data Pada Tabel 'tbmksajiupy' File 'jadwalmk.php' ";
		} else {
			$edtID=$_POST['edtID'];
			$MySQL->Update("tbmksajiupy","KELASMKSAJI=UPPER('$edtKelas'),NODOSMKSAJI='$cbDosen',NMDOSMKSAJI='$NamaDosen',RUANGMKSAJI=UPPER('$edtRuang'),HRPELMKSAJI='$cbHari',MULAIMKSAJI='$edtJam',DURSIMKSAJI='$edtDurasi'","where IDX=".$edtID,"1");
			$msg=$msg_edit_data;
			$act_log="Update ID='".$edtID."' Pada Tabel 'tbmksajiupy' File 'jadwalmk.php' ";
		}
	  	if ($MySQL->exe){
			$succ=1;
		}
	  	if ($succ==1){
			$act_log .="Sukses!";
			AddLog($id_admin,$act_log);
			echo $msg;
	  	} else{
			$act_log .="Gagal";
			AddLog($id_admin,$act_log);
			echo $msg_update_0;
		}
	}


	if (isset($_GET['p']) && (($_GET['p']=='add')||($_GET['p']=='editx'))) {
		$pst=$_GET['pst'];
		$title="Tambah";
		$submited="Simpan";
		//$kurikulum=$kurikulum[0];
		if ($_GET['p']=='edit'){
			$edtID=$_GET['id'];
			$MySQL->Select("tbmksajiupy.THSMSMKSAJI,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.RUANGMKSAJI,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI","tbmksajiupy","WHERE tbmksajiupy.IDX = '".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$thn=$show['THSMSMKSAJI'];
			$cbDosen=$show['NODOSMKSAJI'];
			$edtKelas=$show['KELASMKSAJI'];
			$edtRuang=$show['RUANGMKSAJI'];
			$cbHari=$show['HRPELMKSAJI'];
			$edtJam=$show['MULAIMKSAJI'];
			$edtDurasi=$show['DURSIMKSAJI'];
			$title="Edit";
			$submited="Update";
		}
?>
		<form name="form1" action="./?page=jadwalmk" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>"/>
		<input type="hidden" name="simpan" value="<?php echo $submited; ?>"/>
		<tr><th colspan="2"><?php echo $title; ?> DATA JADWAL PERKULIAHAN</th></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		 <td style="width:150px;" >Matakuliah</td>
		 <td>: 
<?php
		 if ($_GET['p']=='add') {
			LoadMKSaji("cbMatakuliah","$cbMatakuliah",$ThnSemester,$pst);
		 } else {
			echo LoadMKSaji("","$edtID","","");			
		 }
?>
		</td>
		</tr>
		<tr>
		 <td>Dosen Pengampu</td>
		 <td class="mandatory">: <?php LoadDosen_X("cbDosen","$cbDosen","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Dosen yang Ada!'"); ?>
		</tr>
		<tr>
		 <td>Kelas Matakuliah</td>
		 <td class="mandatory">: <input type="text" name="edtKelas" id="edtKelas" size="6" maxlength="6" value="<?php echo $edtKelas; ?>" required='1' realname='Kelas Matakuliah' /></td>
</td>
		</tr>
		
    <tr>
		 <td>Ruang</td>
		 <td>: <input type="text" name="edtRuang" id="edtRuang" size="10" maxlength="10" value="<?php echo $edtRuang; ?>" required='1' realname='Ruang' /></td>
</td>
		</tr>
		<tr><td colspan="2">Jadwal Tatap Muka</td></tr>
		<tr>
		 <td>Hari</td>
		 <td>: <?php LoadHari_X("cbHari","$cbHari",""); ?></td>
</td>
		</tr>
		<tr>
		 <td>Jam</td>
		 <td>: <input type="text" name="edtJam" id="edtJam" size="5" maxlength="5" value="<?php echo $edtJam; ?>" required='1' realname='Jam Pelaksanaan' />&nbsp;[hh:mm]</td>
		</tr>
		
		<tr>
		 <td>Durasi</td>
		 <td>: <input type="text" name="edtDurasi" id="edtDurasi" size="3" maxlength="3" value="<?php echo $edtDurasi; ?>" required='1' realname='Durasi Waktu' />&nbsp;dalam Menit</td>
		</tr>		
		<tr>
		 <td colspan="2" align="center">
		 <button type="reset" onClick=window.location.href="./?page=jadwalmk" /><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
		<button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited ?></button>
		 </td>
		</tr>
		</table>
		</form>
<?php	
	} else {	
		echo "<form action='./?page=jadwalmk' method='post' >";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Jadwal Matakuliah TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		if ($level_user != '2') {
			echo "&nbsp;@&nbsp;";
			if ($level_user == '1') {
				LoadProdi_X("cbProdi","",$akses_user);
			} else {
				LoadProdi_X("cbProdi","");
			}
		}
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>
			&nbsp;<button type=\"button\" onClick=window.location.href='./?page=jadwalmk'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;</th>";
		echo "</tr></table></form>";		
		
		/*** Tampilan Default Jadwal matakuliah semester berjalan, 
		**** per fakultas yang merupakan hak user, pada semester berjalan/semester 
		**** paling akhir yang ada pada data base ******/
		
		echo "<table border='0' align='center' style='width:99%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
	
    echo "<tr><th colspan='6' style='background-color:#EEE'>JADWAL PERKULIAHAN TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." SEM. ".LoadSemester_X("",substr($ThnSemester,4,1))."</th></tr>";
		for ($i=0;$i < $jml_master;$i++) {
			echo "<tr><td colspan='6' style='padding-top:5px; padding-bottom:5px;'><a href=\"jadwal/main/form/".md5('blanc'.$id_pst[$i])."\" class='fancy blanc' style='color:#333; font-weight:bold; padding:3px; border: solid #999 1px;'>Tambah Kelas Baru</a>
      <a href=\"jadwal/ruang\" class='fancy2 blanc' style=' color:#333; font-weight:bold; padding:3px; border: solid #999 1px;'>Daftar Ruang</a></td></tr>";
      //echo "<tr><td colspan='6'><button type=\"button\" onClick=window.location.href='jadwal' ><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Jadwal Kuliah</button></td></tr>";
			echo "<tr><th align='left' colspan='6'>PROGRAM STUDI : ".$nm_pst[$i]."</th></tr>"; //./?page=jadwalmk&amp;p=add&amp;pst=$id_pst[$i]
			$qry ="LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) ";
			$qry .="WHERE tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."' AND tbmksajiupy.KDPSTMKSAJI ='".$id_pst[$i]."'";	
			$qry .= "AND SEMESMKSAJI <> ''";
     
			$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI","tbmksajiupy",
      $qry,"tbmksajiupy.KDPSTMKSAJI ASC,tbmksajiupy.KDKMKMKSAJI ASC","","0");
			$row[$i]=$MySQL->Num_Rows();
			if ($row[$i] > 0) {
//echo "PERIODE :".$ThnSemester;
				$j=0;
				while ($show=$MySQL->Fetch_Array()){
					$data[$j][1]=$show['KDKMKMKSAJI'];
					$data[$j][2]=$show['NAMKTBLMK'];
					$data[$j][3]=$show['SKSMKMKSAJI'];
					$data[$j][4]=$show['SEMESMKSAJI'];
					$j++;
				}
				echo "<tr>
				<th style='width:20px;'>NO</th> 
				<th style='width:50px;'>KODE MK</th> 
				<th style='width:250px;'>MATAKULIAH</th> 
				<th style='width:20px;'>SKS</th> 
				<th style='width:20px;'>SEM</th>
				<th>DETAIL MATAKULIAH</th>
				</tr>";
			
				$no=1;
				for ($j=0;$j < $row[$i]; $j++) {
			    	echo "<tr>";
					$sel="";
					if ($no % 2 == 1) $sel="sel"; 
			     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
			     	echo "<td class='$sel'>".$data[$j][1]."</td>";
			    	echo "<td class='$sel'>".$data[$j][2]."</td>";
			    	echo "<td class='$sel tac'>".$data[$j][3]."</td>";
			    	echo "<td class='$sel tac'>".$data[$j][4]."</td>";
			     	echo "<td class='$sel'>";
			     	$no++;
					
						/******** Tabel Detail ****************/
				     	$MySQL->Select("tbmksajiupy.IDX,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI,
               ruangNama,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,
               tbmksajiupy.DURSIMKSAJI,tbmksajiupy.SMPAIMKSAJI","tbmksajiupy","
               LEFT JOIN ruang_kuliah ON ruangId = tbmksajiupy.RUANGMKSAJI 
               WHERE tbmksajiupy.KDKMKMKSAJI = '".$data[$j][1]."' 
               AND tbmksajiupy.THSMSMKSAJI = '".$ThnSemester."'","tbmksajiupy.KELASMKSAJI ASC","");

					// cek jadwal masih kosong atau ga, kalo kosong, jangan ditampilkan
					$cekJadwal = null; 
         
					
				
				     	echo "<table border='0' style='width:100%;' cellpadding='2' cellspacing='1' class='tblbrdr' >";
			     	 	$no1=0;
					    echo "<tr>";
				   		echo "<th style='width:50px;'>KLS</th> 
				   			<th style='width:200px;'>JADWAL</th> 
							<th style='width:200px;'>DOSEN PENGAMPU</th>
				   			<th style='width:20px;' colspan='2'>ACT</th>";
					    echo "</tr>";	
  						while ($detail=$MySQL->fetch_array()){
  							$sel1="sel";
  							$durasi=($detail['DURSIMKSAJI']*60);
  							//$mulai= New Time($detail['MULAIMKSAJI']);
  							//$selesai=$mulai->add($durasi);
  							
  							if ($no1 % 2 == 1) $sel1="";
  							if($detail['HRPELMKSAJI'] <> null ){
    					    echo "<tr><td class='$sel1 tac'>".$detail['KELASMKSAJI']."</td>";
    					    echo "<td class='$sel1' style='width:20px;'>".$detail['HRPELMKSAJI']." ";
    					    echo "".substr($detail['MULAIMKSAJI'],0,5)." - ".substr($detail['SMPAIMKSAJI'],0,5).", ";
    					    echo "".$detail['ruangNama']."</td>";
    					    echo "<td class='$sel1' style='width:250px;'>".$detail['NMDOSMKSAJI']." - ".$detail['NODOSMKSAJI']."</td>";			    	
    					    //echo "<td class='tac $sel1'>";
    							//echo "<a href='./?page=jadwalmk&amp;p=edit&amp;id=".$detail['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
    				 			//echo "</td>";
    				 			echo "<td class='$sel1 tac'>";
    							echo "<a href='./?page=jadwalmk&amp;p=delete&amp;id=".$detail['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
    				    	echo "</td></tr>";
  				    	}else{
                  //echo "<tr><td colspan=4 align=center>  </td></tr>";
                }
  							$no1++;	
  						}
					echo "</table>";
					
					
					echo "</td></tr>";
				}
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td colspan='6'>&nbsp;</td></tr>";
		}
		echo "</table>";

	}
}

function cekAmbil($ThnSemester, $id){
   global $MySQL;
   $MySQL->Select("IDX","trnlmupy",
      "WHERE THSMSTRNLM = '".$ThnSemester."'
      AND IDXMKSAJI = '".$id."'");
			if($MySQL->Num_Rows() > 0){
          return true;
      }else{
          return false;
      }

}
?>