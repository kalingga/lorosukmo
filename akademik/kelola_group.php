<?php
$id_page=$_SESSION[$PREFIX."81"];
if (!isset($_SESSION[$PREFIX.'user_admin'])) {
	echo "<div class='diverr m5 p5 tac'>";
	echo "MAAF!, Akses Ditolak, Anda Harus Login Dahulu!";
	echo "</div>";
}	
else{
	echo "<div id='headpage'> KELOLA GROUP </div>";
	if (!isset($_GET['subpage'])) $_GET['subpage']='add';
?>

<?php
if ($_GET['subpage']=='add' and $hak_akses[($id_page+1)]==1){
	$succ=0;
   if (isset($_POST['add_group'])){
      $nama_group=substr(strip_tags($_POST['nama_group']),0,25);
	  $keterangan_group=substr(strip_tags($_POST['keterangan_group']),0,225);
      $sm_count=$_POST['sm_count'];
	  $sm_hak_akses_arr=$_POST['hak_akses_arr'];
	  for ($i=0;$i<=$sm_count;$i++){
		if ($sm_hak_akses_arr[$i]=='on'){
			if (!empty($hak_akses_group) or $hak_akses_group=='0') $hak_akses_group.=",1"; else $hak_akses_group="1";
		}
		else{
			if (!empty($hak_akses_group) or $hak_akses_group=='0') $hak_akses_group.=",0"; else $hak_akses_group="0";
		}
	  }
      $MySQL->Insert("tb_group","","'','$nama_group', '$hak_akses_group', '$keterangan_group'");
      if ($MySQL->exe){
         $succ=1;
      }
      if ($succ==1){
         $act_log="Penambahan Nama='$nama_group' Pada Tabel 'tb_group' File 'kelola_group.php' Sukses";
         AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
         echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
         echo "Data Berhasil Ditambahkan!";
         echo "</div>";
      }
      else{
         $act_log="Penambahan ID='$id_group' Pada Tabel 'tb_group' File 'kelola_group.php' Gagal";
         AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
         echo "<div id='msg_err' class='diverr m5 p5 tac'>";
         echo "Maaf!, Tambah Data Gagal! Pastikan Data Yang Anda Masukkan Benar";
         echo "</div>";
      }
   }
?>
<form name="form1" action="./?page=kelola_group&amp;subpage=add" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
   <table style="width:95%" border="0" cellpadding="1" cellspacing="1">
   <tr>
      <th colspan="3">Form Tambah Data</th>
   </tr>
   <tr>
      <td style="width:150px;" >Nama </td>
      <td>:</td>
      <td>
         <input type="text" name="nama_group" size="20" maxlength="25" />
      </td>
   </tr>
   <tr>
      <td>Hak Akses </td>
      <td>:</td>
      <td>
	  <?php
	  	$hak_akses_group="1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0";
		$sm_hak_akses=explode(",",$hak_akses_group);
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
			while($show1=$MySQL->Fetch_Array()){
				if ($show1[status]==1)
					echo "da.add($show1[id],$id0,'".$show1[name]."');\n";
				$id1=$show1[id];
				$MySQL2->Select("*","tb_menu2","where pid=$id1");
				while($show2=$MySQL2->Fetch_Array()){
					$hak_akses_id++;
					$check="";
					if ($sm_hak_akses[$hak_akses_id]=='1') $check='checked="checked"';
					if ($show2[status]==1)
						echo "da.add($show2[id],$id1,'"."<input name=\"hak_akses_arr[$hak_akses_id]\" class=\"cbx\" type=\"checkbox\" name=\"\" $check /> ".$show2[name]."');\n";
					$lastmenu="hak_akses_arr[$hak_akses_id]";
					$id2=$show2[id];
					$MySQL3->Select("*","tb_menu3","where pid=$id2");
					while($show3=$MySQL3->Fetch_Array()){
						$hak_akses_id++;
						$check="";
						if ($sm_hak_akses[$hak_akses_id]=='1') $check='checked="checked"';
						if ($show3[status]==1)
							echo "da.add($show3[id],$id2,'"."<input onclick=\"checkmenu(this.form, this,\'$lastmenu\')\" name=\"hak_akses_arr[$hak_akses_id]\" style=\"font-size:8px\" class=\"cbx\" type=\"checkbox\" name=\"\" $check /> ".$show3[name]."');\n";
					}
				}
			}
			?>						
			document.write(da); 
		//-->
		</script>
		<p></p>
		<input type='checkbox' onclick='flipflop(this.form,this)' /> Check/UnCheck All
		<?php
		echo "<input type='hidden' name='sm_count' value='$hak_akses_id' />\n";
	  ?>	
      </td>
   </tr>
   <tr>
      <td>Keterangan </td>
      <td>:</td>
      <td>
         <input type="text" name="keterangan_group" size="50" maxlength="255" />
      </td>
   </tr>
   <tr>
       <td colspan="3">
       <button type="submit" name="add_group"><img src="images/b_save.gif" class="btn_img"/> Simpan</button>
       <button type="reset"><img src="images/b_reset.gif" class="btn_img"/> Reset</button>
       </td>
   </tr>
   </table>
   </form>
<?php
}
?>


<?php
if ($_GET['subpage']=='edit' and $hak_akses[($id_page+2)]==1){
   $succ=0;
   if (isset($_POST['edit_group'])){
      	$id_group=$_POST['id_group'];
		$nama_group=substr(strip_tags($_POST['nama_group']),0,25);
	  	$keterangan_group=substr(strip_tags($_POST['keterangan_group']),0,225);
		$sm_count=$_POST['sm_count'];
		$sm_hak_akses_arr=$_POST['hak_akses_arr'];
		for ($i=0;$i<=$sm_count;$i++){
			if ($sm_hak_akses_arr[$i]=='on'){
				if (!empty($hak_akses_group) or $hak_akses_group=='0') $hak_akses_group.=",1"; else $hak_akses_group="1";
			}
			else{
				if (!empty($hak_akses_group) or $hak_akses_group=='0') $hak_akses_group.=",0"; else $hak_akses_group="0";
			}
		}
		$qry="";
		if ($_SESSION[$PREFIX.'id_group']!=0) $qry=" and id_group<>0";
		$MySQL->Update("tb_group","nama_group='".$nama_group."', hak_akses_group='".$hak_akses_group."', keterangan_group='".$keterangan_group."' ","WHERE id_group=$id_group ".$qry,"1");
		if ($MySQL->exe){
			$act_log="Update ID='$id_group' Pada Tabel 'tb_goup' File 'kelola_group.php' Sukses";
			AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
			echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
			echo "Data Berhasil Disimpan!";
			echo "</div>";
		}
		else{
			$act_log="Update ID='$id_group' Pada Tabel 'tb_goup' File 'kelola_group.php' Gagal";
			AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
			echo "<div id='msg_err' class='diverr m5 p5 tac'>";
			echo "Data Gagal Disimpan!";
			echo "</div>";
		}
		$_GET['id_group']=$_POST['id_group'];
	  ?>
		<script type="text/javascript">
		function back_page(){
			history.go(-2);
		}
		setTimeout("back_page()",1500);
		</script>
	  <?php
   }
   if (isset($_GET['id_group'])) {
   	  $qry="";
	  if ($_SESSION[$PREFIX.'id_group']!=0) $qry=" and id_group<>0";
      $MySQL->Select("*","tb_group","where id_group=".$_GET['id_group'].$qry,"","1");
      $show=$MySQL->Fetch_Array();
	  $id_group=$show['id_group'];
	  $nama_group=$show['nama_group'];
	  $keterangan_group=$show['keterangan_group'];
	  $hak_akses_group=$show['hak_akses_group'];
	  $sm_hak_akses=explode(",",$hak_akses_group);
      ?>
      <form name="form1" action="./?page=kelola_group&amp;subpage=edit" method="post" enctype="multipart/form-data" onsubmit="return ValidateForm(this)">
      <input type="hidden" name="id_group" value="<?php echo $id_group ?>" />
      <table style="width:95%" border="0" cellpadding="1" cellspacing="1">
      <tr>
         <th colspan="3">Form Update Data</th>
      </tr>
	  <tr>
      	<td style="width:150px;" >Nama </td>
      	<td>:</td>
      	<td>
         <input type="text" name="nama_group" size="20" maxlength="25" value="<?php echo $nama_group; ?>" />
      	</td>
  	  </tr>
      <tr>
         <td>Hak Akses</td>
         <td>:</td>
         <td>
			<script type="text/javascript">
			<!--
				var PATH_MENU="include/menu/";
				da = new dTree('da');
				da.add(0,-1,'HOME');
				<?php
				$id0=0;
				$MySQL->Select("*","tb_menu1","");
				$hak_akses_id=-1;
				while($show1=$MySQL->Fetch_Array()){
					if ($show1[status]==1)
						echo "da.add($show1[id],$id0,'".$show1[name]."');\n";
					$id1=$show1[id];
					$MySQL2->Select("*","tb_menu2","where pid=$id1");
					while($show2=$MySQL2->Fetch_Array()){
						$hak_akses_id++;
						$check="";
						if ($sm_hak_akses[$hak_akses_id]=='1') $check='checked="checked"';
						if ($show2[status]==1)
							echo "da.add($show2[id],$id1,'"."<input name=\"hak_akses_arr[$hak_akses_id]\" class=\"cbx\" type=\"checkbox\" name=\"\" $check /> ".$show2[name]."');\n";
						$lastmenu="hak_akses_arr[$hak_akses_id]";
						$id2=$show2[id];
						$MySQL3->Select("*","tb_menu3","where pid=$id2");
						while($show3=$MySQL3->Fetch_Array()){
							$hak_akses_id++;
							$check="";
							if ($sm_hak_akses[$hak_akses_id]=='1') $check='checked="checked"';
							if ($show3[status]==1)
								echo "da.add($show3[id],$id2,'"."<input onclick=\"checkmenu(this.form, this,\'$lastmenu\')\" name=\"hak_akses_arr[$hak_akses_id]\" style=\"font-size:8px\" class=\"cbx\" type=\"checkbox\" name=\"\" $check /> ".$show3[name]."');\n";
						}
					}
				}
				?>						
				document.write(da); 
			//-->
			</script>
			<p></p>
			
			<input type='checkbox' onclick='flipflop(this.form,this)' /> Check/UnCheck All
         </td>
      </tr>
	  <tr>
      	<td style="width:150px;" >Keterangan </td>
      	<td>:</td>
      	<td>
         <input type="text" name="keterangan_group" size="50" maxlength="255" value="<?php echo $keterangan_group; ?>" />
      	</td>
  	  </tr>
     <tr>
         <td colspan="3">
		<input type='hidden' name='sm_count' value='<? echo $hak_akses_id; ?>' />
       <button type="submit" name="edit_group"><img src="images/b_save.gif" class="btn_img"/> Simpan</button>
       <button type="button" onclick="history.back()"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
         </td>
      </tr>
      </table>
      </form>
   <?php
   }
   else{
   	  if ($_SESSION[$PREFIX.'id_group']!=0) $qry="WHERE id_group<>0";
      $MySQL->Select("*","tb_group",$qry," id_group ASC");
      echo "<table border='0' style='width:100%; margin:10px auto; overflow:scroll' class='tblbrdr' >";
      echo "<tr><th colspan='5' style='background-color:#EEE'>Daftar Group</th> </tr>";
      echo "<tr>
      <th style='width:30px;'>NO</th> 
      <th style='width:75px;'>ID GROUP</th> 
      <th style='width:150px;'> NAMA GROUP</th> 
	  <th> KETERANGAN GROUP</th> 
      <th style='width:20px;'>ACT</th> 
      </tr>";
      $no=$start;
      while ($show=$MySQL->Fetch_Array()){
        echo "<tr>";
        $sel="";
        if ($no % 2 == 1) $sel="sel";
        echo "<td class='$sel'>".++$no."</td>";
        echo "<td class='$sel'>".$show['id_group']."</td>";
        echo "<td class='$sel'>".$show['nama_group']."</td>";
		 echo "<td class='$sel'>".$show['keterangan_group']."</td>";
        echo "<td class='$sel tac'>";
        echo "<a href='./?page=kelola_group&amp;subpage=edit&amp;id_group=".$show['id_group']."'>
        <img border='0' src='images/b_edit.png' title='EDIT DATA' />
        </a> ";
        echo "</td>";
        echo "</tr>";
     }
     echo "</table>";
   }
}
?>

<?php
if ($_GET['subpage']=='del' and $hak_akses[($id_page+3)]==1){
 if ($_GET['act']=='del'){
  $id_group=$_GET['id_group']; 
  $MySQL->Delete("tb_group","where id_group=".$id_group,"1");
  if ($MySQL->exe){
    $act_log="Hapus ID='$id_group' Pada Tabel 'tb_group' File 'kelola_group.php' Sukses";
    AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    echo "<div id='msg_err' class='divsucc m5 p5 tac'>";
    echo "Data Berhasil Dihapus!";
    echo "</div>";
  }
  else{
   $act_log="Hapus ID='$id_group' Pada Tabel 'tb_group' File 'kelola_group.php' Gagal";
    AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    echo "<div id='msg_err' class='diverr m5 p5 tac'>";
    echo "Data Gagal Dihapus!";
    echo "</div>";
  }
 }

  	  if ($_SESSION[$PREFIX.'id_group']!=0) $qry="WHERE id_group<>0";
      $MySQL->Select("*","tb_group",$qry," id_group ASC");
      echo "<table border='0' style='width:100%; margin:10px auto; overflow:scroll' class='tblbrdr' >";
      echo "<tr><th colspan='5' style='background-color:#EEE'>Daftar Group</th> </tr>";
      echo "<tr>
      <th style='width:30px;'>NO</th> 
      <th style='width:75px;'>ID GROUP</th> 
      <th style='width:150px;'> NAMA GROUP</th> 
	  <th> KETERANGAN GROUP</th> 
      <th style='width:20px;'>ACT</th> 
      </tr>";
      $no=$start;
      while ($show=$MySQL->Fetch_Array()){
        echo "<tr>";
        $sel="";
        if ($no % 2 == 1) $sel="sel";
        echo "<td class='$sel'>".++$no."</td>";
        echo "<td class='$sel'>".$show['id_group']."</td>";
        echo "<td class='$sel'>".$show['nama_group']."</td>";
		 echo "<td class='$sel'>".$show['keterangan_group']."</td>";
        echo "<td class='$sel tac'>";
		echo "<a href='./?page=kelola_group&amp;subpage=del&amp;id_group=".$show['id_group']."&amp;act=del' onclick=\"return confirm('Apakah Data Ini Benar Mau Dihapus?')\" >
<img border='0' src='images/b_drop.png' title='HAPUS DATA' />
</a>";
        echo "</td>";
        echo "</tr>";
     }
     echo "</table>";
}
?>

<?php
if ($_GET['subpage']=='print' and $hak_akses[($id_page+4)]==1){
	echo "THIS MODUL IS UNDERCONSTRUCTION";
}
?>

<?php
}
?>
