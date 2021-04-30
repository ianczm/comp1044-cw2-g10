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
	// echo "<table width='400' border='1'><tr align='center'>";
	$i=0;
	while($i<mysqli_num_fields($result))
	{
		$meta=mysqli_fetch_field_direct($result, $i);
		$i++;
	}
	echo"</table>";
	mysqli_close($link);
	?>
</body>
</html>