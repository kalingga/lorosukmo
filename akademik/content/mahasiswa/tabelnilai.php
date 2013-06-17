<?php
$idpage='17';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {	
	     $sel="";
		 echo "<center><table border='0' align='center' style='width:30%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
	     echo "<tr><th colspan='2' style='background-color:#EEE'>TABEL BOBOT NILAI</th></tr>";
	     echo "<tr>
	     <th style='width:100px;'>NILAI</th> 
	     <th style='width:100px;'>BOBOT</th> 
	     </tr>";				
	      $MySQL->Select("tbbnlupy.IDX,tbbnlupy.NLAKHTBBNL,tbbnlupy.BOBOTTBBNL","tbbnlupy","","tbbnlupy.BOBOTTBBNL DESC","","0");
	      $no=1;
	      if ($MySQL->Num_Rows() > 0){
		      while ($show=$MySQL->Fetch_Array()){
		     	$sel="";
				if ($no % 2 == 1) $sel="sel";     	
		     	echo "<tr>";
		     	echo "<td class='$sel tac'>".$show["NLAKHTBBNL"]."</td>";
		     	echo "<td class='$sel tac'>".$show["BOBOTTBBNL"]."</td>";
		     	echo "</tr>";
		     	$no++;
		     }
		} else {
		 	echo "<td colspan='2' align='center' style='color:red;'>".$msg_data_empty."</td>";
		}
	     /********* Tab Navigator ***************/
	    echo "</tr></table></center>";
}
?>

