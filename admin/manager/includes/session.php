<?php
session_start();
	include 'includes/conn.php';

	if(!isset($_SESSION['admin']) && !isset($_SESSION['manager'])){
		header('location: index.php');
	}

	if(isset($_SESSION['admin'])){
		$sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
		$query = $conn->query($sql);
		$user = $query->fetch_assoc();
	}
	else if(isset($_SESSION['manager'])){
		$sql = "SELECT * FROM manager WHERE id = '".$_SESSION['manager']."'";
		$query = $conn->query($sql);
		$user = $query->fetch_assoc();
	}


	
?>