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
	function Page($w,$data,$jenis){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
//		$row=count($data);
		$i=0;
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			$MySQL->Select("jwlutsuas.IDXMKSAJI,jwlutsuas.KDKMKUTSUAS, jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3, jwlutsuas.KELASUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.RUANGUTSUAS,jwlutsuas.RUANG2,jwlutsuas.RUANG3,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.NODOSUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS",
			"jwlutsuas","LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) 
			LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
    	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
    	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId 
			WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."'","jwlutsuas.KDKMKUTSUAS");
			$jml=$MySQL->num_rows();
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$id_mk[$i]=$show["IDXMKSAJI"];
				$kode_mk[$i]=$show["KDKMKUTSUAS"];
				$nama_mk[$i]=$show["NAMKTBLMK"];
				$kelas_mk[$i]=$show["KELASUTSUAS"];
				$ruang_mk[$i]=$show["R1"];
				if($show["R2"] <> ""){
				    $r2 = explode('.',$show["R2"]);
            $ruang_mk[$i] .= "/".$r2[1];
        }
        
        if($show["R3"] <> ""){
            $r3 = explode('.',$show["R3"]);
            $ruang_mk[$i] .= "/".$r3[1];
        
        }
				
				$hari_mk[$i]=$show["HRPELUTSUAS"];
				$tgl_mk[$i]=DateStr($show["TGPELUTSUAS"]);
				$jam_mk[$i]=$show["WKPELUTSUAS"];
				$durasi_mk[$i]=($show["DURSIUTSUAS"] * 60);
				$dosen_mk[$i]=$show["NODOSUTSUAS"];
				$pengawas1_mk[$i]=$show["PENG1UTSUAS"];
				$pengawas2_mk[$i]=$show["PENG2UTSUAS"];
				$pengawas3_mk[$i]=$show["PENG3UTSUAS"];
				$pengawas4_mk[$i]=$show["PENG4UTSUAS"];
				$mulai_mk[$i]= new Time($jam_mk[$i]);
				$selesai_mk[$i]=$mulai_mk[$i]->add($durasi_mk[$i]);
				$waktu_mk[$i]= substr($jam_mk[$i],0,5)." - ".substr($selesai_mk[$i],0,5);
				$i++;
			}
			
			$mk=$id_mk;
			$i=0;
			foreach ($mk as $matakuliah) {
				$MySQL->Select("trnlmupy.NIMHSTRNLM,msmhsupy.NMMHSMSMHS,trnlmupy.STAMKTRNLM","trnlmupy","LEFT OUTER JOIN msmhsupy ON (trnlmupy.NIMHSTRNLM = msmhsupy.NIMHSMSMHS) WHERE trnlmupy.THSMSTRNLM='".$_POST['tahun_akademik']."' AND trnlmupy.IDXMKSAJI = '".$matakuliah."'","trnlmupy.NIMHSTRNLM"); // AND STATUTRNLM='1'
				$jml_mhs[$i]=$MySQL->num_rows();
				$j=0;
				while ($show=$MySQL->fetch_array()) {
					$detail[$i][$j]=$show['NIMHSTRNLM'].",".$show['NMMHSMSMHS'].",".$show['STAMKTRNLM'];
					$j++;
				}
				$i++;
			} 
			for ($i=0; $i < $jml;$i++) {	
				$this->SetTopMargin(35);
				$this->AddPage();
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);			
				$this->Cell(30,5,"Program Studi");
				$this->Cell(100,5,": ".$prodi);
				$this->Cell(25,5,"Kelas");
				$this->Cell(35,5,": ".$kelas_mk[$i]);
				$this->Ln();
				$this->Cell(30,5,"Matakuliah");
				$this->Cell(100,5,": ".$nama_mk[$i]);
				$this->Cell(25,5,"Ruang");
				$this->Cell(35,5,": ".$ruang_mk[$i]);
				$this->Ln();
				$this->Cell(30,5,"Kode MK");
				$this->Cell(100,5,": ".$kode_mk[$i]);
				$this->Cell(25,5,"Hari/Tanggal");
				$this->Cell(35,5,": ".$hari_mk[$i].", ".$tgl_mk[$i]);
				$this->Ln();
				$this->Cell(30,5,"Dosen");
				$this->Cell(100,5,": ".LoadDosen_X("",$dosen_mk[$i]));
				$this->Cell(25,5,"Waktu");
				$this->Cell(35,5,": ".$waktu_mk[$i]);
				$this->Ln(5);
				$this->SetFont('Arial','B',8);
				$this->SetFillColor(223,223,223);			
				$this->Cell($w[0],5,"No",1,"","C",1);
				$this->Cell($w[1],5,"NPM",1,"","C",1);
				$this->Cell($w[2],5,"Nama Mahasiswa",1,"","",1);
				$this->Cell($w[3],5,"B/U/P",1,"","C",1);
				$this->Cell($w[4],5,"Tanda Tangan",1,"","C",1);
				$this->Cell($w[5],5,"Nilai",1,"","C",1);
				$this->Ln();
				$no=1;
				for ($j=0; $j < $jml_mhs[$i];$j++) {
					if ($no==26) {
						$this->SetTopMargin(35);
						$this->AddPage();
						$this->SetFont('Arial','',8);
						$this->SetFillColor(255,255,255);			
						$this->Cell(30,5,"Program Studi");
						$this->Cell(100,5,": ".$prodi);
						$this->Cell(25,5,"Kelas");
						$this->Cell(35,5,": ".$kelas_mk[$i]);
						$this->Ln();
						$this->Cell(30,5,"Matakuliah");
						$this->Cell(100,5,": ".$nama_mk[$i]);
						$this->Cell(25,5,"Ruang");
						$this->Cell(35,5,": ".$ruang_mk[$i]);
						$this->Ln();
						$this->Cell(30,5,"Kode MK");
						$this->Cell(100,5,": ".$kode_mk[$i]);
						$this->Cell(25,5,"Hari/Tanggal");
						$this->Cell(35,5,": ".$hari_mk[$i].", ".$tgl_mk[$i]);
						$this->Ln();
						$this->Cell(30,5,"Dosen");
						$this->Cell(100,5,": ".LoadDosen_X("",$dosen_mk[$i]));
						$this->Cell(25,5,"Waktu");
						$this->Cell(35,5,": ".$waktu_mk[$i]);
						$this->Ln(5);
						$this->SetFont('Arial','B',8);
						$this->SetFillColor(223,223,223);			
						$this->Cell($w[0],5,"No",1,"","C",1);
						$this->Cell($w[1],5,"NPM",1,"","C",1);
						$this->Cell($w[2],5,"Nama Mahasiswa",1,"","",1);
						$this->Cell($w[3],5,"B/U/P",1,"","C",1);
						$this->Cell($w[4],5,"Tanda Tangan",1,"","C",1);
						$this->Cell($w[5],5,"Nilai",1,"","C",1);
						$this->Ln();		
					}
					$mahasiswa=$detail[$i][$j];
					$mahasiswa=@explode(",",$mahasiswa);
					$np_mhs=$mahasiswa[0];
					$nm_mhs=$mahasiswa[1];
					$st_mhs=$mahasiswa[2];					
					$this->SetFont('Arial','',8);
					$this->SetFillColor(255,255,255);			
					$this->Cell($w[0],8,$no." ",1,"","R",1);
					$this->Cell($w[1],8,$np_mhs,1,"","",1);
					$this->Cell($w[2],8,$nm_mhs,1,"","",1);
					$this->Cell($w[3],8,$st_mhs,1,"","C",1);
					$this->Cell($w[4],8,"",1,"","C",1);
					$this->Cell($w[5],8,"",1,"","C",1);
					$this->Ln();
					$no++;
				}
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);
				$this->Cell(130,7,"Pengawas");
				$this->Cell(60,7,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".$tgl_mk[$i]);
				$this->Ln();
				$this->Cell(70,7,"1. ".LoadPegawai_X("",$pengawas1_mk[$i]));
				$this->Cell(60,7,"( _________________________ )");
				$this->Cell(60,7,"");
				$this->Ln();
				
				$this->Cell(70,7,"2. ".LoadPegawai_X("",$pengawas2_mk[$i]));
				$this->Cell(60,7,"( _________________________ )");
				$this->Cell(60,7,"");
				$this->Ln();
				$this->Cell(70,7,"3. ".LoadPegawai_X("",$pengawas3_mk[$i]));
				$this->Cell(60,7,"( _________________________ )");
				$this->Cell(60,7,"");
				$this->Ln();
				$this->Cell(70,7,"4. ".LoadPegawai_X("",$pengawas4_mk[$i]));
				$this->Cell(60,7,"( _________________________ )");
				$this->Cell(60,7,LoadDosen_X("",$dosen_mk[$i]));				
			}
		}
	}

	function Page1($w,$data,$jenis,$title){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			$MySQL->Select("jwlutsuas.IDXMKSAJI,jwlutsuas.KDKMKUTSUAS, jwlutsuas.KELASUTSUAS,tblmkupy.NAMKTBLMK,
      jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3,
      jwlutsuas.RUANG2,jwlutsuas.RUANG3,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.NODOSUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS",
			"jwlutsuas","LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) 
			LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
    	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
    	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId 
			WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."'","jwlutsuas.KDKMKUTSUAS");
			$jml=$MySQL->num_rows();
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$id_mk[$i]=$show["IDXMKSAJI"];
				$kode_mk[$i]=$show["KDKMKUTSUAS"];
				$nama_mk[$i]=$show["NAMKTBLMK"];
				$kelas_mk[$i]=$show["KELASUTSUAS"];
				$ruang_mk[$i]=$show["R1"];
				if($show["R2"] <> ""){
				    $r2 = explode('.',$show["R2"]);
            $ruang_mk[$i] .= "/".$r2[1];
        }
        
        if($show["R3"] <> ""){
            $r3 = explode('.',$show["R3"]);
            $ruang_mk[$i] .= "/".$r3[1];
        
        }
        
				$hari_mk[$i]=$show["HRPELUTSUAS"];
				$tgl_mk[$i]=DateStr($show["TGPELUTSUAS"]);
				$jam_mk[$i]=$show["WKPELUTSUAS"];
				$durasi_mk[$i]=($show["DURSIUTSUAS"] * 60);
				$dosen_mk[$i]=$show["NODOSUTSUAS"];
				$pengawas1_mk[$i]=$show["PENG1UTSUAS"];
				$pengawas2_mk[$i]=$show["PENG2UTSUAS"];
				$pengawas3_mk[$i]=$show["PENG3UTSUAS"];
				$pengawas4_mk[$i]=$show["PENG4UTSUAS"];
				$mulai_mk[$i]= new Time($jam_mk[$i]);
				$selesai_mk[$i]=$mulai_mk[$i]->add($durasi_mk[$i]);
				$waktu_mk[$i]= substr($jam_mk[$i],0,5)." - ".substr($selesai_mk[$i],0,5);
				$i++;
			}

			for ($j=0; $j < $jml;$j++) {	
				$this->SetTopMargin(42);
				$this->AddPage();
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);			
				$this->Cell($w[0],5,"Program Studi");
				$this->Cell($w[1],5,": ".$prodi);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Matakuliah");
				$this->Cell($w[1],5,": ".$nama_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Kode MK");
				$this->Cell($w[1],5,": ".$kode_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Kelas");
				$this->Cell($w[1],5,": ".$kelas_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Dosen Penguji");
				$this->Cell($w[1],5,": ".LoadDosen_X("",$dosen_mk[$j]));
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Sifat Ujian");
				$this->Cell($w[1],5,": ");
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"");
				$this->Cell($w[2],5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", __________________________");
				$this->Ln();
				$this->Cell($w[0],5,"Hari");
				$this->Cell($w[1],5,": ".$hari_mk[$j]);
				$this->Cell($w[2],5,"Penyelenggara,");
				$this->Ln();
				$this->Cell($w[0],5,"Tanggal");
				$this->Cell($w[1],5,": ".$tgl_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Waktu");
				$this->Cell($w[1],5,": ".$waktu_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Tempat");
				$this->Cell($w[1],5,": ".$ruang_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Jml Naskah Pekerjaan");
				$this->Cell($w[1],5,":  __________ ( ____________________________________ )");
				$this->Cell($w[2],5,"( ____________________________________ )");
				$this->Ln(105);
				$this->SetLineWidth(0);
				$this->Line(10,152,201,152);
				if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
					$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,162,16,17);
				$this->SetTextColor(0);
				$this->SetFont('Arial','B',14);
				$this->Text(30,170,$_SESSION[$PREFIX.'NMPTIMSPTI']);
				$this->Ln();
				$this->SetFont('Arial','B',9);
				$this->Text(30,174,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
				$this->SetFont('Arial','B',12);
				$this->Text(47,187,$title);
				$this->SetFont('Arial','B',10);
				$this->Text(83,192,"TAHUN AKADEMIK ".substr($_POST['tahun_akademik'],0,4)."/".(substr($_POST['tahun_akademik'],0,4) + 1));
				$this->SetLineWidth(0.5);
				$this->Line(10,180,201,180);
				$this->SetLineWidth(0);
				$this->Line(10,181,201,181);
				$this->SetFont('Arial','',8);
				$this->Cell($w[0],5,"Program Studi");
				$this->Cell($w[1],5,": ".$prodi);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Matakuliah");
				$this->Cell($w[1],5,": ".$nama_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Kode MK");
				$this->Cell($w[1],5,": ".$kode_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Kelas MK");
				$this->Cell($w[1],5,": ".$kelas_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Dosen Penguji");
				$this->Cell($w[1],5,": ".LoadDosen_X("",$dosen_mk[$j]));
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Sifat Ujian");
				$this->Cell($w[1],5,": ");
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"");
				$this->Cell($w[2],5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", __________________________");
				$this->Ln();
				$this->Cell($w[0],5,"Hari");
				$this->Cell($w[1],5,": ".$hari_mk[$j]);
				$this->Cell($w[2],5,"Penyelenggara,");
				$this->Ln();
				$this->Cell($w[0],5,"Tanggal");
				$this->Cell($w[1],5,": ".$tgl_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Waktu");
				$this->Cell($w[1],5,": ".$waktu_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Tempat");
				$this->Cell($w[1],5,": ".$ruang_mk[$j]);
				$this->Cell($w[2],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"Jml Naskah Pekerjaan");
				$this->Cell($w[1],5,":  __________ ( ____________________________________ )");
				$this->Cell($w[2],5,"( ____________________________________ )");
				$this->Ln();
			}
		}
	}
	
	function Page2($w,$data,$jenis){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			$this->SetTopMargin(37);
			$this->AddPage();
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(255,255,255);			
			$this->Cell(30,5,"Program Studi","");
			$this->Cell(160,5,": ".$prodi,"");
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell($w[0],5,"Waktu/Tempat",1,"","C",1);
			$this->Cell($w[1],5,"Matakuliah/Kelas/Dosen",1,"","C",1);
			$this->Cell($w[2],5,"Nama Pengawas",1,"","C",1);
			$this->Cell($w[3],5,"Tanda Tangan",1,"","C",1);
			$this->Ln();
			$MySQL->Select("jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,
      jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3,jwlutsuas.RUANG2,jwlutsuas.RUANG3,jwlutsuas.KELASUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.NODOSUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS",
			"jwlutsuas","LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) 
			LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
    	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
    	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId 
			WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."'","jwlutsuas.KDKMKUTSUAS");
			$jml=$MySQL->num_rows();
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$kode_mk[$i]=$show["KDKMKUTSUAS"];
				$nama_mk[$i]=$show["NAMKTBLMK"];
				$kelas_mk[$i]=$show["KELASUTSUAS"];
				$ruang_mk[$i]=$show["R1"];
				if($show["R2"] <> ""){
				    $r2 = explode('.',$show["R2"]);
            $ruang_mk[$i] .= "/".$r2[1];
        }
        
        if($show["R3"] <> ""){
            $r3 = explode('.',$show["R3"]);
            $ruang_mk[$i] .= "/".$r3[1];
        
        }
        
				$hari_mk[$i]=$show["HRPELUTSUAS"];
				$tgl_mk[$i]=DateStr($show["TGPELUTSUAS"]);
				$jam_mk[$i]=$show["WKPELUTSUAS"];
				$durasi_mk[$i]=($show["DURSIUTSUAS"] * 60);
				$dosen_mk[$i]=$show["NODOSUTSUAS"];
				$pengawas1_mk[$i]=$show["PENG1UTSUAS"];
				$pengawas2_mk[$i]=$show["PENG2UTSUAS"];
				$pengawas3_mk[$i]=$show["PENG3UTSUAS"];
				$pengawas4_mk[$i]=$show["PENG4UTSUAS"];
				$mulai_mk[$i]= new Time($jam_mk[$i]);
				$selesai_mk[$i]=$mulai_mk[$i]->add($durasi_mk[$i]);
				$waktu_mk[$i]= substr($jam_mk[$i],0,5)." - ".substr($selesai_mk[$i],0,5);
				$i++;
			}

			$no=1;
			for ($j=0; $j < $jml;$j++) {	
				if ($no == 10) {
					$this->SetTopMargin(37);
					$this->AddPage();
					$this->SetFont('Arial','B',8);
					$this->SetFillColor(255,255,255);			
					$this->Cell(30,5,"Program Studi","");
					$this->Cell(160,5,": ".$prodi,"");
					$this->Ln();
					$this->SetFillColor(223,223,223);			
					$this->Cell($w[0],5,"Waktu/Tempat",1,"","C",1);
					$this->Cell($w[1],5,"Matakuliah/Kelas/Dosen",1,"","C",1);
					$this->Cell($w[2],5,"Nama Pengawas",1,"","C",1);
					$this->Cell($w[3],5,"Tanda Tangan",1,"","C",1);
					$this->Ln();
					$no=1;
				}
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);			
				$this->Cell($w[0],7,$hari_mk[$j],"LTR","","",1);
				$this->Cell($w[1],7,$nama_mk[$j],"LTR","","",1);
				$this->Cell($w[2],7,"1. ".LoadPegawai_X("",$pengawas1_mk[$j]),1,"","",1);
				$this->Cell($w[3],7,"",1,"","C",1);
				$this->Ln();
				$this->Cell($w[0],7,"  ".$tgl_mk[$j],"LR","","",1);
				$this->Cell($w[1],7,"  ".$kode_mk[$j],"LR","","",1);
				$this->Cell($w[2],7,"2. ".LoadPegawai_X("",$pengawas2_mk[$j]),1,"","",1);
				$this->Cell($w[3],7,"",1,"","C",1);
				$this->Ln();
				$this->Cell($w[0],7,"  ".$waktu_mk[$j],"LR","","",1);
				$this->Cell($w[1],7,"  ".$kelas_mk[$j],"LR","","",1);
				$this->Cell($w[2],7,"3. ".LoadPegawai_X("",$pengawas3_mk[$j]),1,"","",1);
				$this->Cell($w[3],7,"",1,"","C",1);
				$this->Ln();
				$this->Cell($w[0],7,"  ".$ruang_mk[$j],"LRB","","",1);
				$this->Cell($w[1],7,"  ".LoadDosen_X("",$dosen_mk[$j]),"LRB","","C",1);
				$this->Cell($w[2],7,"4. ".LoadPegawai_X("",$pengawas4_mk[$j]),1,"","",1);
				$this->Cell($w[3],7,"",1,"","",1);
				$this->Ln();
				$no++;
			}
		}
	}

	function Page3($w,$data,$jenis,$title){
		global $MySQL, $PREFIX;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		foreach ($data as $row) {
			$prodi=LoadProdi_X("",$row);
			$MySQL->Select("jwlutsuas.KDKMKUTSUAS,tblmkupy.NAMKTBLMK,jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3,jwlutsuas.RUANG2,jwlutsuas.RUANG3,jwlutsuas.KELASUTSUAS,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS,jwlutsuas.NODOSUTSUAS,jwlutsuas.PENG1UTSUAS,jwlutsuas.PENG2UTSUAS,jwlutsuas.PENG3UTSUAS,jwlutsuas.PENG4UTSUAS","jwlutsuas",
			"LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) 
			LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
    	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
    	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId
			WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."'","jwlutsuas.KDKMKUTSUAS");
			$jml=$MySQL->num_rows();
			$i=0;
			while ($show=$MySQL->fetch_array()) {
				$kode_mk[$i]=$show["KDKMKUTSUAS"];
				$nama_mk[$i]=$show["NAMKTBLMK"];
				$kelas_mk[$i]=$show["KELASUTSUAS"];
				$ruang_mk[$i]=$show["R1"];
				if($show["R2"] <> ""){
				    $r2 = explode('.',$show["R2"]);
            $ruang_mk[$i] .= "/".$r2[1];
        }
        
        if($show["R3"] <> ""){
            $r3 = explode('.',$show["R3"]);
            $ruang_mk[$i] .= "/".$r3[1];
        
        }
        
				$hari_mk[$i]=$show["HRPELUTSUAS"];
				$tgl_mk[$i]=DateStr($show["TGPELUTSUAS"]);
				$jam_mk[$i]=$show["WKPELUTSUAS"];
				$durasi_mk[$i]=($show["DURSIUTSUAS"] * 60);
				$dosen_mk[$i]=$show["NODOSUTSUAS"];
				$pengawas1_mk[$i]=$show["PENG1UTSUAS"];
				$pengawas2_mk[$i]=$show["PENG2UTSUAS"];
				$pengawas3_mk[$i]=$show["PENG3UTSUAS"];
				$pengawas4_mk[$i]=$show["PENG4UTSUAS"];
				$mulai_mk[$i]= new Time($jam_mk[$i]);
				$selesai_mk[$i]=$mulai_mk[$i]->add($durasi_mk[$i]);
				$waktu_mk[$i]= substr($jam_mk[$i],0,5)." - ".substr($selesai_mk[$i],0,5);
				$i++;
			}

			for ($j=0; $j < $jml;$j++) {	
				$this->SetTopMargin(42);
				$this->AddPage();
				$this->SetFont('Arial','',8);
				$this->SetFillColor(255,255,255);			
				$this->Cell(190,5,"Pada hari ini ".$hari_mk[$j].", tanggal ".$tgl_mk[$j]." telah dilaksanakan ".strtolower(substr($title,25))." tahun akademik ".substr($_POST['tahun_akademik'],0,4)."/".(substr($_POST['tahun_akademik'],0,4) + 1)." :");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Program Studi");
				$this->Cell($w[2],5,": ".$prodi);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Matakuliah yang diajukan");
				$this->Cell($w[2],5,": ".$nama_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Kode MK");
				$this->Cell($w[2],5,": ".$kode_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Kelas");
				$this->Cell($w[2],5,": ".$kelas_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Dosen Penguji");
				$this->Cell($w[2],5,": ".LoadDosen_X("",$dosen_mk[$j]));
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Sifat Ujian");
				$this->Cell($w[2],5,": ");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Waktu Pelaksanaan");
				$this->Cell($w[2],5,": ".$waktu_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Bertempat di ruang");
				$this->Cell($w[2],5,": ".$ruang_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah peserta");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah peserta hadir");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah peserta tidak hadir");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah naskah pekerjaan");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Catatan Penting");
				$this->Cell(140,5,": _______________________________________________________________________________________");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"");
				$this->Cell(140,5,"  _______________________________________________________________________________________");
				$this->Ln();
				$this->Cell(190,5,"Berita acara ini dibuat sebagai dokumen pelaksanaan ".strtolower(substr($title,25)).".");
				$this->Ln();
				$this->Cell(145,5,"Pengawas");
				$this->Cell($w[3],5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".$tgl_mk[$j]);
				$this->Ln();

				$this->Cell(75,5,"1. ".LoadPegawai_X("",$pengawas1_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"Penyelenggara,");
				$this->Ln();
				
				$this->Cell(75,5,"2. ".LoadPegawai_X("",$pengawas2_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell(75,5,"3. ".LoadPegawai_X("",$pengawas3_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell(75,5,"4. ".LoadPegawai_X("",$pengawas4_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"( _________________________ )");
				$this->Ln();
				$this->Ln(50);
				$this->SetLineWidth(0);
				$this->Line(10,152,201,152);
				if (file_exists($_SESSION[$PREFIX.'LGPTIMSPTI']))
					$this->Image($_SESSION[$PREFIX.'LGPTIMSPTI'],9,162,16,17);
				$this->SetTextColor(0);
				$this->SetFont('Arial','B',14);
				$this->Text(30,170,$_SESSION[$PREFIX.'NMPTIMSPTI']);
				$this->Ln();
				$this->SetFont('Arial','B',9);
				$this->Text(30,174,$_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']);
				$this->SetFont('Arial','B',12);
				$this->Text(42,187,$title);
				$this->SetFont('Arial','B',10);
				$this->Text(83,192,"TAHUN AKADEMIK ".substr($_POST['tahun_akademik'],0,4)."/".(substr($_POST['tahun_akademik'],0,4) + 1));
				$this->SetLineWidth(0.5);
				$this->Line(10,180,201,180);
				$this->SetLineWidth(0);
				$this->Line(10,181,201,181);
				$this->SetFont('Arial','',8);
				$this->Cell(190,5,"Pada hari ini ".$hari_mk[$j].", tanggal ".$tgl_mk[$j]." telah dilaksanakan ".strtolower(substr($title,25))." tahun akademik ".substr($_POST['tahun_akademik'],0,4)."/".(substr($_POST['tahun_akademik'],0,4) + 1)." :");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Program Studi");
				$this->Cell($w[2],5,": ".$prodi);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Matakuliah yang diajukan");
				$this->Cell($w[2],5,": ".$nama_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Kode MK");
				$this->Cell($w[2],5,": ".$kode_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Kelas");
				$this->Cell($w[2],5,": ".$kelas_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Dosen Penguji");
				$this->Cell($w[2],5,": ".LoadDosen_X("",$dosen_mk[$j]));
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Sifat Ujian");
				$this->Cell($w[2],5,": ");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Waktu Pelaksanaan");
				$this->Cell($w[2],5,": ".$waktu_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Bertempat di ruang");
				$this->Cell($w[2],5,": ".$ruang_mk[$j]);
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah peserta");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah peserta hadir");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah peserta tidak hadir");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Jumlah naskah pekerjaan");
				$this->Cell($w[2],5,": _________ ( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"Catatan Penting");
				$this->Cell(140,5,": _______________________________________________________________________________________");
				$this->Ln();
				$this->Cell($w[0],5,"");
				$this->Cell($w[1],5,"");
				$this->Cell(140,5,"  _______________________________________________________________________________________");
				$this->Ln();
				$this->Cell(190,5,"Berita acara ini dibuat sebagai dokumen pelaksanaan ".strtolower(substr($title,25)).".");
				$this->Ln();
				$this->Cell(145,5,"Pengawas");
				$this->Cell($w[3],5,$_SESSION[$PREFIX.'KOTAAMSPTI'].", ".$tgl_mk[$j]);
				$this->Ln();

				$this->Cell(75,5,"1. ".LoadPegawai_X("",$pengawas1_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"Penyelenggara,");
				$this->Ln();
				
				$this->Cell(75,5,"2. ".LoadPegawai_X("",$pengawas2_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell(75,5,"3. ".LoadPegawai_X("",$pengawas3_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"");
				$this->Ln();
				$this->Cell(75,5,"4. ".LoadPegawai_X("",$pengawas4_mk[$j]));
				$this->Cell(70,5,"( _________________________ )");
				$this->Cell($w[3],5,"( _________________________ )");
				$this->Ln();
			}
		}
	}

	function Page4($w,$data,$jenis,$title){
		global $MySQL;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		foreach ($data as $row) {
			$this->SetTopMargin(42);
			$this->AddPage();
			$this->SetFont('Arial','B',8);
			$this->Cell(190,5,"Program Studi : ".LoadProdi_X("",$row));
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell($w[0],5,"Kode MK","1","","C",1);
			$this->Cell($w[1],5,"Matakuliah","1","","C",1);
			$this->Cell($w[2],5,"Kelas","1","","C",1);
			$this->Cell($w[3],5,"Hari/Tanggal","1","","C",1);
			$this->Cell($w[4],5,"Waktu","1","","C",1);
			$this->Cell($w[5],5,"Ruang","1","","C",1);
			$this->Ln();
			$MySQL->Select("DISTINCT jwlutsuas.KDKMKUTSUAS","jwlutsuas","WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."'","jwlutsuas.KDKMKUTSUAS");
			$i=0;
			$jml=$MySQL->num_rows();
			while ($master=$MySQL->fetch_array()) {
				$mk[$i]=$master['KDKMKUTSUAS'];
				$i++;
			}
			
			for ($i=0;$i < $jml;$i++) {
				$this->SetFillColor(255,255,255);			
				$this->SetFont('Arial','',6);
				$MySQL->Select("jwlutsuas.KDKMKUTSUAS,jwlutsuas.KELASUTSUAS,jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3, tblmkupy.NAMKTBLMK,jwlutsuas.RUANGUTSUAS,jwlutsuas.RUANG2,jwlutsuas.RUANG3,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS","jwlutsuas",
				
				"LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
      	LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
      	LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId 
				LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."' AND jwlutsuas.KDKMKUTSUAS='".$mk[$i]."'","jwlutsuas.KELASUTSUAS");
				$no=1;
				$tt=$MySQL->num_rows();
				while ($show=$MySQL->fetch_array()) {

			 	  $ruangUjian = $show["R1"];
			 	  if($show["R2"] <> ""){
             $r2 = explode('.',$show["R2"]);
            $ruangUjian .= "/".$r2[1];
          }
          
          if($show["R3"] <> ""){
             $r3 = explode('.',$show["R3"]);
            $ruangUjian .= "/".$r3[1];
          
          }
					$mulai= New Time($show['WKPELUTSUAS']);
					$durasi=($show['DURSIUTSUAS'] * 60);
					$selesai=$mulai->add($durasi);
					if ($no==1) {
						$this->Cell($w[0],5,$show['KDKMKUTSUAS'],"1","","L",1);
						$this->Cell($w[1],5,$show['NAMKTBLMK'],"1","","L",1);
					} elseif ($no == $tt) {
						$this->Cell($w[0],5,"","LBR","","L",1);
						$this->Cell($w[1],5,"","LBR","","L",1);
					} else {
						$this->Cell($w[0],5,"","LR","","L",1);						
						$this->Cell($w[1],5,"","LR","","L",1);
					}
					$this->Cell($w[2],5,$show['KELASUTSUAS'],"1","","C",1);
					$this->Cell($w[3],5,$show['HRPELUTSUAS'].", ".DateStr($show['TGPELUTSUAS']),"1","","L",1);

					$this->Cell($w[4],5,substr($show['WKPELUTSUAS'],0,5)." s.d. ".substr($selesai,0,5),"1","","L",1);
					$this->Cell($w[5],5,$ruangUjian,"1","","C",1);
					$this->Ln();
					$no++;
				}
			}
			$this->Ln();
		}	
	}

	function Page5($w,$data,$jenis,$title){
		global $MySQL;
		$this->SetTextColor(0);
		$this->SetDrawColor(0,0,0);
		foreach ($data as $row) {
			$this->SetTopMargin(42);
			$this->AddPage();
			$this->SetFont('Arial','B',8);
			$this->Cell(190,5,"Program Studi : ".LoadProdi_X("",$row));
			$this->Ln();
			$this->SetFillColor(223,223,223);			
			$this->Cell($w[0],5,"Hari/Tanggal","1","","C",1);
			$this->Cell($w[1],5,"Waktu","1","","C",1);
			$this->Cell($w[2],5,"Kode MK","1","","C",1);
			$this->Cell($w[3],5,"Matakuliah","1","","C",1);
			$this->Cell($w[4],5,"Kelas","1","","C",1);
			$this->Cell($w[5],5,"Ruang","1","","C",1);
			$this->Ln();
			$MySQL->Select("DISTINCT jwlutsuas.TGPELUTSUAS","jwlutsuas",
			
			"WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."'","jwlutsuas.TGPELUTSUAS");
			$i=0;
			
			//echo $MySQL->qry."<br /><br />";
			$jml=$MySQL->num_rows();
			while ($master=$MySQL->fetch_array()) {
				$tgl[$i]=$master['TGPELUTSUAS'];
				$i++;
			}
			
			for ($i=0;$i < $jml;$i++) {
				$this->SetFillColor(255,255,255);			
				$this->SetFont('Arial','',6);
				$MySQL->Select("jwlutsuas.KDKMKUTSUAS,jwlutsuas.KELASUTSUAS,tblmkupy.NAMKTBLMK,
        jwlutsuas.RUANGUTSUAS, r1.ruangNama AS R1, r2.ruangNama AS R2,r3.ruangNama AS R3,jwlutsuas.HRPELUTSUAS,jwlutsuas.TGPELUTSUAS,jwlutsuas.WKPELUTSUAS,jwlutsuas.DURSIUTSUAS","jwlutsuas",
				"LEFT JOIN ruang_kuliah AS r1 ON RUANGUTSUAS = r1.ruangId
    	  LEFT JOIN ruang_kuliah AS r2 ON RUANG2 = r2.ruangId
    	  LEFT JOIN ruang_kuliah AS r3 ON RUANG3 = r3.ruangId 
				LEFT OUTER JOIN tblmkupy ON (jwlutsuas.KDKMKUTSUAS = tblmkupy.KDMKTBLMK) WHERE jwlutsuas.THSMSUTSUAS = '".$_POST['tahun_akademik']."' AND jwlutsuas.KDPSTUTSUAS = '".$row."' AND JENISUTSUAS = '".$jenis."' AND jwlutsuas.TGPELUTSUAS='".$tgl[$i]."'","jwlutsuas.WKPELUTSUAS");
				
        //echo $MySQL->qry; exit;
        $no=1;
				$tt=$MySQL->num_rows();
				while ($show=$MySQL->fetch_array()) {
				  $ruangUjian = $show["R1"];
			 	  if($show["R2"] <> ""){
             $r2 = explode('.',$show["R2"]);
            $ruangUjian .= "/".$r2[1];
          }
          
          if($show["R3"] <> ""){
             $r3 = explode('.',$show["R3"]);
            $ruangUjian .= "/".$r3[1];
          
          }
          
					$mulai= New Time($show['WKPELUTSUAS']);
					$durasi=($show['DURSIUTSUAS'] * 60);
					$selesai=$mulai->add($durasi);
					if ($no==1) {
						$this->Cell($w[0],5,$show['HRPELUTSUAS'].", ".DateStr($tgl[$i]),"1","","L",1);
					} elseif ($no == $tt) {
						$this->Cell($w[0],5,"","LBR","","L",1);
					} else {
						$this->Cell($w[0],5,"","LR","","L",1);						
					}
					$this->Cell($w[1],5,substr($show['WKPELUTSUAS'],0,5)." s.d. ".substr($selesai,0,5),"1","","L",1);
					$this->Cell($w[2],5,$show['KDKMKUTSUAS'],"1","","L",1);
					$this->Cell($w[3],5,$show['NAMKTBLMK'],"1","","L",1);
					$this->Cell($w[4],5,$show['KELASUTSUAS'],"1","","C",1);
					$this->Cell($w[5],5,$ruangUjian,"1","","C",1);
					$this->Ln();
					$no++;
				}
			}
			$this->Ln();
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
			$title ="PRESENSI UJIAN ".$jenis_ujian;
			$x=60;
			break;
		case '1' :
			$title ="NASKAH PEKERJAAN UJIAN ".$jenis_ujian;
			$x=47;
			break;
		case '2' :
			$title ="PRESENSI PENGAWAS UJIAN ".$jenis_ujian;
			$x=47;
			break;
		case '3' :
			$title ="BERITA ACARA PELAKSANAAN UJIAN ".$jenis_ujian;
			$x=42;
			break;
		case '4' :
			$title ="JADWAL PELAKSANAAN UJIAN ".$jenis_ujian." (Matakuliah)";
			$x=35;
			break;
		case '5' :
			$title ="JADWAL PELAKSANAAN UJIAN ".$jenis_ujian." (Hari)";
			$x=32;
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
		$this->SetFont('Arial','B',10);
		$this->Text(83,32,"TAHUN AKADEMIK ".substr($tahun_akademik,0,4)."/".(substr($tahun_akademik,0,4) + 1));
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
$tahun_akademik=$_POST['tahun_akademik'];
$semester = substr($tahun_akademik,4,1); 
$jenis_ujian = $_POST['jenis_ujian'];
if ($jenis_ujian == '0') {
	$jenis="UTS";
	$jenis_ujian = "TENGAH SEMESTER ";
} else {
	$jenis="UAS";
	$jenis_ujian = "AKHIR SEMESTER ";	
}
$jenis_ujian .= LoadSemester_X("",$semester);
if (isset($_POST['report_title'])){
	$program_studi=$_POST['program_studi'];
	$pdf->SetTextColor(0);
	switch ($report_title) {
		case '0' :
			$title ="PRESENSI UJIAN ".$jenis_ujian;
			$width1="8,20,97,10,30,25";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page($width1,$data,$jenis);
			break;
		case '1' :
			$title ="NASKAH PEKERJAAN UJIAN ".$jenis_ujian;
			$width1 = $width1="30,100,60";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page1($width1,$data,$jenis,$title);
			break;
		case '2' :
			$title ="PRESENSI PENGAWAS UJIAN ".$jenis_ujian;
			$width1="40,60,60,30";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page2($width1,$data,$jenis);
			break;
		case '3' :
			$title ="BERITA ACARA PELAKSANAAN UJIAN ".$jenis_ujian;
			$width1 = $width1="10,40,95,45";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page3($width1,$data,$jenis,$title);
			break;
		case '4' :
			$title ="JADWAL PELAKSANAAN UJIAN ".$jenis_ujian." (Matakuliah)";
			$width1 = $width1="20,83,15,30,30,15";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page4($width1,$data,$jenis,$title);
			break;
		case '5' :
			$title ="JADWAL PELAKSANAAN UJIAN ".$jenis_ujian." (Hari)";
			$width1 = $width1="30,30,20,83,15,15";
			$width1= @explode(",",$width1);
			$data=@explode(",",$program_studi);
			$pdf->Page5($width1,$data,$jenis,$title);
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