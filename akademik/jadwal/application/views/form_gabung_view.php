<html>
<head>
<link rel="stylesheet" href="<?=base_url();?>css/ui/jquery.ui.all.css">
<style>
table tr td{
font-family:Tahoma;
font-size : 80%;
padding-top: 0px;
padding-bottom: 0px;
border-bottom: dotted 1px; 
}

form {
font-family:Tahoma;
font-size : 80%;
}
</style>

</head>
<body>
<h1 style="font-family:Tahoma; text-align:center; font-size:110%">Gabung Kelas</h1>
<form action="<?=base_url();?>sch/setGabungan" method="post" name="form_kelas" id="form_kelas">
  <table width="200" border="0" style="margin:auto;">
    <tr>
      <td>Kelas I</td>
      <td><input type="text" name="kelas1" style="width:45px;"></td>
    </tr>
    <tr>
      <td>Kelas II</td>
      <td><input type="text" name="kelas2" style="width:45px;"></td>
    </tr>
    <tr>
      <td>Kelas III</td>
      <td><input type="text" name="kelas3" style="width:45px;"></td>
    </tr>

  </table>        
  <br>
  <div style="text-align:center">
  <input type="submit" name="Submit" value=" OK ">
  </div>
</form>

</body>
</html>