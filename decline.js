function decline1(words, ncase, ct) {
  var parts = words.split(", ");
  var stem = parts[0].replace(/ae?$/, "");

  var suffix = "";

  if (ncase == "Nom" || ncase == "Voc") {
    suffix = (ct == 1 ? "a" : "ae");
  } else if (ncase == "Gen") {
    suffix = (ct == 1 ? "ae" : "arum");
  } else if (ncase == "Dat") {
    suffix = (ct == 1 ? "ae" : "is");
  } else if (ncase == "Acc") {
    suffix = (ct == 1 ? "am" : "as");
  } else if (ncase == "Abl") {
    suffix = (ct == 1 ? "a" : "is");
  }

  return stem + suffix;
}

function decline2(gender, words, ncase, ct) {
  var parts = words.split(", ");

  if (ncase == "Nom" && ct == 1) {
    return parts[0];
  }
  if (ncase == "Gen" && ct == 1 && parts[1].charAt(0) != '-') {
    return parts[1];
  }
  if (ncase == "Voc" && ct == 1 && !parts[0].match(/us$/)) {
    return parts[0];
  }

  var stem;

  if (parts[1].substring(0, 2) == "-i") {
    // -i, -ii
    stem = parts[0].replace(/..$/, "");
  } else if (parts[1].charAt(0) == '-') {
    // -orum
    stem = parts[0].replace(/.$/, "");
  } else {
    // ager, puer, etc.
    stem = parts[1].replace(/.$/, "");
  }

  var suffix;

  if (ncase == "Nom") {
    // already handled singular above, just plural here
    suffix = (gender == "n" ? "a" : "i");
  } else if (ncase == "Gen") {
    suffix = (ct == 1 ? "i" : "orum");
  } else if (ncase == "Dat") {
    suffix = (ct == 1 ? "o" : "is");
  } else if (ncase == "Acc") {
    suffix = (ct == 1 ? "um" : (gender == "n" ? "a" : "os"));
  } else if (ncase == "Abl") {
    suffix = (ct == 1 ? "o" : "is");
  } else if (ncase == "Voc") {
    // already handled singular except for -us, which end in "e"
    if (ct == 1) {
      if (parts[0] == "filius") {
        suffix = "";
      } else {
        suffix = "e";
      }
    } else {
      suffix = (gender == "n" ? "a" : "i");
    }
  }

  return stem + suffix;
}

function decline3(gender, words, ncase, ct) {
  var parts = words.split(", ");

  if (ct == 1 && (ncase == "Nom" || ncase == "Voc")) {
    return parts[0];
  }
  if (ncase == "Acc" && ct == 1 && gender == "n") {
    return parts[0];
  }
  if (ncase == "Gen" && ct == 1) {
    return parts[1];
  }

  var stem = parts[1].replace(/..$/, "");

  var suffix;

  if (ncase == "Nom" || ncase == "Voc") {
    // already handled singular above, just plural here
    suffix = (gender == "n" ? "a" : "es");
  } else if (ncase == "Gen") {
    // already handled singular above, just plural here
    suffix = "um";
  } else if (ncase == "Dat") {
    suffix = (ct == 1 ? "i" : "ibus");
  } else if (ncase == "Acc") {
    if (gender == "n") {
      // already handled singular above, just plural here
      suffix = "a";
    } else {
      suffix = (ct == 1 ? "em" : "es");
    }
  } else if (ncase == "Abl") {
    suffix = (ct == 1 ? "e" : "ibus");
  }

  return stem + suffix;
}

function declineVis(ncase, ct) {
  if (ncase == "Nom" || ncase == "Voc") {
    return (ct == 1 ? "vis" : "vires");
  } else if (ncase == "Gen") {
    return (ct == 1 ? "vis" : "virium");
  } else if (ncase == "Dat" || ncase == "Abl") {
    return (ct == 1 ? "vi" : "viribus");
  } else {
    return (ct == 1 ? "vim" : "vires");
  }
}

function decline3i(gender, words, ncase, ct) {
  var parts = words.split(", ");

  if (parts[0] == "vis") {
    return declineVis(ncase, ct);
  }

  var stem = parts[1].replace(/..$/, "");

  if (gender != "n") {
    if (ct == 2 && ncase == "Gen") {
      return stem + "ium";
    } else {
      return decline3(gender, words, ncase, ct);
    }
  }

  if (ct == 1 && (ncase == "Nom" || ncase == "Voc")) {
    return parts[0];
  }

  var suffix;

  if (ncase == "Nom" || ncase == "Voc") {
    suffix = "ia";
  } else if (ncase == "Gen") {
    suffix = (ct == 1 ? "is" : "ium");
  } else if (ncase == "Dat" || ncase == "Abl") {
    suffix = (ct == 1 ? "i" : "ibus");
  } else if (ncase == "Acc") {
    suffix = (ct == 1 ? "e" : "ia");
  }

  return stem + suffix;
}

function decline4(gender, words, ncase, ct) {
  var parts = words.split(", ");
  var stem = parts[0].replace(/us?$/, "");

  var suffix = "";

  if (gender == "n") {
    if (ct == 1) {
      suffix = (ncase == "Gen" ? "us" : "u");
    } else {
      if (ncase == "Nom" || ncase == "Acc" || ncase == "Voc") {
        suffix = "ua";
      } else if (ncase == "Gen") {
        suffix = "uum";
      } else if (ncase == "Dat" || ncase == "Abl") {
        suffix = "ibus";
      }
    }
  } else {
    if (ct == 1) {
      if (ncase == "Nom" || ncase == "Gen" || ncase == "Voc") {
        suffix = "us";
      } else if (ncase == "Dat") {
        suffix = "ui";
      } else if (ncase == "Acc") {
        suffix = "um";
      } else if (ncase == "Abl") {
        suffix = "u";
      }
    } else {
      if (ncase == "Nom" || ncase == "Acc" || ncase == "Voc") {
        suffix = "us";
      } else if (ncase == "Gen") {
        suffix = "uum";
      } else if (ncase == "Dat" || ncase == "Abl") {
        suffix = "ibus";
      }
    }
  }

  return stem + suffix;
}

function decline5(words, ncase, ct) {
  var parts = words.split(", ");
  var stem = parts[1].replace(/i$/, "");

  var suffix;

  if (ncase == "Nom" || ncase == "Voc") {
    suffix = "s";
  } else if (ncase == "Gen") {
    suffix = (ct == 1 ? "i" : "rum");
  } else if (ncase == "Dat") {
    suffix = (ct == 1 ? "i" : "bus");
  } else if (ncase == "Acc") {
    suffix = (ct == 1 ? "m" : "s");
  } else if (ncase == "Abl") {
    suffix = (ct == 1 ? "" : "bus");
  }

  return stem + suffix;
}

function checkAnswer(num, ncase, ct, words, decl, gender, show) {
  var id = "" + ct + ncase + num;
  var input = document.getElementById(id);
  var result = document.getElementById("result" + id);

  var answer;

  if (decl == 1) {
    answer = decline1(words, ncase, ct);
  } else if (decl == 2) {
    answer = decline2(gender, words, ncase, ct);
  } else if (decl == 3) {
    answer = decline3(gender, words, ncase, ct);
  } else if (decl == "3i") {
    answer = decline3i(gender, words, ncase, ct);
  } else if (decl == 4) {
    answer = decline4(gender, words, ncase, ct);
  } else if (decl == 5) {
    answer = decline5(words, ncase, ct);
  }

  if (answer == input.value) {
    result.innerHTML = "<font color=\"green\">Correct!</font> " + (show ? answer : "");
  } else {
    result.innerHTML = "<font color=\"red\">Incorrect!</font> " + (show ? answer : "");
  }
  return false;
}

