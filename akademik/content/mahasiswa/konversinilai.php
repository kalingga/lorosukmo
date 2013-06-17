<?php
$idpage='28';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$mahasiswa_dtl=GetMhsBaruDetail_X($user_admin);
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
	
	echo "<table border='0' align='center' style='width:80%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	echo "<tr>
		<th style='width:50px;'>NO</th>
		<th style='width:100px;'>KODE</th>
		<th>MATAKULIAH</th>
		<th style='width:60px;'>SKS</th>
		<th style='width:60px;'>NILAI</th></tr>";
    
	$MySQL->Select("trnlmupy.IDX,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SKSMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE trnlmupy.ISKONTRNLM='1'AND trnlmupy.NIMHSTRNLM = '".$nim."'","trnlmupy.KDKMKTRNLM ASC","");
	$row=$MySQL->Num_Rows();
	if ($row > 0){
		$i=0;
		while ($show=$MySQL->Fetch_Array()){
			$data[$i][0] = $show['IDX'];
			$data[$i][1] = $show['KDKMKTRNLM'];
			$data[$i][2] = $show['NAMKTBLMK'];
			$data[$i][3] = $show['SKSMKTRNLM'];
			$data[$i][4] = $show['NLAKHTRNLM'];
			$data[$i][5] = $show['BOBOTTRNLM'];
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
			echo "<tr>";
	     	echo "<td class='$sel tar'>".$no."&nbsp;</td>";
	     	echo "<td class='$sel tac'>".$data[$i][1]."</td>";
	     	echo "<td class='$sel'>".$data[$i][2]."</td>";
	     	echo "<td class='$sel tac'>".$data[$i][3]."</td>";
	     	echo "<td class='$sel tac'>".$data[$i][4]."</td>";
	     	echo "</tr>";
	     	$no++;
		}
		$ip_sem= 0;
		if ($jml_nilai > 0 ) {
			$ip_sem = ($jml_nilai / $jml_SKS);
		}
		echo "<tr><td colspan='2'>Jumlah SKS</td>";			     	
		echo "<td colspan='3'>: ".$jml_SKS." SKS</td></tr>";
		echo "<tr><td colspan='2'>Jumlah Nilai</td>";			     	
		echo "<td colspan='3'>: ".$jml_nilai."</td></tr>";
		echo "<tr><td colspan='2'>IP SEM</td>";			     	
		echo "<td colspan='3'>: ".$ip_sem."</td></tr>";
	} else {
		echo "<td colspan='5' align='center' style='color:red;'>".$msg_data_empty."</td>";		
	}
	echo "</table><br>";
}
?>
