<?php

function test_sumcolumn($base) {

include "config_db.php";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");
mysql_select_db($dbname) or die('Could not select database');

     if (!$con) {
     test_regression(__FUNCTION__);
     }

mysql_query("SELECT SUM(t5) FROM test_table") or die(mysql_error());

}

mysql_close($con);

    return test_end(__FUNCTION__);
}

function test_sumcolumn_enabled() {
    return TRUE;
}

?>
