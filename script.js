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