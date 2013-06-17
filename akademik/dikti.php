<?php
$idpage='9';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	/*** deklarasi variabel global ****/
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user= GetLevelUser($id_admin);
	$action= UpdateData($id_group);
	
	$succ=0;
	if ($_POST['submit']=='Update'){
		if ($action) {
			if ($level_user=='0') {
				$edtKode=substr(strip_tags($_POST['edtKode']),0,6);
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
				$edtRektor=substr(strip_tags($_POST['edtRektor']),0,40);
				$edtNoRektor=substr(strip_tags($_POST['edtNoRektor']),0,10);
				$edtPR1=substr(strip_tags($_POST['edtPR1']),0,40);
				$edtNoPR1=substr(strip_tags($_POST['edtNoPR1']),0,10);
				$edtPR2=substr(strip_tags($_POST['edtPR2']),0,40);
				$edtNoPR2=substr(strip_tags($_POST['edtNoPR2']),0,10);
				$edtPR3=substr(strip_tags($_POST['edtPR3']),0,40);
				$edtNoPR3=substr(strip_tags($_POST['edtNoPR3']),0,10);				
				$MySQL->Update("msptiupy","KDPTIMSPTI='$edtKode',NMPTIMSPTI='$edtNama', ALMT1MSPTI='$edtAlamat1', ALMT2MSPTI='$edtAlamat2',KOTAAMSPTI='$edtKota', KDPOSMSPTI='$edtKodePos', TELPOMSPTI='$edtTelp', FAKSIMSPTI='$edtFax',EMAILMSPTI='$edtEmail', HPAGEMSPTI='$edtWeb',TGAWLMSPTI='$edtBerdiri',NMRETMSPTI='$edtRektor',NORETMSPTI='$edtNoRektor',NMPR1MSPTI='$edtPR1',NOPR1MSPTI='$edtNoPR1',NMPR2MSPTI='$edtPR2',NOPR2MSPTI='$edtNoPR2',NMPR3MSPTI='$edtPR3',NOPR3MSPTI='$edtNoPR3'","","1");
				if ($MySQL->exe){
			    	$succ=1;
				}
				if ($succ==1){
					$act_log="Update Kode='$edtKode' Pada Tabel 'msptiupy' File 'dikti.php' Sukses";
					AddLog($id_admin,$act_log);
					echo $msg_edit_data;
				} else {
					$act_log="Update Kode='$edtKode' Pada Tabel 'msptiupy' File 'dikti.php' Gagal";
					AddLog($id_admin,$act_log);
					echo $msg_update_0;
				}
			}
		}
	} 
	
	
	if (isset($_POST['submit_1'])) {
		if ($action) {
			if ($level_user=='0') {
				$edtSKPT=substr(strip_tags($_POST['edtSKPT']),0,30);
				$edtTglSK=substr(strip_tags($_POST['edtTglSK']),0,10);
				$edtTglSK=@explode("-",$edtTglSK);
				$edtTglSK=$edtTglSK[2]."-".$edtTglSK[1]."-".$edtTglSK[0];		
				if ($_POST['submit_1'] == 'simpan') {
					$edtIdPT=substr(strip_tags($_POST['edtIdPT']),0,1);
				  	$MySQL->Insert("tbskptupy","NOMSKMSPTI,TGPTIMSPTI,IDXPTMSPTI","'$edtSKPT','$edtTglSK','$edtIdPT'");
				  	if ($MySQL->exe){
				    	$succ=1; 
				  	}
				  	if ($succ==1){
				  		$act_log="Tambah Data Pada Tabel 'tbskptupy' File 'dikti.php' Sukses";
				    	AddLog($id_admin,$act_log);
				    	echo $msg_insert_data;
			  	  	} else {
			   			$act_log="Tambah Data Pada Tabel 'tbskptupy' File 'dikti.php' Gagal";
				 		AddLog($id_admin,$act_log);
				 		echo $msg_update_0;
				  	}
				} else {
					$edtID=substr(strip_tags($_POST['edtID']),0,5);
				  	$MySQL->Update("tbskptupy","NOMSKMSPTI='$edtSKPT',TGPTIMSPTI='$edtTglSK'","where IDX='$edtID'");
				  	if ($MySQL->exe){
				    	$succ=1; 
				  	}
				  	if ($succ==1){
				  		$act_log="Update ID='$edtID' Pada Tabel 'tbskptupy' File 'dikti.php' Sukses";
				    	AddLog($id_admin,$act_log);
				    	echo $msg_edit_data;
			  	  	} else {
			   			$act_log="Update ID='$edtID' Pada Tabel 'tbskptupy' File 'dikti.php' Gagal";
				 		AddLog($id_admin,$act_log);
				 		echo $msg_update_0;
				  	}
				}
			}
		}
	}

	if (isset($_GET['p']) && ($_GET['p'] == 'delete')) {
		if ($action) {
			if ($level_user=='0') {
				$id=$_GET['id'];
				$MySQL->Delete("tbskptupy","where IDX='".$id."'");
			    if ($MySQL->exe){
					$act_log="Hapus ID='$id' Pada Tabel 'tbskptupy' File 'dikti.php' Sukses";
					AddLog($id_admin,$act_log);
					echo $msg_delete_data;
				} else {
					$act_log="Hapus ID='$id' Pada Tabel 'tbskptupy' File 'dikti.php' Gagal";
					AddLog($id_admin,$act_log);
					echo $msg_delete_data_0;
				}
			}
		}
	}

	$MySQL->Select("*","msptiupy","","","1");
	$show=$MySQL->Fetch_Array();
	$edtIdPT=$show["IDX"];
	$edtKode=$show["KDPTIMSPTI"];
	$edtNama=$show["NMPTIMSPTI"];
	$edtAlamat1=$show["ALMT1MSPTI"];
	$edtAlamat2=$show["ALMT2MSPTI"];
	$edtKota=$show["KOTAAMSPTI"];
	$edtKodePos=$show["KDPOSMSPTI"];
	$edtTelp=$show["TELPOMSPTI"];
	$edtFax=$show["FAKSIMSPTI"];
	$edtEmail=$show["EMAILMSPTI"];
	$edtWeb=$show["HPAGEMSPTI"];
	$edtBerdiri=$show["TGAWLMSPTI"];
	$edtRektor=$show["NMRETMSPTI"];
	$edtNoRektor=$show["NORETMSPTI"];
	$edtPR1=$show["NMPR1MSPTI"];
	$edtNoPR1=$show["NOPR1MSPTI"];
	$edtPR2=$show["NMPR2MSPTI"];
	$edtNoPR2=$show["NOPR2MSPTI"];
	$edtPR3=$show["NMPR3MSPTI"];
	$edtNoPR3=$show["NOPR3MSPTI"];

	if (isset($_GET['p']) &&  ($_GET['p'] != 'delete')) {
		if ($action) {
			if ($level_user=='0') {
				if ($_GET['p'] == 'add') {
				//Tampilkan Form Tambah SK Perguraun Tinggi	
?>
					<form name="form1" action="./?page=dikti" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
					<input type="hidden" name="edtIdPT" value="<?php echo $edtIdPT ?>" />
					<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
					<tr><th colspan="2">FORM TAMBAH DATA SK PERGURUAN TINGGI</th></tr>
					<tr><th colspan="2">&nbsp;</th></tr>
					<tr><td width="22%">No SK PT.</td>
						<td class="inputtext">: <input size="30" type="text" name="edtSKPT" maxlength="30"></td>
					</tr>
				    <tr>
					    <td>Tgl SK. Perguruan Tinggi</td>
					    <td colspan="3">: <input type="text" name="edtTglSK" size="10"  maxlength="10" /> 
				<a href="javascript:show_calendar('document.form1.edtTglSK','document.form1.edtTglSK',document.form1.edtTglSK.value);">
				<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
				    <tr>
					    <td colspan="2" align="center">
				            <button type="button" onClick=window.location.href="./?page=dikti" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
				            <button type="submit" name="submit_1" value="simpan" /><img src="images/b_save.gif" class="btn_img">&nbsp;Simpan</button>
				
						</td>
				    </tr>
					</table>
					</form>
					<br>
	<?php			
				} else {
					//Tampilkan Form Edit Badan Hukum
					$id=$_GET['id'];
					$MySQL->Select("*","tbskptupy","where IDX='".$id."'","","1");
					$show=$MySQL->Fetch_Array();
					$edtSKPT=$show["NOMSKMSPTI"];
					$edtTglSK=DateStr($show["TGPTIMSPTI"]);	
	?>
					<form name="form1" action="./?page=dikti" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
					<input type="hidden" name="edtID" value="<?php echo $id ?>" />	
					<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
					<tr>
					<th colspan="2">FORM EDIT DATA SK PERGURUAN TINGGI</th>
					</tr>
					<tr><th colspan="2">&nbsp;</th></tr>
					<tr><td width="22%">No SK PT.</td>
						<td class="inputtext">: <input size="30" type="text" name="edtSKPT" maxlength="30" value="<?php echo $edtSKPT ?>"></td>
					</tr>
				    <tr>
					    <td>Tgl SK. Perguruan Tinggi</td>
					    <td colspan="3">: <input type="text" name="edtTglSK" size="10"  maxlength="10" value="<?php echo $edtTglSK ?>" /> 
				<a href="javascript:show_calendar('document.form1.edtTglSK','document.form1.edtTglSK',document.form1.edtTglSK.value);">
				<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
						</td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
				    <tr>
					    <td colspan="2" align="center">
				            <button type="button" onClick=window.location.href="./?page=dikti" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
				            <button type="submit" name="submit_1" value="update" /><img src="images/b_save.gif" class="btn_img">&nbsp;Update</button>
						</td>
				    </tr>
					</table>
					</form>
					<br>			
<?php		
				}
			} else {
				include "./content/umum/dikti.php";
			}	
		} else {
			include "./content/umum/dikti.php";
		}
	} else {
	/************ Tampilan depan / default form ***********/
		switch ($id_group) {
			case '0' : 
				include "./content/admin/dikti.php";
				break;
			case '1' : 
				include "./content/admin/dikti.php";
				break;
			case '4' : 
				$level_user = GetLevelUser($id_admin);
				if ($level_user=='0') {
					include "./content/admin/dikti.php";
				} else {
					include "./content/umum/dikti.php";					
				}
				break;
			default : 
				include "./content/umum/dikti.php";					
		}
	}
}
?>
