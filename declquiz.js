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

function createForm(word, plural, type, count) {
    var form = document.createElement("form");
    form.autocomplete = false;
    form.autocorrect = false;
    form.spellcheck = false;
    form.onsubmit = (() => checkAnswer(count, type, plural, word.latin, word.declension, word.gender, true));

    var input = document.createElement("input");
    input.id = `${plural}${type}${count}`;
    input.type = "text";
    input.autocomplete = false;
    input.autocorrect = false;
    input.spellcheck = false;
    form.appendChild(input);

    return form;
}

function createResult(word, plural, type, count) {
    var label = document.createElement("label");
    label.id = `result${plural}${type}${count}`;
    return label;
}

var noun_types = ["Nom", "Gen", "Dat", "Acc", "Abl", "Voc"];
function buildRow(word, count) {
    var root = word.latin.split(/, /)[0];
    // try to do Voc less often
    var rand = Math.floor(Math.random() * (noun_types.length * 2 - 1)) % noun_types.length;
    var type = noun_types[rand];
    var plural = word.plural ? 2 : Math.floor(Math.random() * 2) + 1;

    var tr = document.createElement("tr");

    var td = document.createElement("td");
    td.innerText = `${type}. ${plural == 1 ? "Sg" : "Pl"} of ${root}`;
    tr.appendChild(td);

    td = document.createElement("td");
    td.appendChild(createForm(word, plural, type, count));
    tr.appendChild(td);

    td = document.createElement("td");
    td.appendChild(createResult(word, plural, type, count));
    tr.appendChild(td);

    return tr;
}

function buildTable() {
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
        var tr = buildRow(word, count);
        decltable.appendChild(tr);
        count--;
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
