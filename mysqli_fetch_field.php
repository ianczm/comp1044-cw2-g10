<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>column's data</title>
</head>
<body>
	<?php
	require_once("dbtools.inc.php");

	$link=create_connection();
	$sql="SELECT* FROM actor";
	$result=execute_sql($link, "cw2-entertainment", $sql);


	while($i<mysqli_num_field($result))
	{

	}
	echo"</table>";
	mysqli_close($link);
	?>
</body>
</html>