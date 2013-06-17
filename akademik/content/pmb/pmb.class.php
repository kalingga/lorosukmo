<?php
function GetAjaran() {
	$thn=date("Y",$_SERVER['REQUEST_TIME']); 
	return $thn;
}

function GetNoDaftar() {
	global $MySQL;
	$ThnAjaran= GetAjaran();
	$MySQL->Select("count(*) as JMLDAFTAR","tbpmbupy","WHERE THNSMTBPMB ='".$ThnAjaran."'","","1");
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

function GetForm() {
	global $MySQL;
	$tgl=date("d-m-Y",$_SERVER['REQUEST_TIME']);
	$MySQL->Select("MAX(setpmb.IDX) AS DAFTAR,setpmb.TG1SETPMB,setpmb.TG2SETPMB","setpmb","GROUP BY setpmb.TG1SETPMB,setpmb.TG2SETPMB","","1");
//    $daftar=0;
	$show=$MySQL->Fetch_Array();	
	if ((strftime('Y-m-d',$tgl) >= $show['TG1SETPMB']) && (strftime('Y-m-d',$tgl) <= $show['TG2SETPMB']) ){
		$daftar=1;
	}
	return $daftar;
}

?>