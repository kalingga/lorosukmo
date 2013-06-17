<?php
$idpage='29';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit'])) {
		$cbNilai=$_POST['cbNilai'];
		$nilai_count=count($cbNilai);
		$succ=array();
		$fail=array();
		
		for ($i=0;$i < $nilai_count;$i++){
			$data[$i]=@explode(",",$cbNilai[$i]);
			$nilai[$i]=$data[$i][0];
			$bobot[$i]=$data[$i][1];
			$id_mk[$i]=$data[$i][2];
			$MySQL->Update("trnlmupy","NLAKHTRNLM='$nilai[$i]',BOBOTTRNLM='$bobot[$i]'","where IDX='".$id_mk[$i]."'");
			
//echo "trnlmupy"." - NLAKHTRNLM='$nilai[$i]',BOBOTTRNLM='$bobot[$i]'"." - where IDX='".$id_mk[$i];
	
			if ($MySQL->exe)  $succ[]=$id_mk[$i]; else $fail[]=$id_mk[$i];
		}
  		if (count($succ)>0){
    		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
    		echo "Data ".implode(',',$succ)." Berhasil Diupdate!";
    		echo "</div>";
    		$act_log = "Update ID=".implode(',',$succ)." pada tabel 'trnlmupy' Sukses!";
  		}
  		if (count($fail)>0){
    		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    		echo "Maaf!, Update Data ".implode(',',$fail)." Gagal!.<br>Pastikan Data yang Anda Masukkan Benar Dihapus!";
    		echo "</div>";
    		$act_log = "Update ID=".implode(',',$succ)." pada tabel 'trnlmupy' Gagal! &";
  		}		  
	}
	if (isset($_GET['p']) && $_GET['p']=='view') {
		$id=$_GET['id'];
		$MySQL->Select("trnlmupy.IDX,trnlmupy.NIMHSTRNLM,msmhsupy.NMMHSMSMHS,trnlmupy.NLAKHTRNLM,trnlmupy.SKSMKTRNLM","trnlmupy","LEFT OUTER JOIN msmhsupy ON (trnlmupy.NIMHSTRNLM = msmhsupy.NIMHSMSMHS) WHERE trnlmupy.IDXMKSAJI = '".$id."' and STATUTRNLM='1'","trnlmupy.NIMHSTRNLM","");		

echo "<div class='tac fwb'>ISIAN HASIL STUDI MAHASISWA</div><br>";
		echo "<form action='./?page=isianhs' method='post' >";
		echo "<table border='0' align='center' style='width:60%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr>
			<th style='width:30px;'>NO</th>
			<th style='width:75px;'>NIM</th> 
			<th>MAHASISWA</th> 
			<th style='width:60px;'>NILAI</th> 
		</tr>";
		$row=$MySQL->num_rows();
		if ($row > 0){
			$i=0;
			while ($show=$MySQL->Fetch_Array()){
				$data[$i][0]=$show["IDX"];
				$data[$i][1]=$show["NIMHSTRNLM"];
				$data[$i][2]=$show["NMMHSMSMHS"];
				$data[$i][3]=$show["NLAKHTRNLM"];
				$data[$i][4]=$show["SKSMKTRNLM"];
				$i++;
			}
			$no=1;
			$i=0;
			for ($i=0;$i < $row;$i++ ){
				$sel1="sel";
				if ($no % 2 == 1) $sel1="";
				echo "<tr><td class='$sel1 tac'>".$no."</td>
					<td class='$sel1'>".$data[$i][1]."</td>
					<td class='$sel1'>".$data[$i][2]."</td>
					<td class='$sel1 tac'>";
					$id_mk_arr =$data[$i][0];
					$sks_arr=$data[$i][4];
					$name= 'cbNilai['.$i.']';
					LoadNilai_X($name,$data[$i][3],$id_mk_arr,$sks_arr,"","required='1' exclude='-1' err='Pilih Salah Satu Dari Daftar Nilai yang Ada!'");
					echo "</td></tr>";
					$no++;
			}
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
		}
		echo "</table><br>";				
		echo "<div class='tac'><button type=\"button\" onClick=window.location.href='./?page=isianhs'><img src=\"images/b_cancel.gif\" class=\"btn_img\"/>&nbsp;Batal</button>
			&nbsp;<button type=\"submit\" name='submit' value='simpan'><img src=\"images/b_save.gif\" class=\"btn_img\"/>&nbsp;Simpan</button></div></form><br>";
	} else {	
		echo "<form action='./?page=isianhs' method='post' >";
		echo "<table border='0' align='center' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' ><tr><th>";
		echo "Nilai Akhir Mahasiswa TA Sebelumnya : ";
		echo "<input type='text' size='4' maxlength='4' name='ThnAjaran' value='".$ThnAjaran."'/>\n";
		LoadSemester_X("cbSemester",$cbSemester);
		echo "&nbsp;<b>@</b>&nbsp;";
		LoadProdi_X("cbProdi","");
		echo "&nbsp;<button type=\"submit\">GO&nbsp;<img src=\"images/b_go.png\" class=\"btn_img\"/></button>\n</th>";
		echo "</tr></table></form><br>";
			
		echo "<table border='0' align='center' style='width:95%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
		echo "<tr>
			<th style='width:30px;'>NO</th>
			<th style='width:75px;'>KODE MK</th> 
			<th style='width:350px;'>MATAKULIAH</th> 
			<th style='width:40px;'>KELAS</th>
			<th>PENGAJAR</th> 
			<th style='width:20px;'>ACT</th>
		</tr>";
			
		for ($i=0;$i < $jml_master;$i++){
			echo "<tr><td colspan='6' class='fwb' style='background-color:#EEE;'>PROGRAM STUDI : ".$nm_pst[$i]."</td></tr>";
			$MySQL->Select("tbmksajiupy.IDX,tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","tbmksajiupy","LEFT OUTER JOIN tblmkupy ON tbmksajiupy.KDKMKMKSAJI=tblmkupy.KDMKTBLMK WHERE tbmksajiupy.THSMSMKSAJI='".$ThnSemester."' AND KELASMKSAJI IS NOT NULL AND tbmksajiupy.KDPSTMKSAJI = '".$id_pst[$i]."'","tbmksajiupy.KDKMKMKSAJI ASC","");
//			echo $MySQL->qry;
			$no=1;
			if ($MySQL->Num_Rows() > 0){
				while ($show=$MySQL->Fetch_Array()){
			    	echo "<tr>";
					$sel="";
					if ($no % 2 == 1) $sel="sel";
					echo "<td class='$sel tar'>".$no."&nbsp;</td>";
			     	echo "<td class='$sel'>".$show['KDKMKMKSAJI']."</td>";
			     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
			    	echo "<td class='$sel tac'>".$show['KELASMKSAJI']."</td>";
			    	echo "<td class='$sel'>".$show['NMDOSMKSAJI']." - ".$show['NODOSMKSAJI']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=isianhs&amp;p=view&amp;id=".$show['IDX']."' ><img border='0' src='images/b_view.png' title='LIHAT DATA' /></a> ";
			     	echo "</td></tr>";
		    		$no++;
		    	}
			} else {
				echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
			}
		}
		echo "</table>";
	}
}
?>