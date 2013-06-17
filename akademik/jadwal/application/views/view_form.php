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

</head>
<body>
<br>
<form action="<?=base_url();?>main/create" method="post" name="form_kelas" id="form_kelas">
  <table width="500" border="0" style="margin:auto;">
    <tr>
      <td>Matakuliah</td>
      <td>
      <select name="matkul" id="matkul" style="width:325px;">
      <?
      foreach($listMatkul->result() as $mk){
        echo "<option value='$mk->KODE'>$mk->NAMA</option>";
      
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
        echo "<option value='$row->nidn # $row->nama_pegawai'>$row->nama_pegawai, ".str_replace("|",",",$row->gelar_akademik_pegawai)." - $row->nidn</option>";
      
      } 
      ?>
      </select></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td><input name="kelas" type="text" id="kelas" size="10"></td>
    </tr>
    <tr>
      <td>Kapasitas</td>
      <td><input name="kapasitas" type="text" size="2" maxlength="3" value="30"></td>
    </tr>
    <tr>
      <td>Status</td>
      <td><select name="status" id="status">
        <option value="R">Reguler</option>
        <option value="S">Sore</option>
      </select></td>
    </tr>
    <tr>
      <td>Perlu Jadwal &amp; Ruang</td>
      <td><input type="checkbox" name="perlujadwal" checked></td>
    </tr>
    <tr>
      <td valign="top">Jenis Ruang</td>
      <td><input type="radio" name="jenisruang" value="T" checked />R. Teori <br> 
      <input type="radio" name="jenisruang" value="K"/>Lab. Komputer <br>
      <input type="radio" name="jenisruang" value="B"/>Lab. Bahasa   <br>
      <input type="radio" name="jenisruang" value="M"/>Lab. Microteaching <br>
      <input type="radio" name="jenisruang" value="H"/>Lab. Kajian Hukum</td>
    </tr>
    
  </table>        
  <br>
  <div style="text-align:center">
  <input type="submit" name="Submit" value="Simpan">
  </div>
</form>

</body>
</html>