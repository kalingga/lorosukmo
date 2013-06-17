<?php
$idpage='6';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
$id_admin=$_SESSION[$PREFIX.'id_admin'];
$apl=$_GET['apl'];
$MySQL->Select("KETERTBAPL","tbaplupy","where KDAPLTBAPL='".$apl."'","","1","0");	
$show=$MySQL->Fetch_Array();
$aplikasi=$show[KETERTBAPL];
//************** Simpan Data ***********************
$succ=0;
if (isset($_POST['submit'])){
  	$edtKode=substr(strip_tags($_POST['edtKode']),0,1);
  	$edtKeterangan=substr(strip_tags($_POST['edtKeterangan']),0,40);
	if ($_POST['submit']=='Simpan'){
  		$MySQL->Insert("tbkodupy","KDKODTBKOD,NMKODTBKOD,KDAPLTBKOD","'$edtKode','$edtKeterangan','$apl'");
  		$msg=$msg_insert_data;
    	$act_log="Tambah Data Pada Tabel 'tbkodupy' File 'kode.php' ";
	} else {
		$edtID=$_POST['edtID'];
  		$MySQL->Update("tbkodupy","KDKODTBKOD='$edtKode',NMKODTBKOD='$edtKeterangan'","where IDX=".$edtID,"1");
  		$msg=$msg_edit_data;
    	$act_log="Update ID='$edtID' Pada Tabel 'tbkodupy' File 'kode.php' ";
  	}
  	if ($MySQL->exe){
		$succ=1;
	}
  	if ($succ==1){
    	$act_log .="Sukses!";
    	AddLog($id_admin,$act_log);
    	echo $msg;
  	} else{
		$act_log .="Gagal!";
		AddLog($id_admin,$act_log);
    	echo $msg_update_0;
	}
}
	
	/*if (!isset($_GET['subpage'])) $_GET['subpage']='add';*/	
?>

<?php
if (isset($_GET['p']) && ($_GET['p']=='delete')) {
	$id=$_GET['id']; 
	$MySQL->Delete("tbkodupy","where IDX=".$id,"1");
	if ($MySQL->exe){
		$act_log="Hapus ID='$id' Pada Tabel 'tbkodupy' File 'kode.php' Sukses!";
		AddLog($id_admin,$act_log);
    	echo $msg_delete_data;
	} else {
		$act_log="Hapus ID='$id' Pada Tabel 'tbkodupy' File 'kode.php' Gagal!";
		AddLog($id_admin,$act_log);
    	echo $msg_delete_data_0;
	}
} elseif (isset($_GET['p']) && ($_GET['p']=='edit')) {
/*********** Tampilkan Form Edit*************/
$MySQL->Select("tbkodupy.IDX,tbkodupy.KDKODTBKOD,tbkodupy.NMKODTBKOD,tbkodupy.KDAPLTBKOD,tbaplupy.KETERTBAPL","tbkodupy","LEFT JOIN tbaplupy ON KDAPLTBKOD=tbaplupy.IDX where tbkodupy.IDX='".$_GET['id']."'","","1");
$show=$MySQL->Fetch_Array();
$edtID=$show["IDX"];
$edtKode=$show["KDKODTBKOD"];
$edtKeterangan=$show["NMKODTBKOD"];
$apl=$show["KDAPLTBKOD"];
$aplikasi=$show["KETERTBAPL"];
?>
<form name="form1" action="./?page=kode&amp;apl=<?php echo $apl; ?>" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" /><table style="width:95%" border="0" cellpadding="1" cellspacing="1">
<tr>
<th colspan="3">Form Edit Data Parameter Kode '<?php echo $aplikasi; ?>'</th>
</tr>
<tr>
 <td style="width:100px;" >Kode Parameter</td>
 <td>: <input type="text" name="edtKode" size="1" maxlength="1" value="<?php echo $edtKode; ?>"/>
 </td>
</tr>
<tr>
 <td>Keterangan</td>
 <td>: <input type="text" name="edtKeterangan" size="40" maxlength="40" value="<?php echo $edtKeterangan; ?>"/>
 </td>
</tr>
 <td colspan="2" align="center"><br>
 <button type="button" onClick=window.location.href="./?page=kode&amp;apl=<?php echo $apl; ?>"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
<button type="submit" name="submit" value="Update" /><img src="images/b_save.gif" class="btn_img">&nbsp;Update</button>
 </td>
</tr>
</table>
</form>
<br>
<?php
} 

if (!isset($_GET['p']) || ($_GET['p']!='edit')){
/**** Tampilkan Form Tambah Sebagai Default **********/	
?>
<form name="form1" action="./?page=kode&amp;apl=<?php echo $apl; ?>" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
<tr>
<th colspan="2">Form Tambah Data Paramater Kode '<?php echo $aplikasi; ?>'</th>
</tr>
<tr>
 <td style="width:100px;" >Kode Parameter</td>
 <td>: <input type="text" name="edtKode" size="1" maxlength="1"/></td>
</tr>
<tr>
 <td>Keterangan</td>
 <td>: <input type="text" name="edtKeterangan" size="40" maxlength="40" /></td>
</tr>
<tr>
 <td colspan="2" align="center"><br>
 <button type="reset" onclick=window.location.href="./?page=aplikasi" /><img src="images/b_back.png" class="btn_img"/>&nbsp;Kembali</button>
<button type="submit" name="submit" value="Simpan" /><img src="images/b_save.gif" class="btn_img">&nbsp;Simpan</button>
 </td>
</tr>
</table>
</form>
<br>
<?php
}
	echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
     echo "<tr><th colspan='5' style='background-color:#EEE'>Daftar Kode Aplikasi</th></tr>";
     echo "<tr>
     <th style='width:50px;'>NO</th> 
     <th style='width:150px;'>KODE PARAMETER</th> 
     <th>KETERANGAN</th> 
     <th style='width:20px;' colspan='2'>ACT</th> 
     </tr>";
      $MySQL->Select("*","tbkodupy","where KDAPLTBKOD='".$apl."'","KDKODTBKOD ASC","","0");
	  if (($MySQL->Num_Rows()) > 0 ){
      	$no=1;
      	while ($show=$MySQL->Fetch_Array()){
     		$sel="";
			if ($no % 2 == 1) $sel="sel";     	
     		echo "<tr>";
     		echo "<td class='$sel tac'>".$no."</td>";
     		echo "<td class='$sel'>".$show['KDKODTBKOD']."</td>";
     		echo "<td class='$sel'>".$show['NMKODTBKOD']."</td>";
     		echo "<td class='$sel tac'>";
     		echo "<a href='./?page=kode&amp;p=edit&amp;id=".$show['IDX']."'>
     		<img border='0' src='images/b_edit.png' title='EDIT DATA' />
     		</a> ";
     		echo "</td>";
     		echo "<td class='$sel tac'>";
     		echo "<a href='./?page=kode&amp;apl=$apl&amp;p=delete&amp;id=".$show['IDX']."'>
     		<img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/>
     		</a> ";
     		echo "</td>";
     		echo "</tr>";
     		$no++;
     	}
    } else {
		echo "<td colspan='5' align='center' style='color:red;'>".$msg_data_empty."</td>";
	}
     /********* Tab Navigator ***************/
    echo "</table>";
}
?>

