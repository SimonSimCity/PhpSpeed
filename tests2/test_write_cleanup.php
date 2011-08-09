<?php

function test_write_cleanup($base) {

include "config_db.php";

    $t = $base;
    test_start(__FUNCTION__);    
 
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");
mysql_select_db($dbname) or die('Could not select database');

     if (!$con) {
     test_regression(__FUNCTION__);
     }

mysql_query("TRUNCATE TABLE test_table");

mysql_close($con);

    return test_end(__FUNCTION__);
}

function test_write_cleanup_enabled() {
    return TRUE;
}

?>
