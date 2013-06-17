<?php
include "include/config.php";
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	//exit;
}

//jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND 	
//AND jwlutsuas.JENISUTSUAS = '".$_POST['jenis_ujian']."' 
require('include/fpdf/fpdf.php');
class PDF extends FPDF{
	//Colored table
	function Page($w,$data){
		global $MySQL, $PREFIX;
		$tahun_akademik=$_POST['tahun_akademik'];
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		$i=0;
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			if(!isset($_POST['tahun_akademik'])){
          $tahun_akademik=$_GET['smt'];    
      }else{
          $tahun_akademik=$_POST['tahun_akademik'];
      }
			$this->SetTopMargin(30);
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
			$this->cell($w[0],4,"No","LTR","","C",1);
			$this->cell($w[1],4,"Sem","LTR","","C",1);
			$this->cell($w[2],4,"NPM","LTR","","C",1);
			$this->cell($w[3],4,"Nama Mahasiswa","LTR","","C",1);
			$this->cell($w[4],4,"Jumlah","LTR","","C",1);
			$this->cell($w[5],4,"SKS","LTR","","C",1);
			$this->cell($w[6],4,"SKS","LTR","","C",1);
			$this->cell($w[7],4,"IP","LTR","","C",1);
			$this->cell($w[8],4,"IP","LTR","","C",1);
			$this->cell($w[9],4,"Max SKS","LTR","","C",1);
			$this->Ln();
			$this->cell($w[0],3,"","LRB","","C",1);
			$this->cell($w[1],3,"","LRB","","C",1);
			$this->cell($w[2],3,"","LRB","","C",1);
			$this->cell($w[3],3,"","LRB","","C",1);
			$this->cell($w[4],3,"MK","LRB","","C",1);
			$this->cell($w[5],3,"Sem","LRB","","C",1);
			$this->cell($w[6],3,"Kum","LRB","","C",1);
			$this->cell($w[7],3,"Sem","LRB","","C",1);
			$this->cell($w[8],3,"Kum","LRB","","C",1);
			$this->cell($w[9],3,"Diambil","LRB","","C",1);
			$this->Ln();
			
			/*
      $qry ="LEFT OUTER JOIN msmhsupy ON (trakmupy.NIMHSTRAKM = msmhsupy.NIMHSMSMHS)";
			$qry .=" LEFT OUTER JOIN trnlmupy ON (trakmupy.NIMHSTRAKM = trnlmupy.NIMHSTRNLM)";
			$qry .=" WHERE trakmupy.THSMSTRAKM = trnlmupy.THSMSTRNLM 
        AND trakmupy.THSMSTRAKM = '".$tahun_akademik."' 
        
	 AND msmhsupy.KDPSTMSMHS ='".$row."'
        AND msmhsupy.TAHUNMSMHS = ".$_SESSION['angkatan']." 
        GROUP BY trakmupy.NIMHSTRAKM,trakmupy.SKSEMTRAKM,trakmupy.SKSTTTRAKM,trakmupy.NLIPSTRAKM,
          trakmupy.NLIPKTRAKM,trakmupy.MAKRSTRAKM,msmhsupy.NMMHSMSMHS,msmhsupy.TAHUNMSMHS";  // AND trnlmupy.STATUTRNLM = '1' 
          
      
      $MySQL->Select("trakmupy.NIMHSTRAKM,trakmupy.SKSEMTRAKM,trakmupy.SKSTTTRAKM,trakmupy.NLIPSTRAKM,
        trakmupy.NLIPKTRAKM,trakmupy.MAKRSTRAKM,msmhsupy.NMMHSMSMHS,COUNT(trnlmupy.KDKMKTRNLM) AS JMLMK,
        msmhsupy.TAHUNMSMHS",
        "trakmupy",$qry,
        "msmhsupy.KDPSTMSMHS,msmhsupy.NIMHSMSMHS","");	
        
          
			*/
      
			$MySQL->Select("NIM, NAMA, ANGKATAN, SMTAWAL,
        COUNT(*) AS JML_MK,
        SUM(SKSMKTRNLM) AS JML_SKS, 
        (SUM(MUTU) / SUM(SKSMKTRNLM)) AS IP",
        "(SELECT NIMHSTRNLM AS NIM,
            SMAWLMSMHS AS SMTAWAL, 
            NMMHSMSMHS AS NAMA,
            TAHUNMSMHS AS ANGKATAN,
            trnlmupy.SKSMKTRNLM,
            IFNULL(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM,0) AS MUTU
            FROM
            trnlmupy 
            LEFT JOIN msmhsupy ON NIMHSTRNLM = NIMHSMSMHS      
                  WHERE trnlmupy.ISKONTRNLM <> '1' 
                  AND trnlmupy.THSMSTRNLM = '".$tahun_akademik."'
                  AND msmhsupy.TAHUNMSMHS = ".$_SESSION['angkatan']."
                  AND msmhsupy.KDPSTMSMHS ='".$row."' 
                  AND BOBOTTRNLM IS NOT NULL
            GROUP BY NIM, KDKMKTRNLM) AS nilai
        GROUP BY NIM");                    
	
			$no=1;
			$i=1;
			while ($show=$MySQL->Fetch_Array()){
				$semester_mhs= (((substr($tahun_akademik,0,4) - substr($show["SMTAWAL"],0,4)) * 2) + ((substr($tahun_akademik,4,1) - substr($show["SMTAWAL"],4,1)) + 1));
				if (!($i % 51)) {
					$this->SetTopMargin(30);
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
					$this->cell($w[0],4,"No","LTR","","C",1);
					$this->cell($w[1],4,"Sem","LTR","","C",1);
					$this->cell($w[2],4,"NPM","LTR","","C",1);
					$this->cell($w[3],4,"Nama Mahasiswa","LTR","","C",1);
					$this->cell($w[4],4,"Jumlah","LTR","","C",1);
					$this->cell($w[5],4,"SKS","LTR","","C",1);
					$this->cell($w[6],4,"SKS","LTR","","C",1);
					$this->cell($w[7],4,"IP","LTR","","C",1);
					$this->cell($w[8],4,"IP","LTR","","C",1);
					$this->cell($w[9],4,"Max SKS","LTR","","C",1);
					$this->Ln();
					$this->cell($w[0],3,"","LRB","","C",1);
					$this->cell($w[1],3,"","LRB","","C",1);
					$this->cell($w[2],3,"","LRB","","C",1);
					$this->cell($w[3],3,"","LRB","","C",1);
					$this->cell($w[4],3,"MK","LRB","","C",1);
					$this->cell($w[5],3,"Sem","LRB","","C",1);
					$this->cell($w[6],3,"Kum","LRB","","C",1);
					$this->cell($w[7],3,"Sem","LRB","","C",1);
					$this->cell($w[8],3,"Kum","LRB","","C",1);
					$this->cell($w[9],3,"Diambil","LRB","","C",1);
					$this->Ln();
					$i=1;
				}
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);
				$this->cell($w[0],5,$no." ",1,"","R",1);
				$this->cell($w[1],5,$semester_mhs,1,"","C",1);
				$this->cell($w[2],5,$show["NIM"],1,"","",1);
				$this->cell($w[3],5,$show["NAMA"],1,"","",1);
				$this->cell($w[4],5,$show["JML_MK"],1,"","C",1);
				$this->cell($w[5],5,$show["JML_SKS"],1,"","C",1);
				$this->cell($w[6],5,$show["SKSTTTRAKM"],1,"","C",1);
				$this->cell($w[7],5,substr($show["IP"],0,4),1,"","C",1);
				$this->cell($w[8],5,$show["NLIPKTRAKM"],1,"","C",1);
				$this->cell($w[9],5,$show["MAKRSTRAKM"],1,"","C",1);
				$this->Ln();
				$no++;
				$i++;
			}
		}
	}

	function Page1($w,$data){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		foreach ($data as $row) {
			global $MySQL, $PREFIX;
			$data=@explode(",",$row);
			if(!isset($_POST['tahun_akademik'])){
          $tahun_akademik=$_GET['smt'];    
      }else{
          $tahun_akademik=$_POST['tahun_akademik'];
      }
			
			$nim_mhs=$data[0];
			$nama_mhs=$data[1];
			$pst_mhs=$data[2];
			$sem_mhs= ((substr($tahun_akademik,0,4) - $data[3]) * 2) + substr($tahun_akademik,4,1);
			$dsn_pa=$data[4];
			$MySQL->Select("trnlmupy.KDKMKTRNLM,tblmkupy.NAMKTBLMK,trnlmupy.KELASTRNLM,
      trnlmupy.SEMESTRNLM,trnlmupy.STAMKTRNLM,trnlmupy.NLAKHTRNLM,trnlmupy.SKSMKTRNLM,
	trnlmupy.BOBOTTRNLM,
      IFNULL(trnlmupy.SKSMKTRNLM * trnlmupy.BOBOTTRNLM,0) AS MUTU",
      "trnlmupy",
      "LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
      WHERE trnlmupy.ISKONTRNLM <> '1' 
      AND trnlmupy.THSMSTRNLM = '".$tahun_akademik."' 
      AND trnlmupy.NIMHSTRNLM = '".$data[0]."'",
      "trnlmupy.KDKMKTRNLM ASC","");
			$i=0;
			$rowCount = $MySQL->num_rows();						
			// untuk nyimpen value
			$jmlMutu = 0;
			$jmlSKS = 0;
			while ($show=$MySQL->fetch_array()) {
				$kd_mk[$i]=$show["KDKMKTRNLM"];
				$nm_mk[$i]=$show["NAMKTBLMK"];
				$kl_mk[$i]=$show["KELASTRNLM"];
				$sm_mk[$i]=$show["SEMESTRNLM"];
				$st_mk[$i]=$show["STAMKTRNLM"];
				$nl_mk[$i]=$show["NLAKHTRNLM"];
				$sk_mk[$i]=$show["SKSMKTRNLM"];
				$bb_mk[$i]=$show["BOBOTTRNLM"];
				$mt_mk[$i]=$show["MUTU"];
				
				if($show["BOBOTTRNLM"] <> null){
				   $jmlMutu = $jmlMutu + $show["MUTU"];
				   $jmlSKS = $jmlSKS + $show["SKSMKTRNLM"];
				}
				$i++;				
			}
			
			$ipsem_mhs = substr(($jmlMutu / $jmlSKS), 0, 4); 
			
			$sks_total=0;
			$bbt_total=0;
			$mutu_total=0;                               
      
      // Select(entity, table, condition)
      $MySQL->Select("SUM(SKS) AS JML_SKS,
      SUM(MUTU) AS JML_MUTU"," 
      (SELECT  trnlmupy.SKSMKTRNLM AS SKS,                  
      IFNULL((trnlmupy.SKSMKTRNLM * MAX(trnlmupy.BOBOTTRNLM)),0) AS MUTU
      FROM trnlmupy 
      LEFT OUTER JOIN tblmkupy ON (trnlmupy.KDKMKTRNLM = tblmkupy.KDMKTBLMK) 
      WHERE
      trnlmupy.NIMHSTRNLM ='$nim_mhs'
      AND BOBOTTRNLM IS NOT NULL         
      GROUP BY trnlmupy.KDKMKTRNLM
      ORDER BY trnlmupy.IDX) AS nilai");      // trnlmupy.STATUTRNLM = '1'  
      
      while($show=$MySQL->fetch_array()){          
            $skstt_mhs = $show["JML_SKS"];            
            $ipkum_mhs = round(($show["JML_MUTU"] / $show["JML_SKS"]),2);            
      }
      
      $makrs_mhs=$show["MAKRSTRAKM"];
      //===============================================
			
      /*
      $MySQL->Select("NLIPSTRAKM,NLIPKTRAKM,SKSTTTRAKM,MAKRSTRAKM","trakmupy","WHERE THSMSTRAKM = '".$tahun_akademik."' AND NIMHSTRAKM = '".$nim_mhs."'");
			if ($MySQL->num_rows() > 0) {
				$show=$MySQL->fetch_array();
				//$ipsem_mhs=$show["NLIPSTRAKM"];
				//$ipkum_mhs=$show["NLIPKTRAKM"];
				//$skstt_mhs=$show["SKSTTTRAKM"];
				
			}
			*/

			$this->SetTopMargin(30);
			$this->AddPage();
			      
			for ($j=0;$j < 2;$j++) {
				if ($j==1) {
					$this->Ln(50);
					$this->Line(10,165,201,165);
					if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
						$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,172,16,17);
					$this->SetTextColor(0);
					$this->SetFont('Arial','B',14);
					$this->Text(30,180,$_SESSION[$PREFIX.'NMPTIMSPTI']);
					$this->Ln();
					$this->SetFont('Arial','B',9);
					$this->Text(30,184,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
					$this->SetFont('Arial','B',12);
					$this->Text(85,197,"KARTU HASIL STUDI".$ujian);
					$this->SetLineWidth(0.5);
					$this->Line(10,190,201,190);
					$this->SetLineWidth(0);
					$this->Line(10,191,201,191);
				}
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);
				$this->cell(30,5,"Program Studi","","","",1);
				$this->cell(100,5,": ".$data[2],"","","",1);
				$this->cell(30,5,"Tahun Akademik","","","",1);
				$this->cell(30,5,": ".substr($tahun_akademik,0,4)."/".((substr($tahun_akademik,0,4) + 1)),"","","",1);
				$this->Ln();
				$this->cell(30,5,"Nama Mhs","","","",1);
				$this->cell(100,5,": ".$data[1],"","","",1);
				$this->cell(30,5,"Semester","","","",1);
				$this->cell(30,5,": ".$sem_mhs,"","","",1);
				$this->Ln();
				$this->cell(30,5,"NPM","","","",1);
				$this->cell(100,5,": ".$data[0],"","","",1);
				$this->cell(30,5,"","","","",1);
				$this->cell(30,5,"","","","",1);
				$this->Ln(5);
				$this->SetFont('Arial','B',8);
				$this->SetFillColor(223,223,223);
				$this->cell($w[0],5,"No",1,"","C",1);
				$this->cell($w[1],5,"Kode MK",1,"","C",1);
				$this->cell($w[2],5,"Matakuliah",1,"","C",1);
				$this->cell($w[3],5,"Kelas",1,"","C",1);
				$this->cell($w[4],5,"Sem",1,"","C",1);
				$this->cell($w[5],5,"B/U/P",1,"","C",1);
				$this->cell($w[6],5,"Nilai",1,"","C",1);
				$this->cell($w[7],5,"SKS",1,"","C",1);
				$this->cell($w[8],5,"Bobot",1,"","C",1);
				$this->cell($w[9],5,"Mutu",1,"","C",1);
				$this->Ln();
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);
				$no=1;
				$sks_total=0;
				$bbt_total=0;
				$mutu_total=0;
				
				// error sebelumnya (ada matakuliah yg tidak diambil tapi tersimpan karena sebelumnya masih di hard code )				
        for ($i=0;$i < $rowCount;$i++) {
    					$this->cell($w[0],5,$no." ",1,"","R",1);
    					$this->cell($w[1],5,$kd_mk[$i],1,"","",1);
    					$this->cell($w[2],5,$nm_mk[$i],1,"","",1);
    					$this->cell($w[3],5,$kl_mk[$i],1,"","C",1);
    					$this->cell($w[4],5,$sm_mk[$i],1,"","C",1);
    					$this->cell($w[5],5,$st_mk[$i],1,"","C",1);
    					$this->cell($w[6],5,$nl_mk[$i],1,"","C",1);
    					$this->cell($w[7],5,$sk_mk[$i],1,"","C",1);
    					$this->cell($w[8],5,$bb_mk[$i],1,"","R",1);
    					$this->cell($w[9],5,$mt_mk[$i],1,"","R",1);
    					$this->Ln();
    					$sks_total=$sks_total + $sk_mk[$i];
    					$bbt_total=$bbt_total + $bb_mk[$i];
    					$mutu_total=$mutu_total + $mt_mk[$i];
    					$no++;
    		}
        
        // menulis yang kosong, sampe tiap KHS ada 12 baris, agar formatnya ga berubah
        if($rowCount <12){
            for(($x=$rowCount+1);$x < 13;$x++){
              $this->cell($w[0],5,$x." ",1,"","R",1);
    					$this->cell($w[1],5,"-",1,"","",1);
    					$this->cell($w[2],5,"-",1,"","",1);
    					$this->cell($w[3],5,"-",1,"","C",1);
    					$this->cell($w[4],5,"-",1,"","C",1);
    					$this->cell($w[5],5,"-",1,"","C",1);
    					$this->cell($w[6],5,"-",1,"","C",1);
    					$this->cell($w[7],5,"-",1,"","C",1);
    					$this->cell($w[8],5,"-",1,"","R",1);
    					$this->cell($w[9],5,"-",1,"","R",1);
    					$this->Ln();                  
            
            }
        
        }    
        
        if($ipsem_mhs >= 3){
            $makrs_mhs = 24;
        }else if(($ipsem_mhs > 2.49) and ($ipsem_mhs <= 3)){
            $makrs_mhs = 21;
        }else if(($ipsem_mhs > 2) and ($ipsem_mhs <= 2.49)){
            $makrs_mhs = 18;
        }else if(($ipsem_mhs > 1.49) and ($ipsem_mhs <= 2)){
            $makrs_mhs = 15;
        }else if(($ipsem_mhs > 1) and ($ipsem_mhs <= 1.49)){
            $makrs_mhs = 12;
        }else if(($ipsem_mhs <= 1)){
            $makrs_mhs = 0;
        }
				
				$this->SetFont('Arial','B',8);
				$this->cell(156,5,"Total SKS",1,"","C",1);
				$this->cell(12,5,$sks_total,1,"","C",1);
				$this->cell(12,5,$bbt_total,1,"","C",1);
				$this->cell(12,5,$mutu_total,1,"","C",1);
				$this->Ln();
				$this->SetFont('Arial','I',8);
				$this->cell(192,5,"Keterangan B/U/P : B = Baru, U = Ulang (Pernah menempuh dgn Nilai E atau D), P = Perbaikan (Pernah menempuh dgn Nilai C atau B)","T","","",1);
				$this->Ln();
				$this->SetFont('Arial','',8);
				$this->cell(50,5,"IP Semester","","","",1);
				$this->cell(70,5,": ".$ipsem_mhs,"","","",1);
				$this->cell(72,5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".FormatDateTime(time(),2),"","","",1);
				$this->Ln();
				$this->cell(50,5,"IP Kumulatif","","","",1);
				$this->cell(70,5,": ".$ipkum_mhs,"","","",1);
				$this->cell(72,5,"Dosen Pembimbing Akademik","","","",1);
				$this->Ln();
				$this->cell(50,5,"SKS Kumulatif","","","",1);
				$this->cell(142,5,": ".$skstt_mhs,"","","",1);
				$this->Ln();
				$this->cell(50,5,"Jml. max. SKS yang dapat ditempuh","","","",1);
				$this->cell(142,5,": ".$makrs_mhs,"","","",1);
				$this->Ln();
				$this->cell(120,5,"","","","",1);
				$this->cell(72,5,LoadDosen_X("",$dsn_pa),"","","",1);
				$this->Ln();			
				$this->cell(120,4,"","","","",1);
				$this->cell(72,4,"NIDN : ".$dsn_pa,"","","",1);
				$this->Ln();
			}
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
			$title ="REKAP HASIL STUDI";
			$x=88;
			break;
		case '1' :
			$title ="KARTU HASIL STUDI";
			$x=85;
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
if ((isset($_POST['report_title'])) or (isset($_GET['report_title']))){
  if(isset($_GET['report_title'])){
      $report_title = $_GET['report_title'];
  } 
	$program_studi=$_POST['program_studi'];
	
	if(!isset($_SESSION['angkatan'])){
      $angkatan = 2007;
      $_SESSION['angkatan'] = 2007;
  }else{
      $angkatan = $_SESSION['angkatan'];
  }
	
	
	$pdf->SetTextColor(0);
	switch ($report_title) {
		case '0' :
			$title ="REKAP HASIL STUDI";
			$width1="10,10,20,77,12,12,12,12,12,15";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page($width1,$data);
			break;
		case '1' :
			global $MySQL;
			$title ="KARTU HASIL STUDI";
			$width1="8,25,75,12,12,12,12,12,12,12";
			$width1= @explode(",",$width1);
			$program_studi ="(".$program_studi.")";
			$tahun_akademik=$_POST['tahun_akademik'];
			
			$nim = ""; 
			if(isset($_GET['report_title'])){
          $tahun_akademik = $_GET['smt'];
          $program_studi = "(".$_GET['ps'].")";
          $nim = $_GET['nim'];
      }      
      $addQuery = "";
      if($nim <> ""){
          $addQuery = " AND tbkrsupy.NIMHSTBKRS = '$nim'";  
      }
			$MySQL->Select("tbkrsupy.NIMHSTBKRS,msmhsupy.NMMHSMSMHS,msmhsupy.TAHUNMSMHS,
          msmhsupy.DSNPAMSMHS,mspstupy.NMPSTMSPST","tbkrsupy","
          LEFT OUTER JOIN msmhsupy ON (tbkrsupy.NIMHSTBKRS = msmhsupy.NIMHSMSMHS) 
          LEFT OUTER JOIN mspstupy ON (tbkrsupy.KDPSTTBKRS = mspstupy.IDPSTMSPST) 
          WHERE tbkrsupy.KDPSTTBKRS IN $program_studi
          AND msmhsupy.TAHUNMSMHS = '$angkatan'   
          AND tbkrsupy.THSMSTBKRS = '".$tahun_akademik."' 
          
	   $addQuery","tbkrsupy.NIMHSTBKRS"); //AND tbkrsupy.DIACCTBKRS = '1' 
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$mahasiswa[$i]=$show["NIMHSTBKRS"].",".$show["NMMHSMSMHS"].",".$show["NMPSTMSPST"].",".$show["TAHUNMSMHS"].",".$show["DSNPAMSMHS"];
				$i++;
			}
//echo $MySQL->qry."<br><br>";
			$pdf->Page1($width1,$mahasiswa);
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