<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
	<?php
	require_once("dbtools.inc.php");
	$link=create_connection();
	$sql="SELECT* FROM actor";
	$result=execute_sql($link, "cw2-entertainment", $sql);
	mysqli_close($link);
	?>
</body>
</html>