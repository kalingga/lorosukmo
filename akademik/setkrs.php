<?php
$idpage='30';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$level_user = GetLevelUser($id_admin);
	
	if (isset($_POST['submit'])) {
		$cbProdi=substr(strip_tags($_POST['cbProdi']),0,2);
		$edtIP=$_POST['edtIP'];
		$edtSKS=$_POST['edtSKS'];
		$IsLama=$_POST['IsLama'];
		
		if (($_POST['submit']=='Simpan')){
			for ($i=0; $i <= 5;$i++) {
				if ($i==5) {
					$batasIP[$i]=0;
				} else {
					$batasIP[$i]=$edtIP[$i];
				}
				$MySQL->insert("makrsupy","KDPSTMAKRS,BATASMAKRS,MASKSMAKRS,ISLMAMAKRS","'$cbProdi','$batasIP[$i]','$edtSKS[$i]','$isLama[$i]'");
			}
			$msg=$msg_insert_data;
			$act_log="Tambah Data Pada Tabel 'makrsupy' File 'setkrs.php ";
		} else {
			$edtID=$_POST['edtID'];
			for ($i=0; $i <= 5;$i++) {
				if ($i==5) {
					$batasIP[$i]=0;
				} else {
					$batasIP[$i]=$edtIP[$i];
				}
				$MySQL->Update("makrsupy","KDPSTMAKRS='$cbProdi',BATASMAKRS='$batasIP[$i]',MASKSMAKRS='$edtSKS[$i]'","where makrsupy.IDX='".$edtID[$i]."'","1");
			}
			$msg=$msg_edit_data;
			$act_log="Update ID='$edtID' Pada Tabel 'makrsupy' File 'setpmb.php ";
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

	if (isset($_GET['p']) && ($_GET['p']=='delete')) {
		$id=$_GET['id']; 
		$MySQL->Delete("makrsupy","where KDPSTMAKRS=".$id);
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'makrsupy' File 'setkrs.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'makrsupy' File 'setkrs.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}
	
	if (isset($_GET['p']) && ($_GET['p']=='add' || $_GET['p']=='edit')) {
		$submited="Simpan";
		$formtitle="Tambah Data";
		if (($_GET['p']) == 'edit') {
			$formtitle="Edit Data";
			$id=$_GET['id'];
			$MySQL->Select("*","makrsupy","where KDPSTMAKRS ='".$id."'","makrsupy.KDPSTMAKRS ASC,makrsupy.IDX ASC","");
			$cbProdi=$id;
			$i=0;
			while ($show=$MySQL->fetch_array()){
				$edtID[$i]=$show["IDX"];
				$edtIP[$i]=$show["BATASMAKRS"];
				$edtSKS[$i]=$show["MASKSMAKRS"];
				$IsLama[$i]=$show["ISLMAMAKRS"];
				$i++;
			}
			$submited="Update";
		}		
		
		
?>
		<form name="form1" action="./?page=setkrs" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		<th colspan="3">Form <?php echo $formtitle; ?> Set KRS</th>
		</tr>
		<tr>
		<th colspan="3">&nbsp;</th>
		</tr>
		<tr>
		<tr>
			<td colspan="2">Program Studi</td>
		 	<td>:
<?php 
			  LoadProdi_X('cbProdi',$cbProdi,$fak,"required='1' exclude='-1' err ='Pilih Salah Satu dari Daftar Program Studi yang Ada!'");
?>
			</td>
		</tr>
		<tr>
		<td width="2%">A. </td>
		<td colspan="2">Mahasiswa Lama</td>			
<?php

		for ($i=0; $i <= 5;$i++){
			echo "<input type='hidden' name='edtID[$i]' value='$edtID[$i]' />";
			if ($i==5) {
				echo "<tr><td>B. </td><td>Mahasiswa Baru</td>";
				echo "<td>: 
					<input type='text' name='edtSKS[$i]' id='edtSKS[$i]' size='3' maxlength='3' value='$edtSKS[$i]' />&nbsp;SKS
					<input type='hidden' name='isLama[$i]' id='isLama[$i]' size='1' maxlength='1' value='0'/>
				</td>
				</tr>";
			} else {
				echo "</tr><td>&nbsp;</td><td width='20%'>IPK Semester Sebelumnya</td>
				 	 <td>: <= ";
				echo "<input type='text' name='edtIP[$i]' id='edtIP[$i]' size='5' maxlength='5' value='$edtIP[$i]' />";
		        echo "&nbsp;[n.nn]&nbsp;&nbsp;&nbsp;Max SKS&nbsp;&nbsp;
 				      &nbsp;: <input type='text' name='edtSKS[$i]' id='edtSKS[$i]' size='3' maxlength='3' value='$edtSKS[$i]' />&nbsp;SKS
					  <input type='hidden' name='isLama[$i]' id='isLama[$i]' size='1' maxlength='1' value='1'/></td></tr>";
			}
		}
?>
		<tr><td colspan='3'>&nbsp;</td></tr>
		<tr>
		 <td colspan="3" align="center">
		 <button type="reset"  onClick=window.location.href="./?page=setkrs"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
		 <button type="submit" name="submit" value="<?php echo $submited; ?>" ><img src="images/b_save.gif" class="btn_img"/>&nbsp;<?php echo $submited; ?></button>
		 </td>
		</tr>
		</table>
		</form>
		<br>
<?		
	} else {
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		;
		echo "<tr><td colspan='4' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=setkrs&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
	    echo "<tr><th style='width:20px;'>NO.</th> 
	    <th>Program Studi</th> 
	    <th style='width:40px;' colspan='2'>ACT</th> 
	 	</tr>";
		
		$qry ="LEFT JOIN mspstupy ON (makrsupy.KDPSTMAKRS = mspstupy.IDPSTMSPST)";
		$MySQL->Select("DISTINCTROW makrsupy.KDPSTMAKRS,mspstupy.NMPSTMSPST","makrsupy",$qry,"","","0");
	    $no=1;
	    if ($MySQL->Num_Rows() > 0){
			while ($show=$MySQL->Fetch_Array()){
		    	$sel="";
				if ($no % 2 == 1) $sel="sel";
		     	echo "<tr>";
		     	echo "<td class='$sel tac'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['NMPSTMSPST']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=setkrs&amp;p=edit&amp;id=".$show['KDPSTMAKRS']."' ><img border='0' src='images/b_edit.png' title='EDIT DATA' \"/></a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=setkrs&amp;p=delete&amp;id=".$show['KDPSTMAKRS']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
		     	echo "</td>";
		     	echo "</tr>";
	     	$no++;
	 		}
		} else {
			echo "<td colspan='4' align='center' style='color:red;'>".$msg_data_empty."</td>";		
	 	}
	 	echo "</table>";
	}
}
?>

