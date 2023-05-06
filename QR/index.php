<?php
$f = "visit.php";
if(!file_exists($f)){
	touch($f);
	$handle =  fopen($f, "w" ) ;
	fwrite($handle,0) ;
	fclose ($handle);
}
 
include('libs/phpqrcode/qrlib.php'); 

// function getUsernameFromEmail($body) {
// 	// $find = '@';
// 	// $pos = strpos($email, $find);
// 	$username = substr($email, 0, $pos);
// 	return $username;
// }

if(isset($_POST['submit']) ) {
	$tempDir = 'temp/'; 
	// $email = $_POST['mail'];
	// $subject =  $_POST['subject'];
	$body =  $_POST['msg'];
	$filename = 'EmployeeID_'.$body.'';
	$codeContents = urlencode($body); 
	QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5);
}
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
	<title>(QR) Code Generator</title>
	<link rel="stylesheet" href="libs/css/bootstrap.min.css">
	<link rel="stylesheet" href="libs/style.css">
	<script src="libs/navbarclock.js"></script>
	</head>
	<body onload="startTime()">
		<!-- <nav class="navbar-inverse" style="background-color: blue" role="navigation">
			<a href="index.php"><h1 style="color:white">QR Code Generator</h1></a>
			<div id="clockdate">
				<div class="clockdate-wrapper">
					<div id="clock"></div>
					<div id="date"><?php echo date('l, F j, Y'); ?></div>
				</div>
			</div>
		</nav> -->
		<div class="form-group">
			<!-- <h3><strong>(QR) Code Generator</strong></h3> -->
			<!-- <center/><a href="" class="form-control">Go back</a> -->
			<!-- <div class="form-control"> -->
				<!-- <h3>Please Fill-out All Fields</h3> -->
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
					<h2 style="text-align:center">QR Code Result: </h2>
					<center>
						<div class="form-group" style="border:2px solid black; width:210px; height:210px;">
							<?php echo '<img src="temp/'. @$filename.'.png" style="width:200px; height:200px;"><br>'; ?>
						</div>
							<a class="btn btn-primary submitBtn" style="width:210px; margin:5px 0;" href="download.php?file=<?php echo $filename; ?>.png ">Download QR Code</a>
					<!-- </center> -->
					<!-- <div class="form-group">
						<label>Subject</label>
						<input type="text" class="form-control" name="subject" style="width:20em;" placeholder="Enter your Email Subject" value="<?php echo @$subject; ?>" required pattern="[a-zA-Z .]+" />
					</div> -->
					<!-- <div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="mail" style="width:20em;" placeholder="Enter your Email" value="<?php echo @$email; ?>" required />
					</div>  -->
					<div class="form-group">
						<label>Generate QR Code</label>
						<input type="text" class="form-control" name="msg" style="width:20em;" value="<?php echo @$body; ?>" required pattern="[a-zA-Z0-9 .]+" placeholder="Enter employee ID"></textarea>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary submitBtn" style="width:20em; margin:0;" />
					</div>
					<div class="form-group">
						<a href="../admin/attendance.php">Go back</a>
					</div>
					
					
				</form>
			<!-- </div> -->
			<?php
			if(!isset($filename)){
				$filename = "author";
			}
			?>
			<!-- <div class="form-group">
				<h2 style="text-align:center">QR Code Result: </h2>
					<center>
						<div class="form-group" style="border:2px solid black; width:210px; height:210px;">
							<?php echo '<img src="temp/'. @$filename.'.png" style="width:200px; height:200px;"><br>'; ?>
						</div>
							<a class="btn btn-primary submitBtn" style="width:210px; margin:5px 0;" href="download.php?file=<?php echo $filename; ?>.png ">Download QR Code</a>
					</center>
			</div> -->
			
			<!-- <div class = "dllink" style="text-align:center;margin:-100px 0px 50px 0px;">
				<h4>www.itsourcecode.com</h4>
			</div> -->
			
		</div>
	</body>
	<footer></footer>
</html>