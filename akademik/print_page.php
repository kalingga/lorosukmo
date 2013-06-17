<?php
include "include/config.php";
/*if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}	*/
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
//Colored table
	var $TitleReport;
	var $BannerReport;
	var $HeaderTable;
	var $HeightHeaderTable=6;
	var $HeightDataTable=5;
	var $WidthColTable;
	var $TempatTglReport;
	var $Nama;
	var $NIP;
	var $Logo;
	var $Lembaga;
	var $Instansi;
	var $WidthBorderHeader=1;
	var $HeaderAlignment;
	var $DataAlignment;
	var $spaceTTD=0;

	function SetParameter($ttr){
		global $MySQL,$PREFIX;
/*		if ($_POST['page']=='formpmb') {
			$MySQL->Select("*","setpmbupy","where TASETPMB='".date("Y",$ttr)."'","","1");
			$show=$MySQL->Fetch_Array();
			$lembaga=$show['LBGSETPMB'];
  			$nama=$show['NIKSETPMB'];
  			$nip=$show['NMTTSETPMB'];
		}*/
		$this->Nama=$_SESSION[$PREFIX.'nama_penandatangan'];
		$this->NIP=$_SESSION[$PREFIX.'nip_penandatangan'];
		$this->Logo=$_SESSION[$PREFIX.'logo_instansi'];
		$this->Instansi=$_SESSION[$PREFIX.'nama_instansi'];
		$this->Lembaga=$_SESSION[$PREFIX.'lembaga_instansi'];
		$this->TempatTglReport=$ttr;
		$this->AliasNbPages('PageCount');
	}
	
	function CreatePage($data)	{
		//Colors, line width and bold font
		$this->SetDrawColor(0,0,0);
		$this->SetLineWidth(0);
		//Color and font restoration
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		//Data
		$fill=0;

		foreach($data as $row){
			for($i=0;$i<count($this->WidthColTable);$i++){
				$align="L";
				if (!empty($this->DataAlignment[$i])) $align=$this->DataAlignment[$i];
				$this->Cell($this->WidthColTable[$i],$this->HeightDataTable,$row[$i],'LR',0,$align,$fill);
			}
			$this->Ln();
			$fill=!$fill;
		}
		if (!empty($this->Photo))	$this->Image($this->Photo,175,40,20,27);
		$this->Cell(@array_sum($this->WidthColTable),0,'','T');
		
		$this->Ln(5+$this->spaceTTD);
		$this->SetFont('Arial','',11);
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$this->TempatTglReport,0,0,'C');
		$this->Ln();
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$this->Instansi,0,0,'C');
		$this->Ln();
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$this->Lembaga,0,0,'C');
		$this->Ln(14);
		$this->SetFont('Arial','U',11);
		$this->Cell(110,5,"",0,0,'R');
		$this->Cell(80,5,$this->Nama,0,0,'C');
		$this->Ln();
		$this->SetFont('Arial','',11);
		$this->Cell(110,5,"",0,0,'');
		$this->Cell(80,5,"NIP : ".$this->NIP,0,0,'C');
		$this->Ln();	
	}
	
	function Footer(){
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(190,6,"Page ".$this->PageNo()."/".$this->AliasNbPages,0,0,'L');	;		
	}
	
	function Header(){
		if (file_exists($this->BannerReport))
			$this->Image($this->BannerReport,5,5,200,25);
		if (file_exists($this->Logo))
			$this->Image($this->Logo,9,8,15,20);
		$this->SetTextColor(255,255,255);
		$this->SetFont('Arial','B',12);
		$this->Text(30,13,$this->Lembaga);
		$this->Ln();
		$this->SetFont('Arial','B',18);
		$this->Text(30,20,$this->Instansi);
		$this->Ln();
		$this->SetFont('Arial','B',9);
		$this->Text(30,25,$this->Alamat);
		$this->SetTextColor(0,0,0);
		$this->Ln(22);
		$this->SetFont('Arial','B',13);
		$this->Cell(190,6,$this->TitleReport,0,0,'C');
		$this->Ln(8);
	}

}
	
	$qry = $_POST['qry'];
	$table=$_POST['table'];
	$delete_text_field=str_replace("tb_","",$table);
	$join_table=$_POST['join_table'];
	$join_table_arr=explode(",",$join_table);
	$spaceTTD = $_POST[spaceTTD];
	$MySQL->qry=$qry;
	$MySQL->Execute(0);
	$show=$MySQL->Fetch_Array();
	$MySQL2->qry="DESCRIBE `$table`";
	$MySQL2->Execute(0);
	$data=array();
	$i=0;
	$j=0;
	while($show2=$MySQL2->Fetch_Array()){
		$noshow="id_".substr($table,3,strlen($table));
		if ($_POST['page']=='identitas_pegawai'){
			if ($show2[Field]==$noshow){
				$i++;
				$j=1;
				continue;
			}
		} 

		$data[$i][0]="";
		$data[$i][1]=":";
		$data[$i][2]=$show[$j];
		$data[$i][3]="";	
		$field=$show2['Field'];
		$field_arr=explode("_",$field);
		$field_show="";
		foreach ($field_arr as $fields){
			if ($field_arr[0]!="id" and $fields==$delete_text_field){
			}
			else{
				if (!empty($field_show)) $field_show.=" ";
				$fields=str_replace(array("gol","tgl"),array("golongan","tanggal"),$fields);
				if ($fields=="id" and $field_arr[1]!=$delete_text_field){
				
				}
				else{
					$field_show.=substr(strtoupper($fields),0,1).substr($fields,1,strlen($fields));
				}
			}
		}
		$field_show=str_replace(
		array("Nip","Ktp","Npwp","Gender","Nama","Bakn","Sk","Cpns","Sttp","Tmt"),
		array("NIP","KTP","NPWP","Jenis Kelamin","Nama Lengkap","BAKN","SK","CPNS","STTP","TMT"),$field_show);
		$data[$i][0] = $field_show;
		$data[$i][1] = ":";
		$type2=$show2['Type'];
		$curr_type='';
		$curr_length='';
		$pos1 = strpos($type2, '(', 0);
		if ($pos1>0){
			$curr_type=substr($type2,0,$pos1);
			$pos2 = strpos($type2, ')', 0);
			$curr_length=stripslashes(substr($type2,$pos1+1,$pos2-$pos1-1));
		}
		else{
			$curr_type=$type2;
		}		

		$type_arr1 = array("varchar", "char");
		$type_arr2 = array("int","bigint","tinyint","float","double","decimal","shortint");
		$with_join_table=false;
		foreach ($join_table_arr as $join_table){
			if 	(substr($show2[Field],3,strlen($show2[Field]))==substr($join_table,3,strlen($join_table))){			
				$MySQL3->Select("*",$join_table,"WHERE ".$show2[Field]."=".$show[$j]);
				$show3=$MySQL3->Fetch_Array();
				$data[$i][2] = $show3[1];
				$with_join_table=true;
				break;
			}
		}
		
		if ($with_join_table){
			
		}
		else if (in_array($curr_type, $type_arr1)) {
			if ($curr_length=='32'){
				continue;
			}
			else{
				if ($curr_type=="varchar" and $curr_length=="255"){
					if (preg_match("/photo/i", $field) or preg_match("/image/i", $show2[Field])) {
						$photo=$show[$j];
						$i--;
					} 
				}
				else if (preg_match("/tempat_lahir/i", $show2[Field])) {
					$tgl_lahir_arr=@explode("-",$show[$j+1]);;
					$data[$i][0]="Tempat & Tgl Lahir";
					$tgl_lahir=$tgl_lahir_arr[2]."-".$tgl_lahir_arr[1]."-".$tgl_lahir_arr[0];
					$data[$i][2]=$show[$j]." , ".$tgl_lahir;	
					$j++;$j++;
					$i++;
					continue;
				}
				else if (preg_match("/gelar_akademik/i", $field)) {
						$gelar=explode("|",$show[$j]);
						$data[$i-1][2]=$gelar[0]." ".$data[$i-1][2]." ".$gelar[1];
						$i--;
				} 
			}
		}
		else if ($curr_type=="date") {
			if (preg_match("/tgl_lahir/i", $show2[Field])) {
				$i--;
				$j--;
			}
			else{
				$tgl_arr=@explode("-",$show[$j]);
				$tgl=$tgl_arr[2]."-".$tgl_arr[1]."-".$tgl_arr[0];	
				$data[$i][2]=$tgl;
			}
		} 
		else if ($curr_type=="datetime") {
			$datetime_arr=@explode(" ",$show[$j]);
			$tgl=$datetime_arr[0];
			$jam=$datetime_arr[1];
			$tgl_arr=@explode("-",$tgl);
			$tgl=$tgl_arr[2]."-".$tgl_arr[1]."-".$tgl_arr[0];	
			$data[$i][2]=$tgl." ".$jam;
		} 

		$i++;
		$j++;
	}
	
if ($_POST['page']=='identitas_pegawai'){
	$pdf=new PDF();
	//Column titles
	$pdf->WidthColTable=array('40','5','100','*');
	$pdf->DataAlignment=array('','C','','C','C');
	$pdf->SetParameter($_SESSION[$PREFIX.'kabupaten_instansi'].", ".FormatDateTime(time(),2));
	$pdf->spaceTTD=$spaceTTD;
	$pdf->SetFont('Arial','',11);
	$pdf->TitleReport="LAPORAN PER PEGAWAI";
	$pdf->BannerReport="images/banner.jpg";
	$pdf->Photo=$photo;
	$pdf->AddPage();
	$pdf->CreatePage($data);
	$filename=$_POST['page'].".pdf";
	if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
		$pdf->Output($filename,'D');
	else
		$pdf->Output($filename,'I');
}


if ($_POST['page']=='pengangkatan_cpns'){
	$pdf=new PDF();
	//Column titles
	$pdf->WidthColTable=array('75','5','100','*');
	$pdf->DataAlignment=array('','C','','C','C');
	$pdf->SetParameter($_SESSION[$PREFIX.'kabupaten_instansi'].", ".FormatDateTime(time(),2));
	$pdf->spaceTTD=$spaceTTD;
	$pdf->SetFont('Arial','',11);
	$pdf->TitleReport="LAPORAN PER PEGAWAI";
	$pdf->BannerReport="images/banner.jpg";
	$pdf->Photo=$photo;
	$pdf->AddPage();
	$pdf->CreatePage($data);
	$filename=$_POST['page'].".pdf";
	if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
		$pdf->Output($filename,'D');
	else
		$pdf->Output($filename,'I');
}

?>