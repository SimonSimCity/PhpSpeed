<?php

function test_1_small_page($base) {
    $t = $base;
    test_start(__FUNCTION__);

$path = basename(dirname(__FILE__));

for ( $counter = 0; $counter <= $t; $counter += 1) {
$counter;
file("$path/index.php");
}
    return test_end(__FUNCTION__);
}

function test_1_small_page_enabled() {
    return TRUE;
}

?>
