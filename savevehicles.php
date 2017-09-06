<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['transportreg'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("INSERT INTO transportation(TRANS_CODE,TRANS_TYPE,TRANS_LOAD_LMT,TRANS_TYPEPACK,TRANS_COST,TRANS_DEPOTRANGE) VALUES (?, ?, ?, ?, ?, ?)");

	    $stmt->bind_param("ssssss", $transportreg, $transportype, $loadlimit, $packagetype, $transportcost, $depotrange);

	    // set parameters and execute
	    $transportreg = $_GET["transportreg"];
		$transportype = $_GET["transportype"];
		$loadlimit = $_GET["loadlimit"];
		$packagetype = $_GET["packagetype"];
		$transportcost = $_GET["transportcost"];
		$depotrange = $_GET["depotrange"];

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