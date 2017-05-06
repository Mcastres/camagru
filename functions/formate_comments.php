<?php

function formate_comment($string)
{
	$exploded = explode("E+[zk#", $string);
	foreach ($exploded as $key => $value)
	{
		if (!empty(trim($value)))
		{?>
			<h5><?php echo $value; ?></h5><?php
		}
	}
}

?>
