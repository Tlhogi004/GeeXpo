<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['drivercode'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("CALL insert_driver(?,?,?,?,?,?,?,?)");

	    $stmt->bind_param("ssssssss", $drivercode, $driverfirstname, $driverlastname, $driverphonenumber, $driverlicense, $assignedtruck,$assignedshiftday,$assignedshiftslots);

	    // set parameters and execute
	    $drivercode = $_GET["drivercode"];
		$driverfirstname = $_GET["driverfirstname"];
		$driverlastname = $_GET["driverlastname"];
		$driverphonenumber = $_GET["driverphonenumber"];
		$driverlicense = $_GET["driverlicense"];
		$assignedshiftday = $_GET["assignedshiftday"];
		$assignedshiftslots = $_GET["assignedshiftslot"];
		$assignedtruck = $_GET["assignedtruck"];

	    $stmt->execute();

	    echo "New records created successfully";

	    $stmt->close();
	}
	else{
	    echo "Something went wrong here: <br>".$sql."<br> Type something in the text input areas please.";
	}

	mysqli_close($conn);
	if(!isset($_SESSION['login_user'])){
	    header("location:loggedinadmin.php");
	}
?>