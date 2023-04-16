<?php
	include 'includes/session.php';

	
	
	if(isset($_POST['create'])){
		$id = $_POST['id'];
		$password = $_POST['password'];
		// $position = $_GET['position'];
		// $department = $_GET['department'];
		// $schedule = $_GET['schedule'];

		// $sql = "SELECT *, users.id as id FROM users LEFT JOIN position ON position.id=users.position_id LEFT JOIN departments ON departments.id=users.department_id LEFT JOIN schedules ON schedules.id=users.schedule_id WHERE employees.id = '$id'";

		$sql = "INSERT INTO users (username, password,  created_on) 
		VALUES ('$id','$password', NOW())";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Employee account created successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: employee.php');
?>