<?php
$idpage='33';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit'])) {
		$edtThnAjaran=substr(strip_tags($_POST['edtThnAjaran']),0,4);
		$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
		$ThnSemester=$edtThnAjaran.$cbSemester;
		$edtTglAwl=substr(strip_tags($_POST['edtTglAwl']),0,10);
		$edtTglAwl=@explode("-",$edtTglAwl);
		$edtTglAwl=$edtTglAwl[2]."-".$edtTglAwl[1]."-".$edtTglAwl[0];
		$edtTglAkh=substr(strip_tags($_POST['edtTglAkh']),0,10);
		$edtTglAkh=@explode("-",$edtTglAkh);
		$edtTglAkh=$edtTglAkh[2]."-".$edtTglAkh[1]."-".$edtTglAkh[0];
		$edtTglAwl1=substr(strip_tags($_POST['edtTglAwl1']),0,10);
		$edtTglAwl1=@explode("-",$edtTglAwl1);
		$edtTglAwl1=$edtTglAwl1[2]."-".$edtTglAwl1[1]."-".$edtTglAwl1[0];
		$edtTglAkh1=substr(strip_tags($_POST['edtTglAkh1']),0,10);
		$edtTglAkh1=@explode("-",$edtTglAkh1);
		$edtTglAkh1=$edtTglAkh1[2]."-".$edtTglAkh1[1]."-".$edtTglAkh1[0];

		if (($_POST['submit']=='Simpan')){
				$MySQL->Insert("setkrsupy","TASMSSETKRS,MLKRSSETKRS,BTKRSSETKRS,TGAWLSETKRS,TGAKHSETKRS","'$ThnSemester','$edtTglAwl','$edtTglAkh','$edtTglAwl1','$edtTglAkh1'");
				$msg=$msg_insert_data;
				$act_log="Tambah Data Pada Tabel 'setkrsupy' File 'jadwalkrs.php ";
		} else {
				$edtID=substr(strip_tags($_POST['edtID']),0,11);
				$MySQL->Update("setkrsupy","TASMSSETKRS='$ThnSemester',MLKRSSETKRS='$edtTglAwl',BTKRSSETKRS='$edtTglAkh',TGAWLSETKRS='$edtTglAwl1',TGAKHSETKRS='$edtTglAkh1'","where IDX=".$edtID,"1");
				$msg=$msg_edit_data;
				$act_log="Update ID='$edtID' Pada Tabel 'setkrsupy' File 'jadwalkrs.php ";
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
		$MySQL->Delete("setkrsupy","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'setkrsupy' File 'jadwalkrs.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'setkrsupy' File 'jadwalkrs.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}			
	
	if (isset($_GET['p']) && ($_GET['p']=='add' || $_GET['p']=='edit')) {
		$submited="Simpan";
		$formtitle="Tambah Data";
		$edtTahunAjaran="";
		$cbSemester="";
		$edtTglAwl="";
		$edtTglAkh="";
		$edtTglAwl1="";
		$edtTglAkh1="";
		if (($_GET['p']) == 'edit') {
			$formtitle="Edit Data";
			$edtID=$_GET['id'];
			$MySQL->Select("*","setkrsupy","where IDX='".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$edtThnAjaran=$show['TASMSSETKRS'];
			$cbSemester=substr($show['TASMSSETKRS'],4,1);
			$edtTglAwl=DateStr($show['MLKRSSETKRS']);
			$edtTglAkh=DateStr($show['BTKRSSETKRS']);
			$edtTglAwl1=DateStr($show['TGAWLSETKRS']);
			$edtTglAkh1=DateStr($show['TGAKHSETKRS']);
			$submited="Update";
		}		
?>
		<form name="form1" action="./?page=jadwalkrs" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" size="11" maxlength="11" value="<?php echo $edtID; ?>" />
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
		<th colspan="2">Form <?php echo $formtitle; ?> Set KRS</th>
		</tr>
		<tr>
		<th colspan="2">&nbsp;</th>
		</tr>
		<tr>
		 <td width="35%">Tahun Akademik</td>
		 <td>: <input type="text" name="edtThnAjaran" id="edtThnAjaran" size="4" maxlength="4" value="<?php echo $edtThnAjaran; ?>" required="1" regexp="/^\d*$/" realname ="Tahun"/>
		 <?php LoadSemester_X("cbSemester","$cbSemester"); ?></td>
		</tr>
		<tr> 
	     <td>Masa Pengisian KRS</td>
	    	<td>: 
			<input type="text" name="edtTglAwl" size="10"  maxlength="10" value="<?php echo $edtTglAwl; ?>" /> 
	<a href="javascript:show_calendar('document.form1.edtTglAwl','document.form1.edtTglAwl',document.form1.edtTglAwl.value);">
	<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> s.d. 
			<input type="text" name="edtTglAkh" size="10"  maxlength="10" value="<?php echo $edtTglAkh; ?>" /> 
	<a href="javascript:show_calendar('document.form1.edtTglAkh','document.form1.edtTglAkh',document.form1.edtTglAkh.value);">
	<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
			</td>
		</tr>
		<tr> 
	     <td>Masa Perubahan KRS</td>
	    	<td>: 
			<input type="text" name="edtTglAwl1" size="10"  maxlength="10" value="<?php echo $edtTglAwl1; ?>" /> 
	<a href="javascript:show_calendar('document.form1.edtTglAwl1','document.form1.edtTglAwl1',document.form1.edtTglAwl1.value);">
	<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> s.d. 
			<input type="text" name="edtTglAkh1" size="10"  maxlength="10" value="<?php echo $edtTglAkh1; ?>" /> 
	<a href="javascript:show_calendar('document.form1.edtTglAkh1','document.form1.edtTglAkh1',document.form1.edtTglAkh1.value);">
	<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a> dd-mm-yyyy 			
			</td>
		</tr>



		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		 <td colspan="2" align="center">
		 <button type="reset"  onClick=window.location.href="./?page=jadwalkrs"><img src="images/b_reset.gif" class="btn_img"/>&nbsp;Batal</button>
		 <button type="submit" name="submit" value="<?php echo $submited; ?>" ><img src="images/b_save.gif" class="btn_img"/>&nbsp;<?php echo $submited; ?></button>
		 </td>
		</tr>
		</table>
		</form>
<?		
	} else {
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		;
		
		echo "<form action='./?".$URLa."' method='post' >";
		echo "<tr><td colspan='5'>";
		echo "Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='TASMSSETKRS') $sel1="selected='selected'";
	
	    echo "<option value='TASMSSETKRS' $sel1 >TAHUN AKADEMIK</option>";
	
	    echo "</select>";
	    echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n</td>";
		 
		echo "<td colspan='4' align='right'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=jadwalkrs&amp;p=refresh'><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	    echo "</td></tr></form>";
		echo "<tr><td colspan='9' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=jadwalkrs&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
	    echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR PENJADWALAN KRS</th></tr>";
	    echo "<tr>
	    <th style='width:20px; tac' rowspan='2'>NO</th> 
	    <th style='width:75px;' rowspan='2'>TAHUN AKADEMIK</th> 
	    <th style='width:30px; tac' rowspan='2'>SEM</th> 
	    <th style='width:150px;' colspan='2'>PENGISIAN KRS</th> 
	    <th style='width:150px;' colspan='2'>PERUBAHAN KRS</th>
	    <th colspan='2' style='width:40px;' rowspan='2'>ACT</th> 
	 	</tr>";
	    echo "<tr>
	    <th style='width:150px;'>TANGGAL</th> 
	    <th style='width:30px;'>HARI</th> 
	    <th style='width:150px;'>TANGGAL</th> 
	    <th style='width:30px;'>HARI</th>
	 	</tr>";
		$MySQL->Select("*","setkrsupy",$qry,"","","0");
		$total=$MySQL->Num_Rows();
		$perpage=$_REQUEST['limit'];
		$totalpage=ceil($total/$perpage);
		$start=($_GET['pos']-1)*$perpage;
	    $MySQL->Select("setkrsupy.*,(DATEDIFF(setkrsupy.BTKRSSETKRS,setkrsupy.MLKRSSETKRS)+1) AS JMLHARI,(DATEDIFF(setkrsupy.TGAKHSETKRS,setkrsupy.TGAWLSETKRS)+1) AS JMLHARI1","setkrsupy",$qry,"setkrsupy.TASMSSETKRS DESC","$start,$perpage");
	    $no=1;
	    if ($MySQL->Num_Rows() > 0){
			while ($show=$MySQL->Fetch_Array()){
		    	$sel="";
				if ($no % 2 == 1) $sel="sel";
		     	//set semester
		     	$semester="Gasal";
		     	if (substr($show['TASMSSETKRS'],4,1)=="2") $semester="Genap";
		     	echo "<tr>";
		     	echo "<td class='$sel tac'>".$no."</td>";
		     	echo "<td class='$sel'>".substr($show['TASMSSETKRS'],0,4)."/".(substr($show['TASMSSETKRS'],0,4) + 1)."</td>";
		     	echo "<td class='$sel tac'>".$semester."</td>";
		     	echo "<td class='$sel'>".DateStr($show['MLKRSSETKRS'])." s.d. ".DateStr($show['BTKRSSETKRS'])."</td>";
		     	echo "<td class='$sel tar'>".$show['JMLHARI']." hari</td>";	     	
		     	echo "<td class='$sel'>".DateStr($show['TGAWLSETKRS'])." s.d. ".DateStr($show['TGAKHSETKRS'])."</td>";
		     	echo "<td class='$sel tar'>".$show['JMLHARI1']." hari</td>";
				echo "<td class='$sel tac'><a href='./?page=jadwalkrs&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=jadwalkrs&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
		     	echo "</td>";
		     	echo "</tr>";
	     	$no++;
	 		}
		} else {
			echo "<td colspan='9' align='center' style='color:red;'>".$msg_data_empty."</td>";		
	 	}
	 	echo "</table>";
	 	include "navigator.php";
	}
}
?>

