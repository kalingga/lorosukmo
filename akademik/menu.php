	<div class="chromestyle" id="chromemenu">
	<ul>
		<li><a href="index.php">Home</a></li>
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
		$MySQL->Select("*","tb_menu1","","id ASC","");
		while ($show=$MySQL->Fetch_Array()){
			$menu++;
			if ($hak_akses_arr[$menu] == '1'){	
				echo "<li><a href='' rel='$show[id]'><span>$show[name]</span></a></li>";		
			}
			$pid[$menu]=$show['id'];
		}
?>
	</ul>
	</div>

<?php
	$submenu=-1;
	for ($i=0;$i <= $menu; $i++){
		echo "<div id='$pid[$i]' class='dropmenudiv'>";
		$MySQL->Select("*","tb_menu2"," where pid='$pid[$i]'","id ASC");
		while($show=$MySQL->Fetch_Array()){
			$page=$show['page']-1;
			if ($sm_akses_arr[$page] == '1') {	
				echo "<a href='$show[url]' rel='$show[pid]'>$show[name]</a>";
			}
		}
		echo "</div>";
	}
?>

	<script type="text/javascript">
	cssdropdown.startchrome("chromemenu")
	</script>