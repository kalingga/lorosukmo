<?php
$info="";
$style="page";
if (isset($_SESSION[$PREFIX.'user_admin'])) {
	$style="page2";
	$info = "<div class='taj' style='float:left;'>
			
			Selamat Datang 
      <span class='fwb'>".$_SESSION[$PREFIX.'nama_admin']." [".$_SESSION[$PREFIX.'user_admin']."],&nbsp;&nbsp;
      <img src='images/b_admin.png' align='absmiddle'/> ".$_SESSION[$PREFIX.'nama_group']."
      </span>
			<span style='padding-left: 0px'>";
      
			
}
	echo "<div id='$style' >";
?>
	<div id='headpage'>USER DETAIL</div>
	<div id="currDate">
	<script type="text/javascript">
	GetDate();
	var time2=setTimeout("DeleteMessage()",5000)
	</script>
	</div>
<?php
	echo $info;
	echo "</span></div>";
	if($_SESSION[$PREFIX.'id_group'] == "2"){
    include "view_krs.php";
  }else if($_SESSION[$PREFIX.'user_admin'] != "" ){
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='button' onClick=window.location.href='?act=logout' value='Log Out' 
          style='width:60px; padding:2px 0 2px 0; margin-top:-2px; font-weight:bold;'>
                <br />";
  }

if($_SESSION[$PREFIX.'id_group'] == "8"){
	/*echo "<br><div style='text-align:center; background-color: yellow; border: dotted 1px; font-size:140%;'>";
	echo "Berhubung Tanggal 9 Juni 2012 ada acara Senam Massal Peringatan Alih Bentuk UPY,<br>
	maka ujian hanya sampai shift 2</div>";*/
  }
?>
</div>
