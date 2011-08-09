<?
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
include "inc/functions.server.php";

$self = $_SERVER['PHP_SELF'];
$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
if(!$db->db_connect_id)
{
	message_die(CRITICAL_ERROR, "Could not connect to the database");
}

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);

$tests_run = $ver['tests_run'];
$new_tests = ($tests_run + 1);

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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<title>PHPspeed | <? echo $_SERVER['HTTP_HOST']; ?></title>
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
	<span class="maintitle">PHPspeed <? echo $ver['version']; ?></span><br />
       <span class="mainmenu"><a href="index.php">Home</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
       <a href="phpinfo.php">PHP Info</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
       <a href="mysql.php">MySQL Info</a>&nbsp;&nbsp;&#149;&nbsp;&nbsp;
       <a href="info.php">System Info</a></span>
       </td>
       <td align="right">
<? echo $login; ?>
       </td>
   </tr>
</table>

<?php

ignore_user_abort(TRUE);
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush(1);

define('CSV_SEP', ',');
define('CSV_NL', "\n");
define('DEFAULT_BASE', 300);
define('MIN_BASE', 2);
////define('DEFAULT_BASE', 300);
//define('MIN_BASE', 10);

$TESTS_DIRS = array('tests3');

$test = isset($_GET['test']) ? htmlentities(addslashes($_GET['test'])) : '';

if ($test != 'go') {

	echo "
<H6>&nbsp;&nbsp;&nbsp;&nbsp;Benchmark # 3 | Read/Write to File Test</h6>
    <table width=\"94%\" cellpadding=\"10\" cellspacing=\"1\" align=\"center\" class=\"forumline\">
        <tr>
          <td class=\"row2\">
              This tests measures how fast your server reads and writes to files on the hard drive.  This test is a good
              indicator of the effectiveness of hardware tweaks.  This test is also affected by the speed of your CPU, and
              the amount of memory you have.
               <br /><br />
               &nbsp;<u>Testing Guidelines:</u>
               &nbsp;<li>Always run tests when your server is least busy</li>
               &nbsp;<li>Run each test several times and take the best score</li>
               &nbsp;<li>Remember to write down any tweaks you make and the date</li>
             <br /><br />
             The tests are each run multiple times and the average of each, along with the total is
             returned.  Upon completion you can save your results so that after you make tweaks you
             can compare between tests.<br /><br />
             To begin this test click <a href=\"runtests3.php?test=go\">&raquo; here</a>
          </td>
        </tr>
    </table>
";

} else {

	if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {

		//**** This is the output for the test name below

		function test_start($func) {
			global $GLOBAL_TEST_FUNC;
			global $GLOBAL_TEST_START_TIME;

			$GLOBAL_TEST_FUNC = $func;
			echo "<b>" . sprintf('%34s', $func) . "</b> ... \t";
			flush();
			list($usec, $sec) = explode(' ', microtime());
			$GLOBAL_TEST_START_TIME = $usec + $sec;
		}

		//**** This is the output for the test time below

		function test_end($func) {
			global $GLOBAL_TEST_FUNC;
			global $GLOBAL_TEST_START_TIME;

			list($usec, $sec) = explode(' ', microtime());
			$now = $usec + $sec;
			if ($func !== $GLOBAL_TEST_FUNC) {
				trigger_error('Wrong func: [' . $func . '] ' .
				'vs ' . $GLOBAL_TEST_FUNC);
				return FALSE;
			}
			if ($now < $GLOBAL_TEST_START_TIME) {
				trigger_error('Wrong func: [' . $func . '] ' .
				'vs ' . $GLOBAL_TEST_FUNC);
				return FALSE;
			}
			$duration = $now - $GLOBAL_TEST_START_TIME;
			echo sprintf('%9.04f', $duration) . ' seconds' . "&nbsp;&nbsp;|&nbsp;\n";

			return $duration;
		}

		function test_regression($func) {
			trigger_error('* REGRESSION * [' . $func . ']' . "\n");
			die();
		}

		function do_tests($base, &$tests_list, &$results) {
			foreach ($tests_list as $test) {
				$results[$test] = call_user_func($test, $base, $results);
			}
		}

		function load_test($tests_dir, &$tests_list) {
			if (($dir = @opendir($tests_dir)) === FALSE) {
				return FALSE;
			}
			$matches = array();
			while (($entry = readdir($dir)) !== FALSE) {
				if (preg_match('/^(test_.+)[.]php$/i', $entry, $matches) <= 0) {
					continue;
				}
				$test_name = $matches[1];
				include_once($tests_dir . '/' . $entry);
				flush();
				if (!function_exists($test_name . '_enabled')) {
					echo 'INVALID !' . "\n";
					continue;
				}
				if (call_user_func($test_name . '_enabled') !== TRUE) {
					echo 'disabled.' . "\n";
					continue;
				}
				if (!function_exists($test_name)) {
					echo 'BROKEN !' . "\n";
					continue;
				}
				array_push($tests_list, $test_name);
			}
			closedir($dir);

			return TRUE;
		}

		function load_tests(&$tests_dirs, &$tests_list) {
			$ret = FALSE;

			foreach ($tests_dirs as $tests_dir) {
				if (load_test($tests_dir, $tests_list) === TRUE) {
					$ret = TRUE;
				}
			}
			if (count($tests_list) <= 0) {
				return FALSE;
			}
			asort($tests_list);

			return $ret;
		}

		function csv_escape($str) {
			if (strchr($str, CSV_SEP) !== FALSE) {
				return '"' . str_replace('"', '\'', $str) . '"';
			}
			return $str;
		}

		function export_csv($csv_file, &$results, &$percentile_times) {
			if (empty($csv_file)) {
				return TRUE;
			}
			if (($fp = fopen($csv_file, 'w')) === FALSE) {
				return FALSE;
			}
			if (fputs($fp, csv_escape('Test') . CSV_SEP . csv_escape('Time') . CSV_SEP .
			csv_escape('Percentile') . CSV_NL)
			=== FALSE) {
				@fclose($fp);
				unlink($csv_file);
				return FALSE;
			}
			foreach ($results as $test => $time) {
				if (fputs($fp, csv_escape($test) . CSV_SEP .
				csv_escape(sprintf('%.04f', $time)) . CSV_SEP .
				csv_escape(sprintf('%.03f', $percentile_times[$test])) .
				CSV_NL) === FALSE) {
					@fclose($fp);
					unlink($csv_file);
					return FALSE;
				}
			}
			if (fclose($fp) === FALSE) {
				return FALSE;
			}
			return TRUE;
		}

		function show_summary($base, &$results, $csv_file) {
			$total_time = 0.0;
			foreach ($results as $test => $time) {
				$total_time += $time;
			}
			if ($total_time <= 0.0) {
				die('Not enough iterations, please try with more.' . "\n");
			}
			$percentile_times = array();
			foreach ($results as $test => $time) {
				$percentile_times[$test] = $time * 100.0 / $total_time;
			}
			$score = (float) $base * 80.0 / $total_time;

			//Insert into DB
			global $db, $dbhost, $dbuname, $dbpass, $dbname, $ver, $cpu_info, $uptime, $tot_mem, $percent_used, $new_tests;

			$result = $db->sql_query("INSERT INTO results3
    VALUES ('','" . time() . "','$cpu_info','$uptime','" . round(($tot_mem/1024),2) . " GB -  $percent_used % Used','{$ver['version']}','" . phpversion() . "','" . mysql_get_server_info() . "','" . $_SERVER['SERVER_SOFTWARE'] . "','" . serialize($results) . "','" . count($results) . "','$base','" . round($total_time) . "','" . round($score) . "','" . $_SERVER['HTTP_HOST'] . "')");

			$result2 = $db->sql_query("UPDATE phpspeed_config SET tests_run ='$new_tests', last_test = " . time() . "");

			echo
			'<br /><br />Tests      : ' . count($results) . "\n" .
			'<br />Iterations : ' . $base . "\n" .
			'<br />Total time : ' . round($total_time) . ' seconds' . "\n" .
			'<br />Score      : ' . round($score) . ' (higher is better)' . "\n";

			if ($csv_file !== FALSE) {
				export_csv($csv_file, $results, $percentile_times);
			}
		}

		$base = DEFAULT_BASE;
		$csv_file = FALSE;

		////
		if (function_exists('getopt')) {
			$options = getopt('f:hi:');
		} else {
			$options = array();
		}
		////

		if (!empty($options['f'])) {
			$csv_file = $options['f'];
			if (preg_match('/[.]csv$/i', $csv_file) <= 0) {
				$csv_file .= '.csv';
			}
		}
		if (!empty($options['i']) && is_numeric($options['i'])) {
			$base = $options['i'];
		}
		if ($base < MIN_BASE) {
			die('Min iterations = ' . MIN_BASE . "\n");
		}

		echo '<h6>&nbsp;&nbsp;&nbsp;&nbsp;Performing the benchmark. Please be patient while the tests are conducted</h6>';
		echo "<div class=\"testoutput\"><div class=\"testoutputtext\">";

		if (function_exists('phpversion')) {
			echo 'PHP version: ' . phpversion() . "<br />\n";
		}
		echo 'MySQL version: ' . mysql_get_server_info() . "<br />\n";
		echo 'Server Software: ' . $_SERVER['SERVER_SOFTWARE'] . "<br />\n";
		echo 'Date       : ' . date('F j, Y, g:i a') . "<br /><br />\n";

		$tests_list = array();
		$results = array();
		if (load_tests($TESTS_DIRS, $tests_list) === FALSE) {
			die('Unable to load tests');
		}
		echo "\n";
		do_tests($base, $tests_list, $results);
		echo "\n";
		show_summary($base, $results, $csv_file);
		echo "<br /><a href=\"runtests3.php?test=go\">Run again</a> | <a href=\"benchhistory.php?bench=3\">&raquo; Test history</a></div></div>\n";

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


}

?>
   </div>

</body>
</html>
