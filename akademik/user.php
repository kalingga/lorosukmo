<script language="JavaScript" type="text/javascript">
<!--
// This script supports an unlimited number of linked combo boxed
// Their id must be "combo_0", "combo_1", "combo_2" etc.
// Here you have to put the data that will fill the combo boxes
// ie. data_2_1 will be the first option in the second combo box
// when the first combo box has the second option selected


// first combo box

	data_1 = new Option("1");
	data_2 = new Option("2", "$");
	data_3 = new Option("3", "$$");

// second combo box
	data_2_1 = new Option("TEKNIK", "1");
	data_2_2 = new Option("PERTANIAN", "2");
	data_2_3 = new Option("EKONOMI", "3");
	data_2_4 = new Option("KEGURUAN DAN ILMU PENDIDIKAN", "4");
	data_2_5 = new Option("PROGRAM PASCA SARJANA", "5");

	data_3_1 = new Option("TEKNIK INFORMATIKA", "11");
	data_3_2 = new Option("AGROTEKNOLOGI / AGROEKOTEKNOLOGI", "22");
	data_3_3 = new Option("AKUNTANSI", "31");
	data_3_4 = new Option("MANAJEMEN", "32");
	data_3_5 = new Option("PENDIDIKAN MATEMATIKA", "41");
	data_3_6 = new Option("BIMBINGAN DAN KONSELING", "42");
	data_3_7 = new Option("PENDIDIKAN PANCASILA DAN KEWARGANEGARAAN", "43");
	data_3_8 = new Option("PENDIDIKAN SEJARAH", "44");
	data_3_9 = new Option("PENDIDIKAN GURU SEKOLAH DASAR", "46");
	data_3_10 = new Option("PENDIDIKAN BAHASA INGGRIS", "47");
	data_3_11 = new Option("PENDIDIKAN BAHASA DAN SASTRA INDONESIA", "48");
	data_3_12 = new Option("PENDIDIKAN IPS", "51");


// other parameters

    displaywhenempty=""
    valuewhenempty=-1

    displaywhennotempty="- Hak Akses -"
    valuewhennotempty=0


function change(currentbox) {
	numb = currentbox.id.split("_");
	currentbox = numb[1];

    i=parseInt(currentbox)+1

// I empty all combo boxes following the current one

    while ((eval("typeof(document.getElementById(\"combo_"+i+"\"))!='undefined'")) &&
           (document.getElementById("combo_"+i)!=null)) {
         son = document.getElementById("combo_"+i);
	     // I empty all options except the first one (it isn't allowed)
	     for (m=son.options.length-1;m>0;m--) son.options[m]=null;
	     // I reset the first option
	     son.options[0]=new Option(displaywhenempty,valuewhenempty)
	     i=i+1
    }


// now I create the string with the "base" name ("stringa"), ie. "data_1_0"
// to which I'll add _0,_1,_2,_3 etc to obtain the name of the combo box to fill

    stringa='data'
    i=0
    while ((eval("typeof(document.getElementById(\"combo_"+i+"\"))!='undefined'")) &&
           (document.getElementById("combo_"+i)!=null)) {
           eval("stringa=stringa+'_'+document.getElementById(\"combo_"+i+"\").selectedIndex")
           if (i==currentbox) break;
           i=i+1
    }


// filling the "son" combo (if exists)

    following=parseInt(currentbox)+1

    if ((eval("typeof(document.getElementById(\"combo_"+following+"\"))!='undefined'")) &&
       (document.getElementById("combo_"+following)!=null)) {
       son = document.getElementById("combo_"+following);
       stringa=stringa+"_"
       i=0
       while ((eval("typeof("+stringa+i+")!='undefined'")) || (i==0)) {

       // if there are no options, I empty the first option of the "son" combo
	   // otherwise I put "-select-" in it

	   	  if ((i==0) && eval("typeof("+stringa+"0)=='undefined'"))
	   	      if (eval("typeof("+stringa+"1)=='undefined'"))
	   	         eval("son.options[0]=new Option(displaywhenempty,valuewhenempty)")
	   	      else
	             eval("son.options[0]=new Option(displaywhennotempty,valuewhennotempty)")
	      else
              eval("son.options["+i+"]=new Option("+stringa+i+".text,"+stringa+i+".value)")
	      i=i+1
	   }
       //son.focus()
       i=1
       combostatus=''
       cstatus=stringa.split("_")
       while (cstatus[i]!=null) {
          combostatus=combostatus+cstatus[i]
          i=i+1
          }
       return combostatus;
    }
}

//-->
</script>

<?php
$idpage='2';
$sm_akses_arr=explode(",",$_SESSION[$PREFIX.'sm_akses_admin']);
if ($sm_akses_arr[$idpage] == 0) {
	echo $msg_not_akses;
} else {
	if ($_GET['p']=='delete'){
		$id=$_GET['id']; 
		$MySQL->Delete("tbuser","where USERID=".$id,"1");
		if ($MySQL->exe){
			$act_log="Hapus ID='$id' Pada Tabel 'tbuser' File 'user.php' Sukses";
			AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
			echo $msg_delete_data;
		} else {
			$act_log="Hapus ID='$id' Pada Tabel 'tbuser' File 'user.php' Gagal";
			AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
			echo $msg_delete_data_0;
		}
	}
	
	//************** Simpan Data ***********************
	//if ($_GET['subpage']=='edit' and $hak_akses[($id_page+2)]==1){
	if (isset($_POST['submit'])){
		/***** jika p= add => insert***/
		$succ=0;
		$edtUser=substr(strip_tags($_POST['edtUser']),0,25);
		//  $addqry="";
		//  if (!empty($_POST['pass_admin'])){
		//  	$addqry=", pass_admin='$pass_admin' ";
		//  }
  		$edtNama=substr(strip_tags($_POST['edtNama']),0,35);
		$edtPassword=substr(strip_tags($_POST['edtPassword']),0,20);
  		$cbGroup=substr(strip_tags($_POST['cbGroup']),0,5);
  //		$cbFakultas=substr(strip_tags($_POST['cbFakultas']),0,1);
		
		$cbLevel=substr(strip_tags($_POST['combo0']),0,1);
		$cbPrivelage=substr(strip_tags($_POST['combo1']),0,5);
  		$edtID=substr(strip_tags($_POST['edtID']),0,11);
		$edtPassword=md5($edtPassword);

 		if ($_POST['submit']=='Simpan'){
  			$MySQL->Insert("tbuser","USERNAME,PASSWORD,NAMAUSER,GROUPUSER,LEVELUSER,PRIVEUSER","'$edtUser','$edtPassword','$edtNama','$cbGroup','$cbLevel','$cbPrivelage'");
  			$msg=$msg_insert_data;
    		$act_log="Tambah Data Pada Tabel 'tbuser' File 'user.php' ";  		
		} else {
			$edtID=$_POST['edtID'];
  			//***** jika p= edit => update***/;  
  			if (empty($_REQUEST['edtPassword'])) {
				$qry="USERNAME='$edtUser',NAMAUSER='$edtNama',GROUPUSER='$cbGroup',LEVELUSER='$cbLevel',PRIVEUSER='$cbPrivelage'";
			} else {
	  			$qry="USERNAME='$edtUser',PASSWORD='$edtPassword', NAMAUSER='$edtNama',GROUPUSER='$cbGroup',LEVELUSER='$cbLevel',PRIVEUSER='$cbPrivelage'";			
			}
			$MySQL->Update("tbuser",$qry,"where USERID=".$edtID,"1");
  			$msg=$msg_edit_data;
   			$act_log="Update ID='$edtID' Pada Tabel 'tbuser' File 'user.php' ";
  		}
  		if ($MySQL->exe){
			$succ=1;
		}
  		if ($succ==1){
    		$act_log .="Sukses!";
    		AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    		echo $msg;
  		} else {
   			$act_log .="Gagal!";
    		AddLog($_SESSION[$PREFIX.'id_admin'],$act_log);
    		echo $msg_update_0;
  		}
	}
	
	if (isset($_GET['p']) && (($_GET['p'] != 'delete') && ($_GET['p'] != 'refresh'))) {
		$edtUser="";
		$edtNama="";
		$cbGroup="";
		$cbLevel="";
		$cbPrivilage="";
		//$hak_akses_admin="";
		$submited="Simpan";
		$form_header="Tambah";
		$URLa = "page=".$_GET['page']."&amp;p=".$_GET['p'];


		//if (!isset($_REQUEST['cbLevel'])) $cbLevel="";
		
		if ($_GET['p']=='edit') {
			$MySQL->Select("*","tbuser","where USERID=".$_GET['id']."","","1");
			$show=$MySQL->Fetch_Array();
			$edtID=$show["USERID"];
			$edtUser=$show["USERNAME"];
			$edtNama=$show["NAMAUSER"];
			$cbGroup=$show["GROUPUSER"];
			$cbLevel=$show["LEVELUSER"];
			$cbPrivilage=$show["PRIVEUSER"];
//			$hak_akses_admin=$show["hak_akses_admin"];
			$submited="Update";
			$form_header="Edit";
		}
?>
			<form name="form1" action="./?page=user" method="post" enctype="multipart/form-data" onsubmit="return validateStandard(this, 'error');">
			<input type="hidden" name="edtID" value="<?php echo $edtID; ?>" /><table style="width:95%" border="0" cellpadding="1" cellspacing="1">
			<tr><th colspan="3">Form <?php echo $form_header; ?> Data User</th></tr>
			<tr>
			 	<td style="width:100px;" >Username</td>
			 	<td>: <input type="text" name="edtUser" size="20" maxlength="20" value="<?php echo $edtUser; ?>"/>
			 	</td>
			</tr>
			<tr>
			 	<td>Password</td>
			 	<td>: <input type="password" name="edtPassword" id="edtPassword" size="20" maxlength="20" /> Biarkan kosong jika Anda tidak ingin merubahnya</td>
			</tr>
			<tr>
			 	<td>Nama Lengkap</td>
			 	<td>: <input type="text" name="edtNama" id="edtNama" size="30" maxlength="50" value="<?php echo $edtNama; ?>"/></td>
			</tr>
			<tr>
			 	<td>Group</td>
			 	<td>: <?php LoadGroup_X("cbGroup",$cbGroup) ?></td>
			</tr>
			<tr>
<!---			 	<td>Level User</td>
			 	<td>: 
			    <select name='cbLevel' id="cbLevel" onChange=window.location.href="./?<?php echo $URLa."&amp;lvl=".$cbLevel; ?>" >"; -->
			<?php				 
/*				 $cbLevel= $_REQUEST['cbLevel'];		 
				 if ($cbLevel== '-1') $sel="selected='selected'";
				 if ($cbLevel== '0') $sel0="selected='selected'";
				 if ($cbLevel== '1') $sel1="selected='selected'";
				 if ($cbLevel== '2') $sel2="selected='selected'";

				 echo "<option value='-1' $sel >--- Level ---</option>";
			 	 echo "<option value='0' $sel0 >UNIVERSITAS</option>";
			 	 echo "<option value='1' $sel1 >FAKULTAS</option>";
			 	 echo "<option value='2' $sel2 >PROGRAM STUDI</option>";
				 echo "</select>";
				$cbPrivilage="<b> @ </b>";
				if ($_REQUEST['cbLevel'] == 1) {
						$cbPrivilage .= LoadFakultas_X("cbFakultas","");
				} elseif ($_REQUEST['cbLevel'] == 2) {
						$cbPrivilage .= LoadProdi_X("cbProdi","");						
				} else {
					echo $cbPrivilage;
				}*/
?>					  
			</tr>
			<tr><td>Level</td>
<?php
			if ($cbLevel == '-1') $sel="selected='selected'";
			if ($cbLevel == '0') $sel0="selected='selected'";
			if ($cbLevel == '1') $sel1="selected='selected'";
			if ($cbLevel == '2') $sel2="selected='selected'";
?>			
			<td>: <select name="combo0" id="combo_0" onChange="change(this);" style="width:200px;">
					<option value="-1" <?php echo $sel; ?>>-- Level --</option>
					<option value="0" <?php echo $sel0; ?>>Universitas</option>
					<option value="1" <?php echo $sel1; ?>>Fakultas</option>
					<option value="2" <?php echo $sel2; ?>>Program Studi</option>
				  </select>&nbsp;<b>@</b>&nbsp;
				<select name="combo1" id="combo_1" style="width:200px;">
				</select>
			</td></tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><td colspan="3" align="center">
			 <button type="button" onClick=window.location.href="./?page=user"><img src="images/b_cancel.gif" class="btn_img"/>&nbsp;Batal</button>
				<button type="submit" name="submit" value="<?php echo $submited; ?>" ><img src="images/b_save.gif" class="btn_img"/>&nbsp;<?php echo $submited; ?></button></td>
			</tr>
			</table>
			</form><br>
			
<?php
	} else {
	 if (!isset($_GET['pos'])) $_GET['pos']=1;
	 	$sama=false;
	 	if (isset($sama)) $_POST["sama"] = $sama; 	 
	 	$page=$_GET['page'];
	 	$p=$_GET['p'];
	 	$sel="";
	 	$checkstr = "";
	 	$field=$_REQUEST['field'];
	 	if (!isset($_REQUEST['limit'])){
	    	$_REQUEST['limit']="20";
	 	}
	 	if (isset($_REQUEST["key"])) $key = $_REQUEST["key"];
		$URLa="page=".$page;		
	
		echo "<table border='0' align='center' style='width:99%; cellpadding='2' cellspacing='1' margin:10px auto; overflow:scroll' class='tblbrdr' >";
	;
	/*********** From Pencarian ************/
	 	echo "<tr><td colspan='4'>";
	 	echo "<form action='./?".$URLa."' method='post' >";
	 	echo "Pencarian Berdasarkan : <select name='field'>";
	 	if ($field=='USERNAME') $sel1="selected='selected'";
	 	if ($field=='NAMAUSER') $sel2="selected='selected'";
	 	if ($field=='NMGROUPOP') $sel3="selected='selected'";
	 	if ($field=='msfakupy.NMFAKMSFAK') $sel3="selected='selected'";
	
	 	echo "<option value='USERNAME' $sel1 >USER</option>";
	 	echo "<option value='NAMAUSER' $sel2 >NAMA USER</option>";
	 	echo "<option value='NMGROUPOP' $sel3 >GROUP USER</option>";
	 	echo "<option value='msfakupy.NMFAKMSFAK' $sel4 >@ AKSES</option>";
	
	 	echo "</select>";
	 	echo "<input type='text' name='key' value='".$_REQUEST['key']."'/>\n";
	 	echo "<button type=\"submit\"><img src=\"images/b_search.gif\" class=\"btn_img\"/>&nbsp;Cari</button>\n</td>";
	 	echo "<td colspan='4' align='right'>Data per Hal&nbsp;:&nbsp;<input type='text' name='limit' value='".$_REQUEST['limit']."' size='5'/>";
	 	echo "&nbsp;<button type=\"button\" onClick=window.location.href='./?page=user&amp;p=refresh'><img src=\"images/b_refresh.png\" class=\"btn_img\"/>&nbsp;Refresh</button>&nbsp;";	 
	
	 	echo "</td></tr></form>";
		/************** Form Pencarian **************/
	 	echo "<tr><td colspan='8'><button type=\"button\" onClick=window.location.href='./?page=user&amp;p=add'><img src=\"images/b_add.png\" class=\"btn_img\"/>&nbsp;Tambah Data</button></td></tr>";
	 	echo "<tr><th colspan='8' style='background-color:#EEE'>Daftar User</th></tr>";
	 	echo "<tr>
	 		<th style='width:20px;'>NO</th> 
	 		<th style='width:100px;'>USER</th> 
	     	<th style='width:200px;'>NAMA USER</th> 
	     	<th style='width:100px;'>GROUP USER</th> 
	     	<th style='width:60px;'>LEVEL USER</th> 
	     	<th style='width:100px;'>@ AKSES</th> 
	     	<th style='width:20px;' colspan='2'>ACT</th> 
	 	</tr>";
	  	if(!($_REQUEST['sama']=='checked') && !empty($_REQUEST['key'])) $key = "%".$key ."%";
	  	if(!empty($_REQUEST['key'])){
	  		$qry .= " and ".$field." like '%".$key."%'";
	  	}
	  	$qry="LEFT OUTER JOIN groupop ON (tbuser.GROUPUSER = groupop.IDGROUPOP) WHERE tbuser.GROUPUSER <> '0'";
	 	if (isset($_REQUEST['key']) && !empty($_REQUEST['key'])){
			$qry .= " and ".$field." like '".$key."'";
	  	}
	  	$MySQL->Select("tbuser.USERID,tbuser.USERNAME,groupop.NMGROUPOP,tbuser.NAMAUSER,tbuser.LEVELUSER,tbuser.PRIVEUSER","tbuser",$qry,"tbuser.USERID ASC","","0");
	  	$total=$MySQL->Num_Rows();
	  	$perpage=$_REQUEST['limit'];
	  	$totalpage=ceil($total/$perpage);
	  	$start=($_GET['pos']-1)*$perpage;
	  	$MySQL->Select("tbuser.USERID,tbuser.USERNAME,groupop.NMGROUPOP,tbuser.NAMAUSER,tbuser.LEVELUSER,tbuser.PRIVEUSER","tbuser",$qry,"tbuser.USERID ASC","$start,$perpage");
	  	$jml_user=$MySQL->num_rows();
	  	if ($jml_user > 0) {
	  		$i=0;
	      	while ($show=$MySQL->Fetch_Array()){
	      		$userid[$i]=$show['USERID'];
	      		$username[$i]=$show['USERNAME'];
	      		$namauser[$i]=$show['NAMAUSER'];
	      		$grupuser[$i]=$show['NMGROUPOP'];
	      		$lveluser[$i]=$show['LEVELUSER'];
	      		$privuser[$i]=$show['PRIVEUSER'];
	      		$i++;
	     	}
	     	
	     	$no=1;
			for ($i=0;$i < $jml_user;$i++) {
	      		switch ($lveluser[$i]) {
	      			case '-' : $level[$i] = "";
	      					   $akses[$i] = "";
	      					   break;	
	      			case '0' : $level[$i] = "Universitas";
	      					   $akses[$i] = "UPY";
	      					   break;	
	      			case '1' : $level[$i] = "Fakultas";
        					   $akses[$i] = LoadFakultas_X("",$privuser[$i]);	      			
	      					   break;	
	      			case '2' : $level[$i] = "Program Studi";
      						   $akses[$i] = LoadProdi_X("",$privuser[$i]);	      			
	      					   break;	
				}
	     		$sel="";
				if ($no % 2 == 1) $sel="sel";     	
	     		echo "<tr>";
		     	echo "<td class='$sel tac'>".$no."</td>";
		     	echo "<td class='$sel'>".$username[$i]."</td>";
		     	echo "<td class='$sel'>".$namauser[$i]."</td>";
		     	echo "<td class='$sel'>".$grupuser[$i]."</td>";
		     	echo "<td class='$sel'>".$level[$i]."</td>";
		     	echo "<td class='$sel'>".$akses[$i]."</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=user&amp;p=edit&amp;id=".$userid[$i]."'>
		     	<img border='0' src='images/b_edit.png' title='EDIT DATA' />
		     	</a> ";
		     	echo "</td>";
		     	echo "<td class='$sel tac'>";
		     	echo "<a href='./?page=user&amp;p=delete&amp;id=".$userid[$i]."'>
		     	<img border='0' src='images/b_drop.png' title='HAPUS DATA' onclick=\"return confirm('Apakah Anda Yakin Akan Menghapus Data Ini?')\"/>
		     	</a> ";
		     	echo "</td>";
		     	echo "</tr>";
		     	$no++;
			}
		} else {
			echo "<td colspan='8' align='center' style='color:red;'>".$msg_data_empty."</td>";				
		}
	 /********* Tab Navigator ***************/
		echo "<tr><td colspan='8'>";
		include "navigator.php";
		echo "</td></tr>";
		echo "</table>";
	}	         
}

function LoadGroup_X($nama="",$val="") {
	global $MySQL;
	if (($val == "")){
		$MySQL->Select("IDGROUPOP,NMGROUPOP","groupop","where IDGROUPOP <> '0'","IDGROUPOP ASC","","0");
		$program_x = print("<select name='$nama' id='$nama' required='1' realname='Group' exclude = '-1' err = 'Pilih Salah Satu dari Daftar Group yang Ada!';>");
    	$program_x .= print("<option value='-1'>--- ".substr($nama,2)." ---</option>");
    	while ($show=$MySQL->Fetch_Array()) {
        	$program_x .= print("<option value='".$show["IDGROUPOP"]."'>".$show["NMGROUPOP"]."</option>");
    	}
    	$program_x .= print("</select>");
	} else {
		$MySQL->Select("NMGROUPOP","groupop","where IDGROUPOP='".$val."'","","1");
    	$show=$MySQL->Fetch_Array();
		$program_x = print("<select name='$nama' id='$nama'>");
    	$program_x .= print("<option value='$val'>".$show["NMGROUPOP"]."</option>");
		$MySQL->Select("IDGROUPOP,NMGROUPOP","groupop","where IDGROUPOP <> '0'","IDGROUPOP ASC");
    	$program_x .= print("<option value='-1'>--- ".substr($nama,2)." ---</option>");
    	while ($show=$MySQL->Fetch_Array()) {
        	$program_x .= print("<option value=".$show["IDGROUPOP"].">".$show["NMGROUPOP"]."</option>");
    	}
    	$program_x .= print("</select>");
	}
	return $program_x;
}	

?>

