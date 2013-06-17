<?php
$idpage='4';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
//************** Simpan Data ***********************
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$succ=0;
	if (isset($_POST['submit'])){
	  	$edtKode=substr(strip_tags($_POST['edtKode']),0,6);
	  	$edtNama=substr(strip_tags($_POST['edtNama']),0,50);
	  	$edtKota=substr(strip_tags($_POST['edtKota']),0,20);
	  	$cbStatus=substr(strip_tags($_POST['cbStatus']),0,1);
		if ($_POST['submit']=='Simpan'){
	  		$MySQL->Insert("tbpti","KDPTITBPTI,NMPTITBPTI,KOTAATBPTI,KDSTATBPTI","'$edtKode','$edtNama','$edtKota','$cbStatus'");
	  		$msg=$msg_insert_data;
		   	$act_log="Tambah Data Pada Tabel 'tbpti' File 'datapt.php' ";
		} else {
			$edtID=$_POST['edtID'];
	  		$MySQL->Update("tbpti","KDPTITBPTI='$edtKode',NMPTITBPTI='$edtNama',KOTAATBPTI='$edtKota',KDSTATBPTI='$cbStatus'","where IDX=".$edtID,"1");
	  		$msg=$msg_edit_data;
		   	$act_log="Update ID='$edtID' Pada Tabel 'tbpti' File 'datapt.php' ";
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
		$MySQL->Delete("tbpti","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tbpti' File 'datapt.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'tbpti' File 'datapt.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}
	
	if (isset($_GET['p']) && (($_GET['p']!='delete') && ($_GET['p']!='refresh'))) {
		$edtID="";
		$edtKode="";	
		$edtNama="";
		$edtKota="";
		$cbStatus="";
		$submited="Simpan";
		$form_header="Tambah";
		if (isset($_GET['p']) && $_GET['p']=='edit') {
			$edtID=$_GET['id'];
			$MySQL->Select("*","tbpti","where IDX='".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$edtKode=$show["KDPTITBPTI"];	
			$edtNama=$show["NMPTITBPTI"];	
			$edtKota=$show["KOTAATBPTI"];
			$cbStatus=$show["KDSTATBPTI"];
			$submited="Update";
			$form_header="Edit";			
		}
/**** Tampilkan Default **********/	
?>
		<form name="form1" action="./?page=datapt" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" />
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<th colspan="2">Form <?php echo $form_header; ?> Data Perguruan Tinggi</th>
		</tr>
		<tr>
	 		<td style="width:150px;" >Kode PT</td>
	 		<td>: <input type="text" name="edtKode" size="6" maxlength="6"  value="<?php echo $edtKode; ?>" /></td>
		</tr>
		<tr>
	 	<td>Perguruan Tinggi</td>
	 		<td>: <input type="text" name="edtNama" size="50" maxlength="50" value="<?php echo $edtNama; ?>" /></td>
		</tr>
	 	<td>Kota</td>
	 		<td>: <input type="text" name="edtKota" size="20" maxlength="20" value="<?php echo $edtKota; ?>" /></td>
		</tr>
	 	<td>Status</td>
	 		<td>: <?php LoadKode_X("cbStatus","$cbStatus","14"); ?></td>
		</tr>	
		<tr>
	 		<td colspan="2" align="center"><br>
	 		<button type="button" onclick=window.location.href="./?page=datapt" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
	<button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
	 		</td>
		</tr>
		</table>
		</form>
		<br>
<?php
	} else {
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
		 echo "<form action='./?".$URLa."' method='post' >";
		/*********** From Pencarian ************/
		 echo "<tr><td colspan='3'>";
		 echo "Pencarian Berdasarkan : <select name='field'>";
		 if ($field=='KDPTITBPTI') $sel1="selected='selected'";
		 if ($field=='NMPTITBPTI') $sel2="selected='selected'";
		 if ($field=='KOTAATBPTI') $sel3="selected='selected'";
		
		 echo "<option value='KDPTITBPTI' $sel1 >KODE</option>";
		 echo "<option value='NMPTITBPTI' $sel2 >PERGURUAN TINGGI</option>";
		 echo "<option value='KOTAATBPTI' $sel3 >KOTA</option>";
		 
		 echo "</select>";
		 echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
		 echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>";
		 
		 echo "<td align='right' colspan='4'> Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		 echo "&nbsp;<button type=\"button\" style='tar' onClick=window.location.href='./?page=datapt'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>";	 
		 echo "</td></tr></form>";
	 	echo "<tr><td colspan='7'><button type=\"button\" onClick=window.location.href='./?page=datapt&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
		 echo "<tr><th colspan='7' style='background-color:#EEE'>Data Perguruan Tinggi</th></tr>";
		 echo "<tr>
		 <th style='width:50px;'>NO</th> 
		 <th style='width:150px;'>KODE</th> 
		 <th style='width:250px;'>PERGURUAN TINGGI</th> 
		 <th style='width:150px;'>KOTA</th> 
		 <th style='width:100px;'>STATUS</th> 
		 <th style='width:20px;' colspan='2'>ACT</th> 
		 </tr>";
		  $qry="left join tbkodupy on tbpti.KDSTATBPTI=tbkodupy.KDKODTBKOD where KDAPLTBKOD='14'";
		  if(!empty($_REQUEST['key'])){
		 	$qry .= " and ".$field." like '%".$key."%'";
		  }
		  $MySQL->Select("tbpti.KDPTITBPTI,tbpti.NMPTITBPTI,tbpti.KOTAATBPTI,tbkodupy.NMKODTBKOD","tbpti",$qry,"KDPTITBPTI ASC","","0");
		  $total=$MySQL->Num_Rows();
		  $perpage=$_REQUEST['limit'];
		  $totalpage=ceil($total/$perpage);
		  $start=($_GET['pos']-1)*$perpage;
		  $MySQL->Select("tbpti.IDX,tbpti.KDPTITBPTI,tbpti.NMPTITBPTI,tbpti.KOTAATBPTI,tbkodupy.NMKODTBKOD","tbpti",$qry,"KDPTITBPTI ASC","$start,$perpage");
		  $no=1;
		  if ($MySQL->Num_Rows() > 0){
		      while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
				if ($no % 2 == 1) $sel="sel";     	
		     	echo "<tr>";
		     	echo "<td class='$sel tac'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['KDPTITBPTI']."</td>";
		     	echo "<td class='$sel'>".$show['NMPTITBPTI']."</td>";
		     	echo "<td class='$sel'>".$show['KOTAATBPTI']."</td>";
		     	echo "<td class='$sel'>".$show['NMKODTBKOD']."</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=datapt&amp;p=edit&amp;id=".$show['IDX']."'>
		     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
		     	</a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=datapt&amp;p=delete&amp;id=".$show['IDX']."'>
		     	<img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/>
		     	</a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
		     }
		} else {
		 	echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";
		}
		 /********* Tab Navigator ***************/
		echo "<tr><td colspan='7'>";
		include "navigator.php";
		echo "</td></tr>";
		echo "</table>";
	}	         
}
?>

