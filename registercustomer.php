<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_GET['firstname'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }
	    // prepare and bind
	    $stmt = $conn->prepare("INSERT INTO customer(CUST_FNAME,CUST_LNAME,CUST_PHONE,CUST_EMAIL,CUST_PCODE,CUST_STREET,CUST_CITY,CUST_PROVINCE) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

	    $stmt->bind_param("ssssssss", $firstname, $lastname, $phonenumber, $email, $postalcode, $street, $province, $country);

	    // set parameters and execute
	    $firstname = $_GET["firstname"];
		$lastname = $_GET["surname"];
		$phonenumber = $_GET["phoneno"];
		$email = $_GET["Email"];
		$postalcode = $_GET["postalcode"];
		$street = $_GET["street"];
		$country = $_GET["city"];
		$province = $_GET["province"];

	    $stmt->execute();

	    echo "New records created successfully";

	    $stmt->close();
	}
	else{
	    echo "Something went wrong here: <br>".$sql."<br> Type something in the text input areas please.";
	}

	mysqli_close($conn);
	if(!isset($_SESSION['login_user'])){
	    header("location:signup.html");
	}
?>