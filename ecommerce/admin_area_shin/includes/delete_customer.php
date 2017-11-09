<?php
	include("dbUdemy.php");

	if(isset($_GET['delete_customer'])){

	$delete_id = $_GET['delete_customer'];

	$delete_customer = "DELETE FROM customersudemy WHERE customer_id='$delete_id'";

	$run_delete = mysqli_query($conn, $delete_customer);

	if($run_delete){

	echo "<script>alert('A customer has been deleted!')</script>";
	echo "<script>window.open('../index.php?view_customers','_self')</script>";
	}

	}





?>
