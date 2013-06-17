<html>
<head>
<link rel="stylesheet" href="<?=base_url();?>css/ui/jquery.ui.all.css">
<style>
body{
font-family:Tahoma;
font-size:100%;
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
</style>

</head>
<body>
<h1 style="font-family:Tahoma; text-align:center; font-size:130%">Informasi Penggunaan Ruang</h1>
<?
foreach($info->result() as $row){
?>
<table width="500" border="1">
  <tr>
    <td>Prodi</td>
    <td><?=$row->NMPSTMSPST;?></td>
  </tr>
  <tr>
    <td>Mata Kuliah </td>
    <td><?=$row->NAMKTBLMK;?></td> 
  </tr>
  <tr>
    <td>Dosen</td>
    <td><?=$row->NMDOSMKSAJI." (".$row->NODOSMKSAJI.")";?></td>       
  </tr>
  
  <tr>
    <td>Kelas</td>
    <td><?=$row->KELASMKSAJI;?></td>
  </tr>
  <tr>
    <td>Semester</td>
    <td><?=$row->SEMESMKSAJI;?></td>
  </tr>
</table>
<?
}
?>
</body>
</html>