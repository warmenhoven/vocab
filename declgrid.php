<? include 'build.php' ?>
<?
  $decl  = $_POST["decl"];
  $start = $_POST["start"];
  $end   = $_POST["end"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
    <script type="text/javascript" src="decline.js"></script>
  </head>
  <body>
    <p><b>Please input your answers and press "Enter" to check them.</b></p>
    <p><form action="declgrid.php" method="post">
      Quiz
      <select name="decl">
        <option value="0">all</option>
        <option value="1">first</option>
        <option value="2">second</option>
        <option value="3">third</option>
        <option value="3i">third, i-stem</option>
        <option value="4">fourth</option>
        <option value="5">fifth</option>
      </select>
      declensions for nouns (as grids) from Chapter
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
    if (strcasecmp($vocab[$i]['TYPE'], "noun"))
      continue;

    if ($decl) {
      if ($vocab[$i]['DECLENSION'] != $decl)
        continue;
    }

    $list[$num++] = array($vocab[$i]['PLURAL'], $vocab[$i]['LATIN'],
                          $vocab[$i]['DECLENSION'], $vocab[$i]['GENDER']);
  }
  if ($start == $end)
    $count = sizeof($list);

  if (!sizeof($list)) {
    print "<tr><td>There aren't any nouns to quiz you on!</td></tr>";
  } else while ($count && sizeof($list)) {
    $i = rand(0, sizeof($list) - 1);
    
?>
        <tr>
          <td><? print $list[$i][1] ?></td>
          <td align="center">Singular</td><td></td>
          <td align="center">Plural</td><td></td></tr>
<?
    $types = array("Nom", "Gen", "Dat", "Acc", "Abl", "Voc");
    foreach ($types as $type) {
?>
        <tr>
          <td><? print $type ?>.</td>
          <td>
<? if (!$list[$i][0]): ?>
           <form onsubmit="return checkAnswer(<? print $count ?>,
                                              '<? print $type ?>',
                                              1,
                                              '<? print $list[$i][1] ?>',
                                              '<? print $list[$i][2] ?>',
                                              '<? print $list[$i][3] ?>')">
              <input id="1<? print $type . $count ?>" />
            </form>
<? endif ?>
          </td>
          <td><label id="result1<? print $type . $count ?>"><font color="white">Incorrect!</font></td>
          <td>
           <form onsubmit="return checkAnswer(<? print $count ?>,
                                              '<? print $type ?>',
                                              2,
                                              '<? print $list[$i][1] ?>',
                                              '<? print $list[$i][2] ?>',
                                              '<? print $list[$i][3] ?>')">
              <input id="2<? print $type . $count ?>" />
            </form>
          </td>
          <td><label id="result2<? print $type . $count ?>"><font color="white">Incorrect!</font></td>
        </tr>

<?
    }
    $count--;
    array_splice($list, $i, 1);
    if ($count && sizeof($list)) {
      print "<tr><td colspan=\"5\"><hr /></td></tr>\n";
    }
  }
?>
    </table>
  </body>
</html>
