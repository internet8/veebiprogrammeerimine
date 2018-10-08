function M_event1 (result) {
	var points = document.getElementById("100mResult");
	var pointsInt = Math.pow((18-result), 1.81);
    points.innerHTML = Math.floor(25.4347 * pointsInt);
}

function M_event2 (result) {
	var points = document.getElementById("LGResult");
	var pointsInt = Math.pow((result*100-220), 1.4);
    points.innerHTML = Math.floor(0.14354 * pointsInt);
}

function M_event3 (result) {
	var points = document.getElementById("SPResult");
	var pointsInt = Math.pow((result-1.5), 1.05);
    points.innerHTML = Math.floor(51.39 * pointsInt);
}

function M_event4 (result) {
	var points = document.getElementById("HJResult");
	var pointsInt = Math.pow((result*100-75), 1.42);
    points.innerHTML = Math.floor(0.8465 * pointsInt);
}

function M_event5 (result) {
	var points = document.getElementById("400mResult");
	var pointsInt = Math.pow((82-result), 1.81);
    points.innerHTML = Math.floor(1.53775 * pointsInt);
}

function M_event6 (result) {
	var points = document.getElementById("110mhResult");
	var pointsInt = Math.pow((28.50-result), 1.92);
    points.innerHTML = Math.floor(5.74352 * pointsInt);
}

function M_event7 (result) {
	var points = document.getElementById("DTResult");
	var pointsInt = Math.pow((result-4), 1.1);
    points.innerHTML = Math.floor(12.91 * pointsInt);
}

function M_event8 (result) {
	var points = document.getElementById("PVResult");
	var pointsInt = Math.pow((result*100-100), 1.35);
    points.innerHTML = Math.floor(0.2797 * pointsInt);
}

function M_event9 (result) {
	var points = document.getElementById("JVResult");
	var pointsInt = Math.pow((result-7), 1.08);
    points.innerHTML = Math.floor(10.14 * pointsInt);
}

function M_event10 (result, result2) {
	var points = document.getElementById("1500mResult");
	res = parseInt(result)*60+parseInt(result2);
	var pointsInt = Math.pow((480-res), 1.85);
    points.innerHTML = Math.floor(0.03768 * pointsInt);
}

function Sum (){
	var points = document.getElementById("FinalResult");
	var result = 0;;
	var Table = document.getElementById("calcTable");
	var Rows = Table.getElementsByTagName("tr");
	for (i=3; i<Rows.length-1; i++) {
		var Cells = Rows[i].getElementsByTagName("td");
		if (!isNaN(parseInt(Cells[3].innerText))) {
			result += parseInt(Cells[3].innerText);
			//alert(parseInt(Cells[3].innerText));
		}
	}
	points.innerHTML = result;
}

// lingid:
// http://learn.shayhowe.com/html-css/building-forms/
// https://web.archive.org/web/20071203030644/http://www.iaaf.org/newsfiles/32097.pdf