<?php
	include 'includes/session.php';

	
	
	if(isset($_POST['create'])){
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$password = $_POST['password'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		$password = password_hash($password, PASSWORD_DEFAULT);
		// $positionid = $_POST['positionid'];
		$acctype = $_POST['acctype'];
		// $department = $_GET['department'];
		// $schedule = $_GET['schedule'];

		// $sql = "SELECT *, users.id as id FROM users LEFT JOIN position ON position.id=users.position_id LEFT JOIN departments ON departments.id=users.department_id LEFT JOIN schedules ON schedules.id=users.schedule_id WHERE employees.id = '$id'";
	
		$sql = "INSERT INTO admin (username, password, firstname, lastname, photo, account_type, created_on) 
		VALUES ('$id','$password', '$firstname', '$lastname', '$filename', '$acctype',NOW())";
		
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