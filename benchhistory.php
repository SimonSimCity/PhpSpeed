<?php
define('IN_PHPSPEED', true);

include "config_db.php";
include "inc/mysql.php";

$self = $_SERVER['PHP_SELF'];

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

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
if(!$db->db_connect_id)
{
	message_die(CRITICAL_ERROR, "Could not connect to the database");
}

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);

$b = htmlentities(addslashes($_GET['bench']));

switch ($b){
	case "1":
	$r="1";
	$t="Synthetic PHP BenchMark";
	break;
	case "2":
	$r="2";
	$t="Synthetic MySQL BenchMark";
	break;
	case "3":
	$r="3";
	$t="Synthetic Read/Write BenchMark";
	break;
	case "4":
	$r="4";
	$t="Real World PHP BenchMark";
	break;
	case "5":
	$r="5";
	$t="Real World PHP & MySQL BenchMark";
	break;
	case "6":
	$r="6";
	$t="Server Benchmark";
	break;
	default:
	$r="1";
	$t="Synthetic PHP BenchMark";
	break;
}

$result = $db->sql_query("SELECT * FROM results$r ORDER BY testid DESC LIMIT 0,15");

$result2 = $db->sql_query("SELECT avg(score) FROM results$r");
$row2 = $db->sql_fetchrow($result2);

$avg = number_format($row2["avg(score)"]);


$result3 = $db->sql_query("SELECT timestamp, score FROM results$r ORDER BY score DESC");
$row3 = $db->sql_fetchrow($result3);
$max = number_format($row3["score"]);
$num = mysql_num_rows($result3);

if (isset($_GET['erase']) && ($_GET['erase'] == '1')) {
	$del = "yes";
} else {
	$del = "";
}

if (isset($_GET['conf']) && ($_GET['conf'] == '1')) {
	$conf = "1";
} else {
	$conf = "";
}

if (isset($_GET['csv']) && ($_GET['csv'] == '1')) {
	$csv = "yes";
} else {
	$csv = "";
}

if ($csv == 'yes') {

	$csv_output = '"Test ID","Date","CPU","Uptime","Memory","PHPspeed","PHP","MySQL","Server","Test Results","Tests Run","Iterations","Total Time","Score","Site"';
	$csv_output .= "\015\012";
	$result = $db->sql_query("SELECT * FROM results$r ORDER BY testid DESC");

	while($row = mysql_fetch_array($result)) {
		$csv_output .= '"'.$row['testid'].'","'. date("m/d/y",$row['timestamp']).'","'.$row['cpu'].'","'.$row['uptime'].'","'.$row['memory'].'","'.$row['phpspeed_version'].'","'.$row['php_version'].'","'.$row['mysql_version'].'","'.$row['server_software'].'","'. $row['test_results'].'","'.$row['tests_run'].'","'.$row['iterations'].'","'.$row['total_time'].'","'.$row['score'].'","'.$row['site'].'"';
		$csv_output .= "\015\012";
	}

	//You cannot have the breaks in the same feed as the content.
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=\"PHPspeed_Benchmark".$r."_". date("dmy") . ".csv\"");
	print $csv_output;
	exit;
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<title>PHPspeed | Test Results</title>
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

<?php
if (($del == 'yes') && ($conf != '1')) {

	if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {

?>

<H6>&nbsp;&nbsp;&nbsp;&nbsp;Are you sure?</h6>

			      <table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
                                <tr>
                                   <td align="left" class="row2"><font color="yellow"> Are you sure you want to delete all results for Test # <?php echo $r; ?>  &nbsp;<a href="benchhistory.php?conf=1&bench=<?php echo $r; ?>"><b>YES</b></a></td>
                                </tr>
			      </table><br />


<?php	} else {
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

} else if (($del != 'yes') && ($conf == '1')) {

	if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {

		$result3 = $db->sql_query("TRUNCATE TABLE results$r");

	}

?>

<H6>&nbsp;&nbsp;&nbsp;&nbsp;All data deleted...</h6>

			      <table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
                                <tr>
                                   <td align="left" class="row2"><font color="yellow">SUCCESS!  All data has been deleted.</td>
                                </tr>
			      </table><br />
<?php

} else {

?>

                 <H6>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $t; ?></h6>

			      <table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
                                <tr>
                                   <th align="center">Tests Run: <?php echo $num; ?></th><th align="center">Best Score: <?php echo $max; ?></th><th align="center">Avg. Score: <?php echo $avg; ?></th>
                                </tr>
			      </table><br />


	        <h6>&nbsp;&nbsp;&nbsp;&nbsp;Last 15 Tests</h6>
				<table width="94%" cellpadding="9" cellspacing="1" align="center" class="forumline">
                                <tr><th align="center">Date</th><th align="center">PHPspeed</th><th align="center">PHP</th><th align="center">MySQL</th><th align="center">Tests</th><th align="center">Iterations</th><th align="center">Time</th><th align="center">Score</th></tr>
<?php
while ($row = mysql_fetch_assoc($result)) {
	echo "<tr><td class=\"row1\">" . date("m/d/y", $row["timestamp"]) . "</td><td class=\"row1\">" . $row["phpspeed_version"] . "</td><td class=\"row1\">" . $row["php_version"] . "</td><td class=\"row1\">" . $row["mysql_version"] . "</td><td class=\"row1\" align=\"center\">" . $row["tests_run"] . "</td><td class=\"row1\" align=\"center\">" . $row["iterations"] . "</td><td class=\"row1\" align=\"center\">" . $row["total_time"] . "</td><td class=\"row1\" align=\"center\">" . $row["score"] . "</td></tr>";
}
?>
					</table>
<?php
echo "<table width=\"94%\" cellpadding=\"8\" cellspacing=\"1\" class=\"forumline\" align=\"center\">
          <tr>
              <td class=\"row2\" align=\"right\">
                   <a href=\"".$_SERVER['PHP_SELF']."?bench=$r&erase=1\"><img src=\"inc/images/delete.png\" align=\"middle\" border=\"0\"></a> <span class=\"gensmall\"><a href=\"".$_SERVER['PHP_SELF']."?bench=$r&erase=1\">Delete</a></span> &nbsp;&nbsp;&nbsp;
                   <a href=\"".$_SERVER['PHP_SELF']."?bench=$r&csv=1\"><img src=\"inc/images/csv.png\" border=\"0\"></a> <span class=\"gensmall\"> <a href=\"".$_SERVER['PHP_SELF']."?bench=$r&csv=1\">Save CSV</a></span>
               </td>
           </tr>
      </table>";
}
?>

</body>
</html>
