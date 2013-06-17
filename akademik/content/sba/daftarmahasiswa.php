<?php
$idpage='13';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	//echo $idpage." ".$sm_akses_arr[$idpage];

	$pst="(".$akses_user.")";
	if ($level_user=='1') {
		$pst= GetProdiInFakultas($akses_user);
	}
	if (isset($_GET['p']) && $_GET['p']=='edit') {
		include "./datamahasiswa.php";
	} else {
		if (isset($_POST['submit'])){
			$edtID=$_POST['edtID'];
			$edtNIM=$_POST['edtNIM'];
			//Form 1
			$rbKelBelajar=substr(strip_tags($_POST['rbKelBelajar']),0,1);
			$edtKelBelajar=substr(strip_tags($_POST['edtKelBelajar']),0,10);
			$edtNama=substr(strip_tags($_POST['edtNama']),0,30);
			$rbJK=substr(strip_tags($_POST['rbJK']),0,1);
			$edtTglLahir=substr(strip_tags($_POST['edtTglLahir']),0,10);
			$edtTglLahir=@explode("-",$edtTglLahir);
			$edtTglLahir=$edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
			$edtTempatLahir=substr(strip_tags($_POST['edtTempatLahir']),0,20);
			$edtKabLahir=substr(strip_tags($_POST['edtKabLahir']),0,20);
			$cbPropLahir=substr(strip_tags($_POST['cbPropLahir']),0,2);
			$rbNegara=substr(strip_tags($_POST['rbNegara']),0,1);
			$edtNegara=substr(strip_tags($_POST['edtNegara']),0,20);
			$cbAgama=substr(strip_tags($_POST['cbAgama']),0,1);
			$cbStatusSipil=substr(strip_tags($_POST['cbStatusSipil']),0,1);
			$edtAlamat=substr(strip_tags($_POST['edtAlamat']),0,30);
			$edtKelurahan=substr(strip_tags($_POST['edtKelurahan']),0,20);
			$edtKecamatan=substr(strip_tags($_POST['edtKecamatan']),0,20);
			$edtKota=substr(strip_tags($_POST['edtKota']),0,20);
			$cbPropinsi=substr(strip_tags($_POST['cbPropinsi']),0,2);
			$edtKodePos=substr(strip_tags($_POST['edtKodePos']),0,5);
			$edtTelpon=substr(strip_tags($_POST['edtTelpon']),0,20);
			$edtAlamatDIY=substr(strip_tags($_POST['edtAlamatDIY']),0,30);
			$edtKelurahanDIY=substr(strip_tags($_POST['edtKelurahanDIY']),0,20);
			$edtKecamatanDIY=substr(strip_tags($_POST['edtKecamatanDIY']),0,20);
			$edtKotaDIY=substr(strip_tags($_POST['edtKotaDIY']),0,20);
			$edtKodePosDIY=substr(strip_tags($_POST['edtKodePosDIY']),0,5);
			$edtTelponDIY=substr(strip_tags($_POST['edtTelponDIY']),0,20);
			//Form 2
			$edtThnSemester=substr(strip_tags($_POST['edtThnSemester']),0,5);
			$edtTahunMasuk=substr($edtThnSemester,0,4);
			$cbPropinsiAsal=substr(strip_tags($_POST['cbPropinsiAsal']),0,2);
			$rbPindahan=substr(strip_tags($_POST['rbPindahan']),0,1);
			$edtTahunMasukAsal=substr(strip_tags($_POST['edtTahunMasukAsal']),0,4);
			$cbPerguruanTinggi=substr(strip_tags($_POST['cbPerguruanTinggi']),0,6);
			$edtNimAsal=substr(strip_tags($_POST['edtNimAsal']),0,15);
			$cbProdiAsal=substr(strip_tags($_POST['cbProdiAsal']),0,5);
			$cbJenjang=substr(strip_tags($_POST['cbJenjang']),0,1);
			$edtSKSdiakui="0";
			$edtSMU=substr(strip_tags($_POST['edtSMU']),0,40);
			$edtThnLulusSMU=substr(strip_tags($_POST['edtThnLulusSMU']),0,4);
			$cbStatusSMU=substr(strip_tags($_POST['cbStatusSMU']),0,1);
			$edtJenisSMK=substr(strip_tags($_POST['edtJenisSMK']),0,20);
			$edtJurusanSMU=substr(strip_tags($_POST['edtJurusanSMU']),0,30);
			$edtLokasiSMU=substr(strip_tags($_POST['edtLokasiSMU']),0,30);
			$edtAlamatSMU=substr(strip_tags($_POST['edtAlamatSMU']),0,40);
			$edtKotaSMU=substr(strip_tags($_POST['edtKotaSMU']),0,20);
			$cbPropinsiSMU=substr(strip_tags($_POST['cbPropinsiSMU']),0,2);
			//Form 3
		    $edtAyah=substr(strip_tags($_POST['edtAyah']),0,30);
		    $rbAyah=substr(strip_tags($_POST['rbAyah']),0,1);
		    $edtIbu=substr(strip_tags($_POST['edtIbu']),0,30);
		    $rbIbu=substr(strip_tags($_POST['rbIbu']),0,1);
		    $edtAlamatOrtu=substr(strip_tags($_POST['edtAlamatOrtu']),0,30);
		    $edtKelurahanOrtu=substr(strip_tags($_POST['edtKelurahanOrtu']),0,20);
			$edtKecamatanOrtu=substr(strip_tags($_POST['edtKecamatanOrtu']),0,20);
		    $edtKotaOrtu=substr(strip_tags($_POST['edtKotaOrtu']),0,20);
		    $cbPropinsiOrtu=substr(strip_tags($_POST['cbPropinsiOrtu']),0,2);
		    $edtKodePosOrtu=substr(strip_tags($_POST['edtKodePosOrtu']),0,5);
		    $edtTelponOrtu=substr(strip_tags($_POST['edtTelponOrtu']),0,20);
		    $cbPendidikanAyah=substr(strip_tags($_POST['cbPendidikanAyah']),0,1);
		    $cbPendidikanIbu=substr(strip_tags($_POST['cbPendidikanIbu']),0,1);
		    $cbPekerjaanAyah=substr(strip_tags($_POST['cbPekerjaanAyah']),0,1);
		    $cbPekerjaanIbu=substr(strip_tags($_POST['cbPekerjaanIbu']),0,1);
			//Form 4
			$cbTempatTinggal=substr(strip_tags($_POST["cbTempatTinggal"]),0,1);
		    $cbPekerjaan=substr(strip_tags($_POST["cbPekerjaan"]),0,1);
			$edtNIP=substr(strip_tags($_POST["edtNIP"]),0,30);
	  		$edtInstansi=substr(strip_tags($_POST["edtInstansi"]),0,30);
	  		$edtAlamatInstansi=substr(strip_tags($_POST["edtAlamatInstansi"]),0,30);
	  		$rbAlumni=substr(strip_tags($_POST["rbAlumni"]),0,1);
	  		$edtNoAnggota=substr(strip_tags($_POST["edtNoAnggota"]),0,11);
		    $cbTextBook=substr(strip_tags($_POST["cbTextBook"]),0,1);
		    $cbKunjunganKePerpustakaan=substr(strip_tags($_POST["cbKunjunganKePerpustakaan"]),0,1);
		    $cbKegiatan=substr(strip_tags($_POST["cbKegiatan"]),0,1);
		    $cbOlahRaga=substr(strip_tags($_POST["cbOlahRaga"]),0,1);
		    $cbKesenian=substr(strip_tags($_POST["cbKesenian"]),0,1);
			$cbSumberBiayaStudi==substr(strip_tags($_POST["cbSumberBiayaStudi"]),0,1);
			$edtPenanggungBiaya==substr(strip_tags($_POST["edtPenanggungBiaya"]),0,30);
			$cbBeasiswa==substr(strip_tags($_POST["cbBeasiswa"]),0,1);
		    $edtAlamatSurat=substr(strip_tags($_POST["edtAlamatSurat"]),0,30);
		    $edtKelurahanSurat=substr(strip_tags($_POST["edtKelurahanSurat"]),0,20);
			$edtKecamatanSurat=substr(strip_tags($_POST['edtKecamatanSurat']),0,20);
		    $edtKotaSurat=substr(strip_tags($_POST["edtKotaSurat"]),0,20);
		    $cbPropinsiSurat=substr(strip_tags($_POST["cbPropinsiSurat"]),0,2);
		    $edtKodePosSurat=substr(strip_tags($_POST["edtKodePosSurat"]),0,5);
			$edtTelponSurat=substr(strip_tags($_POST["edtTelponSurat"]),0,20);
		    $edtEmail=substr(strip_tags($_POST["edtEmail"]),0,40);
						
			$MySQL->Update("msmhsupy","NMMHSMSMHS='$edtNama',TPLHRMSMHS='$edtTempatLahir',TGLHRMSMHS='$edtTglLahir',KDJEKMSMHS='$rbJK',ASSMAMSMHS='$cbPropinsiAsal',ASNIMMSMHS='$edtNimAsal',ASPTIMSMHS='$cbPerguruanTinggi',ASJENMSMHS='$cbJenjang',ASPSTMSMHS='$cbProdiAsal'","where IDX='".$edtID."'","1");
  			$MySQL->Update("mhsdtlupy","KDBLJMSMHS='$rbKelBelajar',KLBLJMSMHS='$edtKelBelajar',KBLHRMSMHS='$edtKabLahir',PRLHRMSMHS='$cbPropLahir',ISWNIMSMHS='$rbNegara',NEGRAMSMHS='$edtNegara',AGAMAMSMHS='$cbAgama',STSPLMSMHS='$cbStatusSipil',ALMATMSMHS='$edtAlamat',KLRHNMSMHS='$edtKelurahan',KCMTNMSMHS='$edtKecamatan',KOTAAMSMHS='$edtKota',PRMHSMSMHS='$cbPropinsi',KDPOSMSMHS='$edtKodePos',TELPOMSMHS='$edtTelpon',ALDIYMSMHS='$edtAlamatDIY',KLDIYMSMHS='$edtKelurahanDIY',KCDIYMSMHS='$edtKecamatanDIY',KTDIYMSMHS='$edtKotaDIY',PSDIYMSMHS='$edtKodePosDIY',TLDIYMSMHS='$edtTelponDIY',THASLMSMHS='$edtTahunMasukAsal',NMSMUMSMHS='$edtSMU',LLSMUMSMHS='$edtThnLulusSMU',STSMUMSMHS='$cbStatusSMU',JNSMKMSMHS='$edtJenisSMK',JRSMUMSMHS='$edtJurusanSMU',LKSMUMSMHS='$edtLokasiSMU',ALSMUMSMHS='$edtAlamatSMU',KTSMUMSMHS='$edtKotaSMU',PRSMUMSMHS='$cbPropinsiSMU',NMAYHMSMHS='$edtAyah',NMIBUMSMHS='$edtIbu',STAYHMSMHS='$rbAyah',STIBUMSMHS='$rbIbu',ALORTMSMHS='$edtAlamatOrtu',KLORTMSMHS='$edtKelurahanOrtu',KCORTMSMHS='$edtKecamatanOrtu',KTORTMSMHS='$edtKotaOrtu',PRORTMSMHS='$cbPropinsiOrtu',PSORTMSMHS='$edtKodePosOrtu',TLORTMSMHS='$edtTelponOrtu',PDAYHMSMHS='$cbPendidikanAyah',PDIBUMSMHS='$cbPendidikanIbu',KRAYHMSMHS='$cbPekerjaanAyah',KRIBUMSMHS='$cbPekerjaanIbu',KOSTMMSMHS='$cbTempatTinggal',KRJMHMSMHS='$cbPekerjaan',NIPMHMSMHS='$edtNIP',NMKRJMSMHS='$edtInstansi',ALKRJMSMHS='$edtAlamatInstansi',IPGRIMSMHS='$rbAlumni',NOANGMSMHS='$edtNoAnggota',TXBOKMSMHS='$cbTextBook',PERPUMSMHS='$cbKunjunganKePerpustakaan',AKTVSMSMHS='$cbKegiatan',OLHRGMSMHS='$cbOlahRaga',SENIAMSMHS='$cbKesenian',SMBYAMSMHS='$cbSumberBiayaStudi',NMBYAMSMHS='$edtPenanggungBiaya',BSSWAMSMHS='$cbBeasiswa',ALSRTMSMHS='$edtAlamatSurat',KLSRTMSMHS='$edtKelurahanSurat',KCSRTMSMHS='$edtKecamatanSurat',KTSRTMSMHS='$edtKotaSurat',PRSRTMSMHS='$cbPropinsiSurat',PSSRTMSMHS='$edtKodePosSurat',TLSRTMSMHS='$edtTelponSurat',EMAILMSMHS='$edtEmail'","where NIMHSMSMHS='".$edtNIM."'","1");			
			
			$act_log="Update ID='$edtID' Pada Tabel 'msmhsupy,mhsdtlupy' File 'daftarmahasiswa.php,datamahasiswa.php' ";
		  	if ($MySQL->exe){
				$succ=1;
			}
		  	if ($succ==1){
				$act_log .= "Sukses!";
		    	echo $msg_edit_data;
		  	} else {
				$act_log .= "Gagal!";
				echo $msg_update_0;
			}
			AddLog($id_admin,$act_log);
		}
		
		if ((isset($_GET['p']) && $_GET['p']=='deletex')) {
			$id=$_GET['id'];
			$MySQL->Delete("msmhsupy","where IDX=".$id,"1");
		    if ($MySQL->exe){
				$act_log="Hapus ID='$id' Pada Tabel 'msmhsupy' File 'daftarmahasiswa.php' Sukses";
				echo $msg_delete_data;
			} else {
				$act_log="Hapus ID='$id' Pada Tabel 'msmhsupy' File 'daftarmahasiswa.php' Gagal";
				echo $msg_delete_data_0;
			}
			AddLog($id_admin,$act_log);
		}

		if (!isset($_GET['pos'])) $_GET['pos']=1;
		$page=$_GET['page'];
		$URLa="page=".$page;
    	$sel="";
   		if (!isset($_REQUEST['limit'])){
	    	$_REQUEST['limit']="20";
		}
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
		echo "<form action='./?page=daftarmahasiswa' method='post' >";
		echo "<tr><td colspan='4'>Pencarian Berdasarkan : <select name='field'>";
	    if ($field=='NIMHSMSMHS') $sel1="selected='selected'";
		if ($field=='NMMHSMSMHS') $sel2="selected='selected'";
	    if ($field=='mspstupy.NMPSTMSPST') $sel3="selected='selected'";
	
	    echo "<option value='NIMHSMSMHS' $sel1 >NP MAHASISWA</option>";
	    echo "<option value='NMMHSMSMHS' $sel2 >NAMA MAHASISWA</option>";
	    echo "<option value='mspstupy.NMPSTMSPST' $sel3 >PROGRAM STUDI</option>";
	     
	    echo "</select>";
	    echo "<input type='text' size='50' name='key' value='".$key."'/>\n";
	    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
		echo "</td><td colspan='5' align='right'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
		echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=daftarmahasiswa&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";
	    echo "</td></tr></form>";
	
	  	$qry ="LEFT OUTER JOIN mspstupy mspstupy on (msmhsupy.KDPSTMSMHS = mspstupy.IDPSTMSPST) WHERE msmhsupy.STMHSMSMHS IN ('A','C','N')";
	  	$qry .= "AND msmhsupy.KDPSTMSMHS IN $pst ";
		if (!empty($key)) {
	  		$qry .= " AND ".$field." like '".$key."'";			
		}
			
		$MySQL->Select("msmhsupy.IDX,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,msmhsupy.TAHUNMSMHS,mspstupy.NMPSTMSPST AS PROGRAMSTUDI,msmhsupy.STMHSMSMHS","msmhsupy",$qry,"TAHUNMSMHS DESC,KDPSTMSMHS ASC,NIMHSMSMHS ASC","","0");
	   	$total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
	
		$MySQL->Select("msmhsupy.IDX,msmhsupy.NIMHSMSMHS,msmhsupy.NMMHSMSMHS,msmhsupy.TAHUNMSMHS,mspstupy.NMPSTMSPST AS PROGRAMSTUDI,msmhsupy.STMHSMSMHS","msmhsupy",$qry,"TAHUNMSMHS DESC,KDPSTMSMHS ASC,NIMHSMSMHS ASC","$start,$perpage","0");
	
	     echo "<tr><th colspan='9' style='background-color:#EEE'>DAFTAR MAHASISWA</th></tr>";
	     echo "<tr>
	     <th style='width:20px;'>NO</th> 
	     <th style='width:100px;'>NPM</th> 
	     <th style='width:300px;'>NAMA MAHASISWA</th> 
	     <th colspan='2'>PROGRAM STUDI</th>
	     <th style='width:10px;'>TAHUN MASUK</th> 
	     <th style='width:10px;'>STATUS</th> 
	     <th style='width:20px;' colspan='2'>ACT</th>
	     </tr>";
	     $no=1;
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
		    	echo "<td class='$sel'>".$show['TAHUNMSMHS']."</td>";
		    	echo "<td class='$sel tac'>".$show['STMHSMSMHS']."</td>";
		     	echo "<td class='$sel tac'>";
				echo "<a href='./?page=daftarmahasiswa&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
		     	echo "</td>";
		     	//echo "<td class='$sel tac'>";
			//	echo "<a href='./?page=daftarmahasiswa&amp;p=&amp;id=".$show['IDX']."'><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
		     	//echo "</td>";	     	
		     	echo "</tr>";
		     	$no++;
		     }
		} else {
		     	echo "<tr><td align='center' style='color:red;' colspan='9'>".$msg_data_empty."</td></tr>";
		}
     	echo "<tr><td colspan='9' class='fwb'>Keterangan : A=Aktif, C=Cuti, N=Non-Aktif</td></tr>";
		echo "<tr><td colspan='9'>";
	 	include "navigator.php";
		echo "</td></tr>";
	    echo "</table>";
	}
}
?>
