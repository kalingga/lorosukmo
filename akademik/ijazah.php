<?
$idpage='40';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
  echo '<form name="form1" method="post" target="_blank" action="cetak_ijazah.php">
  <center>	
  <table width="355" border="0">
    <!---
    <tr>
      <td width="187">Nomor Seri </td>
      <td width="158"><input name="noSeri" type="text" id="noSeri"></td>
    </tr>
    --->
    <tr>
      <td>NPM</td>
      <td><input name="nim" type="text" id="nim"></td>
    </tr>
    <tr>
      <td>Tanggal Lulus </td>
      <td><input name="tglLulus" type="text" id="tglLulus"></td>
    </tr>
    <tr>
      <td>Tanggal Wisuda </td>
      <td><input name="tglWisuda" type="text" id="tglWisuda"></td>
    </tr>
    <tr>
    <tr>
      <td>Gelar </td>
      <td><input name="gelar" type="text" id="gelar"></td>
    </tr>    
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Submit"></td>
    </tr>
  </table>
  </center>
</form>';  
} 

?>
