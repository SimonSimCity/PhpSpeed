<?php

function test_9_readdir($base) {

$dir = "tests3";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;

$dh = opendir($dir);
	while (!(($file = readdir($dh)) === false )) {
	is_dir("$dir/$file");
       }
       closedir($dh);
}

return test_end(__FUNCTION__);
}

function test_9_readdir_enabled() {
    return TRUE;
}

?>
