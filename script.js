var ALERT_TITLE = "Usuwanie kodu!";
var ALERT_BUTTON_OK = "Ok";
var ALERT_BUTTON_CANCEL = "Cancel";
function deletekod(nr)
{
	var txt = "Kliknij OK aby usunąć kod rabatowy";
	d = document;
	if(d.getElementById("modalContainer")) return;

	mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
	mObj.id = "modalContainer";
	mObj.style.height = d.documentElement.scrollHeight + "px";
	
	alertObj = mObj.appendChild(d.createElement("div"));
	console.log(alertObj);
	alertObj.id = "alertBox";
	
	if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
	alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
	alertObj.style.visiblity="visible";

	h1 = alertObj.appendChild(d.createElement("h1"));
	h1.appendChild(d.createTextNode(ALERT_TITLE));
	msg = alertObj.appendChild(d.createElement("p"));
	msg.innerHTML = txt;
	testObj = alertObj.appendChild(d.createElement("div"));
	testObj.id = "test123";
	btn1 = testObj.appendChild(d.createElement("a"));
	console.log(btn1);
	btn1.id = "okBtn";
	btn1.appendChild(d.createTextNode(ALERT_BUTTON_OK));
	btn2 = testObj.appendChild(d.createElement("a"));
	btn2.id = "closeBtn";
	btn2.appendChild(d.createTextNode(ALERT_BUTTON_CANCEL));
	btn1.focus();
	btn1.onclick = function() { 
		document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
		$.ajax({
			url: 'delete_r.php',
			type: 'POST',
			data: {n:nr},
		});
			setTimeout(function() {
				window.location.reload(true);
			}, 1000)
			return false; 
		}
	btn2.focus();
	btn2.onclick = function() {
		document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer")); 
		return false; }
	alertObj.style.display = "block";
}

function go(nr)
{
	$.ajax({
		url: 'select_p.php',
		type: 'POST',
		dataType: 'json', 
		data: {n:nr},
		success: function(data) {
			if(data == "Ok") {window.location.href = "dane_zamowienie.php?id="+nr; } else {alert("Inny pracownik już zajmuje się tym zamówieniem"); }
		}
	});	
}

function save(nr,zap)
{
	var c = false;
	console.log(zap);
	if(zap != "Zapłacono") {
		if (confirm('Klient nie zapłacił! Czy chcesz kontynuować?')) {
			c = true;
		} else {
			c = false;
		}
	} else {
		c = true;
	}
	if(c==true) {
		var e = document.getElementById("opiekun");
		var pracownik = e.options[e.selectedIndex].value;
		var s = document.getElementById("status");
		var status = s.options[s.selectedIndex].value;
		var termin = $("#termin").val();
		var nr_paczki = $("#nr_paczki").val();
		var waga = $("#waga_paczki").val();
		var komentarz_pracownika = $("#komentarz_pracownika").val();
		$.ajax({
			url: 'edit_z.php',
			type: 'POST',
			data: {i:nr,p:pracownik,s:status,t:termin,n:nr_paczki,w:waga,k:komentarz_pracownika},
		});
		setTimeout(function() {
			window.location.reload(true);
		}, 1000)
	}
}
