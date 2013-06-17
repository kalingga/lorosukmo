<?php
$idpage='33';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
	echo "<form action='./?".$URLa."' method='post' >";
	echo "<tr><td colspan='5'>";
	echo "Pencarian Berdasarkan : <select name='field'>";
    if ($field=='TASMSSETKRS') $sel1="selected='selected'";
    echo "<option value='TASMSSETKRS' $sel1 >TAHUN AKADEMIK</option>";
	
    echo "</select>";
    echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n</td>";
	 
	echo "<td colspan='2' align='right'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
	echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=jadwalkrs&amp;p=refresh'><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 

    echo "</td></tr></form>";
	echo "<tr><td colspan='7' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=jadwalkrs&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
    echo "<tr><th colspan='7' style='background-color:#EEE'>DAFTAR PENJADWALAN KRS</th></tr>";
    echo "<tr>
    <th style='width:20px; tac' rowspan='2'>NO</th> 
    <th style='width:75px;' rowspan='2'>TAHUN AKADEMIK</th> 
    <th style='width:30px; tac' rowspan='2'>SEM</th> 
    <th style='width:150px;' colspan='2'>PENGISIAN KRS</th> 
    <th style='width:150px;' colspan='2'>PERUBAHAN KRS</th>
 	</tr>";
    echo "<tr>
    <th style='width:150px;'>TANGGAL</th> 
    <th style='width:30px;'>HARI</th> 
    <th style='width:150px;'>TANGGAL</th> 
    <th style='width:30px;'>HARI</th>
 	</tr>";
	$MySQL->Select("*","setkrsupy",$qry,"","","0");
	$total=$MySQL->Num_Rows();
	$perpage=$_REQUEST['limit'];
	$totalpage=ceil($total/$perpage);
	$start=($_GET['pos']-1)*$perpage;
    $MySQL->Select("setkrsupy.*,(DATEDIFF(setkrsupy.BTKRSSETKRS,setkrsupy.MLKRSSETKRS)+1) AS JMLHARI,(DATEDIFF(setkrsupy.TGAKHSETKRS,setkrsupy.TGAWLSETKRS)+1) AS JMLHARI1","setkrsupy",$qry,"setkrsupy.TASMSSETKRS DESC","$start,$perpage");
    $no=1;
    if ($MySQL->Num_Rows() > 0){
		while ($show=$MySQL->Fetch_Array()){
	    	$sel="";
			if ($no % 2 == 1) $sel="sel";
	     	//set semester
	     	$semester="Gasal";
	     	if (substr($show['TASMSSETKRS'],4,1)=="2") $semester="Genap";
	     	echo "<tr>";
	     	echo "<td class='$sel tac'>".$no."</td>";
	     	echo "<td class='$sel'>".substr($show['TASMSSETKRS'],0,4)."/".(substr($show['TASMSSETKRS'],0,4) + 1)."</td>";
	     	echo "<td class='$sel tac'>".$semester."</td>";
	     	echo "<td class='$sel tac'>".DateStr($show['MLKRSSETKRS'])." s.d. ".DateStr($show['BTKRSSETKRS'])."</td>";
	     	echo "<td class='$sel tar'>".$show['JMLHARI']." hari</td>";	     	
	     	echo "<td class='$sel tac'>".DateStr($show['TGAWLSETKRS'])." s.d. ".DateStr($show['TGAKHSETKRS'])."</td>";
	     	echo "<td class='$sel tar'>".$show['JMLHARI1']." hari</td>";
	     	echo "</tr>";
     	$no++;
 		}
	} else {
		echo "<td colspan='7' align='center' style='color:red;'>".$msg_data_empty."</td>";		
 	}
 	echo "</table>";
 	include "navigator.php";
}
?>

