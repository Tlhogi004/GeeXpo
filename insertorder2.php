<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['deliveryitem'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("CALL insert_product2(?,?,?,?)");

	    $stmt->bind_param("ssss", $deliveryitem, $orderexpected, $billinglocation, $customer_email);

	    // set parameters and execute
	    $deliveryitem = $_GET["deliveryitem"];
		$orderexpected = $_GET["expecteddate"];
		$billinglocation = $_GET["billingaddress"];
		$customer_email = $_GET["email1"];

	    $stmt->execute();

	    echo "New records created successfully";

	    $stmt->close();
	}
	else{
	    echo "Something went wrong here: <br>".$sql."<br> Type something in the text input areas please.";
	}

	mysqli_close($conn);
	if(!isset($_SESSION['login_user'])){
	    header("location:loggedinuser.php");
	}
?>