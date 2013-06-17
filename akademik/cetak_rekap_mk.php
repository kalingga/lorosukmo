<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}
	
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$data,$prodi,$id,$thn){
		global $MySQL;
		$this->SetTopMargin(30);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$this->Ln(20);
		$this->SetFont('Arial','',8);
		$this->Cell(30,5,"Program Studi","");
		$this->Cell(100,5,": ".$prodi,"");
		$this->Ln();
		$this->Cell(30,5,"Kurikulum Tahun","");
		$this->Cell(100,5,": ".$thn,"");
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(223,223,223);			
		$this->Cell(10,5,"No","1","","C","1");
		$this->Cell(25,5,"Kode MK","1","","C",1);
		$this->Cell(80,5,"Matakuliah","1","","",1);
		$this->Cell(20,5,"SKS","1","","C",1);
		$this->Cell(25,5,"Prasyarat","1","","C",1);
		$this->Cell(30,5,"Kurikulum","1","","C",1);
		$this->Ln();		

		foreach($data as $row){
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255,255,255);			
			$this->Cell(190,5,"Semester ".$row,"1","","","1");
			$this->Ln();		
			$MySQL->Select("tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SKSTMTBKMK,tbkmkupy.SKSPRTBKMK,tbkmkupy.SKSLPTBKMK,tbkmkupy.KDKURTBKMK,tbkmkupy.KDSYATBKMK,tblmkupy.NAMKTBLMK","tbkmkupy","LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.IDKURTBKMK ='".$id."' and tbkmkupy.SEMESTBKMK='".$row."'","tbkmkupy.KDKMKTBKMK ASC");
			$no=1;
			$sksTotal=0;
			while ($show=$MySQL->Fetch_Array()) {
				$syarat=$show['KDSYATBKMK'];
				if ($syarat=='-1') $syarat="-";
				$this->Cell(10,5,$no,"1","","C","1");
				$this->Cell(25,5,$show['KDKMKTBKMK'],"1","","C",1);
				$this->Cell(80,5,$show['NAMKTBLMK'],"1","","",1);
				$this->Cell(20,5,$show['SKSMKTBKMK']."-".$show['SKSTMTBKMK']."-".$show['SKSPRTBKMK']."-".$show['SKSLPTBKMK'],"1","","C",1);
				$this->Cell(25,5,$syarat,"1","","C",1);
				$this->Cell(30,5,$show['KDKURTBKMK'],"1","","C",1);
				$this->Ln();
		     	$sksTotal += $show['SKSMKTBKMK'];
		     	$no++;
			}
			$this->SetFont('Arial','B',8);
			$this->Cell(115,5,"SKS Total  ","1","","R","1");
			$this->Cell(20,5,$sksTotal." SKS","1","","C","1");
			$this->Cell(55,5,"","1","1","C","1");
			//$this->Ln();
		}
		$this->Cell(190,5,"Keterangan Kurikulum : A = Inti, B = Institusi","T","","","1");
		$this->Ln();
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
		$this->Text(73,27,"DAFTAR MATAKULIAH");
		$this->SetLineWidth(0.5);
		$this->Line(10,20,201,20);
		$this->SetLineWidth(0);
		$this->Line(10,21,201,21);	
	}
	
	function Footer(){
		$this->SetFont('Arial','',10);
		$this->AliasNbPages('PageCount');
		$this->Cell(205,6,"Halaman ".$this->PageNo()."/".$this->AliasNbPages,0,0,'R');
		$this->Ln(20);
	}
}
$pdf=new PDF();
$pdf->AddPage();

// ALL
$indikator=$_POST['indikator'];
$indikator=@explode(",",$indikator);
$prodi=$indikator[0];
$id=$indikator[1];
$thn=$indikator[2];

$report_title="DAFTAR MATAKULIAH";
$width1 ="30,100";
if (isset($_POST['indikator'])){
	$data = $_SESSION[PREFIX.'data'];
	$pdf->SetTextColor(0);
	$pdf->Page($width1,$data,$prodi,$id,$thn);
}

$limit=$_POST['limit'];
$filename=str_replace(" ","_",$report_title).".pdf";
	
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>