<?php
include("db_config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    // username and password sent from form

    $myusername = "";
    $mypassword = "";

    if (isset($_GET['txtusername']))
    {
        $myusername = mysqli_real_escape_string($conn,$_GET['txtusername']);
        $mypassword = mysqli_real_escape_string($conn,$_GET['txtpassword']);
    }
    else{
        $error = "please enter your credentials to continue";
    }

    $sql = "SELECT CUSTOMER.CUST_FNAME FROM britehousedeliverymanagement.CUSTOMER WHERE CUSTOMER.CUST_EMAIL = '$myusername' AND CUSTOMER.CUST_PASSWORD = '$mypassword'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//    $active = $row['active'];

    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
//        session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        header("location: loggedinadmin.php");
    }else if(($count == 0) && (isset($_GET['submit']))) {
        $error = "Your Login Name or Password is invalid";
    }
}
?>