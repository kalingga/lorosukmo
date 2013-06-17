<div id="page">		
	<div id='headpage'>USER DETAIL</div>
	<div id="currDate">
	<script type="text/javascript">
	GetDate();
	var time2=setTimeout("DeleteMessage()",5000)
	</script>
	</div>
<?php
	echo "<div class='taj'>";
	echo "<div class='taj'>";
	echo "Selamat Datang <span class='fwb'>".$_SESSION[$PREFIX.'nama']." [".$_SESSION[$PREFIX.'user']."],&nbsp;&nbsp;<img src='images/b_admin.png' align='absmiddle'/>".$_SESSION[$PREFIX.'groupop']."</span>";
	echo ("<span style='padding-left: 20px'><button type='button' onClick=window.location.href='?a=logout'><img src='images/trash.png' align='absmiddle'/>&nbsp;Logout</button></span>");
	echo "</div>";
	echo "</div>";
?>
</div>
