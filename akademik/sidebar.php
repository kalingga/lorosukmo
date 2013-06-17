<div id="sidebar">
	<div class="panel">
		<div class="headpanel"><div>LOGIN</div></div>
		<div class="mainpanel">
			<form method="post" action="">
			<br>
			<div class="content">Username :</div>
			<div class="content"><input type="text" name="user" style="width:150px;" value="" maxlength="25" /></div>
			<div class="content">Password :</div>
			<div class="content"><input type="password" name="pass" style="width:150px;" value="" maxlength="20"/></div>
			<div style="text-align:center; margin:5px 0 0 0">
			<button type="submit" name="login_admin"><img src="images/b_login.png" align="absmiddle"/>&nbsp;Login</button></div>
			</form>
<?php
		if ($login_result > 0){
			echo "<div id='msg_err' class='diverr tac p5 m5' margin:0 auto;'>";
			if ($login_result==1) echo "USERNAME TIDAK DITEMUKAN!!";
			if ($login_result==2) echo "PASSWORD ANDA SALAH!!";
			echo "</div>";
}
?>
		</div>
		<div class="footpanel"></div>
	</div>
	<!******************* akhir panel Login *******************>
	<!******************* panel kalender *******************>
	<div class="panel">
		<div class="headpanel">
		<div>KALENDER</div>
		</div>
		<div class="mainpanel">
			<CENTER>
			<SCRIPT LANGUAGE="JavaScript">
			monthnames = new Array(
			"Januari",
			"Februari",
			"Maret",
			"April",
			"Mei",
			"Juni",
			"Juli",
			"Agustus",
			"September",
			"Oktober",
			"Nopember",
			"Desember");
			var linkcount=0;
			function addlink(month, day, href) {
			var entry = new Array(3);
			entry[0] = month;
			entry[1] = day;
			entry[2] = href;
			this[linkcount++] = entry;
			}
			Array.prototype.addlink = addlink;
			linkdays = new Array();
			monthdays = new Array(12);
			monthdays[0]=31;
			monthdays[1]=28;
			monthdays[2]=31;
			monthdays[3]=30;
			monthdays[4]=31;
			monthdays[5]=30;
			monthdays[6]=31;
			monthdays[7]=31;
			monthdays[8]=30;
			monthdays[9]=31;
			monthdays[10]=30;
			monthdays[11]=31;
			
			<?
			$saiki = date("d M Y");
			echo "saiki=\"$saiki\"";
			?>;
			
			todayDate=new Date(saiki);
			
			thisday=todayDate.getDay();
			thismonth=todayDate.getMonth();
			thisdate=todayDate.getDate();
			thisyear=todayDate.getYear();
			thisyear = thisyear % 100;
			thisyear = ((thisyear < 50) ? (2000 + thisyear) : (1900 + thisyear));
			if (((thisyear % 4 == 0) 
			&& !(thisyear % 100 == 0))
			||(thisyear % 400 == 0)) monthdays[1]++;
			startspaces=thisdate;
			while (startspaces > 7) startspaces-=7;
			startspaces = thisday - startspaces + 1;
			if (startspaces < 0) startspaces+=7;
			document.write("<table border=0 cellspacing=1 cellpadding=0 ");
			document.write("bordercolor=#666666 width=100%><font color=black>");
			document.write("<tr><td colspan=7><center><strong><font size=1>" 
			+ monthnames[thismonth] + " " + thisyear 
			+ "</font></strong></center></font></td></tr>");
			document.write("<tr>");
			document.write("<td align=center><font size=1 color=red><b>M</b></font></td>");
			document.write("<td align=center><font size=1><b>S</b></font></td>");
			document.write("<td align=center><font size=1><b>S</b></font></td>");
			document.write("<td align=center><font size=1><b>R</b></font></td>");
			document.write("<td align=center><font size=1><b>K</b></font></td>");
			document.write("<td align=center><font size=1 color=green><b>J</b></font></td>");
			document.write("<td align=center><font size=1><b>S</b></font></td>"); 
			document.write("</tr>");
			document.write("<tr>");
			for (s=0;s<startspaces;s++) {
			document.write("<td> </td>");
			}
			count=1;
			while (count <= monthdays[thismonth]) {
				for (b = startspaces;b<7;b++) {
					linktrue=false;
					document.write("<td align=center><font size=1>");
					for (c=0;c<linkdays.length;c++) {
						if (linkdays[c] != null) {
							if ((linkdays[c][0]==thismonth + 1) && (linkdays[c][1]==count)) {
								document.write("<a href=\"" + linkdays[c][2] + "\">");
								linktrue=true;
			    				}
			   				}
						}
					if (count <= monthdays[thismonth]) {
						if (b==0) {
							document.write("<font color=red>");}
						if (b==5) {
							document.write("<font color=green>");}
						if (count==thisdate) {
							document.write("<font size=2 color=blue><strong>");}
						
						document.write(count);
			
						if (count==thisdate) {
							document.write("</strong></font>");}			
						if (b==0){
							document.write("</font>");}
						if (b==5){
							document.write("</font>");}
			
						}
					else {
					document.write(" ");
						}
					if (linktrue)
						document.write("</a>");
					document.write("</font></td>");
					count++;
					}
				document.write("</tr>");
				document.write("<tr>");
				startspaces=0;
			}
			document.write("</table>");
			</SCRIPT>
			</CENTER>
		</div>
		<div class="footpanel"></div>
	</div>
	<!******************* akhir panel kalender *******************>	
	<!******************* panel web info *******************>
	<div class="panel">
		<div class="headpanel">
			<div>WEB INFO</div>
		</div>
		<div class="mainpanel">
			<br>
			<div class="content"><?php echo "Server&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ".$serverStatus; ?></div>
			<div class="content"><?php echo "Database : ".$dbStatus; ?></div>
		</div>
		<div class="footpanel"></div>
	</div>
	<!******************* akhir panel web info *******************>

</div>