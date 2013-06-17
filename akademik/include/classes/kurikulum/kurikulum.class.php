<?php
function GetCurrKurikulum($kd=""){
	global $MySQL;
	$MySQL->Select("tbkurupy.IDX,tbkurupy.KDKURTBKUR","tbkurupy","WHERE tbkurupy.KDPSTTBKUR ='".$kd."'","tbkurupy.THAWLTBKUR DESC","1");
	$show=$MySQL->fetch_array();
	$kurikulum = $show["IDX"].",".$show["KDKURTBKUR"];

	return $kurikulum;
}

function GetKurSaji($cbProdi,$ThnSemester){
	global $MySQL;
	$MySQL->Select("DISTINCT tbmksajiupy.KDKURMKSAJI","tbmksajiupy","WHERE tbmksajiupy.KDPSTMKSAJI ='".$cbProdi."' and tbmksajiupy.THSMSMKSAJI='".$ThnSemester."'","","");
	$show=$MySQL->fetch_array();
	$kurikulum = $show["KDKURMKSAJI"];
	return $kurikulum;
}

function GetDetailMhs($kd){
	global $MySQL;
	$MySQL->Select("NMMHSMSMHS,KDPSTMSMHS","msmhsupy","WHERE msmhsupy.NIMHSMSMHS ='".$kd."'","","1");
	$show=$MySQL->fetch_array();
	$mahasiswa = $show["NMMHSMSMHS"].",". $show["KDPSTMSMHS"] ;
	return $mahasiswa;
}

function LoadKurikulumMK($nama="",$val="",$kur,$sem){
	global $MySQL;
	//$sem = substr($sem,4,1);
	$semester="(1,3,5,7,9)";
	if ($sem=="2") $semester="(2,4,6,8,10)";

	if ($nama != ""){
		$MySQL->Select("tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK","tbkmkupy"," LEFT JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE tbkmkupy.IDKURTBKMK='".$kur."' AND tbkmkupy.SEMESTBKMK IN ".$semester,"tbkmkupy.KDKMKTBKMK ASC");
		$sel0="";
		if ($val=="") $sel0="selected='selected'";
		$matakuliah_x = print("<select name='$nama' id='$nama'>");
    	$matakuliah_x .= print("<option value='-1' $sel0 >--- Matakuliah ---</option>");
    	while ($show=$MySQL->Fetch_Array()) {
    		$sel="";
    		if ($show["KDKMKTBKMK"]==$val) $sel="selected='selected'";
        	$matakuliah_x .= print("<option value='".$show["KDKMKTBKMK"]."' $sel>".$show["KDKMKTBKMK"]. " - ".$show["NAMKTBLMK"]."</option>");
    	}
    	$matakuliah_x .= print("</select>");
	} else {
		$MySQL->Select("NAMKTBLMK","tblmkupy","WHERE KDMKTBLMK='".$val."'","","1");
    	$show=$MySQL->Fetch_Array();
		$matakuliah_x = $show["NAMKTBLMK"];
	}
	return $matakuliah_x;
}
?>