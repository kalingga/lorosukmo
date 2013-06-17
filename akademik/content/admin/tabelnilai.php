<?php
$idpage='17';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
//************** Simpan Data ***********************
	$form_header="TAMBAH";	
	$succ=0;
	if (isset($_POST['submit'])){
	  	$cbProdi=substr(strip_tags($_POST['cbProdi']),0,2);
	  	$edtNilai=substr(strip_tags($_POST['edtNilai']),0,2);
	  	$edtBobot=substr(strip_tags($_POST['edtBobot']),0,5);
		if ($_POST['submit']=='Simpan'){
	  		$MySQL->Insert("tbbnlupy","NLAKHTBBNL,BOBOTTBBNL","UPPER('$edtNilai'),'$edtBobot'");
	  		$msg=$msg_insert_data;
		   	$act_log="Tambah Data Pada Tabel 'tbbnlupy' File 'tabelnilai.php' ";
		} else {
			$edtID=$_POST['edtID'];
	  		$MySQL->Update("tbbnlupy","NLAKHTBBNL=UPPER('$edtNilai'),BOBOTTBBNL='$edtBobot'","where IDX=".$edtID,"1");
	  		$msg=$msg_edit_data;
		   	$act_log="Update ID='$edtID' Pada Tabel 'tbbnlupy' File 'tabelnilai.php' ";
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
	if (isset($_GET['p']) && ($_GET['p']=='delete')) {
		$id=$_GET['id']; 
		$MySQL->Delete("tbbnlupy","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tbbnlupy' File 'tabelnilai.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'tbbnlupy' File 'tabelnilai.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}
	
	if (isset($_GET['p']) && ($_GET['p']!='delete')) {
		$edtID="";
		$edtKode="";	
		$edtNama="";
		$submited="Simpan";
		if ($_GET['p']=='edit') {
			$edtID=$_GET['id'];
			$MySQL->Select("*","tbbnlupy","where IDX='".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$edtNilai=$show["NLAKHTBBNL"];
			$edtBobot=$show["BOBOTTBBNL"];
			$form_header="EDIT";
			$submited="Update";
		}
/**** Tampilkan Default **********/	
?>
		<form name="form1" action="./?page=tabelnilai" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
		<table align="center" style="width:50%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<th colspan="2">FORM <?php echo $form_header; ?> DATA TABEL NILAI</th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
	 		<td style="width:150px;" >NILAI</td>
	 		<td>: <input type="text" name="edtNilai" size="2" maxlength="2"  value="<?php echo $edtNilai ?>" required='1' realname = 'Nilai' /></td>
		</tr>
		<tr>
	 		<td style="width:150px;" >Bobot</td>
	 		<td>: <input type="text" name="edtBobot" size="5" maxlength="5"  value="<?php echo $edtBobot ?>" required='1' realname = 'Bobot' />&nbsp;[xn.nn]</td>
		</tr>
		<tr>
	 		<td colspan="2" align="center"><br>
	 		<button type="button" onclick=window.location.href='./?page=tabelnilai'><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;
			<button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
	 		</td>
		</tr>
		</table>
		</form>
		<br>
<?php
	}
     $sel="";
	 echo "<table border='0' align='center' style='width:50%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
	 echo "<tr><td colspan='4'><button type=\"button\" style='tar' onClick=window.location.href='./?page=tabelnilai&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button>";	 
     echo "</td></tr>";
     echo "<tr><th colspan='4' style='background-color:#EEE'>TABEL BOBOT NILAI</th></tr>";
     echo "<tr>
     <th style='width:100px;'>NILAI</th> 
     <th style='width:100px;'>BOBOT</th> 
     <th style='width:40px;' colspan='2'>ACT</th> 
     </tr>";				
      $MySQL->Select("tbbnlupy.IDX,tbbnlupy.NLAKHTBBNL,tbbnlupy.BOBOTTBBNL","tbbnlupy","","tbbnlupy.BOBOTTBBNL DESC","","0");
      $no=1;
      if ($MySQL->Num_Rows() > 0){
	      while ($show=$MySQL->Fetch_Array()){
	     	$sel="";
			if ($no % 2 == 1) $sel="sel";     	
	     	echo "<tr>";
	     	echo "<td class='$sel tac'>".$show["NLAKHTBBNL"]."</td>";
	     	echo "<td class='$sel tac'>".$show["BOBOTTBBNL"]."</td>";
	     	echo "<td class='$sel tac'>";
	     	echo "<a href='./?page=tabelnilai&amp;p=edit&amp;id=".$show['IDX']."'>
	     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
	     	</a> ";
	     	echo "</td>";
	     	echo "<td class='$sel tac'>";
	     	echo "<a href='./?page=tabelnilai&amp;p=delete&amp;id=".$show['IDX']."'>
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
    echo "</tr></table>";
}
?>

