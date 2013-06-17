<form name="form1" action="./" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
<table style="width:95%" border="0" cellpadding="1" cellspacing="1">
<tr>
<th colspan="2">Form Regristrasi</th>
</tr>
<tr>
 <td colspan="2">&nbsp;</td>
</tr>
<tr>
 <td style="width:100px;" >Username </td>
 <td>: <input type="text" name="edtUser" size="25" maxlength="25" required="1" realname="Username" regexp = /^\w*$/; err='Username Tidak Boleh Kosong/mengandung karakter kosong(spasi)!' /></td>
</tr>
<tr>
 <td>Password </td>
 <td class="mandatory">: <input type="password" name="edtPassword" id="edtPassword" size="20" maxlength="20" required="1" minlength="6" realname="Password" err='Password Tidak Boleh Kosong/Panjang Minimal 6 Karakter!' /></td>
</tr>
<tr>
 <td>Password </td>
 <td class="mandatory">: <input type="password" name="edtPassword1" id="edtPassword1" size="20" maxlength="20" required="1" equals="edtPassword" err="Password Yang Anda Masukkan Tidak Valid" /></td>
</tr>
<tr>
 <td>Nama Lengkap </td>
 <td class="mandatory">: <input type="text" name="edtNama" id="edtNama" size="35" maxlength="35" required="1" realname = "Nama" /></td>
</tr>
<tr>
 <td colspan="2">&nbsp;</td>
</tr>
<tr>
 <td colspan="2" align="center">
 <button type="reset" onclick=window.location.href="./"><img src="images/b_reset.gif" class="btn_img"/>&nbsp;Batal</button>
 <input type="submit" name="submit" value="Submit" />
 </td>
</tr>
</table>
</form>