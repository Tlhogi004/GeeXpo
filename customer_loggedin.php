<?php
include("db_config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form
    $user_fname = "";
    $user_address = "";
    $user_phone = "";

    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "SELECT CUSTOMER.CUST_FNAME, CUSTOMER.CUST_LNAME, CUSTOMER.CUST_ADDRESS, CUSTOMER.CUST_PHONE 
            FROM britehousedeliverymanagement.CUSTOMER 
            WHERE CUSTOMER.CUST_EMAIL = '$myusername' 
            AND CUSTOMER.CUST_PASSWORD = '$mypassword'";

    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//    $active = $row['active'];

    $count = mysqli_num_rows($result);

    $result2 = $conn->query($sql1);

    if ($result2->num_rows > 0) {
        // output data of each row
        while($row = $result2->fetch_assoc()) {
            $user_fname = $row["CUST_FNAME"] . ', ' . $row["CUST_LNAME"];
            $user_address = $row["CUST_ADDRESS"];
            $user_phone = $row["CUST_PHONE"];
        }
    }
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
        session_start();
        $_SESSION['login_user'] = $user_fname . '|' . $user_address . '|' . $user_phone . '|' . $myusername;
        header("location: orderstatushistory.php");
        exit;
    }else {
        session_start();
        echo "User does not exist";
        header("location: customer_login.php");
    }
}
?>