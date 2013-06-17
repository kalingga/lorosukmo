<html>
<head>
<link rel="stylesheet" href="<?=base_url();?>css/ui/jquery.ui.all.css">
<style>
body{
font-family:Tahoma;
font-size:90%;
}
table, table tr, table td{
font-family:Tahoma;
font-size : 90%;
padding-top: 2px;
padding-bottom: 2px;
border-collapse:collapse; 
border-color:#000;
margin:auto;
}

form {
font-family:Tahoma;
font-size : 80%;
}

h1{
font-family:Tahoma;
font-size : 100%;
text-align:center;
}

a{
color:#EF8609;
border : none;
font-size : 90%;
text-decoration:none;
}

.pagination{
color:#EF8609;
border : solid 1px #ddd;
font-size : 90%;
text-decoration:none;
padding:2px;
}

.jadwal{
border : none;
}

</style>

</head>
<body>
<h1>Daftar Penggunaan Ruang</h1>
  <div style="width:300px; margin:auto;">
  <form method="post" action="<?=base_url();?>ruang">
  <b>Nama Ruang :</b> <input type="text" name="namaruang" value="<?=$this->session->userdata('filter_ruang');?>" style="height:18px;">
  <input type="submit" name="search_form" value="Cari"> 
  </form>
  </div>
<?
echo "<div style='width:600px; margin:auto;'>";
if($pagination <> ""){
  echo "Halaman : ".$pagination;
}else{
  echo "<br><br>";	
}
echo "</div>";

echo "<div style='width:600px; margin:auto;'>";
echo $tabel;
echo "</div>";

/*
echo "<div style='width:600px; margin:auto;'>";
echo "Halaman :".$pagination;
echo "</div>";
*/
?> 
</body>
</html>