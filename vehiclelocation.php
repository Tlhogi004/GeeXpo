<?php
include("db_config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $user_fname = "";

    $myusername = mysqli_real_escape_string($conn,$_POST['truckid']);

    $sql = "SELECT CUSTOMER.CUST_FNAME, CUSTOMER.CUST_LNAME FROM britehousedeliverymanagement.CUSTOMER WHERE CUSTOMER.CUST_EMAIL = '$myusername' AND CUSTOMER.CUST_PASSWORD = '$mypassword'";

    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//    $active = $row['active'];

    $count = mysqli_num_rows($result);

    $result1 = $conn->query($sql);

    if ($result1->num_rows > 0) {
        // output data of each row
        while($row = $result1->fetch_assoc()) {
            $myusername = $row["CUST_FNAME"] . ', ' . $row["CUST_LNAME"];
        }
    }
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
        session_start();
        $_SESSION['login_user'] = $myusername;
        header("location: loggedinadmin.php");
        exit;
    }else {
        session_start();
        echo "User does not exist";
        header("location: index.html");
    }
}
?>