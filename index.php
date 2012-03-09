<?php
/***************************************************************************
*   PHPspeed.com | PHP Benchmarking Script
*   http://www.phpspeed.com
*   November 4, 2006
*
*   This is a commercial script.  You MAY modify this script for your
*   personal use.  You MAY NOT redistrubute modified code without the
*   written permission of the author.  Please see the included license
*   for additional restrictions.
***************************************************************************/
define('IN_PHPSPEED', true);
include "config_db.php";

include "inc/mysql.php";
include "inc/functions.server.php";

$self = $_SERVER['PHP_SELF'];

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);

if ($result === false)
{
	header("Location:install/install.php");
	die;
}

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

if ($u == "$admin" && $p == "$pass") {
	$_SESSION['user'] = $u;
	$_SESSION['logged'] = "yes";
	header("Location: $self");
}

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?></title>
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

<br />
<table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
         <tr>
             <th align="left">Installed Tests</th>
             <th>Best Score</th>
             <th>Avg Score</th>
             <th>Tests Run</th>
             <th>History</th>
        </tr>
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results1 ORDER BY score DESC");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results1");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
$num = mysql_num_rows($result);
?>
        <tr>
             <td class="row2">
                <img src="inc/images/reddot.png"><span class="gen">
                <b>Synthetic PHP BenchMark:</b> [ <a href="runtests.php">Start Test</a> ]
                </span>
             </td>
             <td class="row1"><b><?php echo $max; ?></b></td>
             <td class="row1"><b><?php echo $avg; ?></b></td>
             <td class="row1"><b><?php echo $num; ?></b></td>
             <td class="row1"><a href="benchhistory.php?bench=1"><img src="inc/images/view.png" border="0"></a></td>
        </tr>
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results2 ORDER BY score DESC");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results2");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
$num = mysql_num_rows($result);
?>
         <tr>
            <td class="row2">
               <img src="inc/images/reddot.png"><span class="gen">
               <b>Synthetic MySQL BenchMark:</b> [ <a href="runtests2.php">Start Test</a> ]
               </span>
             </td>
             <td class="row1"><b><?php echo $max; ?></b></td>
             <td class="row1"><b><?php echo $avg; ?></b></td>
             <td class="row1"><b><?php echo $num; ?></b></td>
             <td class="row1"><a href="benchhistory.php?bench=2"><img src="inc/images/view.png" border="0"></a></td>
        </tr>
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results3 ORDER BY score DESC");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results3");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
$num = mysql_num_rows($result);
?>
        <tr>
             <td class="row2">
                 <img src="inc/images/reddot.png"><span class="gen">
                 <b>Synthetic Read/Write BenchMark:</b> [ <a href="runtests3.php">Start Test</a> ]
                 </span>
               </td>
            <td class="row1"><b><?php echo $max; ?></b></td>
             <td class="row1"><b><?php echo $avg; ?></b></td>
             <td class="row1"><b><?php echo $num; ?></b></td>
             <td class="row1"><a href="benchhistory.php?bench=3"><img src="inc/images/view.png" border="0"></a></td>
             </tr>
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results4 ORDER BY score DESC");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results4");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
$num = mysql_num_rows($result);
?>
        <tr>
             <td class="row2">
                 <img src="inc/images/reddot.png"><span class="gen">
                 <b>Real World PHP BenchMark:</b> [ <a href="runtests4.php">Start Test</a> ]
                 </span>
            </td>
           <td class="row1"><b><?php echo $max; ?></b></td>
             <td class="row1"><b><?php echo $avg; ?></b></td>
             <td class="row1"><b><?php echo $num; ?></b></td>
             <td class="row1"><a href="benchhistory.php?bench=4"><img src="inc/images/view.png" border="0"></a></td>
       </tr>
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results5 ORDER BY score DESC");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results5");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
$num = mysql_num_rows($result);
?>
        <tr>
             <td class="row2">
                 <img src="inc/images/reddot.png"><span class="gen">
                 <b>Real World PHP & MySQL BenchMark:</b> [ <a href="runtests5.php">Start Test</a> ]
                 </span>
              </td>
        <td class="row1"><b><?php echo $max; ?></b></td>
             <td class="row1"><b><?php echo $avg; ?></b></td>
             <td class="row1"><b><?php echo $num; ?></b></td>
             <td class="row1"><a href="benchhistory.php?bench=5"><img src="inc/images/view.png" border="0"></a></td>
        </tr>
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results6 ORDER BY score DESC");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results6");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
$num = mysql_num_rows($result);
?>
        <tr>
             <td class="row2">
                 <img src="inc/images/reddot.png"><span class="gen">
                 <b>Server Benchmark</b> [ <a href="runtests6.php">Start Test</a> ]
                 </span>
		</td>
            <td class="row1"><b><?php echo $max; ?></b></td>
             <td class="row1"><b><?php echo $avg; ?></b></td>
             <td class="row1"><b><?php echo $num; ?></b></td>
             <td class="row1"><a href="benchhistory.php?bench=6"><img src="inc/images/view.png" border="0"></a></td>
        </tr>
</table>

<br />
<table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
      <tr>
          <td class="row1">PHP ver: <b><?php echo phpversion(); ?></b></td>
          <td class="row1">MySQL ver: <b><?php printf(mysql_get_server_info()); ?></b></td>
          <td class="row1">Server: <b><?php echo $_SERVER['SERVER_SOFTWARE']; ?></b></td>
          <td class="row1">Last Test: <?php echo date("m/d/y", (int) $ver['last_test']) ?></td>
      </tr>
       <tr>
          <td class="row1"><a href="http://www.phpspeed.com/phpbenchmark.php"><img src="inc/phpspeed.php" border="0" alt="php benchmark"></a></td>
          <td class="row1"><a href="http://www.phpspeed.com/mysqlbenchmark.php"><img src="inc/mysqlspeed.php" border="0" alt="mysql benchmark"></a></td>
          <td class="row1"> <a href="http://www.phpspeed.com/serverbenchmark.php"><img src="inc/serverspeed.php" border="0" alt="server benchmark"></a></td>
          <td class="row1"><a href="http://www.phpspeed.com/drivebenchmark.php"><img src="inc/drivespeed.php" border="0" alt="drive benchmark"></a></td>
      </tr>
</table>

<br />
<table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
       <tr>
          <td align="center" class="row1">
                           <a href="http://www.phpspeed.com">PHPspeed.com</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                           <a href="http://www.phpspeed.com/phpbenchmark.php">PHP Results</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                           <a href="http://www.phpspeed.com/mysqlbenchmark.php">MySQL Results</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                           <a href="http://www.phpspeed.com/drivebenchmark.php">Drive Results</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
                           <a href="http://www.phpspeed.com/serverbenchmark.php">Server Results</a><br /><br />
                           <span class="gensmall">&copy; 2006 - PHPspeed.com</span></td>
      </tr>
</table>

</body>
</html>
