<?php

function formate_comment($string)
{
	$exploded = explode("E+[zk#", $string);
	foreach ($exploded as $key => $value)
	{
		if ($value)
		{?>
			<li><?php echo $value; ?></li><?php
		}
	}
}

?>
