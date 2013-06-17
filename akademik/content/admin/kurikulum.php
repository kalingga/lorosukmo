<?php
$idpage='15';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if ((isset($_GET['p']) && $_GET['p']=='del')) {
		$id=$_GET['id']; 
		$MySQL->Delete("tbkurupy","where IDX=".$id,"1");
	    if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tbkurupy' File 'kurikulum.php' Sukses";
			echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'tbkurupy' File 'kurikulum.php' Gagal";
			echo $msg_delete_data_0;
		}
		AddLog($id_admin,$act_log);
	}

	/*** Simpan Master Kurikulum ***********/	
	if (isset($_POST['submit'])){
		$succ=0;
		$edtKode=substr(strip_tags($_POST['edtKode']),0,15);
		$edtNama=substr(strip_tags($_POST['edtNama']),0,30);
		$cbProdi=substr(strip_tags($_POST['cbProdi']),0,2);
		$edtTahun=substr(strip_tags($_POST['edtTahun']),0,4);
		$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
		$TahunSemester=$edtTahun.$cbSemester;
		$cbStatus=substr(strip_tags($_POST['cbStatus']),0,1);
		$edtTahun1=substr(strip_tags($_POST['edtTahun1']),0,4);
		$cbSemester1=substr(strip_tags($_POST['cbSemester1']),0,1);
		$TahunSemester1=$edtTahun1.$cbSemester1;


		if ($_POST['submit']=="Simpan"){
			$MySQL->Insert("tbkurupy","KDKURTBKUR,NMKURTBKUR,KDPSTTBKUR,THAWLTBKUR","'$edtKode','$edtNama','$cbProdi','$TahunSemester'");
			$msg="Data Kurikulum Berhasil Ditambahkan!";
			$act_log="Tambah Data Pada Tabel 'tbkurupy' File 'kurikulum.php' ";
		} else {
			$edtID=$_POST['edtID'];
			$MySQL->Update("tbkurupy","KDKURTBKUR='$edtKode',NMKURTBKUR='$edtNama',KDPSTTBKUR='$cbProdi',THAWLTBKUR='$TahunSemester',STATUTBKUR='$cbStatus',THAKHTBKUR='$TahunSemester1'","where IDX=".$edtID,"1");
			$msg="Data Kurikulum Berhasil Diupdate!";
			$act_log="Update ID='".$edtID."' Pada Tabel 'tbkurupy' File 'kurikulum.php' ";
		}
	  	if ($MySQL->exe){
			$succ=1;
		}
	  	if ($succ==1){
			$act_log .="Sukses!";
			AddLog($id_admin,$act_log);
			echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
			echo $msg;
			echo "</div>";
	  	} else{
			$act_log .="Gagal";
			AddLog($id_admin,$act_log);
	    	echo "<div id='msg_err' class='diverr m5 p5 tac'>";
	    	echo "Maaf!, Update Data Gagal! Pastikan Data Yang Anda Masukkan Benar";
	    	echo "</div>";
		}
	}

	/*** Simpan Detail Kurikulum ***********/
		if (isset($_POST['submit_1'])){
			$succ=0;
			$edtKurikulum=$_GET['id'];
			$cbMatakuliah=substr(strip_tags($_POST['cbMatakuliah']),0,10);
			$edtSKS=substr(strip_tags($_POST['edtSKS']),0,1);
			$edtSKSTM=substr(strip_tags($_POST['edtSKSTM']),0,1);
			$edtSKSPR=substr(strip_tags($_POST['edtSKSPR']),0,1);
			$edtSKSLP=substr(strip_tags($_POST['edtSKSLP']),0,1);
			$edtSemester=substr(strip_tags($_POST['edtSemester']),0,2);
			$cbJenisMK=substr(strip_tags($_POST['cbJenisMK']),0,1);
			$cbLingkupMK=substr(strip_tags($_POST['cbLingkupMK']),0,1);
			$cbDosen=substr(strip_tags($_POST['cbDosen']),0,10);
			$NamaDosen= LoadDosen_X("","$cbDosen");
			$cbPrasyarat=substr(strip_tags($_POST['cbPrasyarat']),0,10);
			$rbSilabus=substr(strip_tags($_POST['rbSilabus']),0,1);
			$rbAcaraKuliah=substr(strip_tags($_POST['rbAcaraKuliah']),0,1);
			$rbBahanAjar=substr(strip_tags($_POST['rbBahanAjar']),0,1);
			$rbDiktat=substr(strip_tags($_POST['rbDiktat']),0,1);
	
			if ($_POST['submit_1']=="Simpan"){
				$MySQL->Insert("tbkmkupy","IDKURTBKMK,KDKMKTBKMK,SKSMKTBKMK,SKSTMTBKMK,SKSPRTBKMK,SKSLPTBKMK,SEMESTBKMK,KDKURTBKMK,KDWPLTBKMK,NODOSTBKMK,NMDOSTBKMK,SLBUSTBKMK,SAPPPTBKMK,BHNAJTBKMK,DIKTTTBKMK,KDSYATBKMK","'$edtKurikulum','$cbMatakuliah','$edtSKS','$edtSKSTM','$edtSKSPR','$edtSKSLP','$edtSemester','$cbLingkupMK','$cbJenisMK','$cbDosen','$NamaDosen','$rbSilabus','$rbAcaraKuliah','$rbBahanAjar','$rbDiktat','$cbPrasyarat'");
				$msg="Data Kurikulum Berhasil Ditambahkan!";
				$act_log="Tambah Data Pada Tabel 'tbkmkupy' File 'kurikulum.php' ";
			} else {
				$edtID=$_POST['edtID'];
				$MySQL->Update("tbkmkupy","KDKMKTBKMK='$cbMatakuliah',SKSMKTBKMK='$edtSKS',SKSTMTBKMK='$edtSKSTM',SKSPRTBKMK='$edtSKSPR',SKSLPTBKMK='$edtSKSLP',SEMESTBKMK='$edtSemester',KDKURTBKMK='$cbLingkupMK',KDWPLTBKMK='$cbJenisMK',NODOSTBKMK='$cbDosen',NMDOSTBKMK='$NamaDosen',SLBUSTBKMK='$rbSilabus',SAPPPTBKMK='$rbAcaraKuliah',BHNAJTBKMK='$rbBahanAjar',DIKTTTBKMK='$rbDiktat',KDSYATBKMK='$cbPrasyarat'","where IDX='".$edtID."'","1");
				$msg="Data Kurikulum Berhasil Diupdate!";
				$act_log="Update ID: '".$edtID."' Data Pada Tabel 'tbkmkupy' File 'kurikulum.php' ";
			}
		  	if ($MySQL->exe){
				$succ=1;
			}
		  	if ($succ==1){
				$act_log .="Sukses!";
				AddLog($id_admin,$act_log);
				echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
				echo $msg;
				echo "</div>";
		  	} else {
				$act_log .="Gagal!";
				AddLog($id_admin,$act_log);
		    	echo "<div id='msg_err' class='diverr m5 p5 tac'>";
		    	echo "Maaf!, Update Data Kurikulum Gagal Dilakukan!";
		    	echo "</div>";
			}
		}		
	
	if (isset($_GET['p']) && $_GET['p']=='add'){
		if (isset($_GET['kmk'])) {
			$kmk=$_GET['kmk'];
			$MySQL->Select("KDKURTBKUR,NMKURTBKUR","tbkurupy","WHERE IDX=".$kmk,"1");
			$show=$MySQL->fetch_array();
			/**** Form tambah data matakuliah **************/
?>
			<form name="form1" action="./?page=kurikulum&amp;p=view&id=<?php echo $kmk; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr>
				<th colspan="2">Form Tambah Data Matakuliah Kurikulum</th>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>	
				<tr><td width="30%">Kode Kurikulum</td>
				  <td>: <?php echo $show['KDKURTBKUR']; ?>
				  </td>
				</tr>
				<tr><td width="30%">Kurikulum</td>
				  <td>: <?php echo 	$show['NMKURTBKUR']; ?>
				  </td>
				</tr>				
				<tr>
				    <td>Matakuliah</td>
				    <td class="mandatory">
					: <?php LoadMatakuliah_X("cbMatakuliah",""); ?>
			    </tr>
				<tr>
				    <td>Bobot SKS Matakuliah</td>
				    <td>: 
					<input size="1" type="text" name="edtSKS" id="edtSKS" maxlength="1" value="0" >&nbsp;SKS
			    </tr>
				<tr>
				    <td>SKS Tatap Muka</td>
				    <td>: 
					<input size="1" type="text" name="edtSKSTM" id="edtSKSTM" maxlength="1" value="0">&nbsp;SKS

			    </tr>
				<tr>
				    <td>SKS Praktikum</td>
				    <td>: 
					<input size="1" type="text" name="edtSKSPR" id="edtSKSPR" maxlength="1" value="0">&nbsp;SKS
			    </tr>
				<tr>
				    <td>SKS Praktek Lapangan</td>
				    <td>: 
					<input size="1" type="text" name="edtSKSLP" id="edtSKSLP" maxlength="1" value="0">&nbsp;SKS
				</tr>
				<tr>
				    <td>Untuk Semester</td>
				    <td class="mandatory">: 
					<input size="2" type="text" name="edtSemester" id="edtSemester" maxlength="2">
			    </tr>
				<tr>
				    <td>Jenis Matakuliah</td>
				    <td class="mandatory">: 
					<?php LoadKode_X("cbJenisMK","","28"); ?>
			    </tr>
				<tr>
				    <td>Lingkup Matakuliah</td>
				    <td class="mandatory">: 
					<?php LoadKode_X("cbLingkupMK","","11"); ?>
			    </tr>
				<tr>
				    <td>Nama Dosen Pengampu</td>
				    <td class="mandatory">: 
					<?php LoadDosen_X("cbDosen",""); ?>
			    </tr>
				<tr>
				    <td>Prasyarat Matakuliah</td>
				    <td class="mandatory">
					: <?php LoadMatakuliah_X("cbPrasyarat",""); ?>
			    </tr>
				<tr>
			    <td>Silabus</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbSilabus) $checkstr="checked";
	echo "<input type='radio' name='rbSilabus' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr>
			    <td>Satuan Acara Perkuliahan</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbAcaraKuliah) $checkstr="checked";
	echo "<input type='radio' name='rbAcaraKuliah' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr>
			    <td>Bahan Ajar</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbBahanAjar) $checkstr="checked";
	echo "<input type='radio' name='rbBahanAjar' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr>
			    <td>Diktat</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbDiktat) $checkstr="checked";
	echo "<input type='radio' name='rbDiktat' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
				    <td colspan="2" align="center">
			        <button type="button" onClick=window.location.href="./?page=kurikulum&amp;p=view&amp;id=<?php echo $kmk; ?>" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
            <button type="submit" name="submit_1" value="Simpan" /><img src="images/b_save.gif" class="btn_img">&nbsp;Simpan</button>
					</td>
				</tr>
			</table>
			</form>
<?php			
		} else {
			/********* Form edit Data Kurikulum ***********/
?>
			<form name="form1" action="./?page=kurikulum" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr>
				<th colspan="2">Form Tambah Data Kurikulum</th>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>	
				<tr><td width="30%">Kode Kurikulum</td>
				  <td class="mandatory">: 
				  <input size="15" type="text" name="edtKode" id="edtKode" maxlength="15"></td>
				</tr>	      
				<tr>
				    <td>Nama Kurikulum</td>
				    <td class="mandatory">
					: 
				    <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30"></td>
			    </tr>
				<tr>
				    <td>Program Studi : </td>
				    <td class="mandatory">:
					<?php LoadProdi_X("cbProdi","",$fak,"required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Program Studi yang Ada!'") ?></td>
			    </tr>
				<tr>
				    <td>Tahun Akademik Mulai berlaku</td>
				    <td class="mandatory">: 
				    <input size="4" type="text" name="edtTahun" id="edtTahun" maxlength="4" required='1' regexp ='/^\d*$/' realname='Tahun' >
<?php
					LoadSemester_X("cbSemester","$cbSemester","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Semester yang Ada!'")
?>
					</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
				    <td colspan="2" align="center">
			        <button type="button" onClick=window.location.href="./?page=kurikulum" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
			        <button type="submit" name="submit" value="Simpan"  /><img src="images/b_save.gif" class="btn_img">&nbsp;Simpan</button>
					</td>
				</tr>
			</table>
			</form>
<?php
		}
	} elseif (isset($_GET['p']) && $_GET['p']=='edit'){
		if (isset($_GET['kmk'])) {
			$kmk=$_GET['kmk'];
			$MySQL->Select("KDKURTBKUR,NMKURTBKUR","tbkurupy","WHERE IDX=".$kmk,"1");
			$show=$MySQL->Fetch_Array();
			$edtKurikulum=$show['KDKURTBKUR'];
			$kurikulum=$show['NMKURTBKUR'];
			/**** Form update data matakuliah **************/
			$edtID=$_GET['id'];
			$MySQL->Select("*","tbkmkupy","WHERE IDX=".$edtID,"1");
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
			
			
?>
			<form name="form1" action="./?page=kurikulum&amp;p=view&id=<?php echo $kmk; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		  	<input type="hidden" name="edtID" value="<?php echo $edtID; ?>">
			<tr>
				<th colspan="2">Form Tambah Data Matakuliah Kurikulum</th>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>	
				<tr><td width="30%">Kode Kurikulum</td>
				  <td>: <?php echo $edtKurikulum; ?>
			  	</td>
				</tr>
				<tr><td width="30%">Kurikulum</td>
				  <td>: <?php echo $kurikulum; ?>
				  </td>
				</tr>				
				<tr>
				    <td>Matakuliah</td>
				    <td class="mandatory">
					: <?php LoadMatakuliah_X("cbMatakuliah","$cbMatakuliah"); ?>
			    </tr>
				<tr>
				    <td>Bobot SKS Matakuliah</td>
				    <td>: 
					<input size="1" type="text" name="edtSKS" id="edtSKS" maxlength="1" value="<?php echo $edtSKS; ?>" >&nbsp;SKS

			    </tr>
				<tr>
				    <td>SKS Tatap Muka</td>
				    <td>: 
					<input size="1" type="text" name="edtSKSTM" id="edtSKSTM" maxlength="1" value="<?php echo $edtSKSTM; ?>">&nbsp;SKS

			    </tr>
				<tr>
				    <td>SKS Praktikum</td>
				    <td>: 
					<input size="1" type="text" name="edtSKSPR" id="edtSKSPR" maxlength="1" value="<?php echo $edtSKSPR; ?>">&nbsp;SKS
			    </tr>
				<tr>
				    <td>SKS Praktek Lapangan</td>
				    <td>: 
					<input size="1" type="text" name="edtSKSLP" id="edtSKSLP" maxlength="1" value="<?php echo $edtSKSLP; ?>">&nbsp;SKS
				</tr>
				<tr>
				    <td>Untuk Semester</td>
				    <td class="mandatory">: 
					<input size="2" type="text" name="edtSemester" id="edtSemester" maxlength="2" value="<?php echo $edtSemester; ?>">

			    </tr>
				<tr>
				    <td>Jenis Matakuliah</td>
				    <td class="mandatory">: 
					<?php LoadKode_X("cbJenisMK","$cbJenisMK","28"); ?>
			    </tr>
				<tr>
				    <td>Lingkup Matakuliah</td>
				    <td class="mandatory">: 
					<?php LoadKode_X("cbLingkupMK","$cbLingkupMK","11"); ?>
			    </tr>
				<tr>
				    <td>Nama Dosen Pengampu</td>
				    <td class="mandatory">: 
					<?php LoadDosen_X("cbDosen","$cbDosen"); ?>
			    </tr>
				<tr>
				    <td>Prasyarat Matakuliah</td>
				    <td class="mandatory">
					: <?php LoadMatakuliah_X("cbPrasyarat","$cbPrasyarat"); ?>
			    </tr>
				<tr>
			    <td>Silabus</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbSilabus) $checkstr="checked";
	echo "<input type='radio' name='rbSilabus' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr>
			    <td>Satuan Acara Perkuliahan</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbAcaraKuliah) $checkstr="checked";
	echo "<input type='radio' name='rbAcaraKuliah' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr>
			    <td>Bahan Ajar</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbBahanAjar) $checkstr="checked";
	echo "<input type='radio' name='rbBahanAjar' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr>
			    <td>Diktat</td>
				<td>
				: 
	<?php
					$ops[1]="Y - ada";
					$ops[0]="T - tidak ada";
					$op[1]="Y";
					$op[0]="T";
					for ($i=1;$i >= 0 ; $i--){
						$checkstr="";
						if ($op[$i]==$rbDiktat) $checkstr="checked";
	echo "<input type='radio' name='rbDiktat' value='$op[$i]' ".$checkstr." >".$ops[$i]."&nbsp;&nbsp;";
					}
	?>
		    	</td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
				    <td colspan="2" align="center">
			        <button type="button" onClick=window.location.href="./?page=kurikulum&amp;p=view&amp;id=<?php echo $kmk; ?>" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
            		<button type="submit" name="submit_1" value="Update" /><img src="images/b_save.gif" class="btn_img">&nbsp;Update</button>
					</td>
				</tr>
			</table>
			</form>			
			
<?php			
		} else {
		$edtID=$_GET['id'];
		$MySQL->Select("*","tbkurupy","where IDX='$edtID'","","1");
		$show=$MySQL->fetch_array();
		$edtKode=$show['KDKURTBKUR'];
		$edtNama=$show['NMKURTBKUR'];
		$cbProdi=$show['KDPSTTBKUR'];
		$edtTahun=substr($show['THAWLTBKUR'],0,4);
		$cbSemester=substr($show['THAWLTBKUR'],4,1);
		$cbStatus=$show['STATUTBKUR'];
		$edtTahun1=substr($show['THAKHTBKUR'],0,4);
		$cbSemester1=substr($show['THAKHTBKUR'],4,1);
?>
		<form name="form1" action="./?page=kurikulum" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" >
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<th colspan="2">Form Update Data Kurikulum</th>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>	
			<tr><td width="30%">Kode Kurikulum</td>
			  <td class="mandatory">: 
			  <input size="15" type="text" name="edtKode" id="edtKode" maxlength="15" value="<?php echo $edtKode; ?>"></td>
			</tr>	      
			<tr>
			    <td>Nama Kurikulum</td>
			    <td class="mandatory">
				: 
			    <input size="30" type="text" name="edtNama" id="edtNama" maxlength="30" value="<?php echo $edtNama; ?>" ></td>
		    </tr>
			<tr>
			    <td>Program Studi : </td>
			    <td class="mandatory">:
				<?php LoadProdi_X("cbProdi","$cbProdi",$fak,"required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Program Studi yang Ada!'") ?></td>
		    </tr>
			<tr>
			    <td>Tahun Akademik Mulai berlaku</td>
			    <td class="mandatory">: 
			    <input size="4" type="text" name="edtTahun" id="edtTahun" maxlength="4" value="<?php echo $edtTahun; ?>" required='1' regexp ='/^\d/' realname='Tahun' > <?php LoadSemester_X("cbSemester","$cbSemester","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Semester yang Ada!'"); ?>
				</td>
			</tr>
			<tr>
			    <td>Status</td>
			    <td class="mandatory">: <?php LoadKode_X("cbStatus","$cbStatus","14","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Status yang Ada!'"); ?>
				</td>
			</tr>
			<tr>
			    <td>Tahun Akademik Mulai Hapus</td>
			    <td class="mandatory">: 
			    <input size="4" type="text" name="edtTahun1" id="edtTahun1" maxlength="4" value="<?php echo $edtTahun1; ?>" regexp ='/^\d/' realname='Tahun' > <?php LoadSemester_X("cbSemester1","$cbSemester1"); ?>
				</td>
			</tr>			
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			    <td colspan="2" align="center">
		        <button type="button" onClick=window.location.href="./?page=kurikulum" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
		        <button type="submit" name="submit" value="Update" /><img src="images/b_save.gif" class="btn_img">&nbsp;Update</button>
				</td>
			</tr>
		</table>
		</form>
<?php	
		}	
	} elseif (isset($_GET['p']) && $_GET['p']=='view') {
		if (isset($_GET['kmk'])){
			$id=$_GET['id'];
			$edtID=$_GET['kmk']; 
			$MySQL->Delete("tbkmkupy","where IDX=".$id,"1");
		    if ($MySQL->exe){
				$act_log="Hapus ID='$id' Pada Tabel 'tbkmkupy' File 'kurikulum.php' Sukses";
				AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
			    echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
			    echo "Data Berhasil Dihapus!";
			    echo "</div>";
			} else {
				$act_log="Hapus ID='$id' Pada Tabel 'tbkmkupy' File 'kurikulum.php' Gagal";
				AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
			    echo "<div id='msg_err' class='diverr m5 p5 tac'>";
			    echo "Data Gagal Dihapus!";
			    echo "</div>";
			}
		} else {
			$edtID=$_GET['id'];
		}
		$MySQL->Select("*","tbkurupy","where IDX='$edtID'","","1");
		$show=$MySQL->fetch_array();
		$edtKodeKurikulum=$show['KDKURTBKUR'];
		$edtNamaKurikulum=$show['NMKURTBKUR'];
		$cbProdi=LoadProdi_X("",$show['KDPSTTBKUR']);
		$edtTahun=substr($show['THAWLTBKUR'],0,4);
		$cbSemester=substr($show['THAWLTBKUR'],4,1);
?>
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<th colspan="2">Pendataan Matakuliah Kurikulum</th>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>	
			<tr><td width="30%">Kode Kurikulum</td>
			  <td>: <?php echo $edtKodeKurikulum; ?></td>
			</tr>	      
			<tr>
			    <td>Nama Kurikulum</td>
			    <td>
				: <?php echo $edtNamaKurikulum; ?></td>
		    </tr>
			<tr>
			    <td>Program Studi : </td>
			    <td>: <?php echo $cbProdi ?></td>
		    </tr>
			<tr>
			    <td>Tahun Akademik Mulai berlaku</td>
			    <td>: 
<?php 
				echo $edtTahun; 
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Semester : ".LoadSemester_X("","$cbSemester"); ?>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			    <td colspan="2" align="center">
		        <button type="button" onClick=window.location.href="./?page=kurikulum" /><img src="images/b_back.png" class="btn_img">&nbsp;Kembali</button>
				</td>
			</tr>
		</table>
		<br>
<?php
		/******* Tampilkan daftar matakuliah ****************/
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><td colspan='8' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=kurikulum&amp;p=add&amp;kmk=$edtID' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
		echo "<tr><th colspan='8' style='background-color:#EEE'>Daftar Matakuliah</th></tr>";
		echo "<tr>
			<th style='width:20px;'>NO</th>
			<th style='width:75px;'>KODE</th>
			<th style='width:200px;'>MATAKULIAH</th>
			<th style='width:20px; tac'>JUMLAH SKS</th>
			<th style='width:75px; tac'>PRASYARAT</th>
			<th style='width:100px;'>KURIKULUM</th>
			<th colspan='2' style='width:40px;'>ACT</th>";
		echo "</tr>";
		$MySQL->Select("DISTINCT tbkmkupy.SEMESTBKMK","tbkmkupy","WHERE tbkmkupy.IDKURTBKMK ='".$edtID."'","tbkmkupy.SEMESTBKMK");
		$i=0;
		$row=$MySQL->Num_Rows();
		if ($row > 0){
			while ($show=$MySQL->fetch_array()) {
				$master[$i]=$show['SEMESTBKMK'];
				$i++;
			}

		for ($i=0; $i < $row; $i++) {
			echo "<td colspan='8' class='fwb'>Semester ".$master[$i]."</td>";
			$MySQL->Select("tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SKSTMTBKMK,tbkmkupy.SKSPRTBKMK,tbkmkupy.SKSLPTBKMK,tbkmkupy.KDKURTBKMK,tbkmkupy.KDSYATBKMK,tblmkupy.NAMKTBLMK","tbkmkupy","LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.IDKURTBKMK ='".$edtID."' and tbkmkupy.SEMESTBKMK='".$master[$i]."'","tbkmkupy.KDKMKTBKMK ASC");
				$no=1;
				$sksTotal=0;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					$syarat=$show['KDSYATBKMK'];
					if ($syarat=='-1') $syarat="-";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tac'>".$no."</td>";
			     	echo "<td class='$sel'>".$show['KDKMKTBKMK']."</td>";
			     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
			     	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."-".$show['SKSTMTBKMK']."-".$show['SKSPRTBKMK']."-".$show['SKSLPTBKMK']."</td>";
			     	echo "<td class='$sel tac'>".$syarat."</td>";
			     	echo "<td class='$sel tac'>".$show['KDKURTBKMK']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=kurikulum&amp;p=edit&amp;kmk=".$edtID."&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=kurikulum&amp;p=view&amp;kmk=".$edtID."&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$sksTotal += $show['SKSMKTBKMK'];
			     	$no++;
				}
				echo "<tr><td class='tar fwb' colspan='3'>SKS Total &nbsp;&nbsp;</td>";
				echo "<td class='tac fwb'>".$sksTotal." SKS</td><td colspan='4'>&nbsp;</td></tr>";				
			}			
		} else {
 			echo "<td colspan='8' align='center' style='color:red;'>".$msg_data_empty."</td>";		
		}
		echo "</table>";
		echo "Keterangan Kurikulum : A = Inti, B = Institusi";
		//  Cetak
		//Tampilkan form konfirmasi	
		echo "<br><form action=\"cetak_rekap_mk.php\" method=\"post\" target=\"pdf_target\">";
		$_SESSION[PREFIX.'data']=$master;
		echo "<input type='hidden' name='indikator' value='".$cbProdi.",".$edtID.",".$edtTahun."' >";
		echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" /></td>";
		echo "</form>";
		//Cetak Bukti Pembayaran Ujian	


	} else {
			/***** Default Tampilan **************/
	 	 if (!isset($_GET['pos'])) $_GET['pos']=1;
		 $page=$_GET['page'];
		 $p=$_GET['p'];
	     $sel="";
	     $field=$_REQUEST['field'];
		 if (!isset($_REQUEST['limit'])){
		    $_REQUEST['limit']="20";
		 }
		 if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
	
		$URLa="page=".$page;		
			
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		/************ Form Pencarian****************/
		echo "<tr><td colspan='3'>";
		echo "<form action='./?".$URLa."' method='post' >";
		echo "Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='KDKURTBKUR') $sel1="selected='selected'";
	    if ($field=='NMKURTBKUR') $sel2="selected='selected'";
	    if ($field=='mspstupy.NMPSTMSPST') $sel3="selected='selected'";
	
	    echo "<option value='KDKURTBKUR' $sel1 >KODE</option>";
	    echo "<option value='NMKURTBKUR' $sel2 >KURIKULUM</option>";
	    echo "<option value='mspstupy.NMPSTMSPST' $sel3 >PROGRAM STUDI</option>";
	
	    echo "</select>";
	    echo "<input type='text' size='50' name='key' value='".$_REQUEST['key']."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		 
		echo "<td colspan='6' align='right'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=kurikulum&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	    echo "</td></tr></form>";
	 		
		echo "<tr><td colspan='9' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=kurikulum&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
		echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR KURIKULUM</th></tr>";
		echo "<tr>
			<th style='width:50px;' rowspan='2'>KODE</th>
			<th style='width:150px;' rowspan='2'>KURIKULUM</th>
			<th style='width:150px;' rowspan='2'>PROGRAM STUDI</th>
			<th style='width:80px;' colspan='2'>MULAI BERLAKU</th>
			<th style='width:30px;' rowspan='2'>STATUS</th>
			<th colspan='3' style='width:40px;' rowspan='2'>ACT</th>";
		echo "</tr>";
		echo "<tr>
			<th style='width:40px;'>TAHUN</th>
			<th style='width:40px;'>SEMESTER</th>";
		echo "</tr>";

	    $qry = "left join mspstupy on tbkurupy.KDPSTTBKUR=mspstupy.IDPSTMSPST";
		$qry .= " left join tbkodupy on tbkurupy.STATUTBKUR=tbkodupy.KDKODTBKOD";
		$qry .= " where KDAPLTBKOD='14'";
		
		if(!empty($_REQUEST['key'])){
	      	$qry .= " and ".$field." like '".$key."'";
	  	}
	
		$MySQL->Select("*","tbkurupy",$qry,"","","0");
		$total=$MySQL->Num_Rows();
		$perpage=$_REQUEST['limit'];
		$totalpage=ceil($total/$perpage);
		$start=($_GET['pos']-1)*$perpage;
		$MySQL->Select("tbkurupy.*,mspstupy.NMPSTMSPST as PRODI,tbkodupy.NMKODTBKOD as STATUS","tbkurupy",$qry,"tbkurupy.THAWLTBKUR DESC,tbkurupy.KDPSTTBKUR ASC","$start,$perpage");
		if ($MySQL->Num_Rows() > 0){
			$no=1;
			while ($show=$MySQL->Fetch_Array()){
				$sel="";
				$thn=substr($show["THAWLTBKUR"],0,4);
				$smt=substr($show["THAWLTBKUR"],4,1);
				$semester="GASAL";
				if ($smt=="2") $semester="GENAP";

				if ($no % 2 == 1) $sel="sel";     	
				echo "<tr>";
		     	echo "<td class='$sel'>".$show['KDKURTBKUR']."</td>";
		     	echo "<td class='$sel'>".$show['NMKURTBKUR']."</td>";
		     	echo "<td class='$sel'>".$show['PRODI']."</td>";
		     	echo "<td class='$sel'>".$thn."</td>";
		     	echo "<td class='$sel'>".$semester."</td>";
		     	echo "<td class='$sel tac'>".$show['STATUS']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=kurikulum&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=kurikulum&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=kurikulum&amp;p=del&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
			}
		} else {
 			echo "<td colspan='9' align='center' style='color:red;'>".$msg_data_empty."</td>";		
		}
		echo "<tr><td colspan='9'>";	
		include "navigator.php";
		echo "</td></tr>";
		echo "</table>";
	}
}
?>

