<!-- please do not use this file -->

<!-- <?php  include('php_code.php'); ?>
<?php 
	if (isset($_GET['edit'])) {
		$actor_id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM actor WHERE actor_id=$actor_id");

		if ($record !== false && $record->num_rows == 1) {
			$n = mysqli_fetch_array($record);
			$actor_id = $n['actor_id'];
			$first_name = $n['first_name'];
			$last_name = $n['last_name'];
			$last_update = $n['last_update'];			
		}
	}
?> -->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="0; url=https://ianczm.github.io/comp1044-cw2-g10/COMP1044.php" />
	<title>actor: CReate, Update, Delete PHP MySQL</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<!-- <body>
<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
<?php endif ?>

<?php $results = mysqli_query($db, "SELECT * FROM actor"); ?>

<table>
	<thead>
		<tr>
			<th>actor_id</th>
			<th>first_name</th>
			<th>last_name</th>
			<th>last_update</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['actor_id']; ?></td>
			<td><?php echo $row['first_name']; ?></td>
			<td><?php echo $row['last_name']; ?></td>
			<td><?php echo $row['last_update']; ?></td>
			<td>
				<a href="index.php?edit=<?php echo $row['actor_id']; ?>" class="edit_btn" >Edit</a>
			</td>
			<td>
				<a href="php_code.php?del=<?php echo $row['actor_id']; ?>" class="del_btn">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>

	<form method="post" action="php_code.php" >

		<div class="input-group">
			<label>actor_id</label>
			<input type="text" name="actor_id" value="">
		</div>
		<div class="input-group">
			<label>first_name</label>
			<input type="text" name="first_name" value="">
		</div>
				<div class="input-group">
			<label>last_name</label>
			<input type="text" name="last_name" value="">
		</div>
				<div class="input-group">
			<label>last_update</label>
			<input type="text" name="last_update" value="">
		</div>
		        <div class="input-group">
            <?php if ($update == true): ?>
	            <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
            <?php else: ?>
	           <button class="btn" type="submit" name="save" >Save</button>
            <?php endif ?>
		</div>

	</form>
</body> -->
</html>
