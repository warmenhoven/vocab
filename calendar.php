<?

function roman($yr) {
	$r = "";
	while ($yr >= 1000) {
		$yr -= 1000;
		$r .= "M";
	}
	if ($yr >= 900) {
		$yr -= 900;
		$r .= "CM";
	}
	if ($yr >= 500) {
		$yr -= 500;
		$r .= "D";
	}
	if ($yr >= 400) {
		$yr -= 400;
		$r .= "CD";
	}
	while ($yr >= 100) {
		$yr -= 100;
		$r .= "C";
	}
	if ($yr >= 90) {
		$yr -= 90;
		$r .= "XC";
	}
	if ($yr >= 50) {
		$yr -= 50;
		$r .= "L";
	}
	if ($yr >= 40) {
		$yr -= 40;
		$r .= "XL";
	}
	while ($yr >= 10) {
		$yr -= 10;
		$r .= "X";
	}
	if ($yr == 9) {
		$yr -= 9;
		$r .= "IX";
	}
	if ($yr >= 5) {
		$yr -= 5;
		$r .= "V";
	}
	if ($yr == 4) {
		$yr -= 4;
		$r .= "IV";
	}
	while ($yr >= 1) {
		$yr -= 1;
		$r .= "I";
	}
	return $r;
}

	$month_names = array("", "Ianuari", "Februari", "Marti", "April", "Mai", "Iuni", "Iuli", "August", "Septembr", "Octobr", "Novembr", "Decembr");
	$full_names = array("", "Ianuarius", "Februarius", "Martius", "Aprilis", "Maius", "Iunius", "Iulius", "Augustus", "September", "October", "November", "December");
	$english_mos = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	if ($month == 3 || $month == 5 || $month == 7 || $month == 10) {
		$nones = 7;
	} else {
		$nones = 5;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Calendar</title>
  </head>
  <body>

    <table>
      <tr>
        <td colspan="2"><? echo "$english_mos[$month] $year: $full_names[$month] " . roman($year + 753) . " A.U.C." ?></td>
      </tr>
<?
	$end = cal_days_in_month(CAL_JULIAN, $month, $year);
	$next_month = $month + 1;
	if ($next_month == 13)
		$next_month = 1;
	for ($i = 1; $i <= $end; $i++):
?>
      <tr bgcolor="<? if ($i % 2) echo "yellow"; else echo "white" ?>">
        <td><? echo "$english_mos[$month] $i" ?></td>
	<td>
<?
		if ($i == 1) {
			echo "Kalendis $month_names[$month]";
			if ($month == 4 || $month > 8)
				echo "ibus";
			else
				echo "is";
		} else if ($i > 1 && $i < $nones) {
			if ($nones - $i == 1) {
				echo "pridie";
			} else {
				echo "a.d. ";
				echo roman($nones - $i + 1);
			}
			echo " Nonas $month_names[$month]";
			if ($month == 4 || $month > 8)
				echo "es";
			else
				echo "as";
		} else if ($i == $nones) {
			echo "Nonis $month_names[$month]";
			if ($month == 4 || $month > 8)
				echo "ibus";
			else
				echo "is";
		} else if ($i > $nones && $i < $nones + 8) {
			if ($nones + 8 - $i == 1) {
				echo "pridie";
			} else {
				echo "a.d. ";
				echo roman($nones + 8 - $i + 1);
			}
			echo " Idus $month_names[$month]";
			if ($month == 4 || $month > 8)
				echo "es";
			else
				echo "as";
		} else if ($i == $nones + 8) {
			echo "Idibus $month_names[$month]";
			if ($month == 4 || $month > 8)
				echo "ibus";
			else
				echo "is";
		} else {
			if ($i == $end) {
				echo "pridie";
			} else if ($month == 2 && $end == 29 && $i < 25) {
				echo "a.d. ";
				echo roman($end + 1 - $i);
			} else {
				echo "a.d. ";
				echo roman($end + 1 - $i + 1);
			}
			echo " Kalendas $month_names[$next_month]";
			if ($next_month == 4 || $next_month > 8)
				echo "es";
			else
				echo "as";
			if ($month == 2 && $end == 29 && $i == 25)
				echo " bis";
		}
?>
        </td>
      </tr>
<?
	endfor;
?>
    </table>
  </body>
</html>
