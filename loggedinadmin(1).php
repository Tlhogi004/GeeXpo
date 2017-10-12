<?php
    require_once __DIR__ . '/db_config.php';
    include("phpsessionattr.php");
    
    date_default_timezone_set('Africa/Harare');
    $date = date('m/d/Y h:i:s', time());

    $query1 = "SELECT * FROM britehousedeliverymanagement.VEHICLE";
    $query2 = "SELECT CUSTOMER.CUST_FNAME, CUSTOMER.CUST_LNAME, CUSTOMER.CUST_PHONE, CUSTOMER.CUST_EMAIL, CUSTOMER.CUST_ADDRESS FROM britehousedeliverymanagement.CUSTOMER ORDER BY CUSTOMER.CUST_FNAME";
    $query3 = "SELECT * FROM britehousedeliverymanagement.DRIVER";
    $query4 = "CALL select_delivery()";
    $query6 = "SELECT COUNT(*) FROM britehousedeliverymanagement.DRIVER";
    $query7 = "SELECT COUNT(*),VEHICLE.VEH_CODE FROM britehousedeliverymanagement.VEHICLE";
    $query8 = "SELECT COUNT(*) FROM britehousedeliverymanagement.PRODUCT WHERE PRODUCT.PROD_EXP_DATE >= '$date'";
    $query9 = "SELECT * FROM britehousedeliverymanagement.SCHEDULE";
    $query10 = "CALL auto_update_deliveries()";
    $query11 = "SELECT NOTICE.TITLE,NOTICE.DESCRIPTION,NOTICE.STARTDATE,NOTICE.ENDDATE FROM britehousedeliverymanagement.NOTICE";
    
    $result7 = mysqli_query($conn, $query6);
    $result8 = mysqli_query($conn, $query7);
    $result9 = mysqli_query($conn, $query8);
    $result10 = mysqli_query($conn, $query9);
    $result11 = mysqli_query($conn, $query10);
    $result12 = mysqli_query($conn, $query11);
    $result13 = mysqli_query($conn, $query2);
    $result1 = mysqli_query($conn, $query1);
    $result2 = mysqli_query($conn, $query2);
    $result3 = mysqli_query($conn, $query3);
    $result4 = mysqli_query($conn, $query1);
    $result5 = mysqli_query($conn, $query4);

    $numOfDriver = 0;
    $numOfVehicle = 0;
    $numOfDelivery = 0;

    $arrtitle[] = array();
    $arrdescription[] = array();
    $arrstartdate[] = array();
    $arrenddate[] = array();

    while($row1 = mysqli_fetch_array($result12)):;
        $arrtitle[] = array(0 => $row1[0]);
        $arrdescription[] = array(0 => $row1[1]);
        $arrstartdate[] = array(0 => $row1[2]);
        $arrenddate[] = array(0 => $row1[3]);
    endwhile;
          
    if($row1 = mysqli_fetch_array($result7)):;
        $numOfDriver = $row1[0];
    endif;

    if($row1 = mysqli_fetch_array($result8)):;
        $numOfVehicle = $row1[0];
    endif;

    if($row1 = mysqli_fetch_array($result9)):;
        $numOfDelivery = $row1[0];
    endif;

    session_start();

    $expireAfter = 30;
    $user = '';

    if(isset($_SESSION['login_user']) !== 'loggedout') {
        $myArray = explode('|', $_SESSION['login_user']);
        $user = $myArray[0];
        if(!$myArray[1]){header("Location:index.php");}
        $id = $myArray[1];
        
        // if(isLoginSessionExpired(1)) {
        //  header("Location:sessionlogout.php");
        // }
    } else {
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>DataTables Bootstrap 3 example</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="css/jquery.popup.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/calendarbootstrapstylemin.css">
        <link rel="stylesheet" type="text/css" href="css/calendarbootstrapstyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
        <link rel="stylesheet" href="css/displaystyle.css">
        <link rel="stylesheet" href="css/calendar_style.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/> -->
        <header>
        <div id="top-div" style="color: black; height: 40px; width: 100px; font-size: 13.3333px; margin-left: 75.1%;">
            <input type="submit" value="Admin Panel" id="inserttransport" style="background: linear-gradient(#64B5F6, #1A237E); border-width: 0px; color: white;">
            <select id="mylist" onchange="favlang()">
                <option>English</option>
            </select>

            <input type="text" placeholder="SEARCH" style="border-radius: 10px;">
        </div>

        <div id="green-bar"></div>

        <div id="log-bar">
            <table>
                
            </table>
        </div>

        <div id="image-src">
            <img src="Images/britehouse_icon.png" alt="britehouse_icon">
        </div>
    </header>
    </head>

    <script type="text/javascript">
        var timing = 5;
        var arrtitle = <?php echo json_encode($arrtitle); ?>;
        var arrdescription = <?php echo json_encode($arrdescription); ?>;
        var arrstartdate = <?php echo json_encode($arrstartdate); ?>;
        var arrenddate = <?php echo json_encode($arrenddate); ?>;
     </script>
    <body>
        <div id="side-left-panel">
        <table>
            <tbody>
                <tr>
                    <td style="width: 10%; vertical-align: top; margin-top: 10.8px; background: #005566; color: #056D80;">
                        <table style="margin-left: 0px;">
                            <tbody>
                                <tr>
                                    <div id="side-bar-left" style="margin-top: 10.8px; margin-left: 1px; margin-right: 1px; text-decoration: none; width: 10%;">
                                        <ul>
                                            <img src="Images/admin_default" alt="britehouse_icon" style="width: 80px; height: 80px; border: 2px solid lightblue; border-radius: 40px; margin-left: 50px;">
                                            <label style="font-size: 14px; color: lightgrey; display: inline; margin-left: 60px;">Welcome, <p style="color: white; font-size: 16px; text-transform:capitalize; text-align: center; margin-left: 60px;"><?php echo $user;?></p></label>
                                            <li onclick="dashboard_display();"><a href="#" onclick="dashboard_display();">DASHBOARD</a></li>
                                            <li onclick="customermanagement_display();"><a href="#" onclick="customermanagement_display();">CUSTOMER MANGEMENT</a></li>
                                            <li onclick="deliverymanagement_display();"><a href="#" onclick="deliverymanagement_display();">DELIVERY MANGEMENT</a></li>
                                            <li onclick="schedulemanagement_display();"><a href="#" onclick="schedulemanagement_display();">SCHEDULE MANGEMENT</a></li>
                                            <li onclick="drivermanagement_display();"><a href="#" onclick="drivermanagement_display();">DRIVER MANGEMENT</a></li>
                                            <li onclick="truckmanagement_display();"><a href="#" onclick="truckmanagement_display();">TRUCK MANGEMENT</a></li>
                                            <li onclick="reportmanagement_display();"><a href="#" onclick="reportmanagement_display();">REPORTING</a></li>
                                            <li onclick="profilemanagement_display();"><a href="#" onclick="profilemanagement_display();">PROFILE</a></li>
                                            <li onclick="profilemanagement_display();"><a href="#" onclick="profilemanagement_display();">HELP</a></li>
                                            <li style="border-bottom: 1px solid rgba(69, 74, 84, 0.7);" onclick="location.href='sessionlogout.php';"><a href="sessionlogout.php">LOGOUT</a></li>
                                        </ul>
                                    </div>
                                </tr>
                            </tbody>
                        </table>        
                    </td>
                    <td id="scheduledata_td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
                        <h1>Britehouse Delivery Management System</h1>
                        <img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">SCHEDULE INFORMATION</h2>
                        <input class="js__p_start"; type="button" id="addcustomer" onclick="document.getElementById('vehicle_button').value = 'PROCEED'" name="addcustomer" value="ADD SCHEDULE" style="background-color: #00a651; color: white; border: none; border-radius: 2px; margin-bottom: 10px;text-align: right; margin-left: 91%; margin-right: 0; cursor: pointer; height: 30px;">
                        <section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
                            <div id="tbl-header">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>SCHEDULE CODE</th>
                                            <th>START DATE</th>
                                            <th>START TIME</th>
                                            <th>END DATE</th>
                                            <th>END TIME</th>
                                            <th>PLANNED BY</th> 
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="tbl-content" style="height: 405px;">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <?php while($row1 = mysqli_fetch_array($result10)):;?>
                                            <tr>
                                                <td><?php echo $row1[0];?></td>
                                                <td><?php echo $row1[1];?></td>
                                                <td><?php echo $row1[2];?></td>
                                                <td><?php echo $row1[3];?></td>
                                                <td><?php echo $row1[4];?></td>
                                                <td style="width: 175px;"><?php echo $row1[5];?></td>
                                            </tr>
                                        <?php endwhile;?>
                                    </tbody>
                                </table>
                          </div>
                        </section>
                    </td>
                    <td id="driverdata_td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
                        <h1>Britehouse Delivery Management System</h1>
                        <img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">DRIVER INFORMATION</h2>
                        <section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
                            <div id="tbl-header">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th>EMPLOYEE CODE</th>
                                            <th>FIRST NAME</th>
                                            <th>LAST NAME</th>
                                            <th>CONTACT</th>
                                            <th>DRIVER'S LICENSE</th>
                                            <th>ASSIGNED TRUCK</th> 
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div id="tbl-content" style="height: 405px;">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <?php while($row1 = mysqli_fetch_array($result3)):;?>
                                            <tr>
                                                <td><?php echo $row1[0];?></td>
                                                <td><?php echo $row1[1];?></td>
                                                <td><?php echo $row1[2];?></td>
                                                <td><?php echo $row1[3];?></td>
                                                <td><?php echo $row1[4];?></td>
                                                <td style="width: 165px;"><?php echo $row1[5];?></td>
                                            </tr>
                                        <?php endwhile;?>
                                    </tbody>
                                </table>
                          </div>
                        </section>
                    </td>
                    <td>
                        <div class="container" style=" margin: 10 auto;">

                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>FIRST NAME</th>
                                    <th>LAST NAME</th>
                                    <th>CONTACTS</th>
                                    <th>EMAIL</th>
                                    <th>ADDRESS</th>
                                    <th></th>
                                </tr>
                            </thead>
                             <tbody>
                            <?php while($row1 = mysqli_fetch_array($result13)):;?>
                                <tr>
                                    <td><?php echo $row1[0];?></td>
                                    <td><?php echo $row1[1];?></td>
                                    <td><?php echo $row1[2];?></td>
                                    <td><?php echo $row1[3];?></td>
                                    <td><?php echo $row1[4];?></td>
                                    <td><input type="submit" value="DELETE" 
                                        onclick="
                                        document.getElementById('customeremaildelete').value = '<?php echo $row1[3];?>';
                                        " 
                                        style="width: 100px;">
                                    </td>
                                </tr>
                            <?php endwhile;?>
                            </tbody>
                        </table>
                            
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>


        <script type="text/javascript">
            // For demo to fit into DataTables site builder...
            $('#example')
                .removeClass( 'display' )
                .addClass('table table-striped table-bordered');
        </script>
        <script src='js/calendarquerymin.js'></script>
<script src='js/bootstrapjquerytheme.js'></script>

    <script  src="js/calendar_index.js"></script>
    <script  src="js/displayjquery.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>
    </body>
</html>