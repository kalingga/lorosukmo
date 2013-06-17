<?php
$idpage='5';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
//************** Simpan Data ***********************
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$succ=0;
	if (isset($_POST['submit'])){
	  	$edtKode=substr(strip_tags($_POST['edtKode']),0,5);
	  	$edtNama=substr(strip_tags($_POST['edtNama']),0,40);
		if ($_POST['submit']=='Simpan'){
	  		$MySQL->Insert("tbpst","KDPSTTBPST,NMPSTTBPST","'$edtKode','$edtNama'");
	  		$msg=$msg_insert_data;
		   	$act_log="Tambah Data Pada Tabel 'tbpst' File 'dataprodi.php' ";
		} else {
			$edtID=$_POST['edtID'];
	  		$MySQL->Update("tbpst","KDPSTTBPST='$edtKode',NMPSTTBPST='$edtNama'","where IDX=".$edtID,"1");
	  		$msg=$msg_edit_data;
		   	$act_log="Update ID='$edtID' Pada Tabel 'tbpst' File 'dataprodi.php' ";
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
		$MySQL->Delete("tbpst","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tbpst' File 'dataprodi.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'tbpst' File 'dataprodi.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}
	
	if (isset($_GET['p']) && (($_GET['p']!='delete') && ($_GET['p'] != 'refresh'))) {
		$edtID="";
		$edtKode="";	
		$edtNama="";
		$submited="Simpan";
		$form_header='Tambah';
		if (isset($_GET['p']) && $_GET['p']=='edit') {
			$edtID=$_GET['id'];
			$MySQL->Select("*","tbpst","where IDX='".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$edtKode=$show["KDPSTTBPST"];	
			$edtNama=$show["NMPSTTBPST"];	
			$submited="Update";
			$form_header='Edit';
		}
?>
		<form name="form1" action="./?page=dataprodi" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<th colspan="2">Form <?php echo $form_header; ?> Data Program Studi</th>
		</tr>
		<tr>
			<td style="width:150px;" >Kode Prodi</td>
			<td>: <input type="text" name="edtKode" size="5" maxlength="5"  value="<?php echo $edtKode; ?>" /></td>
		</tr>
		<tr>
		<td>Program Studi</td>
			<td>: <input type="text" name="edtNama" size="40" maxlength="40" value="<?php echo $edtNama; ?>" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><br>
			<button type="reset" onClick=window.location.href="./?page=dataprodi" ><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;
		<button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
			</td>
		</tr>
		</table>
		</form>
		<br>
<?php
	} else {
			/**** Tampilkan Default **********/	
	 	 if (!isset($_GET['pos'])) $_GET['pos']=1;
		 $page=$_GET['page'];
		 $p=$_GET['p'];
	     $sel="";
	
	     $field=$_REQUEST['field'];
		 if (!isset($_REQUEST['limit'])){
		    $_REQUEST['limit']="20";
		 }
		 if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];	 
		 if (isset($p) && $p!=''){
			$URLa="page=".$page."&amp;p=".$p;	
		 } else{
			$URLa="page=".$page;		
		 }	 
		 echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		 echo "<form action='./?page=dataprodi' method='post' >";
		/*********** From Pencarian ************/
		 echo "<tr><td colspan='3'>";
		 echo "Pencarian Berdasarkan : <select name='field'>";
	     if ($field=='KDPSTTBPST') $sel1="selected='selected'";
	     if ($field=='NMPSTTBPST') $sel2="selected='selected'";
	
	     echo "<option value='KDPSTTBPST' $sel1 >KODE</option>";
	     echo "<option value='NMPSTTBPST' $sel2 >PROGRAM STUDI</option>";
	     
	     echo "</select>";
	     echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	     echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>";
		 
		 echo "<td align='right' colspan='3'> Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		 echo "&nbsp;<button type=\"button\" style='tar' onClick=window.location.href='./?page=dataprodi'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>";	 
	     echo "</td></tr></form>";
		 echo "<tr><td colspan='6'><button type=\"button\" style='tar' onClick=window.location.href='./?page=dataprodi&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";	 
	     echo "<tr><th colspan='6' style='background-color:#EEE'>Daftar Program Studi yang Terdaftar di Dikti</th></tr>";
	     echo "<tr>
	     <th style='width:50px;'>NO</th> 
	     <th style='width:150px;'>KODE</th> 
	     <th colspan='2' style='width:300px;'>PROGRAM STUDI</th> 
	     <th style='width:20px;' colspan='2'>ACT</th> 
	     </tr>";
	      $qry="";
	      if(!empty($_REQUEST['key'])){
	     	$qry = "where ".$field." like '%".$key."%'";
	  	  }
	      $MySQL->Select("*","tbpst",$qry,"KDPSTTBPST ASC","","0");
	      $total=$MySQL->Num_Rows();
	      $perpage=$_REQUEST['limit'];
	      $totalpage=ceil($total/$perpage);
	      $start=($_GET['pos']-1)*$perpage;
	      $MySQL->Select("*","tbpst",$qry,"KDPSTTBPST ASC","$start,$perpage");
	      $no=1;
	      if ($MySQL->Num_Rows() > 0){
		      while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
				if ($no % 2 == 1) $sel="sel";     	
		     	echo "<tr>";
		     	echo "<td class='$sel tac'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['KDPSTTBPST']."</td>";
		     	echo "<td class='$sel' colspan='2'>".$show['NMPSTTBPST']."</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=dataprodi&amp;p=edit&amp;id=".$show['IDX']."'>
		     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
		     	</a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=dataprodi&amp;p=delete&amp;id=".$show['IDX']."'>
		     	<img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/>
		     	</a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
		     }
		} else {
		 	echo "<td colspan='6' align='center' style='color:red;'>".$msg_data_empty."</td>";
		}
	     /********* Tab Navigator ***************/
		echo "<tr><td colspan='6'>";
		include "navigator.php";
		echo "</td></tr>";
	    echo "</table>";
	}	         
}
?>

