<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
  </head>
  <body>
    <center>
<?
	if (sizeof($_POST)) {
		$key = key($_POST);
		if (!strcasecmp($key, $_POST[$key])) {
			print "<font color=\"green\">Correct!</font>";
		} else {
			print "<font color=\"red\">Incorrect!</font>";
		}
		print " $key";
	}
?>
    </center>
  </body>
</html>
