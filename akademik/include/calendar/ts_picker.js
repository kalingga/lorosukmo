function show_calendar(str_target1,str_target2, str_datetime) {
	var arr_months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
		"Juli", "Agustus", "September", "Oktober", "November", "Desember"];
	var week_days = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
	var n_weekstart = 1; // day week starts from (normally 0 or 1)

	var dt_datetime = (str_datetime == null || str_datetime =="" ?  new Date() : str2dt(str_datetime));
	var dt_prev_month = new Date(dt_datetime);
	dt_prev_month.setMonth(dt_datetime.getMonth()-1);
	var dt_next_month = new Date(dt_datetime);
	dt_next_month.setMonth(dt_datetime.getMonth()+1);
	//tambah tahun
	var dt_prev_year = new Date(dt_datetime);
	dt_prev_year.setYear(verYear(dt_datetime)-1);
	var dt_next_year = new Date(dt_datetime);
	dt_next_year.setYear(verYear(dt_datetime)+1);
	//tambahan
	var dt_firstday = new Date(dt_datetime);
	dt_firstday.setDate(1);
	dt_firstday.setDate(1-(7+dt_firstday.getDay()-n_weekstart)%7);
	var dt_lastday = new Date(dt_next_month);
	dt_lastday.setDate(0);
	
	// print calendar header
	var str_buffer = new String (
		"<html>\n"+
		"<head>\n"+
		"	<title>Calendar</title>\n"+
		"<style type='text/css'>"+
		"a {color:white;text-decoration:none;}"+
		"</style>"+
		"</head>\n"+
		"<body bgcolor=\"White\">\n"+
		"<table class=\"clsOTable\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n"+
		"<tr><td bgcolor=\"#4682B4\">\n"+
		"<table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" width=\"100%\">\n"+
		"<tr>\n	<td bgcolor=\"#4682B4\"><a href=\"javascript:window.opener.show_calendar('"+
		str_target1+"','"+str_target2+"', '"+ dt2dtstr(dt_prev_month)+"');\">"+
		"&lt;&lt;&nbsp;</a></td>\n"+
		"<td bgcolor=\"#4682B4\" colspan=\"5\">"+
		"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"
		+arr_months[dt_datetime.getMonth()]+"&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:window.opener.show_calendar('"
		+str_target1+"', '"+str_target2+"', '"+dt2dtstr(dt_prev_year)+"');\">"+
		"&lt;&nbsp;</a>"+verYear(dt_datetime)+"<a href=\"javascript:window.opener.show_calendar('"
		+str_target1+"', '"+str_target2+"', '"+dt2dtstr(dt_next_year)+"');\">"+
		"&nbsp;&gt;</a></font></td>\n"+
		"	<td bgcolor=\"#4682B4\" align=\"right\"><a href=\"javascript:window.opener.show_calendar('"
		+str_target1+"', '"+str_target2+"', '"+dt2dtstr(dt_next_month)+"');\">"+
		"&nbsp;&gt;&gt;</a></td>\n</tr>\n"
	);
	
	function verYear(dt_datetime){
		//if (dt_datetime.getFullYear()<=100) return (dt_datetime.getFullYear()+1900);
		return (dt_datetime.getFullYear())
	}
	var dt_current_day = new Date(dt_firstday);
	// print weekdays titles
	str_buffer += "<tr>\n";
	for (var n=0; n<7; n++)
		str_buffer += "	<td bgcolor=\"#87CEFA\">"+
		"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"+
		week_days[(n_weekstart+n)%7]+"</font></td>\n";
	// print calendar table
	str_buffer += "</tr>\n";
	while (dt_current_day.getMonth() == dt_datetime.getMonth() ||
		dt_current_day.getMonth() == dt_firstday.getMonth()) {
		// print row heder
		str_buffer += "<tr>\n";
		for (var n_current_wday=0; n_current_wday<7; n_current_wday++) {
				if (dt_current_day.getDate() == dt_datetime.getDate() &&
					dt_current_day.getMonth() == dt_datetime.getMonth())
					// print current date
					str_buffer += "	<td bgcolor=\"#FFB6C1\" align=\"right\">";
				else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
					// weekend days
					str_buffer += "	<td bgcolor=\"#DBEAF5\" align=\"right\">";
				else
					// print working days of current month
					str_buffer += "	<td bgcolor=\"white\" align=\"right\">";

				if (dt_current_day.getMonth() == dt_datetime.getMonth())
					// print days of current month
					str_buffer += "<a href=\"javascript:window.opener."+str_target1+
					".value='"+dt2dtstr(dt_current_day)+"'; window.opener."+str_target2+
					".value='"+dt2dtstr_hide(dt_current_day)+"'; window.close();\">"+
					"<font color=\"black\" face=\"tahoma, verdana\" size=\"2\">";
				else 
					// print days of other months
					str_buffer += "<a href=\"javascript:window.opener."+str_target1+
					".value='"+dt2dtstr(dt_current_day)+"'; window.opener."+str_target2+
					".value='"+dt2dtstr_hide(dt_current_day)+"'; window.close();\">"+
					"<font color=\"gray\" face=\"tahoma, verdana\" size=\"2\">";
				str_buffer += dt_current_day.getDate()+"</font></a></td>\n";
				dt_current_day.setDate(dt_current_day.getDate()+1);
		}
		// print row footer
		str_buffer += "</tr>\n";
	}
	// print calendar footer
	str_buffer +=		
		"</table>\n" +
		"</tr>\n</td>\n</table>\n" +
		"</body>\n" +
		"</html>\n";

	var vWinCal = window.open("", "Calendar", 
		"width=250,height=210,status=no,resizable=no,top=215,left=680");
	vWinCal.opener = self;
	var calc_doc = vWinCal.document;
	calc_doc.write (str_buffer);
	calc_doc.close();
}
// datetime parsing and formatting routimes. modify them if you wish other datetime format
function str2dt (str_datetime) {
	var re_date = /^(\d+)\-(\d+)\-(\d+)$/;
	if (!re_date.exec(str_datetime))
		return alert("Invalid Datetime format: "+ str_datetime);
	return (new Date (RegExp.$3, RegExp.$2-1, RegExp.$1, RegExp.$4, RegExp.$5, RegExp.$6));
}
function dt2dtstr (dt_datetime) {
	return (new String (
			dt_datetime.getDate()+"-"+(dt_datetime.getMonth()+1)+"-"+dt_datetime.getFullYear() ));
}
function dt2dtstr_hide (dt_datetime) {
	return (new String (
			dt_datetime.getDate()+"-"+(dt_datetime.getMonth()+1)+"-"+dt_datetime.getFullYear() ));
	//dt_datetime.getFullYear()+"-"+(dt_datetime.getMonth()+1)+"-"+dt_datetime.getDate()));
}
function dt2tmstr (dt_datetime) {
	return (new String (
			dt_datetime.getHours()+":"+dt_datetime.getMinutes()+":"+dt_datetime.getFullYear() ));
}