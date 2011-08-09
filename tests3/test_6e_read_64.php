<?php

function test_6e_read_64($base) {

$path = (dirname(__FILE__));
$filename = "test_file.dat";
$file = "$path/temp_dir/$filename";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;

$fp = fopen($file,"r");
while (!feof($fp)) {
     $line = fgets($fp, 64);
}

}

return test_end(__FUNCTION__);
}

function test_6e_read_64_enabled() {
    return TRUE;
}

?>
