<?php

function test_del_tempdir($base) {

$path = dirname(__FILE__) ;
$dir = "temp_dir";
$filename = "test_file.dat";
$file = "$path/$dir";

test_start(__FUNCTION__);    
 
if (file_exists($file)) {
rmdir($file);
}

    return test_end(__FUNCTION__);
}

function test_del_tempdir_enabled() {
    return TRUE;
}

?>
