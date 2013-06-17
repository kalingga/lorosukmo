<?php
$idpage='3';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_GET['p']) && $_GET['p']=='del') {
  		$id=$_GET['id']; 
  		$MySQL->Delete("tb_log","where id_log=".$id,"1");
  		if ($MySQL->exe){
    		$message ="Data Berhasil Dihapus!<br />";
    		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
    		echo $message;
    		echo "</div>";
  		} else {
    		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    		echo "Data Gagal Dihapus!";
    		echo "</div>";
  		}
 	}
 
 	if ($_POST['p']=='Hapus'){
  		$id_log_arr=$_POST['id_log_arr']; 
  		$succ=array();
  		$fail=array();
  
  		if (count($id_log_arr)>0){
	  		foreach($id_log_arr as $id_log=>$value){
				$MySQL->Delete("tb_log","where id_log=".$id_log,"1");
				if ($MySQL->exe) $succ[]=$id_log; else $fail[]=$id_log;
	  		}
  		}   
  		if (count($succ)>0){
    		echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
    		echo "Data ".implode(',',$succ)." Berhasil Dihapus!";
    		echo "</div>";
  		}
  		if (count($fail)>0){
    		echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    		echo "Data ".implode(',',$fail)." Gagal Dihapus!";
    		echo "</div>";
  		}
 	}
 
 	$URLa="page=".$_GET['page'];
    if (!isset($_GET['pos'])) $_GET['pos']=1;
    echo "<form action='./?page=loghistory' method='post' >";
    echo "Pencarian Berdasarkan : <select name='field'>";
    $field=$_REQUEST['field'];
    $sel="";
    if ($field=='id_admin') $sel1="selected='selected'";
    if ($field=='act_log') $sel2="selected='selected'";
    echo "<option value='nama_admin' $sel1 >ADMIN</option>";
    echo "<option value='act_log' $sel2 >AKTIVITAS</option>";
    echo "</select> ";
    echo "<input type='text' name='kwd' value='".$_REQUEST['kwd']."' /> ";
    echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>&nbsp;\n";
	 if (!isset($_REQUEST['limit'])){
	    $_REQUEST['limit']="20";
	 }
	 echo "<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5' /> ";
    echo "</form>";
    if(!empty($_REQUEST['kwd'])) $qry="WHERE $field LIKE '%".$_REQUEST['kwd']."%'"; 
	else {
		$qry='';
	}
    $MySQL->Select("*","tb_log",$qry);
    $total=$MySQL->Num_Rows();
    $perpage=$_REQUEST['limit'];
    $totalpage=ceil($total/$perpage);
    $start=($_GET['pos']-1)*$perpage;	
    $MySQL->Select("*","tb_log",$qry," datetime_log DESC","$start,$perpage");
	echo "<form name='frm_del' action='./?page=loghistory' method='post' >";
    echo "<table border='0' style='width:99%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
    echo "<tr><th colspan='5' style='background-color:#EEE'>Daftar History Log</th></tr>";
    echo "<tr>
    <th style='width:30px;'>NO</th> 
    <th style='width:75px;'>ID USER</th> 
    <th>AKTIVITAS</th> 
	<th style='width:125px;'>WAKTU</th> 
    <th style='width:40px;'>ACT</th> 
    </tr>";
    $no=1;
    while ($show=$MySQL->Fetch_Array()){
    	echo "<tr>";
		$sel="";
		if ($no % 2 == 1) $sel="sel"; 
     	echo "<td class='$sel fs11'>".$no."</td>";
     	echo "<td class='$sel fs11'>".$show['id_user']."</td>";
     	echo "<td class='$sel fs11'>".$show['act_log']."</td>";
		echo "<td class='tac $sel fs11'>".$show['datetime_log']."</td>";
     	echo "<td class='tac $sel fs11'>";
		echo "<a href='./?page=loghistory&amp;p=del&amp;id=".$show['id_log']."' onclick=\"return confirm('Apakah Data Ini Benar Mau Dihapus?')\" ><img border='0' src='images/b_drop.png' title='HAPUS DATA' /></a> ";
		echo "<input type='checkbox' class='cbx' name='id_log_arr[".$show['id_log']."]' />";
     	echo "</td>";
     	echo "</tr>";
        $no++;
    }
	echo "<tr><th colspan='5' class='tal'>";
	include "navigator.php";
	echo "</th></tr>";
    echo "</table>";
	echo "<input type='checkbox' class='cbx' onclick='flipflop(this.form,this)' /> Check/UnCheck All 			<button type='submit' name='p' value='Hapus'><img src='images/b_delete.png' class='btn_img'/> Hapus</button></form>";
}
?>