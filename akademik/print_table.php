<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}
	
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Table($title,$w,$align,$header,$data,$style='1',$show_header='yes',$sub_title=""){
		$this->SetTextColor(0);
		$this->SetDrawColor(100,100,100);
		$this->SetFont('Arial','B',12);
		$this->Cell(190,6,$title,0,0,'C');
		$this->Ln();
		if (!empty($sub_title)){
			$this->SetFont('Arial','B',10);
			$sub_title_arr=explode('|',$sub_title);
			foreach($sub_title_arr as $subtitle){
				$this->Cell(190,7,$subtitle,0,0,'C');
				$this->Ln();	
			}
		}
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
		foreach($data as $row){
			$nb=0;
			for($i=0;$i<count($row);$i++)
				$nb=max($nb,$this->NbLines($w[$i],trim($row[$i])));
			$h=5*$nb;
			$this->CheckPageBreak($h);
			for($i=0;$i<$count_header;$i++){
				//if ($i==3)
					$x=$this->GetX();
					$y=$this->GetY();
					$this->Rect($x,$y,$w[$i],$h);
					if (empty($row[$i])) $row[$i]='';
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
		$this->SetFont('Arial','',10);
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".FormatDateTime(time(),2),0,0,'C');
		$this->Ln();
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'NMPTIMSPTI'],0,0,'C');
		$this->Ln();
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'lembaga_instansi'],0,0,'C');
		$this->Ln(14);
		$this->SetFont('Arial','U',10);
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$_SESSION[$PREFIX.'nama_penandatangan'],0,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',10);
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
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->AliasNbPages('PageCount');
		//$this->Cell(190,6,"Page ".$this->PageNo()."/".$this->AliasNbPages,0,0,'L');	;		
	}
}
	
$pdf=new PDF();
$width_col_table= @explode(",",$_POST['width_col_table']);
$align_col_table= @explode(",",$_POST['align_col_table']);
$header_table = @explode(",",$_POST['header_table']);
$field_name = @explode(",",$_POST['field_name']);
$qry_table = strip_tags($_POST['qry_table']);
$qry_table=stripslashes($qry_table);
$report_title=$_POST['report_title'];
$space_ttd=$_POST['space_ttd'];
$show_header=$_POST['show_header'];
$report_sub_title=$_POST['report_sub_title'];
$filename=str_replace(" ","_",$_POST['report_title']).".pdf";

if (!empty($qry_table)){
	$MySQL->qry=$qry_table;
	$MySQL->Execute(0);
	$data=array();
	$i=0;
	while ($show=$MySQL->Fetch_Array()){
		$data[$i][0]=$i+1;
		for($j=1;$j<count($header_table);$j++){
			if (preg_match("/tgl_/i", $field_name[$j-1]) or 
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
}
$pdf->AddPage();
$pdf->Table($report_title,$width_col_table, $align_col_table, $header_table,$data,3,$show_header,$report_sub_title);
$pdf->Sign($space_ttd);
if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
	$pdf->Output($filename,'D');
else
	$pdf->Output($filename,'I');

?>