<?php
$idpage='10';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user=GetLevelUser($id_admin);
	$akses_user=GetAksesUser($id_admin);
	$action = UpdateData($id_group);
	$page=$_GET['page'];
	$URLa="page=".$page;		
	/*************** Simpan Data ****************/
	$such=0;
	if (isset($_POST['submit'])){
		if ($action) {
			$edtKode=substr(strip_tags($_POST['edtKode']),0,2);
			$edtNama=substr(strip_tags($_POST['edtNama']),0,50);
			$edtAlamat1=substr(strip_tags($_POST['edtAlamat1']),0,30);
			$edtAlamat2=substr(strip_tags($_POST['edtAlamat2']),0,30);
			$edtKota=substr(strip_tags($_POST['edtKota']),0,20);
			$edtKodePos=substr(strip_tags($_POST['edtKodePos']),0,5);
			$edtTelp=substr(strip_tags($_POST['edtTelp']),0,20);
			$edtFax=substr(strip_tags($_POST['edtFax']),0,20);
			$edtEmail=substr(strip_tags($_POST['edtEmail']),0,40);
			$edtWeb=substr(strip_tags($_POST['edtWeb']),0,40);
			$edtBerdiri=substr(strip_tags($_POST['edtBerdiri']),0,10);
			$edtBerdiri=@explode("-",$edtBerdiri);
			$edtBerdiri=$edtBerdiri[2]."-".$edtBerdiri[1]."-".$edtBerdiri[0];
			$edtDekan=substr(strip_tags($_POST['edtDekan']),0,40);
			$edtNoDekan=substr(strip_tags($_POST['edtNoDekan']),0,10);
			$edtPemDekan1=substr(strip_tags($_POST['edtPemDekan1']),0,40);
			$edtNoPemDekan1=substr(strip_tags($_POST['edtNoPemDekan1']),0,10);
			$edtPemDekan2=substr(strip_tags($_POST['edtPemDekan2']),0,40);
			$edtNoPemDekan2=substr(strip_tags($_POST['edtNoPemDekan2']),0,10);
			$edtPemDekan3=substr(strip_tags($_POST['edtPemDekan3']),0,40);
			$edtNoPemDekan3=substr(strip_tags($_POST['edtNoPemDekan3']),0,10);
			if ($_POST['chkStatus']=='on'){
				$chkStatus='0';
			} else {
				$chkStatus='1';		
			}
			if ($_POST['submit']=='Simpan'){
				if ($level_user = '0') {
					$MySQL->Insert("msfakupy","KDFAKMSFAK,NMFAKMSFAK,ALMT1MSFAK,ALMT2MSFAK,KOTAAMSFAK,KDPOSMSFAK,TELPOMSFAK,FAKSIMSFAK,EMAILMSFAK,HPAGEMSFAK,TGAWLMSFAK,STATUMSFAK,DEKANMSFAK,NODKNMSFAK,PDKN1MSFAK,NDKN1MSFAK,PDKN2MSFAK,NDKN2MSFAK,PDKN3MSFAK,NDKN3MSFAK","'$edtKode','$edtNama','$edtAlamat1','$edtAlamat2','$edtKota','$edtKodePos','$edtTelp','$edtFax','$edtEmail','$edtWeb','$edtBerdiri','$chkStatus','$edtDekan','$edtNoDekan','$edtPemDekan1','$edtNoPemDekan1','$edtPemDekan2','$edtNoPemDekan2','$edtPemDekan3','$edtNoPemDekan3'");
					$msg=$msg_insert_data ;
			    	$act_log = "Tambah Data Pada Tabel 'msfakupy' File 'fakultas.php' ";
			    }
			} else {
				$edtID=substr(strip_tags($_POST['edtID']),0,2);
				if ($level_user <= '1') {
					$oke='1';
					if ($level_user == '1') {
						if (AddEditDel($akses_user,$edtID)) {
							$oke='1';
						} else {
							$oke='0';
						}
					}
				}
				if ($oke=='1') {
					$MySQL->Update("msfakupy","KDFAKMSFAK='$edtKode',NMFAKMSFAK='$edtNama',ALMT1MSFAK='$edtAlamat1',ALMT2MSFAK='$edtAlamat2',KOTAAMSFAK='$edtKota',KDPOSMSFAK='$edtKodePos',TELPOMSFAK='$edtTelp',FAKSIMSFAK='$edtFax',EMAILMSFAK='$edtEmail',HPAGEMSFAK='$edtWeb',TGAWLMSFAK='$edtBerdiri',STATUMSFAK='$chkStatus',DEKANMSFAK='$edtDekan',NODKNMSFAK='$edtNoDekan',PDKN1MSFAK='$edtPemDekan1',NDKN1MSFAK='$edtNoPemDekan1',PDKN2MSFAK='$edtPemDekan2',NDKN2MSFAK='$edtNoPemDekan2',PDKN3MSFAK='$edtPemDekan3',NDKN3MSFAK='$edtNoPemDekan3'","where IDX=".$edtID,"1");
					$msg=$msg_edit_data;
			    	$act_log = "Update ID='$edtID' Data Pada Tabel 'msfakupy' File 'fakultas.php' ";
				}
			}
			// perintah SQL berhasil dijalankan
		  	if ($MySQL->exe){
				$succ=1;
			}
		  	if ($succ==1){
		    	$act_log .=" Sukses!";
		    	AddLog($id_admin,$act_log);
		    	echo $msg;
		  	} else{
		   		$act_log .=" Gagal!";
		 		AddLog($id_admin,$act_log);
		    	echo $msg_update_0;
			}
		}
	}
		

	if (isset($_GET['p']) && $_GET['p']=='delete') {
		if ($action) {
			if ($level_user == '0') {
				$MySQL->Delete("msfakupy","where IDX=".$id,"1");
			    if ($MySQL->exe){
				    $act_log="Hapus ID='$id' Pada Tabel 'msfakupy' File 'fakultas.php' Sukses!";
				    AddLog($id_admin,$act_log);
				    echo $msg_delete_data;
				}
				else{
				   $act_log="Hapus ID='$id' Pada Tabel 'msfakupy' File 'fakultas.php' Gagal!";
				    AddLog($id_admin,$act_log);
				    echo $msg_delete_data_0;
				}
			}
		}
	}
	
	
	if (isset($_GET['p']) && (($_GET['p'] !='delete') && ($_GET['p']!='refresh'))) {
		$id=$_GET['id'];
		$MySQL->Select("*","msfakupy","where IDX='".$id."'","","1");
		$show=$MySQL->Fetch_Array();
		$edtKode=$show["KDFAKMSFAK"];
		$edtNama=$show["NMFAKMSFAK"];
		$edtAlamat1=$show["ALMT1MSFAK"];
		$edtAlamat2=$show["ALMT2MSFAK"];
		$edtKota=$show["KOTAAMSFAK"];
		$edtKodePos=$show["KDPOSMSFAK"];
		$edtTelp=$show["TELPOMSFAK"];
		$edtFax=$show["FAKSIMSFAK"];
		$edtEmail=$show["EMAILMSFAK"];
		$edtWeb=$show["HPAGEMSFAK"];
		$edtBerdiri=$show["TGAWLMSFAK"];
		$chkStatus=$show["STATUMSFAK"];
		$checkstr='';
		if ($chkStatus=='0'){
			$checkstr='checked';
		}
		$edtDekan=$show["DEKANMSFAK"];
		$edtNoDekan=$show["NODKNMSFAK"];
		$edtPemDekan1=$show["PDKN1MSFAK"];
		$edtNoPemDekan1=$show["NDKN1MSFAK"];
		$edtPemDekan2=$show["PDKN2MSFAK"];
		$edtNoPemDekan2=$show["NDKN2MSFAK"];
		$edtPemDekan3=$show["PDKN3MSFAK"];
		$edtNoPemDekan3=$show["NDKN3MSFAK"];
		if ($_GET['p']=='view') {
?>
			<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan="4">DATA FAKULTAS</th></tr>
			<tr><th colspan="4">&nbsp;</th></tr>
			<tr><td>Kode Fakultas</td><td colspan="2">: <?php echo $edtKode; ?></td>
				<td>&nbsp;</td>
			</tr>	      
			<tr>
				<td>Nama Fakultas</td><td colspan="3">: <?php echo $edtNama; ?></td>
			</tr>
			<tr>
				<td>Alamat</td><td colspan="3">: <?php echo $edtAlamat1; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td><td colspan="3">&nbsp;&nbsp;<?php echo $edtAlamat2; ?></td>
			</tr>
			<tr>
				<td width="27%">Kota</td><td width="34%">: <?php echo $edtKota; ?></td>
				<td width="11%">Kode Pos</td><td width="28%">: <?php echo $edtKodePos; ?></td>
			</tr>
			<tr>
				<td>Telepon</td><td colspan="3">: <?php echo $edtTelp; ?></td>
			</tr>
			<tr>
				<td>Fax.</td><td colspan="3">: <?php echo $edtFax; ?></td>
			</tr>
			<tr>
				<td>Email</td><td colspan="3">: <?php echo $edtEmail; ?></td>
			</tr>
			<tr>
				<td>Website</td><td colspan="3">: <?php echo $edtWeb; ?></td>
			</tr>
			<tr>
				<td>Awal Berdiri</td><td colspan="3">: <?php echo DateStr($edtBerdiri); ?></td>
		    </tr>
			<tr>
				<td colspan="4" align="center">&nbsp;</td></tr>
			<tr>
			<tr>
				<td colspan="4" class='fwb'>Pejabat Dekan</td>
		    </tr>
			<tr>
				<td>Dekan Fakultas</td><td>: <?php echo $edtDekan; ?></td>
				<td>NIDN</td><td>: <?php echo $edtNoDekan; ?></td>
		    </tr>
			<tr>
				<td>Pembantu Dekan I.</td><td>: <?php echo $edtPemDekan1; ?></td>
				<td>NIDN</td><td>: <?php echo $edtNoPemDekan1; ?></td>
		    </tr>
			<tr>
				<td>Pembantu Dekan II.</td><td>: <?php echo $edtPemDekan2; ?></td>
				<td>NIDN</td><td>: <?php echo $edtNoPemDekan2; ?></td>
		    </tr>
			<tr>
				<td>Pembantu Dekan III.</td><td>: <?php echo $edtPemDekan3; ?></td>
				<td>NIDN</td><td>: <?php echo $edtNoPemDekan3; ?></td>
		    </tr>
			<tr>
				<td colspan="4" align="center">&nbsp;</td></tr>
			<tr>
				<td colspan="4" align="center">
		        <button type="button" onClick=window.location.href="./?page=<? echo $page; ?>" /><img src="images/b_back.png" class="btn_img">&nbsp;Kembali</button></td>
		    </tr>      
			</table>
			<br>
<?php
		} else {
			if ($action) {
				if ($level_user <= '1') {
					$oke='1';
					if ($level_user == '1') {
						if (AddEditDel($akses_user,$id)) {
							$oke='1';							
						} else {
							$oke='0';
						}
					}
					$submited="Update";
					$form_header="EDIT";
					if ($_GET['p']=='add') {
						if ($level_user == '1') {
							$oke='0';
						}
						$edtKode="";
						$edtNama="";
						$edtAlamat1="";
						$edtAlamat2="";
						$edtKota="";
						$edtKodePos="";
						$edtTelp="";
						$edtFax="";
						$edtEmail="";
						$edtWeb="";
						$edtBerdiri="";
						$chkStatus="";
						$checkstr="";
						$submited="Simpan";
						$form_header="TAMBAH";
					}
					
					if ($oke=='1') {
?>
						<form name="form1" action="./?page=<?php echo $page; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
						<input type="hidden" size="2" maxlength="2" name="edtID" value="<?php echo $id ?>" />			  <table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
						<tr><th colspan="4">FORM <?php echo $form_header; ?> DATA FAKULTAS</th></tr>
						<tr><th colspan="4">&nbsp;</th></tr>
						<tr><td>Kode Fakultas</td>
							<td colspan="2" class="mandatory">: <input size="2" type="text" name="edtKode" id="edtKode" maxlength="2" value="<?php echo $edtKode; ?>"></td>
							<td><input type="checkbox" name="chkStatus" <?php echo $checkstr; ?>>Tidak Aktif</td>
						</tr>	      
						<tr>
							<td>Nama Fakultas</td>
							<td colspan="3" class="mandatory">: 
							<input size="50" type="text" name="edtNama" id="edtNama" maxlength="50" value="<?php echo $edtNama; ?>"></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td colspan="3">:
							<input size="30" type="text" name="edtAlamat1" maxlength="30" value="<?php echo $edtAlamat1; ?>"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="3">&nbsp;
							<input class="inputbox" size="30" type="text" name="edtAlamat2" maxlength="30" value="<?php echo $edtAlamat2; ?>"></td>
						</tr>
						<tr>
							<td width="27%">Kota</td>
							<td width="34%">:
							<input size="20" type="text" name="edtKota" maxlength="20" value="<?php echo $edtKota; ?>"></td>
							<td width="8%">Kode Pos</td>
							<td width="28%">: 
						    <input class="inputbox" size="5" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>"></td>
						</tr>
						<tr>
							<td>Telepon</td>
							<td colspan="3">: 
							<input size="20" type="text" name="edtTelp" maxlength="20" value="<?php echo $edtTelp; ?>"></td>
						</tr>
						<tr>
							<td>Fax.</td>
							<td colspan="3">: 
							<input size="20" type="text" name="edtFax" maxlength="20" value="<?php echo $edtFax; ?>"></td>
						</tr>
						<tr>
							<td>Email</td>
							<td colspan="3">: 
							<input size="40" type="text" name="edtEmail" maxlength="40" value="<?php echo $edtEmail; ?>"></td>
						</tr>
						<tr>
							<td>Website</td>
							<td colspan="3">: 
							<input size="40" type="text" name="edtWeb" maxlength="40" value="<?php echo $edtWeb; ?>"></td>
						</tr>
						<tr>
							<td>Awal Berdiri</td>
							<td colspan="3">: 
							<input type="text" name="edtBerdiri" size="10"  maxlength="10" value="<?php echo DateStr($edtBerdiri); ?>"/> 
					<a href="javascript:show_calendar('document.form1.edtBerdiri','document.form1.edtBerdiri',document.form1.edtBerdiri.value);">
					<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy</td>
					    </tr>
						<tr><td colspan="4" align="center">&nbsp;</td></tr>
						<tr>
							<td colspan="4" class='fwb'>Pejabat Dekan</td>
						</tr>
						<tr>
							<td>Dekan Fakultas</td><td>: 
							<input size="40" type="text" name="edtDekan" maxlength="40" value="<?php echo $edtDekan; ?>"></td>
							<td>NIDN</td><td>: 
							<input size="10" type="text" name="edtNoDekan" maxlength="10" value="<?php echo $edtNoDekan; ?>"></td>
						</tr>
						<tr>
							<td>Pembantu Dekan I.</td><td>: 
							<input size="40" type="text" name="edtPemDekan1" maxlength="40" value="<?php echo $edtPemDekan1; ?>"></td>
							<td>NIDN</td><td>: 
							<input size="10" type="text" name="edtNoPemDekan1" maxlength="10" value="<?php echo $edtNoPemDekan1; ?>"></td>
						</tr>
						<tr>
							<td>Pembantu Dekan II.</td><td>: 
							<input size="40" type="text" name="edtPemDekan2" maxlength="40" value="<?php echo $edtPemDekan2; ?>"></td>
							<td>NIDN</td><td>: 
							<input size="10" type="text" name="edtNoPemDekan2" maxlength="10" value="<?php echo $edtNoPemDekan2; ?>"></td>
						</tr>
						<tr>
							<td>Pembantu Dekan III.</td><td>: 
							<input size="40" type="text" name="edtPemDekan3" maxlength="40" value="<?php echo $edtPemDekan3; ?>"></td>
							<td>NIDN</td><td>: 
							<input size="10" type="text" name="edtNoPemDekan3" maxlength="10" value="<?php echo $edtNoPemDekan3; ?>"></td>
						</tr>
						<tr><td colspan="4" align="center">&nbsp;</td></tr>
						<tr>
							<td colspan="4" align="center">
					        <button type="button" onClick=window.location.href="./?page=<? echo $page; ?>" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
					        <button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
							</td>
					    </tr>      
						</table>
						</form>
						<br>
<?php
					} else {
						include "./content/sba/fakultas.php";
					}
				} else {
					include "./content/direktorat/fakultas.php";
				}
			} else {
				include "./content/direktorat/fakultas.php";
			}
		}
	} else {
		/*********** Tampilan Utama ***************/
		switch ($id_group) {
			case '0'  : include "./content/admin/fakultas.php";
						break;
			case '1'  : include "./content/admin/fakultas.php";
						break;
			case '2'  : include "./content/direktorat/fakultas.php";
						break;
			case '3'  : include "./content/direktorat/fakultas.php";
						break;
			case '4'  : 
						if ($level_user == '0') { 
							include "./content/admin/fakultas.php";
						} elseif ($level_user == '1') {
							include "./content/sba/fakultas.php";
						} else {
							include "./content/direktorat/fakultas.php";
						}
						break;
			case '5'  : include "./content/direktorat/fakultas.php";
						break;
			case '6'  : include "./content/umum/fakultas.php";
						break;
			default   : include "./content/umum/fakultas.php";
			
		}
	}
}

function AddEditDel ($akses_user,$id) {
	global $MySQL;
	$MySQL->Select("KDFAKMSFAK","msfakupy","WHERE KDFAKMSFAK = '".$id."'","","1");
	$show=$MySQL->fetch_array();
	if ($show["KDFAKMSFAK"] == $akses_user) {
		return True;
	} else {
		return False;
	}
}
?>
