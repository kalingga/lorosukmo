<html>
<head>
<link rel="stylesheet" href="<?=base_url();?>css/ui/jquery.ui.all.css">
<script type="text/javascript" src="<?=base_url();?>js/jquery-1.5.1.min.js"></script>	
<script type="text/javascript" src="<?=base_url();?>js/fancybox/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

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

<script type="text/javascript">
		$(document).ready(function() {

			$(".fancy").fancybox({
				'width'				: '50%',
				'height'			: '60%',
				'autoScale'			: true,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',				
				'type'				: 'iframe',
				'onClosed' : function() { 
				   $.post("<?=base_url();?>getsession", {q: "gk"}, function(data){
          				if(data.length >0) {
                      $("#kelas").attr('value',data);	
                      //$("#simpan").attr('disabled','disabled');				
          				}
          			});
        }
				
			});
			
		});

</script>

</head>
<body>
<br>
<h1 style="font-family:Tahoma; text-align:center; font-size:130%">Ubah Data Kelas</h1>
<br><br>
<form action="<?=base_url();?>sch/create" method="post" name="form_kelas" id="form_kelas">
  <table width="500" border="0" style="margin:auto;">
    <tr>
      <td>Matakuliah</td>
      <td>
      <input type="hidden" name="matkul" value="<?=$this->session->userdata('manual_matkul');?>">
      <select name="matkulx" style="width:325px;" disabled=disabled>
      <?
      foreach($listMatkul->result() as $mk){
        if($mk->KODE == $this->session->userdata('manual_matkul')){
            $sel = "selected";    
        }else{
            $sel = "";
        }
        echo "<option $sel value='$mk->KODE'>$mk->NAMA</option>";
      
      } 
      ?>
      </select>
      </td>
    </tr>
    <tr>
      <td>Dosen</td>
      <td>
      <select name="dosen" id="dosen" style="width:325px;">
      <?
      foreach($listDosen->result() as $row){
        if($row->nidn == $this->session->userdata('manual_nodos')){
            $sl = "selected";
        }else{
            $sl = "";
        }
        echo "<option $sl value='$row->nidn # $row->nama_pegawai'>$row->nama_pegawai, ".str_replace("|",",",$row->gelar_akademik_pegawai)." - $row->nidn</option>";
      
      } 
      ?>
      </select></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td><input name="kelas" type="text" id="kelas" size="10" value="<?=$this->session->userdata('manual_kelas')?>">
      &nbsp;&nbsp; <i>jika kelas gabungan, pisahkan dengan koma</i>
      </td>
    </tr>
    <tr>
      <td>Kapasitas</td>
      <td><input name="kapasitas" type="text" size="2" maxlength="3" value="<?=$this->session->userdata('manual_kapasitas')?>"></td>
    </tr>
     <tr>
      <td>Durasi/sks </td>
      <td><select name="durasi">
      <option value="50">50 menit</option>
      <option value="40">40 menit</option>
      <option value="30">30 menit</option>
      </select> 
      </td>
    </tr>
    
  </table>        
  <br>
  <div style="text-align:center">
  <input type="submit" id="simpan" name="simpan" value="Simpan" >
  <input type="submit" name="simpan" value="Pilih Ruang">
  </div>
</form>

</body>
</html>