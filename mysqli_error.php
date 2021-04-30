<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>error message</title>
</head>
<body>
<?php
$link=@mysqli_connect("localhost:3307", "root")
	or die("Failed to connect: ".mysqli_connect_error());
echo "connect sucessful";
	mysql_close($link);
?>
</body>
</html>