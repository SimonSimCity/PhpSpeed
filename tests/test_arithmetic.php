<?php

function test_arithmetic($base) {
	$t = $base;
	test_start(__FUNCTION__);
	do {
		$a = 5;
		$b = - $a;
		$a = $a + $b;
		$b = $a - $b;
		$a = $a * $b;
		$c = $a;
		@$b = ($a == 0) ? 0 : ($b / $a);
		@$a = ($b == 0) ? 0 : ($a % $b);
	} while (--$t !== 0);

	if (!(empty($a) && empty($b)) || $c !== 0) {
		test_regression(__FUNCTION__);
	}
	return test_end(__FUNCTION__);
}

function test_arithmetic_enabled() {
	return TRUE;
}

?>
