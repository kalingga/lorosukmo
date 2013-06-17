<?php
/*	untuk memunculkan no formulir */

function GetEndVal(){
	global $MySQL;
	$MySQL->Select("MAX(setpmb.TG1SETPMB) AS MAXDATE","setpmb","","1");
	$show=$MySQL->fetch_array();
	$maxdate=$show['MAXDATE'];
	return $maxdate;
}

function GetFormulir(){
	global $MySQL;
	$MySQL->Select("*","setpmb","where setpmb.TG1SETPMB = '".GetEndVal()."'","","1");
	$show=$MySQL->fetch_array();
	$setpmb=$show['TG1SETPMB'].",".$show['TG2SETPMB'].",".$show['TASETPMB'].",".$show['KDSETPMB'].",".$show['GELSETPMB'].",".$show['PUJISETPMB'].",".$show['TUJISETPMB'].",".$show['KPSTSETPMB'].",".$show['WUJISETPMB'].",".$show['DURSSETPMB'];
	return $setpmb;
}


function GetAjaran() {
	$thn=date("Y",$_SERVER['REQUEST_TIME']); 
	return $thn;
}

function GetNoDaftar() {
	global $MySQL;
	$pmb=GetFormulir();
	$pmb=@explode(",",$pmb);
	$thn_pmb= $pmb[2];
	$ang_pmb= $pmb[4];
	$MySQL->Select("count(*) as JMLDAFTAR","tbpmbupy","WHERE THNSMTBPMB ='".$thn_pmb."' and ANGKTTBPMB='".$ang_pmb."'","","1");
    $show=$MySQL->Fetch_Array();
	$jumlah= $show["JMLDAFTAR"] + 1;
	return $jumlah;
}

function SetNoForm() {
	global $MySQL;
	$ThnAjaran= GetAjaran();
	$MySQL->Select("count(*) as FORMULIR","frpmbupy","WHERE THNSMFRPMB ='".$ThnAjaran."'","","1");
    $show=$MySQL->Fetch_Array();
	$jumlah= $show["FORMULIR"] + 1;
	
	return $jumlah;
}
?>