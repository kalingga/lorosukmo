function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}
//var xmlhttp = createRequestObject();

function ubahjabatan(combobox)
{
	var xmlhttp = createRequestObject();
    var kode = combobox.value;
    //if (!kode) return;
    xmlhttp.open('get', 'includes/menuajax.php?menu=jabatan&kode='+kode, true);
    xmlhttp.onreadystatechange = function() {
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
             document.getElementById("divjabatan").innerHTML = xmlhttp.responseText;
        return false;
    }
    xmlhttp.send(null);         
}

function ubahpangkatbykelompok(combobox)
{
	var xmlhttp = createRequestObject();
    var kode = combobox.value;
    //if (!kode) return;
    xmlhttp.open('get', 'includes/menuajax.php?menu=pangkatbykelompok&kode='+kode, true);
    xmlhttp.onreadystatechange = function() {
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
             document.getElementById("divpangkatbykelompok").innerHTML = xmlhttp.responseText;
        return false;
    }
    xmlhttp.send(null);         
}

function ubahkorp(combobox, menu)
{
	var xmlhttp = createRequestObject();
    var kode = combobox.value;
    //if (!kode) return;
    xmlhttp.open('get', 'includes/menuajax.php?menu='+menu+'&kode='+kode, true);
    xmlhttp.onreadystatechange = function() {
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
             document.getElementById(menu).innerHTML = xmlhttp.responseText;
        return false;
    }
    xmlhttp.send(null);         
}
