<html>
<head>
<link rel="stylesheet" href="<?=base_url();?>css/ui/jquery.ui.all.css">
<script type="text/javascript" src="<?=base_url();?>js/jquery-1.5.1.min.js"></script>	
<script type="text/javascript" src="<?=base_url();?>js/fancybox/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

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

<script type="text/javascript">
		$(document).ready(function() {

			$(".fancy").fancybox({
				'width'				: '70%',
				'height'			: '60%',
				'autoScale'			: true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',				
				'type'				: 'iframe'
				
			});
			
		});

	</script>


</head>
<body>
<h1 style="font-size:120%">Pilih Ruang</h1>

  <div style="width:300px; margin:auto;">
  <?
  if($status == "edit"){
    $link = "sch/edit/".$this->session->userdata('manual_id');
  }else{
    $link = "sch/pilihManual";
  }
  ?>
  
  <form method="post" action="<?=base_url().$link;?>">
  <b>Nama Ruang :</b> <input type="text" name="namaruang" value="<?=$this->session->userdata('filter_ruang');?>" style="height:18px;">
  <input type="submit" name="search_form" value="Cari"> 
  </form>
  </div> 
</div>

<br />
<div style="width:600px; margin:autox;">
<div style="height:20px; font-weight:bold; border: solid 1px brown; width:180px; background-color:#aaa; background-repeat:repeat-x; background-image:url(<?=base_url();?>images/btn5.jpg); float:left; text-align:center; padding-top:3px;">

<?
if($this->session->userdata('manual_edit') == 1){
echo '<a class="jadwal" class="blanc" style="color:#222;" href="'.base_url().'sch/updatenull">Simpan Tanpa Jadwal</a>';
}else{
echo '<a class="jadwal" class="blanc" style="color:#222;" href="'.base_url().'sch/savenull">Simpan Tanpa Jadwal</a>';
}
?>
</div>
</div>

<?
echo "<div style='width:300px; margin:auto; text-align:center;padding-bottom:2px;' >";
if($pagination <> ""){
  echo "Halaman : ".$pagination;
}else{
  echo "<br><br><br>";	
}
echo "</div>";                     
              
echo "<div style='width:400px; margin:auto; float:left; position:fixed; z-index:1001;'>";
echo $tabel;
echo "</div>";                                             


?>             
<div style="width:200px; float:right; border:dotted 1px #333; position:relative; font-size:85%;">
  <span style="font-weight:bold;">Keterangan :</span> 
  <div style="width:200px; margin:auto;"><div style="height:16px; width:12px; background-color:red; float:left;">&nbsp;</div>&nbsp;Ruang Terpakai</div><br>
  <div style="width:200px; margin:auto;"><div style="height:16px; width:12px; background-color:blue; float:left;">&nbsp;</div>&nbsp;Kelas ada jadwal</div><br>
  <div style="width:200px; margin:auto;"><div style="height:16px; width:12px; background-color:black; float:left;">&nbsp;</div>&nbsp;Dosen sedang mengajar</div><br>
  <div style="width:200px; margin:auto;"><div style="height:16px; width:12px; background-color:#A2F520; float:left;">&nbsp;</div>&nbsp;Jadwal dapat dipilih</div>
  &nbsp;&nbsp;&nbsp;(satu kotak mewakili 1 sks)  
</div>
</body>
</html>