<?php
	function floatvalue($val){
				$val = str_replace(",",".",$val);
				$val = preg_replace('/\.(?=.*\.)/', '', $val);
				return floatval($val);
	}

	$string = "12,34";
	$number = floatvalue($string);
	
	$r = 40 + 7.5 + $number;
	
	echo $r;

?>

