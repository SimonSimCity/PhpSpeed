<?php

function test_connect_db($base) {

include "config_db.php";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;
$con = mysql_connect($dbhost,$dbuname,$dbpass) or die("Cant connect to MySQL");

     if (!$con) {
     test_regression(__FUNCTION__);
     }
}
mysql_close($con);

    return test_end(__FUNCTION__);
}

function test_connect_db_enabled() {
    return TRUE;
}

?>
