<?php

// Database connection file
require_once('db_connect.php');

// Select all images from database and display them in HTML <table>.
$query = "SELECT * FROM detected_faces";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0)
{
?>

<style>
table, th, td {
  border: 1px solid black;
}
</style>

<table>
	
	<?php
	while($row = $result->fetch_assoc())
	{
	?>
	<tr>
	
		<td id="displayImg" style="display:none">
			<img src="<?=$row['image']?>" id="fetchedImage" style="max-width: 300px;" />
		</td>
		
	</tr>
	<?php
	}
	?>
</table>
<?php
}
else
{
  echo "No records found!";
}

?>