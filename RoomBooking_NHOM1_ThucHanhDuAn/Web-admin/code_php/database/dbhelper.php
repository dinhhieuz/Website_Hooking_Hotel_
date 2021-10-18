<?php
require_once ('config.php');

// ------------ One Query - Hàm để thực hiện Insert, Update, Delete và Return 1 note
function execute($sql) {
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	mysqli_query($con, $sql);

	//close connection
	mysqli_close($con);
}
// ------------ Multi Query - Hàm để thực hiện Insert, Update, Delete 
function Multiexecute($sql) {
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	$con->multi_query($sql);

	//close connection
	mysqli_close($con);
}
// ------------ Hàm để thực hiện Select và Return DataTable
function executeResult($sql) {
	//save data into table
	// open connection to database
	
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$data   = [];
	
	while ($row = mysqli_fetch_array($result, 1)) {
		$data[] = $row;
	}

	//close connection
	mysqli_close($con);

	return $data;
}
// ------------ Hàm để thực hiện Select và Return 1 arrgument
function executeSingleResult($sql) {
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$row    = mysqli_fetch_array($result, 1);

	//close connection
	mysqli_close($con);

	return $row;
}
