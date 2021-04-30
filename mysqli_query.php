<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>execute SELECT cmd</title>
</head>
<body>
<?php
$link=mysqli_connect("localhost:3307", "cw2", "123456")
	or die("Failed to connect: ".mysqli_connect_error());

mysqli_select_db($link, "cw2-entertainment")
	or die("Failed to open database: ".mysqli_error($link));
	$sql="SELECT * FROM actor";
	$result=mysqli_query($link, $sql);

	mysqli_close($link);
?>
</body>
</html>