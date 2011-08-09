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
include "inc/mysql.php";

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
if(!$db->db_connect_id)
{
	message_die(CRITICAL_ERROR, "Could not connect to the database");
}

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<title>PHPspeed | Test Results</title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="start" title="Home" href="http://www.phpspeed.com/" />
	<link rel="stylesheet" type="text/css" media="screen" href="inc/screen.css" />
	<!--[if lt ie 7]><link rel="stylesheet" type="text/css" media="screen" href="inc/ie-win.css" /><![endif]-->

</head>

<body id="babout">

	<div id="header">
	
		<h1>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?> | DEMO</h1>
	
	</div>
	
	<div id="navigation">
	
		<ul>
			<li id="lhome"><a href="index.php">&raquo; Home</a></li>
			<li id="lhome"><a href="results.php">&raquo; View Results</a></li>
			<li id="lhome"><a href="phpinfo.php">&raquo; PHP Info</a></li>
                     <li id="lhome"><a href="mysql.php">&raquo; MySQL Info</a></li>
                     <li id="lhome"><a href="info.php">&raquo; System Info</a></li>
		</ul>
	
	</div>

	<div id="wrapper">
	
		<div id="content-wrapper">
			
			<div id="content">

                            <h2>Test Results | DEMO</h2>
				<dl>
				
					<h6>Synthetic PHP BenchMark:</h6>
				       	<table width="100%" cellpadding="5">
                                       <tr>
						<td colspan="2">
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results1 ORDER BY score DESC LIMIT 0,1");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results1");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);

?>
                                          Best Score: <b><?php echo $max; ?></b> on <i><?php echo $date; ?></i><br />
                                          Average Score: <b><?php echo $avg; ?></b><br />
                                          Last 10 Tests: (

<?php
$line = "";
$result = $db->sql_query("SELECT score FROM results1 ORDER BY testid DESC LIMIT 0,10");
while ($row = mysql_fetch_assoc($result)) {
    $line .= $row['score'] . ", ";
}
$done = rtrim ($line, ', ');
echo $done;
?>						
                                                 )<br />
                                               
						
                                            </td>
                                         </tr>
					</table>
				
					<h6>Synthetic MySQL BenchMark:</h6>
				       	<table width="100%" cellpadding="5">
                                       <tr>
						<td colspan="2">  
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results2 ORDER BY score DESC LIMIT 0,1");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results2");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
?>						
							Best Score: <b><?php echo $max; ?></b> on <i><?php echo $date; ?></i><br />
                                                Average Score: <b><?php echo $avg; ?></b><br />
                                                Last 10 Tests: (
<?php
$line = "";
$result = $db->sql_query("SELECT score FROM results2 ORDER BY testid DESC LIMIT 0,10");
while ($row = mysql_fetch_assoc($result)) {
    $line .= $row['score'] . ", ";
}
$done = rtrim ($line, ', ');
echo $done;
?>	
                                                )<br />
                                                
						
                                            </td>
                                         </tr>
					</table>

                                 <h6>Synthetic Read/Write BenchMark:</h6>
				       	<table width="100%" cellpadding="5">
                                       <tr>
						<td colspan="2">  
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results3 ORDER BY score DESC LIMIT 0,1");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results3");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
?>						
							Best Score: <b><?php echo $max; ?></b> on <i><?php echo $date; ?></i><br />
                                                Average Score: <b><?php echo $avg; ?></b><br />
                                                Last 10 Tests: (
<?php
$line = "";
$result = $db->sql_query("SELECT score FROM results3 ORDER BY testid DESC LIMIT 0,10");
while ($row = mysql_fetch_assoc($result)) {
    $line .= $row['score'] . ", ";
}
$done = rtrim ($line, ', ');
echo $done;
?>
                                                )<br />
                                                
						
                                            </td>
                                         </tr>
					</table>

					<h6>Real World PHP Page Load BenchMark:</h6>
				       	<table width="100%" cellpadding="5">
                                       <tr>
						<td colspan="2">  
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results4 ORDER BY score DESC LIMIT 0,1");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results4");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
?>					
							Best Score: <b><?php echo $max; ?></b> on <i><?php echo $date; ?></i><br />
                                                Average Score: <b><?php echo $avg; ?></b><br />
                                                Last 10 Tests: (
<?php
$line = "";
$result = $db->sql_query("SELECT score FROM results4 ORDER BY testid DESC LIMIT 0,10");
while ($row = mysql_fetch_assoc($result)) {
    $line .= $row['score'] . ", ";
}
$done = rtrim ($line, ', ');
echo $done;
?>
                                                )<br />
                                                
						
                                            </td>
                                         </tr>
					</table>
					<h6>Real World PHP w/MySQL Page Load BenchMark:</h6>
				       	<table width="100%" cellpadding="5">
                                       <tr>
						<td colspan="2">  
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results5 ORDER BY score DESC LIMIT 0,1");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results5");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
?>						
							Best Score: <b><?php echo $max; ?></b> on <i><?php echo $date; ?></i><br />
                                                Average Score: <b><?php echo $avg; ?></b><br />
                                                Last 10 Tests: (
<?php
$line = "";
$result = $db->sql_query("SELECT score FROM results5 ORDER BY testid DESC LIMIT 0,10");
while ($row = mysql_fetch_assoc($result)) {
    $line .= $row['score'] . ", ";
}
$done = rtrim ($line, ', ');
echo $done;
?>
                                                )<br />
                                               
						
                                            </td>
                                         </tr>
					</table>

                                  <h6>PHPspeed Full System Benchmark:</h6>
				       	<table width="100%" cellpadding="5">
                                       <tr>
						<td colspan="2">  
<?php
$result = $db->sql_query("SELECT timestamp, score FROM results6 ORDER BY score DESC LIMIT 0,1");
$row = $db->sql_fetchrow($result);
$max = number_format($row["score"]);
$date = date("F d, Y - g:i a", $row["timestamp"]);
if ($max == "0") { $date = "xx/xx/xx"; }
$result2 = $db->sql_query("SELECT avg(score) FROM results6");
$row2 = $db->sql_fetchrow($result2);
$avg = number_format($row2["avg(score)"]);
?>
							Best Score: <b><?php echo $max; ?></b> on <i><?php echo $date; ?></i><br />
                                                Average Score: <b><?php echo $avg; ?></b><br />
                                                Last 10 Tests: (
<?php
$line = "";
$result = $db->sql_query("SELECT score FROM results6 ORDER BY testid DESC LIMIT 0,10");
while ($row = mysql_fetch_assoc($result)) {
    $line .= $row['score'] . ", ";
}
$done = rtrim ($line, ', ');
echo $done;
?>
                                                )<br />
						
                                            </td>
                                         </tr>
					</table>
				
				</dl>
				
			</div>
		
		</div>
		
		<div id="sidebar-wrapper">
		
			<div id="sidebar">
			
		<h3>Server Time</h3>
		
				<ul>
				       <li><b>SERVER TIME:</b><br />
					<?php echo date("g:i a : l"); ?><br />
                                  <?php echo date("F d, Y"); ?></li>
                                  <?php echo $cpu2 ?></li>
                                 
				
				</ul>

				<h3>Version Info</h3>
				
				<ul>
                                  <li>PHPspeed: <b><?php echo $ver['version']; ?></b><br />
                                      <i>Tests Run: <b><?php echo $ver['tests_run']; ?></b></i><br />
                                      <i>Last Test: <?php echo date("m/d/y", $ver['last_test']) ?></i> </li>
					<li>PHP: <b><?php echo phpversion(); ?></b></li>
					<li>MySQL: <b><?php printf(mysql_get_server_info()); ?></b></li>
					<li><?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                                 
				</ul>

                           <h3>Dynamic Scorecard</h3>
                           <ul>
                                 <center>
                                  <a href="http://www.phpspeed.com/phpbenchmark.php"><img src="inc/phpspeed.php" vspace="6" border="0" alt="php benchmark"></a><br />
                                  <a href="http://www.phpspeed.com/mysqlbenchmark.php"><img src="inc/mysqlspeed.php" vspace="6" border="0" alt="mysql benchmark"></a><br />
                                  <a href="http://www.phpspeed.com/drivebenchmark.php"><img src="inc/drivespeed.php" vspace="6" border="0" alt="drive benchmark"></a><br />
                                  <a href="http://www.phpspeed.com/serverbenchmark.php"><img src="inc/serverspeed.php" vspace="6" border="0" alt="server benchmark"></a><br />
                                 </center>
				</ul>
			
			</div>
		
		</div>
	
	</div>

   <div id="footer">
		
		<p>
			<a href="http://www.phpspeed.com">PHPspeed.com</a> | 
                     <a href="http://www.phpspeed.com/phpbenchmark.php">PHP Benchmark</a> | 
			<a href="http://www.phpspeed.com/mysqlbenchmark.php">MySQL Benchmark</a> | 
			<a href="http://www.phpspeed.com/drivebenchmark.php">Drive Benchmark</a> |
                    <a href="http://www.phpspeed.com/serverbenchmark.php">Server Benchmark</a> 
		</p>
	
	</div>



</body>
</html>
