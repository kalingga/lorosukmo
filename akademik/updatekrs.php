<?php
$idpage='21';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
	$LastKRS=GetLastKRS();
	$krsBefore = getKRSBefore();
	
	$curr_akses= date("Y-m-d",$_SERVER['REQUEST_TIME']);
	$curr_date=@explode("-",$curr_akses);
	$curr_month=$curr_date[1];
	$curr_year=$curr_date[0];

	if ($id_group=='2') {
		$edtNIM=$user_admin;
		if(getBPMStatus($edtNIM, $krsBefore)){
    		   echo "<meta http-equiv='refresh' content='0; url=http://upy.ac.id/angket/'>";
       	   exit;
		}
	}
	if (isset($_POST['submit'])) {
		$edtNIM=substr(strip_tags($_POST['edtNIM']),0,15);
	}

	if (isset($_GET['nim'])) {
		$edtNIM=$_GET['nim'];
	}	
	//*** Cari Identitas Mahasiswa *****/
	$MySQL->Select("KDPSTMSMHS,NIMHSMSMHS,NMMHSMSMHS,DSNPAMSMHS","msmhsupy","where NIMHSMSMHS='".$edtNIM."'","","1");
	$show=$MySQL->fetch_array();
	$nim=$show['NIMHSMSMHS'];
	$mahasiswa=$show['NMMHSMSMHS'];
	$prodi=$show['KDPSTMSMHS'];
	$fakultas=substr($show['KDPSTMSMHS'],0,1);
	$dosenpa=LoadDosen_X("",$show['DSNPAMSMHS']);
	$nidn=$show['DSNPAMSMHS'];

	if (isset($_GET['p']) && ($_GET['p']=='delete')) {
		$id=$_GET['id']; 
		$MySQL->Delete("trnlmupy","where IDX=".$id,"1");
    	if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'trnlmupy' File 'updatekrs.php' Sukses!";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'trnlmupy' File 'updatekrs.php.php' Gagal!";
			AddLog($id_admin,$act_log);
	    	echo $msg_delete_data_0;
		}		
	}	

	if ((($id_group != "2") && (!isset($_POST['submit']))) && (!isset($_GET['p'])) && (!isset($_GET['nim']))) {
	/*** jika id_admin user akses selain mahasiswa maka ditampilkan form isian
	untuk menghandle mahasiswa yang terlambat secara administrasi dalam melakukan
	pengisian KRS *****/
?>
		<form name="form1" action="./?page=updatekrs" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
		<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan="2">Form Perubahan KRS</th></tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><td width="25%">Silahkan Masukkan NPM Mahasiswa</td>
				<td class="inputtext">: <input size="15" type="text" name="edtNIM" maxlength="15" >
			  </tr>
			<tr>
			<td colspan="2">&nbsp;</td>
			</tr>
		    <tr>
			    <td colspan="2" align="center">
		            <button type="reset" /><img src="images/b_cancel.gif" class="btn_img">&nbsp;Batal</button>
		            <button type="submit" name="submit" value="submit" />Submit&nbsp;<img src="images/b_go.png" class="btn_img"></button>
				</td>
		    </tr>
			</table>
		</form>
<?php
	} else {
		if ($_POST['submit']=='simpan') {
			$id=$_POST['edtID'];
			$MySQL->Update("tbkrsupy","DIACCTBKRS=0","where IDX='$id'","1");
			$act_log="Update ID=$id Pada Tabel 'tbkrsupy' File 'updatekrs.php' ";
			if ($MySQL->exe) {
				echo $msg_edit_data;
		  		$act_log .="Sukses!";
				AddLog($id_admin,$act_log);
			}
		}
				
		if (isset($_GET['p']) && $_GET['p']=='ins') {

			//Transfer matakuliah yang dipilih
			//========
			$jml_sks_now = $_SESSION['jml_sks'];
			$periodeSblm = "";
			if(substr($LastKRS,4,5) == "1"){
			     $periodeSblm = (substr($LastKRS,0,4) - 1)."2";		
			}else{
			     $periodeSblm = $LastKRS - 1;
			}	
	
			$id=$_GET['id'];
			$MySQL->Select("tbmksajiupy.THSMSMKSAJI,tbmksajiupy.IDKMKMKSAJI,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.IDX,tbmksajiupy.KELASMKSAJI,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI","tbmksajiupy","WHERE tbmksajiupy.IDX = '".$id."'","","1");
			$show=$MySQL->fetch_array();
			$thn=$show["THSMSMKSAJI"];
			$idkmk=$show["IDKMKMKSAJI"];
			$mk=$show["KDKMKMKSAJI"];
			$idx=$show["IDX"];
			$kelas=$show["KELASMKSAJI"];
			$sks=$show["SKSMKMKSAJI"];
			$semes=$show["SEMESMKSAJI"];
			$prasyarat=CekSyarat($idkmk,$edtNIM);	
			$batasSKS = CekLimitSKS($edtNIM,$periodeSblm,($jml_sks_now + $sks));				
			$statusMK=GetStatMK($mk,$edtNIM);			

			if ($prasyarat AND $batasSKS) {
				$succ=0;
				$MySQL->insert("trnlmupy","THSMSTRNLM,NIMHSTRNLM,IDKMKTRNLM,KDKMKTRNLM,IDXMKSAJI,KELASTRNLM,SKSMKTRNLM,SEMESTRNLM,STAMKTRNLM","'$thn','$edtNIM','$idkmk','$mk','$idx','$kelas','$sks','$semes','$statusMK'");
				$act_log="Tambah Data Pada Tabel 'trnlmupy' File 'updatekrs.php' ";
				if ($MySQL->exe){
					$succ=1;
				}
				if ($succ==1) {
					$msg=$msg_insert_data;
			  		$act_log .="Sukses!";
				} else {
					$msg=$msg_update_0;
					$act_log .="Gagal!";
				}
				echo $msg;
				AddLog($id_admin,$act_log);
			}
		}
		if (isset($_GET['p']) && $_GET['p']=='add') {
		/***** Tampilkan Jadwal Matakuliah Saji Sesuai dengan 
		****** Program Studi dan Tahun Semester Mahasiswa Bersangkutan ****/
			if (!isset($_GET['pos'])) $_GET['pos']=1;
			$page=$_GET['page'];
			$p=$_GET['p'];
			$URLa="page=".$page."&amp;p=".$p."&amp;nim=".$_GET['nim'];
			$sel="";
			$field=$_REQUEST['field'];
			if (!isset($_REQUEST['limit'])){
				$_REQUEST['limit']="20";
			}
	
			echo "<table border='0' style='width:100%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
			echo "<form action='./?$URLa' method='post' >";
			echo "<tr><td>";
			echo "Pencarian Berdasarkan : <select name='field'>";
			if ($field=='tbkmkupy.KDKMKTBKMK') $sel1="selected='selected'";
			if ($field=='tblmkupy.NAMKTBLMK') $sel2="selected='selected'";
			if ($field=='tbkmkupy.SEMESMKSAJI') $sel2="selected='selected'";
			echo "<option value='tbkmkupy.KDKMKTBKMK' $sel1 >KODE MK</option>";
			echo "<option value='tblmkupy.NAMKTBLMK' $sel2 >MATAKULIAH</option>";
			echo "<option value='tbkmkupy.SEMESTBKMK' $sel2 >SEMESTER</option>";
			echo "</select>";
			echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
			echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button></td>\n";
			echo "<td class='tar'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
			echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?$URLa'><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;</td>";	 
			echo "</td></tr></table></form>";

			$qry ="LEFT JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK)";
			$qry .=" WHERE tbmksajiupy.THSMSMKSAJI = '".$LastKRS."' AND tbmksajiupy.KDPSTMKSAJI='".$prodi."'";
				     
			if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
			 	$qry .= " and ".$field." like '%".$_REQUEST['key']."%'";			
			}
	
			$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI","tbmksajiupy",$qry,"tbmksajiupy.KDPSTMKSAJI ASC,tbmksajiupy.KDKMKMKSAJI ASC","","0");
			$total=$MySQL->Num_Rows();
			if ($total <= 0){
				echo $data_not_found;
			}
			$perpage=$_REQUEST['limit'];
			$totalpage=ceil($total/$perpage);
			$start=($_GET['pos']-1)*$perpage;	
			$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI","tbmksajiupy",$qry,"tbmksajiupy.KDPSTMKSAJI ASC,tbmksajiupy.KDKMKMKSAJI ASC","$start,$perpage");
			$row=$MySQL->Num_Rows();
			$i=0;
			while ($show=$MySQL->Fetch_Array()){
				$data[$i][0]=$show['IDX'];
				$data[$i][1]=$show['KDKMKMKSAJI'];
				$data[$i][2]=$show['NAMKTBLMK'];
				$data[$i][3]=$show['SKSMKMKSAJI'];
				$data[$i][4]=$show['SEMESMKSAJI'];
				$i++;	
			}
			echo $btnTambah;
			echo "<table border='0' style='width:100%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
			echo "<tr>
			<th style='width:20px;'>NO</th> 
			<th style='width:40px;'>KODE MK</th> 
			<th style='width:175px;'>MATAKULIAH</th> 
			<th style='width:20px;'>SKS</th> 
			<th style='width:20px;'>SEM</th>
			<th colspan='2'>DETAIL MATAKULIAH</th>
			</tr>";
			$no=1;
			if ($row > 0){
			//	    	while ($show=$MySQL->Fetch_Array()){
				for ($i=0;$i < $row; $i++){
			    	echo "<tr>";
					$sel="";
					if ($no % 2 == 1) $sel="sel"; 
			     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
			     	echo "<td class='$sel'>".$data[$i][1]."</td>";
			    	echo "<td class='$sel'>".$data[$i][2]."</td>";
			    	echo "<td class='$sel tac'>".$data[$i][3]."</td>";
			    	echo "<td class='$sel tac'>".$data[$i][4]."</td>";
			     	echo "<td class='$sel' colspan='2'>";
					//********** Tabel Detail
			     	$MySQL->Select("tbmksajiupy.IDX,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI,tbmksajiupy.RUANGMKSAJI,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI",
             "tbmksajiupy",
             "WHERE tbmksajiupy.KDKMKMKSAJI = '".$data[$i][1]."' 
				     AND tbmksajiupy.THSMSMKSAJI = '".$LastKRS."'",
             "tbmksajiupy.KELASMKSAJI ASC","");
			
			     	echo "<table border='0' style='width:100%;' cellpadding='2' cellspacing='1' class='tblbrdr' >";
			     	$no1=0;
				    echo "<tr>";
			   		echo "<th style='width:20px;'>KLS</th> 
			   			<th style='width:200px;'>JADWAL</th> 
						<th style='width:200px;'>DOSEN PENGAMPU</th>
			   			<th style='width:20px;'>ACT</th>";
				    echo "</tr>";	
					while ($detail=$MySQL->fetch_array()){
						$sel1="sel";
						$durasi=($detail['DURSIMKSAJI']*60);
						$mulai= New Time($detail['MULAIMKSAJI']);
						$selesai=$mulai->add($durasi);
						
						if ($no1 % 2 == 1) $sel1="";
				     	echo "<tr><td class='$sel1 tac'>".$detail['KELASMKSAJI']."</td>";
				    	echo "<td class='$sel1' style='width:20px;'>".$detail['HRPELMKSAJI']." ";
				    	echo "".substr($detail['MULAIMKSAJI'],0,5)." - ".substr($selesai,0,5).", ";
				     	echo "".$detail['RUANGMKSAJI']."</td>";
				    	echo "<td class='$sel1' style='width:250px;'>".$detail['NMDOSMKSAJI']." - ".$detail['NODOSMKSAJI']."</td>";			    	
				     	echo "<td class='tac $sel1'>";
						echo "<a href='./?page=updatekrs&amp;p=ins&amp;nim=".$_GET['nim']."&amp;id=".$detail['IDX']."'><img border='0' src='images/b_go.png' title='EDIT DATA' /></a> ";
			 			echo "</td></tr>";
						$no1++;	
					}
			     	echo "</table>";
			     	echo "</tr>";
			        $no++;
			    }
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td colspan='7'class='tal'>";
			include "navigator.php";
			echo "</td></tr>";
			echo "</table>";
			echo "<center><button type='button' onClick=window.location.href='./?page=updatekrs&amp;nim=$edtNIM' /><img src='images/b_back.png' class='btn_img'>&nbsp;Kembali</button></center><br>";
		} else {
			$akses=1;
			if ($id_group=="2") {
			/*** Bila user akses sebagai mahasiswa
			check waktu KRS *****/
				$CekWaktuKRS=CekWaktuKRS($curr_akses,$LastKRS);
				if (!$CekWaktuKRS) $akses=0;
			}			
			if ($akses==1) {
			/****** Default Tampilkan Form isian KRS ****************/
?>
			<table border='0' style='width:97%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1' >
			  <tr><td width="15%">Nama Mahasiswa</td>
			  	  <td width="45%">: <?php echo $mahasiswa; ?></td>
			  	  <td width="15%">No. Pokok Mhs</td>
			  	  <td>: <?php echo $nim; ?></td>
			  	  <td rowspan="4" align="right">
				  </td>
			  </tr>
			  <tr><td>Fakultas</td>
			      <td>: <?php echo LoadFakultas_X("",$fakultas); ?></td>
				  <td>Kel. Registrasi</td>  	  
				  <td>:&nbsp;</td>  	  
			  </tr>
			  <tr>
			  	  <td>Progran Strudi</td>
			  	  <td>: <?php echo LoadProdi_X("",$prodi);?></td>
			  	  <td>Semester</td>
			  	  <td>:&nbsp;<?php echo LoadKode_X("",substr($LastKRS,4,1),"95"); ?></td>
			  </tr>
			  <tr><td>Nama Dosen PA.</td>
			  	  <td>:&nbsp;<?php echo $dosenpa; ?></td>
			  	  <td>Tahun Akademik</td>
			  	  <td>:&nbsp;<?php echo substr($LastKRS,0,4)."/".((substr($LastKRS,0,4))+1); ?></td>
			  </tr>
			</table>
			<table border='0' style='width:97%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1' class='tblbrdr' >
			<tr><td colspan='9' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=updatekrs&amp;p=add&amp;nim=<?php echo $nim; ?>' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>
				<tr>
					<th style="width:20px">No</th>
		   			<th style="width:75px">Kode MK </th>
		    		<th style="width:300px">Matakuliah</th>
		   			<th style="width:20px">Kls</th>
		   			<th style="width:20px">Sem</th>
		    		<th style="width:20px">SKS</th>
		    		<th style="width:20px">B/U/P</th>
		    		<th>Nama Dosen</th>
		    		<th style="width:40px">ACT</th>
				</tr>		
<?php	
				$MySQL->Select("trnlmupy.IDX,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.KELASTRNLM,trnlmupy.SEMESTRNLM,trnlmupy.SKSMKTRNLM,trnlmupy.STATUTRNLM,trnlmupy.STAMKTRNLM,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) LEFT OUTER JOIN tbmksajiupy ON (trnlmupy.IDXMKSAJI = tbmksajiupy.IDX) WHERE trnlmupy.THSMSTRNLM='".$LastKRS."' and trnlmupy.NIMHSTRNLM='".$edtNIM."' AND trnlmupy.ISKONTRNLM <> '1'","IDX ASC");
				$jmlSKS=0;
				$i=0;
				while ($show=$MySQL->fetch_array()){
					$data[$i][0]=$show["IDX"];
					$data[$i][1]=$show["KDKMKTRNLM"];
					$data[$i][2]=$show["NAMKTBLMK"];
					$data[$i][3]=$show["KELASTRNLM"];
					$data[$i][4]=$show["SEMESTRNLM"];
					$data[$i][5]=$show["SKSMKTRNLM"];
					$data[$i][6]=$show["NMDOSMKSAJI"]." [".$show["NODOSMKSAJI"]."]";
					$data[$i][7]=$show["STATUTRNLM"];
					$data[$i][8]=$show["STAMKTRNLM"];
					$jmlSKS += $data[$i][5];
					$flag[$i]="1";
					$i++;
				}		
				$_SESSION['jml_sks'] = $jmlSKS;  			
		
				$no=1;
				for ($j=0;$j < 12;$j++ ){
					$sel1="sel";
					if ($no % 2 == 1) $sel1="";
					echo "<tr><td class='$sel1 tac'>".$no."</td>
						<td class='$sel1'>".$data[$j][1]."</td>
						<td class='$sel1'>".$data[$j][2]."</td>
						<td class='$sel1 tac'>".$data[$j][3]."</td>
						<td class='$sel1 tac'>".$data[$j][4]."</td>
						<td class='$sel1 tac'>".$data[$j][5]."</td>
						<td class='$sel1 tac'>".$data[$j][8]."</td>
						<td class='$sel1'>".$data[$j][6]."</td>
						<td class='$sel1 tac'>";
						if ($flag[$j]=="1") {
							echo "<a href='./?page=updatekrs&amp;p=delete&amp;nim=".$nim."&amp;id=".$data[$j][0]."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a>";
						}
						echo "</td></tr>";
						$no++;
				}
				echo "<tr><th colspan='5'>Jumlah SKS :</th><th colspan='4'>".$jmlSKS." SKS</th></tr>";
				echo "</table>";
				
				echo "<table width='97%' align='center'>
				  	<tr><td width='9%' rowspan='3'>";
			//************* Cetak KRS ********************//
					echo "<form action=\"cetak_krs.php\" method=\"post\" target=\"pdf_target\">";
					echo "<input type=\"image\" onclick=\"form.submit\" src=\"images/b_print_pdf.png\" title=\"CETAK KE PDF\" />";
					$i=0;
					$mhs[$i][0]="Nama Mahasiswa";
					$mhs[$i][1]=": ".$mahasiswa;;
					$mhs[$i][2]="No. Pokok Mhs";
					$mhs[$i][3]=": ".$nim;
					$i++;
					$mhs[$i][0]="Fakultas";
					$mhs[$i][1]=": ".LoadFakultas_X("","$fakultas");
					$mhs[$i][2]="Kel. Registrasi";
					$mhs[$i][3]=": ";
					$i++;
					$mhs[$i][0]="Progran Strudi";
					$mhs[$i][1]=": ".LoadProdi_X("","$prodi");
					$mhs[$i][2]="Semester";
					$mhs[$i][3]=": ".LoadKode_X("",substr($LastKRS,4,1),"95");
					$i++;
					$mhs[$i][0]="Nama Dosen PA.";
					$mhs[$i][1]=": ".$dosenpa;
					$mhs[$i][2]="Tahun Akademik";
					$mhs[$i][3]=": ".substr($LastKRS,0,4)."/".((substr($LastKRS,0,4))+1);
					for ($j=0;$j < $i; $j++){
						echo "<input type=\"hidden\" name=\"mhs[$j][0]\" value=\"".$mhs[$j][0]."\" />";			
						echo "<input type=\"hidden\" name=\"mhs[$j][1]\" value=\"".$mhs[$j][1]."\" />";			
						echo "<input type=\"hidden\" name=\"mhs[$j][2]\" value=\"".$mhs[$j][2]."\" />";			
						echo "<input type=\"hidden\" name=\"mhs[$j][3]\" value=\"".$mhs[$j][3]."\" />";			
					}
					$width1="30,100,30,45"; // 160
					$width2="7,20,66,8,8,8,8,67"; // 160
					$_SESSION[PREFIX.'mhs']=$mhs;
					$_SESSION[PREFIX.'data']=$data;
			
					$_SESSION[$PREFIX.'nip_penandatangan']=$nidn;	
					$_SESSION[$PREFIX.'nama_penandatangan']=$dosenpa;
					
					$mahasiswa .= ",".$nim;
					echo "<input type=\"hidden\" name=\"mahasiswa\" value=\"".$mahasiswa."\" /><br>";
					echo "<input type=\"hidden\" name=\"width1\" value=\"".$width1."\" /><br>";
					echo "<input type=\"hidden\" name=\"width2\" value=\"".$width2."\" /><br>";
					echo "</form>";	 
	  				echo "</td>
    				<td width='91%' align='center'>";
    				//cari idx dari tbkrs;
					$MySQL->Select("IDX","tbkrsupy","where THSMSTBKRS='".$LastKRS."' and NIMHSTBKRS='".$edtNIM."'","1");
					$show=$MySQL->fetch_array();
					echo "<form action='./?page=updatekrs' method='post'>";
					echo "<input type='hidden' name='edtID' value='$show[IDX]' />
					<input type='hidden' name='edtNIM' value='$edtNIM' />
					<button type='reset' name='reset' onClick=window.location.href='./?page=updatekrs'><img src='images/b_back.png' class='btn_img'/>&nbsp;Kembali</button>				
					<button type='submit' name='submit' value='simpan'><img src='images/b_save.gif' class='btn_img'/>&nbsp;Simpan</button></form>";
				echo "</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr></table>";
			}
		}
	}
}

function GetLastKRS(){
	global $MySQL;
	$MySQL->Select("DISTINCT MAX(setkrsupy.TASMSSETKRS) AS LASTKRS","setkrsupy","","","1");
	$show=$MySQL->fetch_array();
	return $show["LASTKRS"];	
}

function getKRSBefore(){
	global $MySQL;
	$MySQL->Select("DISTINCT (setkrsupy.TASMSSETKRS) AS KRSBEFORE","setkrsupy","WHERE TASMSSETKRS < (SELECT MAX(TASMSSETKRS) FROM setkrsupy)",
	"setkrsupy.TASMSSETKRS DESC","1");
	//echo $MySQL->qry;
	$show=$MySQL->fetch_array();
	//echo $show["KRSBEFORE"];
	return $show["KRSBEFORE"];	
}

function CekWaktuKRS($curr_akses,$thn){
	global $MySQL;
	$MySQL->Select("TGAWLSETKRS,TGAKHSETKRS","setkrsupy","where TASMSSETKRS='".$thn."'","","1");
	$show=$MySQL->fetch_array();
	$mulaikrs=$show["TGAWLSETKRS"];
	$bataskrs=$show["TGAKHSETKRS"];
	$curr_akses= New Date($curr_akses);
	$curr_akses_1=$curr_akses->isBetween($mulaikrs,$bataskrs);
	if (!$curr_akses_1) {
		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
		echo "Maaf!, Waktu Perubahan KRS Telah Melewati Batas Akhir!";
		echo "<br>Silahkan Anda Konfirmasi ke Bagian Akademik!";
		echo "</div>";		
		return false;
	} else {
		return true;
	}		
}

function CekSyarat($idkmk,$nim){
	global $MySQL;
	$MySQL->Select("KDSYATBKMK,KDKMKTBKMK","tbkmkupy","where IDX='".$idkmk."'","THSMSTBKMK DESC","1");
	$show=$MySQL->fetch_array();
	$mk=$show["KDKMKTBKMK"];
	$prasyarat=$show["KDSYATBKMK"];
	
	if (($prasyarat=="") || (is_null($prasyarat)) || ($prasyarat=="-1")){
		return True;
	} else {
		$MySQL->Select("KDKMKTRNLM","trnlmupy","where KDKMKTRNLM = '".$prasyarat."' and NIMHSTRNLM='".$nim."'","","");
		if ($MySQL->num_rows() > 0){
			return true;
		} else {
			echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    		echo "Pengambilan Matakuliah ".$mk." Tidak Diijinkan Sebelum Memenuhi Syarat!";
    		echo "</div>";
    		return false;
		}
	}
}

function CekLimitSKS($nim,$thnSmt, $sks){
	global $MySQL;
	$MySQL->Select("(SUM(MUTU) / SUM(SKSMKTRNLM)) AS IP",
          "(SELECT trnlmupy.SKSMKTRNLM,
            IFNULL(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM,0) AS MUTU
            FROM
            trnlmupy 
            LEFT JOIN msmhsupy ON NIMHSTRNLM = NIMHSMSMHS      
            WHERE NIMHSTRNLM = '$nim'              
	     AND trnlmupy.BOBOTTRNLM IS NOT NULL	
            AND trnlmupy.THSMSTRNLM = '".$thnSmt."' 
	     AND trnlmupy.ISKONTRNLM <> '1') AS nilai"); //trnlmupy.ISKONTRNLM <> '1'
            
        
	$show=$MySQL->fetch_array();
	$ip=$show["IP"];
	if($ip == null){
//	    echo "IP MASIH NULL di PERIODE $thnSmt";
      	    $limit = 24;
  	}else{    	
    	  if($ip >= 3){
         	$limit = 24;
      	  }else if(($ip >= 2.49) and ($ip < 3)){
         	$limit = 21;
         }else if(($ip >= 1.99) and ($ip < 2.49)){
         	$limit = 18;
         }else if(($ip >= 1.49) and ($ip < 1.99)){
         	$limit = 15;
         }else if(($ip >= 1) and ($ip < 1.49)){
         	$limit = 12;
         }else if(($ip < 1)){
         	$limit = 12;
         }
       }

		
	if ($limit >= $sks){
			return true;
	} else {
			echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    	echo "Penambahan tidak diijinkan karena melebihi batas maksimum KRS Anda yaitu <b>". $limit."</b> SKS, sesuai IP anda semester sebelumnya <b>".substr($ip,0,4)."</b>";
    	echo "</div>";
    	return false;
	}
	
}

function getBPMStatus($nim, $periode){
  global $MySQL;
	$MySQL->Select("*",
		"bpm_status","WHERE bpmNim = '".$nim."' AND bpmPeriode = '".$periode."'","","1");
	$show=$MySQL->Num_Rows();
	if ($show == 0) {
		$status= true;
	} else {
	  $status= false;
  }
  
  return $status;

}



function GetStatMK($mk,$nim) {
	global $MySQL;
	$MySQL->Select("COUNT(trnlmupy.KDKMKTRNLM) AS JMLMK",
		"trnlmupy","WHERE trnlmupy.KDKMKTRNLM = '".$mk."' AND trnlmupy.NIMHSTRNLM = '".$nim."'","","1");
	$show=$MySQL->fetch_array();
	if ($show['JMLMK'] <= '0') {
		$status='B';
	} else {
		$MySQL->Select("trnlmupy.NLAKHTRNLM","trnlmupy","WHERE trnlmupy.KDKMKTRNLM = '".$mk."' AND trnlmupy.NIMHSTRNLM = '".$nim."'","","1");
		$show=$MySQL->fetch_array();
		$nilai=$show['NLAKHTRNLM'];
		switch ($nilai) {
			case 'B': $status='P';
					  break;
			case 'C': $status='P';
					  break;
			case 'D': $status='U';
					  break;
			case 'E': $status='U';
					  break;
		}
	}
	return $status;
}
?>