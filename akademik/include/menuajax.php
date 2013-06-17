<?php
$menu = $_GET['menu'];
$kode = $_GET['kode'];
require "../config.php";
$DB_site = new mysqli($servername, $dbusername, $dbpassword);
$DB_site->select_db($dbname);

function ChangeKorp ($idparent="", $idkorp="") {
	global $DB_site;
	$temps=$DB_site->query("SELECT IDKorp, NamaKorp FROM korp where IDKorp_Parent='$idparent' order by NamaKorp");
	
	while ($row = $temps->fetch_assoc()) {
	//while ($row=$DB_site->fetch_array($temps)) {
		if ($row[IDKorp]==$idkorp) {	
			print("<option value=\"$row[IDKorp]\" selected>$row[NamaKorp]</option>");	
  		}else{
			print("<option value=\"$row[IDKorp]\">$row[NamaKorp]</option>");	
  		}
	}
	$temps->close();
}

function LoadPangkatByKelompok ($kelompok=0) {
	global $DB_site;
	$strSQL = "SELECT IDPangkat, NamaPangkat FROM Pangkat ";
	switch ($kelompok){
	case 0 : $strSQL .= "WHERE IDPangkat_Parent<>'0' AND JenisPangkat='1' ";break;
	case 1 : $strSQL .= "WHERE IDPangkat_Parent='1' ";break;
	case 2 : $strSQL .= "WHERE IDPangkat_Parent='1' AND (seq between 1 and 4) ";break;
	case 3 : $strSQL .= "WHERE IDPangkat_Parent='1' AND (seq between 5 and 7) ";break;
	case 4 : $strSQL .= "WHERE IDPangkat_Parent='1' AND (seq between 8 and 10) ";break;
	case 5 : $strSQL .= "WHERE IDPangkat_Parent='2' ";break;
	case 6 : $strSQL .= "WHERE IDPangkat_Parent='3' ";break;
	}
	$strSQL .= " ORDER BY JenisPangkat, IDPangkat_Parent, Seq";
	$temps=$DB_site->query($strSQL);
	
	while ($row = $temps->fetch_assoc()) {
	//while ($row=$DB_site->fetch_array($temps)) {
		if ($row[IDPangkat]==$idpangkat) {	
			print("<option value=\"$row[IDPangkat]\" selected>$row[NamaPangkat]</option>");	
  		}else{
			print("<option value=\"$row[IDPangkat]\">$row[NamaPangkat]</option>");	
  		}
	}
	$temps->close();
}

function LoadHirarkiJabatan ($IDSatuan=0, $IDParent=0, $level=0, $IDSelected=0) {
	global $DB_site;
	
	$temps = $DB_site->query("SELECT * FROM jabatan
		WHERE IDJabatanParent='$IDParent' AND IDSATUAN='$IDSatuan'
		ORDER BY NamaJabatan Asc");	
	while ($row = $temps->fetch_assoc()) {
		if ($row[IDJabatan] <> $IDParent) {
			$pad = str_repeat('&#8212; ', $level);
		}			
		if ($row[IDJabatan]==$IDSelected) {
			echo "<option value=$row[IDJabatan] selected>".$pad.$row[NamaJabatan]."</option>";	
		} else {
			echo "<option value=$row[IDJabatan]>".$pad.$row[NamaJabatan]."</option>";	
		}
		LoadHirarkiJabatan ($IDSatuan, $row[IDJabatan], $level+1, $IDSelected);
	}
	$temps->close();
}

switch ($menu){
	case "jabatan" :
		echo "<select name=\"idjabatan\">";
		echo "<option value=\"\">-- Jabatan --</option>";
		if($kode!=""){
			LoadHirarkiJabatan ($kode, 0, 0, "");
		}
		echo "</select>";
		break;
		
	case "pangkatbykelompok" :
		echo "<select name=\"idpangkat\">";
		echo "<option value=\"\">-- Pangkat --</option>";
		if($kode!=""){
			LoadPangkatByKelompok ($kode);
		}
		echo "</select>";
		break;
		
	case "divspesialisasi" :
		global $DB_site;
		echo "<select name=\"idspesialisasi\" onchange=\"javascript:ubahkorp(this,'divkualifikasi')\">";
		echo "<option value=\"\">-- Spesialisasi --</option>";
		if($kode!=""){	
			ChangeKorp ($kode, "");
		}
		echo "</select>";
		break;
		
	case "divkualifikasi" :
		echo "<select name=\"idkualifikasi\">";
		echo "<option value=\"\">-- Kualifikasi --</option>";
		if($kode!=""){
			ChangeKorp ($kode, "");}
		echo "</select>";
		break;
}
//$temps->close( );
?>