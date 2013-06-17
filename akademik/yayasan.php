<?php
$idpage='8';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	/*** deklarasi variabel global ****/
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user=GetLevelUser($id_admin);
	$action = UpdateData($id_group);

	$page	= 'yayasan';
	$p		= "";
	if (isset($_GET['page'])) $page=$_GET['page'];
	if (isset($_GET['p'])) $p=$_GET['p'];
	
	$succ=0;
	if (isset($_POST['submit'])) {
		if ($action) {
			if ($level_user =='0') {
				if ($_POST['submit']=="Update") {
					$edtKode=substr(strip_tags($_POST['edtKode']),0,7);
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
				
					$MySQL->Update("msyysupy","KDYYSMSYYS='$edtKode',NMYYSMSYYS='$edtNama', ALMT1MSYYS='$edtAlamat1', ALMT2MSYYS='$edtAlamat2',KOTAAMSYYS='$edtKota', KDPOSMSYYS='$edtKodePos', TELPOMSYYS='$edtTelp', FAKSIMSYYS='$edtFax', EMAILMSYYS='$edtEmail', HPAGEMSYYS='$edtWeb', TGAWLMSYYS='$edtBerdiri'","","1");
					$act_log="Update Kode='$edtKode' Pada Tabel 'msyysupy' File 'yayasan.php'";
				    $msg = $msg_edit_data;
				}
					
				if (($_POST['submit'] == 'simpanbadanhukum') || ($_POST['submit'] == 'updatebadanhukum')) {
				/*********** simpan badan hukum ***************/
					$edtSKYys=substr(strip_tags($_POST['edtSKYys']),0,30);
					$edtTglSK=substr(strip_tags($_POST['edtTglSK']),0,10);
					$edtTglSK=@explode("-",$edtTglSK);
					$edtTglSK=$edtTglSK[2]."-".$edtTglSK[1]."-".$edtTglSK[0];
					$edtPNYys=substr(strip_tags($_POST['edtPNYys']),0,30);
					$edtTglPN=substr(strip_tags($_POST['edtTglPN']),0,10);
					$edtTglPN=@explode("-",$edtTglPN);
					$edtTglPN=$edtTglPN[2]."-".$edtTglPN[1]."-".$edtTglPN[0];
				
					if ($_POST['submit']=='simpanbadanhukum'){  
						$edtIdYys=substr(strip_tags($_POST['edtIdYys']),0,1);
				  		$MySQL->Insert("tbhkmupy","NOMSKMSYYS,TGYYSMSYYS,NOMBNMSYYS,TGLBNMSYYS,IDYYSMSYYS","'$edtSKYys','$edtTglSK','$edtPNYys','$edtTglPN','$edtIdYys'");
				  		$act_log="Tambah Data Pada Tabel 'tblhkmupy' File 'yayasan.php'";
				    	$msg = $msg_insert_data;
				  	} else {
						$edtID=substr(strip_tags($_POST['edtID']),0,5);
				  		$MySQL->Update("tbhkmupy","NOMSKMSYYS='$edtSKYys',TGYYSMSYYS='$edtTglSK',NOMBNMSYYS='$edtPNYys',TGLBNMSYYS='$edtTglPN'","where IDX='$edtID'");
				  		$act_log="Update ID='$edtID' Pada Tabel 'tblhkmupy' File 'yayasan.php'";
				    	$msg=$msg_edit_data;
					}
				}
				if ($MySQL->exe){
			   		$succ=1; 
				}
			 	if ($succ==1){
			 		$act_log .=" Sukses!";
			 		echo $msg;
		  	  	} else {
		   			$act_log .=" Gagal!";
			 		echo $msg_update_0;
			  	}		  	
		 		AddLog($id_admin,$act_log);
		 	}
	 	}
	} 

	if ($p == 'delete'){
		if ($action) {
			if ($level_user=='0') {
				$id=$_GET['id'];
		   		$MySQL->Delete("tbhkmupy","where IDX='".$id."'");
			    if ($MySQL->exe){
					$act_log="Hapus ID='$id' Pada Tabel 'tblhkmupy' File 'yayasan.php' Sukses";
					AddLog($id_admin,$act_log);
				    echo $msg_delete_data;
				} else {
					$act_log="Hapus ID='$id' Pada Tabel 'tblhkmupy' File 'yayasan.php' Gagal";
					AddLog($id_admin,$act_log);
				    echo $msg_delete_data_0;
				}
			}
		}
	}
	
	$MySQL->Select("*","msyysupy","","","1");
	$show=$MySQL->Fetch_Array();
	$edtIdYys=$show["IDX"];
	$edtKode=$show["KDYYSMSYYS"];
	$edtNama=$show["NMYYSMSYYS"];
	$edtAlamat1=$show["ALMT1MSYYS"];
	$edtAlamat2=$show["ALMT2MSYYS"];
	$edtKota=$show["KOTAAMSYYS"];
	$edtKodePos=$show["KDPOSMSYYS"];
	$edtTelp=$show["TELPOMSYYS"];
	$edtFax=$show["FAKSIMSYYS"];
	$edtEmail=$show["EMAILMSYYS"];
	$edtWeb=$show["HPAGEMSYYS"];
	$edtBerdiri=$show["TGAWLMSYYS"];
	
	if ($p == 'add') {
		if ($action) {
			if ($level_user=='0') {
				//Tampilkan Form Tambah Badan Hukum
?>
			<form name="form1" action="./?page=yayasan" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
				<input type="hidden" name="edtIdYys" value="<?php echo $edtIdYys ?>" />
				<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				<th colspan="2">Form Tambah Data Badan Hukum Yayasan</th>
				</tr>
				<tr><th colspan="2">&nbsp;</th></tr>
				<tr><td width="20%">No SK Yayasan.</td>
					<td class="inputtext">: <input size="30" type="text" name="edtSKYys" maxlength="30"></td>
				</tr>
		    	<tr>
			    	<td>Tgl SK. Yayasan</td>
			    	<td colspan="3">: <input type="text" name="edtTglSK" size="10"  maxlength="10" /> 
		<a href="javascript:show_calendar('document.form1.edtTglSK','document.form1.edtTglSK',document.form1.edtTglSK.value);">
		<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
					</td>
				</tr>
				<tr>
					<td>No. PN/Badan Hukum</td>
					<td>: <input size="30" type="text" name="edtPNYys" maxlength="30"></td>
				</tr>
			    <tr>
				    <td>Tgl PN/Badan Hukum</td>
				    <td>: 
					<input type="text" name="edtTglPN" size="10"  maxlength="10" /> 
			<a href="javascript:show_calendar('document.form1.edtTglPN','document.form1.edtTglPN',document.form1.edtTglPN.value);">
			<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
					</td>
				</tr>
				<tr><th colspan="2">&nbsp;</th></tr>
			    <tr>
				    <td colspan="2" align="center">
			            <button type="button" onClick=window.location.href="./?page=yayasan" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
						<button type="submit" name="submit" value="simpanbadanhukum"><img src="images/b_save.gif" class="btn_img"/> Simpan</button>
					</td>
			    </tr>
				</table>
				</form>
				<br>
<?php
			} else {
				include "./content/umum/yayasan.php";
			}
		} else {
			include "./content/umum/yayasan.php";					
		}
	} elseif ($p == 'edit') {
		if ($action) {
			if ($level_user=='0') {
				//Tampilkan Form Edit Badan Hukum
				$id=$_GET['id'];
				$MySQL->Select("*","tbhkmupy","where IDX='".$id."'","","1");
				$show=$MySQL->Fetch_Array();
				$edtSKYys=$show["NOMSKMSYYS"];
				$edtTglSK=DateStr($show["TGYYSMSYYS"]);
				$edtPNYys=$show["NOMBNMSYYS"];
				$edtTglPN=DateStr($show["TGLBNMSYYS"]);
	
?>	
				<form name="form1" action="./?page=yayasan" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
				<input type="hidden" name="edtID" value="<?php echo $id ?>" />	
				<table align="center" style="width:80%" border="0" cellpadding="1" cellspacing="1">
				<tr>
				<th colspan="2">Form Edit Data Badan Hukum Yayasan</th>
				</tr>
				<tr><th colspan="2">&nbsp;</th></tr>
				<tr><td width="20%">No SK Yayasan.</td>
					<td class="inputtext">: <input size="30" type="text" name="edtSKYys" maxlength="30" value="<?php echo $edtSKYys ?>"></td>
				</tr>
			    <tr>
				    <td>Tgl SK. Yayasan</td>
				    <td colspan="3">: <input type="text" name="edtTglSK" size="10"  maxlength="10" value="<?php echo $edtTglSK ?>" /> 
			<a href="javascript:show_calendar('document.form1.edtTglSK','document.form1.edtTglSK',document.form1.edtTglSK.value);">
			<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
					</td>
				</tr>
				<tr>
					<td>No. PN/Badan Hukum</td>
					<td>: <input size="30" type="text" name="edtPNYys" maxlength="30" value="<?php echo $edtPNYys ?>"></td>
				</tr>
			    <tr>
				    <td>Tgl PN/Badan Hukum</td>
				    <td>: 
					<input type="text" name="edtTglPN" size="10"  maxlength="10" value="<?php echo $edtTglPN ?>"/> 
			<a href="javascript:show_calendar('document.form1.edtTglPN','document.form1.edtTglPN',document.form1.edtTglPN.value);">
			<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
					</td>
				</tr>
				<tr><th colspan="2">&nbsp;</th></tr>
			    <tr>
				    <td colspan="2" align="center">
			            <button type="button" onClick=window.location.href="./?page=yayasan" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
					<button type="submit" name="submit" value="updatebadanhukum"><img src="images/b_save.gif" class="btn_img"/> Update</button>
					</td>
			    </tr>
				</table>
			</form>
			<br>
<?php
			} else {
				include "./content/umum/yayasan.php";					
			}
		} else {
			include "./content/umum/yayasan.php";					
		}
	} else {
		switch ($id_group) {
			case '0' : 
				include "./content/admin/yayasan.php";
				break;
			case '1' : 
				include "./content/admin/yayasan.php";
				break;
			case '4' : 
				$level_user = GetLevelUser($id_admin);
				if ($level_user=='0') {
					include "./content/admin/yayasan.php";
				} else {
					include "./content/umum/yayasan.php";					
				}
				break;
			default : 
				include "./content/umum/yayasan.php";					
		}
	}
}
?>
