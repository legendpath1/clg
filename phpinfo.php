<?php
	var $conn = "";
	$conn = mysql_pconnect( "localhost:3306", "root", "root" );
	if ($conn = "") {
		echo "Connection success";
	} else {
		echo "Connection fail";
	}
?>