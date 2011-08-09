<?php

function test_5_fileinfo($base) {

$path = (dirname(__FILE__));
$filename = "test_file.dat";
$file = "$path/temp_dir/$filename";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;

$a = is_file($file);
$b = is_writeable($file);
$c = is_readable($file);
////$d = is_executable($file);
if ( function_exists( "is_executable" ) ) {
	$d = is_executable($file);
} else {
	$d = false;
}
$e = fileatime($file);
$f = filemtime($file);
$g = filectime($file);
$h = filesize($file);

}

return test_end(__FUNCTION__);
}

function test_5_fileinfo_enabled() {
    return TRUE;
}

?>
