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
?>