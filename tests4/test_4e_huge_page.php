<?php

function test_4e_huge_page($base) {
    $t = $base;
    test_start(__FUNCTION__);

$path = basename(dirname(__FILE__));

for ( $counter = 0; $counter <= $t; $counter += 1) {
$counter;
file("$path/index4.php");

}

    return test_end(__FUNCTION__);
}

function test_4e_huge_page_enabled() {
    return TRUE;
}

?>
