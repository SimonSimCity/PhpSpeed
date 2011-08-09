<?php

function test_4b_append($base) {

$path = (dirname(__FILE__));
$filename = "test_file.dat";
$file = "$path/temp_dir/$filename";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;
$fp = fopen($file,"a");
fputs ($fp, "ABCDEFGHIJKLMNOPQRSTUVWXYZ - abcdefghijklmnopqrstuvwxyz - 1234567890 - uno dos tres quotro cinco seis seite ocho nueve dias\n");
}

return test_end(__FUNCTION__);
}

function test_4b_append_enabled() {
    return TRUE;
}

?>
