var vocab = [];
var _vocab_responses = [];
var _vocab_waiters = [];
var _vocab_started = false;
function _vocab_complete() {
    return vocab.length > 0;
}
function GetVocab(cb) {
    if (_vocab_complete()) {
        if (cb) cb(vocab);
        return;
    }
    if (cb) _vocab_waiters.push(cb);
    if (_vocab_started)
        return;
    _vocab_started = true;
    Array(40).fill().map((_, i) => i).forEach((num) => {
        var xhr = new XMLHttpRequest();
        xhr.addEventListener("load", () => {
            try {
                _vocab_responses[num] = JSON.parse(xhr.responseText);
            } catch (e) {
                console.log(`failed to parse ${num}`);
                console.log(xhr.responseText);
                return;
            }
            if (_vocab_responses.filter((e) => e).length != 40)
                return;
            vocab = [].concat.apply([], _vocab_responses);
            _vocab_waiters.forEach((xb) => xb(vocab));
            _vocab_waiters = [];
        });
        xhr.open("GET", `dict/${num+1}.json`);
        xhr.send();
    });
}

GetVocab();
