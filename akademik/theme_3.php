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
<title>SISTEM INFORMASI AKADEMIK</title>
<script type="text/javascript" src="include/function.js"></script>
<script type="text/javascript" src="include/calendar/ts_picker.js"></script>
<script type="text/javascript" src="include/calendar/injection_graph_func.js"></script>
<link href="include/style.css" rel="stylesheet" type="text/css" />
<link href="theme_1/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="include/menu/ddtabmenu.js">
/***********************************************
Menu Utama
***********************************************/
</script>
<link rel="stylesheet" type="text/css" href="include/menu/ddcolortabs.css" />
<link rel="stylesheet" type="text/css" href="ddtabmenufiles/solidblocksmenu.css" />
<script type="text/javascript">
//SYNTAX: ddtabmenu.definemenu("tab_menu_id", integer OR "auto")
ddtabmenu.definemenu("ddtabs4", 1) //initialize Tab Menu #4 with 3rd tab selected
</script>
<script LANGUAGE="JavaScript">
/************** function go histori ******************/
function goHist(a) 
{
	history.go(a);      
}
/*************** emd function go histori *************/
</script>
</head>
<body>
<div id="ticker"><div id="ticker_text" class="fl" style="width:95%"><marquee truespeed="truespeed" scrolldelay="1000">SISTEM INFORMASI AKADEMIK :: <?php echo $_SESSION[$PREFIX.'NMPTIMSPTI']; ?></marquee></div><input type="image" src="theme_1/btn_close.png" onclick="GetId('ticker').style.display='none'" class="fr" style="margin:2px" /></div>
<div id="outer">
<div id="body">
	<div id="banner">
	<table border="0" style="width:99%; margin:5px auto;" cellpadding="0" cellspacing="0">
	<tr><td><img src="<?php echo $_SESSION[$PREFIX.'LGPTIMSPTI']; ?>" width="90" height="91" border="0" /></td>
		<td><div class="fs15 fwb"><?php echo $_SESSION[$PREFIX.'NMPTIMSPTI']; ?></div>
		<div class="fs22 fwb" style="padding:5px 0;">SISTEM INFORMASI AKADEMIK</div>
		<div class="fs11 fwb"><?php echo $_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI'] ?></div></td>
	</tr>
	<tr><td class="fs11 fwb">&nbsp</td></tr>
	<tr>
		<td colspan="2" scope="row">
<?php
		include "menu.php";
?>
		</td></tr>
	</table>
	</div>
	<br>
	<div id="main">
		<?php
/*		if (isset($_SESSION[$PREFIX.'user_admin'])){
		<div id="sidebar">		
			<div class="panel">
				<div class="headpanel">
					<div>MAIN MENU</div>
				</div>
				<div class="mainpanel">
				<?php
				//	include "menu.php";			
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
		}
		else{*/
			include "sidebar.php";
//		}
		?>		
			<?php
			//if (isset($_SESSION[$PREFIX.'user_member']))
			{
			?>
			<?php
			}
			?>
		<!******************* Info User Login *******************>
<?php
				include "userdetail.php";
?>			
		<!******************* end info user login *******************>
		</div>
		<!******************* Halaman Utama *******************>
		<div id="page">
<?php				
		if (!isset($_GET['page'])) $_GET['page']="kalender";
/*		echo "<div class='fs11 tdu fwb' style='margin-bottom:10px;'>&raquo; ".strtoupper($_GET['page'])." PAGE</div>";*/
		echo "<div id='headpage'>".$_GET['page']."</div>";

		$page=$_GET['page'].".php";
		if (!file_exists($page)) $page="unknown.php";
		include $page;
?>
		</div>
		<!******************* end halaman utama *******************>		
		<div class="free"></div>
	</div>
	<div id="foot">
		<div id="textfoot" class=""></div>
	</div>
	<div id="footer">
		<div id="textfooter">
		Copyright &copy; 2008. <a href="http://hasanahmedia.com">HASANAH MEDIA</a>. All Rights Reserved</div>
	</div>
</div>
</div>
</body>
</html>
