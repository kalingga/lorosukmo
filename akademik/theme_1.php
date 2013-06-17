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
<script type="text/javascript" src="include/menu/dtree.js"></script>
<script type="text/javascript" src="include/calendar/injection_graph_func.js"></script>
<script type="text/javascript" src="include/menu/chromejs/chrome.js"></script>
<script type="text/javascript" src="include/menuajax.js"></script>
<script type="text/javascript" src="include/fadecontent/jquery-1.2.2.pack.js"></script>
<script type="text/javascript" src="include/fadecontent/contentfader.js"></script>

<script type="text/javascript" src="include/jqui/jquery-1.5.1.min.js"></script>	
<script type="text/javascript" src="include/fancybox/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="include/jqui/jquery.ui.core.js"></script>       
<script src="include/jqui/jquery.ui.datepicker.js"></script>
<script src="include/jqui/lang/jquery.ui.datepicker-id.js"></script>      
<link rel="stylesheet" href="include/jqui/jquery-ui-1.8.14.custom.css">

  	<script type="text/javascript">
		$(document).ready(function() {

			$(".fancy").fancybox({
				'width'				: '85%',
				'height'			: '87%',
				'autoScale'			: true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',				
				'type'				: 'iframe',
				'onClosed' : function() {
           parent.location.reload(true);
        }
				
			});
			
			$(".fancy2").fancybox({
				'width'				: '100%',
				'height'			: '80%',
				'autoScale'			: true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',				
				'type'				: 'iframe'
				
			});
			
		});

	</script>

	<script>
	$(function() {
		$( "#tglLulus" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd MM yy"
		});
	});
	</script>
	
	<script>
	$(function() {
		$( "#tglWisuda" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd MM yy"
		});
	});
	</script>
	
	<script>
	$(function() {
		$( "#tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});
	</script>

<script type="text/javascript" src="include/menu/ddtabmenu.js">
/***********************************************
Menu Utama
***********************************************/
</script>
<?php
//$calendar = new DHTML_Calendar('./include/jscalendar/', 'id', 'calendar-system', false);
//$calendar->load_files();
?>
<script type="text/javascript">
//SYNTAX: ddtabmenu.definemenu("tab_menu_id", integer OR "auto")
ddtabmenu.definemenu("ddtabs4",1)//initialize Tab Menu #4 with 3rd tab selected
var html_banner= new String (
	"<table border='1' cellpadding='3' cellspacing='0' style='width:100%; margin:2px auto; overflow:scroll' >"+
	"<tr>"+
		"<td>"+
		"<img src='images/logo69.png' width='90' height='90' border='0' align='left' style='margin-right:10px;' />"+
		"<div class='fs15 fwb'><?php echo $_SESSION[$PREFIX.'NMPTIMSPTI'] ?></div>"+
		"<div class='fs22 fwb' style='padding:5px 0;'>SISTEM INFORMASI AKADEMIK</div>"+
		"<div class='fs11 fwb'><?php echo $_SESSION[$PREFIX.'ALMT1MSPTI']." ".$_SESSION[$PREFIX.'ALMT2MSPTI']." ".$_SESSION[$PREFIX.'KOTAAMSPTI']." Telp. ".$_SESSION[$PREFIX.'TELPOMSPTI']." Fax. ".$_SESSION[$PREFIX.'FAKSIMSPTI']; ?></div>"+
		"</td>"+
	"</tr>"+
	"</table>"
)
</script>
<link href="include/style.css" rel="stylesheet" type="text/css" >
<link href="theme_1/style.css" rel="stylesheet" type="text/css" >
<link href="include/jsval.css" rel="stylesheet" type="text/css"  >
<link href="include/menu/dtree.css" rel="stylesheet" type="text/css" >
<link href="include/menu/ddcolortabs.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" type="text/css" href="include/menu/chrometheme/chromestyle.css">
<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
<script language="javascript" src="include/jsval.js"></script>
<script language="javascript">
<!--
    function initValidation()
    {
        var objForm = document.forms["form1"];
        objForm.edtKode.required = 1;
        objForm.edtKode.regexp = /^\w*$/;
        objForm.edtKode.realname = "Kode";
 
        objForm.edtNama.required = 1;
        objForm.edtNama.regexp = /^\w/;
        objForm.edtNama.realname = "Nama";
        
        objForm.edtSKS.regexp = /^\d*$/;
        objForm.edtSKS.realname = "SKS";

        objForm.edtTahun.regexp = /^\d*$/;
        objForm.edtTahun.realname = "Tahun";
        
        objForm.cbFakultas.required = 1;
        objForm.cbFakultas.exclude = '-1';
        objForm.cbFakultas.err = 'Pilih Salah Satu dari Daftar Fakultas yang Ada!';

        objForm.cbStatus.required = 1;
        objForm.cbStatus.exclude = '-1';
        objForm.cbStatus.err = 'Pilih Salah Satu dari Daftar Status yang Ada!';

        objForm.cbKelompok.required = 1;
        objForm.cbKelompok.exclude = '-1';
        objForm.cbKelompok.err = 'Pilih Salah Satu dari Daftar Kelompok yang Ada!';

        objForm.edtEmail.regexp = "JSVAL_RX_EMAIL";        
        objForm.edtEmail.realname = "Email";        

        objForm.edtTelp.regexp = "JSVAL_RX_TEL";        
        objForm.edtTelp.realname = "Telepon";        

        objForm.edtFax.regexp = "JSVAL_RX_TEL";        
        objForm.edtFax.realname = "Faksimile";        

        objForm.edtHP.regexp = "JSVAL_RX_TEL";        
        objForm.edtHP.realname = "Telepon";        

        objForm.edtHP1.regexp = "JSVAL_RX_TEL";        
        objForm.edtHP1.realname = "Telepon";
    }
//-->
</script>
</head>
<body onLoad="initValidation()">
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
	<tr><td class="fs11 fwb">&nbsp;</td></tr>
	<tr>
		<td colspan="2" scope="row">
<?php
		include "menu.php";
?>
		</td></tr>
	</table>
	</div>
	<div id="main">
		<?php
		if (!isset($_SESSION[$PREFIX.'user_admin'])) {
			/*** Jika user belum login atau user tidak berhasil login atau user logout =>tampilkan sidebar**/
			include "sidebar.php";
		}
		/******************* Info User Login *******************/
			include "userdetail.php";
		/******************* end info user login *******************/
		?>
	</div>
<?php			
		//******************* Halaman Utama *******************
		$style="page";
		if (isset($_SESSION[$PREFIX.'user_admin'])) $style="page2";
		echo "<div id='$style'>";
		if (!isset($_GET['page'])) $_GET['page']="home";
/*		echo "<div class='fs11 tdu fwb' style='margin-bottom:10px;'>&raquo; ".strtoupper($_GET['page'])." PAGE</div>";*/
		if (($_GET['p'])!=""){
			switch ($p) {
				case "add": $p="&raquo Tambah Data";
				case "edit": $p="&raquo Edit Data";
				case "view": $p="&raquo Lihat Data";				
			}
		}
		
		$page=htmlentities($_GET['page']);
		if((substr($page,0,1) == "<") OR (substr($page,0,1) == ".")){
      			exit();            
		}

		switch ($page) {
			case "dikti"   : $title_head = "perguruan tinggi";
							 break;
			case "datapt"   : $title_head = "master perguruan tinggi";
							 break;
			case "dataprodi"   : $title_head = "master program studi";
							 break;
			case "prodi"   : $title_head = "program studi";
							 break;
			case "aplikasi"   : $title_head = "kode aplikasi";
							 break;
			case "propinsi"   : $title_head = "kode propinsi";
							 break;
			case "daftarmahasiswa"   : $title_head = "data mahasiswa";
							 break;
			case "isiandatamahasiswa"   : $title_head = "isian data mahasiswa";
							 break;
			case "dosenpa"   : $title_head = "pembimbing akademik";
							 break;
			case "tabelnilai" : $title_head = "tabel nilai";
							 break;
			case "mksaji" : $title_head = "matakuliah saji";
							 break;
			case "daftarcmb" : $title_head = "daftar calon mahasiswa";
							 break;
			case "seleksicmb" : $title_head = "seleksi calon mahasiswa baru";
							 break;
			case "jadwalutsuas" : $title_head = "jadwal uts/uas";
							 break;
			case "isianhs" : $title_head = "Nilai Akhir";
							 break;
			case "konversinilai" : $title_head = "konversi nilai mahasiswa pindahan";
							 break;
			case "hasilstudi" : $title_head = "hasil studi mahasiswa";
							 break;
			case "jadwalmk" : $title_head = "jadwal perkuliahan";
							 break;
			case "jadwalkrs" : $title_head = "masa pengisian krs";
							 break;
			case "rekappmb" : $title_head = "rekap data pmb";
							 break;
			case "akta_mengajar" : $title_head = "Akta Mengajar";
							 break;
			case "transkrip_resmi" : $title_head = "Transkrip Resmi";
							 break;
			case "isiankrs" : $title_head = "Pengisian KRS";
							 break;
			default        : $title_head = "";
		}
		echo "<div id='headpage'>".$title_head." ".$p."</div>";

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
		Copyright &copy; 2008 - 2011. <br/>Hasanah Media - PPTIK. All Rights Reserved</div>
	</div>
</div>
</div>
</body>
</html>
