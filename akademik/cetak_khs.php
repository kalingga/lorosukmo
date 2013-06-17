<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}
	
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$mhs){
		$this->SetTextColor(0);
		$this->SetDrawColor(100,100,100);
		$this->SetFont('Arial','',8);

		foreach($mhs as $row){
			$this->Cell($w[0],3,$row[0],"");
			$this->Cell($w[1],3,$row[1],"");
			$this->Cell($w[2],3,$row[2],"");
			$this->Cell($w[3],3,$row[3],"");
			$this->Ln();
		}
		$this->Ln(1);
	}
	
	function Page2($w,$data,$ip_sem,$ip_kum){
		$this->SetTextColor(0);
		$this->SetDrawColor(100,100,100);
		$this->SetFont('Arial','',8);
		$this->Cell($w[0],5,"No","1","","C");
		$this->Cell($w[1],5,"Kode MK","1");
		$this->Cell($w[2],5,"Matakuliah","1");
		$this->Cell($w[3],5,"SKS","1","","C");
		$this->Cell($w[4],5,"Nilai","1","","C");
		$this->Cell($w[5],5,"Bobot","1","","C");
		$this->Cell($w[6],5,"Total","1","","C");
		$this->Ln();
		$no=1;
		$sks=0;
		for ($i=0;$i < 12;$i++){
			$this->Cell($w[0],5,$no." ","1","","R");
			$this->Cell($w[1],5,$data[$i][1],"1");
			$this->Cell($w[2],5,$data[$i][2],"1");
			$this->Cell($w[3],5,$data[$i][3],"1","","C");
			$this->Cell($w[4],5,$data[$i][4],"1","","C");
			$this->Cell($w[5],5,$data[$i][5],"1","","C");
			$this->Cell($w[6],5,$data[$i][6]."   ","1","","R");
			$jmlSKS += $data[$i][3];
			$jmlNilai += $data[$i][6];
			$this->Ln();
			$no++;
		}
		$this->Ln(1);
		$this->Cell(130,3,"Jumlah SKS  : ".$jmlSKS,"","","L");
		$this->Cell(80,3,"IP Semester  : ".$ip_sem,"","","L");
		$this->Ln();
		$this->Cell(130,3,"Jumlah Nilai  : ".$jmlNilai,"","","L");
		$this->Cell(80,3,"IP Kumulatif   : ".$ip_kum,"","","L");
		$this->Sign($space_ttd);
	}
	
	function Sign($space=1){
		global $PREFIX;
		$this->Ln(5+$space);
		$this->SetFont('Arial','',8);
		$this->Cell(110,3,"",0,0,'R');
		$this->Cell(80,3,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".FormatDateTime(time(),2),0,0,'C');
		$this->Ln(1);
		$this->Cell(110,3,"",0,0,'R');
		$this->Cell(80,3,$_SESSION[$PREFIX.'lembaga_instansi'],0,0,'C');
		$this->Ln(14);
		$this->SetFont('Arial','U',8);
		$this->Cell(110,3,"",0,0,'R');
		$this->Cell(80,3,$_SESSION[$PREFIX.'nama_penandatangan'],0,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',8);
		$this->Cell(110,3,"",0,0,'');
		$this->Cell(80,3,"NIP : ".$_SESSION[$PREFIX.'nip_penandatangan'],0,0,'C');
		$this->Ln(1);
	}

	
	function Header(){
		global $PREFIX;
		if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
			$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,2,16,17);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',18);
		$this->Text(30,9,"KARTU HASIL STUDI");
		$this->Ln();
		$this->SetFont('Arial','B',12);
		$this->Text(30,13,$_SESSION[$PREFIX.'NMPTIMSPTI']);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,17,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
		$this->Ln(14);
		$this->SetLineWidth(0.5);
		$this->Line(10,20,201,20);
		$this->SetLineWidth(0);
		$this->Line(10,21,201,21);
	
//		$this->Cell(190,.3,'','TB');
		if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
			$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,143,16,17);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',18);
		$this->Text(30,150,"KARTU HASIL STUDI");
		$this->Ln();
		$this->SetFont('Arial','B',12);
		$this->Text(30,155,$_SESSION[$PREFIX.'NMPTIMSPTI']);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,159,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
		$this->SetLineWidth(0.5);
		$this->Line(10,163,201,163);
		$this->SetLineWidth(0);
		$this->Line(10,164,201,164);
//		$this->Cell(190,.5,'','TB');
	}	
}
	
$pdf=new PDF();
$pdf->AddPage();

// ALL
$report_title="KARTU HASIL STUDI";
$limit=$_POST['limit'];
$no_urut=0;
//BIODATA
if (isset($_POST['id'])) {
	$MySQL->Select("THSMSTRAKM,NIMHSTRAKM,NLIPSTRAKM,NLIPKTRAKM","trakmupy","where trakmupy.IDX='".$_POST['id']."'","","1");
	$show=$MySQL->Fetch_Array();
	$ThnSemester=$show["THSMSTRAKM"];
	$nim=$show["NIMHSTRAKM"];
	$ip_sem=$show["NLIPSTRAKM"];
	$ip_kum=$show["NLIPKTRAKM"];

	$mahasiswa_X=GetMhsDetail_X($nim);
	$mahasiswa_X=@explode(",",$mahasiswa_X);
	$mahasiswa=$mahasiswa_X[0];
	$prodi=$mahasiswa_X[1];
	$fakultas=$mahasiswa_X[2];
	$nidn=$mahasiswa_X[3];
	$dosenpa=LoadDosen_X("",$nidn);

	$width1="30,100,30,45"; // 160
	$width2="7,20,85,20,20,20,20"; // 160
	$width1= @explode(",",$width1);
	$width2= @explode(",",$width2);

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
	$mhs[$i][3]=": ".LoadKode_X("",substr($ThnSemester,4,1),"95");
	$i++;
	$mhs[$i][0]="Nama Dosen PA.";
	$mhs[$i][1]=": ".$dosenpa;
	$mhs[$i][2]="Tahun Akademik";
	$mhs[$i][3]=": ".substr($ThnSemester,0,4)."/".((substr($ThnSemester,0,4))+1);

	$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,trnlmupy.NLAKHTRNLM,trnlmupy.BOBOTTRNLM,(tbkmkupy.SKSMKTBKMK * trnlmupy.BOBOTTRNLM) AS TOTAL","trnlmupy","LEFT JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) LEFT JOIN tbkmkupy ON (trnlmupy.IDKMKTRNLM = tbkmkupy.IDX) WHERE trnlmupy.THSMSTRNLM = '".$ThnSemester."' AND trnlmupy.NIMHSTRNLM ='".$nim."' AND trnlmupy.STATUTRNLM = '1'","trnlmupy.IDX ASC");
	$i=0;
	while ($show=$MySQL->fetch_array()){
		$data[$i][0]=($i+1);
		$data[$i][1]=$show["KDKMKTRNLM"];
		$data[$i][2]=$show["NAMKTBLMK"];
		$data[$i][3]=$show["SKSMKTBKMK"];
		$data[$i][4]=$show["NLAKHTRNLM"];
		$data[$i][5]=$show["BOBOTTRNLM"];
		$data[$i][6]=$show["TOTAL"];
		$i++;
	}

	$filename=str_replace(" ","_",$report_title." ".$nim).".pdf";
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Page($width1, $mhs);
	$pdf->Page2($width2,$data,$ip_sem,$ip_kum);
	$pdf->Ln(36);
	$pdf->SetLineWidth(0);
	$pdf->Line(10,138,200,138);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Page($width1, $mhs);
	$pdf->Page2($width2,$data,$ip_sem,$ip_kum);
}

	
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>