<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
  </head>
  <body>
    <center>
<?
	array_splice($_POST, 0, 1);
	if (sizeof($_POST)) {
		$ans = key($_POST);
		$try = $_POST[$ans];
		$ans = preg_replace("/_/", " ", urldecode($ans));

		$correct = 0;

		if (!strcasecmp($english, "no")) {
			$answers = preg_split("/[,\;] /", $ans);
			if (!strcasecmp($answers[0], "-")) {
				if (!strcasecmp($answers[1], $try))
					$correct = 1;
			} else {
				if (!strcasecmp($answers[0], $try))
					$correct = 1;
			}
		} else {
			$tmp = preg_replace("/ ?\([^\)]*\) ?/", "", $ans);
			$answers = preg_split("/[,\;] ?/", $tmp);

			foreach ($answers as $a) {
				$a = preg_replace("/^(a|an|the|to) /i", "", $a);
				$a = preg_replace("/!/", "", $a);
				// run their answer through the same checks
				$b = $try;
				$b = preg_replace("/^(a|an|the|to) /i", "", $b);
				$b = preg_replace("/ ?\([^\)]*\) ?/", "", $b);
				$b = preg_replace("/!/", "", $b);
				if (!strcasecmp($a, $b)) {
					$correct = 1;
					break;
				}
			}
		}
		if ($correct) {
			print "<font color=\"green\">Correct!</font>";
		} else {
			print "<font color=\"red\">Incorrect!</font>";
		}
		print " $ans\n";
	}
?>
    </center>
  </body>
</html>
