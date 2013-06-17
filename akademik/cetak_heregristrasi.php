<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	exit;
}

//jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND 	
//AND jwlutsuas.JENISUTSUAS = '".$_POST['jenis_ujian']."' 
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$data){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$i=0;
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			$tahun_akademik=$_POST['tahun_akademik'];
			$this->SetTopMargin(35);
			$this->AddPage();
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255,255,255);
			$this->cell(30,5,"Program Studi");
			$this->cell(160,5,": ".$prodi);
			$this->Ln();			
			$this->cell(30,5,"Tahun akademik");
			$this->cell(160,5,": ".substr($tahun_akademik,0,4)."/".(substr($tahun_akademik,0,4) + 1));
			$this->Ln();			
			$this->cell(30,5,"Semester");
			$this->cell(160,5,": ".LoadSemester_X("",substr($tahun_akademik,4,1)));
			$this->Ln();

			$this->SetFont('Arial','B',8);
			$this->SetFillColor(223,223,223);
			$this->cell($w[0],5,"Kode MK",1,"","C",1);
			$this->cell($w[1],5,"Matakuliah",1,"","C",1);
			$this->cell($w[2],5,"Kelas",1,"","C",1);
			$this->cell($w[3],5,"Jml Mhs",1,"","C",1);
			$this->cell($w[4],5,"Dosen",1,"","C",1);
			$this->Ln();						
			$MySQL->Select("tblmkupy.NAMKTBLMK,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI,COUNT(trnlmupy.NIMHSTRNLM) AS JMLMHS,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","tbmksajiupy","LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) LEFT OUTER JOIN trnlmupy ON (tbmksajiupy.IDX = trnlmupy.IDXMKSAJI) WHERE tbmksajiupy.KDPSTMKSAJI = '".$row."' AND 
  tbmksajiupy.THSMSMKSAJI = '".$tahun_akademik."' GROUP BY tblmkupy.NAMKTBLMK,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI");
  			$jml_total=0;
			while ($show=$MySQL->fetch_array()){
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);
				$this->cell($w[0],5,$show["KDKMKMKSAJI"],1,"","C",1);
				$this->cell($w[1],5,$show["NAMKTBLMK"],1,"","",1);
				$this->cell($w[2],5,$show["KELASMKSAJI"],1,"","C",1);
				$this->cell($w[3],5,$show["JMLMHS"],1,"","C",1);
				$this->cell($w[4],5,$show["NMDOSMKSAJI"]." - ".$show["NODOSMKSAJI"],1,"","",1);
				$this->Ln();
			}
		}
	}

	function Page2($w,$data){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$i=0;
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			$tahun_akademik=$_POST['tahun_akademik'];
			$this->SetTopMargin(35);
			$this->AddPage();
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255,255,255);
			$this->cell(30,5,"Program Studi");
			$this->cell(160,5,": ".$prodi);
			$this->Ln();			
			$this->cell(30,5,"Tahun akademik");
			$this->cell(160,5,": ".substr($tahun_akademik,0,4)."/".(substr($tahun_akademik,0,4) + 1));
			$this->Ln();			
			$this->cell(30,5,"Semester");
			$this->cell(160,5,": ".LoadSemester_X("",substr($tahun_akademik,4,1)));
			$this->Ln();

			$this->SetFont('Arial','B',8);
			$this->SetFillColor(223,223,223);
			$this->cell($w[0],5,"Dosen",1,"","C",1);
			$this->cell($w[1],5,"Kode MK",1,"","C",1);
			$this->cell($w[2],5,"Matakuliah",1,"","C",1);
			$this->cell($w[3],5,"Kelas",1,"","C",1);
			$this->cell($w[4],5,"Jml Mhs",1,"","C",1);
			$this->Ln();						
			$MySQL->Select("tblmkupy.NAMKTBLMK,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI,COUNT(trnlmupy.NIMHSTRNLM) AS JMLMHS,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","tbmksajiupy","LEFT OUTER JOIN tblmkupy ON (tbmksajiupy.KDKMKMKSAJI = tblmkupy.KDMKTBLMK) LEFT OUTER JOIN trnlmupy ON (tbmksajiupy.IDX = trnlmupy.IDXMKSAJI) WHERE tbmksajiupy.KDPSTMKSAJI = '".$row."' AND 
  tbmksajiupy.THSMSMKSAJI = '".$tahun_akademik."' GROUP BY tblmkupy.NAMKTBLMK,tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI,tbmksajiupy.NMDOSMKSAJI","tbmksajiupy.KDKMKMKSAJI,tbmksajiupy.KELASMKSAJI,tbmksajiupy.NODOSMKSAJI");
  			$jml_total=0;
			while ($show=$MySQL->fetch_array()){
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);
				$this->cell($w[0],5,$show["NMDOSMKSAJI"]." - ".$show["NODOSMKSAJI"],1,"","",1);
				$this->cell($w[1],5,$show["KDKMKMKSAJI"],1,"","C",1);
				$this->cell($w[2],5,$show["NAMKTBLMK"],1,"","",1);
				$this->cell($w[3],5,$show["KELASMKSAJI"],1,"","C",1);
				$this->cell($w[4],5,$show["JMLMHS"],1,"","C",1);
				$this->Ln();
			}
		}
	}

	function Page1($w,$data,$jenis){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$i=0;
		$this->SetTopMargin(30);
		$this->AddPage();
		$dt=1;
		if(count($data) == 0){
			echo '<script type="text/javascript">
				alert(\'Tidak ada mahasiswa yang membayar tanggal tersebut, atau data belum di upload oleh Biro Keuangan!\');
   			       history.go(-1);	
				</script>';
			exit;
		}
		foreach ($data as $row) {
			global $MySQL, $PREFIX;
			$data=@explode(",",$row);
			$tahun_akademik=$_POST['tahun_akademik'];
			$MySQL->Select("trnlmupy.IDXMKSAJI,trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.STAMKTRNLM","trnlmupy","LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK)
WHERE trnlmupy.THSMSTRNLM = '".$tahun_akademik."' AND trnlmupy.NIMHSTRNLM = '".$data[0]."' AND trnlmupy.ISKONTRNLM <> '1'","trnlmupy.KDKMKTRNLM ASC","");
			// AND trnlmupy.STATUTRNLM = '1'
      $jml_mk=$MySQL->num_rows();
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$kode_mk[$i]=$show["KDKMKTRNLM"];
				$nama_mk[$i]=$show["NAMKTBLMK"];
				$status_mk[$i]=$show["STAMKTRNLM"];
				$index_mk[$i]=$show["IDXMKSAJI"];
				$i++;
			}
			
			for ($i=0; $i < $jml_mk;$i++) {
				$MySQL->Select("jwlutsuas.KELASUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,
				jwlutsuas.RUANGUTSUAS,r1.ruangNama AS R1, r2.ruangNama  AS R2,r3.ruangNama AS R3","jwlutsuas",
				"LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
      	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
      	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId 
				WHERE jwlutsuas.IDXMKSAJI ='".$index_mk[$i]."' AND jwlutsuas.JENISUTSUAS = '".$jenis."'","IDX DESC","1");
				$show=$MySQL->fetch_array();
				$mulai[$i]= new Time($show["WKPELUTSUAS"]);
				$durasi[$i]= ($show["DURSIUTSUAS"] * 60);
				$selesai[$i] = $mulai[$i]->Add($durasi[$i]);
				$kelas_mk[$i]=$show["KELASUTSUAS"];
				$hari_mk[$i]=$show["HRPELUTSUAS"];
				$tgl_mk[$i]=DateStr($show["TGPELUTSUAS"]);
				$waktu_mk[$i]=substr($show["WKPELUTSUAS"],0,5)." - ".substr($selesai[$i],0,5);
				$ruang_mk[$i]=$show["R1"];
				if($show["R2"] <> ""){
				    $r2 = explode('.',$show["R2"]);
            $ruang_mk[$i] .= "/".$r2[1];
        }
        
        if($show["R3"] <> ""){
            $r3 = explode('.',$show["R3"]);
            $ruang_mk[$i] .= "/".$r3[1];
        
        }
				
			//	echo $MySQL->qry;
			//	exit;
			}
			
			if (!($dt % 2)) {
				$this->Ln(60);
				$dt=1;
				$this->Line(10,160,201,160);
				if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
					$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,167,16,17);
				$this->SetTextColor(0);
				$this->SetFont('Arial','B',14);
				$this->Text(30,175,$_SESSION[$PREFIX.'NMPTIMSPTI']);
				$this->Ln();
				$this->SetFont('Arial','B',9);
				$this->Text(30,179,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
				$this->SetFont('Arial','B',12);
				$ujian=" TENGAH SEMESTER";
				if ($_POST['report_title'] != "1") $ujian=" AKHIR SEMESTER";				
				$this->Text(67,192,"KARTU UJIAN".$ujian);
				$this->SetLineWidth(0.5);
				$this->Line(10,185,201,185);
				$this->SetLineWidth(0);
				$this->Line(10,186,201,186);
				$this->Rect(10,284,25,25,"");				
			}
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255,255,255);
			$this->cell(30,5,"Program Studi");
			$this->cell(100,5,": ".$data[2]);
			$this->cell(30,5,"Tahun akademik");
			$this->cell(30,5,": ".substr($tahun_akademik,0,4)."/".(substr($tahun_akademik,0,4) + 1));
			$this->Ln();
			$this->cell(30,5,"Nama Mahasiswa");
			$this->cell(100,5,": ".$data[1]);
			$this->cell(30,5,"Semester");
			$this->cell(30,5,": ".LoadSemester_X("",substr($tahun_akademik,4,1)));
			$this->Ln();
			$this->cell(30,5,"NPM");
			$this->cell(160,5,": ".$data[0]);
			$this->Ln();
	
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(223,223,223);
			$this->cell($w[0],5,"No",1,"","C",1);
			$this->cell($w[1],5,"Kode MK",1,"","C",1);
			$this->cell($w[2],5,"Matakuliah",1,"","C",1);
			$this->cell($w[3],5,"Kls",1,"","C",1);
			$this->cell($w[4],5,"B/U/P",1,"","C",1);
			$this->cell($w[5],5,"Hari",1,"","C",1);
			$this->cell($w[6],5,"Tanggal",1,"","C",1);
			$this->cell($w[7],5,"Waktu",1,"","C",1);
			$this->cell($w[8],5,"Ruang",1,"","C",1);
			$this->cell($w[9],5,"Paraf",1,"","C",1);
			$this->Ln();
			$this->SetFont('Arial','',8);
			$this->SetFillColor(255,255,255);
			$no=1;
			for ($i=0;$i < 12;$i++) {
				if ($i >= $jml_mk) {
					$this->cell($w[0],5,$no." ",1,"","C",1);
					$this->cell($w[1],5,"",1,"","C",1);
					$this->cell($w[2],5,"",1,"","",1);
					$this->cell($w[3],5,"",1,"","C",1);
					$this->cell($w[4],5,"",1,"","C",1);
					$this->cell($w[5],5,"",1,"","C",1);
					$this->cell($w[6],5,"",1,"","C",1);
					$this->cell($w[7],5,"",1,"","C",1);
					$this->cell($w[8],5,"",1,"","C",1);
					$this->cell($w[9],5,"",1,"","C",1);
				} else {
					$this->cell($w[0],5,$no." ",1,"","C",1);
					$this->cell($w[1],5,$kode_mk[$i],1,"","C",1);
					$this->cell($w[2],5,$nama_mk[$i],1,"","",1);
					$this->cell($w[3],5,$kelas_mk[$i],1,"","C",1);
					$this->cell($w[4],5,$status_mk[$i],1,"","C",1);
					$this->cell($w[5],5,$hari_mk[$i],1,"","C",1);
					$this->cell($w[6],5,$tgl_mk[$i],1,"","C",1);
					$this->cell($w[7],5,$waktu_mk[$i],1,"","C",1);
					$this->cell($w[8],5,$ruang_mk[$i],1,"","C",1);
					$this->cell($w[9],5,"",1,"","C",1);
				}
				$this->Ln();
				$no++;
			}
			$this->Ln(0.5);
			$width1="7,18,50,7,8,20,20,20,20,20";
			$this->cell(30,5,"","","","",1);
			$this->cell(100,5,"Mahasiswa,","","","",1);
			$this->cell(60,5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".FormatDateTime(time(),2),"","","",1);
			$this->Ln();				
			$this->cell(30,5,"","","","",1);
			$this->cell(100,5,"","","","",1);
			$this->cell(60,5,"Penyelenggara,","","","",1);
			$this->Ln(15);
			$this->cell(30,3,"","","","",1);
			$this->cell(100,3,$data[1],"","","",1);
			$this->cell(60,3,"(                                             )","","","",1);
			$this->Ln();
			$this->cell(30,3,"","","","",1);
			$this->cell(100,3,"NPM .".$data[0],"","","",1);
			$this->cell(60,3,"","","","",1);
			$this->Ln();
			$this->Rect(10,115,25,25,"");
			$dt++;
		}
	}


	function Header(){
		global $PREFIX;
		$report_title = $_POST['report_title'];
		$tahun_akademik=$_POST['tahun_akademik'];
		$semester = substr($tahun_akademik,4,1); 
		$jenis_ujian = $_POST['jenis_ujian'];
		if ($jenis_ujian == '0') {
			$jenis_ujian = "TENGAH SEMESTER ";
		} else {
			$jenis_ujian = "AKHIR SEMESTER ";	
		}
		$jenis_ujian .= LoadSemester_X("",$semester);
		switch ($report_title) {
		case '0' :
			$title ="REKAP KRS (Matakuliah)";
			$x=83;
			break;
		case '1' :
			$title ="KARTU UJIAN TENGAH SEMESTER";
			$x=67;
			break;
		case '2' :
			$title ="REKAP KRS (Dosen)";
			$x=83;
			break;
		case '3' :
			$title ="KARTU UJIAN AKHIR SEMESTER";
			$x=67;
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
		$this->Text($x,27,$title);
		$this->SetLineWidth(0.5);
		$this->Line(10,20,201,20);
		$this->SetLineWidth(0);
		$this->Line(10,21,201,21);	
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
if (isset($_POST['report_title'])){
	$program_studi=$_POST['program_studi'];
	$tglBayar=$_POST['tglBayar'];
	if(($tglBayar == "") AND $report_title== '3'){
		echo '<script type="text/javascript">
		   alert(\'Tanggal pembayaran harus diisi!\');
		   history.go(-1);	
		</script>';
		exit;
	}
	$pdf->SetTextColor(0);
	switch ($report_title) {
		case '0' :
			$title ="REKAP KRS (Matakuliah)";
			$width1="18,75,10,12,75";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page($width1,$data);
			break;
		case '1' :
			global $MySQL;
			$title ="KARTU UJIAN TENGAH SEMESTER";
			$width1="7,18,50,7,8,20,20,20,20,20";
			$width1= @explode(",",$width1);
			$program_studi ="(".$program_studi.")";  
			$jenis='UTS';
			$MySQL->Select("DISTINCT tbkrsupy.NIMHSTBKRS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST","tbkrsupy","LEFT OUTER JOIN msmhsupy ON (tbkrsupy.NIMHSTBKRS = msmhsupy.NIMHSMSMHS) LEFT OUTER JOIN mspstupy ON (tbkrsupy.KDPSTTBKRS = mspstupy.IDPSTMSPST) WHERE tbkrsupy.THSMSTBKRS = '".$_POST['tahun_akademik']."' AND tbkrsupy.KDPSTTBKRS IN $program_studi",""); // AND tbkrsupy.DIACCTBKRS = '1'
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$mahasiswa[$i]=$show["NIMHSTBKRS"].",".$show["NMMHSMSMHS"].",".$show["NMPSTMSPST"];
				$i++;
			}
			$pdf->Page1($width1,$mahasiswa,$jenis);
			break;
		case '2' :
			$title ="REKAP KRS (Dosen)";
			$width1="75,18,75,10,12";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page2($width1,$data);
			break;
		case '3' :
			global $MySQL;
			$jenis='UAS';
			$title ="KARTU UJIAN AKHIR SEMESTER";
			$width1="7,18,50,7,8,15,20,20,25,20";
			$width1= @explode(",",$width1);
			$program_studi ="(".$program_studi.")";
			$MySQL->Select("DISTINCT tbkrsupy.NIMHSTBKRS,msmhsupy.NMMHSMSMHS,mspstupy.NMPSTMSPST","tbkrsupy",
      "LEFT OUTER JOIN msmhsupy ON (tbkrsupy.NIMHSTBKRS = msmhsupy.NIMHSMSMHS) 
      LEFT OUTER JOIN mspstupy ON (tbkrsupy.KDPSTTBKRS = mspstupy.IDPSTMSPST) 
      LEFT JOIN pembayaran ON bayarNim = CAST(NIMHSTBKRS AS DECIMAL(15,0))
      WHERE tbkrsupy.THSMSTBKRS = '".$_POST['tahun_akademik']."' AND tbkrsupy.KDPSTTBKRS IN $program_studi 
      AND bayarTanggal = '$tglBayar'","msmhsupy.NIMHSMSMHS,bayarTanggal "); //AND tbkrsupy.DIACCTBKRS = '1'
      //echo $MySQL->qry;
      $i=0;
			while ($show=$MySQL->fetch_array()) {
				$mahasiswa[$i]=$show["NIMHSTBKRS"].",".$show["NMMHSMSMHS"].",".$show["NMPSTMSPST"];
				$i++;
			}
			$pdf->Page1($width1,$mahasiswa,$jenis);
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