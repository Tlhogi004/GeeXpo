<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_POST['transportreg'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("INSERT INTO VEHICLE(VEH_CODE,VEH_TYPE,VEH_LOAD_LMT,VEH_COST,VEH_DEPOTRANGE) VALUES (?, ?, ?, ?, ?)");

	    $stmt->bind_param("sssss", $transportreg, $transportype, $loadlimit, $transportcost, $depotrange);

	    // set parameters and execute
	    $transportreg = $_POST["transportreg"];
		$transportype = $_POST["transportype"];
		$loadlimit = $_POST["loadlimit"];
		$transportcost = $_POST["transportcost"];
		$depotrange = $_POST["depotrange"];

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