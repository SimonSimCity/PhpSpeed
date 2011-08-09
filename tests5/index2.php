<?php
include "../config_db.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?></title>
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="start" title="Home" href="http://www.phpspeed.com/" />
	<link rel="stylesheet" type="text/css" media="screen" href="../screen.css" />
	<!--[if lt ie 7]><link rel="stylesheet" type="text/css" media="screen" href="../ie-win.css" /><![endif]-->
</head>

<body id="babout">

	<div id="header">
	
		<h1>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?></h1>
	
	</div>
	
	<div id="navigation">
	
		<ul>
			<li id="lhome"><a href="/">&raquo; Home</a></li>
			<li id="lhome"><a href="/">&raquo; View Results</a></li>
			<li id="lhome"><a href="/">&raquo; PHP Info</a></li>
                     <li id="lhome"><a href="/">&raquo; MySQL Info</a></li>
                     <li id="lhome"><a href="/">&raquo; System Info</a></li>
		</ul>
	
	</div>

	<div id="wrapper">
	
		<div id="content-wrapper">
			
			<div id="content">		
                   
                            <h2>PHP Benchmark</h2>
				
                              <dl>
				
			           <dt>Benchmark #1</dt>
					<dd>
                                         <b><u>Synthetic PHP BenchMark:</u></b>&nbsp;
					
							This set of benchmarks is designed to test various functions within PHP.  The tests are  
							each run multiple times and the average of each, along with the total is
                                                saved to your results database. <a href="/">&raquo; Start Test</a>
						
                      
					</dd>

                                   <dt>Benchmark #2</dt>

				       <dd>
					       <b><u>Synthetic MySQL BenchMark:</u></b>&nbsp;

                                                This set of benchmarks will measure the speed of MySQL through the performance of several
                                                DB reads and writes using MySQL's built in benchmark features.  It will also test your connection 
                                                speed to the MySQL database.  <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                  <dt>Benchmark #3</dt>

					<dd>
                                         <b><u>Synthetic Read/Write BenchMark:</u></b>&nbsp;
                                         
                                                PHPSpeed reads and writes multiple lines of data to a txt file to test the 
                                                read and write speed of PHP.  This is a good way to validate if system wide tweaks are improving
                                                the read and write speed of your server.  <a href="/">&raquo; Start Test</a>

                                        
                                  </dd>
					<dt>Benchmark #4</dt>
					<dd>
                                         <b><u>Real World PHP BenchMark:</u></b>&nbsp;
                               
                                                This benchmark measures the load time of 4 PHP pages of various sizes.  There are no DB calls, this  
                                                test will measure the real world time for someone to load a PHP page on your server. 
                                                <a href="/">&raquo; Start Test</a>

                                  </dd>
					<dt>Benchmark #5</dt>
					<dd>
                                         <b><u>Real World PHP & MySQL BenchMark:</u></b>&nbsp;
                                  
                                                This benchmark measures the time to load 4 PHP pages WITH MySQL DB calls. MySQL cacheing will positively affect 
                                                the outcome of this test.  You can measure the benefit of cacheing by running the test with cacheing enabled and 
                                                disabled. </em> <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                    <dt>Benchmark #6</dt>
					<dd>
                                         <b><u>Find out your PHPspeed!</u></b>&nbsp;
                                  
                                                This is our all-in-one benchmark that will use sections of all of the above tests to give you a thorough
                                                indication of the speed of your server.  Compare your PHPspeed to other webmasters with similar configurations
                                                to determine if you are maximizing your performance. </em>  <a href="/">&raquo; Start Test</a>
                                        
                                  </dd>
				
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
                                 
				
				</ul>
<?php
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");
mysql_select_db($dbname) or die('Could not select database');

    $sql = "SELECT * FROM phpspeed_config";
    $result = mysql_query($sql,$con);
    $ver = mysql_fetch_assoc($result);

mysql_close($con);
?>
				<h3>Version Info</h3>
				
				<ul>
					<li>PHP: <b><?php echo phpversion(); ?></b></li>
					<li>MySQL: <b><?php printf(mysql_get_server_info()); ?></b></li>
					<li><?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                                  <li>PHPspeed: <b><?php echo $ver['version']; ?></b></li>
				</ul>

				<h3>PHPspeed Stats</h3>
				
				<ul>
					<li>Tests Run:</li>
					<li>Last Test:</li>
				</ul>

                           <h3>Powered by Links</h3>
                           <ul>
                                 <center>
                                  <img src="../images/phpspeed.jpg" width="120" height="60" vspace="4">
                                  <img src="../images/phpspeedblu.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedgre.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedred.png" width="80" height="15" vspace="4">
                                 </center>
				</ul>
			</div>
		
		</div>
	
	</div>
	
<div id="header">
	
		<h1>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?></h1>
	
	</div>
	
	<div id="navigation">
	
		<ul>
			<li id="lhome"><a href="/">&raquo; Home</a></li>
			<li id="lhome"><a href="/">&raquo; View Results</a></li>
			<li id="lhome"><a href="/">&raquo; PHP Info</a></li>
                     <li id="lhome"><a href="/">&raquo; MySQL Info</a></li>
                     <li id="lhome"><a href="/">&raquo; System Info</a></li>
		</ul>
	
	</div>

	<div id="wrapper">
	
		<div id="content-wrapper">
			
			<div id="content">		
                   
                            <h2>PHP Benchmark</h2>
				
                              <dl>
				
			           <dt>Benchmark #1</dt>
					<dd>
                                         <b><u>Synthetic PHP BenchMark:</u></b>&nbsp;
					
							This set of benchmarks is designed to test various functions within PHP.  The tests are  
							each run multiple times and the average of each, along with the total is
                                                saved to your results database. <a href="/">&raquo; Start Test</a>
						
                      
					</dd>

                                   <dt>Benchmark #2</dt>

				       <dd>
					       <b><u>Synthetic MySQL BenchMark:</u></b>&nbsp;

                                                This set of benchmarks will measure the speed of MySQL through the performance of several
                                                DB reads and writes using MySQL's built in benchmark features.  It will also test your connection 
                                                speed to the MySQL database.  <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                  <dt>Benchmark #3</dt>

					<dd>
                                         <b><u>Synthetic Read/Write BenchMark:</u></b>&nbsp;
                                         
                                                PHPSpeed reads and writes multiple lines of data to a txt file to test the 
                                                read and write speed of PHP.  This is a good way to validate if system wide tweaks are improving
                                                the read and write speed of your server.  <a href="/">&raquo; Start Test</a>

                                        
                                  </dd>
					<dt>Benchmark #4</dt>
					<dd>
                                         <b><u>Real World PHP BenchMark:</u></b>&nbsp;
                               
                                                This benchmark measures the load time of 4 PHP pages of various sizes.  There are no DB calls, this  
                                                test will measure the real world time for someone to load a PHP page on your server. 
                                                <a href="/">&raquo; Start Test</a>

                                  </dd>
					<dt>Benchmark #5</dt>
					<dd>
                                         <b><u>Real World PHP & MySQL BenchMark:</u></b>&nbsp;
                                  
                                                This benchmark measures the time to load 4 PHP pages WITH MySQL DB calls. MySQL cacheing will positively affect 
                                                the outcome of this test.  You can measure the benefit of cacheing by running the test with cacheing enabled and 
                                                disabled. </em> <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                    <dt>Benchmark #6</dt>
					<dd>
                                         <b><u>Find out your PHPspeed!</u></b>&nbsp;
                                  
                                                This is our all-in-one benchmark that will use sections of all of the above tests to give you a thorough
                                                indication of the speed of your server.  Compare your PHPspeed to other webmasters with similar configurations
                                                to determine if you are maximizing your performance. </em>  <a href="/">&raquo; Start Test</a>
                                        
                                  </dd>
				
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
                                 
				
				</ul>
<?php
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");
mysql_select_db($dbname) or die('Could not select database');

    $sql = "SELECT * FROM phpspeed_config";
    $result = mysql_query($sql,$con);
    $ver = mysql_fetch_assoc($result);

mysql_close($con);
?>
				<h3>Version Info</h3>
				
				<ul>
					<li>PHP: <b><?php echo phpversion(); ?></b></li>
					<li>MySQL: <b><?php printf(mysql_get_server_info()); ?></b></li>
					<li><?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                                  <li>PHPspeed: <b><?php echo $ver['version']; ?></b></li>
				</ul>

				<h3>PHPspeed Stats</h3>
				
				<ul>
					<li>Tests Run:</li>
					<li>Last Test:</li>
				</ul>

                           <h3>Powered by Links</h3>
                           <ul>
                                 <center>
                                  <img src="../images/phpspeed.jpg" width="120" height="60" vspace="4">
                                  <img src="../images/phpspeedblu.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedgre.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedred.png" width="80" height="15" vspace="4">
                                 </center>
				</ul>
			</div>
		
		</div>
	
	</div>
	<div id="header">
	
		<h1>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?></h1>
	
	</div>
	
	<div id="navigation">
	
		<ul>
			<li id="lhome"><a href="/">&raquo; Home</a></li>
			<li id="lhome"><a href="/">&raquo; View Results</a></li>
			<li id="lhome"><a href="/">&raquo; PHP Info</a></li>
                     <li id="lhome"><a href="/">&raquo; MySQL Info</a></li>
                     <li id="lhome"><a href="/">&raquo; System Info</a></li>
		</ul>
	
	</div>

	<div id="wrapper">
	
		<div id="content-wrapper">
			
			<div id="content">		
                   
                            <h2>PHP Benchmark</h2>
				
                              <dl>
				
			           <dt>Benchmark #1</dt>
					<dd>
                                         <b><u>Synthetic PHP BenchMark:</u></b>&nbsp;
					
							This set of benchmarks is designed to test various functions within PHP.  The tests are  
							each run multiple times and the average of each, along with the total is
                                                saved to your results database. <a href="/">&raquo; Start Test</a>
						
                      
					</dd>

                                   <dt>Benchmark #2</dt>

				       <dd>
					       <b><u>Synthetic MySQL BenchMark:</u></b>&nbsp;

                                                This set of benchmarks will measure the speed of MySQL through the performance of several
                                                DB reads and writes using MySQL's built in benchmark features.  It will also test your connection 
                                                speed to the MySQL database.  <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                  <dt>Benchmark #3</dt>

					<dd>
                                         <b><u>Synthetic Read/Write BenchMark:</u></b>&nbsp;
                                         
                                                PHPSpeed reads and writes multiple lines of data to a txt file to test the 
                                                read and write speed of PHP.  This is a good way to validate if system wide tweaks are improving
                                                the read and write speed of your server.  <a href="/">&raquo; Start Test</a>

                                        
                                  </dd>
					<dt>Benchmark #4</dt>
					<dd>
                                         <b><u>Real World PHP BenchMark:</u></b>&nbsp;
                               
                                                This benchmark measures the load time of 4 PHP pages of various sizes.  There are no DB calls, this  
                                                test will measure the real world time for someone to load a PHP page on your server. 
                                                <a href="/">&raquo; Start Test</a>

                                  </dd>
					<dt>Benchmark #5</dt>
					<dd>
                                         <b><u>Real World PHP & MySQL BenchMark:</u></b>&nbsp;
                                  
                                                This benchmark measures the time to load 4 PHP pages WITH MySQL DB calls. MySQL cacheing will positively affect 
                                                the outcome of this test.  You can measure the benefit of cacheing by running the test with cacheing enabled and 
                                                disabled. </em> <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                    <dt>Benchmark #6</dt>
					<dd>
                                         <b><u>Find out your PHPspeed!</u></b>&nbsp;
                                  
                                                This is our all-in-one benchmark that will use sections of all of the above tests to give you a thorough
                                                indication of the speed of your server.  Compare your PHPspeed to other webmasters with similar configurations
                                                to determine if you are maximizing your performance. </em>  <a href="/">&raquo; Start Test</a>
                                        
                                  </dd>
				
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
                                 
				
				</ul>
<?php
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");
mysql_select_db($dbname) or die('Could not select database');

    $sql = "SELECT * FROM phpspeed_config";
    $result = mysql_query($sql,$con);
    $ver = mysql_fetch_assoc($result);

mysql_close($con);
?>
				<h3>Version Info</h3>
				
				<ul>
					<li>PHP: <b><?php echo phpversion(); ?></b></li>
					<li>MySQL: <b><?php printf(mysql_get_server_info()); ?></b></li>
					<li><?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                                  <li>PHPspeed: <b><?php echo $ver['version']; ?></b></li>
				</ul>

				<h3>PHPspeed Stats</h3>
				
				<ul>
					<li>Tests Run:</li>
					<li>Last Test:</li>
				</ul>

                           <h3>Powered by Links</h3>
                           <ul>
                                 <center>
                                  <img src="../images/phpspeed.jpg" width="120" height="60" vspace="4">
                                  <img src="../images/phpspeedblu.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedgre.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedred.png" width="80" height="15" vspace="4">
                                 </center>
				</ul>
			</div>
		
		</div>
	
	</div>
	
<div id="header">
	
		<h1>PHPspeed | <?php echo $_SERVER['HTTP_HOST']; ?></h1>
	
	</div>
	
	<div id="navigation">
	
		<ul>
			<li id="lhome"><a href="/">&raquo; Home</a></li>
			<li id="lhome"><a href="/">&raquo; View Results</a></li>
			<li id="lhome"><a href="/">&raquo; PHP Info</a></li>
                     <li id="lhome"><a href="/">&raquo; MySQL Info</a></li>
                     <li id="lhome"><a href="/">&raquo; System Info</a></li>
		</ul>
	
	</div>

	<div id="wrapper">
	
		<div id="content-wrapper">
			
			<div id="content">		
                   
                            <h2>PHP Benchmark</h2>
				
                              <dl>
				
			           <dt>Benchmark #1</dt>
					<dd>
                                         <b><u>Synthetic PHP BenchMark:</u></b>&nbsp;
					
							This set of benchmarks is designed to test various functions within PHP.  The tests are  
							each run multiple times and the average of each, along with the total is
                                                saved to your results database. <a href="/">&raquo; Start Test</a>
						
                      
					</dd>

                                   <dt>Benchmark #2</dt>

				       <dd>
					       <b><u>Synthetic MySQL BenchMark:</u></b>&nbsp;

                                                This set of benchmarks will measure the speed of MySQL through the performance of several
                                                DB reads and writes using MySQL's built in benchmark features.  It will also test your connection 
                                                speed to the MySQL database.  <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                  <dt>Benchmark #3</dt>

					<dd>
                                         <b><u>Synthetic Read/Write BenchMark:</u></b>&nbsp;
                                         
                                                PHPSpeed reads and writes multiple lines of data to a txt file to test the 
                                                read and write speed of PHP.  This is a good way to validate if system wide tweaks are improving
                                                the read and write speed of your server.  <a href="/">&raquo; Start Test</a>

                                        
                                  </dd>
					<dt>Benchmark #4</dt>
					<dd>
                                         <b><u>Real World PHP BenchMark:</u></b>&nbsp;
                               
                                                This benchmark measures the load time of 4 PHP pages of various sizes.  There are no DB calls, this  
                                                test will measure the real world time for someone to load a PHP page on your server. 
                                                <a href="/">&raquo; Start Test</a>

                                  </dd>
					<dt>Benchmark #5</dt>
					<dd>
                                         <b><u>Real World PHP & MySQL BenchMark:</u></b>&nbsp;
                                  
                                                This benchmark measures the time to load 4 PHP pages WITH MySQL DB calls. MySQL cacheing will positively affect 
                                                the outcome of this test.  You can measure the benefit of cacheing by running the test with cacheing enabled and 
                                                disabled. </em> <a href="/">&raquo; Start Test</a>
                                         
                                  </dd>
                                    <dt>Benchmark #6</dt>
					<dd>
                                         <b><u>Find out your PHPspeed!</u></b>&nbsp;
                                  
                                                This is our all-in-one benchmark that will use sections of all of the above tests to give you a thorough
                                                indication of the speed of your server.  Compare your PHPspeed to other webmasters with similar configurations
                                                to determine if you are maximizing your performance. </em>  <a href="/">&raquo; Start Test</a>
                                        
                                  </dd>
				
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
                                 
				
				</ul>
<?php
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");
mysql_select_db($dbname) or die('Could not select database');

    $sql = "SELECT * FROM phpspeed_config";
    $result = mysql_query($sql,$con);
    $ver = mysql_fetch_assoc($result);

mysql_close($con);
?>
				<h3>Version Info</h3>
				
				<ul>
					<li>PHP: <b><?php echo phpversion(); ?></b></li>
					<li>MySQL: <b><?php printf(mysql_get_server_info()); ?></b></li>
					<li><?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                                  <li>PHPspeed: <b><?php echo $ver['version']; ?></b></li>
				</ul>

				<h3>PHPspeed Stats</h3>
				
				<ul>
					<li>Tests Run:</li>
					<li>Last Test:</li>
				</ul>

                           <h3>Powered by Links</h3>
                           <ul>
                                 <center>
                                  <img src="../images/phpspeed.jpg" width="120" height="60" vspace="4">
                                  <img src="../images/phpspeedblu.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedgre.png" width="80" height="15" vspace="4">
                                  <img src="../images/phpspeedred.png" width="80" height="15" vspace="4">
                                 </center>
				</ul>
			</div>
		
		</div>
	
	</div>
</body>
</html>
