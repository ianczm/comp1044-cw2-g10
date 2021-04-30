<?php
function create_connection()
{
	$link=mysqli_connect("localhost:3307", "cw2", "123456")
	or die("Failed to connect: ".mysqli_connect_error());
	mysqli_query($link, "SET NAMES utf8");
	return $link;
}

function execute_sql($link, $database, $sql)
{
	mysqli_select_db($link, $database)
	or die("Failed to open database: ".mysqli_error($link));
	$result=mysqli_query($link, $sql);
	return $result;
}
?>