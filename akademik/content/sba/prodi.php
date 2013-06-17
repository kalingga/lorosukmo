<?php
$idpage='11';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$prive_user=GetAksesUser($id_admin);
	
	$i=0;
	$akses_user[$i] = $prive_user;
	if ($level_user == '1') {
		$MySQL->Select("IDPSTMSPST","mspstupy","WHERE KDFAKMSPST = '".$prive_user."'","","");
		$prodi_in_fak = "";
		while ($show=$MySQL->fetch_array()) {
			if ($i==0) {
				$prodi_in_fak .= $show["IDPSTMSPST"];
			} else {
				$prodi_in_fak .= ",".$show["IDPSTMSPST"];
			}
			$i++;
		}
		$prodi_in_fak = @explode(",",$prodi_in_fak);
		$jml_prodi_in_fak = count($prodi_in_fak);
		$MySQL->Select("IDPSTMSPST","mspstupy","","","");
		$i=0;
		while ($show=$MySQL->fetch_array()) {
			for ($j=0;$j < $jml_prodi_in_fak;$j++) {
				if ($prodi_in_fak[$j] == $show["IDPSTMSPST"]) $akses_user[$i]=$show["IDPSTMSPST"];
			}
			$i++;
		}
	}

	$URLa="page=".$_GET['page'];
	//$page=$_GET['page'];
	
	/*************** Simpan Data ****************/
	$such=0;
	if (isset($_POST['submit_1'])){
		$pst=$_POST['pst'];
		$cbAkreditasi=substr(strip_tags($_POST['cbAkreditasi']),0,1);
		$edtBAN=substr(strip_tags($_POST['edtBAN']),0,40);
		$edtTglBAN1=substr(strip_tags($_POST['edtTglBAN1']),0,10);
		$edtTglBAN1=@explode("-",$edtTglBAN1);
		$edtTglBAN1=$edtTglBAN1[2]."-".$edtTglBAN1[1]."-".$edtTglBAN1[0];
		$edtTglBAN2=substr(strip_tags($_POST['edtTglBAN2']),0,10);
		$edtTglBAN2=@explode("-",$edtTglBAN2);
		$edtTglBAN2=$edtTglBAN2[2]."-".$edtTglBAN2[1]."-".$edtTglBAN2[0];
		if ($_POST['submit_1']=='Simpan') {
			$MySQL->Insert("akpstupy","KDSTAMSPST,NOMBAMSPST,TGLBAMSPST,TGLABMSPST,IDPSTMSPST","'$cbAkreditasi','$edtBAN','$edtTglBAN1','$edtTglBAN2','$pst'");
			$msg=$msg_insert_data;
			$act_log="Tambah Data Pada Tabel 'akpstupy' File 'akreditasi.php' ";
		} else {
			$edtID=$_POST['edtID'];
			$MySQL->Update("akpstupy","KDSTAMSPST='$cbAkreditasi',NOMBAMSPST='$edtBAN',TGLBAMSPST='$edtTglBAN1',TGLABMSPST='$edtTglBAN2'","where IDX=".$edtID,"1");
			$msg=$msg_edit_data;
			$act_log="Update ID='$edtID' Data Pada Tabel 'akpstupy' File 'akreditasi.php' ";
  		}
		if ($MySQL->exe){
			$succ=1;
		}
  		if ($succ==1){
			$act_log .="Sukses!";
			AddLog($id_admin,$act_log);
			echo $msg;
  		} else	{
			$act_log .="Gagal!";
			AddLog($id_admin,$act_log);
			echo $msg_update_0;
		}			
	}
	
	if (isset($_POST['submit_2'])){
		$pst=$_POST['pst'];
		$edtSK=substr(strip_tags($_POST['edtSK']),0,40);
		$edtTglSK1=substr(strip_tags($_POST['edtTglSK1']),0,10);
		$edtTglSK1=@explode("-",$edtTglSK1);
		$edtTglSK1=$edtTglSK1[2]."-".$edtTglSK1[1]."-".$edtTglSK1[0];		
		$edtTglSK2=substr(strip_tags($_POST['edtTglSK2']),0,10);
		$edtTglSK2=@explode("-",$edtTglSK2);
		$edtTglSK2=$edtTglSK2[2]."-".$edtTglSK2[1]."-".$edtTglSK2[0];		
		if ($_POST['submit_2']=='Simpan') {
			$MySQL->Insert("skpstupy","NOMSKMSPST,TGLSKMSPST,TGLAKMSPST,IDPSTMSPST","'$edtSK','$edtTglSK1','$edtTglSK2','$pst'");
			$msg=$msg_insert_data;
			$act_log="Tambah Data Pada Tabel 'akpstupy' File 'akreditasi.php' ";
		} else {
			$edtID=$_POST['edtID'];
			$MySQL->Update("skpstupy","NOMSKMSPST='$edtSK',TGLSKMSPST='$edtTglSK1',TGLAKMSPST='$edtTglSK2'","where IDX=".$edtID,"1");
			$msg=$msg_edit_data;
			$act_log="Update ID='$edtID' Data Pada Tabel 'skpstupy' File 'prodi.php' ";
 		}
		if ($MySQL->exe){
			$succ=1;
		}
  		if ($succ==1){
			$act_log .="Sukses!";
			AddLog($id_admin,$act_log);
			echo $msg;
  		} else	{
			$act_log .="Gagal!";
			AddLog($id_admin,$act_log);
			echo $msg_update_0;
		}			
	}

	if (isset($_POST['submit'])){
		$edtKode=substr(strip_tags($_POST['edtKode']),0,5);
		$cbProdi=substr(strip_tags($_POST['cbProdi']),0,5);
		$edtNama=substr(strip_tags($_POST['edtNama']),0,50);
		$cbJenjang=substr(strip_tags($_POST['cbJenjang']),0,1);
		$Jenjang=LoadKode_X("",$cbJenjang,"04");
		$cbFakultas=substr(strip_tags($_POST['cbFakultas']),0,1);
		$edtTelp=substr(strip_tags($_POST['edtTelp']),0,20);
		$edtFax=substr(strip_tags($_POST['edtFax']),0,20);
		$edtEmail=substr(strip_tags($_POST['edtEmail']),0,40);
		$edtBerdiri=substr(strip_tags($_POST['edtBerdiri']),0,10);
		$edtBerdiri=@explode("-",$edtBerdiri);
		$edtBerdiri=$edtBerdiri[2]."-".$edtBerdiri[1]."-".$edtBerdiri[0];
		$edtSKS=substr(strip_tags($_POST['edtSKS']),0,3);
		$cbStatus=substr(strip_tags($_POST['cbStatus']),0,1);
		$edtTahun=substr(strip_tags($_POST['edtTahun']),0,4);
		$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
		$ThnSemester=$edtTahun.$cbSemester;
		$cbFrekuensi=substr(strip_tags($_POST['cbFrekuensi']),0,1);
		$cbPelaksanaan=substr(strip_tags($_POST['cbPelaksanaan']),0,1);
		$edtKaProdi=substr(strip_tags($_POST['edtKaProdi']),0,40);
		$edtNIDN=substr(strip_tags($_POST['edtNIDN']),0,10);
		$edtHP=substr(strip_tags($_POST['edtHP']),0,20);
		$edtOperator=substr(strip_tags($_POST['edtOperator']),0,40);
		$edtHP1=substr(strip_tags($_POST['edtHP1']),0,20);
	
		if ($_POST['submit']=='Simpan'){
			$MySQL->Insert("mspstupy","KDFAKMSPST,IDPSTMSPST,KDPSTMSPST,NMPSTMSPST,KDJENMSPST,NMJENMSPST,TELPOMSPST,FAKSIMSPST,EMAILMSPST,TGAWLMSPST,SKSTTMSPST,STATUMSPST,MLSEMMSPST,KDFREMSPST,KDPELMSPST,NMOPRMSPST,TELPRMSPST,KAPSTMSPST,NOKPSMSPST,TELPSMSPST","'$cbFakultas','$edtKode','$cbProdi','$edtNama','$cbJenjang','$Jenjang','$edtTelp','$edtFax','$edtEmail','$edtBerdiri','$edtSKS','$cbStatus','$ThnSemester','$cbFrekuensi','$cbPelaksanaan','$edtOperator','$edtHP1','$edtKaProdi','$edtNIDN','$edtHP'");
			$msg=$msg_insert_data;
			$act_log="Tambah Data Pada Tabel 'mspstupy' File 'prodi.php' "; 
		} else {
			$edtID=substr(strip_tags($_POST['edtID']),0,2);
			$MySQL->Update("mspstupy","KDFAKMSPST='$cbFakultas',IDPSTMSPST='$edtKode',KDPSTMSPST='$cbProdi',NMPSTMSPST='$edtNama',KDJENMSPST='$cbJenjang',NMJENMSPST='$Jenjang',TELPOMSPST='$edtTelp',FAKSIMSPST='$edtFax',EMAILMSPST='$edtEmail',TGAWLMSPST='$edtBerdiri',SKSTTMSPST='$edtSKS',STATUMSPST='$cbStatus',MLSEMMSPST='$ThnSemester',KDFREMSPST='$cbFrekuensi',KDPELMSPST='$cbPelaksanaan',NMOPRMSPST='$edtOperator',TELPRMSPST='$edtHP1',KAPSTMSPST='$edtKaProdi',NOKPSMSPST='$edtNIDN',TELPSMSPST='$edtHP'","where IDX=".$edtID,"1");
			$msg=$msg_edit_data;
			$act_log="Update ID='$edtID' Data Pada Tabel 'mspstupy' File 'prodi.php' "; 
		}
		// perintah SQL berhasil dijalankan
	  	if ($MySQL->exe){
			$succ=1;
		}
	  	if ($succ==1){
			$act_log .="Sukses!";
			AddLog($id_admin,$act_log);
			echo $msg;
	  	} else {
			$act_log .="Gagal!";
			AddLog($id_admin,$act_log);
			echo $msg_update_0;
		}
	}
		/****** Jika page=prodi && p=delete=> *********/		
	if ((isset($_GET['p']) && $_GET['p']=='delete')){
		$id=$_GET['id']; 
		$MySQL->Delete("mspstupy","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'mspstupy' File 'prodi.php' Sukses!";
			AddLog($id_admin,$act_log);
			echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'mspstupy' File 'prodi.php' Gagal!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data_0;
		}
	}
	
	if ((isset($_GET['p']) && ($_GET['p'] != 'delete')) || isset($_GET['sub'])) {
		$edtKode="";
		$cbProdi="";
		$edtNama="";
		$cbJenjang="";
		$cbFakultas="";
		$edtTelp="";
		$edtFax="";
		$edtEmail="";
		$edtBerdiri="";
		$edtSKS="";
		$cbStatus="";
		$edtTahun="";
		$cbSemester="";
		$cbFrekuensi="";
		$cbPelaksanaan="";
		$edtKaProdi="";
		$edtNIDN="";
		$edtHP="";
		$edtOperator="";
		$edtHP1="";
		$submited="Simpan";
		$HeaderTitle="Tambah";
		
		if (isset($_GET['p']) || (isset($_GET['act']) && $_GET['act']=='delete')  ) {
			if ($_GET['sub']=='akreditasi'){
				$id=$_GET['id'];
				$MySQL->Delete("akpstupy","where IDX=".$id,"1");
				if ($MySQL->exe){
					$act_log="Hapus ID='$id' Pada Tabel 'akpstupy' File 'prodi.php' Sukses!";
					AddLog($id_admin,$act_log);
					echo $msg_delete_data;
				} else {
					$act_log="Hapus ID='$id' Pada Tabel 'akpstupy' File 'prodi.php' Gagal!";
					AddLog($id_admin,$act_log);
				    echo $msg_delete_data_0;
				}
			}
			
			if ($_GET['sub']=='sk_dikti'){
				$id=$_GET['id'];
				$MySQL->Delete("skpstupy","where IDX=".$id,"1");
				if ($MySQL->exe){
					$act_log="Hapus ID='$id' Pada Tabel 'skpstupy' File 'prodi.php' Sukses!";
					AddLog($id_admin,$act_log);
					echo $msg_delete_data;
				} else {
					$act_log="Hapus ID='$id' Pada Tabel 'skpstupy' File 'prodi.php' Gagal!";
					AddLog($id_admin,$act_log);
				    echo $msg_delete_data_0;
				}
			}
			
			if (($_GET['p']=="edit") || ($_GET['p']=="view") || ($_GET['act']=="delete")) {
				$edtID=$_GET['id'];
				if ($_GET['act']=="delete") $edtID=$_GET['pst'];
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
				$cbStatus=$show['STATUMSPST'];
				$edtTahun=substr($show['MLSEMMSPST'],0,4);
				$cbSemester=substr($show['MLSEMMSPST'],4,1);
				$cbFrekuensi=$show['KDFREMSPST'];
				$cbPelaksanaan=$show['KDPELMSPST'];
				$edtKaProdi=$show['KAPSTMSPST'];
				$edtNIDN=$show['NOKPSMSPST'];
				$edtHP=$show['TELPSMSPST'];
				$edtOperator=$show['NMOPRMSPST'];
				$edtHP1=$show['TELPRMSPST'];
				$submited="Update";
				$HeaderTitle="Update";
			}
			
			if ($_GET['p'] == 'view') {
				echo "<center>";
?>
				<div class="fadecontenttoggler" style="width: 90%;">
				<a class="toc">DETAIL PROGRAM STUDI</a>
				</div>
				<div class="fadecontentwrapper" style="width: 90%; height: 10px;" ></div>
				<table style="width:90%" border="0" cellpadding="1" cellspacing="1">
				<tr><td colspan="4">&nbsp;</td></tr>	
				<tr><td width="35%">Kode Program Studi</td>
					<td colspan="3">: <?php echo $edtKode; ?></td>
				</tr>	      
				<tr><td width="35%">Kode Dikti Program Studi</td>
				  <td colspan="3">: <?php echo $cbProdi; ?></td>
				</tr>	      
				<tr>
				    <td>Nama Program Studi yang Digunakan di Masing-masing PT.</td>
				    <td colspan="3">: <?php echo $edtNama; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenjang &nbsp;&nbsp;:&nbsp;<?php echo LoadKode_X("","$cbJenjang","04") ?></td>
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
				<tr>
				    <td>Status Program Studi</td>
				    <td colspan="3">: <?php echo LoadKode_X("","$cbStatus","14"); ?></td>
				</tr>
				<tr>
				    <td>Tahun Semester Mulai Hapus </td>
				    <td colspan="3">: <?php echo $edtTahun; ?>&nbsp;&nbsp;&nbsp;
					Sem. : <?php echo LoadSemester_X("","$cbSemester"); ?></td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
				    <td>Frekuensi Pemutakhiran Kurikulum </td>
				    <td colspan="3">: 
					<?php echo LoadKode_X("","$cbFrekuensi","29"); ?></td>
				</tr>
				<tr>
				    <td>Pelaksanaan Pemutakhiran Kurikulum</td>
				    <td colspan="3">: <?php echo LoadKode_X("","$cbPelaksanaan","30"); ?></td>
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
				     <th style='width:150px;'>Status Akreditasi</th> 
				     <th style='width:150px;'>Nomor SK Akreditasi</th> 
				     <th style='width:150px;'>Tanggal SK Akreditasi</th> 
				     <th style='width:150px;'>Berlaku S.d.</th> 
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
				     	echo "<td class='$sel'>".DateStr($show['TGLABMSPST'])."</td>";
				     	echo "</tr>";
				     	$no++;	     	
			     	}
				} else {
			 		echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";
				}
			    echo "</table>";
		
				/********** Riwayat SK Penetapan Program Studi ********************/
				echo "<br>";
				echo "<table border='0' style='width:90%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
				echo "<tr><th colspan='3' style='background-color:#EEE'>RIWAYAT SK DIKTI</th></tr>";
				echo "<tr>
				     <th style='width:200px;'>Nomor SK Dikti</th> 
				     <th style='width:200px;'>Tanggal SK Dikti</th> 
				     <th style='width:200px;'>Berlaku S.d.</th> 
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
				     	echo "<td class='$sel'>".DateStr($show['TGLAKMSPST'])."</td>";
				     	echo "</tr>";
				     	$no++;
					}
				} else {
			 		echo "<td colspan='3' align='center' style='color:red;'>".$msg_data_empty."</td>";
				}
			    echo "</table><br></center>";
			} else {
?>
				<form name="form1" action="./?page=prodi" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
				<input type="hidden" size="2" maxlength="2" name="edtID" value="<?php echo $edtID; ?>" />
				<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				<th colspan="4">Form <?php echo $HeaderTitle; ?> Data Program Studi</th>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>	
				<tr><td width="35%">Kode Program Studi</td>
				  <td colspan="3" class="mandatory">: <input size="5" type="text" name="edtKode" id="edtKode" maxlength="5" value="<?php echo $edtKode; ?>"></td>
				</tr>	      
				<tr><td width="35%">Kode Dikti Program Studi</td>
				  <td colspan="3" class="mandatory">: <?php LoadProdiDikti_x("cbProdi","$cbProdi"); ?>			
				  </td>
				</tr>	      
				<tr>
				    <td>Nama Program Studi yang Digunakan di Masing-masing PT.</td>
				    <td colspan="3">
					: 
					<input size="40" type="text" name="edtNama" id="edtNama" maxlength="40" value="<?php echo $edtNama; ?>">&nbsp;&nbsp;&nbsp;Jenjang Studi&nbsp;&nbsp;:&nbsp;
				    <?php LoadKode_X("cbJenjang","$cbJenjang","04") ?></td>
			    </tr>
				<tr>
				    <td>Fakultas : </td>
				    <td colspan="3">:
					<?php LoadFakultas_X("cbFakultas","$cbFakultas") ?></td>
			    </tr>
				<tr>
				    <td>Telepon</td>
				    <td colspan="3">
					: 
					<input size="20" type="text" name="edtTelp" id="edtTelp" maxlength="20" value="<?php echo $edtTelp; ?>"></td>
			    </tr>
				<tr>
				    <td>Fax.</td>
				    <td colspan="3">
					: 
					<input size="20" type="text" name="edtFax" id="edtFax" maxlength="20" value="<?php echo $edtFax; ?>"></td>
			    </tr>
				<tr>
				    <td>Email</td>
					<td colspan="3">
					: 
					<input size="40" type="text" name="edtEmail" id="edtEmail" maxlength="40" value="<?php echo $edtEmail; ?>"></td>
			    </tr>
				<tr>
				    <td>Mulai Berdiri</td>
				    <td colspan="3">
					: 
					<input type="text" name="edtBerdiri" size="10"  maxlength="10" value="<?php echo DateStr($edtBerdiri); ?>" />
					<a href="javascript:show_calendar('document.form1.edtBerdiri','document.form1.edtBerdiri',document.form1.edtBerdiri.value);"> <img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy </td>
			    </tr>
				<tr>
				    <td>Jumlah SKS Kelulusan </td>
				    <td colspan="3">: 
			        <input type="text" name="edtSKS" id="edtSKS" size="3"  maxlength="3" value="<?php echo $edtSKS; ?>" /></td>
				</tr>
				<tr>
				    <td>Status Program Studi</td>
				    <td colspan="3" class="mandatory">: 
					<?php LoadKode_X("cbStatus","$cbStatus","14")?>
				    </td>
				</tr>
				<tr>
				    <td>Tahun Semester Mulai Hapus </td>
				    <td colspan="3" class="mandatory">: 
					<input size="4" type="text" name="edtTahun" id="edtTahun" maxlength="40" value="<?php echo $edtTahun; ?>">
					<select name="cbSemester">
			<?php
			     	if ($cbSemester=='') $sel0="selected='selected'";
			     	if ($cbSemester=='1') $sel1="selected='selected'";
			     	if ($cbSemester=='2') $sel2="selected='selected'";
			     	echo "<option value='' $sel0 >--- Semester ---</option>";
			     	echo "<option value='1' $sel1 >GASAL</option>";
			     	echo "<option value='2' $sel2 >GENAP</option>";
			?>
					</select>
					&nbsp;<span style='font-size:10px; font-weight:normal;'>Diisi Apabila Program Studi berstatus Hapus</span>
				    </td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
				    <td>Frekuensi Pemutakhiran Kurikulum </td>
				    <td colspan="3" class="mandatory">: 
					<?php LoadKode_X("cbFrekuensi","$cbFrekuensi","29")?>
				    </td>
				</tr>
				<tr>
				    <td>Pelaksanaan Pemutakhiran Kurikulum</td>
				    <td colspan="3" class="mandatory">: 
					<?php LoadKode_X("cbPelaksanaan","$cbPelaksanaan","30")?>
				    </td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
				    <td>Ka. Program Studi</td>
				    <td colspan="3" class="mandatory">: 
					<input size="40" type="text" name="edtKaProdi" id="edtKaProdi" maxlength="40" value="<?php echo $edtKaProdi; ?>" >
				    </td>
				</tr>
				<tr>
				    <td>NIDN Ka. Program Studi</td>
				    <td colspan="3" class="mandatory">: 
					<input size="10" type="text" name="edtNIDN" id="edtNIDN" maxlength="10" value="<?php echo $edtNIDN; ?>" >
				    </td>
				</tr>
				<tr>
				    <td>Telp./HP. Ka Program Studi</td>
				    <td colspan="3" class="mandatory">: 
					<input size="20" type="text" name="edtHP" id="edtHP" maxlength="20" value="<?php echo $edtHP; ?>" >
				    </td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
				    <td>Operator</td>
				    <td colspan="3" class="mandatory">: 
					<input size="40" type="text" name="edtOperator" id="edtOperator" maxlength="40" value="<?php echo $edtOperator; ?>" >
				    </td>
				</tr>
				<tr>
				    <td>Telp./HP. Operator</td>
				    <td colspan="3" class="mandatory">: 
					<input size="20" type="text" name="edtHP1" id="edtHP1" maxlength="20" value="<?php echo $edtHP1; ?>" >
				    </td>
			  	</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
					<td colspan="4" align="center"><button type="button" onClick=window.location.href="./?page=prodi" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
		        <button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
					</td>
			    </tr>
				<tr><td colspan="4" align="center">&nbsp;</td></tr>
				</table>
				</form>
<?php
			}
		}

		if (($_GET['p']=='edit') || isset($_GET['sub']) ) {
			$pst=$_GET['id'];
			if (isset($_GET['pst'])) $pst=$_GET['pst'];
			if (($_GET['sub']=='akreditasi') && ($_GET['act']!='delete') ) {
				/*** Tampilkan Form Akreditasi ****/
				$pst=$_GET['pst'];
				include "akreditasi.php";
			}
			if (($_GET['sub']=='sk_dikti') && ($_GET['act']!='delete') ) {
				/*** Tampilkan Form SK dari Dikti ****/
				$pst=$_GET['pst'];
				include "skprodi.php";
			}
			/********** Riwayat Status Akreditasi ********************/
			echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	 		echo "<tr><td colspan='6'><button type=\"button\" style='tar' onClick=window.location.href='./?page=prodi&amp;sub=akreditasi&amp;act=add&amp;pst=$pst'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
			echo "<tr><th colspan='6' style='background-color:#EEE'>Riwayat Akreditasi</th></tr>";
			echo "<tr>
			     <th style='width:150px;'>Status Akreditasi</th> 
			     <th style='width:150px;'>Nomor SK Akreditasi</th> 
			     <th style='width:150px;'>Tanggal SK Akreditasi</th> 
			     <th style='width:150px;'>Berlaku S.d.</th> 
			     <th colspan='2' style='width:20px;'>ACT</th> 
			     </tr>";
			$MySQL->Select("akpstupy.*,tbkodupy.NMKODTBKOD","akpstupy","LEFT OUTER JOIN tbkodupy ON akpstupy.KDSTAMSPST=tbkodupy.KDKODTBKOD where KDAPLTBKOD='07' AND IDPSTMSPST='".$pst."'","TGLBAMSPST DESC","","0");
			if ($MySQL->Num_Rows() > 0){
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tac'>".$show['NMKODTBKOD']."</td>";
			     	echo "<td class='$sel'>".$show['NOMBAMSPST']."</td>";
			     	echo "<td class='$sel tac'>".DateStr($show['TGLBAMSPST'])."</td>";
			     	echo "<td class='$sel'>".DateStr($show['TGLABMSPST'])."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=prodi&amp;sub=akreditasi&amp;act=edit&amp;pst=$pst&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=prodi&amp;sub=akreditasi&amp;act=delete&amp;pst=$pst&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;	     	
		     	}
			} else {
		 		echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";
			}
		    echo "</table>";
			
			/********** Riwayat SK Penetapan Program Studi ********************/
			echo "<br>";
			echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	 		echo "<tr><td colspan='5'><button type=\"button\" style='tar' onClick=window.location.href='./?page=prodi&amp;sub=sk_dikti&amp;act=add&amp;pst=$pst'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";			
			echo "<tr><th colspan='5' style='background-color:#EEE'>Riwayat Surat Keputusan Dikti</th></tr>";
			echo "<tr>
			     <th style='width:200px;'>Nomor SK Dikti</th> 
			     <th style='width:200px;'>Tanggal SK Dikti</th> 
			     <th style='width:200px;'>Berlaku S.d.</th> 
			     <th colspan='2' style='width:20px;'>ACT</th> 
			     </tr>";
			$MySQL->Select("*","skpstupy","where IDPSTMSPST='".$pst."'","TGLSKMSPST DESC","","0");
			if ($MySQL->Num_Rows() > 0){
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel'>".$show['NOMSKMSPST']."</td>";
			     	echo "<td class='$sel tac'>".DateStr($show['TGLSKMSPST'])."</td>";
			     	echo "<td class='$sel'>".DateStr($show['TGLAKMSPST'])."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=prodi&amp;sub=sk_dikti&amp;act=edit&amp;pst=$pst&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=prodi&amp;sub=sk_dikti&amp;act=delete&amp;pst=$pst&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;
				}
			} else {
		 		echo "<td colspan='5' align='center' style='color:red;'>".$msg_data_empty."</td>";
			}
		    echo "</table>";
		}				 		    
	} else {
		/***** Default Tampilan ***********/
		if (!isset($_GET['pos'])) $_GET['pos']=1;
		$page=$_GET['page'];
		$p=$_GET['p'];
		$sel="";
		$field=$_REQUEST['field'];
		if (!isset($_REQUEST['limit'])){
			$_REQUEST['limit']="20";
		}
		if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
		
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<form action='./?page=prodi' method='post' >";
		echo "<tr><td colspan='5'>Pencarian Berdasarkan : <select name='field'>";
		if ($field=='IDPSTMSPST') $sel1="selected='selected'";
		if ($field=='NMPSTMSPST') $sel2="selected='selected'";
		if ($field=='NMFAKMSFAK') $sel3="selected='selected'";
		
		echo "<option value='IDPSTMSPST' $sel1 >KODE</option>";
		echo "<option value='NMPSTMSPST' $sel2 >PROGRAM STUDI</option>";
		echo "<option value='NMFAKMSFAK' $sel3 >FAKULTAS</option>";
		 
		echo "</select>";
		echo "<input type='text' name='key' size='50' value='".$_REQUEST['key']."'/>\n";
		echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "<td align='right' colspan='4'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=prodi'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
		echo "</td></tr></form>";
		 
			/***** Default Tampilan **************/
		echo "<tr><td colspan='9' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=prodi&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
		echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR PROGRAM STUDI</th></tr>";
		echo "<tr>
				<th style='width:20px;'>KODE</th>
				<th style='width:150px;'>PROGRAM STUDI</th>
				<th style='width:5px;'>JENJANG</th>
				<th style='width:150px;'>FAKULTAS</th>
				<th style='width:50px;'>TELP.</th>
				<th style='width:150px;'>KA. PRODI</th>
				<th style='width:50px;'>STATUS</th>
				<th colspan='2' style='width:20px;'>ACT</th></tr>";
		
		$qry="LEFT OUTER JOIN msfakupy ON (mspstupy.KDFAKMSPST = msfakupy.KDFAKMSFAK) ";
  		$qry .= "LEFT OUTER JOIN tbkodupy ON (mspstupy.STATUMSPST = tbkodupy.KDKODTBKOD) ";
		$qry .= "WHERE tbkodupy.KDAPLTBKOD = '14' ";
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
	  		$qry .= " and ".$field." like '%".$key."%'";			
		}
		
		$MySQL->Select("*","mspstupy",$qry,"","");
		$total=$MySQL->Num_Rows();
		$perpage=$_REQUEST['limit'];
		$totalpage=ceil($total/$perpage);
		$start=($_GET['pos']-1)*$perpage;
		
		$MySQL->Select("mspstupy.IDX,mspstupy.IDPSTMSPST,mspstupy.NMPSTMSPST,mspstupy.NMJENMSPST,msfakupy.NMFAKMSFAK,mspstupy.TELPOMSPST,mspstupy.KAPSTMSPST,tbkodupy.NMKODTBKOD","mspstupy",$qry,"KDFAKMSPST ASC,IDPSTMSPST ASC","$start,$perpage","0");
		if ($MySQL->num_rows() > 0){
			$no=1;
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$sel="";
				if ($no % 2 == 1) $sel="sel";     	
				echo "<tr>";
		     	echo "<td class='$sel tac'>".$show['IDPSTMSPST']."</td>";
		     	echo "<td class='$sel'>".$show['NMPSTMSPST']."</td>";
		     	echo "<td class='$sel tac'>".$show['NMJENMSPST']."</td>";
		     	echo "<td class='$sel'>".$show['NMFAKMSFAK']."</td>";
		     	echo "<td class='$sel'>".$show['TELPOMSPST']."</td>";
		     	echo "<td class='$sel'>".$show['KAPSTMSPST']."</td>";
		     	echo "<td class='$sel tac'>".$show['NMKODTBKOD']."</td>";
		     	echo "<td class='$sel tac'>";
		     	if ($akses_user[$i]==$show['IDPSTMSPST']) {
					echo "<a href='./?page=prodi&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=prodi&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
				} else {
					echo "<a href='./?page=prodi&amp;p=view&amp;id=".$show['IDX']."'><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<img border='0' src='images/ico_check.png' title='DEFAULT'/>";
				}
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
		     	$i++;
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

