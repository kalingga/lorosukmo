<?php
$idpage='28';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit'])) {
		$cbNilai=$_POST['cbNilai'];
		
		$nilai_count=count($cbNilai);
		$succ=array();
		$fail=array();

		if ($_POST['submit']=='Simpan') {
			for ($i=0;$i < $nilai_count; $i++){
				$data[$i]=@explode(",",$cbNilai[$i]);
				$nilai[$i]=$data[$i][0];
				$bobot[$i]=$data[$i][1];
				$id_mk[$i]=$data[$i][2];
				if ($nilai[$i]!= -1 ) {
					$MySQL->Update("trnlmupy","NLAKHTRNLM='$nilai[$i]',BOBOTTRNLM='$bobot[$i]',STATUTRNLM='1'","where trnlmupy.IDX='$id_mk[$i]'");
					//if ($MySQL->exe) $succ[]=$id_mk[$i]; else $fail[]=$id_mk[$i];
				}
				
			}
			
			// cari ID di tabel trnlm
			$nim = $_POST['nim'];
      $MySQL->Select("trnlmupy.IDX","trnlmupy","WHERE trnlmupy.ISKONTRNLM='1'AND trnlmupy.NIMHSTRNLM = '".$nim."'","trnlmupy.KDKMKTRNLM ASC","");
			$row=$MySQL->Num_Rows();
			if ($row > 0){
      $arr = array();
      $arrId = array();
      $x = 0;				
				while ($show=$MySQL->Fetch_Array()){
					// nilai asal yang dikonversi per baris
          $idtabel = $show['IDX']; 
          $kodeMKAsal = $_POST['kodemk'.$idtabel];
          $namaMKAsal = $_POST['namamk'.$idtabel];
          $sksAsal = $_POST['sks'.$idtabel];
          $nilaiAsal = $_POST['nilai'.$idtabel];  
          
          // simpan data transkrip asal ke array dulu
          $arr[$x] = "asalNilai='$nilaiAsal',asalSKS='$sksAsal',asalKodeMK='$kodeMKAsal',asalNamaMK='$namaMKAsal'";
          $arrId[$x] = "where trnlmupy.IDX='$idtabel'";
          
        
         // echo "CAPTURED DATA :::::: $kodeMKAsal - $namaMKAsal -  $sksAsal - $nilaiAsal --- "."kodemk".$show['IDX']." <br />";        					
					$x++;
				}
				// simpan data transkrip asal ke database
				for($i=0; $i < $x; $i++){
          $MySQL->Update("trnlmupy",$arr[$i],$arrId[$i]);
        }
			}
			
		// ===============	
			
	  		if (count($succ)>0){
	    		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
	    		echo "Data ".implode(',',$succ)." Berhasil Diupdate!";
	    		echo "</div>";
	    		$act_log = "Tambah Data ID=".implode(',',$succ)." pada tabel 'trnlmupy' file 'konversinilai.php' Sukses!";
	  		}
	  		if (count($fail)>0){
	    		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
	    		echo "Maaf!, Update Data ".implode(',',$fail)." Gagal!.<br>Pastikan Data yang Anda Masukkan Benar!";
	    		echo "</div>";
	    		$act_log = "Tambah Data ID=".implode(',',$succ)." pada tabel 'trnlmupy' file 'konversinilai.php' Gagal! &";
	  		}	
		}	
	}
	
	if (isset($_GET['p']) && $_GET['p'] != 'refresh') {
		$id=$_GET['id'];
		$mahasiswa_dtl=GetMhsBaruDetail_X($id);
		$mahasiswa_dtl=@explode(",",$mahasiswa_dtl);
		
		$show["NMMHSMSMHS"].",".$show["NIMHSMSMHS"].",".$show["TPLHRMSMHS"].",".$show["TGLHRMSMHS"].",".$show["KDFAKMSPST"].",".$show["ASPSTMSMHS"].",".$show["ASPTIMSMHS"].",".$show["KDPSTMSMHS"].",".$show["TAHUNMSMHS"].",".$show["KDJENMSPST"].",".$show["KDSTAMSPST"];		
		$nama=$mahasiswa_dtl[0];
		$nim=$mahasiswa_dtl[1];
		$tplLahir=$mahasiswa_dtl[2];
		$tglLahir=$mahasiswa_dtl[3];
		$fakultas=$mahasiswa_dtl[4];
		$pst_asal=$mahasiswa_dtl[5];
		$pt_asal=$mahasiswa_dtl[6];
		$prodi=$mahasiswa_dtl[7];
		$thn_masuk=$mahasiswa_dtl[8];
		$jenjang=$mahasiswa_dtl[9];
		$akreditasi=$mahasiswa_dtl[10];
		$kurikulum=Get_Curr_kurikulum($prodi);
//echo $MySQL->qry; // fungsi cari kurikulum
		if ($_GET['p']=='add') {
			echo $thn;
			/*********** Tampilkan Kurikulum ****************/
			/************************************************/
			$MySQL->Select("DISTINCT tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK","tbkmkupy","LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.THSMSTBKMK = '".$kurikulum."' AND tbkmkupy.KDPSTTBKMK = '".$prodi."'","","","0");
//echo $kurikulum;
//echo "<br>";			
//echo $MySQL->qry;
			echo "<table border='0' align='center' style='width:80%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr>
				<th style='width:50px;'>NO</th>			
				<th style='width:100px;'>KODE</th>
				<th>MATAKULIAH</th>
				<th style='width:60px;'>SKS</th>
				<th style='width:20px;'>ACT</th></tr>";
	    
			if ($MySQL->num_rows() > 0 ) {
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";  
			     	echo "<td class='$sel tac'>".$show['KDKMKTBKMK']."</td>";
			     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
			     	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=konversinilai&amp;p=ins&amp;id=$id&amp;mk=".$show['IDX']."'><img border='0' src='images/b_go.png' title='INSERT DATA' /></a>";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;
				}
			} else {
				echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";
			}
			echo "</table><br>";
			echo "<div class='tac'><button type='reset' onClick=window.location.href='./?page=konversinilai&amp;p=edit&amp;id=$id' /><img src='images/b_cancel.gif' class='btn_img'/>&nbsp;Batal</button></div>";
		} else {
			if ($_GET['p']=='ins'){
				$mk=$_GET['mk'];
				$MySQL->Select("tbkmkupy.KDKMKTBKMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK","tbkmkupy","where tbkmkupy.IDX='".$mk."'","","1");
				$show=$MySQL->fetch_array();
				$kdmk=$show['KDKMKTBKMK'];
				$sks=$show['SKSMKTBKMK'];
				$semes=$show['SEMESTBKMK'];
				$succ=0;
				$MySQL->insert("trnlmupy","THSMSTRNLM,NIMHSTRNLM,IDKMKTRNLM,KDKMKTRNLM,SKSMKTRNLM,SEMESTRNLM,ISKONTRNLM","'$ThnSemester','$nim','$mk','$kdmk','$sks','$semes','1'");
				$act_log="Tambah Data Pada Tabel 'trnlmupy' File 'konversinilai.php' ";
				if ($MySQL->exe) {
					$succ=1;
				}
				
				if ($succ==1) {
					$act_log .= "Sukses!";
					echo $msg_insert_data;	
				} else {
					$act_log .= "Gagal!";
					echo $msg_update_0;
				}
				AddLog($id_admin,$act_log);
			}
			
			// ==========================================================================//

			if ($_GET['p']=='delete'){
				$mk=$_GET['mk'];
				$MySQL->Delete("trnlmupy","where IDX=".$mk,"1");
				if ($MySQL->exe){
					$act_log="Hapus ID='$mk' Pada Tabel 'trnlmupy' File 'konversinilai.php' Sukses!";
					AddLog($id_admin,$act_log);
			    	echo $msg_delete_data;
				} else {
					$act_log="Hapus ID='$mk' Pada Tabel 'trnlmupy' File 'konversinilai.php' Gagal!";
					AddLog($id_admin,$act_log);
			    	echo $msg_delete_data_0;
				}
			}

			echo "<table width=80% align='center'>";
			echo "<tr><td colspan='4' class='fwb tac'>KONVERSI NILAI</td></tr>";
			echo "<tr><td colspan='4'>&nbsp;</td></tr>";
			echo "<tr><td width='15%'>Nama Mahasiswa</td>";
			echo "<td>: ".$nama."</td>";
			echo "<td width='10%'>NPM</td>";
			echo "<td width='38%'>: ".$nim."</td><tr>";

			echo "<tr><td>Tempat, Tgl Lahir</td>";
			echo "<td>: ".$tplLahir.", ".DateStr($tglLahir)."</td>";
			echo "<td>Fakultas</td>";
			echo "<td>: ".LoadFakultas_X("",$fakultas)."</td><tr>";
			
			echo "<tr><td>Pendidikan Asal</td>";
			echo "<td>: ".LoadProdiDikti_X("",$pst_asal).".".LoadPT_X("",$pt_asal)."</td>";
			echo "<td>Program Studi</td>";
			echo "<td>: ".LoadProdi_X("",$prodi)."</td><tr>";


			echo "<tr><td>Tahun Masuk</td>";
			echo "<td>: ".$thn_masuk."</td>";
			echo "<td>Jenjang/Status</td>";
			echo "<td>: ".LoadKode_X("",$jenjang,"04")."/".LoadKode_X("",$akreditasi,"07")."</td><tr>";
			echo "</table>";
			
			echo "<form action='./?page=konversinilai' method='post' >";
			echo "<table border='0' align='center' style='width:90%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr><td colspan='12' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=konversinilai&amp;p=add&amp;id=$id' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
			echo "<th rowspan=2>NO</th> 
        <th colspan=4 >ASAL</th>
        <th colspan=4>KONVERSI</th>
        <th rowspan=2>AKSI</th>";
        
      // ================== edited by Adi ====================================// 
			echo "<tr>
				
				<th style='width:100px;'>KODE</th>
				<th style='width:200px;'>MATAKULIAH</th>
				<th style='width:60px;'>SKS</th>
				<th style='width:60px;'>NILAI</th>
				
				<th style='width:100px;'>KODE</th>
				<th style='width:200px;'>MATAKULIAH</th>
				<th style='width:60px;'>SKS</th>
				<th style='width:60px;'>NILAI</th>";
		    
			$MySQL->Select("trnlmupy.IDX,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SKSMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM,asalKodeMK, asalNamaMK, asalSKS, asalNilai",
      "trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE trnlmupy.ISKONTRNLM='1'AND trnlmupy.NIMHSTRNLM = '".$nim."'","trnlmupy.KDKMKTRNLM ASC","");
			$row=$MySQL->Num_Rows();
echo $MySQL->qry;			
if ($row > 0){
				$i=0;
				while ($show=$MySQL->Fetch_Array()){
					$data[$i][0] = $show['IDX'];
					$data[$i][1] = $show['KDKMKTRNLM'];
					$data[$i][2] = $show['NAMKTBLMK'];
					$data[$i][3] = $show['SKSMKTRNLM'];
					$data[$i][4] = $show['NLAKHTRNLM'];
					$data[$i][5] = $show['BOBOTTRNLM'];
					
					$data[$i][6] = $show['asalKodeMK'];
					$data[$i][7] = $show['asalNamaMK'];
					$data[$i][8] = $show['asalSKS'];
					$data[$i][9] = $show['asalNilai'];
					$i++;
				}
				
				$no=1;
				$jml_SKS=0;
				$jml_nilai = 0;
				for ($i=0; $i < $row ; $i++) {
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					$name= 'cbNilai['.$i.']';
					$id_mk_arr=$data[$i][0];
					$sks_arr=$data[$i][3];
					$jml_SKS += $sks_arr;
					$jml_nilai += ($sks_arr * $data[$i][5]);
          
          echo "<input type='hidden' name='nim' value='$nim'>";
          
					echo "<tr>";
			     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";			     	
			     	echo "<td><input type='text' name='kodemk".$data[$i][0]."'  style='width:70px;' value='".$data[$i][6]."'></td>";
			     	echo "<td><input type='text' name='namamk".$data[$i][0]."' style='width:170px;' value='".$data[$i][7]."'></td>";
			     	echo "<td align=center><input type='text' name='sks".$data[$i][0]."'  style='width:25px;' value='".$data[$i][8]."'></td>";
			     	echo "<td align=center><input type='text' name='nilai".$data[$i][0]."' style='width:25px;' value='".$data[$i][9]."'></td>";
			     	echo "<td class='$sel tac'>".$data[$i][1]."</td>";
			     	echo "<td class='$sel'>".$data[$i][2]."</td>";
			     	echo "<td class='$sel tac'>".$data[$i][3]."</td>";
			     	echo "<td class='$sel tac'>";
					LoadNilai_X($name,$data[$i][4],$id_mk_arr,$sks_arr,"","required='1' exclude='-1' err='Pilih Salah Satu Dari Daftar Nilai yang Ada!'");
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=konversinilai&amp;p=delete&amp;id=$id&amp;mk=".$data[$i][0]."'><img border='0' src='images/b_drop.png' title='HAPUS DATA' /></a>";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;
				}
				$ip_sem= 0;
				if ($jml_nilai > 0 ) {
					$ip_sem = ($jml_nilai / $jml_SKS);
				}
				echo "<tr><td colspan='7' align=right>Jumlah SKS</td>";			     	
				echo "<td colspan='4'> ".$jml_SKS." SKS</td></tr>";
				echo "<tr><td colspan='7' align=right>Jumlah Nilai</td>";			     	
				echo "<td colspan='4'> ".$jml_nilai."</td></tr>";
				echo "<tr><td colspan='7' align=right>IP SEM</td>";			     	
				echo "<td colspan='4'> ".$ip_sem."</td></tr>";
			} else {
				echo "<tr><td colspan='10' align='center' style='color:red;'>".$msg_data_empty."</td></tr>";		
			}
			echo "</table><br>";
			echo "<div class='tac'><button type='reset' onClick=window.location.href='./?page=konversinilai' /><img src='images/b_cancel.gif' class='btn_img'/>&nbsp;Batal</button>
	            <button type='submit' name='submit' value='Simpan'/><img src='images/b_save.gif' class='btn_img'>&nbsp;Simpan</button></div></form>";
	    }
	} else {
		echo "<form action='./?page=konversinilai' method='post' >";
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Mahasiswa Pindahan TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		echo "&nbsp;@&nbsp;";
		LoadProdi_X("cbProdi",$cbProdi);
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form><br>";	
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		echo "<form action='./?page=konversinilai' method='post' >";
		echo "<tr><td colspan='4'>Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='NIMHSMSMHS') $sel2="selected='selected'";
		if ($field=='NMMHSMSMHS') $sel3="selected='selected'";
	
	    echo "<option value='NIMHSMSMHS' $sel2 >NP MAHASISWA</option>";
	    echo "<option value='NMMHSMSMHS' $sel3 >NAMA MAHASISWA</option>";
	     
	    echo "</select>";
	    echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "</td><td colspan='5' align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=konversinilai&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";
	    echo "</td></tr></form>";
	
	  	$qry ="LEFT JOIN mspstupy mspstupy on msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST where msmhsupy.STPIDMSMHS = 'P' AND SMAWLMSMHS='".$ThnSemester."' AND msmhsupy.KDPSTMSMHS IN $prive_user ";
	  		  	
		if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
		 	$qry .= "and ".$field." like '%".$_REQUEST['key']."%'";			
		}
			
		$MySQL->Select("msmhsupy.*,mspstupy.NMPSTMSPST AS PROGRAMSTUDI","msmhsupy",$qry,"msmhsupy.KDPSTMSMHS ASC,msmhsupy.NIMHSMSMHS ASC","","0");
	   	$total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
	
		$MySQL->Select("msmhsupy.*,mspstupy.NMPSTMSPST AS PROGRAMSTUDI","msmhsupy",$qry,"msmhsupy.KDPSTMSMHS ASC,msmhsupy.NIMHSMSMHS ASC","$start,$perpage","0");
	
	     echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR MAHASISWA PINDAHAN TA. ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1)." SEM. ".LoadSemester_X("",substr($ThnSemester,4,1))."</th></tr>";
	     echo "<tr>
	     <th style='width:20px;'>NO</th> 
	     <th style='width:100px;'>NPM</th> 
	     <th style='width:300px;'>NAMA MAHASISWA</th> 
	     <th  colspan='2'>PROGRAM STUDI</th>
	     <th style='width:20px;'>ACT</th>
	     </tr>";
	     $no=1;
	     $i=0;
		 if ($MySQL->Num_Rows() > 0){
		     while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
				if ($no % 2 == 1) $sel="sel";
				//$PILIHAN2= LoadProdi_X("",$show['PLHN2TBPMB']);
		     	echo "<tr>";
		     	echo "<td class='$sel'>".$no."</td>";
		     	echo "<td class='$sel'>".$show['NIMHSMSMHS']."</td>";
		     	echo "<td class='$sel'>".$show['NMMHSMSMHS']."</td>";
		    	echo "<td class='$sel' colspan='2'>".$show['PROGRAMSTUDI']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=konversinilai&amp;p=edit&amp;&amp;id=".$show['NIMHSMSMHS']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$data[$i] = $show['NIMHSMSMHS'];
		     	$no++;
		     	$i++;
		     }
		} else {
		     	echo "<tr><td align='center' style='color:red;' colspan='9'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='9'>";
	 	include "navigator.php";
		echo "</td></tr>";
	    echo "</table><br>";
	}
}
?>
