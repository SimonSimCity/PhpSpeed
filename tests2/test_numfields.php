<?php

function test_numfields($base) {

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

$sql = "SELECT * FROM test_table";
$result = mysql_query($sql,$con);
mysql_num_fields($result);

}

mysql_close($con);

    return test_end(__FUNCTION__);
}

function test_numfields_enabled() {
    return TRUE;
}

?>
