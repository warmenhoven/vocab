<? include 'build.php' ?>
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
    <p><a href="index.php">Return to Main Page</a></p>
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
  </body>
</html>
