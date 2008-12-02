<? include 'build.php' ?>
<?
  $part  = $_POST["part"];
  $start = $_POST["start"];
  $end   = $_POST["end"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
    <script type="text/javascript">

    function checkAnswer(num) {
      var check = document.getElementById(num);
      var result = document.getElementById("result" + num);

      if (check.name == check.value) {
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
    <p><hr /></p>

    <table>

<?
  $count = 10;
  $num = 0;
  for ($i = 0; $i < sizeof($vocab); $i++) {
    if ($start || $end) {
      if ($end < $start) $end = $start;
      if ($vocab[$i]['CHAPTER'] < $start)
        continue;
      if ($vocab[$i]['CHAPTER'] > $end)
        continue;
    }
    if (strcasecmp($vocab[$i]['TYPE'], "verb"))
      continue;

    $list[$num++] = preg_split("/, /", $vocab[$i]['LATIN']);
  }
  if ($start == $end)
    $count = sizeof($list);

  if (!sizeof($list)) {
    print "<tr><td>There aren't any verbs to quiz you on!</td></tr>";
  } else while ($count && sizeof($list)) {
    $i = rand(0, sizeof($list) - 1);
    if (!$part) {
      // I like to focus on the last two parts
      $j = rand(0, 6);
      if ($j > 3) $j -= 2;
      if ($j > 3) $j -= 2;
    } else {
      $j = $part - 1;
    }

    if (strcasecmp($list[$i][$j], "-")) {
      print "<form onsubmit=\"return checkAnswer($count)\"><tr><td>";
      for ($k = 0; $k < 4; $k++) {
        if ($j == $k) {
          $answer = $list[$i][$j];
          print "<input name=\"$answer\" id=\"$count\" />";
        } else {
          print $list[$i][$k];
        }
        if ($k != 3)
          print ", ";
      }
      print "</td><td><label id=\"result$count\" /></td></tr></form>\n";
      $count--;
    }

    array_splice($list, $i, 1);
  }
?>
    </table>
    <hr />
    <p><form action="verbs.php" method="post">
      Quiz
      <select name="part">
        <option value="0">all</option>
        <option value="1">first</option>
        <option value="2">second</option>
        <option value="3">third</option>
        <option value="4">fourth</option>
      </select>
      principal parts for verbs from Chapter
      <select name="start">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == $start) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      to Chapter
      <select name="end">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == $end) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      <input type="submit" value="Quiz" />
    </form></p>

    <p><a href="index.php">Return to Main Page</a></p>
  </body>
</html>
