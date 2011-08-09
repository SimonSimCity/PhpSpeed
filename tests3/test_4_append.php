<?php

function test_4_append($base) {

$path = (dirname(__FILE__));
$filename = "test_file.dat";
$file = "$path/temp_dir/$filename";

    $t = $base;
    test_start(__FUNCTION__);    
 
for ( $counter = 0; $counter <= $t; $counter += 1) {

$counter;
$fp = fopen($file,"a");
fputs ($fp, "I like tweaking my server! | All work and no play makes Jack a dull boy | Can you still hear the lambs screaming Clarice? | Life is what you want it to be so don't get tangled up trying to be free and don't worry what the other people see, it's nothting, fugazi | When I'm walking and I strut my stuff and I'm so strung out, high as a kite I just might stop to check you out, vfemmes |\n");
}

return test_end(__FUNCTION__);
}

function test_4_append_enabled() {
    return TRUE;
}

?>
