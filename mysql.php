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
include "config_db.php";

if(!file_exists("config_db.php"))
{
	header("Location:install/install.php");
	die;
}

include "inc/mysql.php";
include "inc/functions.server.php";

$self = $_SERVER['PHP_SELF'];

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);

session_start();

if (isset($_GET['action']) and $_GET['action'] == 'logout') {
	session_start();
	session_destroy();
	header("Location: $self");
}

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

$show = isset($_GET['show']) ? htmlentities(addslashes($_GET['show'])) : '';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>PHPspeed | MySQL Info</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="start" title="Home" href="http://www.phpspeed.com/" />
	<link rel="stylesheet" type="text/css" media="screen" href="inc/Style.css" />
       <!--[if gte IE 5.5000]><script type="text/javascript" language="javascript" src="inc/pngfix.inc.js"></script><![endif]-->

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

<?php

if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {


	if(!extension_loaded("mysql")){
		echo ("<br><font color=red><b>php MySQL extension not loaded !!</font><br><br>Check in php.ini if  extension=php_mysql.dll is enabled, and  that the  extension_dir = is pointing to  your php/ext folder. <br><br>Copy libmySQL.dll from your Mysql/bin folder to c:/windows.</b><br><br><br>");
		die;
	}
	$link = mysql_connect($dbhost, $dbuname, $dbpass);

	if (!$link) {
		echo ('<br><font color=red><b>Could not connect to the Mysql server !!</font><br><br>' . mysql_error() . '<br><br><b>Did you set the correct host and login parameters in mysqlinfo.php ? <br><br><br>');
		die;
	}
	else
	{
		if( $user == 'root' ) {
			if( $password == '') {
				echo "<font color=red><b>Your user and password are the install default (user:root and password is blank), change it !!</b></font><br><br>";
			}

		}

		if ($show == "1") {
?>


<h6>&nbsp;&nbsp;&nbsp;MySQL Show Status</h6>

<table width="95%" class="forumline" align="center" cellspacing="1" cellpadding="4">
   <tr>
      <th colspan="4" align="center">

<?php

echo "MySQL Status | <a href=\"$self\">Show Variables</a></th></tr><tr></th></tr><tr>";

$result = mysql_query('SHOW /*!50002 GLOBAL */ STATUS', $link);
$p = 1;
while ($row = mysql_fetch_assoc($result)) {
	$p ++;
	if($p%2==0){
		echo '</tr><tr>';
	}
	echo '<td class=row1><span class=gen>&nbsp;' . $row['Variable_name'] . '</span></td><td class=row1><span class=gen>&nbsp;' . number_format($row['Value']) . "</span></td>";
}
?>
      </tr>
</table>

<?php
		} else {
?>

<h6>&nbsp;&nbsp;&nbsp;MySQL Show Variables</h6>

<table width="95%" class="forumline" align="center" cellspacing="1" cellpadding="4">
   <tr>
       <th colspan="4" align="center">
<?php

echo "MySQL Variables | <a href=\"$self?show=1\">Show Status</a></th></tr><tr>";

$result = mysql_query('SHOW VARIABLES', $link);
$p = 1;
while ($row = mysql_fetch_assoc($result)) {
	$p ++;

	if($p%2==0){
		echo '</tr><tr>';
	}
	echo '<td class=row1><span class=gen>&nbsp;' . $row['Variable_name'] . '</span></td><td class=row1><span class=gen>&nbsp;' . number_format($row['Value']) . "</span></td>";
}
		}

?>

     </tr>
</table>

<?php
	}

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

</body>
</html>
