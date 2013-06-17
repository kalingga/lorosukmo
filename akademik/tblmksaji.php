<?php
$idpage='18';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	    echo "<table border='0' style='width:100%;margin:10px auto; overflow:scroll' cellpadding='2' cellspacing='1'  class='tblbrdr' >";
		$qry ="LEFT OUTER JOIN tblmkupy ON (tbkmkupy.KDKMKTBKMK = tblmkupy.KDMKTBLMK) WHERE
  tbkmkupy.IDKURTBKMK = '$kur' AND tbkmkupy.SEMESTBKMK IN $semester";	     
		$MySQL->Select("tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NODOSTBKMK,tbkmkupy.NMDOSTBKMK","tbkmkupy",$qry,"tbkmkupy.SEMESTBKMK,tbkmkupy.KDKMKTBKMK ASC","","0");
	    $total=$MySQL->Num_Rows();
	    $perpage=$_REQUEST['limit'];
	    $totalpage=ceil($total/$perpage);
	    $start=($_GET['pos']-1)*$perpage;	
		$MySQL->Select("tbkmkupy.IDX,tbkmkupy.KDKMKTBKMK,tblmkupy.NAMKTBLMK,tbkmkupy.SKSMKTBKMK,tbkmkupy.SEMESTBKMK,tbkmkupy.NODOSTBKMK,tbkmkupy.NMDOSTBKMK","tbkmkupy",$qry,"tbkmkupy.SEMESTBKMK,tbkmkupy.KDKMKTBKMK ASC","$start,$perpage");
	    echo "<tr><th colspan='6' style='background-color:#EEE'>Daftar Matakuliah Kurikulum '".$kurikulum."' Program Studi '".$namaprodi."'</th></tr>";
	    echo "<tr>
	    <th style='width:20px;'>ACT</th>
	    <th style='width:100px;'>KODE MK</th> 
	    <th>MATAKULIAH</th> 
	    <th style='width:50px;'>SKS</th> 
	    <th style='width:50px;'>SEM</th>
	    <th style='width:300px;'>DOSEN PENGAMPU</th> 	     
	    </tr>";	
	    $no=1;
	 	if ($MySQL->Num_Rows() > 0){
	    	while ($show=$MySQL->Fetch_Array()){
		    	echo "<tr>";
				$sel="";
				if ($no % 2 == 1) $sel="sel"; 
		     	echo "<td class='tac $sel fs11'>";
				echo "<input type='checkbox' class='cbx' name='id_mk_arr[".$show['IDX']."]' />";
		     	echo "</td>";
		     	echo "<td class='$sel'>".$show['KDKMKTBKMK']."</td>";
		     	echo "<td class='$sel'>".$show['NAMKTBLMK']."</td>";
		    	echo "<td class='$sel tac'>".$show['SKSMKTBKMK']."</td>";
		    	echo "<td class='$sel tac'>".$show['SEMESTBKMK']."</td>";
		    	echo "<td class='$sel'>".$show['NODOSTBKMK']." - ".$show['NMDOSTBKMK']."</td>";
		     	echo "</tr>";
		        $no++;
		    }
		} else {
			echo "<tr><td align='center' style='color:red;' colspan='6'>".$msg_data_empty."</td></tr>";
		}
		echo "<tr><td colspan='6'  class='tal'>";
		echo "<br>&nbsp;&nbsp;<input type='checkbox' class='cbx' onclick='flipflop(this.form,this)' /> Check/UnCheck All&nbsp;&nbsp;<button type='submit' name='submit' value='Submit' />Proses&nbsp;<img src='images/b_go.png' class='btn_img'></button>";
		echo "</td></tr>";
	    echo "</table>";
		echo "</form>";
}
?>