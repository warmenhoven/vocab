<? include 'build.php' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
  </head>
  <body>
    <p><b>Please input your answers and press "Enter" to check them.</b></p>

<? if (!strcasecmp($english, "no")): ?>
    <p><b>For verbs, please give the first principal part (or second for
    defective verbs with no first principal part); for nouns, give the singlar
    nominative; for adjectives, give the masculine singular nominative.</b></p>
<? endif ?>

<?
	if (!$start) $start = 1;
	if (!$end) $end = 40;
	if ($end < $start) $end = $start;
?>
    <form action="vocab.php" method="post" target="top">
      Quiz vocab from Chapter
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
      from
      <select name="english">
        <option value="yes">Latin to English</option>
	<option value="no">English to Latin</option>
      </select>
      <input type="submit" value="Quiz" />
    </form>

    <p><a href="index.php" target="top">Return to Main Page</a></p>

    <hr />

<?
	$num = 0;
	for ($i = 0; $i < sizeof($vocab); $i++) {
		if ($vocab[$i]['CHAPTER'] < $start)
			continue;
		if ($vocab[$i]['CHAPTER'] > $end)
			continue;

		$list[$num]['LATIN'] = $vocab[$i]['LATIN'];
		$list[$num]['ENGLISH'] = $vocab[$i]['ENGLISH'];
		$list[$num]['TYPE'] = $vocab[$i]['TYPE'];
		$list[$num]['GENDER'] = $vocab[$i]['GENDER'];
		$num++;
	}
	if ($start == $end):
		$count = sizeof($list);
?>
    <p>Chapter <? echo $start ?></p>
<?
	else:
		$count = 10;
?>
    <p>Chapters <? echo $start ?> through <? echo $end ?></p>
<?
	endif;
?>
    <table>
<?
	while ($count && sizeof($list)):
		$i = rand(0, sizeof($list) - 1);

?>
      <tr>
        <td valign="top"><?
		if (!strcasecmp($english, "no")) {
			print $list[$i]['ENGLISH'];
			$ans = $list[$i]['LATIN'];
		} else {
			print $list[$i]['LATIN'];
			$ans = $list[$i]['ENGLISH'];
		}

		if ($list[$i]['GENDER'])
			print " (" . $list[$i]['GENDER'] . ".)";
		else if (strcasecmp($list[$i]['TYPE'], "verb"))
			print " (" . $list[$i]['TYPE'] . ")";
		$ans = urlencode($ans);
		$ans = preg_replace("/\./", "%2e", $ans);

		array_splice($list, $i, 1);
		$count--;
      ?></td>
        <td valign="bottom">
          <form action="vocabans.php" method="post" target="bottom">
            <input type="hidden" name="english" value="<? echo $english ?>" />
            <input name="<? echo $ans ?>" />
          </form>
        </td>
      </tr>
<?
	endwhile;
?>
    </table>

  </body>
</html>
