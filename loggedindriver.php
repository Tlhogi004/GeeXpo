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
		// 	header("Location:sessionlogout.php");
		// }
	} else {
		header("Location:index.php");
	}
?>

<!DOCTYPE html>
<html >
<head>
  	<meta charset="UTF-8">
 	<title>Admin | BriteHouse</title>
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
  	<header>
		<div id="top-div" style="color: black; height: 40px; width: 100px; font-size: 13.3333px; margin-left: 75.1%;">
			<input type="submit" value="Driver Panel" id="inserttransport" style="background: linear-gradient(#64B5F6, #1A237E); border-width: 0px; color: white;">
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
<body onbeforeunload=”HandleBackFunctionality()”>
	<div class="p_body js__p_body js__fadeout"></div>
	
	<div id="delivery-edit-div" class="popup js__popup js__slide_top" style="margin-bottom: 0px; background-color: lightblue; display: none;">
		<form action="updatevehicles.php" method="post">
			<h2 style="margin-bottom: 25px; margin-top: 13px; position: absolute; font-size: 16px;">BRITEHOUSE DELIVERY MANAGEMENT SYSTEM</h2>
			<a href="#" class="p_close js__p_close" title="Close"></a>
		    <div class="p_content" style="background-color: lightblue; height: 500px;">
		    	<h2 style="margin-bottom: 25px; margin-top: 0px; text-align: left; border-bottom: 1px solid white;">EDIT VEHICLE</h2>
				<table style="margin: 0 auto; width: 90%;">
		    		<tbody>
		    			<tr>
		    				<td style="width: 50%;">
		    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-right: none; border-top-right-radius: 0; border-bottom-right-radius: 0;">
									<div><p><label for="transportreg" class="floatLabel">VEHICLE REG.</label></p></div>
									<div><p><label for="transportype" class="floatLabel">VEHICLE TYPE</label></p></div>
									<div><p><label for="loadlimit" class="floatLabel">LOAD CAPABILITY</label></p></div>
									<div><p><label for="transportcost" class="floatLabel">COST</label></p></div>
									<div><p><label for="depot_range" class="floatLabel">DEPOT RANGE</label></p></div>
									<div><p><label for="depot_range" class="floatLabel">SCHEDULE CODE</label></p></div>
								</div>
		    				</td>
		    				<td style="width: 50%; margin-left: 0;">
		    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;">
									<div><p><input type="text" id="transportreg" name="transportreg" style="height: 25px;"></p></div>
									<div><p><input type="text" id="transportype" name="transportype" style="height: 25px;"></p></div>
									<div><p><input type="text" id="loadlimit" name="loadlimit" style="height: 25px;"></p></div>
									<div><p><input type="text" id="transportcost" name="transportcost" style="height: 25px;"></p></div>
									<div><p><input type="text" id="depotrange" name="depotrange" style="height: 25px;"></p></div>
									<div><p>
										<?php
											//Connect to our MySQL database using the PDO extension.
											$pdo = new PDO('mysql:host=localhost;dbname=britehousedeliverymanagement', 'root', 'tl004');
											 
											//Our select statement. This will retrieve the data that we want.
											$sql = "SELECT SCH_CODE FROM SCHEDULE";
											 
											//Prepare the select statement.
											$stmt = $pdo->prepare($sql);
											 
											//Execute the statement.
											$stmt->execute();
											 
											//Retrieve the rows using fetchAll.
											$schedulecode1 = $stmt->fetchAll();
											 
											?>
											 
											<select id="schedule_drop" name="schedule_drop" onchange="favlang()" style="height: 25px; width: 185px;">
											    <?php foreach($schedulecode1 as $sch_code): ?>
											        <option value="<?= $sch_code['SCH_CODE']; ?>"><?= $sch_code['SCH_CODE']; ?></option>
											    <?php endforeach; ?>
											</select>
										</p>
									</div>
									<p><input id="vehicle_button" type="submit" name="" value="ADD" style="width: 100px; border-radius: 2px; background-color: #00a651; border: none; -webkit-appearance: button; cursor: pointer; color: white; margin-bottom: 10px; text-align: center; height: 30px;"></p>
								</div>
		    				</td>
		    			</tr>
		    		</tbody>
		    	</table>
		    </div>
	    </form>
	</div>
	<div id="schedule-edit-div" class="popup js__popup js__slide_top" style="margin-bottom: 0px; background-color: lightblue; display: none;">
		<form action="insertschedule.php" method="get">
			<h2 style="margin-bottom: 25px; margin-top: 13px; position: absolute; font-size: 16px;">BRITEHOUSE DELIVERY MANAGEMENT SYSTEM</h2>
			<a href="#" class="p_close js__p_close" title="Close"></a>
		    <div class="p_content" style="background-color: lightblue; height: 600px;">
		    	<h2 style="margin-bottom: 25px; margin-top: 0px; text-align: left; border-bottom: 1px solid white;">ADD SCHEDULE</h2>
				<table style="margin: 0 auto; width: 90%;">
		    		<tbody>
		    			<tr>
		    				<td style="width: 50%;">
		    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-right: none; border-top-right-radius: 0; border-bottom-right-radius: 0;">
									<div><p><label for="schedulecode" class="floatLabel">SCHEDULE CODE</label></p></div>
									<div><p><label for="startdate" class="floatLabel">START DATE</label></p></div>
									<div><p><label for="enddate" class="floatLabel">END DATE</label></p></div>
									<div><p><label for="starttime" class="floatLabel">START TIME</label></p></div>
									<div><p><label for="endtime" class="floatLabel">END TIME</label></p></div>
									<div><p><label for="plannerid" class="floatLabel">PLANNER ID</label></p></div>
								</div>
		    				</td>
		    				<td style="width: 50%; margin-left: 0;">
		    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;">
									<div><p><input type="text" id="schedulecode" name="schedulecode" style="height: 25px;"></p></div>
									<div><p><input type="text" id="startdate" name="startdate" style="height: 25px;"></p></div>
									<div><p><input type="text" id="enddate" name="enddate" style="height: 25px;"></p></div>
									<div><p><input type="text" id="starttime" name="starttime" style="height: 25px;"></p></div>
									<div><p><input type="text" id="endtime" name="endtime" style="height: 25px;"></p></div>
									<div><p><input type="text" id="plannerid" name="plannerid" style="height: 25px;"></p></div>
									<p><input id="vehicle_button" type="submit" name="" value="ADD SCHEDULE" style="width: 115px; border-radius: 2px;background-color: #00a651; border: none; -webkit-appearance: button; cursor: pointer; color: white; margin-bottom: 10px; text-align: center; height: 30px;"></p>
								</div>
		    				</td>
		    			</tr>
		    		</tbody>
		    	</table>
		    </div>
	    </form>
	</div>
	<div id="lightblue-bar"></div>
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
					<td id="reporting" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
            			<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">CUSTOMER INFORMATION</h2>
						<span class="btn-group" style="float: right;">
              				<button class="js-cal-prev1 btn btn-default">Excel</button>
              				<button id="export_pdf" class="js-cal-prev2 btn btn-default">PDF</button>
              				<button class="js-cal-prev3 btn btn-default">Print</button>
              				<label style="font-family: Arial;font-size: 13.3333px;font-weight: 0;">SEARCH: </label>
              				<input type="text" name="" style="font-family: Arial;height: 35px; border-radius: 2px; border: 1px solid lightgrey; margin-right: 5px;">
            			</span>
						<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4); margin-top: 10px;">
							<div id="tbl-content">
								<table id="tbl-customer" cellpadding="0" cellspacing="0" border="0">
									<thead style="background-color: rgba(255,255,255,0.3);">
										<tr>
											<th style="padding: 5px;
													  text-align: left;
													  font-weight: 500;
													  font-size: 12px;
													  color: #fff;
													  text-transform: uppercase;">FIRST_NAME</th>
											<th style="padding: 5px;
													  text-align: left;
													  font-weight: 500;
													  font-size: 12px;
													  color: #fff;
													  text-transform: uppercase;">LAST_NAME</th>
											<th style="padding: 5px;
													  text-align: left;
													  font-weight: 500;
													  font-size: 12px;
													  color: #fff;
													  text-transform: uppercase;">CONTACTS</th>
											<th style="padding: 5px;
													  text-align: left;
													  font-weight: 500;
													  font-size: 12px;
													  color: #fff;
													  text-transform: uppercase;">EMAIL</th>
											<th style="padding: 5px;
													  text-align: left;
													  font-weight: 500;
													  font-size: 12px;
													  color: #fff;
													  text-transform: uppercase;">ADDRESS</th>
											<th></th>	
										</tr>
									</thead>
									
						      		<tbody>
						      		<input type="hidden" id="customeremaildelete" name="customeremaildelete" value="">
						        	<?php while($row1 = mysqli_fetch_array($result13)):;?>
										<tr>
											<td><?php echo $row1[0];?></td>
											<td><?php echo $row1[1];?></td>
											<td><?php echo $row1[2];?></td>
											<td><?php echo $row1[3];?></td>
											<td><?php echo $row1[4];?></td>
											<td><input type="submit" value="DELETE" onclick="
												document.getElementById('customeremaildelete').value = '<?php echo $row1[3];?>';
												" 
												style="width: 100px;">
											</td>
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
					<td id="deliverymanagement-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">DELIVERY INFORMATION</h2>
						<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4); width: 100%;">
							<table>
								<tbody>
									<tr>
										<td>
											<div class="wrapper">

										  <div class="table" >
										    <td style="width: 60%; text-align: left;">
										    	<div class="row2 header blue">
										      		<div class="cell">
										        		CUSTOMER: TLHOGI MOLWANA
										      		</div>
										    	</div>
										    
										    
										    	<div class="row2">
										       	<div class="promos">  
										            <div class="promo first" style="margin-top: 85px;">
										                <h4>CUSTOMER INFORMATION</h4>
										                <ul class="features">
										                	<label id="customerstatus">STATUS: ACTIVE</label>
										                    <label id="customernumber">ID#</label>
										                    <label id="customernames" style="text-transform: uppercase;">NAMES</label></br>
										                    <label id="customeraddress">ADDRESS</label></br>
										                    <label id="customerphone">PHONE</label></br>
										                    <label>EMAIL: <a id="customeremail"></a></label>
										                </ul>
										            </div>
										            <div class="promo second" style="margin-top: 85px;">
										                <h4>VEHICLE INFORMATION</h4>
										                <ul class="features">
										                	<label id="vehiclestatus">STATUS: ACTIVE</label></br>
										                    <label id="vehiclereg">
										                    	<?php
																//Connect to our MySQL database using the PDO extension.
																$pdo = new PDO('mysql:host=localhost;dbname=britehousedeliverymanagement', 'root', 'tl004');
																 
																//Our select statement. This will retrieve the data that we want.
																$sql = "SELECT VEH_CODE FROM VEHICLE ORDER BY VEH_CODE";
																 
																//Prepare the select statement.
																$stmt = $pdo->prepare($sql);
																 
																//Execute the statement.
																$stmt->execute();
																 
																//Retrieve the rows using fetchAll.
																$vehiclecodes = $stmt->fetchAll();
																 
																?>
																 
																<select id="vehiclereg2" name="vehiclereg2" disabled 
																		style="height: 25px; margin-left: 15px; background: #292b2e; border:none; text-align: center; width: 150px;">
																    <option>SELECT</option>
																    <?php foreach($vehiclecodes as $veh_code): ?>
																        <option value="<?= $veh_code['VEH_CODE']; ?>"><?= $veh_code['VEH_CODE']; ?></option>
																    <?php endforeach; ?>
																</select>
										                    </label></br>
										                    <label id="vehicletype">TYPE</label></br>
										                    <label>LOAD LIMIT: <a id="vehicleload"></a></label></br>
										                    <label>DEPOT RANGE: <a id="vehiclerange"></a></label></br>
										                    <label>SCHEDULE: <a id="vehicleschedule" class="rad"></a></label>
										                    <div class="box" id="box">This is a popup box</div>

														  	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
															<script  src="js/displayjquery.js"></script>
										                </ul>
										            </div>
										            <div class="promo third scale" style="margin-top: 50px;">
										                <h4>ORDER INFORMATION</h4>
										                <ul class="features">
										                    <label id="orderstatus1">ORDER STATUS:
																<select id="ordsts" name="ordsts" disabled 
																		style="height: 25px; background: #0F1012; border:none; text-align: center; width: 100px;">
																    <option>ASSEMBLING</option>
																	<option>CANCELLED</option>
																	<option>RETURNED</option>
																	<option>PROCESSED</option>
																	<option>SHIPPING</option>
																	<option>SHIPPED</option>
																</select>
										                    </label>
										                    <input type='text' id="ordernumber" name="ordernumber" value="ORD#"
										                    		style="background: #292b2e; border:none; text-align: center;"></br>
										                    <label id="deliveryitem">ITEM:</label></br>
										                    <label id="daterequested">DATE REQUESTED:</label></br>
										                    <label id="dateexpected">DATE EXPECTED:</label></br>
										                	<label id="shippedto">SHIPPING ADDRESS</label></br>
										                	<label style="vertical-align: top;margin-right: 5px;">COMMENTS</label></br><textarea id="comments" name="comments" disabled cols="20" rows="4" style="text-align: justify; font-weight: 500; font-size: 13.3333px; font-family: Arial; background: #0F1012; border: 0.01px solid grey;color: white;"></textarea></br>
										                    <li class="buy">
										                    	<input type="submit" name="editorder" id="editorder" value="Edit"
										                    	style="
										                    		padding: 1em 3.25em;
																	border: none;
																	border-radius: 40px;
																	background: #292b2e;
																	color: #f9f9f9;
																	cursor: pointer;
																	width: 150px;
																	font-size: 13.3333px;
										                    	"></li> 
										                </ul>
										            </div>  
										        </div>
										      </div>
										    </td>	
										    <td style="width: 40%; vertical-align: top;">
												<div id="tbl-header">
													<table cellpadding="0" cellspacing="0" border="0">
														<thead>
															<tr>
																<th>#</th>
																<th>STATUS</th>
																<th></th>		
															</tr>
														</thead>
													</table>
												</div>
												<div id="tbl-content" style="height: 510.9px;">
											    <table cellpadding="0" cellspacing="0" border="0">
											      <tbody>
											        <?php while($row1 = mysqli_fetch_array($result5)):;?>
											        	<script type="text/javascript">
											        		document.getElementById('ordernumber').value = '<?php echo $row1[0];?>';
																document.getElementById('ordsts').value = '<?php echo $row1[4];?>';
																document.getElementById('vehiclereg2').value = '<?php echo $row1[5];?>';
																document.getElementById('deliveryitem').innerHTML ='ITEM : ' + '<?php echo $row1[7];?>';
																document.getElementById('daterequested').innerHTML ='DATE REQUESTED: ' + '<?php echo $row1[1];?>';
																document.getElementById('dateexpected').innerHTML ='DATE EXPECTED: ' + '<?php echo $row1[2];?>';
																document.getElementById('shippedto').innerHTML ='SHIPPING ADDRESS: ' + '<?php echo $row1[3];?>';
																document.getElementById('vehicletype').innerHTML ='TYPE: ' + '<?php echo $row1[8];?>';
																document.getElementById('vehicleload').innerHTML ='<?php echo $row1[9];?>';
																document.getElementById('vehiclerange').innerHTML ='<?php echo $row1[10];?>';
																document.getElementById('vehicleschedule').innerHTML ='<?php echo $row1[11];?>';
																document.getElementById('customernumber').innerHTML ='<?php echo $row1[12];?>';
																document.getElementById('customernames').innerHTML ='NAMES: ' + '<?php echo $row1[13];?>';
																document.getElementById('customeraddress').innerHTML ='ADDRESS: ' + '<?php echo $row1[14];?>';
																document.getElementById('customerphone').innerHTML ='PHONE: ' + '<?php echo $row1[15];?>';
																document.getElementById('customeremail').innerHTML ='<?php echo $row1[16];?>';
																document.getElementById('comments').value = '<?php echo $row1[6];?>';
																document.getElementById('box').innerHTML = '<?php echo $row1[6];?>';
											        	</script>
														<tr>
															<td><?php echo $row1[0];?></td>
															<td><?php echo $row1[4];?></td>
															<td style="width: 140px;"><input type="submit" value="VIEW" 
															onclick="
																document.getElementById('ordernumber').value = '<?php echo $row1[0];?>';
																document.getElementById('ordsts').value = '<?php echo $row1[4];?>';
																document.getElementById('vehiclereg2').value = '<?php echo $row1[5];?>';
																document.getElementById('deliveryitem').innerHTML ='ITEM : ' + '<?php echo $row1[7];?>';
																document.getElementById('daterequested').innerHTML ='DATE REQUESTED: ' + '<?php echo $row1[1];?>';
																document.getElementById('dateexpected').innerHTML ='DATE EXPECTED: ' + '<?php echo $row1[2];?>';
																document.getElementById('shippedto').innerHTML ='SHIPPING ADDRESS: ' + '<?php echo $row1[3];?>';
																document.getElementById('vehicletype').innerHTML ='TYPE: ' + '<?php echo $row1[8];?>';
																document.getElementById('vehicleload').innerHTML ='<?php echo $row1[9];?>';
																document.getElementById('vehiclerange').innerHTML ='<?php echo $row1[10];?>';
																document.getElementById('vehicleschedule').innerHTML ='<?php echo $row1[11];?>';
																document.getElementById('customernumber').innerHTML ='<?php echo $row1[12];?>';
																document.getElementById('customernames').innerHTML ='NAMES: ' + '<?php echo $row1[13];?>';
																document.getElementById('customeraddress').innerHTML ='ADDRESS: ' + '<?php echo $row1[14];?>';
																document.getElementById('customerphone').innerHTML ='PHONE: ' + '<?php echo $row1[15];?>';
																document.getElementById('customeremail').innerHTML ='<?php echo $row1[16];?>';
																document.getElementById('comments').value = '<?php echo $row1[6];?>';
																document.getElementById('box').innerHTML = '<?php echo $row1[6];?>';
																" 
																style="width: 80px;"></td>
														</tr>
													<?php endwhile;?>
											      </tbody>
											    </table>
											  </div>
											</td>
										    </div>
										  </div>
										</td>
									</tr>
								</tbody>
							</table>
						</section>
					</td>
					<td id="profile-td" style="display: none; width: 100%; vertical-align: top; background: white; margin-top: 0; height: auto;">
	  					<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">PROFILE INFORMATION</h2>
						<form action="savevehicles.php" method="get" id="signup-form" style="margin-left: 0px; margin-right: 0px; margin-top: 10px; width: 100%; max-width: 1090px;">
							<table>
								<tbody>
									<tr>
										<div id="profile-edit-div">
											<h2 style="margin-bottom: 25px;">EDIT PROFILE</h2>
											<div><p><label for="profilename" class="floatLabel">NAME</label><input type="text" id="profilename" name="profilename"></p></div>
											<div><p><label for="profileemail" class="floatLabel">EMAIL</label><input type="text" id="profileemail" name="profileemail"></p></div>
											<div><p><label for="profileaddress" class="floatLabel">ADDRESS</label><textarea id="profileaddress" name="profileaddress" cols="20" rows="2"></textarea></p></div>
											<div><p><label for="profilephone" class="floatLabel">PHONE</label><input type="text" id="profilephone" name="profilephone"></p></div>
											<p><input type="button" name="" value="UPDATE" style="width: 100px; margin-left: 45%; border-radius: 2px; background-color: #00a651; border: none; -webkit-appearance: button; cursor: pointer; color: white;"></p>
										</div>
									</tr>
									<tr>
										<p>
											<div id="profile-changepassword-div">
												<h2>CHANGE PASSWORD</h2>
												<div><p><label for="profileoldpassword" class="floatLabel">OLD PASSWORD</label><input type="password" id="profileoldpassword" name="profileoldpassword"></p></div>
												<div><p><label for="profilenewpassword" class="floatLabel">NEW PASSWORD</label><input type="password" id="profilenewpassword" name="profilenewpassword"></p></div>
												<div><p><label for="profileconfirmpassword" class="floatLabel">CONFIRM PASSWORD</label><input type="password" id="profileconfirmpassword" name="profileconfirmpassword"></p></div>
												<p><input type="button" name="" value="UPDATE" style="width: 100px; margin-left: 45%; border-radius: 2px; background-color: #00a651; border: none; -webkit-appearance: button; cursor: pointer; color: white;"></p>
											</div>
										</p>
									</tr>

								</tbody>
							</table>
						</form>
	  				</td>
					<td id="truckmanagement-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">VEHICLE INFORMATION</h2>
						<input class="js__p_start"; type="button" id="addcustomer" onclick="document.getElementById('vehicle_button').value = 'ADD'" name="addcustomer" value="ADD VEHICLE" style="margin-left: 81%;">
						<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
						  <!--for demo wrap-->
						  <div id="tbl-header">
								<table cellpadding="0" cellspacing="0" border="0">
									<thead>
										<tr>
											<th>TRUCK REG</th>
											<th>TRUCK TYPE</th>
											<th>LOAD CAPABILITY</th>
											<th>COST</th>
											<th>DEPOT RANGE</th>
											<th>SCHEDULE</th>
											<th>VIEW ON MAP</th>
											<th></th>
											<th></th>		
										</tr>
									</thead>
								</table>
							</div>
						  <div id="tbl-content">
						    <form action="map.php" method="post">
						    	<table cellpadding="0" cellspacing="0" border="0">
							      <tbody>
							      	<input type="hidden" id="truckid" name="truckid">
							        <?php while($row1 = mysqli_fetch_array($result4)):;?>
										<tr>
											<td><?php echo $row1[0];?></td>
											<td><?php echo $row1[1];?></td>
											<td><?php echo $row1[2];?></td>
											<td><?php echo $row1[3];?></td>
											<td><?php echo $row1[4];?></td>
											<td><?php echo $row1[5];?></td>
											<td style="text-align: left; width: 100px;">
												<input type="submit" value="TRACK" 
												onclick="document.getElementById('truckid').value = '<?php echo $row1[0];?>';" 
												style="width: 100px;">
											</td>
											<td style="text-align: right;">
											<input type="button" 
												onclick="
													document.getElementById('vehicle_button').value = 'UPDATE';
													document.getElementById('transportreg').value = '<?php echo $row1[0];?>';
													document.getElementById('transportype').value = '<?php echo $row1[1];?>';
													document.getElementById('loadlimit').value = '<?php echo $row1[2];?>';
													document.getElementById('transportcost').value = '<?php echo $row1[3];?>';
													document.getElementById('depotrange').value = '<?php echo $row1[4];?>';
													document.getElementById('schedule_drop').value = '<?php echo $row1[5];?>';
													" 
												class="js__p_start"; 
												value="EDIT" style="width: 100px;"
											>
											</td>
											<td style="text-align: right;"><input type="button" value="DELETE" style="width: 100px;"></td>
										</tr>
									<?php endwhile;?>
							      </tbody>
							    </table>
						    </form>
						  </div>
						</section>
					</td>
					<td id="customerdata-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">CUSTOMER INFORMATION</h2>
						<form action="deletecustomer.php" method="get">
							<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
							  	<div id="tbl-header">
									<table cellpadding="0" cellspacing="0" border="0">
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
									</table>
								</div>
							  	<div id="tbl-content">
							    	<table cellpadding="0" cellspacing="0" border="0">
							      		<tbody>
							      		<input type="hidden" id="customeremaildelete" name="customeremaildelete" value="">
							        	<?php while($row1 = mysqli_fetch_array($result2)):;?>
											<tr>
												<td><?php echo $row1[0];?></td>
												<td><?php echo $row1[1];?></td>
												<td><?php echo $row1[2];?></td>
												<td><?php echo $row1[3];?></td>
												<td><?php echo $row1[4];?></td>
												<td><input type="submit" value="DELETE" onclick="
													document.getElementById('customeremaildelete').value = '<?php echo $row1[3];?>';
													" 
													style="width: 100px;">
												</td>
											</tr>
										<?php endwhile;?>
							      		</tbody>
							    	</table>
							  	</div>
							</section>
						</form>
	  				</td>
					<td id="dashboard-panel" style="width: 100%; margin-top: 0px; vertical-align: top; background-color: whitesmoke; height: 556px;">
						<table style="margin-left: 10px;">
							<tbody>
								<tr>
									<div id="dashboard" style="width: 100%; height: 50px; border-bottom: 1.5px solid grey; line-height: 50px; margin-bottom: 10px; ">
										<a style="color: grey; font-size: 20px; text-decoration: none; margin-right: 55%; margin-left: 10px;">ADMIN DASHBOARD</a>
										
										<label style="position: absolute; font-size: 14px; color: lightgrey; display: inline; line-height: 40px;">DRIVER
												<p style="color: lightblue; font-size: 16px; text-transform:capitalize; text-align: center; line-height: 0px;">
													<?php echo $numOfDriver; ?>
												</p>
										</label>

										<a style="padding-left: 80px; padding-top: 15px; padding-bottom: 10px; text-decoration: none; border-right: 1px dotted grey;"></a>

										<label style="position: absolute; font-size: 14px; color: lightgrey; display: inline; line-height: 40px; margin-left: 30px">VEHICLE
											<p style="color: lime; font-size: 16px; text-transform:capitalize; text-align: center; line-height: 0px;">
												<?php echo $numOfVehicle; ?>
											</p>
										</label>

										<a style="padding-left: 120px; padding-top: 15px; padding-bottom: 10px; text-decoration: none; border-right: 1px dotted grey;"></a>

										<label style="position: absolute; font-size: 14px; color: lightgrey; display: inline; line-height: 40px; margin-left: 30px;">DELIVERY
											<p style="color: red; font-size: 16px; text-transform:capitalize; text-align: center; line-height: 0px;">
												<?php echo $numOfDelivery; ?>
											</p>
										</label>
									</div>
								</tr>
								<tr>
									<table>
										<tbody>
											<td>
												 <div class="container theme-showcase">
													<div id="holder" class="row" ></div>
												</div>

												<script type="text/tmpl" id="tmpl">
												  {{ 
												  var date = date || new Date(),
												      month = date.getMonth(), 
												      year = date.getFullYear(), 
												      first = new Date(year, month, 1), 
												      last = new Date(year, month + 1, 0),
												      startingDay = first.getDay(), 
												      thedate = new Date(year, month, 1 - startingDay),
												      dayclass = lastmonthcss,
												      today = new Date(),
												      i, j; 
												  if (mode === 'week') {
												    thedate = new Date(date);
												    thedate.setDate(date.getDate() - date.getDay());
												    first = new Date(thedate);
												    last = new Date(thedate);
												    last.setDate(last.getDate()+6);
												  } else if (mode === 'day') {
												    thedate = new Date(date);
												    first = new Date(thedate);
												    last = new Date(thedate);
												    last.setDate(thedate.getDate() + 1);
												  }
												  
												  }}
												<table class="calendar-table table table-condensed table-tight">
												    <thead>
												      	<tr>
												        	<td colspan="7" style="text-align: center">
												          		<table style="white-space: nowrap; width: 100%">
												            		<tr>
												              			<td style="text-align: left;">
												                			<span class="btn-group">
												                  				<button class="js-cal-prev btn btn-default">&lt;</button>
												                  				<button class="js-cal-next btn btn-default">&gt;</button>
												                			</span>
												                			<button class="js-cal-option btn btn-default {{: first.toDateInt() <= today.toDateInt() && today.toDateInt() <= last.toDateInt() ? 'active':'' }}" data-date="{{: today.toISOString()}}" data-mode="month">{{: todayname }}</button>
												              			</td>
												              			<td>
												                			<span class="btn-group btn-group-lg">
												                  				{{ if (mode !== 'day') { }}
												                    			{{ if (mode === 'month') { }}<button class="js-cal-option btn btn-link" data-mode="year">{{: months[month] }}</button>{{ } }}
												                    			{{ if (mode ==='week') { }}
												                      			<button class="btn btn-link disabled">{{: shortMonths[first.getMonth()] }} {{: first.getDate() }} - {{: shortMonths[last.getMonth()] }} {{: last.getDate() }}</button>
												                    			{{ } }}
												                    			<button class="js-cal-years btn btn-link">{{: year}}</button> 
												                  				{{ } else { }}
												                    			<button class="btn btn-link disabled">{{: date.toDateString() }}</button> 
												                  				{{ } }}
												                			</span>
												              			</td>
												              			<td style="text-align: right">
												                			<span class="btn-group">
												                  				<button class="js-cal-option btn btn-default {{: mode==='year'? 'active':'' }}" data-mode="year">Year</button>
												                  				<button class="js-cal-option btn btn-default {{: mode==='month'? 'active':'' }}" data-mode="month">Month</button>
												                  				<button class="js-cal-option btn btn-default {{: mode==='week'? 'active':'' }}" data-mode="week">Week</button>
												                  				<button class="js-cal-option btn btn-default {{: mode==='day'? 'active':'' }}" data-mode="day">Day</button>
												                			</span>
												              			</td>
												            		</tr>
												          		</table>
												        	</td>
												      	</tr>
												    </thead>
												    {{ if (mode ==='year') {
												      month = 0;
												    }}
												    <tbody>
												      {{ for (j = 0; j < 3; j++) { }}
												      <tr>
												        {{ for (i = 0; i < 4; i++) { }}
												        <td class="calendar-month month-{{:month}} js-cal-option" data-date="{{: new Date(year, month, 1).toISOString() }}" data-mode="month">
												          {{: months[month] }}
												          {{ month++;}}
												        </td>
												        {{ } }}
												      </tr>
												      {{ } }}
												    </tbody>
												    {{ } }}
												    {{ if (mode ==='month' || mode ==='week') { }}
												    <thead>
												      <tr class="c-weeks">
												        {{ for (i = 0; i < 7; i++) { }}
												          <th class="c-name">
												            {{: days[i] }}
												          </th>
												        {{ } }}
												      </tr>
												    </thead>
												    <tbody>
												      {{ for (j = 0; j < 6 && (j < 1 || mode === 'month'); j++) { }}
												      <tr>
												        {{ for (i = 0; i < 7; i++) { }}
												        {{ if (thedate > last) { dayclass = nextmonthcss; } else if (thedate >= first) { dayclass = thismonthcss; } }}
												        <td class="calendar-day {{: dayclass }} {{: thedate.toDateCssClass() }} {{: date.toDateCssClass() === thedate.toDateCssClass() ? 'selected':'' }} {{: daycss[i] }} js-cal-option" data-date="{{: thedate.toISOString() }}">
												          <div class="date">{{: thedate.getDate() }}</div>
												          {{ thedate.setDate(thedate.getDate() + 1);}}
												        </td>
												        {{ } }}
												      </tr>
												      {{ } }}
												    </tbody>
												    {{ } }}
												    {{ if (mode ==='day') { }}
												    <tbody>
												      <tr>
												        <td colspan="7">
												          <table class="table table-striped table-condensed table-tight-vert" >
												            <thead>
												              <tr>
												                <th>&nbsp;</th>
												                <th style="text-align: center; width: 100%">{{: days[date.getDay()] }}</th>
												              </tr>
												            </thead>
												            <tbody>
												              <tr>
												                <th class="timetitle" >All Day</th>
												                <td class="{{: date.toDateCssClass() }}">  </td>
												              </tr>
												              <tr>
												                <th class="timetitle" >Before 6 AM</th>
												                <td class="time-0-0"> </td>
												              </tr>
												              {{for (i = 6; i < 22; i++) { }}
												              <tr>
												                <th class="timetitle" >{{: i <= 12 ? i : i - 12 }} {{: i < 12 ? "AM" : "PM"}}</th>
												                <td class="time-{{: i}}-0"> </td>
												              </tr>
												              <tr>
												                <th class="timetitle" >{{: i <= 12 ? i : i - 12 }}:30 {{: i < 12 ? "AM" : "PM"}}</th>
												                <td class="time-{{: i}}-30"> </td>
												              </tr>
												              {{ } }}
												              <tr>
												                <th class="timetitle" >After 10 PM</th>
												                <td class="time-22-0"> </td>
												              </tr>
												            </tbody>
												          </table>
												        </td>
												      </tr>
												    </tbody>
												    {{ } }}
												  </table>
												</script>

  <script src='js/calendarquerymin.js'></script>
<script src='js/bootstrapjquerytheme.js'></script>

    <script  src="js/calendar_index.js"></script>
											</td>
										</tbody>
									</table>
								</tr>
						</tbody>
					</table>		
	  			</tr>
	  		</tbody>
	  	</table>
	</div>

	<script>
		function drivermanagement_display() {
			document.getElementById('driverdata_td').style.display = 'block';
			document.getElementById('reporting').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('delivery-edit-div').style.display = 'none';
			document.getElementById('scheduledata_td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';

		}

		function dashboard_display() {
			<?php 
				$_SESSION['loggedin_time'] = time();
			?>
			document.getElementById('dashboard-panel').style.display = 'block';
			document.getElementById('reporting').style.display = 'none';
			document.getElementById('scheduledata_td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}

		function customermanagement_display() {
			document.getElementById('customerdata-td').style.display = 'block';
			document.getElementById('reporting').style.display = 'none'; 								
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('scheduledata_td').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';	
		}

		function truckmanagement_display() {
			document.getElementById('truckmanagement-td').style.display = 'block';
			document.getElementById('delivery-edit-div').style.display = 'block';
			document.getElementById('reporting').style.display = 'none';
			document.getElementById('scheduledata_td').style.display = 'none';
			document.getElementById('schedule-edit-div').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}

		function deliverymanagement_display() {
			document.getElementById('deliverymanagement-td').style.display = 'block';
			document.getElementById('reporting').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}

		function profilemanagement_display() {
			document.getElementById('profile-td').style.display = 'block';
			document.getElementById('reporting').style.display = 'none';
			document.getElementById('scheduledata_td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}

		function schedulemanagement_display() {
			document.getElementById('scheduledata_td').style.display = 'block';
			document.getElementById('schedule-edit-div').style.display = 'block';
			document.getElementById('reporting').style.display = 'none';
			document.getElementById('delivery-edit-div').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}
		function reportmanagement_display() {
			document.getElementById('reporting').style.display = 'block';
			document.getElementById('scheduledata_td').style.display = 'none';
			document.getElementById('schedule-edit-div').style.display = 'none';
			document.getElementById('delivery-edit-div').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}

		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}
	</script>
</body>
<!-- <script src="js/displayjquery.js"></script>
<script src="js/popupjquery.js"></script> -->
	
<!-- <script type="text/javascript">
    $(function() {
      $(".js__p_start").simplePopup();
    });
</script> -->
<!-- <script type="text/javascript" src="js/jquery.popup.js"></script> -->
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $("#export_pdf").click(function () {
            // parse the HTML table element having an id=exportTable
            var dataSource = shield.DataSource.create({
                data: "#tbl-customer",
                schema: {
                    type: "table",
                    fields: {
                        FIRST_NAME: { type: String },
						LAST_NAME: { type: String },
						CONTACTS: { type: Number },
						EMAIL: { type: String },
						ADDRESS: { type: String }
                    }
                }
            });

            // when parsing is done, export the data to PDF
            dataSource.read().then(function (data) {
                var pdf = new shield.exp.PDFDocument({
                    author: "PrepBootstrap",
                    created: new Date()
                });

                pdf.addPage("a4", "portrait");

                pdf.table(
                    50,
                    50,
                    data,
                    [
                        { field: "FIRST_NAME", title: "FIRST NAME", width: 200 },
                        { field: "LAST_NAME", title: "LAST NAME", width: 50 },
                        { field: "CONTACTS", title: "PHONE NUMBER", width: 200 },
                        { field: "EMAIL", title: "EMAIL ADDRESS", width: 50 },
                        { field: "ADDRESS", title: "HOME ADDRESS", width: 200 }
                    ],
                    {
                        margins: {
                            top: 50,
                            left: 50
                        }
                    }
                );

                pdf.saveAs({
                    fileName: "PrepBootstrapPDF"
                });
            });
        });
    });
</script>
<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
</footer>
</html>
