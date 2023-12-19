<?php


function getPOST($key) {
	$value = '';
	if (isset($_POST[$key])) {
		$value = $_POST[$key];
	}
	return $value;
}

function checkInput($con, $key){
	$value = getPOST($key);
	$value = trim($value);
	$value = stripslashes($value);
	$value = htmlspecialchars($value);
	$value = pg_escape_string($con, $value);
	return $value;
}
?>