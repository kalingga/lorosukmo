<?php
$idpage='24';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if (isset($_POST['submit'])){
	$edtDaftar=substr(strip_tags($_POST['edtDaftar']),0,25);
	$edtPassword=substr(strip_tags($_POST['edtPassword']),0,20);
	if (($edtDaftar != "" )&& ($edtPassword!="")){
		$MySQL->Select("PSUJITBPMB","tbpmbupy","where NODTRTBPMB='".$edtDaftar."'","","1",0);
			//echo $MySQL->qry;
		$show=$MySQL->Fetch_Array();
		$act_log="Akses User='".$edtDaftar."' Pada Tabel 'tbpmbupy' File 'pmbonline.php' ";
		if ($MySQL->Num_Rows()==0) {
			$err=1; //user tidak ditemukan
			echo $msg_not_akses;
		} else {
			echo "<p class='m5 p5 tac fs14'>";
			echo "<b>Selamat Datang di Sistem Ujian Online<br>";
			echo "Universitas PGRI Yogyakarta</b><br>";
			echo "<p class='m5 p5 tac fs11'>Klik Button Dibawan Ini Untuk Mengaksesnya Untuk Mengaksesnya<br>";
			echo "</p>";
		 	echo "<div style='text-align:center;'><button type='button' onClick=window.open('www.upy.intersat.net.id/index.php?Fuse=ujian_home.main')><img src='images/b_login.png' class='btn_img'/>&nbsp;UJIAN ONLINE</button></div>";
		}
		if ($err>0) $act_log=$act_log." Gagal!"; else $act_log=$act_log." Sukses!";
		if (empty($id)) $id=-1;
		AddLog($id,$act_log);
		return $err;
	}
	} else {
		echo "<p class='m5 p5 tac fs14'>";
		echo "<b>Masukkan No Pendaftaran dan Password Anda Jika Akan Mengikuti Test Seleksi PMB Online?<b>";
		echo "</p>";
	?>
		<form method="post" action="./?page=ujianpmbonline">
		<br>
			<div style="text-align:center;">No Pendaftaran :</div>
			<div style="text-align:center;"><input type="text" name="edtDaftar" style="width:150px;" value="" maxlength="25" /></div>
			<div style="text-align:center;">Password :</div>
			<div style="text-align:center;"><input type="password" name="edtPassword" style="width:150px;" value="" maxlength="20"/></div>
			<div style="text-align:center; margin:5px 0 0 0">
			<button type="submit" name="submit" value="submit"><img src="images/b_login.png" align="absmiddle"/>&nbsp;Login</button></div>
		</form>
	<?php
	}	
	?>
	<div style="text-align:center; -moz-opacity:0.1;">
	<img alt='gambar' style="margin:width:250px; height:250px; filter:alpha(opacity=10);"  src="<?php echo $_SESSION[$PREFIX.'LGPTIMSPTI']; ?>" border="0" />
	</div>
<?php
}
?>