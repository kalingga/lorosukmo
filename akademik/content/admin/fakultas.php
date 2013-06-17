<?php
$idpage='10';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (!isset($_GET['pos'])) $_GET['pos']=1;
	$page=$_GET['page'];
	$p=$_GET['p'];
	$sel="";
	$field=$_REQUEST['field'];
	if (!isset($_REQUEST['limit'])){
		$_REQUEST['limit']="20";
	}
	if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
	echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
  	echo "<form action='./?page=fakultas' method='post' >";
	echo "<tr><td colspan='3'>";
	echo "Pencarian Berdasarkan : <select name='field'>";
	if ($field=='KDFAKMSFAK') $sel1="selected='selected'";
	if ($field=='NMFAKMSFAK') $sel2="selected='selected'";		
	echo "<option value='KDFAKMSFAK' $sel1 >KODE</option>";
	echo "<option value='NMFAKMSFAK' $sel2 >FAKULTAS</option>";
	echo "</select>";
	
	echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n";
	echo "<td align='right' colspan='5'>Data per Hal:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='4'/>";
	echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=fakultas'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	echo "</td></tr></form>";

	echo "<tr><td colspan='8' style='background-color:#FFF'><button type='button' onClick=window.location.href='./?page=$page&amp;p=add' /><img src='images/b_add.png' class='btn_img'>&nbsp;Tambah Data</button></td></tr>";
	echo "<tr><th colspan='8' style='background-color:#EEE'>DAFTAR FAKULTAS</th></tr>";
	echo "<tr>
		<th style='width:75px;'>KODE</th> 
		<th style='width:300px;'>FAKULTAS</th> 
		<th colspan='2'>ALAMAT</th> 
		<th style='width:100px;'>TELEPON</th> 
		<th style='width:40px;'>STATUS</th> 
		<th colspan='2' style='width:20px;'>ACT</th> 
		</tr>";

 	 $qry = "where KDFAKMSFAK='".$fak."'";
	 if (($fak=="") || ($fak=="0") || is_null($fak)) {
	 	$qry ="";
	    if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
 	  		$qry .= " where ".$field." like '".$key."'";
 	  	}
 	 } else {
	    if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
 	  		$qry .= " and ".$field." like '".$key."'";
 	  	}
	 }
		     
	 $MySQL->Select("*","msfakupy",$qry,"","","0");
  	 $total=$MySQL->Num_Rows();
  	 $perpage=$_REQUEST['limit'];
  	 $totalpage=ceil($total/$perpage);
  	 $start=($_GET['pos']-1)*$perpage;
	 $MySQL->Select("IDX,KDFAKMSFAK,NMFAKMSFAK,ALMT1MSFAK,ALMT2MSFAK,KOTAAMSFAK,KDPOSMSFAK,TELPOMSFAK,STATUMSFAK","msfakupy",$qry,"KDFAKMSFAK ASC","$start,$perpage");
     $no=1;
     if ($MySQL->num_rows()) {
	     while ($show=$MySQL->Fetch_Array()){
			$sel="";
			if ($no % 2 == 1) $sel="sel";     	
	     	$alamat=$show['ALMT1MSFAK']." ".$show['ALMT2MSFAK']." ".$show['KOTAAMSFAK']." ".$show['KDPOSMSFAK'];
			$status="Non Aktif";
			if ($show['STATUMSFAK']=='1'){
				$status="Aktif";
			}
			echo "<tr>";
	     	echo "<td class='$sel tac'>".$show['KDFAKMSFAK']."</td>";
	     	echo "<td class='$sel'>".$show['NMFAKMSFAK']."</td>";
	     	echo "<td class='$sel' colspan='2'>".$alamat."</td>";
	     	echo "<td class='$sel'>".$show['TELPOMSFAK']."</td>";
	     	echo "<td class='$sel'>".$status."</td>";
	     	echo "<td class='$sel tac'>";
			echo "<a href='./?page=".$page."&amp;p=edit&amp;id=".$show['IDX']."'><img border='0' src='images/b_edit.png' title='EDIT DATA' /></a> ";
	     	echo "</td>";
	     	echo "<td class='$sel tac'>";
			echo "<a href='./?page=".$page."&amp;p=delete&amp;id=".$show['IDX']."' ><img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/></a> ";
	     	echo "</td>";
	     	echo "</tr>";
	     	$no++;
		}
	} else {
		echo "<tr><td align='center' style='color:red;' colspan='8'>".$msg_data_empty."</td></tr>";
	}
	echo "<tr><td colspan='8'>";
	include "./navigator.php";
	echo "</td></tr>";
	echo "</table>";
}
?>

