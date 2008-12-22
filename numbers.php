<? include 'build.php' ?>
<?
  $english = $_POST["english"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
    <script type="text/javascript">

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
      var english = document.getElementById("english" + num);
      var check = document.getElementById("check" + num);
      var result = document.getElementById("result" + num);
      var correct = false;

      if (english.value == "yes") {
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

    </script>
  </head>
  <body>
    <p><b>Please input your answers and press "Enter" to check them.</b></p>
    <hr />

<?
  $num = 0;
  for ($i = 0; $i < sizeof($vocab); $i++) {
    if ($vocab[$i]['CHAPTER'] != 15)
      continue;
    if ($vocab[$i]['TYPE'] != "adjective, cardinal" &&
        $vocab[$i]['TYPE'] != "adjective, ordinal")
      continue;

    $list[$num]['LATIN'] = $vocab[$i]['LATIN'];
    $list[$num]['ENGLISH'] = $vocab[$i]['ENGLISH'];
    $list[$num]['TYPE'] = $vocab[$i]['TYPE'];
    $list[$num]['GENDER'] = $vocab[$i]['GENDER'];
    $num++;
  }
  $count = sizeof($list);
?>
    <table>
<?
  while ($count && sizeof($list)):
    if ($english == "ordered") {
      $i = 0;
    } else {
      $i = rand(0, sizeof($list) - 1);
    }

?>
      <tr>
        <td valign="top"><?
    if (strcasecmp($english, "latin")) {
      print $list[$i]['ENGLISH'];
      $ans = $list[$i]['LATIN'];
    } else {
      print $list[$i]['LATIN'];
      $ans = $list[$i]['ENGLISH'];
    }

    array_splice($list, $i, 1);
    $count--;
      ?></td>
        <td valign="bottom">
            <form onsubmit="return checkAnswer(<? echo $count ?>)">
            <input type="hidden" id="english<? echo $count ?>" value="<? echo $english ?>" />
            <input name="<? echo $ans ?>" id="check<? echo $count ?>" />
            <label id="result<? echo $count ?>" />
          </form>
        </td>
      </tr>
<?
  endwhile;
?>
    </table>

    <hr />
    <form action="numbers.php" method="post">
      Quiz numbers from
      <select name="english">
        <option value="latin">Latin to English</option>
        <option value="ordered"<? if (!strcasecmp($english, "ordered")) { print " selected=\"selected\""; } ?>>English to Latin, in order</option>
        <option value="random"<? if (!strcasecmp($english, "random")) { print " selected=\"selected\""; } ?>>English to Latin, randomized</option>
      </select>
      <input type="submit" value="Quiz" />
    </form>

    <p><a href="index.php">Return to Main Page</a></p>
  </body>
</html>
