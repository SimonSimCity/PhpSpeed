<?php
/***************************************************************************
*
*   PHPspeed.com | PHP Benchmarking Script
*   http://www.phpspeed.com
*   November 4, 2006
*
*   This is a commercial script.  You MAY modify this script for your
*   personal use.  You MAY NOT redistrubute modified code without the
*   written permission of the author.  Please see the included license
*   for additional restrictions.
*
***************************************************************************/
define('IN_PHPSPEED', true);
session_start();

include "config_db.php";

if (isset($_GET['action']) and $_GET['action'] == 'logout') {
	session_start();
	session_destroy();
	header("Location: $self");
}

$self = $_SERVER['PHP_SELF'];
if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
	$login = "<a href=\"$self?action=logout\"><img align=\"middle\" src=\"inc/images/exit.gif\" border=\"0\" hspace=\"6\" alt=\"logout\"></a>";
} else {
	$login = "<span class=\"gen\"><form name=\"login\" action=\"$self\" method=\"POST\" style=\"margin:0;\"><input type=\"hidden\" name=\"submit\">Name:&nbsp;<input type=\"text\" name=\"user\" size=\"10\" class=\"post\">&nbsp;Pass:&nbsp;<input type=\"password\" name=\"pass\" size=\"10\" class=\"post\">&nbsp;<input name=\"Submit\" type=\"submit\" class=\"button\" value=\"Login\"></form></span>";
}

$u = isset($_POST['user']) ? $_POST['user'] : ''; //username from form
$p = isset($_POST['pass']) ? $_POST['pass'] : ''; // password from form.

if ($u == "$admin" && $p == "$pass"){
	$_SESSION['user'] = $u;
	$_SESSION['logged'] = "yes";
	header("Location: $self");
}

ob_start();
phpinfo(INFO_MODULES);
$php_info = ob_get_contents();
ob_end_clean();

$php_info = strip_tags($php_info, '<table><tr><th><td><h2><style>');
$php_info = str_replace("' '", " \<br>", $php_info);
$php_info = str_replace("'", "", $php_info);
$php_info = str_replace("phpinfo()", "", $php_info);
$php_info = preg_replace('/<h2[^>]*>([^<]+)<\/h2>/',"<H6>&nbsp;&nbsp;\\1</H6>", $php_info);
$php_info = preg_replace('/<style[^>]*>([^<]+)<\/style>/',"", $php_info);

$php_info = str_replace("600", "95%", $php_info);
$php_info = str_replace("table", "table align=center class=forumline cellspacing=1", $php_info);
$php_info = str_replace("=\"e\"", "=\"row1\" width=25%", $php_info);
$php_info = str_replace("=\"v\"", "=\"row1\"", $php_info);

// include_path:

$php_info = str_replace(".:/", "/", $php_info);

// paths:

$php_info = str_replace(":/", "<br>/", $php_info);
$php_info = str_replace("<br>//", "://", $php_info); // correct urls

// LS_COLORS and some paths:

$php_info = str_replace(";", "; ", $php_info);
$php_info = str_replace(",", ", ", $php_info);

// apache address :

$php_info = str_replace("&lt; ", "<", $php_info);
$php_info = str_replace("&gt;", ">", $php_info);

include "inc/mysql.php";
include "inc/functions.server.php";

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);
?>


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<title>PHPspeed | PHP Info</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="start" title="Home" href="http://www.phpspeed.com/" />
	<link rel="stylesheet" type="text/css" media="screen" href="inc/Style.css" />

</head>

<body>

<table width="97%" cellspacing="0" cellpadding="15" border="0" align="center">
	  <tr>
		<td>
			<span class="maintitle">PHPspeed <?php echo $ver['version']; ?></span><br />
                     <span class="mainmenu"><a href="index.php">Home</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                                            <a href="phpinfo.php">PHP Info</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                                            <a href="mysql.php">MySQL Info</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                                            <a href="info.php">System Info</a></span>
		</td>
              <td align="right">
<?php echo $login; ?>
		</td>
	 </tr>
</table>
<span class="gen">
<?php

if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {

	print ($php_info);

} else {

	echo "<table width=\"95%\" align=\"center\">
         <tr>
             <td width=\"100%\">
                  <table class=\"forumline\" cellpadding=\"8\">
                        <tr>
                            <td class=\"row1\">You need to login to view this page...</td>
                        </tr>
                  </table>
            </td>
         </tr>
     </table>";

}

?>
</span>
</body>
</html>
