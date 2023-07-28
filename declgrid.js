function paramVal(name, def) {
    return url.searchParams.has(name) ? url.searchParams.get(name) : def;
}

function paramNumVal(name, def) {
    return url.searchParams.has(name) ? Number.parseInt(url.searchParams.get(name)) : def;
}

var url = new URL(location.href);
var decl = paramVal("decl", 0);
var start = paramNumVal("start", 1);
var end = paramNumVal("end", 40);
if (end < start)
    end = start;

function buildHeader(word) {
    var header = document.createElement("tr");

    var td = document.createElement("td");
    td.innerText = word.latin;
    header.appendChild(td);

    td = document.createElement("td");
    td.innerText = "Singular";
    header.appendChild(td);

    td = document.createElement("td");
    td.innerText = "Plural";
    header.appendChild(td);

    return header;
}

function createForm(word, count, type, plural) {
    var form = document.createElement("form");
    form.onsubmit = (() => checkAnswer(count, type, plural, word.latin, word.declension, word.gender, false));

    var input = document.createElement("input");
    input.id = `${plural}${type}${count}`;
    form.appendChild(input);

    return form;
}

function createResult(word, count, type, plural) {
    var label = document.createElement("label");
    label.id = `result${plural}${type}${count}`;
    label.innerHTML = '<font color="white">Incorrect!</font>';
    return label;
}

function buildTypes(word, count) {
    return ["Nom", "Gen", "Dat", "Acc", "Abl", "Voc"].map((type) => {
        var tr, td, form;

        tr = document.createElement("tr");

        td = document.createElement("td");
        td.innerText = type + ".";
        tr.appendChild(td);

        td = document.createElement("td");
        if (!word.plural) {
            td.appendChild(createForm(word, count, type, 1));
        }
        tr.appendChild(td);

        td = document.createElement("td");
        td.appendChild(createResult(word, count, type, 1));
        tr.appendChild(td);


        td = document.createElement("td");
        td.appendChild(createForm(word, count, type, 2));
        tr.appendChild(td);

        td = document.createElement("td");
        td.appendChild(createResult(word, count, type, 2));
        tr.appendChild(td);

        return tr;
    });
}

function buildRows(word, count) {
    return [buildHeader(word)].concat(buildTypes(word, count));
}

function buildSeparator() {
    var tr = document.createElement("tr");
    var td = document.createElement("td");
    td.colspan = 5;
    td.innerHTML = '<hr />';
    tr.appendChild(td);
    return tr;
}

function buildTable(vocab) {
    var decltable = document.getElementById("decltable");

    var list = vocab.filter((e) =>
        e.chapter >= start && e.chapter <= end &&
            e.type == "noun" &&
            (decl == 0 || e.declension == decl));

    if (!list.length) {
        decltable.innerHTML = "<tr><td>There aren't any nouns to quiz you on!</td></tr>";
        return;
    }

    var count = (start == end) ? list.length : 10;
    while (count && list.length) {
        var rand = Math.floor(Math.random() * list.length);
        var word = list.splice(rand, 1)[0];
        var trs = buildRows(word, count);
        trs.forEach((tr) => decltable.appendChild(tr));
        count--;
        if (count && list.length) {
            decltable.appendChild(buildSeparator());
        }
    }
}


function createChapterOptions(id, selected) {
    var selector = document.getElementById(id);
    for (var i = 1; i <= 40; i++) {
        var opt = document.createElement("option");
        opt.value = i;
        opt.text = i;
        opt.selected = (i === selected);
        selector.appendChild(opt);
    }
}

function buildDeclPage() {
    GetVocab(buildTable);
    createChapterOptions("declstart", start);
    createChapterOptions("declend", end ? end : 40);
}

addEventListener("load", buildDeclPage);
