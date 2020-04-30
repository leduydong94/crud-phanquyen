<?php 

// session_start();
include "connection.php";

	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	$limit = 5;

	$offset = $limit * ($page - 1);

	// $keyword = "";

	if (isset($_GET['keyword'])) {
		$keyword = $_GET['keyword'];
	} else {
		$keyword = "";
	}

	if ($_SESSION['role'] == 1) {
		$url = "readDataAdmin.php?";
	} else {
		$url = "readDataMember.php?";
	}
	

	$sql = "SELECT * FROM users as u LEFT JOIN classes as c ON u.class_id = c.class_id LIMIT $limit OFFSET $offset";
	$sqlTotal 	= "SELECT COUNT(*) AS total FROM users";


	if ($keyword != null) {
		$sql 		= "SELECT * FROM users as u JOIN classes as c ON u.class_id = c.class_id WHERE name LIKE '%{$keyword}%' LIMIT $limit OFFSET $offset";
		$sqlTotal 	= "SELECT count(*) AS total FROM users WHERE name LIKE '%{$keyword}%'";
		$url 		= "readData.php?keyword=" . $keyword . "&"; 
	}

	// var_dump($sqlTotal); exit;

	$successTotal = $conn->query($sqlTotal);
	// var_dump($successTotal); exit;

	if ($successTotal) {
			$totalRecord = $successTotal->fetch_assoc()['total'];
	}

	// $totalPage = ceil($totalRecord/$limit);
	// var_dump($totalPage); exit;

	$success = $conn->query($sql);

	$users = [];

	if ($success) {
		if ($success->num_rows >0) {
			while ($row = $success->fetch_assoc()) {
				$users[] = $row;
			}
		}
	}

	$totalPage = ceil($totalRecord/$limit);
	// var_dump($users); exit;


	// var_dump($totalRecord); exit;
 ?>