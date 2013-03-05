<?php

/* http://net.tutsplus.com/tutorials/php/the-newbies-guide-to-test-driven-development/ */

$files = glob('*_test.php');

foreach ($files as $file) {
	echo '<p><a href="./'.basename($file).'">'.basename($file).'</a></p>';
}