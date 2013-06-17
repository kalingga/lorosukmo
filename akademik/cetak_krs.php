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
		$this->SetFont('Arial','B',12);
		$this->Cell(200,"","KARTU RENCANA STUDI","","","C");
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		foreach($mhs as $row){
			$this->Cell($w[0],3,$row[0],"");
			$this->Cell($w[1],3,$row[1],"");
			$this->Cell($w[2],3,$row[2],"");
			$this->Cell($w[3],3,$row[3],"");
			$this->Ln();
		}
		$this->Ln(1);
	}
	
	function Page2($w,$data,$mahasiswa){
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$this->SetFont('Arial','B',8);
		$this->SetFillColor(223,223,223);
		$this->Cell($w[0],5,"No","1","","C","1");
		$this->Cell($w[1],5,"Kode MK","1","","",1);
		$this->Cell($w[2],5,"Nama Matakuliah","1","","",1);
		$this->Cell($w[3],5,"Kls","1","","C",1);
		$this->Cell($w[4],5,"Sem","1","","C",1);
		$this->Cell($w[5],5,"SKS","1","","C",1);
		$this->Cell($w[6],5,"B/U/P","1","","C",1);
		$this->Cell($w[7],5,"Dosen","1","","",1);
		$this->Ln();
		$no=1;
		$sks=0;
		$this->SetFont('Arial','',8);
		$this->SetFillColor(255,255,255);
		for ($i=0;$i < 12;$i++){
			$this->Cell($w[0],5,$no." ","1","","R");
			$this->Cell($w[1],5,$data[$i][1],"1");
			$this->Cell($w[2],5,$data[$i][2],"1");
			$this->Cell($w[3],5,$data[$i][3],"1","","C");
			$this->Cell($w[4],5,$data[$i][4],"1","","C");
			$this->Cell($w[5],5,$data[$i][5],"1","","C");
			$this->Cell($w[6],5,$data[$i][8],"1","","C");
			$this->Cell($w[7],5,$data[$i][6],"1");
			$this->Ln();
			$no++;
			$sks+=$data[$i][5];
		}
		
	//	7,20,66,8,8,8,8,67
		$this->SetFont('Arial','B',8);
		$this->Cell(109,5,"JUMLAH SKS","1","","C");
		$this->Cell(83,5,$sks." SKS","1","","C");
		$this->Ln();
		$this->SetFont('','I',8);
		$this->Cell(192,5,"Keterangan B/U/P : B=Baru, U=Ulang (Pernah menempuh dengan nilai E atau D), P=Perbaikan (Pernah menempuh dengan nilai C atau B)","","","");
		$this->Sign($space_ttd,$mahasiswa);
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
	function Sign($space=1,$mahasiswa){
		global $PREFIX;
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
		$this->Cell(80,3,"NIDN : ".$_SESSION[$PREFIX.'nip_penandatangan'],0,0,'L');
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
		$this->Ln(14);
		$this->SetLineWidth(0.5);
		$this->Line(10,20,201,20);
		$this->SetLineWidth(0);
		$this->Line(10,21,201,21);
	
//		$this->Cell(190,.3,'','TB');
		if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
			$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,158,16,17);
		$this->SetTextColor(0);
		$this->SetFont('Arial','B',14);
		$this->Text(30,166,$_SESSION[$PREFIX.'NMPTIMSPTI']);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,170,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
		$this->SetLineWidth(0.5);
		$this->Line(10,176,201,176);
		$this->SetLineWidth(0);
		$this->Line(10,177,201,177);
//		$this->Cell(190,.5,'','TB');
	}
	
	function Footer(){
		$this->SetFont('Arial','',10);
//		$this->AliasNbPages('PageCount');
		//$this->Cell(190,6,"Page ".$this->PageNo()."/".$this->AliasNbPages,0,0,'L');
		$this->Ln(20);
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
$report_title="KARTU RENCANA STUDI";
$limit=$_POST['limit'];
$filename=str_replace(" ","_",$report_title).".pdf";
$no_urut=0;
//BIODATA
if (isset($_POST['width1']) && isset($_POST['width2'])){
	$width1= @explode(",",$_POST['width1']);
	$width2= @explode(",",$_POST['width2']);
	$mhs = $_SESSION[PREFIX.'mhs'];
	$data = $_SESSION[PREFIX.'data'];
	$mahasiswa=@explode(",",$_POST['mahasiswa']);

	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Page($width1, $mhs);
	$pdf->Page2($width2,$data,$mahasiswa);
	$pdf->Ln(40);
	$pdf->SetLineWidth(0);
	$pdf->Line(10,153,200,153);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Page($width1, $mhs);
	$pdf->Page2($width2,$data,$mahasiswa);
}

	
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>