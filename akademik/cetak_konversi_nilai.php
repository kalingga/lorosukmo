<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}
	
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$data){
		global $MySQL;
		$this->SetTopMargin(30);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$w=@explode(",",$w);
		foreach($data as $row){
			$this->AddPage();
			$this->SetTopMargin(30);
			$mahasiswa_dtl=GetMhsBaruDetail_X($row);
			$mahasiswa_dtl=@explode(",",$mahasiswa_dtl);
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
			$this->SetFont('Arial','',8);
			$this->Cell(25,5,"Nama Mahasiswa","");
			$this->Cell(65,5,": ".$nama,"");
			$this->Cell(25,5,"NPM","");
			$this->Cell(75,5,": ".$row,"");
			$this->Ln();
			$this->Cell(25,5,"Tempat, Tgl Lahir","");
			$this->Cell(65,5,": ".$tplLahir.", ".$tglLahir,"");
			$this->Cell(25,5,"Fakultas","");
			$this->Cell(75,5,": ".LoadFakultas_X("",$fakultas),"");
			$this->Ln();
			$this->Cell(25,5,"Pendidikan Asal","");
			$this->Cell(65,5,": ".LoadProdiDikti_X("",$pst_asal).".".LoadPT_X("",$pt_asal),"");
			$this->Cell(25,5,"Program Studi","");
			$this->Cell(75,5,": ".LoadProdi_X("",$prodi),"");
			$this->Ln();
			$this->Cell(25,5,"Tahun Masuk UPY","");
			$this->Cell(65,5,": ".$thn_masuk,"");
			$this->Cell(25,5,"Jenjang/Status","");
			$this->Cell(75,5,": ".LoadKode_X("",$jenjang,"04")."/".LoadKode_X("",$akreditasi,"07"),"");
			$this->Ln(5);
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(223,223,223);			
			$this->Cell($w[0],5,"No","1","","C",1);
			$this->Cell($w[1],5,"Kode MK","1","","C",1);
			$this->Cell($w[2],5,"Matakuliah","1","","",1);
			$this->Cell($w[3],5,"Sem","1","","C",1);
			$this->Cell($w[4],5,"Nilai","1","","C",1);
			$this->Cell($w[5],5,"Bobot","1","","C",1);
			$this->Cell($w[6],5,"SKS","1","","C",1);
			$this->Cell($w[7],5,"Mutu","1","","C",1);
			$this->Ln();
			$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.SEMESTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM,trnlmupy.SKSMKTRNLM,(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM) AS NILAI","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) WHERE trnlmupy.NIMHSTRNLM='".$row."' AND trnlmupy.ISKONTRNLM","trnlmupy.SEMESTRNLM ASC,trnlmupy.KDKMKTRNLM ASC","");
			$no=1;
			if ($MySQL->num_rows()) {
				while ($show=$MySQL->fetch_array()) {
					$this->SetFont('Arial','',8);
					$this->SetFillColor(255,255,255);			
					$this->Cell($w[0],5,$no,"1","","C",1);
					$this->Cell($w[1],5,$show["KDKMKTRNLM"],"1","","C",1);
					$this->Cell($w[2],5,$show["NAMKTBLMK"],"1","","",1);
					$this->Cell($w[3],5,$show["SEMESTRNLM"],"1","","C",1);
					$this->Cell($w[4],5,$show["NLAKHTRNLM"],"1","","C",1);
					$this->Cell($w[5],5,$show["BOBOTTRNLM"],"1","","C",1);
					$this->Cell($w[6],5,$show["SKSMKTRNLM"],"1","","C",1);
					$this->Cell($w[7],5,$show["NILAI"],"1","","C",1);
					$this->Ln();
					$bobot += $show["BOBOTTRNLM"];
					$sks += $show["SKSMKTRNLM"];
					$nilai += $show["NILAI"];
					$no++;				
				}
				$ip=($nilai / $sks);
			} else {
					$bobot = "-";
					$sks = "-";
					$nilai = "-";
					$ip = "-";
			}
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(255,255,255);			
			$this->Cell(117,5,"Indeks Prestasi : ".$ip,"1","","C",1);
			$this->Cell(15,5,"Total","1","","C",1);
			$this->Cell(15,5,"","1","","C",1);
			$this->Cell(15,5,$bobot,"1","","C",1);
			$this->Cell(15,5,$sks,"1","","C",1);
			$this->Cell(15,5,$nilai,"1","","C",1);
			$this->Ln();			
		}
	}
	
	function Header(){
		global $PREFIX;
		if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
			$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,2,16,17);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',14);
		$this->Text(30,10,$_SESSION[$PREFIX.'NMPTIMSPTI']);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,14,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
		$this->SetFont('Arial','B',12);
		$this->Text(90,27,$_POST['report_title']);
		$this->SetLineWidth(0.5);
		$this->Line(10,20,201,20);
		$this->SetLineWidth(0);
		$this->Line(10,21,201,21);	
	}
	
	function Footer(){
/*		$this->SetFont('Arial','',10);
		$this->AliasNbPages('PageCount');
		$this->Cell(205,6,"Halaman ".$this->PageNo()."/".$this->AliasNbPages,0,0,'R');
		$this->Ln(20);*/
	}
}
$pdf=new PDF();
//$pdf->AddPage();

// ALL
$report_title=$_POST['report_title'];
$width1 ="9,30,78,15,15,15,15,15";
if (isset($_SESSION[PREFIX.'data1'])){
	$data = $_SESSION[PREFIX.'data1'];
	$pdf->Page($width1,$data);
}

$limit=$_POST['limit'];
$filename=str_replace(" ","_",$report_title).".pdf";
	
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>