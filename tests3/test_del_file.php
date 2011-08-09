<?php

function test_del_file($base) {

$path = (dirname(__FILE__));
$filename = "test_file.dat";
$file = "$path/temp_dir/$filename";

    $t = $base;
    test_start(__FUNCTION__);    
 
if (file_exists($file)) {
unlink($file);
}

    return test_end(__FUNCTION__);
}

function test_del_file_enabled() {
    return TRUE;
}

?>
