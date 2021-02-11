<? include 'build.php' ?>
<?
  $start = $_POST["start"];
  $end   = $_POST["end"];
  $type  = $_POST["type"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
  </head>
  <body>

    <table>
      <tr>
        <td align="center">Chapter</td>
	<td align="center">Part of Speech</td>
	<td>Latin</td>
	<td>English</td>
      </tr>

<?
	for ($i = 0; $i < sizeof($vocab); $i++):
		$types = preg_split("/, /", $vocab[$i]['TYPE']);

		if ($start || $end) {
			if ($end < $start) $end = $start;
			if ($vocab[$i]['CHAPTER'] < $start)
				continue;
			if ($vocab[$i]['CHAPTER'] > $end)
				continue;
		}
		if ($type) {
			$erg = preg_split("/ /", $type);
			$found = 0;
			foreach ($types as $t) {
				if (!strcasecmp($t, $erg[0])) {
					$found = 1;
					break;
				}
			}
			if (!$found)
				continue;
			if (sizeof($erg) > 1) {
				$found = 0;
				foreach ($types as $t) {
					if (!strcasecmp($t, "verb")) {
						if (($erg[1] == $vocab[$i]['CONJUGATION']) ||
						    (!$erg[1] && !$vocab[$i]['CONJUGATION'])) {
							$found = 1;
							break;
						}
					} else if (!strcasecmp($t, "noun")) {
						if (($erg[1] == $vocab[$i]['DECLENSION']) ||
						    (!$erg[1] && !$vocab[$i]['DECLENSION'])) {
							$found = 1;
							break;
						}
					}
				}
				if (!$found)
					continue;
			}
		}
?>

      <tr>
        <td align="center"><? echo $vocab[$i]['CHAPTER'] ?></td>
	<td align="center"><?
		echo $vocab[$i]['TYPE'];
		foreach ($types as $t) {
			if (!strcasecmp($t, "verb")) {
				if (!isset($vocab[$i]['CONJUGATION']))
					print " (irregular)";
				else
					print " (" . $vocab[$i]['CONJUGATION'] . ")";
			} else if (!strcasecmp($t, "noun")) {
				if (!isset($vocab[$i]['DECLENSION']))
					print " (indeclinable)";
				else
					print " (" . $vocab[$i]['DECLENSION'] . ")";
			}
		}
		?></td>
	<td><?
		echo $vocab[$i]['LATIN'];
		foreach ($types as $t) {
			if (!strcasecmp($t, "noun")) {
				print ", " . $vocab[$i]['GENDER'] . ".";
			}
		}
		?></td>
	<td><?
		echo $vocab[$i]['ENGLISH'];
        if (isset($vocab[$i]['NOTES']))
			print " (" . $vocab[$i]['NOTES'] . ")";
		?></td>
      </tr>
<? endfor; ?>

    </table>
  </body>
</html>
