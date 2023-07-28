var url = new URL(location.href);
var month = Number.parseInt(url.searchParams.get("month")) - 1;
var year = Number.parseInt(url.searchParams.get("year"));

var date = new Date(year, month, 1);
var englishMonthName = date.toLocaleString('default', { month: 'long' });;

var month_names = ["Ianuari",   "Februari",   "Marti",   "April",   "Mai",   "Iuni",   "Iuli",   "August",   "Septembr",  "Octobr",  "Novembr",  "Decembr"];
var full_names =  ["Ianuarius", "Februarius", "Martius", "Aprilis", "Maius", "Iunius", "Iulius", "Augustus", "September", "October", "November", "December"];

function roman(num) {
    var str = "";
    [
        ["M", 1000],
        ["CM", 900],
        ["D", 500],
        ["CD", 400],
        ["C", 100],
        ["XC", 90],
        ["L", 50],
        ["XL", 40],
        ["X", 10],
        ["IX", 9],
        ["V", 5],
        ["IV", 4],
        ["I", 1]
    ].forEach(([key, val]) => {
        while (num >= val) {
            num -= val;
            str += key;
        }
    });
    return str;
}

function populateTitle() {
    var titleString = `${englishMonthName} ${year}: ${full_names[month]} ${roman(year + 753)} A.U.C.`;
    var caltitle = document.getElementById("caltitle");
    caltitle.innerText = titleString;
}

function cal_days_in_month() {
    return new Date(year, month + 1, 0).getDate();
}

function translate(day) {
    var rv = "";
    function suffix(one, two) {
        if (month == 3 || month > 7)
            return one;
        else
            return two;
    }
    var nones;
    if (month == 2 || month == 4 || month == 6 || month == 9)
        nones = 7;
    else
        nones = 5;
    if (day == 1) {
        rv += "Kalendis " + month_names[month] + suffix("ibus", "is");
    } else if (day > 1 && day < nones) {
        if (nones - day == 1)
            rv += "pridie";
        else
            rv += "a.d. " + roman(nones - day + 1);
        rv += " Nonas " + month_names[month] + suffix("es", "as");
    } else if (day == nones) {
        rv += "Nonis " + month_names[month] + suffix("ibus", "is");
    } else if (day > nones && day < nones + 8) {
        if (nones + 8 - day == 1)
            rv += "pridie";
        else
            rv += "a.d. " + roman(nones + 8 - day + 1);
        rv += " Idus " + month_names[month] + suffix("es", "as");
    } else if (day == nones + 8) {
        rv += "Idibus " + month_names[month] + suffix("ibus", "is");
    } else {
        var end = cal_days_in_month();
        if (day == end)
            rv += "pridie";
        else if (month == 1 && end == 29 && day < 25)
            rv += "a.d. " + roman(end + 1 - day);
        else
            rv += "a.d. " + roman(end + 1 - day + 1);
        var next_month = (month + 1) % 12;
        rv += " Kalendas " + month_names[next_month];
        if (next_month == 3 || next_month > 7)
            rv += "es";
        else
            rv += "as";
        if (month == 1 && end == 29 && day == 25)
            rv += " bis";
    }
    return rv;
}

function buildTable() {
    populateTitle();
    var caltable = document.getElementById("caltable");
    var end = cal_days_in_month();
    for (var i = 1; i <= end; i++) {
        var tr = document.createElement("tr");
        tr.bgColor = (i %2 ) ? "yellow" : "white";

        var td1 = document.createElement("td");
        td1.innerText = `${englishMonthName} ${i}`;
        tr.appendChild(td1);

        var td2 = document.createElement("td");
        td2.innerText = translate(i);
        tr.appendChild(td2);
        caltable.appendChild(tr);
    }
}

addEventListener("load", buildTable);
