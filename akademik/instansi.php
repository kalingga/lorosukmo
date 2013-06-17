<?php
//$id_page=$_SESSION[$PREFIX."70"];
//echo $id_page;
$idpage='0';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
}	
else{
	if (!isset($_GET['p'])) $_GET['p']='edit';
?>

<?php
if ($_GET['p']=='edit'){
$succ=0;
if (isset($_POST['submit'])){
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

  //$logo=substr(strip_tags($_POST['LG']),0,255);
  $last_logo=substr(strip_tags($_POST['last_logo']),0,255);
  $logo=$last_logo;
  $uploaddir = 'images/';
  $filename = basename($_FILES['logo']['name']);
  $uploadfile = $uploaddir . $filename;
  while(file_exists($uploadfile)){
	$i++;
	$ext=substr($filename,strpos($filename,"."),strlen($filename));
	$basename = substr($filename,0,strpos($filename,"."));
	$uploadfile = $uploaddir . $basename . $i . $ext;
  }
  $filesize=$_FILES['logo']['size'];
  if ($filesize>0 and $filesize<=1000000){
   if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile)) {
    $logo=$uploadfile;
    @unlink($last_logo);
   }
  }
  $MySQL->Update("msptiupy","KDPTIMSPTI='$edtKode',NMPTIMSPTI='$edtNama', ALMT1MSPTI='$edtAlamat1', ALMT2MSPTI='$edtAlamat2',KOTAAMSPTI='$edtKota', KDPOSMSPTI='$edtKodePos', TELPOMSPTI='$edtTelp', FAKSIMSPTI='$edtFax', EMAILMSPTI='$edtEmail', HPAGEMSPTI='$edtWeb', TGAWLMSPTI='$edtBerdiri', LGPTIMSPTI='$logo'","","1");
  if ($MySQL->exe){
    $succ=1; 
  }
  if ($succ==1){
    $act_log="Update Instansi Pada Tabel 'msptiupy' File 'instansi.php' Sukses";
    AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    echo $msg_edit_data;
  }
  else{
    $act_log="Update 'instansi' Pada Tabel 'mspti' File 'instansi.php' Gagal";
    AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    echo $msg_update_0;
  }
}

  $MySQL->Select("*","msptiupy","","","1");
  $show=$MySQL->Fetch_Array();
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
  $logo=$show["LGPTIMSPTI"];
?>
<form name="form1" action="./?page=instansi&amp;p=edit" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
	<tr>
	<th colspan="5">Form Update Data</th>
	</tr>
		    <tr><td>Kode PT.</td>
		    <td colspan="3" class="mandatory">
			: 
			<input style="width: 50px;" type="text" name="edtKode" id="edtKode"  maxlength="7" value="<?php echo $edtKode; ?>"></td>
		    <td rowspan="10" align="center" valign="top">
			<p><b>Logo Instansi</b><br>
			<img src="<?php echo $logo; ?>" height="100" width="100" border="1" /> </p>
		      <p>
                <input type="hidden" name="last_logo" value="<?php echo $logo; ?>" />
                <input type="file" name="logo" value="<?php echo $logo; ?>"/>
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
              </p></td>
	      </tr>
		  <tr>
		    <td>Perguruan Tinggi</td>
		    <td colspan="3" class="mandatory">
			: 
		    <input size="50" type="text" name="edtNama" id="edtNama" maxlength="50" value="<?php echo $edtNama; ?>"></td>
	      </tr>
		  <tr>
		    <td>Alamat</td>
		    <td colspan="3">:
			<input style="width: 200px;" type="text" name="edtAlamat1" maxlength="30" value="<?php echo $edtAlamat1; ?>"></td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td colspan="3">:
			<input class="inputbox" style="width: 200px;" type="text" name="edtAlamat2" maxlength="30" value="<?php echo $edtAlamat2; ?>"></td>
	      </tr>
		  <tr>
		    <td width="19%">Kota</td>
		    <td width="31%">:
			<input style="width: 150px;" type="text" name="edtKota" maxlength="20" value="<?php echo $edtKota; ?>"></td>
		    <td width="14%">Kode Pos</td>
		    <td width="31%">: 
	        <input class="inputbox" style="width: 40px;" type="text" name="edtKodePos" maxlength="5" value="<?php echo $edtKodePos; ?>"></td>
	      </tr>
		  <tr>
		    <td>Telepon</td>
		    <td colspan="3">
			: 
		    <input style="width: 150px;" type="text" name="edtTelp" maxlength="20" value="<?php echo $edtTelp; ?>"></td>
	      </tr>
		  <tr>
		    <td>Fax.</td>
		    <td colspan="3">
			: 
		    <input style="width: 150px;" type="text" name="edtFax" maxlength="20" value="<?php echo $edtFax; ?>"></td>
	      </tr>
		  <tr>
		    <td>Email</td>
			<td colspan="3">
			: 
		    <input style="width: 250px;" type="text" name="edtEmail" maxlength="40" value="<?php echo $edtEmail; ?>"></td>
	      </tr>
		  <tr>
		    <td>Website</td>
		    <td colspan="3">
			: 
		    <input style="width: 250px;" type="text" name="edtWeb" maxlength="40" value="<?php echo $edtWeb; ?>"></td>
	      </tr>
		  <tr>
		    <td>Awal Berdiri</td>
		    <td colspan="3">: 
<?php 
//  $edtBerdiri_arr=@explode("-",$edtBerdiri);
//  $edtBerdiri=$edtBerdiri_arr[2]."-".$edtBerdiri_arr[1]."-".$edtBerdiri_arr[0];
$edtBerdiri=DateStr($edtBerdiri);
?> 		    
			<input type="text" name="edtBerdiri" size="10"  maxlength="10" value="<?php echo $edtBerdiri; ?>"/> 
<a href="javascript:show_calendar('document.form1.edtBerdiri','document.form1.edtBerdiri',document.form1.edtBerdiri.value);">
<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
			</td>
      	</tr>
		  <tr>
		    <td colspan="5" align="center">
            <button type="button" onClick=window.location.href="./" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
       <button type="submit" name="submit"><img src="images/b_save.gif" class="btn_img"/> Update</button>
	   		</td>
      </tr>
	</table>
	</form>
<?php
}
?>
<?php
}
?>
