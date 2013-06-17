<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}
	
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$data){
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$i=0;
		foreach($data as $row){
			$this->AddPage();
			if ($i==0) {
				$this->Ln(24);
			} else {
				$this->Ln(10);				
			}
			$this->SetFont('Arial','B',8);
			$this->Cell($w[0],3,$row[0],"");
			$this->Cell($w[1],3,": ".$row[12],"");
			$this->Cell($w[0],3,$row[11],"");
			$this->Cell($w[1],3,": ".$row[23],"");
			$this->Ln();
			$this->Cell($w[0],3,$row[4],"");
			$this->Cell($w[1],3,": ".$row[16]." [".$row[15]."]","");
			$this->Cell($w[2],3,$row[8],"");
			$this->Cell($w[3],3,": ".$row[20],"");
			$this->Ln();
			$this->Cell($w[0],3,$row[5],"");
			$this->Cell($w[1],3,": ".$row[17],"");
			$this->Cell($w[2],3,$row[9],"");
			$this->Cell($w[3],3,": ".$row[21],"");
			$this->Ln();
			$this->Cell($w[0],3,$row[6],"");
			$this->Cell($w[1],3,": ".$row[18],"");
			$this->Cell($w[2],3,$row[10],"");
			$this->Cell($w[3],3,": ".$row[22],"");
			$this->Ln(5);
			$this->SetFillColor(223,223,223);			
			$this->Cell(10,5,"Pert","1","","C","1");
			$this->Cell(20,5,"Tanggal","1","","C",1);
			$this->Cell(50,5,"Pokok Bahasan","1","","",1);
			$this->Cell(80,5,"Sub-Pokok Bahasan","1","","C",1);
			$this->Cell(15,5,"Jml Mhs","1","","C",1);
			$this->Cell(20,5,"Paraf","1","","C",1);
			$this->Ln();
			$this->SetFillColor(255,255,255);			
			$this->Cell(10,15,"I","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"II","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"III","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"IV","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"V","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"VI","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"VII","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"VIII","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"IX","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"X","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"XI","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"XII","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"XIII","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"XIV","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$this->Ln();
			$this->Cell(10,15,"XV","1","","C","1");
			$this->Cell(20,15,"","1","","C",1);
			$this->Cell(50,15,"","1","","",1);
			$this->Cell(80,15,"","1","","C",1);
			$this->Cell(15,15,"","1","","C",1);
			$this->Cell(20,15,"","1","","C",1);
			$i++;
		}
	}

	function Page2($w,$data,$thn){
		global $MySQL;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$i=0;
		foreach($data as $row){
			$this->AddPage("L");
			if ($i==0) {
				$this->Ln(20);
			} else {
				$this->Ln(16);				
			}
			$this->SetFont('Arial','B',8);
			$this->Cell($w[0],3,$row[0],"");
			$this->Cell($w[1],3,": ".$row[12],"");
			$this->Cell($w[2],3,$row[3],"");
			$this->Cell($w[3],3,": ".$row[15],"");
			$this->Cell($w[4],3,$row[7],"");
			$this->Cell($w[5],3,": ".$row[19],"");
			$this->Ln();

			$this->Cell($w[0],3,$row[1],"");
			$this->Cell($w[1],3,": ".$row[13],"");
			$this->Cell($w[2],3,$row[4],"");
			$this->Cell($w[3],3,": ".$row[16],"");
			$this->Cell($w[4],3,$row[8],"");
			$this->Cell($w[5],3,": ".$row[20],"");
			$this->Ln();

			$this->Cell($w[0],3,$row[2],"");
			$this->Cell($w[1],3,": ".$row[14],"");
			$this->Cell($w[2],3,$row[5],"");
			$this->Cell($w[3],3,": ".$row[17],"");
			$this->Cell($w[4],3,$row[9],"");
			$this->Cell($w[5],3,": ".$row[21],"");
			$this->Ln();

			$this->Cell($w[0],3,$row[6],"");
			$this->Cell($w[1],3,": ".$row[18],"");
			$this->Cell($w[2],3,$row[11],"");
			$this->Cell($w[3],3,": ".$row[23],"");
			$this->Cell($w[4],3,$row[10],"");
			$this->Cell($w[5],3,": ".$row[22],"");
			$this->Ln(5);
			$this->SetFillColor(223,223,223);			
			$this->Cell(7,4,"No","LTR","","C","1");
			$this->Cell(20,4,"NP Mahasiswa","LTR","","C",1);
			$this->Cell(70,4,"Nama Mahasiswa","LTR","","",1);
			$this->Cell(8,4,"B/U/P","LTR","","C",1);
			$this->Cell(13,4,"1","1","","C",1);
			$this->Cell(13,4,"2","1","","C",1);
			$this->Cell(13,4,"3","1","","C",1);
			$this->Cell(13,4,"4","1","","C",1);
			$this->Cell(13,4,"5","1","","C",1);
			$this->Cell(13,4,"6","1","","C",1);
			$this->Cell(13,4,"7","1","","C",1);
			$this->Cell(13,4,"8","1","","C",1);
			$this->Cell(13,4,"9","1","","C",1);
			$this->Cell(13,4,"10","1","","C",1);
			$this->Cell(13,4,"11","1","","C",1);
			$this->Cell(13,4,"12","1","","C",1);
			$this->Cell(13,4,"13","1","","C",1);
			$this->Cell(13,4,"14","1","","C",1);
			$this->Cell(13,4,"15","1","","C",1);
			$this->Cell(15,4,"Jumlah","LTR","","C",1);
			$this->Cell(15,4,"%","LTR","","C",1);
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell(7,3,"","LBR","","C","1");
			$this->Cell(20,3,"","LBR","","C",1);
			$this->Cell(70,3,"","LBR","","",1);
			$this->Cell(8,3,"","LBR","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(13,3,"","1","","C",1);
			$this->Cell(15,3,"Hadir","LBR","","C",1);
			$this->Cell(15,3,"Hadir","LBR","","C",1);
			$this->Ln();			
			
			$MySQL->Select("trnlmupy.NIMHSTRNLM,msmhsupy.NMMHSMSMHS","trnlmupy","LEFT OUTER JOIN msmhsupy ON (trnlmupy.NIMHSTRNLM = msmhsupy.NIMHSMSMHS) WHERE trnlmupy.THSMSTRNLM = '".$thn."' AND trnlmupy.KDKMKTRNLM = '".$row[15]."' AND trnlmupy.KELASTRNLM = '".$row[23]."'","trnlmupy.NIMHSTRNLM","");
			$j=1;
			$no=1;
			$this->SetFont('Arial','',8);
			$this->Text(10,200,"Lembar 1 : Untuk Dosen");
			$this->Text(10,203,"Lembar 2 : Untuk Arsip Program Studi");
			while ($show=$MySQL->fetch_array()) {
				if ($j == 21 ) {
					$this->AddPage("L");
					$this->Ln(16);
					$this->SetFont('Arial','B',8);
					$this->Cell($w[0],3,$row[0],"");
					$this->Cell($w[1],3,": ".$row[12],"");
					$this->Cell($w[2],3,$row[3],"");
					$this->Cell($w[3],3,": ".$row[15],"");
					$this->Cell($w[4],3,$row[7],"");
					$this->Cell($w[5],3,": ".$row[19],"");
					$this->Ln();
		
					$this->Cell($w[0],3,$row[1],"");
					$this->Cell($w[1],3,": ".$row[13],"");
					$this->Cell($w[2],3,$row[4],"");
					$this->Cell($w[3],3,": ".$row[16],"");
					$this->Cell($w[4],3,$row[8],"");
					$this->Cell($w[5],3,": ".$row[20],"");
					$this->Ln();
		
					$this->Cell($w[0],3,$row[2],"");
					$this->Cell($w[1],3,": ".$row[14],"");
					$this->Cell($w[2],3,$row[5],"");
					$this->Cell($w[3],3,": ".$row[17],"");
					$this->Cell($w[4],3,$row[9],"");
					$this->Cell($w[5],3,": ".$row[21],"");
					$this->Ln();
		
					$this->Cell($w[0],3,$row[6],"");
					$this->Cell($w[1],3,": ".$row[18],"");
					$this->Cell($w[2],3,$row[11],"");
					$this->Cell($w[3],3,": ".$row[23],"");
					$this->Cell($w[4],3,$row[10],"");
					$this->Cell($w[5],3,": ".$row[22],"");
					$this->Ln(5);
					$this->SetFillColor(223,223,223);			
					$this->Cell(7,4,"No","LTR","","C","1");
					$this->Cell(20,4,"NP Mahasiswa","LTR","","C",1);
					$this->Cell(70,4,"Nama Mahasiswa","LTR","","",1);
					$this->Cell(8,4,"B/U/P","LTR","","C",1);
					$this->Cell(13,4,"1","1","","C",1);
					$this->Cell(13,4,"2","1","","C",1);
					$this->Cell(13,4,"3","1","","C",1);
					$this->Cell(13,4,"4","1","","C",1);
					$this->Cell(13,4,"5","1","","C",1);
					$this->Cell(13,4,"6","1","","C",1);
					$this->Cell(13,4,"7","1","","C",1);
					$this->Cell(13,4,"8","1","","C",1);
					$this->Cell(13,4,"9","1","","C",1);
					$this->Cell(13,4,"10","1","","C",1);
					$this->Cell(13,4,"11","1","","C",1);
					$this->Cell(13,4,"12","1","","C",1);
					$this->Cell(13,4,"13","1","","C",1);
					$this->Cell(13,4,"14","1","","C",1);
					$this->Cell(13,4,"15","1","","C",1);
					$this->Cell(15,4,"Jumlah","LTR","","C",1);
					$this->Cell(15,4,"%","LTR","","C",1);
					$this->Ln();
					$this->SetFillColor(223,223,223);			
					$this->Cell(7,3,"","LBR","","C","1");
					$this->Cell(20,3,"","LBR","","C",1);
					$this->Cell(70,3,"","LBR","","",1);
					$this->Cell(8,3,"","LBR","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(13,3,"","1","","C",1);
					$this->Cell(15,3,"Hadir","LBR","","C",1);
					$this->Cell(15,3,"Hadir","LBR","","C",1);
					$this->Ln();			
					$j=1;
				}
				$this->SetFillColor(255,255,255);			
				$this->Cell(7,7,$no."","1 ","","R","1");
				$this->Cell(20,7,$show['NIMHSTRNLM'],"1","","C",1);
				$this->Cell(70,7,$show['NMMHSMSMHS'],"1","","",1);
				$this->Cell(8,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(13,7,"","1","","C",1);
				$this->Cell(15,7,"","1","","C",1);
				$this->Cell(15,7,"","1","","C",1);
				$this->Ln();
				$j++;
				$no++;
			}
			$this->SetFont('Arial','',8);
			$this->Text(10,200,"Lembar 1 : Untuk Dosen");
			$this->Text(10,203,"Lembar 2 : Untuk Arsip Program Studi");
			$i++;
		}
	}

	function Page3($pst="",$thn){   // =========== CETAK GROUP BY SEMESTER =================
		global $MySQL;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$this->AddPage();
		$this->SetTopMargin(35);
		$this->Ln(25);
		foreach ($pst as $row) {
			$this->SetFont('Arial','B',8);
			$this->Cell(190,5,"Program Studi : ".LoadProdi_X("",$row));
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell(7,5,"No","1","","C",1);
			$this->Cell(17,5,"Kode MK","1","","C",1);
			$this->Cell(55,5,"Matakuliah","1","","C",1);
			$this->Cell(7,5,"Kls","1","","C",1);
			$this->Cell(7,5,"SKS","1","","C",1);
			$this->Cell(50,5,"Dosen","1","","C",1);
			$this->Cell(12,5,"Hari","1","","C",1);
			$this->Cell(23,5,"Waktu","1","","C",1);
			$this->Cell(15,5,"Ruang","1","","C",1);
			$this->Ln();
			$MySQL->Select("DISTINCT tbmksajiupy.SEMESMKSAJI","tbmksajiupy","WHERE tbmksajiupy.THSMSMKSAJI = '".$thn."' AND tbmksajiupy.KDPSTMKSAJI = '".$row."'","tbmksajiupy.SEMESMKSAJI");
			$i=0;
			$jml=$MySQL->num_rows();
			while ($master=$MySQL->fetch_array()) {
				$ms[$i]=$master['SEMESMKSAJI'];
				$i++;
			}
			
			for ($i=0;$i < $jml;$i++) {
				$this->SetFillColor(255,255,255);			
				$this->SetFont('Arial','B',8);
				$this->Cell(193,5,"Semester :".$ms[$i],"1","","L",1);
				$this->Ln();
				$this->SetFont('Arial','',6);
				$MySQL->Select("tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.KELASMKSAJI,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.NMDOSMKSAJI,
        tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.SMPAIMKSAJI,ruangNama AS RUANGMKSAJI",
        "tbmksajiupy",
        "LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) 
        LEFT JOIN ruang_kuliah ON ruangId = tbmksajiupy.RUANGMKSAJI 
        WHERE tbmksajiupy.KDPSTMKSAJI = '".$row."' 
        AND tbmksajiupy.THSMSMKSAJI = '".$thn."' AND tbmksajiupy.SEMESMKSAJI = '".$ms[$i]."' 
        AND HRPELMKSAJI IS NOT NULL",
        "tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI","");
        
				$no=1;
				while ($show=$MySQL->fetch_array()) {
					//$mulai= New Time($show['MULAIMKSAJI']);
					//$durasi=($show['DURSIMKSAJI'] * 60);
					//$selesai=$mulai->add($durasi);
					$this->Cell(7,5,$no,"1","","C",1);
					$this->Cell(17,5,$show['KDKMKMKSAJI'],"1","","L",1);
					$this->Cell(55,5,$show['NAMKTBLMK'],"1","","L",1);
					$this->Cell(7,5,$show['KELASMKSAJI'],"1","","C",1);
					$this->Cell(7,5,$show['SKSMKMKSAJI'],"1","","C",1);
					$this->Cell(50,5,$show['NMDOSMKSAJI'],"1","","L",1);
					$this->Cell(12,5,$show['HRPELMKSAJI'],"1","","L",1);
					$this->Cell(23,5,substr($show['MULAIMKSAJI'],0,5)." s.d. ".substr($show['SMPAIMKSAJI'],0,5),"1","","L",1);
					$this->Cell(15,5,$show['RUANGMKSAJI'],"1","","L",1);
					$this->Ln();
					$no++;
				}
			}
			$this->Ln();
		}	
	}

	function Page4($pst="",$thn){      //============ CETAK GROUP BY HARI =============
		global $MySQL;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$this->AddPage();
		$this->SetTopMargin(35);
		$this->Ln(25);
		foreach ($pst as $row) {
			$this->SetFont('Arial','B',8);
			$this->Cell(190,5,"Program Studi : ".LoadProdi_X("",$row));
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell(12,5,"Hari","1","","C",1);
			$this->Cell(23,5,"Waktu","1","","C",1);
			$this->Cell(17,5,"Kode MK","1","","C",1);
			$this->Cell(55,5,"Matakuliah","1","","C",1);
			$this->Cell(7,5,"Kls","1","","C",1);
			$this->Cell(7,5,"SKS","1","","C",1);
			$this->Cell(7,5,"Sem","1","","C",1);
			$this->Cell(50,5,"Dosen","1","","C",1);
			$this->Cell(15,5,"Ruang","1","","C",1);
			$this->Ln();
			$MySQL->Select("DISTINCT tbmksajiupy.HRPELMKSAJI","tbmksajiupy","WHERE tbmksajiupy.THSMSMKSAJI = '".$thn."' 
      AND tbmksajiupy.KDPSTMKSAJI = '".$row."'");
			$i=0;
			$jml=$MySQL->num_rows();
			while ($master=$MySQL->fetch_array()) {
				$ms[$i]=$master['HRPELMKSAJI'];
				$i++;
			}
			
			for ($i=0;$i < $jml;$i++) {
				$this->SetFillColor(255,255,255);			
				$this->SetFont('Arial','',6);
				$MySQL->Select("tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.KELASMKSAJI,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI,tbmksajiupy.NMDOSMKSAJI,
        tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.SMPAIMKSAJI,ruangNama AS RUANGMKSAJI",
        "tbmksajiupy",
        "LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) 
        LEFT JOIN ruang_kuliah ON ruangId = tbmksajiupy.RUANGMKSAJI 
        WHERE tbmksajiupy.KDPSTMKSAJI = '".$row."' AND tbmksajiupy.THSMSMKSAJI = '".$thn."' 
        AND tbmksajiupy.HRPELMKSAJI = '".$ms[$i]."'","tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI","");
				$no=1;
				$tt=$MySQL->num_rows();
				while ($show=$MySQL->fetch_array()) {
					//$mulai= New Time($show['MULAIMKSAJI']);
					//$durasi=($show['DURSIMKSAJI'] * 60);
					//$selesai=$mulai->add($durasi);
					if ($no==1) {
						$this->Cell(12,5,$show['HRPELMKSAJI'],"1","","L",1);
					} elseif ($no == $tt) {
						$this->Cell(12,5,"","LBR","","L",1);
					} else {
						$this->Cell(12,5,"","LR","","L",1);						
					}
					$this->Cell(23,5,substr($show['MULAIMKSAJI'],0,5)." s.d. ".substr($show['SMPAIMKSAJI'],0,5),"1","","L",1);
					$this->Cell(17,5,$show['KDKMKMKSAJI'],"1","","L",1);
					$this->Cell(55,5,$show['NAMKTBLMK'],"1","","L",1);
					$this->Cell(7,5,$show['KELASMKSAJI'],"1","","C",1);
					$this->Cell(7,5,$show['SKSMKMKSAJI'],"1","","C",1);
					$this->Cell(7,5,$show['SEMESMKSAJI'],"1","","C",1);
					$this->Cell(50,5,$show['NMDOSMKSAJI'],"1","","L",1);
					$this->Cell(15,5,$show['RUANGMKSAJI'],"1","","L",1);
					$this->Ln();
					$no++;
				}
			}
			$this->Ln();
		}	
	}

	function Page5($pst="",$thn){       // ============ CETAK GROUP BY DOSEN =============
		global $MySQL;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$this->AddPage();
		$this->SetTopMargin(35);
		$this->Ln(25);
		foreach ($pst as $row) {
			$this->SetFont('Arial','B',8);
			$this->Cell(190,5,"Program Studi : ".LoadProdi_X("",$row));
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell(50,5,"Dosen","1","","C",1);
			$this->Cell(17,5,"Kode MK","1","","C",1);
			$this->Cell(55,5,"Matakuliah","1","","C",1);
			$this->Cell(7,5,"Kls","1","","C",1);
			$this->Cell(7,5,"SKS","1","","C",1);
			$this->Cell(7,5,"Sem","1","","C",1);
			$this->Cell(12,5,"Hari","1","","C",1);
			$this->Cell(23,5,"Waktu","1","","C",1);
			$this->Cell(15,5,"Ruang","1","","C",1);
			$this->Ln();
			$MySQL->Select("DISTINCT tbmksajiupy.NODOSMKSAJI","tbmksajiupy","WHERE tbmksajiupy.THSMSMKSAJI = '".$thn."' 
      AND tbmksajiupy.KDPSTMKSAJI = '".$row."'");
			$i=0;
			$jml=$MySQL->num_rows();
			while ($master=$MySQL->fetch_array()) {
				$ms[$i]=$master['NODOSMKSAJI'];
				$i++;
			}
			
			for ($i=0;$i < $jml;$i++) {
				$this->SetFillColor(255,255,255);			
				$this->SetFont('Arial','',6);
				$MySQL->Select("tbmksajiupy.KDKMKMKSAJI,tblmkupy.NAMKTBLMK,tbmksajiupy.KELASMKSAJI,tbmksajiupy.SKSMKMKSAJI,tbmksajiupy.SEMESMKSAJI,
        tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI,tbmksajiupy.HRPELMKSAJI,tbmksajiupy.MULAIMKSAJI,tbmksajiupy.DURSIMKSAJI,tbmksajiupy.SMPAIMKSAJI,
        ruangNama AS RUANGMKSAJI",
        "tbmksajiupy",
        "LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) 
        LEFT JOIN ruang_kuliah ON ruangId = tbmksajiupy.RUANGMKSAJI
        WHERE tbmksajiupy.KDPSTMKSAJI = '".$row."' 
        AND tbmksajiupy.THSMSMKSAJI = '".$thn."' AND tbmksajiupy.NODOSMKSAJI = '".$ms[$i]."'  AND HRPELMKSAJI IS NOT NULL",
        "tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI","");
        //echo $MySQL->qry; exit;
				$no=1;
				$tt=$MySQL->num_rows();
				while ($show=$MySQL->fetch_array()) {
					$mulai= New Time($show['MULAIMKSAJI']);
					$durasi=($show['DURSIMKSAJI'] * 60);
					$selesai=$mulai->add($durasi);
					if ($no==1) {
						$this->Cell(50,5,$show['NODOSMKSAJI']." - ".$show['NMDOSMKSAJI'],"1","","L",1);
					}
           elseif ($no == $tt) {
						$this->Cell(50,5,"","LBR","","L",1);
					}/* elseif ($no==2) {
							$this->Cell(50,5,$show['NMDOSMKSAJI'],"LR","","L",1);
					} */
          else {
						$this->Cell(50,5,"","LR","","L",1);
					}
					$this->Cell(17,5,$show['KDKMKMKSAJI'],"1","","L",1);
					$this->Cell(55,5,$show['NAMKTBLMK'],"1","","L",1);
					$this->Cell(7,5,$show['KELASMKSAJI'],"1","","C",1);
					$this->Cell(7,5,$show['SKSMKMKSAJI'],"1","","C",1);
					$this->Cell(7,5,$show['SEMESMKSAJI'],"1","","C",1);
					$this->Cell(12,5,$show['HRPELMKSAJI'],"1","","L",1);
					$this->Cell(23,5,substr($show['MULAIMKSAJI'],0,5)." s.d. ".substr($show['SMPAIMKSAJI'],0,5),"1","","L",1);
					$this->Cell(15,5,$show['RUANGMKSAJI'],"1","","L",1);
					$this->Ln();
					$no++;
				}
			}
			$this->Ln();
		}	
	}
	
	function Sign($space=1,$mahasiswa){
/*		global $PREFIX;
		$this->Ln(5+$space);
		$this->SetFont('Arial','',8);
		$this->Cell(130,5,"",0,0,'R');
		$this->Cell(30,5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".FormatDateTime(time(),2),0,0,'L');
		$this->Ln();
		$this->Cell(80,3,"",0,0,'L');
		$this->Cell(50,3,"Mahasiswa,",0,0,'L');
		$this->Cell(30,3,"Dosen Pembimbing Akademik,",0,0,'L');
		$this->Ln(18);
		$this->SetFont('Arial','U',8);
		$this->Cell(80,3,"",0,0,'L');
		$this->Cell(50,3,$mahasiswa[0],0,0,'L');
		$this->Cell(80,3,$_SESSION[$PREFIX.'nama_penandatangan'],0,0,'L');
		$this->Ln();
		$this->SetFont('Arial','',8);
		$this->Cell(80,3,"",0,0,'L');
		$this->Cell(50,3,"NPM : ".$mahasiswa[1],0,0,'L');
		$this->Cell(80,3,"NIP : ".$_SESSION[$PREFIX.'nip_penandatangan'],0,0,'L');*/
	}

	
	function Header(){
		global $PREFIX;
		$report_title=$_POST['report_title'];
		switch ($report_title) {
			case '0' :
				$tahun_akademik=$_POST['tahun_akademik'];
				$title ="PRESENSI DOSEN MENGAJAR";
				$x=201;
				$x1=73;
				break;
			case '1' :
				$title ="DAFTAR HADIR KULIAH";
				$x=339;
				$x1=140;
				break;
			case '2' :
				$tahun_akademik=$_POST['tahun_akademik'];
				$title ="JADWAL KULIAH";
				$x=201;
				$x1=88;
				break;
			case '3' :
				$tahun_akademik=$_POST['tahun_akademik'];
				$title ="JADWAL KULIAH";
				$x=201;
				$x1=88;
				break;
			case '4' :
				$tahun_akademik=$_POST['tahun_akademik'];
				$title ="JADWAL KULIAH";
				$x=201;
				$x1=88;
				break;
		}
		if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
			$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,2,16,17);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',14);
		$this->Text(30,10,$_SESSION[$PREFIX.'NMPTIMSPTI']);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,14,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
		$this->SetFont('Arial','B',12);
		$this->Text($x1,27,$title);
		if ($report_title != '1') {
			$this->SetFont('Arial','B',10);
			$this->Text(83,32,"TA. ".substr($tahun_akademik,0,4)."/".(substr($tahun_akademik,0,4) + 1)." Sem. ".LoadSemester_X("",substr($tahun_akademik,4,1)));
		}
		$this->SetLineWidth(0.5);
		$this->Line(10,20,$x,20);
		$this->SetLineWidth(0);
		$this->Line(10,21,$x,21);	
	}
	
	function Footer(){
		$this->SetFont('Arial','',10);
//		$this->AliasNbPages('PageCount');
		//$this->Cell(190,6,"Page ".$this->PageNo()."/".$this->AliasNbPages,0,0,'L');
		$this->Ln(20);
	}
}
$pdf=new PDF();
//$pdf->AddPage();

// ALL
$report_title=$_POST['report_title'];
$tahun_akademik=$_POST['tahun_akademik'];
$program_studi=$_POST['program_studi'];
$program_studi=@explode(",",$program_studi);
if (isset($_POST['report_title'])){
	$data = $_SESSION[PREFIX.'data'];
	$pdf->SetTextColor(0);
	switch ($report_title) {
		case '0' :
			$title ="PRESENSI DOSEN MENGAJAR";
			$width1 = $width1="30,100,30,45";
			$width1= @explode(",",$width1);
			$pdf->Page($width1, $data);
			break;
		case '1' :
			$title ="DAFTAR HADIR KULIAH";
			$width1 = $width1="30,100,30,100,30,43";
			$width1= @explode(",",$width1);
			$pdf->Page2($width1, $data,$tahun_akademik);
			break;
		case '2' :
			$title ="JADWAL KULIAH (SEMESTER)";
			$pdf->Page3($program_studi,$tahun_akademik);
			break;
		case '3' :
			$title ="JADWAL KULIAH (HARI)";
			$pdf->Page4($program_studi,$tahun_akademik);
			break;
		case '4' :
			$title ="JADWAL KULIAH (DOSEN)";
			$pdf->Page5($program_studi,$tahun_akademik);
			break;
	}
}

$limit=$_POST['limit'];
$filename=str_replace(" ","_",$title).".pdf";
	
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>