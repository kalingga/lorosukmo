<?php
/* Cari Tahun Ajaran Berdasarkan Saat Mahasiswa Mendaftar */ 
include "./content/umum/pmb.class.php";

if (isset($_POST['submit'])){
	$edtNama=substr(strip_tags($_POST['edtNama']),0,30);
	$rbJK=substr(strip_tags($_POST['rbJK']),0,1);
	$edtLahir=substr(strip_tags($_POST['edtLahir']),0,20);
	$edtTglLahir=substr(strip_tags($_POST['edtTglLahir']),0,10);
	$edtTglLahir=@explode("-",$edtTglLahir);
	$edtTglLahir=$edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];	
	$rbNegara=substr(strip_tags($_POST['rbNegara']),0,1);
	$edtNegara=substr(strip_tags($_POST['edtNegara']),0,20);
	$edtAlamat=substr(strip_tags($_POST['edtAlamat']),0,30);
	$edtKelurahan=substr(strip_tags($_POST['edtKelurahan']),0,20);
	$edtKota=substr(strip_tags($_POST['edtKota']),0,20);
	$cbPropinsi=substr(strip_tags($_POST['cbPropinsi']),0,2);
	$edtKodePos=substr(strip_tags($_POST['edtKodePos']),0,5);
	$edtTelp=substr(strip_tags($_POST['edtTelp']),0,20);
	$cbJenjang=substr(strip_tags($_POST['cbJenjang']),0,1);
	$edtNamaPT=substr(strip_tags($_POST['edtNamaPT']),0,30);
	$edtJurusan=substr(strip_tags($_POST['edtJurusan']),0,30);
	$edtAlamat1=substr(strip_tags($_POST['edtAlamat1']),0,30);
	$edtKota1=substr(strip_tags($_POST['edtKota1']),0,20);
	$cbPropinsi1=substr(strip_tags($_POST['cbPropinsi1']),0,2);
	$cbKerja=substr(strip_tags($_POST['cbKerja']),0,1);
	$edtKerja=substr(strip_tags($_POST['edtKerja']),0,30);
	$edtAlamat2=substr(strip_tags($_POST['edtAlamat2']),0,30);
	$rbAlumni=substr(strip_tags($_POST['rbAlumni']),0,1);
	$edtAnggota=substr(strip_tags($_POST['edtAnggota']),0,12);
	$cbProdi1=substr(strip_tags($_POST['cbProdi1']),0,2);
	$cbProdi2=substr(strip_tags($_POST['cbProdi2']),0,2);
	$cbProgram=substr(strip_tags($_POST['cbProgram']),0,1);
	$cbStatus=substr(strip_tags($_POST['cbStatus']),0,1);
	$cbInformasi=substr(strip_tags($_POST['cbInformasi']),0,1);
	if ($_POST['submit']=='Simpan'){
		$thn=GetAjaran();
		$NoDaftar=GetNoDaftar();
		$MySQL->Select("*","tbpmbupy","where NOFRMTBPMB='$edtFormulir","","1");
		if ($MySQL->Num_Rows > 0) {
			$msg="Data Ini Sudah Pernah Diproses!";
		} else {
		$edtFormulir=substr(strip_tags($_POST['edtFormulir']),0,8);
		$MySQL->Insert("tbpmbupy","NOFRMTBPMB,THNSMTBPMB,NODTRTBPMB,NMPMBTBPMB,KDJEKTBPMB,TPLHRTBPMB,TGLHRTBPMB,KDWNITBPMB,NEGRATBPMB,ALMT1TBPMB,KELRHTBPMB,KABPTTBPMB,PROPITBPMB,TELPOTBPMB,KDPOSTBPMB,KDJENTBPMB,SKASLTBPMB,JURSNTBPMB,ALTSKTBPMB,KABSKTBPMB,PROSKTBPMB,STKRJTBPMB,NMKRJTBPMB,ALKRJTBPMB,ALMNITBPMB,ANGGTTBPMB,PLHN1TBPMB,PLHN2TBPMB,PROGRTBPMB,STPIDTBPMB,INFORTBPMB","'$edtFormulir','$thn','$NoDaftar','$edtNama','$rbJK','$edtLahir','$edtTglLahir','$rbNegara','$edtNegara','$edtAlamat','$edtKelurahan','$edtKota','$cbPropinsi','$edtTelp','$edtKodePos','$cbJenjang','$edtNamaPT','$edtJurusan','$edtAlamat1','$edtKota1','$cbPropinsi1','$cbKerja','$edtKerja','$edtAlamat2','$rbAlumni','$edtAnggota','$cbProdi1','$cbProdi2','$cbProgram','$cbStatus','$cbInformasi'");
		$msg="Data Mahasiswa Baru Berhasil Ditambahkan!";
		}
	} else {
		$thn=substr(strip_tags($_POST['thn']),0,4);
		$NoDaftar=substr(strip_tags($_POST['NoDaftar']),0,4);;		
		$edtID=substr(strip_tags($_POST['edtID']),0,11);
		$MySQL->Update("tbpmbupy","NMPMBTBPMB='$edtNama',KDJEKTBPMB='$rbJK',TPLHRTBPMB='$edtLahir',TGLHRTBPMB='$edtTglLahir',KDWNITBPMB='$rbNegara',NEGRATBPMB='$edtNegara',ALMT1TBPMB='$edtAlamat',KELRHTBPMB='$edtKelurahan',KABPTTBPMB='$edtKota',PROPITBPMB='$cbPropinsi',TELPOTBPMB='$edtTelp',KDPOSTBPMB='$edtKodePos',KDJENTBPMB='$cbJenjang',SKASLTBPMB='$edtNamaPT',JURSNTBPMB='$edtJurusan',ALTSKTBPMB='$edtAlamat1',KABSKTBPMB='$edtKota1',PROSKTBPMB='$cbPropinsi1',STKRJTBPMB='$cbKerja',NMKRJTBPMB='$edtKerja',ALKRJTBPMB='$edtAlamat2',ALMNITBPMB='$rbAlumni',ANGGTTBPMB='$edtAnggota',PLHN1TBPMB='$cbProdi1',PLHN2TBPMB='$cbProdi2',PROGRTBPMB='$cbProgram',STPIDTBPMB='$cbStatus',INFORTBPMB='$cbInformasi'","where IDX=".$edtID,"1");
		$msg="Update Data Mahasiswa Baru Berhasil!";
	}
	// perintah SQL berhasil dijalankan
  	if ($MySQL->exe){
		$succ=1;
	}
  	if ($succ==1){
	//   $act_log="Update ID='$id_admin' Pada Tabel 'tb_admin' File 'kelola_admin.php' //Sukses";
	//    AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
	    echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
	    echo $msg;
	    echo "</div>";
	} else{
	//	$act_log="Update ID='$id_admin' Pada Tabel 'tb_admin' File 'kelola_admin.php' Gagal";
	//	AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    	echo "<div id='msg_err' class='diverr m5 p5 tac'>";
	    echo "Maaf!, Update Data Gagal! Pastikan Data Yang Anda Masukkan Benar";
	    echo "</div>";
	}
	include "./content/umum/pmb.edit.php";	
} else {
	$tahun=GetAjaran();
	$no=SetNoForm();
	$MySQL->Insert("frpmbupy","THNSMFRPMB,NOFRMFRPMB","'$tahun','$no'");
	$MySQL->Select("*","frpmbupy","WHERE THNSMFRPMB ='".$tahun."' and NOFRMFRPMB='".$no."'","","1");
    $show=$MySQL->Fetch_Array();
	$noForm=$show["THNSMFRPMB"].$show["NOFRMFRPMB"];
	$edtID=$show["IDX"];
	include "./content/umum/pmb.tambah.php";
}
?>