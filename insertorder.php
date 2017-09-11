<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['ordertype'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("CALL insert_product(?,?,?)");

	    $stmt->bind_param("sss", $ordertype, $orderexpected, $customer_email);

	    // set parameters and execute
	    $ordertype = $_GET["ordertype"];
	    $customer_email = $_GET["email"];
		$orderexpected = $_GET["datetimepicker1"];

	    $stmt->execute();

	    echo "New records created successfully";

	    $stmt->close();
	}
	else{
	    echo "Something went wrong here: <br>".$sql."<br> Type something in the text input areas please.";
	}

	mysqli_close($conn);
	if(!isset($_SESSION['login_user'])){
	    header("location:orderentry.html");
	}
?>