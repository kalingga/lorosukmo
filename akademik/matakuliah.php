<?php
$idpage='18';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$page=$_GET['page'];
	if (isset($_POST['submit'])){
		$edtKode=strtoupper(substr(strip_tags($_POST['edtKode']),0,10));
		$edtNama=strtoupper(substr(strip_tags($_POST['edtNama']),0,40));
		$cbKelompok=substr(strip_tags($_POST['cbKelompok']),0,1);
		$cbStatus=substr(strip_tags($_POST['cbStatus']),0,1);
		$simpan=substr(strip_tags($_POST['simpan']),0,6);
		if ($simpan=='Simpan'){
			$MySQL->Insert("tblmkupy","KDMKTBLMK,NAMKTBLMK,KDKLTBLMK,STMKTBLMK","'$edtKode','$edtNama','$cbKelompok','$cbStatus'");
			$msg=$msg_insert_data;
			$act_log="Tambah Data Pada Tabel 'tblmkupy' File 'matakuliah.php' ";
		} else {
			$edtID=$_POST['edtID'];
			$MySQL->Update("tblmkupy","KDMKTBLMK='$edtKode',NAMKTBLMK='$edtNama',KDKLTBLMK='$cbKelompok',STMKTBLMK='$cbStatus'","where IDX=".$edtID,"1");
			$msg=$msg_edit_data;
			$act_log="Update ID='$edtID' Pada Tabel 'tblmkupy' File 'matakuliah.php' ";
		}
		// perintah SQL berhasil dijalankan
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

	if (isset($_GET['p']) && $_GET['p']=='delete') {
		$id=$_GET['id']; 
		$MySQL->Delete("tblmkupy","where IDX=".$id,"1");
	    if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tblmkupy' File 'matakuliah.php' Sukses!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'tblmkupy' File 'matakuliah.php' Gagal!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data_0;
		}
	}
	
	if (isset($_GET['p']) && (($_GET['p']!='delete') && ($_GET['p']!='refresh'))) {
		$edtKode='';
		$edtNama='';
		$cbKelompok='';
		$cbStatus='';
		$submited="Simpan";
		$form_header="Tambah";
		if ($_GET['p']=='edit') {
			$id=$_GET['id'];
			$MySQL->Select("*","tblmkupy","where IDX='".$id."'","","1");
			$show=$MySQL->Fetch_Array();
			$edtKode=$show['KDMKTBLMK'];
			$edtNama=$show['NAMKTBLMK'];
			$cbKelompok=$show['KDKLTBLMK'];
			$cbStatus=$show['STMKTBLMK'];
			$submited="Update";
			$form_header="Edit";
		}
?>
		<form name="form1" action="./?page=<?php echo $page; ?>" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" size="11" maxlength="11" value="<?php echo $id; ?>" />		<input type="hidden" name="simpan" size="11" maxlength="11" value="<?php echo $submited; ?>" />		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		<th colspan="2">Form <?php echo $form_header; ?> Data Matakuliah</th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		 <td style="width:150px;" >Kode Matakuliah</td>
		 <td>: <input type="text" name="edtKode" id="edtKode" size="10" maxlength="10" value="<?php echo $edtKode; ?>" /></td>
		</tr>
		<tr>
		 <td>Matakuliah</td>
		 <td class="mandatory">: <input type="text" name="edtNama" id="edtNama" size="40" maxlength="40" value="<?php echo $edtNama; ?>" /></td>
		</tr>
		<tr>
		 <td>Kelompok Matakuliah</td>
		 <td class="mandatory">: <?php LoadKode_X("cbKelompok","$cbKelompok","10","required='1' exclude='-1' err='Pilih Salah Satu Dari Daftar Kelompok MK yang Ada!'"); ?></td>
		</tr>
		<tr>
		 <td>Status</td>
		 <td>: <?php LoadKode_X("cbStatus","$cbStatus","32"); ?></td>
		</tr>
		<tr>
		 <td colspan="2" align="center">
		 <button type="reset" onClick=window.location.href="./?page=<?php echo $page; ?>" /><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
            <button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
		 </td>
		</tr>
		</table>
		</form>
		<br>
<?php		
	} else {
	    $sel="";
	    $field=$_REQUEST['field'];
	 	if (!isset($_GET['pos'])) $_GET['pos']=1;
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
	     if ($field=='KDMKTBLMK') $sel1="selected='selected'";
	     if ($field=='NAMKTBLMK') $sel2="selected='selected'";
	     if ($field=='tbkodupy.NMKODTBKOD') $sel3="selected='selected'";
	
	     echo "<option value='KDMKTBLMK' $sel1 >KODE</option>";
	     echo "<option value='NAMKTBLMK' $sel2 >MATAKULIAH</option>";
	     echo "<option value='tbkodupy.NMKODTBKOD' $sel3 >KELOMPOK MK</option>";
	
	     echo "</select>";
	     echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	     echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>";
		 echo "<td colspan='4' align='right'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		 echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=matakuliah&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	     echo "</td></tr></form>";
		 /**************/	
		echo "<tr><td colspan='7' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=$page&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
		echo "<tr><th colspan='7' style='background-color:#EEE'>Daftar Matakuliah</th></tr>";
		echo "<tr>
			<th style='width:100px;'>KODE</th>
			<th style='width:250px;'>MATAKULIAH</th>
			<th colspan='2' style='width:250px;'>KELOMPOK MK</th>
			<th style='width:50px;'>STATUS</th>
			<th colspan='2' style='width:20px;'>ACT</th></tr>";
	    
	    $qry = "left join tbkodupy on tblmkupy.KDKLTBLMK=tbkodupy.KDKODTBKOD where tbkodupy.KDAPLTBKOD='10' ";
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
	   		$qry .= "and ".$field." like '".$key."'";
		}
		$MySQL->Select("*","tblmkupy",$qry,"","","0");
		$total=$MySQL->Num_Rows();
		$perpage=$_REQUEST['limit'];
		$totalpage=ceil($total/$perpage);
		$start=($_GET['pos']-1)*$perpage;
		$MySQL->Select("tblmkupy.*,tbkodupy.NMKODTBKOD","tblmkupy",$qry,"IDX DESC","$start,$perpage");
		if ($MySQL->Num_Rows() > 0){
			$no=1;
			while ($show=$MySQL->Fetch_Array()){
				$sel="";
				if ($no % 2 == 1) $sel="sel";     	
				echo "<tr>";
		     	echo "<td class='$sel tac'>".$show['KDMKTBLMK']."</td>";
		     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
		     	echo "<td colspan='2' class='$sel'>".$show['NMKODTBKOD']."</td>";
		     	echo "<td class='$sel tac'>".$show['STMKTBLMK']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=".$page."&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=".$page."&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
			}
		} else {
			echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";		
		}
	 	echo "<tr><td colspan='7' style='background-color:#EEE tal'>Keterangan Status : A=Aktif&nbsp;&nbsp;&nbsp;H=Hapus&nbsp;&nbsp;&nbsp;</td></tr>";
		echo "</table>";
		include "navigator.php";
	}
}
?>

