<?php
session_start();
//SETTING MYSQL DATABASE
$mysql_host="110.76.147.35";
$mysql_user="akademik";
$mysql_password="akademikupyoke2009secure";
$mysql_database="akademikupy";

$mysql_host1="110.76.147.35";
$mysql_user1="akademik";
$mysql_password1="akademikupyoke2009secure";
$mysql_database1="simpeg";

if (!isset($pos)) $pos="";
include($pos.'./include/mysql.class.php');
include($pos.'./include/calendar/Date.class.php');
include($pos.'./include/calendar/Time.class.php');
include($pos.'./include/connect.php');
include($pos.'./include/function.php');

$PATH="akademik"; //$PATH="";
$THEME="1";
$msg_not_akses="<div class='diverr m5 p5 tac'>MAAF!, Akses Anda Ditolak!</div>";
$msg_data_empty="Tidak Ada Data yang Ditampilkan";
$msg_insert_data="<div id='msg_err' class='divsucc m5 p5 tac'>Data Berhasil Ditambahkan!</div>";
$msg_edit_data="<div id='msg_err' class='divsucc m5 p5 tac'>Data Berhasil Diupdate!</div>";
$msg_delete_data="<div id='msg_err' class='divsucc m5 p5 tac'>Data Berhasil Dihapus!</div>";

$msg_update_0="<div id='msg_err' class='diverr m5 p5 tac'> Maaf!, Update Data Gagal! Pastikan Data Yang Anda Masukkan Benar</div>";
$msg_delete_data_0="<div id='msg_err' class='diverr m5 p5 tac'>Data Gagal Dihapus!</div>";
$msg_delete_data_jadwal="<div id='msg_err' style='background-color:yellow;' class='diverr m5 p5 tac'>Data Gagal Dihapus! Karena kelas telah diambil mahasiswa</div>";

//$info='';
//Prefix SESSION
$PREFIX="upy.ac.idakademik"; //$_SERVER['HTTP_HOST'].$PATH;
//echo $PREFIX;
//ini_set('error_reporting', E_ALL);
$datetimeServer=date("Y-n-j H:i:s");
$dateServer=date("Y-n-j");
include($pos.'./include/prepare.php');
?>
