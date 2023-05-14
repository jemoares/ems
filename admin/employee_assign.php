<?php
	include 'includes/session.php';

	if(isset($_POST['assign'])){
		$empid = $_GET['id'];
		$supervisor = $_POST['supervisor'];
	
		$sql = "UPDATE employees SET supervisor_id = '$supervisor' WHERE id = '$empid'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Employee assigned successfully';
			
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