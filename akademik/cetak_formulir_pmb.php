<?php
include "include/config.php";	
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$data,$photo){
		$this->SetTextColor(0);
		$this->SetDrawColor(100,100,100);
		$this->SetFont('Arial','',8);
		$this->Ln();		

		foreach($data as $row){
			$this->CheckPageBreak($h);
			$this->Cell($w[0],3,$row[0]);
			$this->Cell($w[1],3,$row[1]);
			$this->Ln();
		}
		if ($_POST['buktidaftar']!="1") {
			$this->Ln();
			$this->Cell(20,5,"NO","1",0,"C");
			$this->Cell(60,5,"MATERI TEST","1",0,"C");
			$this->Cell(60,5,"TANGGAL","1",0,"C");
			$this->Cell(50,5,"TTD","1",0,"C");
			$this->Ln();

			for ($i=1;$i <= 5;$i++) {
				$this->Cell(20,5,$i,"1",0,"C");
				$this->Cell(60,5,"","1",0,"C");
				$this->Cell(60,5,"","1",0,"C");
				$this->Cell(50,5,"","1",0,"C");
				$this->Ln();
			}
		}				
		if (file_exists($photo)) $this->Image($photo,175,45,20,27);
	}
	
	function Table($w,$align,$header,$limit,$style='1',$show_header='yes'){
		$this->SetTextColor(0);
		$this->SetDrawColor(100,100,100);
		$this->SetLineWidth(.3);
		if ($show_header=='yes'){
			$count_header=count($header);			
			//Colors, line width and bold font
			$this->SetFillColor(230,230,230);
			$this->SetFont('Arial','B',10);
			//Header
			$nb=0;
			for($i=0;$i<$count_header;$i++)
				$nb=max($nb,$this->NbLines($w[$i],trim($header[$i])));
			$h=5*$nb;
			for($i=0;$i<$count_header;$i++){
				$x=$this->GetX();
				$y=$this->GetY();
				$this->Rect($x,$y,$w[$i],$h);
				$this->MultiCell($w[$i],5,$header[$i],0,'C',0);
				$this->SetXY($x+$w[$i],$y);
				//$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
			}
			$this->Ln($h);
		}
		else{
			$count_header=$header[0];
			if ($show_header=='no_border') $this->SetLineWidth(0);
			$this->Cell(array_sum($w),0,'','T');
			$this->Ln();
		}
		//Color and font restoration
		$this->SetFillColor(245,245,245);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Data
		$fill=0;
		
			for($i=0;$i<$limit;$i++)
				$nb=max($nb,$this->NbLines($w[$i],trim($row[$i])));
			$h=5*$nb;
			$this->CheckPageBreak($h);
			for($i=0;$i<$count_header;$i++){
				//if ($i==3)
					$x=$this->GetX();
					$y=$this->GetY();
					$this->Rect($x,$y,$w[$i],$h);
					if (empty($row[$i])) $row[$i]='-';
					$this->MultiCell($w[$i],5,$row[$i],'LR',$align[$i],$fill);
					$this->SetXY($x+$w[$i],$y);
				//else
					//$this->Cell($w[$i],5,$row[$i],'LR',0,$align[$i],$fill);
			}
			$this->Ln($h);
			if ($style==2){
				$fill=!$fill;
			}
			if ($style==3){
				$this->Cell(array_sum($w),0,'','T');
				$this->Ln();
			}
			if ($style==4){
				$fill=!$fill;
				$this->Cell(array_sum($w),0,'','T');
				$this->Ln();
			}
		$this->Cell(array_sum($w),0,'','T');
	}
	
	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	
	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
	function Sign($space=1){
		global $PREFIX;
		$this->Ln(5+$space);
		$this->SetFont('Arial','',9);
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".FormatDateTime(time(),2),0,0,'C');
		$this->Ln();
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'NMPTIMSPTI'],0,0,'C');
		$this->Ln();
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'lembaga_instansi'],0,0,'C');
		$this->Ln(14);
		$this->SetFont('Arial','U',9);
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'nama_penandatangan'],0,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',9);
		$this->Cell(110,5,"",0,0,'');
		$this->Cell(80,5,"NIP : ".$_SESSION[$PREFIX.'nip_penandatangan'],0,0,'C');
		$this->Ln();
	}

	
	function Header(){
		global $PREFIX;
		if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
			$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,8,18,20);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',12);
		$this->Text(30,13,$_SESSION[$PREFIX.'lembaga_instansi']);
		$this->Ln();
		$this->SetFont('Arial','B',18);
		$this->Text(30,20,$_SESSION[$PREFIX.'NMPTIMSPTI']);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,25,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
		$this->Ln(20);
		$this->Cell(190,.5,'','TB');
		$this->Ln(3);
	}
	
	function Footer(){
		$this->SetFont('Arial','',7);
//		$this->AliasNbPages('PageCount');
		//$this->Cell(190,6,"Page ".$this->PageNo()."/".$this->AliasNbPages,0,0,'L');
		$this->Ln(); // Tambahan
		
		$this->Ln();
		if ($_POST['buktidaftar']=="1") {
			$this->Text(9,125,"Catatan :");
			$this->Text(9,128,"1. Bukti Pendaftaran Bukan Merupakan Kartu Ujian");
			$this->Ln();
			$this->Text(9,131,"2. Segera Tukarkan Bukti Pendaftaran Dengan Kartu Ujian di Universitan Bersangkutan");
			$this->Text(9,134,"    disertai Syarat-syarat yang telah ditentukan :");
			$this->Text(9,137,"    - 4 lembar Pasfoto hitam putih ukuran 3 x 4");
			$this->Text(9,140,"    - FC Ijazah Terakhir");
			$this->Text(9,143,"    - Bukti Pembayaran Biaya Pendaftaran dari Bank");
			$this->Text(9,146,"    - Surat Keterangan Pindah Beserta Transkrip Nilai Bagi Calon Mahasiswa Pindahan");
		} else {
			$this->SetFont('Arial','',8);
			$this->Text(9,155,"Catatan :");
			$this->Text(9,158,"Gunakan No. Pendaftaran dan Password Anda apabila Ingin Mengikuti Ujian Secara Online");
			$this->Ln();
			$this->SetFont('Arial','B',9);
			$this->Text(9,161,"Password : ".$_POST['passwd']);
		}
	}
}

function getData($qry_table,$header_table,$field_name){
	global $PREFIX,$MySQL;
	$MySQL->qry=$qry_table;
	$MySQL->Execute(0);
	$data=array();
	$i=0;
	while ($show=$MySQL->Fetch_Array()){
		$data[$i][0]=$i+1;
		for($j=1;$j<count($header_table);$j++){
			if ("ttl|"==substr($field_name[$j-1],0,4)){
				//echo $field_name[$j-1];
				$x=explode("|",$field_name[$j-1]);
				$data[$i][$j]=$show["tempat_lahir_".$x[1]].", ".DateStr($show["tgl_lahir_".$x[1]]);
				//echo $data[$i][$j];
			}
			else if (preg_match("/tgl_/i", $field_name[$j-1]) or 
				preg_match("/tmt_/i", $field_name[$j-1])
				){
				$data[$i][$j]=DateStr($show[$field_name[$j-1]]);
			}
			else if ($field_name[$j-1]=="status_keluarga"){
				$data[$i][$j]="-";
				if ($show[$field_name[$j-1]]=='1')	$data[$i][$j]="Anak Kandung";
				if ($show[$field_name[$j-1]]=='2')	$data[$i][$j]="Anak Angkat";
				if ($show[$field_name[$j-1]]=='3')	$data[$i][$j]="Anak Tiri";
			}
			else if ($field_name[$j-1]=="status_tunjangan"){
				$data[$i][$j]="-";
				if ($show[$field_name[$j-1]]=='1')	$data[$i][$j]="Ya";
				if ($show[$field_name[$j-1]]=='0')	$data[$i][$j]="Tidak";
			}
			else
				$data[$i][$j]=$show[$field_name[$j-1]];
		}
		$i++;
	}	
	return $data;
}
	
$pdf=new PDF();
$pdf->AddPage();

// ALL
$report_title=$_POST['report_title'];
$sub_title=$_POST['sub_title'];
$space_ttd=$_POST['space_ttd'];
$buktidaftar=$_POST['buktidaftar'];
$passwd=$_POST['passwd'];
$limit=$_POST['limit'];
$filename=str_replace(" ","_",$_POST['report_title']).".pdf";
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,4,$report_title,0,0,'C');
$pdf->Ln();
$pdf->Cell(190,7,$sub_title,0,0,'C');

$no_urut=0;
//BIODATA
if (isset($_POST['width1'])){
	$width1= @explode(",",$_POST['width1']);
	$data1 = $_SESSION[PREFIX.'data1'];
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Page($width1, $data1, $photo1);
//	$pdf->Ln();
}
if ($pdf->GetY()>250) $pdf->Ln(20);
	$pdf->Sign($space_ttd);
	
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>