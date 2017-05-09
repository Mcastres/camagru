<?php

function comments_number($string)
{
	$exploded = explode("E+[zk#", $string);
	$i = 0;
	foreach ($exploded as $value)
		$i++;
	echo $i - 1;
}

?>
