<html>
<head>
<link rel="stylesheet" href="<?=base_url();?>css/ui/jquery.ui.all.css">
<style>
table tr td{
font-family:Tahoma;
font-size : 80%;
padding-top: 2px;
padding-bottom: 2px;
border-bottom: dotted 1px; 
}

form {
font-family:Tahoma;
font-size : 80%;
}
</style>

<script type="text/javascript" src="<?=base_url();?>js/jquery-1.5.1.min.js"></script>	
<script src="<?=base_url();?>js/jqui/jquery.ui.core.js"></script>       
<script src="<?=base_url();?>js/jqui/jquery.ui.datepicker.js"></script>
<script src="<?=base_url();?>js/jqui/lang/jquery.ui.datepicker-id.js"></script>      
<link rel="stylesheet" href="<?=base_url();?>js/jqui/jquery-ui-1.8.14.custom.css">

<script>
	$(function() {
		$( "#tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd"
		});
	});
	  
	
	</script>
	
	<script>
	function showRuang(){
	 //alert('OKE');
   $("#idmaster").html('<img src="<?=base_url();?>images/ajax-loader.gif"/>');
   $.post('<?=base_url();?>schujian/showruang', $("form").serialize(), function(hasil){
   $("#idmaster").html(hasil);
   });
   
   $("#idmaster2").html('<img src="<?=base_url();?>images/ajax-loader.gif"/>');
   $.post('<?=base_url();?>schujian/showruang2', $("form").serialize(), function(hasil){
   $("#idmaster2").html(hasil);
   });
   
   $("#idmaster3").html('<img src="<?=base_url();?>images/ajax-loader.gif"/>');
   $.post('<?=base_url();?>schujian/showruang3', $("form").serialize(), function(hasil){
   $("#idmaster3").html(hasil);
   });
   
   cekKelas();
  }
  
  function cekKelas(){
	 
   $("#warning").html(' ');
   
   $.post('<?=base_url();?>schujian/cekKelas', $("form").serialize(), function(hasil){   
   $("#warning").html(hasil);
   //alert(hasil);
   if(hasil == "1"){
      $("#warning").html('Jadwal kelas tumbukan!');
      $("#simpan").attr('disabled','disabled');
   }else{
      $("#warning").html('');
      $("#simpan").removeAttr('disabled');
   }
   
   });
  }

  </script>

</head>
<body>

<div>
<?
$id = "";
$prodi = "";
$matkul = "";
$kelas = "";
$jenis = "";
$dosen = "";
$ruang = "";
$hari = "";
$tanggal = "";
$waktu = "";
$durasi = "";


foreach($detailUjian->result() as $row){
  $id = $row->ID;   
  $prodi = $row->KDPSTUTSUAS;                              
  $matkul = $row->NAMKTBLMK;
  $kelas = $row->KELASUTSUAS;
  $jenis = $row->JENISUTSUAS;
  $dosen = $row->NMDOSMKSAJI;       // HRPELUTSUAS,
  $ruang = $row->ruangNama; 
  $durasi = $row->DURSIUTSUAS;
  $tanggal = $row->TGPELUTSUAS;
  $waktu = $row->WKPELUTSUAS;
   
}

//echo $prodi;
$this->session->set_userdata('prodi_ujian', $prodi);

?>
<br><br>
<form name="form1" action="<?=base_url();?>schujian/save" method="post" enctype="multipart/form-data" >
			<input type="hidden" name="edtID" value="<?=$id?>" />
			<table align="center" style="width:70%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan="2">FORM EDIT DATA JADWAL UJIAN</th></tr>
			<tr><th colspan="2">&nbsp;</th></tr>
			<tr><td style="width:250px;">Matakuliah</td>
			 <td> : 
<?=$matkul;?>			 </td>
			</tr>
			<tr>		
			 <td>Kelas</td>
			 <td>: 
<?=$kelas;?>		 </td>
			</tr>		
			<tr>		
			 <td>Dosen Penguji</td>
			 <td>:  <?=$dosen;?></td>
			</tr>		
			<tr>		
			 <td>Jenis Ujian</td>
			 <td>: 
<select name='cbJenis' id='cbJenis' >  
  <option value='UTS' <? if($jenis == "UTS") echo "selected"?> >UTS</option>
  <option value='UAS' <? if($jenis == "UAS") echo "selected"?> >UAS</option>
</select>			</td>
			</tr>		
		
		  	<tr>
		    	<td>Tanggal Pelaksanaan</td>
		    	<td>: 
				<input type="text" name="edtTgl" id="tgl" size="10"  maxlength="10" value="<?=$tanggal;?>" readonly/> 
	 			
				</td>
			</tr>
			<tr>
			 <td>Waktu</td>
			 <td>: <input type="text" name="edtWaktu" size="5"  maxlength="5" value="<?=substr($waktu,0,5);?>" onBlur="showRuang();" /> [hh:mm] 
           <span id="warning"> </span></td>
			</tr>
			<tr>
			 <td>Durasi</td>
			 <td>: <input type="text" name="edtDurasi" size="3"  maxlength="3" value="<?=$durasi;?>" onBlur="showRuang();" /> dalam menit</td>
			</tr>
			<tr>
			 <td>Ruang 1</td>
			 <td>: <span id="idmaster" style="xfloat:left;"> </span></td>
			</tr>
			<tr>
			 <td>Ruang 2</td>
			 <td>: <span id="idmaster2" style="xfloat:left;"> </span></td>
			</tr>
			
			<tr>
			 <td>Ruang 3</td>
			 <td>: <span id="idmaster3" style="xfloat:left;"> </span></td>
			</tr>
 
  </table>
  </div>
  
   <div style="text-align:center">
  <input type="submit" name="Submit" value="Simpan" id="simpan" disabled>
  </div>
</form>

</body>
</html>