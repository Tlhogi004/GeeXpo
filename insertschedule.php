<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['schedulecode'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("CALL insert_schedule(?,?,?,?,?,?)");

	    $stmt->bind_param("ssssss", $schedulecode, $startdate, $enddate, $starttime, $endtime, $plannerid);

	    // set parameters and execute
	    $schedulecode = $_GET["schedulecode"];
		$startdate = $_GET["startdate"];
		$enddate = $_GET["enddate"];
		$starttime = $_GET["starttime"];
		$endtime = $_GET["endtime"];
		$plannerid = $_GET["plannerid"];

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