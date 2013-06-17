<?php
$idpage='18';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit']) && ($_POST['submit']=='proses')) {
  		$id_mk_arr=$_POST['id_mk_arr']; 
  		$succ=array();
  		$fail=array();
  
  		if (count($id_mk_arr)>0){
  			$i=0;
	  		foreach($id_mk_arr as $id_mk=>$value){
	  			$MySQL->Select("KDPSTTBKMK,KDKMKTBKMK,SKSMKTBKMK,SEMESTBKMK,NODOSTBKMK,NMDOSTBKMK","tbkmkupy","where IDX='".$id_mk."'");
	  			$show=$MySQL->fetch_array();
	  			$id[$i]=$id_mk;
	  			$prodi[$i]=$show['KDPSTTBKMK'];
	  			$mk[$i]=$show['KDKMKTBKMK'];
	  			$sks[$i]=$show['SKSMKTBKMK'];
	  			$semes[$i]=$show['SEMESTBKMK'];
	  			$nidn[$i]=$show['NODOSTBKMK'];
	  			$nmdos[$i]=$show['NMDOSTBKMK'];
				$i++;	
	  		}
	  		
	  		for ($j=0; $j < $i; $j++){
				$MySQL->insert("tbmksajiupy","THSMSMKSAJI,KDPSTMKSAJI,KDKMKMKSAJI,IDKMKMKSAJI,SKSMKMKSAJI,SEMESMKSAJI,NODOSMKSAJI,NMDOSMKSAJI","'$ThnSemester','$prodi[$j]','$mk[$j]','$id[$j]','$sks[$j]','$semes[$j]','$nidn[$j]','$nmdos[$j]'");
//					if ($MySQL->exe) $succ[]=$id_mk; else $fail[]=$id_mk;
				//echo $MySQL->qry;
				if ($MySQL->exe) $succ[]=$mk[$j]; else $fail[]=$mk[$j];
			}
	  		
  		}   
  		if (count($succ)>0){
    		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
    		echo "Transfer Data Matakuliah<br>".implode(',',$succ)."<br>Sukses!";
    		echo "</div>";
  		}
  		if (count($fail)>0){
    		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    		echo "Transfer Data Matakuliah<br>".implode(',',$fail)."<br>Gagal! / Data Sudah Di proses";
    		echo "</div>";
  		}
	}
	
	if (isset($_GET['p']) && $_GET['p']=='delete') {
		$id=$_GET['id'];
		$MySQL->Delete("tbmksajiupy","where KDKMKMKSAJI='".$id."'","");
	    if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tbmksajiupy' File 'mksaji.php' Sukses!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'tbmksajiupy' File 'mksaji.php' Gagal!";
			AddLog($id_admin,$act_log);
		    echo $msg_delete_data_0;
		}		
	}
	
	if ((isset($_GET['p']) && $_GET['p']=='add') || isset($_POST['act'])) {
		if (($_GET['p']=='add') || ($_POST['act'])) {
			$cbProdi=substr(strip_tags($_POST['cbProdi']),0,2);
			if (isset($_POST['cbProdi'])) 
				$cbProdi=$_REQUEST['cbProdi'];
			else
				$cbProdi=$akses_user;
			$MySQL->Select("MAX(tbkmkupy.THSMSTBKMK) AS LASTKUR","tbkmkupy","where KDPSTTBKMK='".$cbProdi."'","","1");
			$show=$MySQL->fetch_array();
			$lastkur=$show["LASTKUR"];


?>
			<form name="form1" action="./?page=mksaji" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
				<tr><th colspan="2">Form Tambah Data Matakuliah Saji</th></tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td width="30%">Silahkan Masukkan Program Studi</td>
					<td>: 
<?php
					if ($level_user!='2') {
						LoadProdi_X("cbProdi","$cbProdi",$akses_user,"required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Program Studi yang Ada!'");
					} else {
						echo LoadProdi_X("",$akses_user);
						echo "<input type='hidden' name='cbProdi' id='cbProdi' size='2' maxlength='2' value='$akses_user' />";
					}
?>			
					</td>
				</tr>
				<tr>
					<td>Tahun Akademik Berjalan</td>
					<td>: 
						<input type="text" name="ThnAjaran" id="ThnAjaran" size="4" maxlength="4" value="<?php echo $ThnAjaran; ?>" required="1" regexp = "/^\d/" realname = "Tahun Ajaran" />
<?php
						LoadSemester_X("cbSemester","$cbSemester","required='1' exclude='-1' err='Pilih Salah Satu dari Daftar Semester yang Ada!'");
?>			
					</td>
				</tr>
				<tr>
					<td colspan="2" class="tac">
						<br>
						<button type="button" onclick=window.location.href="./?page=mksaji" /><img src="images/b_back.png" class="btn_img">&nbsp;Kembali</button>
						<button type="submit" name="act" value="Submit" />Submit&nbsp;<img src="images/b_go.png" class="btn_img"></button>
					</td>
				</tr>
			</table>
			</form>
<?php
			//Tampilkan matakuliah kurikulum tahun semester terakhir
			echo "<form name='form1' action='./?page=mksaji' method='post' >";
			echo "<input type='hidden' name='edtProdi' value='$cbProdi' />";			
		    echo "<table border='0' align='center' style='width:99%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
			$qry ="LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK)";
			//$qry .=" WHERE (tbkmkupy.KDPSTTBKMK = '".$cbProdi."' AND tbkmkupy.THSMSTBKMK = '".$lastkur."' AND tbkmkupy.SEMESTBKMK IN $curr_semester)";
			$qry .=" WHERE (tbkmkupy.KDPSTTBKMK = '".$cbProdi."' AND tbkmkupy.THSMSTBKMK = '".$lastkur."')";


			$MySQL->Select("tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NODOSTBKMK,tbkmkupy.NMDOSTBKMK","tbkmkupy",$qry,"tbkmkupy.SEMESTBKMK ASC,tbkmkupy.KDKMKTBKMK ASC","","0");
		   	//echo $MySQL->qry;
			//echo "prodi : $akses_user";
			echo "<tr>
		    <th style='width:40px;'>ACT</th>
		    <th style='width:100px;'>KODE MK</th> 
		    <th>MATAKULIAH</th> 
		    <th style='width:50px;'>SKS</th> 
		    <th style='width:50px;'>SEM</th>
		    <th style='width:300px;'>DOSEN PENGAMPU</th> 	     
		    </tr>";	
		    $no=1;
		 	if ($MySQL->Num_Rows() > 0){
		    	while ($show=$MySQL->Fetch_Array()){
			    	echo "<tr>";
					$sel="";
					if ($no % 2 == 1) $sel="sel"; 
			     	echo "<td class='tac $sel fs11'>";
					echo "<input type='checkbox' class='cbx' name='id_mk_arr[".$show['IDX']."]' />";
			     	echo "</td>";
			     	echo "<td class='$sel'>".$show['KDKMKTBKMK']."</td>";
			     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
			    	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
			    	echo "<td class='$sel tac'>".$show['SEMESTBKMK']."</td>";
			    	echo "<td class='$sel'>".$show['NMDOSTBKMK']." - ".$show['NODOSTBKMK']."</td>";
			     	echo "</tr>";
			        $no++;
			    }
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td colspan='6'  class='tal'>";
			echo "<br>&nbsp;&nbsp;<input type='checkbox' class='cbx' onclick='flipflop(this.form,this)' /> Check/UnCheck All&nbsp;&nbsp;<button type='submit' name='submit' value='proses' />Proses&nbsp;<img src='images/b_go.png' class='btn_img'></button>";
			echo "</td></tr>";
		    echo "</table>";
			echo "</form>";
		}				
	} else {
		echo "<form action='./?page=mksaji' method='post' >";
		echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr><th>Matakuliah Saji TA. Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester","$cbSemester");			
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form>";	
		echo "<table border='0' align='center' style='width:90%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
		echo "<tr><td colspan='7'><button type=\"button\" style='tar' onClick=window.location.href='./?page=mksaji&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
		echo "<tr><th colspan='7' style='background-color:#EEE'>MATAKULIAH SAJI TA. '".$ThnAjaran."/".($ThnAjaran + 1)."' SEM. '".LoadSemester_X('',$cbSemester)."'</th></tr>";
		for ($i=0;$i < $jml_master; $i++) {
			$qry ="LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) ";
			$qry .="LEFT OUTER JOIN tbkmkupy ON (tbmksajiupy.IDKMKMKSAJI = tbkmkupy.IDX) ";
			$qry .="WHERE tbmksajiupy.THSMSMKSAJI ='".$ThnSemester."' ";	     
			$qry .="AND tbmksajiupy.KDPSTMKSAJI ='".$id_pst[$i]."'";	     
			echo "<tr><td colspan='7' class='fwb'>PROGRAM STUDI : ".$nm_pst[$i]."</td></tr>";
			$MySQL->Select("DISTINCT tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NODOSTBKMK,tbkmkupy.NMDOSTBKMK","tbmksajiupy",$qry,"tbkmkupy.SEMESTBKMK,tbmksajiupy.KDKMKMKSAJI","");
			echo "<tr>
			<th style='width:40px;'>NO</th>
			<th style='width:75px;'>KODE MK</th> 
			<th>MATAKULIAH</th> 
			<th style='width:30px;'>SKS</th> 
			<th style='width:30px;'>SEM</th>
			<th style='width:250px;'>DOSEN PENGAMPU</th>
			<th style='width:20px;'>ACT</th>
			</tr>";	
	
			$no=1;
			if ($MySQL->Num_Rows() > 0){
				while ($show=$MySQL->Fetch_Array()){
			    	echo "<tr>";
					$sel="";
					if ($no % 2 == 1) $sel="sel"; 
			     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
			     	echo "<td class='$sel'>".$show['KDKMKMKSAJI']."</td>";
			     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
			    	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
			    	echo "<td class='$sel tac'>".$show['SEMESTBKMK']."</td>";
			    	echo "<td class='$sel'>".$show['NODOSTBKMK']." - ".$show['NMDOSTBKMK']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=mksaji&amp;p=delete&amp;id=".$show['KDKMKMKSAJI']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			        $no++;
			    }
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='7'>".$msg_data_empty."</td></tr>";
			}
			echo "<tr><td colspan='7'  class='tal'>&nbsp;</td></tr>";
		}
		echo "</table><br>";
	}
}


function Action($kd_mk,$akses) {
	global $MySQL;
	$akses = trim($akses,"()");
	$akses = @explode(",",$akses);
	$privelage = count($akses); 
	$MySQL->Select("tbmksajiupy.KDPSTMKSAJI","tbmksajiupy","WHERE tbmksajiupy.KDKMKMKSAJI ='".$kd_mk."'");
	$show=$MySQL->fetch_array();
	for ($i=0;$i < $privilage;$i++) {
		$akses[$i]=trim($akses[$i],"'");
		if ($akses[$i] == $show["KDPSTMKSAJI"]) {
			True;
		} else {
			false;
		}
		if (True) {
			return true;
		}
	} 
}
?>