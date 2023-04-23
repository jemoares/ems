<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$acctype = $_POST['acctype'];

		if($acctype == 'Admin'){
			$sql = "SELECT * FROM admin WHERE username = '$username'";
		}
		else if($acctype == 'Manager'){
			$sql = "SELECT * FROM admin WHERE username = '$username'";
		}
		else{
			$_SESSION['error'] = 'Invalid account type';
			header('location: index.php');
			exit();
		}

		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find account with the username';
		}
		else{
			$row = $query->fetch_assoc();
			if(password_verify($password, $row['password'])){
				$_SESSION['admin'] = $row['id'];
				$_SESSION['manager'] = $row['id'];
				if($acctype == 'Admin') { 
					header('location: home.php');
				}
				else if($acctype == 'Manager') {
					header('location: manager/manager_home.php');
				}
			}
			else{
				$_SESSION['error'] = 'Incorrect password';
			}
		}
	}
	else{
		$_SESSION['error'] = 'Please enter login credentials';
		header('location: index.php');
		exit();
	}


?>