function paramVal(name, def) {
    return url.searchParams.has(name) ? url.searchParams.get(name) : def;
}

var url = new URL(location.href);
var english = paramVal("english", "latin");

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
        return (guess.toLowerCase() == answers[1].toLowerCase());
    } else {
        return (guess.toLowerCase() == answers[0].toLowerCase());
    }
}

function checkAnswer(num) {
    var check = document.getElementById("check" + num);
    var result = document.getElementById("result" + num);
    var correct = false;

    if (english == 'latin') {
        correct = checkLatin(check.name, check.value);
    } else {
        correct = checkEnglish(check.name, check.value);
    }

    if (correct) {
        result.innerHTML = "<font color=\"green\">Correct!</font> " + check.name;
    } else {
        result.innerHTML = "<font color=\"red\">Incorrect!</font> " + check.name;
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
    var numtable = document.getElementById("numtable");

    var list = vocab.filter((word) => word.chapter == 15 &&
                            (word.type == 'adjective, cardinal' || word.type == 'adjective, ordinal'));
    if (english != 'ordered')
        shuffle(list);

    list.forEach((word, idx) => {
        var answer;
        var tr = document.createElement("tr");

        var td = document.createElement("td");2
        td.valign = "top";
        if (english == 'latin') {
            td.innerText = word.latin;
            answer = word.english;
        } else {
            td.innerText = word.english;
            answer = word.latin;
        }
        tr.appendChild(td);

        td = document.createElement("td");
        tr.appendChild(td);
        td.valign = "bottom";

        var form = document.createElement("form");
        td.appendChild(form);
        form.onsubmit = (() => { return checkAnswer(idx); });

        var input = document.createElement("input");
        input.name = answer;
        input.id = `check${idx}`;
        form.appendChild(input);

        var label = document.createElement("label");
        label.id = `result${idx}`;
        form.appendChild(label);

        numtable.appendChild(tr);
    });
}

addEventListener("load", () => GetVocab(buildTable));
