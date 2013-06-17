<?php
if (!isset($_SESSION[$PREFIX.'user']) && (($_SESSION[$PREFIX.'group']=='0') || ($_SESSION[$PREFIX.'group']=='1'))) {
	echo "<div class='diverr m5 p5 tac'>";
	echo "MAAF!, Akses Ditolak, Anda Harus Login Dahulu!";
	echo "</div>";
} else {
	$page=$_GET['page'];
		if (isset($p) && $p!=''){
			$URLa="page=".$page."&amp;p=".$p;	
		} else{
			$URLa="page=".$page;		
		}	
		/*************** Simpan Data ****************/
		$such=0;
		if (isset($_POST['submit'])){
			$edtKode=substr(strip_tags($_POST['edtKode']),0,10);
			$edtNama=substr(strip_tags($_POST['edtNama']),0,30);
			$edtNIDN=substr(strip_tags($_POST['edtNIDN']),0,10);
			$edtNIP=substr(strip_tags($_POST['edtNIP']),0,9);
			$edtKTP=substr(strip_tags($_POST['edtKTP']),0,25);
			$edtLahir=substr(strip_tags($_POST['edtLahir']),0,20);
			$edtTglLahir=substr(strip_tags($_POST['edtTglLahir']),0,10);
			$edtTglLahir=@explode("-",$edtTglLahir);
			$edtTglLahir=$edtTglLahir[2]."-".$edtTglLahir[1]."-".$edtTglLahir[0];
			$rbJK=substr(strip_tags($_POST['rbJK']),0,1);
			$cbJabatan=substr(strip_tags($_POST['cbJabatan']),0,1);
			$cbKerja=substr(strip_tags($_POST['cbKerja']),0,1);
			$cbStatus=substr(strip_tags($_POST['cbStatus']),0,1);
			$edtTahun=substr(strip_tags($_POST['edtTahun']),0,4);
			$cbSemester=substr(strip_tags($_POST['cbSemester']),0,1);
			$ThnSemester=$edtTahun.$cbSemester;
			$cbFakultas=substr(strip_tags($_POST['cbFakultas']),0,1);
			$edtInstansi=substr(strip_tags($_POST['edtInstansi']),0,6);

			if ($_POST['submit']=='Simpan'){
				$MySQL->Insert("msdosupy","KDDOSMSDOS,NMDOSMSDOS,NODOSMSDOS,NIPNSMSDOS,NOKTPMSDOS,TPLHRMSDOS,TGLHRMSDOS,KDJEKMSDOS,KDJANMSDOS,KDSTAMSDOS,STDOSMSDOS,MLSEMMSDOS,KDFAKMSDOS,PTINDMSDOS","'$edtKode','$edtNama','$edtNIDN','$edtNIP','$edtKTP','$edtLahir','$edtTglLahir','$rbJK','$cbJabatan','$cbKerja','$cbStatus','$ThnSemester','$cbFakultas','$edtInstansi'");
				$msg="Data Dosen Berhasil Ditambahkan!";
			} else {
				$edtID=substr(strip_tags($_POST['edtID']),0,2);
				$MySQL->Update("msdosupy","KDDOSMSDOS='$edtKode',NMDOSMSDOS='$edtNama',NODOSMSDOS='$edtNIDN',NIPNSMSDOS='$edtNIP',NOKTPMSDOS='$edtKTP',TPLHRMSDOS='$edtLahir',TGLHRMSDOS='$edtTglLahir',KDJEKMSDOS='$rbJK',KDJANMSDOS='$cbJabatan',KDSTAMSDOS='$cbKerja',STDOSMSDOS='$cbStatus',MLSEMMSDOS='$ThnSemester',KDFAKMSDOS='$cbFakultas',PTINDMSDOS='$edtInstansi'","where IDX=".$edtID,"1");
				$msg="Update Data Dosen Berhasil!";
			}
			// perintah SQL berhasil dijalankan
		  	if ($MySQL->exe){
				$succ=1;
			}
		  	if ($succ==1){
//				$act_log="Update ID='$id_admin' Pada Tabel 'tb_admin' File 'kelola_admin.php' //Sukses";
//				AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
				echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
				echo $msg;
				echo "</div>";
		  	} else{
//				$act_log="Update ID='$id_admin' Pada Tabel 'tb_admin' File 'kelola_admin.php' Gagal";
//				AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
		    	echo "<div id='msg_err' class='diverr m5 p5 tac'>";
		    	echo "Maaf!, Update Data Gagal! Pastikan Data Yang Anda Masukkan Benar";
		    	echo "</div>";
			}
		}
		/****** Jika page=prodi && p=delete=> *********/		
		if (!isset($_GET['p']) || (isset($_GET['p']) && $_GET['p']=='delete')){
			if ((isset($_GET['p']) && $_GET['p']=='delete') && !isset($_GET['subpage'])) {
				$id=$_GET['id']; 
	  			$MySQL->Delete("msdosupy","where IDX=".$id,"1");
			    if ($MySQL->exe){
//					$act_log="Hapus ID='$id_agama' Pada Tabel 'tb_agama' File 'setting_agama.php' Sukses";
//					AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
				    echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
				    echo "Data Berhasil Dihapus!<br />";;
				    echo "</div>";
				} else {
//					$act_log="Hapus ID='$id_agama' Pada Tabel 'tb_agama' File 'setting_agama.php' Gagal";
//					AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);*/
				    echo "<div id='msg_err' class='diverr m5 p5 tac'>";
				    echo "Data Gagal Dihapus!";
				    echo "</div>";
				}
			}
	 	 	if (!isset($_GET['pos'])) $_GET['pos']=1;
		 	$page=$_GET['page'];
		 	$p=$_GET['p'];		
			if (!isset($_REQUEST['limit'])){
			    $_REQUEST['limit']="20";
			}
			/***** Default Tampilan **************/
			echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
			echo "<tr><td colspan='8' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=$page&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
			echo "<tr>";
			echo "<tr><th colspan='8' style='background-color:#EEE'>Daftar Dosen</th></tr>";
			echo "<tr>
				<th style='width:20px;'>KODE</th>
				<th style='width:200px;'>DOSEN</th>
				<th style='width:200px;'>NIDN</th>
				<th style='width:200px;'>FAKULTAS</th>
				<th style='width:50px;'>STATUS</th>
				<th colspan='2' style='width:20px;'>ACT</th></tr>";
			$MySQL->Select("*","msdosupy","","","","0");
			$total=$MySQL->Num_Rows();
			$perpage=$_REQUEST['limit'];
			$totalpage=ceil($total/$perpage);
			$start=($_GET['pos']-1)*$perpage;
			$MySQL->Select("msdosupy.IDX,msdosupy.KDDOSMSDOS,msdosupy.NMDOSMSDOS,msdosupy.NODOSMSDOS,msfakupy.NMFAKMSFAK,msdosupy.STDOSMSDOS","msdosupy","LEFT JOIN msfakupy ON msdosupy.KDFAKMSDOS=msfakupy.KDFAKMSFAK","KDDOSMSDOS ASC","$start,$perpage");
			if ($MySQL->Num_Rows() > 0){
				$no=1;
				while ($show=$MySQL->Fetch_Array()){
					$sel="";
					if ($no % 2 == 1) $sel="sel";     	
					echo "<tr>";
			     	echo "<td class='$sel tac'>".$show['KDDOSMSDOS']."</td>";
			     	echo "<td class='$sel'>".$show['NMDOSMSDOS']."</td>";
			     	echo "<td class='$sel'>".$show['NODOSMSDOS']."</td>";
			     	echo "<td class='$sel tac'>".$show['NMFAKMSFAK']."</td>";
			     	echo "<td class='$sel tac'>".$show['STDOSMSDOS']."</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=".$page."&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
			     	echo "</td>";
			     	echo "<td class='$sel tac'>";
					echo "<a href='./?page=".$page."&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
			     	echo "</td>";
			     	echo "</tr>";
			     	$no++;
				}
			} else {
	 			echo "<td colspan='8' align='center' style='color:red;'>".$msg_data_empty."</td>";		
			}
	   	 	echo "<tr><td colspan='8' style='background-color:#EEE tal'>Keterangan Status : A=Aktif&nbsp;&nbsp;&nbsp;H=Hapus&nbsp;&nbsp;&nbsp;N=Non-Aktif</td></tr>";
			echo "</table>";
			include "navigator.php";
	     } elseif (isset($_GET['p']) && $_GET['p']=='add') {
	   	/****** Jika page=prodi && p='add' **********/
			include "./content/dosen/dosen.tambah.php";
	?>
	<?php
		} else {
			/*********** Form Edit Data ********************/
			$id=$_GET['id'];
			$MySQL->Select("*","msdosupy","where IDX=".$id."","","1");
			$show=$MySQL->Fetch_Array();			
			$edtKode=$show['KDDOSMSDOS'];
			$edtNama=$show['NMDOSMSDOS'];
			$edtNIDN=$show['NODOSMSDOS'];
			$edtNIP=$show['NIPNSMSDOS'];
			$edtKTP=$show['NOKTPMSDOS'];
			$edtLahir=$show['TPLHRMSDOS'];
			$edtTglLahir=DateStr($show['TGLHRMSDOS']);
			$rbJK=$show['KDJEKMSDOS'];
			$cbJabatan=$show['KDJANMSDOS'];
			$cbKerja=$show['KDSTAMSDOS'];
			$cbStatus=$show['STDOSMSDOS'];
			$edtTahun=substr($show['MLSEMMSDOS'],0,4);
			$cbSemester=substr($show['MLSEMMSDOS'],4,1);
			$cbFakultas=$show['KDFAKMSDOS'];
			$edtInstansi=$show['PTINDMSDOS'];			
			include "./content/dosen/dosen.edit.php";
		}
	}
?>
