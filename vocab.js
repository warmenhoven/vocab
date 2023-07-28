function paramVal(name, def) {
    return url.searchParams.has(name) ? url.searchParams.get(name) : def;
}

function paramNumVal(name, def) {
    return url.searchParams.has(name) ? Number.parseInt(url.searchParams.get(name)) : def;
}

var url = new URL(location.href);
var all = paramVal("test", 0);
var start = paramNumVal("start", 1);
var end = paramNumVal("end", 40);
var english = paramVal("english", "yes");
if (end < start)
    end = start;

function checkEnglish(correct, guess) {
    var answers = correct.toLowerCase().replace(/ ?\([^\)]*\) ?/g, "").replace(/;/g, ",").split(",");
    var minguess = guess.toLowerCase().replace(/^(a|an|the|to) /, "").replace(/ ?\([^\)]*\) ?/g, "").replace(/!/g, "");
    for (i = 0; i < answers.length; i++) {
        var a = answers[i].replace(/!/g, "").replace(/^ */, "").replace(/ *$/, "").replace(/^(a|an|the|to) /, "");
        if (a == minguess) {
            return true;
        }
    }
    return false;
}

function checkLatin(correct, guess) {
    var answers = correct.replace(/ ?\([^\)]*\) ?/g, "").replace(/;/g, ",").split(",");
    if (answers[0] == "-") {
        return (guess.toLowerCase() == answers[1].replace(/^ +/, "").toLowerCase());
    } else {
        return (guess.toLowerCase() == answers[0].toLowerCase());
    }
}

function checkAnswer(num) {
    var check = document.getElementById("check" + num);
    var result = document.getElementById("result" + num);
    var correct = false;

    if (english == "yes") {
        correct = checkEnglish(check.name, check.value);
    } else {
        correct = checkLatin(check.name, check.value);
    }

    if (correct) {
        result.innerHTML = "<font color=\"green\">Correct!</font> " + check.name;
    } else {
        result.innerHTML = "<font color=\"red\">Incorrect!</font> " + check.name;
    }

    return false;
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

function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function buildTable() {
    var vocabtable = document.getElementById("vocabtable");

    var list = vocab.filter((e) =>
        e.chapter >= start && e.chapter <= end &&
            e.type != "adjective, ordinal" &&
            e.type != "adjective. cardinal");
    shuffle(list);
    if (start != end && all != 'all')
        list.splice(10);

    list.forEach((word, idx) => {
        var tr = document.createElement("tr");

        var td = document.createElement("td");
        td.valign = "top";
        var answer;
        if (english == 'yes') {
            td.innerText = word.latin;
            answer = word.english;
        } else {
            td.innerText = word.english;
            answer = word.latin;
        }
        if (word.gender)
            td.innerText += ` (${word.gender}.)`;
        else if (word.type != 'verb')
            td.innerText += ` (${word.type})`;
        tr.appendChild(td);

        td = document.createElement("td");
        td.valign = "bottom";
        tr.appendChild(td);

        var form = document.createElement("form");
        form.onsubmit = (() => { return checkAnswer(idx); });
        td.appendChild(form);

        var input = document.createElement("input");
        input.name = answer;
        input.id = `check${idx}`;
        form.appendChild(input);

        var label = document.createElement("label");
        label.id = `result${idx}`;
        form.appendChild(label);

        vocabtable.appendChild(tr);
    });
}

function buildPage() {
    if (english != 'no') {
        document.getElementById('instr').hidden = true;
    }
    if (start == end)
        document.getElementById('chapters').innerText = `Chapter ${start}`;
    else
        document.getElementById('chapters').innerText = `Chapters ${start} through ${end}`;
    createChapterOptions('verbsstart', start);
    createChapterOptions('verbsend', end);
    GetVocab(buildTable);
}

addEventListener("load", buildPage);
