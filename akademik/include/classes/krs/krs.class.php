<?php
include "include/calendar/Date.class.php";
$curr_date=$dateServer;
$curr_date=@explode("-",$curr_date);
$curr_month=$curr_date[1];
$curr_year=$curr_date[0];

function GetCurrKurikulum($kd=""){
	global $MySQL;
	$MySQL->Select("tbkurupy.KDKURTBKUR","tbkurupy","WHERE tbkurupy.KDPSTTBKUR ='".$kd."'","tbkurupy.THAWLTBKUR DESC","1");
	$show=$MySQL->fetch_array();
	$kurikulum = $show["KDKURTBKUR"];
	return $kurikulum;
}

function GetKurSaji($cbProdi,$ThnSemester){
	global $MySQL;
	$MySQL->Select("DISTINCT tbmksajiupy.KDKURMKSAJI","tbmksajiupy","WHERE tbmksajiupy.KDPSTMKSAJI ='".$cbProdi."' and tbmksajiupy.THSMSMKSAJI='".$ThnSemester."'","","");
	$show=$MySQL->fetch_array();
	$kurikulum = $show["KDKURMKSAJI"];
	return $kurikulum;
}

?>