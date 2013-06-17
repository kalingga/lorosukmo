<?php
$idpage='1';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	$id_admin=$_SESSION[$PREFIX.'id_admin'];	
	$user_admin= $_SESSION[$PREFIX.'user_admin'];
	//************** Simpan Data ***********************
	//if ($_GET['subpage']=='edit' and $hak_akses[($id_page+2)]==1){
	$succ=0;
	if (isset($_POST['submit'])){
		/***** jika p= add => insert***/
  		$edtNama=substr(strip_tags($_POST['edtNama']),0,30);
  		$count_menu_admin=$_POST['count_menu_admin'];
  		$menu_admin="0";
  		for ($i=1;$i < $count_menu_admin;$i++){
			//set menu admin;
			$menu_admin .=",0";
		}
//		echo $menu_admin;
		$menu_admin=@explode(",",$menu_admin);
  		$sm_count=$_POST['sm_count'];
	  	$hak_akses_arr=$_POST['hak_akses_arr'];
	  	$sm_akses="";
	  	for ($i=0;$i <= $sm_count;$i++){
	  		$MySQL->Select("tb_menu2.pid","tb_menu2","where tb_menu2.page='".($i+1)."'","1");
	  		$show=$MySQL->Fetch_Array();
	  		$getpid=($show['pid']-1);
			if ($i == $sm_count){
				if ($hak_akses_arr[$i]=='on'){				
					$sm_akses .="1";
					$menu_admin[$getpid]="1";
				} else {
					$sm_akses .="0";
				}
			} else {
				if ($hak_akses_arr[$i]=='on'){					
					$sm_akses .="1,";
					$menu_admin[$getpid]="1";					
				} else {
					$sm_akses .="0,";
				}
			}
	  	}

//		for ($i=0;$i < $count_menu_admin;$i++){
			//set menu admin;
			$menu_admin = $menu_admin[0].",".$menu_admin[1].",".$menu_admin[2].",".$menu_admin[3].",".$menu_admin[4].",".$menu_admin[5].",".$menu_admin[6].",".$menu_admin[7].",".$menu_admin[8].",".$menu_admin[9];
//		}
	  	
		if ($_POST['submit']=='Simpan'){
  			$MySQL->Insert("groupop","NMGROUPOP,HKGROUPOP,SMGROUPOP","'$edtNama','$menu_admin','$sm_akses'");
		   	$act_log="Tambah Data Pada Tabel 'groupop' File 'groupuser.php' ";
		   	$msg=$msg_insert_data;
		} else {
  		//***** jika p= update => update***/;
   			$edtID=substr(strip_tags($_POST['edtID']),0,5);
  			$MySQL->Update("groupop","NMGROUPOP='$edtNama',HKGROUPOP='$menu_admin',SMGROUPOP='$sm_akses'","where IDGROUPOP=".$edtID,"1");
		   	$act_log="Update ID='$edtID' Pada Tabel 'groupop' File 'groupuser.php' ";
		   	$msg=$msg_edit_data;
  		}
  		if ($MySQL->exe){
			$succ=1;
		}
  		if ($succ==1){
  			$act_log .= "Sukses!";
		   	AddLog($id_admin,$act_log);
		    echo $msg;
  		} else{
  			$act_log .= "Gagal!";
		    AddLog($id_admin,$act_log);
		    echo $msg_update_0;
  		}
	}
	
	if (isset($_GET['p']) && ($_GET['p']=='edit')){
	/*********** Tampilkan Form Edit*************/
		if(!empty($_GET['id'])) {
			$MySQL->Select("*","groupop","where IDGROUPOP=".$_GET['id']."","","1");
			$show=$MySQL->Fetch_Array();
			$edtID=$show["IDGROUPOP"];
			$edtNama=$show["NMGROUPOP"];
//			$menu_admin=$show["HKGROUPOP"];
			$hak_akses_admin=$show["SMGROUPOP"];
			$hak_akses_admin=@explode(",",$hak_akses_admin);
?>
			<form name="form1" action="./?page=groupuser" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
<?php
			echo "<input type='hidden' name='edtID' value='".$edtID."' />";
			echo "<table style='width:95%' border='0' cellpadding='1' cellspacing='1'>";
			echo "<tr>";
			echo "<th colspan='2'>Form Edit Data Group User</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='2' align='center'>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
 			echo "<td style='width:100px;' >Group User</td>";
?>
 			<td class='mandatory'>: <input size='50' type='text' name='edtNama' id='edtNama' maxlength='50' value="<?php echo $edtNama; ?>" ></td>
 <?php
 			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='2' align='center'>&nbsp;</td>";
			echo "</tr>";
   			echo "<tr>";
      		echo "<td>Hak Akses</td>";
      		echo "<td>:</td>";
    		echo "<tr><td>&nbsp;</td>";
    		echo "<td>";
//			$MySQL->Select("*","groupop","WHERE IDGROUPOP =".$id);
//			$show=$MySQL->Fetch_Array();
//			$sm_id=$show['IDGROUPOP'];
//			$sm_user=$show['user_admin'];
//			$sm_hak_akses=explode(",",$show['SMGROUPOP']);			
//			echo "<input type='hidden' name='sm_id' value='$sm_id' />\n";
		?>
		<script type="text/javascript">
		<!--
			var PATH_MENU="include/menu/";
			da = new dTree('da');
			da.add(0,-1,'HOME');
			<?php
			$id0=0;
			$MySQL->Select("*","tb_menu1","","id ASC");
			$hak_akses_id=-1;
			$count_menu_admin=0;
			while($show1=$MySQL->Fetch_Array()){
				$count_menu_admin++;
				if ($show1[status]==1)
					echo "da.add($show1[id],$id0,'".$show1[name]."');\n";
				$id1=$show1[id];
				$MySQL2->Select("*","tb_menu2","where pid=$id1","id ASC");
				while($show2=$MySQL2->Fetch_Array()){
					$hak_akses_id++;
					$idmenu=$show2[id]+1000;
					$check='';
					if ($hak_akses_admin[$hak_akses_id]=='1') $check='checked="checked"';
					if ($show2[status]==1)
						echo "da.add($idmenu,$id1,'"."<input name=\"hak_akses_arr[$hak_akses_id]\" class=\"cbx\" type=\"checkbox\" $check /> ".$show2[name]."');\n";
					$lastmenu="hak_akses_arr[$hak_akses_id]";
				}
			}
			?>						
				document.write(da); 
			//-->
			</script>
			<p></p>
			<input type='checkbox' class='cbx' onclick='flipflop(this.form,this)' /> Check/UnCheck All
<?php
			echo "<div align='center'>";
			echo "<input type='hidden' name='sm_count' value='$hak_akses_id' />\n";	  
			echo "<input type='hidden' name='count_menu_admin' value='$count_menu_admin' />\n";	  
	  		echo "</td></tr>";
 			echo "<tr><td>&nbsp;</td>";
   			echo "<tr><td colspan='2' align='center'>";
       		echo "<button type='reset' onclick=window.location.href='./?page=groupuser'><img src='images/b_cancel.gif' class='btn_img'/> Batal</button>&nbsp;";
  			echo "<button type='submit' name='submit' value='Update'><img src='images/b_save.gif' class='btn_img'/> Update</button>
	   		</td>
</td></tr>";
   			echo "</table>";
			echo "</form><br>";
		}
	}
	
	if (isset($_GET['p']) && ($_GET['p']=='add')){
	/*********** Tampilkan Form Tambah *************/
?>
			<form name="form1" action="./?page=groupuser" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
<?php
			echo "<table style='width:95%' border='0' cellpadding='1' cellspacing='1'>";
			echo "<tr>";
			echo "<th colspan='2'>Form Tambah Data Group User</th>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='2' align='center'>&nbsp;</td>";
			echo "</tr>";
			echo "<tr>";
 			echo "<td style='width:100px;' >Group User</td>";
?>
 			<td class='mandatory'>: <input size='50' type='text' name='edtNama' id='edtNama' maxlength='50' value="<?php echo $edtNama; ?>" ></td>
 <?php
 			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='2' align='center'>&nbsp;</td>";
			echo "</tr>";
   			echo "<tr>";
      		echo "<td>Hak Akses</td>";
      		echo "<td>:</td>";
    		echo "<tr><td>&nbsp;</td>";
    		echo "<td>";
//			$MySQL->Select("*","groupop","WHERE IDGROUPOP =".$id);
//			$show=$MySQL->Fetch_Array();
//			$sm_id=$show['IDGROUPOP'];
//			$sm_user=$show['user_admin'];
//			$sm_hak_akses=explode(",",$show['SMGROUPOP']);			
//			echo "<input type='hidden' name='sm_id' value='$sm_id' />\n";
		?>
		<script type="text/javascript">
		<!--
			var PATH_MENU="include/menu/";
			da = new dTree('da');
			da.add(0,-1,'HOME');
			<?php
			$id0=0;
			$MySQL->Select("*","tb_menu1","");
			$hak_akses_id=-1;
			$count_menu_admin=0;
			while($show1=$MySQL->Fetch_Array()){
				$count_menu_admin++;
				if ($show1[status]==1)
					echo "da.add($show1[id],$id0,'".$show1[name]."');\n";
				$id1=$show1[id];
				$MySQL2->Select("*","tb_menu2","where pid=$id1","ID ASC");
				while($show2=$MySQL2->Fetch_Array()){
					$hak_akses_id++;
					$idmenu=$show2[id]+1000;
					$check='';
					if ($hak_akses_admin[$hak_akses_id]=='1') $check='checked="checked"';
					if ($show2[status]==1)
						echo "da.add($idmenu,$id1,'"."<input name=\"hak_akses_arr[$hak_akses_id]\" class=\"cbx\" type=\"checkbox\" $check /> ".$show2[name]."');\n";
					$lastmenu="hak_akses_arr[$hak_akses_id]";
				}
			}
			?>						
				document.write(da); 
			//-->
			</script>
			<p></p>
			<input type='checkbox' class='cbx' onclick='flipflop(this.form,this)' /> Check/UnCheck All
<?php
			echo "<div align='center'>";
			echo "<input type='hidden' name='sm_count' value='$hak_akses_id' />\n";	  
			echo "<input type='hidden' name='count_menu_admin' value='$count_menu_admin' />\n";	  
	  		echo "</td></tr>";
 			echo "<tr><td>&nbsp;</td>";
   			echo "<tr><td colspan='2' align='center'>";
       		echo "<button type='reset' onclick=window.location.href='./?page=groupuser'><img src='images/b_cancel.gif' class='btn_img'/> Batal</button>&nbsp;";
  			echo "<button type='submit' name='submit' value='Simpan'><img src='images/b_save.gif' class='btn_img'/> Simpan</button>
	   		</td>
</td></tr>";
   			echo "</table>";
			echo "</form><br>";
		}

		if (isset($_GET['p']) && ($_GET['p']=='delete')) {
			$id=$_GET['id']; 
			$MySQL->Delete("groupop","where IDGROUPOP=".$id,"1");
			if ($MySQL->exe){
				$act_log="Hapus ID='$id' Pada Tabel 'groupop' File 'groupuser.php' Sukses";
				AddLog($id_admin,$act_log);
		    	echo $msg_delete_data;
			} else {
			   	$act_log="Hapus ID='$id' Pada Tabel 'groupop' File 'groupuser.php' Gagal";
				AddLog($id_admin,$act_log);
		    	echo $msg_delete_data_0;
			}
		}		

echo "<table border='0' style='width:100%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
;
	 echo "<tr><td colspan='4'><button type=\"button\" style='tar' onClick=window.location.href='./?page=groupuser&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
     echo "<tr><th colspan='4' style='background-color:#EEE'>Daftar Group User</th></tr>";
     echo "<tr>
     <th style='width:50px;'>NO</th> 
     <th style='width:700px;'>GROUP USER</th> 
     <th style='width:20px;' colspan='2'>ACT</th> 
     </tr>";
     $MySQL->Select("*","groupop","WHERE IDGROUPOP <> '0'","IDGROUPOP ASC","","0");
     $no=1;
     while ($show=$MySQL->Fetch_Array()){
     	$sel="";
		if ($no % 2 == 1) $sel="sel";     	
     	echo "<tr>";
     	echo "<td class='$sel tac'>".$no."</td>";
     	echo "<td class='$sel'>".$show['NMGROUPOP']."</td>";
     	echo "<td class='$sel tac'>";
   // 	if (($_SESSION[$PREFIX.'id_group'])!='0'){
    //		if ($show[IDGROUPOP]!='1'){
		   		echo "<a href='./?page=".$_GET['page']."&amp;p=edit&amp;id=".$show['IDGROUPOP']."'>
		     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
		     	</a> ";
	//		} else{
	//	   		echo "<img border='0' src='images/ico_check.png' title='DEFAULT' />";	
	//		}
	//	} else {
	//	   	echo "<a href='./?page=".$_GET['page']."&amp;p=edit&amp;id=".$show['IDGROUPOP']."'>
	//	     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
	//	     	</a>";			
	//	}
     	echo "<td class='$sel tac'>";
		if ($show[IDGROUPOP] > '5'){
		   		echo "<a href='./?page=groupuser&amp;p=delete&amp;id=".$show['IDGROUPOP']."'>
	     	<img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/>
	     	</a> ";
		} else {
	   		echo "<img border='0' src='images/ico_check.png' title='DEFAULT' />";			
		}
     	echo "</td>";		
     	echo "</td>";
     	echo "</tr>";
     	$no++;
     }
     echo "</table>";
}
?>

