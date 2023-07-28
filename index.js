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

function populateDisplayList() {
    createChapterOptions("displaystart");
    createChapterOptions("displayend", 40);
}

function populateVerbsList() {
    createChapterOptions("verbsstart");
    createChapterOptions("verbsend", 40);
}

function populateVocabList() {
    createChapterOptions("vocabstart");
    createChapterOptions("vocabend", 40);
}

function populateDeclList() {
    createChapterOptions("declstart");
    createChapterOptions("declend", 40);
}

function populateGridList() {
    createChapterOptions("gridstart");
    createChapterOptions("gridend", 40);
}

function populateCalendarList() {
    var opt, i;

    var calmonth = document.getElementById("calmonth");
    var today = new Date();
    for (i = 0; i < 12; i++) {
        var date = new Date(today.getFullYear(), i, 1);
        opt = document.createElement("option");
        opt.text = date.toLocaleString('default', { month: 'long' });
        opt.value = i + 1;
        opt.selected = (i == today.getMonth());
        calmonth.appendChild(opt);
    }

    var calyear = document.getElementById("calyear");
    for (i = 1950; i < today.getFullYear() + 100; i++) {
        opt = document.createElement("option");
        opt.text = i;
        opt.value = i;
        opt.selected = (i == today.getFullYear());
        calyear.appendChild(opt);
    }
}

function populateAllLists() {
    populateDisplayList();
    populateVerbsList();
    populateVocabList();
    populateDeclList();
    populateGridList();
    populateCalendarList();
}

addEventListener("load", populateAllLists);
