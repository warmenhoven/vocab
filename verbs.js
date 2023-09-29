function paramNumVal(name, def) {
    return url.searchParams.has(name) ? Number.parseInt(url.searchParams.get(name)) : def;
}

var url = new URL(location.href);
var part = paramNumVal("part", 0);
var start = paramNumVal("start", 1);
var end = paramNumVal("end", 40);
if (end < start)
    end = start;

function checkAnswer(num, conj) {
    var check = document.getElementById(num);
    var result = document.getElementById("result" + num);
    var conjstr = (conj && conj.length) ? " (" + conj + ")" : '';

    if (check.name == check.value) {
        result.innerHTML = "<font color=\"green\">Correct!</font> " + check.name + conjstr;
    } else {
        result.innerHTML = "<font color=\"red\">Incorrect!</font> " + check.name + conjstr;
    }
    return false;
}

function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function buildTable() {
    var verbstable = document.getElementById("verbstable");

    var list = vocab.filter((e) => e.chapter >= start && e.chapter <= end && e.type == "verb");
    if (!list.length) {
        verbstable.innerHTML = "<tr><td>There aren't any verbs to quiz you on!</td></tr>";
        return;
    }
    shuffle(list);
    if (start != end)
        list.splice(10);

    list.forEach((word, idx) => {
        var rand = Math.floor(Math.random() * list.length);
        if (!part) {
            part = Math.floor(Math.random() * 6);
            if (part > 3) part -= 2;
            if (part > 3) part -= 2;
        } else {
            part--;
        }

        var parts = word.latin.split(/, /);
        if (parts[part] == '-')
            return;
        parts[part] = `<input name="${parts[part]}" id="${idx}" type="text" autocomplete="false" autocorrect="false" spellcheck="false"/>`;

        var tr = document.createElement("tr");

        var td = document.createElement("td");
        tr.appendChild(td);

        var form = document.createElement("form");
        form.autocomplete = false;
        form.autocorrect = false;
        form.spellcheck = false;
        form.onsubmit = (() => { return checkAnswer(idx, word.conjugation); });
        form.innerHTML = parts.join(", ");
        td.appendChild(form);

        td = document.createElement("td");
        var label = document.createElement("label");
        label.id = `result${idx}`;
        td.appendChild(label);
        tr.appendChild(td);

        verbstable.appendChild(tr);
    });
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

function buildVerbsPage() {
    GetVocab(buildTable);
    createChapterOptions("verbsstart", start);
    createChapterOptions("verbsend", end);
}

addEventListener("load", buildVerbsPage);
