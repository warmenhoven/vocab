function paramVal(name, def) {
    return url.searchParams.has(name) ? url.searchParams.get(name) : def;
}

function paramNumVal(name, def) {
    return url.searchParams.has(name) ? Number.parseInt(url.searchParams.get(name)) : def;
}

var url = new URL(location.href);
var start = paramNumVal("start", 1);
var end = paramNumVal("end", 40);
if (end < start)
    end = start;
var typeopt = paramVal("type", "0").split(/ /);

function wordFilter(word) {
    if (word.chapter < start || word.chapter > end) return false;
    if (typeopt[0] == "0") return true;
    if (!word.type.split(/, /).includes(typeopt[0])) return false;
    if (!typeopt[1]) return true;
    if (typeopt[0] == 'verb') {
        return word.conjugation == typeopt[1];
    } else if (typeopt[0] == 'noun') {
        return word.declension == typeopt[1];
    }
    return true;
}

function buildTable() {
    var displaytable = document.getElementById("displaytable");
    vocab.filter(wordFilter).forEach((word) => {
        var tr = document.createElement("tr");

        var td = document.createElement("td");
        td.align = "center";
        td.innerText = word.chapter;
        tr.appendChild(td);

        td = document.createElement("td");
        td.align = "center";
        td.innerText = word.type;
        var types = word.type.split(/, /);
        if (types.includes('verb')) {
            td.innerText += ` (${word.conjugation ? word.conjugation : 'irregular'})`;
        } else if (types.includes('noun')) {
            td.innerText += ` (${word.declension ? word.declension : 'indeclinable'})`;
        }
        tr.appendChild(td);

        td = document.createElement("td");
        td.innerText = word.latin;
        if (word.gender)
            td.innerText += `, ${word.gender}.`;
        tr.appendChild(td);

        td = document.createElement("td");
        td.innerText = word.english;
        if (word.notes)
            td.innerText += ` (${word.notes})`;
        tr.appendChild(td);

        displaytable.appendChild(tr);
    });
}

addEventListener("load", () => GetVocab(buildTable));
