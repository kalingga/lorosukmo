<?php
$idpage='16';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
//************** Simpan Data ***********************
	$succ=0;
	if (isset($_POST['submit'])){
	  	$simpan=substr(strip_tags($_POST['simpan']),0,6);
	  	$cbProdi=substr(strip_tags($_POST['cbProdi']),0,5);
	  	$edtKelas=strtoupper(substr(strip_tags($_POST['edtKelas']),0,2));
	  	$edtTahun=substr(strip_tags($_POST['edtTahun']),0,4);
	  	$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
	  	$ThnSemester=$edtTahun.$cbSemester;
	  	$cbDosen=substr(strip_tags($_POST['cbDosen']),0,15);
	  	$dosen=LoadDosen_X("","$cbDosen");
		$dosen=@explode(",",$dosen);
		$nama_dosen=$dosen[0];
		$gelar_dosen=$dosen[1];
	  	$MySQL->Select("KDFAKMSPST","mspstupy","where IDPSTMSPST='".$cbProdi."'","","1");
	  	$show=$MySQL->fetch_array();
	  	$fakultas=$show["KDFAKMSPST"];
		if ($simpan=='Simpan'){
	  		$MySQL->Insert("dsnpaupy","THSMSDSNPA,KDPSTDSNPA,KELASDSNPA,KDFAKDSNPA,NODOSDSNPA,NMDOSDSNPA,GELARDSNPA","'$ThnSemester','$cbProdi','$edtKelas','$fakultas','$cbDosen','$nama_dosen','$gelar_dosen'");
	  		$msg=$msg_insert_data;
		   	$act_log="Tambah Data Pada Tabel 'dsnpaupy' File 'dosenpa.php' ";
		} else {
			$edtID=$_POST['edtID'];
	  		$MySQL->Update("dsnpaupy","THSMSDSNPA='$ThnSemester',KELASDSNPA='$edtKelas',KDPSTDSNPA='$cbProdi',KDFAKDSNPA='$fakultas',NODOSDSNPA='$cbDosen',NMDOSDSNPA='$nama_dosen',GELARDSNPA='$gelar_dosen'","where IDX=".$edtID,"1");
	  		$msg=$msg_edit_data;
		   	$act_log="Update ID='$edtID' Pada Tabel 'dsnpaupy' File 'dosenpa.php' ";
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
		$MySQL->Delete("dsnpaupy","where IDX=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'dsnpaupy' File 'dosenpa.php' Sukses";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
		   	$act_log="Hapus ID='$id' Pada Tabel 'dsnpaupy' File 'dosenpa.php' Gagal";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}
	}

	if (isset($_GET['p']) && (($_GET['p']!='delete') && ($_GET['p']!='refresh'))) {	
		$edtID="";
		$edtKode="";	
		$edtNama="";
		$edtKelas="";
		$submited="Simpan";
		if (isset($_GET['p']) && $_GET['p']=='edit') {
			$edtID=$_GET['id'];
			$MySQL->Select("*","dsnpaupy","where IDX='".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$cbProdi=$show["KDPSTDSNPA"];
			$edtKelas=$show["KELASDSNPA"];
			$ThnSemester=$show["THSMSDSNPA"];
			$edtTahun=substr($ThnSemester,0,4);
			$cbSemester=substr($ThnSemester,4,1);
			$cbDosen=$show["NODOSDSNPA"];
			$submited="Update";
		}
/**** Tampilkan Default **********/	
?>
		<form name="form1" action="./?page=dosenpa" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
		<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" >
		<input type="hidden" name="simpan" value="<?php echo $submited; ?>" >
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<th colspan="2">Form Tambah Data</th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
	 		<td style="width:150px;" >Tahun Akademik</td>
	 		<td>: <input type="text" name="edtTahun" size="4" maxlength="4"  value="<?php echo $edtTahun ?>" required='1' regexp ='/^\d*$/' realname = 'Tahun' >&nbsp;<?php LoadSemester_X("cbSemester","$cbSemester","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Semester yang Ada!'"); ?></td>
		</tr>
		<tr>
	 		<td style="width:150px;" >Program Studi</td>
	 		<td>: <?php LoadProdi_X("cbProdi","$cbProdi","","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Program Studi yang Ada!'"); ?></td>
		</tr>
		<tr>
	 		<td style="width:150px;" >Kelas</td>
	 		<td>: <input type="text" name="edtKelas" value="<?php echo $edtKelas; ?>" size="5" maxlength="2">
</td>
		</tr>
		<tr>
	 		<td style="width:150px;" >Dosen PA.</td>
	 		<td>: <?php LoadDosen_X("cbDosen","$cbDosen","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Dosen yang Ada!'"); ?></td>
		</tr>
		<tr>
	 		<td colspan="2" align="center"><br>
	 		<button type="button" onclick=window.location.href='./?page=dosenpa'><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>&nbsp;
			<button type="submit" name="submit" value="<?php echo $submited; ?>" ><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
	 		</td>
		</tr>
		</table>
		</form>
		<br>
<?php
	} else {
	 	 if (!isset($_GET['pos'])) $_GET['pos']=1;
		 $page=$_GET['page'];
	     $sel="";
	
	     $field=$_REQUEST['field'];
		 if (!isset($_REQUEST['limit'])){
		    $_REQUEST['limit']="20";
		 }
		 if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];	 
		 $URLa="page=".$page;		
		 echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		 echo "<form action='./?page=dosenpa' method='post' >";
		/*********** From Pencarian ************/
		 echo "<tr><td colspan='4'>";
		 echo "Pencarian Berdasarkan : <select name='field'>";
	     if ($field=='KDPSTTBPST') $sel1="selected='selected'";
	     if ($field=='NMPSTTBPST') $sel2="selected='selected'";
	
	     echo "<option value='THSMSDSNPA' $sel1 >TAHUN AKADEMIK</option>";
	     echo "<option value='NMPSTMSPST' $sel2 >PROGRAM STUDI</option>";
	     
	     echo "</select>";
	     echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	     echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>";
		 
		 echo "<td align='right' colspan='3'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		 echo "&nbsp;<button type=\"button\" style='tar' onClick=window.location.href='./?page=dosenpa'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>";	 
	     echo "</td></tr></form>";
	     echo "<tr><td colspan='7'><button type=\"button\" style='tar' onClick=window.location.href='./?page=dosenpa&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
	     echo "<tr><th colspan='7' style='background-color:#EEE'>DAFTAR DOSEN PEMBIMBING AKADEMIK</th></tr>";
	     echo "<tr>
	     <th style='width:100px;'>TAHUN AKADEMIK</th> 
	     <th style='width:50px;'>SEMESTER</th> 
	     <th style='width:300px;'>PROGRAM STUDI</th> 
	     <th style='width:100px;'>KELAS</th> 
	     <th>DOSEN PA</th> 
	     <th style='width:20px;' colspan='2'>ACT</th> 
	     </tr>";
	      $qry="left join mspstupy on dsnpaupy.KDPSTDSNPA=mspstupy.IDPSTMSPST";
		  if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
		   		$qry .= " WHERE ".$field." like '%".$key."%'";
		  }
				
				
	      $MySQL->Select("mspstupy.NMPSTMSPST,dsnpaupy.THSMSDSNPA,dsnpaupy.NODOSDSNPA,dsnpaupy.NMDOSDSNPA,dsnpaupy.GELARDSNPA","dsnpaupy",$qry,"dsnpaupy.THSMSDSNPA,mspstupy.NMPSTMSPST DESC","","0");
	      $total=$MySQL->Num_Rows();
	      $perpage=$_REQUEST['limit'];
	      $totalpage=ceil($total/$perpage);
	      $start=($_GET['pos']-1)*$perpage;
	      $MySQL->Select("dsnpaupy.IDX,dsnpaupy.THSMSDSNPA,dsnpaupy.KELASDSNPA,dsnpaupy.NODOSDSNPA,dsnpaupy.NMDOSDSNPA,dsnpaupy.GELARDSNPA,mspstupy.NMPSTMSPST","dsnpaupy",$qry,"dsnpaupy.THSMSDSNPA,mspstupy.NMPSTMSPST DESC","$start,$perpage");
	      $no=1;
	      if ($MySQL->Num_Rows() > 0){
		      while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
		     	$ThnSemester=$show["THSMSDSNPA"];
		     	$sms=substr($ThnSemester,4,1);
		     	$semester="GASAL";
		     	if ($sms=="2") $semester="GENAP";
				if ($no % 2 == 1) $sel="sel";     	
		     	echo "<tr>";
		     	echo "<td class='$sel'>".substr($ThnSemester,0,4)."/".(substr($ThnSemester,0,4)+1)."</td>";
		     	echo "<td class='$sel tac'>".$semester."</td>";
		     	echo "<td class='$sel'>".$show["NMPSTMSPST"]."</td>";
		     	echo "<td class='$sel'>".$show["KELASDSNPA"]."</td>";
		     	echo "<td class='$sel'>".$show["NODOSDSNPA"]." - ".$show["NMDOSDSNPA"].", ".$show["GELARDSNPA"]."</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=dosenpa&amp;p=edit&amp;id=".$show['IDX']."'>
		     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
		     	</a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=dosenpa&amp;p=delete&amp;id=".$show['IDX']."'>
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

