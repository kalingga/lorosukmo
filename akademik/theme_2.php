<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!*********************************************************************
*****	Dengan Nama Allah Yang Maha Pengasih Lagi Maha Penyanyang	*****    
*****																*****
*****	Application_Name : Sistem Informasi Akademik				*****
*****	Application_Type : WEB Based Application					*****
*****	Product_Date     : 15 Januari 2008							*****
*****	Outhor           : M. Abdul Rachman F.						*****
*****	E-mail           : abdulr4ch@yahoo.com						*****
*****	Customer_Name    : Universitas PGRI Yogyakarta				*****
*****																*****
***********************************************************************!>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $appname; ?></title>
<script type="text/javascript" src="include/menu/dtree.js"></script>
<script type="text/javascript" src="include/function.js"></script>
<script type="text/javascript" src="include/calendar/ts_picker.js"></script>
<script type="text/javascript" src="include/calendar/injection_graph_func.js"></script>
<link href="include/style.css" rel="stylesheet" type="text/css" />
<link href="include/menu/dtree.css" rel="stylesheet" type="text/css" />
<link href="theme_2/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var html_banner= new String (
	"<table border='1' cellpadding='3' cellspacing='0' style='width:100%; margin:2px auto; overflow:scroll' >"+
	"<tr>"+
		"<td>"+
		"<img src='<?php echo $_SESSION[$PREFIX.'logo_instansi']; ?>' width='90' height='90' border='0' align='left' style='margin-right:10px;' />"+
		"<div class='fs15 fwb'><?php echo $_SESSION[$PREFIX.'lembaga_instansi']; ?></div>"+
		"<div class='fs22 fwb' style='padding:5px 0;'><?php echo $_SESSION[$PREFIX.'nama_aplikasi']; ?></div>"+
		"<div class='fs11 fwb'><?php echo $_SESSION[$PREFIX.'alamat_instansi']; ?></div>"+
		"</td>"+
	"</tr>"+
	"</table>"
)
var html_sign= new String (
	"<table border='0' cellpadding='3' cellspacing='0' style='width:100%; margin:2px auto; overflow:scroll' >"+
	"<tr>"+
		"<td>"+
		"<div class='tac fwb p10' style='width:250px; float:right;'>"+
		"<?php echo $_SESSION[$PREFIX.'kabupaten_instansi'].", ".FormatDateTime(time(),2); ?>"+
		"<br />"+
		"<?php echo $_SESSION[$PREFIX.'title_penandatangan']; ?>"+
		"<br />"+
		"<?php echo $_SESSION[$PREFIX.'lembaga_instansi']; ?>"+
		"<br /><br /><br /><br />"+
		"<span class='tdu'><?php echo $_SESSION[$PREFIX.'nama_penandatangan']; ?></span>"+
		"<br />"+
		"NIP : <?php echo $_SESSION[$PREFIX.'nip_penandatangan']; ?>"+
		"</div>"+
		"</td>"+
	"</tr>"+
	"</table>"
		);
</script>
</head>
<body>
<div id="ticker"><div id="ticker_text" class="fl" style="width:95%"><marquee truespeed="truespeed" scrolldelay="1000">SISTEM INFORMASI KEPEGAWAIAN - UNIVERSITAS PGRI YOGYAKARTA</marquee></div><input type="image" src="theme_1/btn_close.png" onclick="GetId('ticker').style.display='none'" class="fr" style="margin:2px" /></div>
<div id="outer">
<div id="body">
	<div id="banner">
	<table border="0" style="width:99%; margin:5px auto;" cellpadding="0" cellspacing="0">
	<tr>
		<td style="width:120px;" class="tac" valign="middle">
		<img src="<?php echo $_SESSION[$PREFIX.'logo_instansi']; ?>" width="90" height="90" border="0" />
		</td>
		<td>
			<div class="fs15 fwb"><?php echo $_SESSION[$PREFIX.'lembaga_instansi']; ?></div>
			<div class="fs22 fwb" style="padding:5px 0;"><?php echo $_SESSION[$PREFIX.'nama_aplikasi']; ?></div>
			<div class="fs11 fwb"><?php echo $_SESSION[$PREFIX.'alamat_instansi']; ?></div>
		</td>
	</tr>
	</table>
	</div>
	<div id="head">
		<div id="texthead">
		<div id="form_search">
	<?php
	if (isset($_SESSION[$PREFIX.'user_admin'])){
		  echo "<form action='./?page=pencarian_pegawai&amp;subpage=print' method='post' >";
		  echo "Pencarian Pegawai : <select name='field'>";
		  $field=$_REQUEST['field'];
		  $sel="";
		  if ($field=='nip_pegawai') $sel="selected='selected'";
		  echo "<option value='nip_pegawai' $sel >NIP</option>";
		  $sel="";
		  if ($field=='nama_pegawai') $sel="selected='selected'";
		  echo "<option value='nama_pegawai' $sel >NAMA</option>";
		  echo "</select>&nbsp;\n";
		  echo "<input type='text' name='kwd' value='".$_REQUEST['kwd']."' />&nbsp;\n";
		  echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>&nbsp;\n";
		  echo "</form>";
	}
	?>
		</div>
		<div id="currDate"></div>
		</div>
	</div>
	<div id="main">
		<?php
		if (isset($_SESSION[$PREFIX.'user_admin'])){
		?>
		<div id="sidebar">		
			<div class="panel">
				<div class="headpanel">
					<div>MAIN MENU</div>
				</div>
				<div class="mainpanel">
					<?php
					include "menu.php";			
					?>	
                </div>
				<div class="footpanel"></div>
			</div>		
			
			<div class="panel">
				<div class="headpanel">
				<div>WEB INFO</div>
				</div>
				<div class="tac fwb mainpanel">
				<?php echo "Server : ".$serverStatus; ?><br />
				<?php echo "Database : ".$dbStatus; ?><br />
				</div>
				<div class="footpanel"></div>
			</div>
		</div>
		<div id="page">
		<?php
		if (!isset($_GET['page'])) $_GET['page']="home";
		$page=$_GET['page'].".php";
		if (!file_exists($page)) $page="unknown.php";
		include $page;
		?>
		</div>
		<div class="free"></div>
		<?php
		}
		else{
		?>
			<div class="panel" style="width:202px; margin:20px auto;">
				<div class="headpanel">
					<div>LOGIN</div>
				</div>
				<div class="mainpanel">
				<?php
					include "form_login.php";
				?>	
				</div>
				<div class="footpanel"></div>
			</div>
		<?php
		}
		?>
	</div>
	<div id="foot">
		<div id="textfoot"></div>
	</div>
	<div id="footer">
		<div id="textfooter">
		Copyright &copy; 2008 - UNIVERSITAS PGRI YOGYAKARTA - All Rights Reserved
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
GetDate();
setTimeout("DeleteMessage()",5000)
</script>
</body>
</html>
