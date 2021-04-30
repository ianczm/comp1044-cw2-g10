<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>connect to database</title>
</head>
<body>
<?php
$link=mysqli_connect("localhost:3307", "cw2", "123456")or die("Failed to connect: ");
echo "connect successful";
?>
</body>
</html>