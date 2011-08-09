<?

include "../config_db.php";

$indb = isset($_GET['indb']) ? htmlentities(addslashes($_GET['indb'])) : '';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>PHPspeed | Install</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="start" title="Home" href="http://www.phpspeed.com/" />
	<link rel="stylesheet" type="text/css" media="screen" href="../inc/Style.css" />
	<!--[if lt ie 7]><link rel="stylesheet" type="text/css" media="screen" href="../inc/ie-win.css" /><![endif]-->
    <!--[if gte IE 5.5000]><script type="text/javascript" language="javascript" src="../inc/pngfix.inc.js"></script>-->
</head>
<body id="babout">
	<div id="header">
		<h1>PHPspeed Install | <? echo $_SERVER['HTTP_HOST']; ?></h1>
	</div>
	<div id="fullpage">
		<div id="content">
			<br />
			<h6>To install this script follow each of the steps below</h6> <br />
			<img src="../inc/images/reddot.png" align="middle"> Edit your <b>config_db.php</b> file before going to the next step. (You must manually make these changes)<br /><br />
			<table cellpadding="4" width="500">
				  <tr><th>DEFAULT SETTINGS</th><th>YOUR CURRENT SETTINGS</th></tr>
				  <tr><td>$dbhost = "localhost";</td><td>$dbhost = "<? echo "$dbhost"; ?>";<? if ($dbhost == "") { echo "<font color='red'><small>&nbsp;&nbsp;&nbsp;&laquo;&nbsp;EMPTY!!</small></font>"; } ?></td></tr>
				 <tr><td>$dbuname = "";</td><td>$dbuname = "<? echo "$dbuname"; ?>"; <? if ($dbuname == "") { echo "<font color='red'><small>&nbsp;&nbsp;&nbsp;&laquo;&nbsp;EMPTY!!</small></font>"; } ?></td></tr>
				 <tr><td>$dbpass = "";</td><td>$dbpass = "<? if ($dbpass != "" ) {echo "<small>hidden</small>"; } else { echo "$dbpass"; } ?>";<? if ($dbpass == "") { echo "<font color='red'><small>&nbsp;&nbsp;&nbsp;&laquo;&nbsp;EMPTY!!</small></font>"; } ?></td></tr>
				 <tr><td>$dbname = "phpspeed";</td><td>$dbname = "<? echo "$dbname"; ?>";<? if ($dbname == "") { echo "<font color='red'><small>&nbsp;&nbsp;&nbsp;&laquo;&nbsp;EMPTY!!</small></font>"; } ?></td></tr>
			</table>
			<br />
			<img src="../inc/images/reddot.png" align="middle"> After your config_db.php file is properly configured, we need to create a new MySQL database <a href="install.php?indb=1">&raquo; Install Now</a><br />

<?
if ($indb == "1") {
	$con = mysql_connect("$dbhost","$dbuname","$dbpass");
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	}
	if (mysql_query("CREATE DATABASE $dbname",$con)) {
		echo "<br /><font color='yellow'><b>Success!</b></font>  Database $dbname created, proceed to next step<br />";
	} else {
		echo "<br /><b><font color='yellow'>&raquo; Error creating database: </font></b>" . mysql_error();
		echo "<br /><br /><font color='yellow'><u>Possible Solutions:</u><br/>&raquo; Check your <b>config_db.php</b> file and make sure you have your username and password set correctly
			<br/>&raquo; If your database already exists, then you can't create it again, just go to the next step
			<br />&raquo; It is also possible that your MySQL name and password don't have authority to create new databases on your server.  If this is the case, then your network administrator will have to create the database for you.  (Or you can install the tables into an existing database)</font><br />";
	}
	mysql_close($con);
}
?>

			<br />
			<img src="../inc/images/reddot.png" align="middle"> Once your database is created (or you chose an exiting DB), this step will create the necessary DB tables <a href="install.php?indb=2">&raquo; Import Now</a><br />

<?
if ($indb == "2") {
	$con = mysql_connect("$dbhost","$dbuname","$dbpass");
	if (!$con) { die('Could not connect: ' . mysql_error()); }
	$seldb = mysql_select_db($dbname);
	$lines = file("phpspeed.sql");
	if(!$lines) { echo "cannot open file phpspeed.sql"; return false; }
	$scriptfile = false;
	foreach($lines as $line) {
		$line = trim($line);
		if(!ereg('^--', $line))	{
			$scriptfile .= " ".$line;
		}
	}

	if(!$scriptfile) { echo "no text found in $filename"; return false; }
	$queries = explode(';', $scriptfile);
	foreach($queries as $query)	{
		$query = trim($query);
		if($query == "") { continue; }
		if(!mysql_query($query.';')) {
			echo "<br /><small>query ".$query." <font color='yellow'>failed</font></small> - " . mysql_error() . "
			<br /><br /><font color='yellow'><u>Possible Solutions:</u>
			<br/>&raquo; Did you create your database successfully in the previous step?  If not, you must complete that step first!
			<br/>&raquo; If your tables already exist, then you can't create them again, your install is complete!  Delete the install folder!</font><br />";
			return false;
		} else {
			echo "<br /><font color='yellow'><b>Success!</b></font>  Tables have been imported!  You are ready to begin using PHPspeed! Now you should delete your entire intall folder!<br />";
		}
	}

	mysql_close($con);
}

?>
			<br /><br /><br />-------------------------------------------------------------------------------------------------------------------------------------
			<br /><font color="yellow">&raquo; After you've finished using this script, DELETE the install folder as a security measure!</font>
			<br /><br />You can start using PHPspeed by pointing your browser to the main PHPspeed folder.  <br />Example:  http://www.yoursite.com/phpspeed/ Or...  <a href="../">This link</a> will probably take you there! ;-)
			<br />-------------------------------------------------------------------------------------------------------------------------------------
			<br />If all else fails visit <a href="http://www.phpspeed.com">http://www.phpspeed.com</a> for help.
		</div>
	</div>	
</body>
</html>