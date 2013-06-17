GetId = function(id){
   if (document.getElementById)
      return document.getElementById(id);
   else if (document.all)
      return document.all[id];
}

SetCookie = function(cook){
		return	document.cookie=PREF+ID+cook;
}

GetCookie = function (name) {
	name=PREF+ID+name;
	var vSearch = name + "="
	var returnvalue = "";
	if (document.cookie.length > 0) {
		offset = document.cookie.indexOf(vSearch)
		if (offset != -1) { 
		offset += vSearch.length
		end = document.cookie.indexOf(";", offset);
		if (end == -1) end = document.cookie.length;
			returnvalue=unescape(document.cookie.substring(offset, end))
		}
	}
	return returnvalue;
} 
	
function DeleteMessage(){
	if (GetId('msg_err')!=undefined)
		GetId('msg_err').style.display='none';	
}

Confirm = function(txt,method,url,form,target,history){
	if (confirm(txt)){
		return Request(method,url,form,target,history);	
	}
	else
		return false;
}

ValidateForm = function (form){
	if (form.nama_pegawai!=undefined)
		if (form.nama_pegawai.value.length<3){
			alert('Nama Minimal 3 Karakter!')
			form.nama_pegawai.focus()
			form.nama_pegawai.select()
			return false
		}
		
	if (form.edtEmail!=undefined){
		var str = form.edtEmail.value; // email string	
		var reg1 = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/; // not valid
		var reg2 = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?)$/; // valid
		if (!(!reg1.test(str) && reg2.test(str))) { // if syntax is valid
		  	alert("Mail \"" + str + "\" Is Not Valid!"); // this is also optional
			form.edtEmail.focus();
			form.edtEmail.select();  
		  	return false;
		}
	}
	return true;
}

var dayarray=new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu');
var montharray=new Array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	
GetDate = function(){
	time=new Date();
	month=time.getMonth();
	year=time.getYear();
	if (year < 1000) year+=1900;
	hour=time.getHours();
	if (hour<10) hour='0'+hour;
	minute=time.getMinutes();
	if (minute<10) minute='0'+minute;
	second=time.getSeconds();
	if (second<10) second='0'+second;
	showtime=dayarray[time.getDay()]+', '+time.getDate()+'-'+montharray[month]+'-'+year
		+' '+hour+':'+minute+':'+second+'&nbsp;&nbsp;';
	
	if (GetId('currDate')!=undefined)
		GetId('currDate').innerHTML=showtime
	temp=setTimeout("GetDate()",1000)
}

function Populate(objForm,selectIndex) {
		timeA=new Date(objForm.txtyear.options[objForm.txtyear.selectedIndex].text,	objForm.txtmonth.options[objForm.txtmonth.selectedIndex].value,1);
		timeDifference = timeA - 86400000;
		timeB = new Date(timeDifference);
		var daysInMonth = timeB.getDate();
		for (var i = 0; i < objForm.txtday.length; i++) {
		objForm.txtday.options[0] = null;
		}
		for (var i = 0; i < daysInMonth; i++) {
		objForm.txtday.options[i] = new Option(i+1);
		}
		objForm.txtday.options[0].selected = true;
}

function Validate(obj,typ) {
	//white list karakter
	list1="ABCDEFGHIJKLMNOPQRSTUVWXYZ ";
	list2="abcdefghijklmnopqrstuvwxyz ";
	list3="1234567890";
	list4="()[]{} ";
	list5=".,'\" ";
	list6="!@#$%^&*_-=+|\\<>?/:; \n";
	newtxt="";
	txt=obj.value
	if (typ==1){ //Numeric Only
		whitelist=list3;
	}
	else if (typ==2){ //Phone Number
		whitelist=list3+list4;
	}
	else if (typ==3){ //Name
		whitelist=list1+list2+list5;
	}
	else if (typ==4){ //Alphabet Only
		whitelist=list1+list2;
	}
	else if (typ==5){ //AlphaNumeric Only
		whitelist=list1+list2+list3;
	}
	else { //Addr
		whitelist=list1+list2+list3+list4+list5+list6;
	}
	
	for (i=0;i<txt.length;i++){
		if (whitelist.indexOf(txt.charAt(i))>-1) 
			newtxt+=txt.charAt(i);	
	}

	obj.value=newtxt;
	return true
}

function flipflop(form,cbx){
	bol=cbx.checked;
	for (i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "checkbox") {
			form.elements[i].checked = bol;
		}
	}
}

function checkmenu(form,cbx,cbx2){
	if (cbx.checked){
		for (i = 0; i < form.elements.length; i++) {
			if (form.elements[i].name == cbx2) {
				form.elements[i].checked = true;
			}
		}
	}
}

var currline=" ";
var overline=" ";
function mover(obj){
	if (obj.style.backgroundColor==''){
		if (currline!=obj)
			obj.style.backgroundColor='#FFE3E3';
		else{
			overline=obj;
		}
	}
	else{
		overline=obj;
		currline=obj;
	}
}

function mout(obj){
	if (overline!=obj){
		if (currline!=obj)
			obj.style.backgroundColor='';
	}
}

function mclick(obj){
		if (currline!=obj){
			currline=obj;
			obj.style.backgroundColor='#E3F1FF';
		}
		else{
			if (obj.style.backgroundColor==''){
				currline=obj;
				obj.style.backgroundColor='#E3F1FF';
			}
			else{
				obj.style.backgroundColor='';
				currline="";
				overline=""
			}
		}
	}


function popWindow(id){
	var win = window.open("", "Calendar", 
		"width=775,height=350,status=no,resizable,scrollbars,top=125,left=150");
//	win.opener = self;
	var html_header = new String (
		"<html>\n"+
		"<head>\n"+
		"<title></title>\n"+
		"<link href='theme_1/style_print.css' rel='stylesheet' type='text/css' />\n"+
		"<link href='include/style.css' rel='stylesheet' type='text/css' />\n"+
		"</head>\n"+
		"<body>\n"+
		"<div class='tac'>\n<button class='m5' type='button' onclick='this.style.display=\"none\"; window.print(); window.close()'>CETAK</button>\n</div>\n");
	var html_footer = new String (	
		"</body>\n"+
		"</html>\n");
	var html_body=GetId(id).innerHTML;
	var win_doc = win.document;
	win_doc.write(html_header+html_banner+html_body+html_sign+html_footer);
	win_doc.close();
}

/******Directions: Just insert the below into the <body> section of your page:
/*
*** Multiple dynamic combo boxes
*** by Mirko Elviro, 9 Mar 2005
*** Script featured and available on JavaScript Kit (http://www.javascriptkit.com)
***
***Please do not remove this comment
*/

// This script supports an unlimited number of linked combo boxed
// Their id must be "combo_0", "combo_1", "combo_2" etc.
// Here you have to put the data that will fill the combo boxes
// ie. data_2_1 will be the first option in the second combo box
// when the first combo box has the second option selected


// first combo box

	data_1 = new Option("1", "$");
	data_2 = new Option("2", "$$");

// second combo box

	data_1_1 = new Option("11", "-");
	data_1_2 = new Option("12", "-");
	data_2_1 = new Option("21", "--");
	data_2_2 = new Option("22", "--");
	data_2_3 = new Option("23", "--");
	data_2_4 = new Option("24", "--");
	data_2_5 = new Option("25", "--");

// third combo box

	data_1_1_1 = new Option("111", "*");
	data_1_1_2 = new Option("112", "*");
	data_1_1_3 = new Option("113", "*");
	data_1_2_1 = new Option("121", "*");
	data_1_2_2 = new Option("122", "*");
	data_1_2_3 = new Option("123", "*");
	data_1_2_4 = new Option("124", "*");
	data_2_1_1 = new Option("211", "**");
	data_2_1_2 = new Option("212", "**");
	data_2_2_1 = new Option("221", "**");
	data_2_2_2 = new Option("222", "**");
	data_2_3_1 = new Option("231", "***");
	data_2_3_2 = new Option("232", "***");

// fourth combo box

	data_2_2_1_1 = new Option("2211","%")
	data_2_2_1_2 = new Option("2212","%%")

// other parameters

    displaywhenempty=""
    valuewhenempty=-1

    displaywhennotempty="-select-"
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

function preview(layout){
	if(layout == '2') {
		GetId('view_1').style.display='none';
		GetId('view_2').style.display='';
	} else if(layout == '1') {
		GetId('view_1').style.display='';
		GetId('view_2').style.display='none';
	} else {
		GetId('view_1').style.display='none';
		GetId('view_2').style.display='none';
	}
}