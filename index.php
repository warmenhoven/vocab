<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latin Vocab</title>
  </head>
  <body>

    <h3>Wheelock's Latin Vocabulary Tools</h3>

    <form action="display.php" method="post">
      Build a vocab list from Chapter
      <select name="start">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      to Chapter
      <select name="end">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == 40) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      containing
      <select name="type">
        <option value="0">All Words</option>
        <option disabled="disabled">-----------</option>
        <option value="noun">All Nouns</option>
        <option value="noun 1">First Declension Nouns</option>
        <option value="noun 2">Second Declension Nouns</option>
        <option value="noun 3">Third Declension Nouns</option>
        <option value="noun 3i">Third Declension I-Stem Nouns</option>
        <option value="noun 4">Fourth Declension Nouns</option>
        <option value="noun 5">Fifth Declension Nouns</option>
        <option value="noun 0">Irregular Nouns</option>
        <option disabled="disabled">-----------</option>
        <option value="verb">All Verbs</option>
        <option value="verb 1">First Conjugation Verbs</option>
        <option value="verb 2">Second Conjugation Verbs</option>
        <option value="verb 3">Third Conjugation Verbs</option>
        <option value="verb 3i">Third Conjugation -io Verbs</option>
        <option value="verb 4">Fourth Conjugation Verbs</option>
        <option value="verb 0">Irregular Verbs</option>
        <option disabled="disabled">-----------</option>
        <option value="adjective">Adjectives</option>
        <option value="adverb">Adverbs</option>
        <option value="cardinal">Cardinals</option>
        <option value="conjunction">Conjunctions</option>
        <option value="enclitic">Enclitics</option>
        <option value="interjection">Interjections</option>
        <option value="ordinal">Ordinals</option>
        <option value="preposition">Prepositions</option>
        <option value="pronoun">Pronouns</option>
      </select>
      <input type="submit" value="Build" />
    </form>

    <form action="verbs.php" method="post">
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
        <option value="<? echo $i ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      to Chapter
      <select name="end">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == 40) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      <input type="submit" value="Quiz" />
    </form>

    <form action="vocab.php" method="post">
      <select name="test">
        <option value="some">Quiz</option>
        <option value="all">Test</option>
      </select>
      vocab from Chapter
      <select name="start">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      to Chapter
      <select name="end">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == 40) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      from
      <select name="english">
        <option value="yes">Latin to English</option>
	<option value="no">English to Latin</option>
      </select>
      <input type="submit" value="Quiz" />
    </form>

    <form action="declquiz.php" method="post">
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
      declensions for nouns (random cases) from Chapter
      <select name="start">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      to Chapter
      <select name="end">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == 40) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      <input type="submit" value="Quiz" />
    </form>

    <form action="declgrid.php" method="post">
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
        <option value="<? echo $i ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      to Chapter
      <select name="end">
<? for ($i = 1; $i <= 40; $i++): ?>
        <option value="<? echo $i; if ($i == 40) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      <input type="submit" value="Quiz" />
    </form>

    <form action="calendar.php" method="post">
    Create a calendar for
      <select name="month">
<? $today = getdate();
   $months = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
   for ($i = 1; $i <= 12; $i++):
?>
        <option value="<? echo $i; if ($i == $today['mon']) echo "\" selected=\"selected" ?>"><? echo $months[$i] ?></option>
<? endfor ?>
      </select>
      <select name="year">
<? for ($i = 1950; $i < 2050; $i++): ?>
        <option value="<? echo $i; if ($i == $today['year']) echo "\" selected=\"selected" ?>"><? echo $i ?></option>
<? endfor ?>
      </select>
      <input type="submit" value="Create" />
    </form>

    <h3>Site Updated, Again! (November 30, 2008)</h3>

    <p>
      I've been thinking about updating this site for a short time
      now, and I finally got around to adding a declension quiz. I've
      actually added two quizzes, one that has you fill in the entire
      grid, and another that just asks for one piece of the grid for
      various nouns.
    </p>

    <p>
      I think I've gotten all of the words right (including vis!), but
      I'm sure there's probably a problem here or there. If you have
      any problems with the new quizzes, please <a
      href="mailto:eric@warmenhoven.org">email me</a>
      (eric@warmenhoven.org).
    </p>

    <h3>Frequently Asked Questions</h3>

    <p>
      <b>It's telling me my translation is wrong, but it's not.</b><br />
      The script is really rather stupid, and very pedantic. It splits the
      correct answers on commas, and ignores everything inside parentheses.
      Then it strips out various articles (as well as the infinitves' "to").
      Finally it checks to see if your answer matches one of the correct
      answers exactly. For example, it thinks the definition of 'quam' is
      "(after comparatives) than; (with superlatives) as...as possible (e.g.
      quam fortissimus, as great as possible)". It will split on the semicolon
      and remove the parenthetical comments, so the correct answers are "than"
      and "as...as possible". If you put in either of these, it should say it's
      correct. If you put spaces between the periods of the ellipsis, it will
      tell you that your answer is incorrect.
    </p>
    <p>
      The only reason why you should care if the script thinks you're correct
      is to save yourself time checking your answers. If it thinks it's wrong,
      your answer may very well be correct, but you'll need to then compare
      your answer to what it thinks the correct answer is and see why it says
      you're wrong. Don't forget, spelling is important.
    </p>

    <p>
      <b>Are you going to add a verb form/conjugation drill or flash
      cards?</b><br />
      Hopefully soon!
    </p>

    <p>
      <b>Are you going to add the words used in Wheelock's but not in the
      Chapters' vocabulary lists?</b><br />
      If I have the time. If you have the time, send them to me and I'll be
      happy to add them.
    </p>

    <p>
      <b>This page is really ugly; you should fix that.</b><br />
      I know.
    </p>

    <h3>About This Page</h3>

    <p>
      Originally I had been using <!--<a
      href="http://cheiron.humanities.mcmaster.ca/~barrette/latin/">this</a>-->
      another Latin vocab site, which was very useful. However, there
      were enough things wrong with it, and the author seemed to be
      absent for long enough, that I decided to create my own based on
      it. I downloaded the vocabulary database and converted it to
      XML, and wrote several PHP scripts. All the PHP and XML files
      are available for download (<a href="site.tgz">tgz</a>, <a
      href="site.zip">zip</a>).
    </p>

    <p>
      I've tried to correct a lot of little errors with the dictionary
      (e.g. 'cecidi' instead of 'cecedi'). If you notice anything
      wrong with any of these pages, please <a
      href="mailto:eric@warmenhoven.org">e-mail me</a>
      (eric@warmenhoven.org). I'll try to respond to email I get about
      this site in a timely manner. (Please don't email me in Latin;
      I'm still just a beginner.)
    </p>

    <p align="center">
      <script type="text/javascript"><!--
      google_ad_client = "pub-7643919961248886";
      google_ad_width = 728;
      google_ad_height = 90;
      google_ad_format = "728x90_as";
      google_ad_type = "text";
      google_ad_channel ="";
      //--></script>
      <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
    </p>
  </body>
</html>
