<?php
	require 'db_config.php';
	
	$conn -> close();
	$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name)
	or die ('Could not connect to the database server' . mysqli_connect_error());

	if (isset($_POST['customeremail'])) {

	    if (!$conn) {
	        die("Connection failed: " . mysqli_connect_error());
	    }

	    // prepare and bind
	    $stmt = $conn->prepare("CALL changepassword(?,?,?)");

	    $stmt->bind_param("sss", $customeremail, $oldpassword, $newpassword);

	    // set parameters and execute
	    $customeremail = $_POST["customeremail"];
		$oldpassword = $_POST["oldpassword"];
		$newpassword = $_POST["newpassword"];
		
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