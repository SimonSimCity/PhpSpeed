<?php

function test_1_create_dir($base) {

$path = dirname(__FILE__) ;
$dir = "temp_dir";
$filename = "test_file.dat";
$file = "$path/$dir";

    $t = $base;
    test_start(__FUNCTION__);    
 
if (!file_exists($file)) {
mkdir($file, 0777);
}

if (!is_writeable($file)) {
die ("Your temp folder is not writeable - CHMOD your tests3 folder to 775 or 777");
}

    return test_end(__FUNCTION__);
}

function test_1_create_dir_enabled() {
    return TRUE;
}

?>
