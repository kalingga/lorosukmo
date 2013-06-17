<div id="ddtabs4" class="ddcolortabs">
	<ul>
		<li><a href="./"><span>Home</span></a></li>
<?php
		if (!isset($_SESSION[$PREFIX.'user_admin'])){
			$MySQL->Select("HKGROUPOP,SMGROUPOP","groupop","where IDGROUPOP='6'","","1");
			$show=$MySQL->fetch_array();
			$_SESSION[$PREFIX.'id_group']="6";
			$_SESSION[$PREFIX.'hak_akses_admin']=$show['HKGROUPOP'];
			$_SESSION[$PREFIX.'sm_akses_admin']=$show['SMGROUPOP'];
		}
		/**** tampilkan menu sesuai group user *******/
		$hak_akses_arr=explode(",",$_SESSION[$PREFIX.'hak_akses_admin']);
		$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
		$menu=-1;
		$MySQL->Select("*","tb_menu1","","","");
		while ($show=$MySQL->Fetch_Array()){
			$menu++;
			if ($hak_akses_arr[$menu] == '1'){	
				echo "<li><a href='' rel='$show[id]'><span>$show[name]</span></a></li>";		
			}
			$pid[$menu]=$show[id];
		}
?>

	</ul>
</div>

<div class="ddcolortabsline">&nbsp;</div>
<!****** Mencari sub menu ****************>
<div class="tabcontainer">
<?php
	$submenu=-1;
	for ($i=0;$i <= $menu; $i++){
		echo "<div id='$pid[$i]' class='tabcontent'>";
		echo "<div class='chromestyle' id='chromemenu'>";
		echo "<ul>";
		echo "<b>Daftar Menu&nbsp;&raquo</b>";
		$MySQL->Select("*","tb_menu2"," where pid='$pid[$i]'","id ASC");
		while($show=$MySQL->Fetch_Array()){
			$page=$show['page']-1;
			if ($sm_akses_arr[$page] == '1') {	
				echo "<li><a href='$show[url]' rel='$show[pid]'>$show[name]</a><li>";
			}
		}
		echo "</ul>";
		echo "</div>";
		echo "</div>";
	}
?>
</div>