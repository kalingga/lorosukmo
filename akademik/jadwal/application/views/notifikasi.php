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
padding-top: 3px;
padding-bottom: 3px;
border-collapse:collapse; 
border-color:#666;
margin:auto;
}

form {
font-family:Tahoma;
font-size : 80%;
}

a{
color:#EF8609;
border : none;
font-size : 90%;
text-decoration:none;
}
</style>

</head>
<body>
<h1 style="font-family:Tahoma; text-align:center; font-size:110%;">Informasi</h1>
<br><br>
<div style="margin:auto; width:450px; background-color: yellow;  text-align:center;">
<?=$warning;?>
</div>
<br><br>
<div style="margin:auto; width:400px; padding:3px; text-align:center;" > 
<a style=" border: solid 1px #aaa; padding:3px;" href="<?=base_url();?>sch/pilihManual"> kembali </a>
</div>
</body>
</html>