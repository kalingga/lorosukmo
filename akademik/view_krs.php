<?php
//include "include/config.php";

$idpage='20';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);

if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {

	$id_admin=$_SESSION[$PREFIX.'id_admin'];
	$id_group=$_SESSION[$PREFIX.'id_group'];
	$user_admin=$_SESSION[$PREFIX.'user_admin'];
	$LastKRS=GetPeriode();
	
	$curr_akses= date("Y-m-d",$_SERVER['REQUEST_TIME']);
	$curr_date=@explode("-",$curr_akses);
	$curr_month=$curr_date[1];
	$curr_year=$curr_date[0];

  $edtNIM=$user_admin;
		
	//*** Cari Identitas Mahasiswa *****/
	$MySQL->Select("KDPSTMSMHS,NIMHSMSMHS,NMMHSMSMHS,DSNPAMSMHS","msmhsupy","where NIMHSMSMHS='".$edtNIM."'","","1");
	$show=$MySQL->fetch_array();
	$nim=$show['NIMHSMSMHS'];
	$mahasiswa=$show['NMMHSMSMHS'];
	$prodi=$show['KDPSTMSMHS'];
	$fakultas=substr($show['KDPSTMSMHS'],0,1);
	$dosenpa=LoadDosen_X("",$show['DSNPAMSMHS']);
	$nidn=$show['DSNPAMSMHS'];
  // ===============
  
  $MySQL->Select("trnlmupy.IDX,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.KELASTRNLM,trnlmupy.SEMESTRNLM,trnlmupy.SKSMKTRNLM,trnlmupy.STAMKTRNLM,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI",
  "trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
  LEFT OUTER JOIN tbmksajiupy ON (trnlmupy.IDXMKSAJI = tbmksajiupy.IDX) 
  WHERE trnlmupy.THSMSTRNLM = '".$LastKRS."' AND  trnlmupy.NIMHSTRNLM = '".$edtNIM."' 
  AND trnlmupy.ISKONTRNLM <> '1'","trnlmupy.KDKMKTRNLM ASC");
		//		echo $MySQL->qry;
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
				
	if ($id_group != "0"){
    
			//************* Cetak KRS ********************//
					echo "<form id=\"krs\" action=\"cetak_krs.php\" method=\"post\" target=\"pdf_target\">";
					//echo "<button type='submit' onClick='form.submit()' align='absmiddle'>Cetak KRS</button><br />";
					
          echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' onClick=window.location.href='?act=logout' value='Log Out' 
          style='width:60px; padding:2px 0 2px 0; margin-top:-2px; font-weight:bold;'>
                <br />";
          echo "<button type='button' onClick='form.submit()' style='width:100px; font-weight:bold; padding:2px;'>
                <img src='images/b_print_pdf.png' width='12px' align='left'/>&nbsp;Cetak KRS </button><br />";      
					//echo "<input type=\"submit\" value=\" Cetak KRS \"  title=\"CETAK KE PDF\" 
          //style='width:75px; padding:2px 2px 2px 2px; margin-top:-2px; font-weight:bold;' /> ";
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
					echo "<input type=\"hidden\" name=\"mahasiswa\" value=\"".$mahasiswa."\" />";
					echo "<input type=\"hidden\" name=\"width1\" value=\"".$width1."\" />";
					echo "<input type=\"hidden\" name=\"width2\" value=\"".$width2."\" />";
					echo "</form>";	 	  					

	}
}

function GetPeriode(){
	global $MySQL;
	$MySQL->Select("DISTINCT MAX(setkrsupy.TASMSSETKRS) AS LASTKRS","setkrsupy","","","1");
	$show=$MySQL->fetch_array();
	return $show["LASTKRS"];	
}





?>