<?php
$idpage='32';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	//Cari PMB paling terakhir dilaksanakan
	if (isset($_GET['p']) && ($_GET['p'] == 'delete')) {
		$id=$_GET['id']; 
		$MySQL->Delete("setpmbupy","where IDX=".$id,"1");
	    if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'setpmbupy' File 'setpmb.php' Sukses!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'setpmbupy' File 'setpmb.php' Gagal!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data_0;
		}	
	}
	if (isset($_POST['submit'])) {
		if (($_POST['submit']=="addshift") || ($_POST['submit']=="editshift")) {
			$edtID=$_POST['edtID'];
			$edtShift=substr(strip_tags($_POST['edtShift']),0,5);
			$edtJam=substr(strip_tags($_POST['edtJam']),0,5);
			$edtJam=@explode(":",$edtJam);
			$edtJam=$edtJam[0].":".$edtJam[1];			
			$edtDurasi=substr(strip_tags($_POST['edtDurasi']),0,3);
			if ($_POST['submit']=="addshift") {
				$MySQL->Insert("setpmbdtl","IDPMBSETPMB,SHIFTSETPMB,WAKTUSETPMB,DURWKSETPMB","'$edtID','$edtShift','$edtJam','$edtDurasi'");
				$msg=$msg_insert_data;
				$act_log="Tambah Data Pada Tabel 'setpmbdtl' File 'jadwalpmb.php ";
			} else {
				$edtKd=$_POST['edtKd'];
				$MySQL->Update("setpmbdtl","SHIFTSETPMB='$edtShift',WAKTUSETPMB='$edtJam',DURWKSETPMB='$edtDurasi'","where setpmbdtl.IDX='".$edtKd."'","1");
				$msg=$msg_edit_data;
				$act_log="Update ID='$edtID' Pada Tabel 'setpmbdtl' File 'jadwalpmb.php ";
			}
		}
		
		if (($_POST['submit']=="Simpan") || ($_POST['submit']=="Update")){
			$edtKode=substr(strip_tags($_POST['edtKode']),0,9);
			$edtFormulir=substr(strip_tags($_POST['edtFormulir']),0,9);
			$edtThnAjaran=substr(strip_tags($_POST['edtThnAjaran']),0,4);
			$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
			$ThnSemester=$edtThnAjaran.$cbSemester;
			$edtGelombang=strtoupper(substr(strip_tags($_POST['edtGelombang']),0,4));
			$edtTglAwl=substr(strip_tags($_POST['edtTglAwl']),0,10);
			$edtTglAwl=@explode("-",$edtTglAwl);
			$edtTglAwl=$edtTglAwl[2]."-".$edtTglAwl[1]."-".$edtTglAwl[0];
			$edtTglAkh=substr(strip_tags($_POST['edtTglAkh']),0,10);
			$edtTglAkh=@explode("-",$edtTglAkh);
			$edtTglAkh=$edtTglAkh[2]."-".$edtTglAkh[1]."-".$edtTglAkh[0];
			$edtTglReg=substr(strip_tags($_POST['edtTglReg']),0,10);
			$edtTglReg=@explode("-",$edtTglReg);
			$edtTglReg=$edtTglReg[2]."-".$edtTglReg[1]."-".$edtTglReg[0];
			$edtNama=substr(strip_tags($_POST['edtNama']),0,70);
			$cbPegawai=substr(strip_tags($_POST['cbPegawai']),0,15);
		    $pegawai=LoadPegawai_X("","$cbPegawai");
			$rbUji=substr(strip_tags($_POST['rbUji']),0,1);
			$edtTglUji=substr(strip_tags($_POST['edtTglUji']),0,10);
			$edtTglUji=@explode("-",$edtTglUji);
			$edtTglUji=$edtTglUji[2]."-".$edtTglUji[1]."-".$edtTglUji[0];
			$edtKapasitas=substr(strip_tags($_POST['edtKapasitas']),0,3);
		
			if (($_POST['submit']=='Simpan')){
					$MySQL->Insert("setpmbupy","KDPMBSETPMB,KDFRMSETPMB,TAPMBSETPMB,GEPMBSETPMB,TGAWLSETPMB,TGAKHSETPMB,TGREGSETPMB,LGPMBSETPMB,NIKKASETPMB,NMPMBSETPMB,METODSETPMB,TGUJISETPMB,KAPSTSETPMB","'$edtKode','$edtFormulir','$ThnSemester','$edtGelombang','$edtTglAwl','$edtTglAkh','$edtTglReg','$edtNama','$cbPegawai','$pegawai','$rbUji','$edtTglUji','$edtKapasitas'");
					$msg=$msg_insert_data;
					$act_log="Tambah Data Pada Tabel 'setpmbupy' File 'setpmb.php ";
			} else {
					$edtID=substr(strip_tags($_POST['edtID']),0,11);
					$MySQL->Update("setpmbupy","KDPMBSETPMB='$edtKode',KDFRMSETPMB='$edtFormulir',TAPMBSETPMB='$ThnSemester',GEPMBSETPMB='$edtGelombang',TGAWLSETPMB='$edtTglAwl',TGAKHSETPMB='$edtTglAkh',TGREGSETPMB='$edtTglReg',LGPMBSETPMB='$edtNama',NIKKASETPMB='$cbPegawai',NMPMBSETPMB='$pegawai',METODSETPMB='$rbUji',TGUJISETPMB='$edtTglUji',KAPSTSETPMB='$edtKapasitas'","where IDX=".$edtID,"1");
					$msg=$msg_edit_data;
					$act_log="Update ID='$edtID' Pada Tabel 'setpmbupy' File 'setpmb.php ";
			}
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
	
	if (isset($_GET['p']) && (($_GET['p'] != 'delete') && ($_GET['p'] != 'refresh'))) {
		$formtitle="Edit Data";
		if (isset($_GET['id'])) {
			$edtID=$_GET['id'];
			$MySQL->Select("*","setpmbupy","where IDX='".$edtID."'","","1");
			$show=$MySQL->fetch_array();
			$edtKode=$show['KDPMBSETPMB'];
			$edtFormulir=$show['KDFRMSETPMB'];
			$edtThnAjaran=substr($show['TAPMBSETPMB'],0,4);
			$cbSemester=substr($show['TAPMBSETPMB'],4,1);
			$edtGelombang=$show['GEPMBSETPMB'];
			$edtTglAwl=DateStr($show['TGAWLSETPMB']);
			$edtTglAkh=DateStr($show['TGAKHSETPMB']);
			$edtNama=$show['LGPMBSETPMB'];
			$cbPegawai=$show['NIKKASETPMB'];
			$rbUji=$show['METODSETPMB'];
			$edtTglUji=DateStr($show['TGUJISETPMB']);
			$edtKapasitas=$show['KAPSTSETPMB'];
			$edtTglReg=DateStr($show['TGREGSETPMB']);
			$submited="Update";
		} else {
			$formtitle="Tambah Data";
			$edtKode="";
			$edtFormulir="";
			$edtThnAjaran="";
			$cbSemester="";
			$edtGelombang="";
			$edtTglAwl="";
			$edtTglAkh="";
			$edtNama="";
			$cbPegawai="";
	  		$rbUji="0";
			$edtTglUji="";
			$edtKapasitas="";
			$edtTglReg="";
			$submited="Simpan";
		}
		if (($_GET['p']=='add') || ($_GET['p']=='edit')) {
?>
			<form name="form1" action="./?page=setpmb" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<input type="hidden" name="edtID" size="11" maxlength="11" value="<?php echo $edtID; ?>" />
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr>
			<th colspan="2">Form <?php echo $formtitle; ?> Pelaksanaan Peneriman Mahasiswa Baru</th>
			</tr>
			<tr>
			<th colspan="2">&nbsp;</th>
			</tr>
			<tr>
			 <td style="width:150px;" >Kode PMB</td>
			 <td>: <input type="text" name="edtKode" size="9" maxlength="9" value="<?php echo $edtKode; ?>" realname ="Kode PMB" /></td>
			</tr>
			<tr>
			 <td style="width:150px;" >Kode Formulir</td>
			 <td>: <input type="text" name="edtFormulir" size="9" maxlength="9" value="<?php echo $edtFormulir; ?>"  required="1" regexp="/^\d*$/" realname ="Kode Formulir" /></td>
			</tr>
			<tr>
			 <td>Tahun Akademik</td>
			 <td class="mandatory">: <input type="text" name="edtThnAjaran" id="edtThnAjaran" size="4" maxlength="4" value="<?php echo $edtThnAjaran; ?>" required="1" regexp="/^\d*$/" realname ="Tahun" />
	<?php	
			LoadKode_X('cbSemester',"$cbSemester",95);
	?>
			 </td>
			</tr>
			<tr>		
			 <td>Gelombang</td>
			 <td class="mandatory">: <input type="text" name="edtGelombang" id="edtGelombang" size="4" maxlength="4" value="<?php echo $edtGelombang; ?>" required="1" realname ="Gelombang" /></td>
			</tr>		
		  	<tr>
		    	<td>Waktu Pelaksanaan</td>
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
			 <td>Lembaga Pelaksana</td>
			 <td>: <input type="text" name="edtNama" size="100" maxlength="100" value="<?php echo $edtNama; ?>" /></td>
			</tr>
			<tr>
			 <td>Ka. Pelaksana</td>
			 <td>: <?php LoadPegawai_X("cbPegawai","$cbPegawai"); ?></td>
			</tr>
			<tr>
			 <td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			 <td colspan="2" class="mandatory">Pelaksanaan Ujian Masuk PMB</td>
			</tr>
			<tr>
			 <td>Tanggal Pelaksanaan</td>
			 <td>: 
	<?php
				if ($rbUji==0){
					$mtd0="checked='checked'";
				} else {
					$mtd1="checked='checked'";				
				}
	?>
				<input name='rbUji' type='radio' value='0' <?php echo $mtd0; ?>/>Setiap Hari&nbsp;
				<input name='rbUji' type='radio' value='1' <?php echo $mtd1; ?>/>Tetapkan Tanggal&nbsp;&nbsp;<input type="text" name="edtTglUji" size="10"  maxlength="10" value="<?php echo $edtTglUji; ?>" />
				<a href="javascript:show_calendar('document.form1.edtTglUji','document.form1.edtTglUji',document.form1.edtTglUji.value);">
		<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a>&nbsp;Diisi Jika Pelaksanaan Ujian Sesuai dengan Penetapan Tanggal Ujian
				</td>
			</tr>
			<tr>
			 <td>Kapasitas Maksimal</td>
			 <td>: <input type="text" name="edtKapasitas" size="3" maxlength="3" value="<?php echo $edtKapasitas; ?>" />&nbsp; Orang/Uji</td>
			</tr>		
		  	<tr><td colspan="2">&nbsp;</td></tr>
		  	<tr><td colspan="2" class="mandatory">Batas Terakhir bagi CMB yang diterima untuk Regristrasi Ulang</td></tr>
		  	<tr>
		    	<td>Batas Regristrasi</td>
		    	<td>: 
				<input type="text" name="edtTglReg" size="10"  maxlength="10" value="<?php echo $edtTglReg; ?>" /> 
		<a href="javascript:show_calendar('document.form1.edtTglReg','document.form1.edtTglReg',document.form1.edtTglReg.value);">
		<img src="include/calendar/cal.gif" alt="CAL" title="Klik untuk memunculkan kalender" border="0" height="16" width="16" align="absMiddle"></a>&nbsp;dd-mm-yyyy 			
				</td>
			</tr>
			<tr>
			 <td colspan="2" align="center">
			 <button type="reset"  onClick=window.location.href="./?page=setpmb"><img src="images/b_reset.gif" class="btn_img"/>&nbsp;Batal</button>&nbsp;
	            <button type="submit" name="submit" value="<?php echo $submited; ?>" /><img src="images/b_save.gif" class="btn_img">&nbsp;<?php echo $submited; ?></button>
			 </td>
			</tr>
			</table>
			</form>
			<br>
<?php
		}
		if (($_GET['p'] == 'addshift') || ($_GET['p']=='editshift')) {
			include "./jadwalpmb.php";
		}		
		if (($_GET['p'] != 'add')) {
			$edtID=$_GET['id'];
			echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			;
			echo "<tr><td colspan='7' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=setpmb&amp;p=addshift&amp;id=$edtID' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
		    echo "<tr><th colspan='7' style='background-color:#EEE'>Jadwal Ujian PMB</th></tr>";
		    echo "<tr>
		    <th style='width:300px;'>SHIFT</th>
		    <th>WAKTU</th> 
		    <th colspan='2' style='width:40px;'>ACT</th> 
		 	</tr>";
			$MySQL->Select("setpmbdtl.*","setpmbdtl","WHERE IDPMBSETPMB='".$edtID."'","setpmbdtl.SHIFTSETPMB ASC");
		    $no=1;
		    if ($MySQL->Num_Rows() > 0){
				while ($show=$MySQL->Fetch_Array()){
			    	$sel="";
					if ($no % 2 == 1) $sel="sel";
					$durasi=($show['DURWKSETPMB'] * 60);
					$waktuujian= New Time($show['WAKTUSETPMB']);
					$selesaiujian=$waktuujian->add($durasi);	
			     	echo "<tr>";
			     	echo "<td class='$sel tac'>".$show['SHIFTSETPMB']."</td>";
			     	echo "<td class='$sel tac'>".substr($show['WAKTUSETPMB'],0,5)." s.d. ".substr($selesaiujian,0,5)."</td>";	     	
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=setpmb&amp;p=editshift&amp;id=".$edtID."&amp;kd=".$show['IDX']."' ><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a></td>";
					echo "<td class='$sel tac'><a href='./?page=setpmbdtl&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a></td>";
			     	echo "</tr>";
		     	$no++;
		 		}
			} else {
				echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";
		 	}
		 	echo "</table>";
		}
	} else {
		 $MySQL->Select("setpmbupy.TAPMBSETPMB","setpmbupy","","TAPMBSETPMB DESC","1");
		 $show=$MySQL->fetch_array();
		 $curr_pmb=$show["TAPMBSETPMB"];
		 
	 	 if (!isset($_GET['pos'])) $_GET['pos']=1;
		 $page=$_GET['page'];
		 $p=$_GET['p'];
	     $sel="";
	     $cbSemester=$_REQUEST['cbSemester'];
		 if (!isset($_REQUEST['limit'])){
		    $_REQUEST['limit']="20";
		 }
		 if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
	
		 if (isset($p) && $p!=''){
			$URLa="page=".$page."&amp;p=".$p;	
		 } else{
			$URLa="page=".$page;		
		 }		
		
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		;
		
		echo "<form action='./?".$URLa."' method='post' >";
		echo "<tr><td colspan='3'>";
		echo "Jadwal PMB TA Sebelumnya : ";
	    echo "<input type='text' size='4' maxlength='4' name='key' value='".$_REQUEST['key']."'/>\n";
		LoadSemester_X("cbSemester","$cbSemester");			
	    echo "&nbsp;<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n</td>";
		 
		echo "<td colspan='4' align='right'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=setpmb&amp;p=refresh'><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	    echo "</td></tr></form>";
		echo "<tr><td colspan='7' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=setpmb&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
	    echo "<tr><th colspan='7' style='background-color:#EEE'>Pelaksanaan Penerimaan Mahasiswa Baru Tahun Akademik Berjalan</th></tr>";
	    echo "<tr>
	    <th style='width:50px;'>KODE</th> 
	    <th style='width:100px;'>TA/SEM/GEL</th> 
	    <th style='width:250px;'>PELAKSANA/<br>KETUA PELAKSANA</th> 
	    <th style='width:75px;'>TGL PELAKSANAAN</th> 
	    <th style='width:30px;'>WAKTU</th> 
	    <th colspan='2' style='width:20px;'>ACT</th> 
	 </tr>";

	    $qry = "where TAPMBSETPMB ='".$curr_pmb."'" ;
		if(!empty($_REQUEST['key'])){
			$ThnSemester_pmb=$key.$cbSemester;
	      	$qry = " where TAPMBSETPMB like '".$ThnSemester_pmb."%'";
	  	}
		$MySQL->Select("*","setpmbupy",$qry,"","","0");
		$total=$MySQL->Num_Rows();
		$perpage=$_REQUEST['limit'];
		$totalpage=ceil($total/$perpage);
		$start=($_GET['pos']-1)*$perpage;
	    $MySQL->Select("setpmbupy.*,(DATEDIFF(setpmbupy.TGAKHSETPMB,setpmbupy.TGAWLSETPMB)+1) AS JMLHARI","setpmbupy",$qry,"setpmbupy.TGAWLSETPMB DESC","$start,$perpage");
	    $no=1;
	    if ($MySQL->Num_Rows() > 0){
			while ($show=$MySQL->Fetch_Array()){
		    	$sel="";
				if ($no % 2 == 1) $sel="sel";
		     	//set tahun ajaran
				$thn=substr($show['TAPMBSETPMB'],0,4);
		     	$TA=$thn."/".($thn+1);
		     	//set semester
		     	$semester="Gasal";
		     	if (substr($show['TAPMBSETPMB'],4,1)=="2") $semester="Genap";
		     	echo "<tr>";
		     	echo "<td class='$sel tac'>".$show['KDPMBSETPMB']."</td>";
		     	echo "<td class='$sel'>".$TA."<br>".$semester."<br>".$show['GEPMBSETPMB']."</td>";
		     	echo "<td class='$sel'>".$show['LGPMBSETPMB']." /<br>".$show['NIKKASETPMB']." - ".$show['NMPMBSETPMB']."</td>";
		     	echo "<td class='$sel'>".DateStr($show['TGAWLSETPMB'])." s.d.<br>".DateStr($show['TGAKHSETPMB'])."</td>";
		     	echo "<td class='$sel tar'>".$show['JMLHARI']." hari</td>";	     	
				echo "<td class='$sel tac'><a href='./?page=setpmb&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=setpmb&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
		     	echo "</td>";
		     	echo "</tr>";
	     	$no++;
	 		}
		} else {
			echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";		
	 	}
	 	echo "</table>";
	 	include "navigator.php";
	}
}
?>

