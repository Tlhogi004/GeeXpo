<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['itemname'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("CALL insert_product(?,?,?,?,?,?,?,?,?)");

	    $stmt->bind_param("sssssssss", $itemname, $orderexpected, $orderdellocation, $firstname, $lastname, $phonenumber, $customer_email, $customer_address, $password);

	    // set parameters and execute
	    $itemname = $_GET["itemname"];
		$orderexpected = $_GET["expecteddate"];
		$orderdellocation = $_GET["orderdellocation"];
		$firstname = $_GET["firstname"];
		$lastname = $_GET["surname"];
		$phonenumber = $_GET["phoneno"];
		$customer_email = $_GET["email"];
		$customer_address = $_GET["address"];
		$password = $_GET["password"];

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