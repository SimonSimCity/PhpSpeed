<?php

function test_2_create_tempfile($base) {

$path = (dirname(__FILE__));
$filename = "test_file.dat";
$file = "$path/temp_dir/$filename";

    $t = $base;
    test_start(__FUNCTION__);    
 
if (!file_exists($file)) {
touch($file);
chmod($file, 0666);
}

if (!is_writeable($file)) {
die ("Your temp file is not writeable");
}

    return test_end(__FUNCTION__);
}

function test_2_create_tempfile_enabled() {
    return TRUE;
}

?>
