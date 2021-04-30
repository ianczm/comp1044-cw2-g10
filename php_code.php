<?php 
	require_once("dbtools.inc.php");
	session_start();

	$db = mysqli_connect('localhost:3307', 'cw2', '123456', 'cw2-entertainment');
	$link=create_connection();

	function deleteData($db, $id_field_name, $id, $table) {
		$sql = "
			DELETE FROM $table WHERE $id_field_name=$id
		";

		if ($db->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: ".$db->error;
		}
	}

	function insertData($db, $table, $fieldnames) {

		// $field_name_array = array();
		// for ($i=0; $i<$total_fields; $i++) {

		// 	$temp = $i;
		// 	$field_name = mysqli_fetch_field_direct($result, $i)->name;
		// 	array_push($field_name_array, $field_name);
		// }

		$sql = 'INSERT INTO '.$table.' ('.$fieldnames.') VALUES ("'.implode('", "', $_POST['fields']).'")';

		if ($db->query($sql) === TRUE) {
			echo "Record added successfully";
		} else {
			echo "Error adding record: ".$db->error;
		}

		// if ($db->query($sql) === TRUE) {
		// 	echo "Search successful";
		// } else {
		// 	echo "Error searching: ".$db->error;
		// }
	}

	function searchData($table, $search, $fieldnames) {

		$fieldnames_array = explode(", ", $fieldnames);

		$like_string = "$fieldnames_array[0] LIKE '%$search%'";
		for ($i=1; $i<count($fieldnames_array); $i++) {
			$like_string .= " OR $fieldnames_array[$i] LIKE '%$search%'";
		}

		$sql = "SELECT * FROM $table WHERE $like_string";

		return $sql;
    }

	// initialize variables
	// $actor_id = "actor_id";
	$first_name = "first_name";
	$last_name = "last_name";
	$last_update = "last_update";
	$actor_id = 1;
	$update = false;

	// if (isset($_POST['save'])) {
	// 	$actor_id = $_POST['actor_id'];
	// 	$first_name = $_POST['first_name'];
	//     $last_name = $_POST['last_name'];
	// 	$last_update = $_POST['last_update'];

	// 	mysqli_query($db, "INSERT INTO actor (actor_id, first_name, last_name, last_update) VALUES ('$actor_id', '$first_name', '$last_name', '$last_update')"); 
	// 	$_SESSION['message'] = "Saved!"; 
	// 	header('location: COMP1044.php');
	// }

    // if (isset($_POST['update'])) {
	// 	$actor_id = $_POST['actor_id'];
	// 	$first_name = $_POST['first_name'];
	//     $last_name = $_POST['last_name'];
	// 	$last_update = $_POST['last_update'];

	// mysqli_query($db, "UPDATE actor SET actor_id='$actor_id', first_name='$first_name', last_name='$last_name', last_update='$last_update' WHERE actor_id=$actor_id");
	// $_SESSION['message'] = "Updated!"; 
	// header('location: COMP1044.php');

	if (isset($_POST['del'])) {
		$del_table_array = unserialize($_POST['del']);
		deleteData($db, ...$del_table_array);
	}

	if (isset($_POST['save'])) {
		$table = $_POST['save'];
		$fieldnames_string = $_SESSION['fieldnames'];
		insertData($db, $table, $fieldnames_string);
	}

	if (isset($_POST['search-box'])) {
		$search = $_POST['search-box'];
		$_SESSION['search_sql'] = searchData($_SESSION['table'], $search, $_SESSION['fieldnames']);
		$_SESSION['is_search'] = 1;
	}



?>