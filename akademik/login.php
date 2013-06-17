<div>LOGIN</div>
</div>
<div class="mainpanel">
<form method="post" action="">
<br>
<div class="content">Username :</div>
<div class="content"><input type="text" name="user" style="width:150px;" value="" maxlength="25" /></div>
<div class="content">Password :</div>
<div class="content"><input type="password" name="pass" style="width:150px;" value="" maxlength="20"/></div>
<div style="text-align:center; margin:5px 0 0 0">
<button type="submit" name="login_admin"><img src="images/b_login.png" align="absmiddle"/>&nbsp;Login</button>
</div>
</form>
<?php
if ($login_result > 0){
	echo "<div id='msg_err' class='diverr tac p5 m5' margin:0 auto;'>";
	if ($login_result==1) echo "USERNAME TIDAK DITEMUKAN!!";
	if ($login_result==2) echo "PASSWORD ANDA SALAH!!";
	echo "</div>";
}
?>
</div>