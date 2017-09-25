<?php
	require_once __DIR__ . '/db_config.php';
	
	$query1 = "SELECT * FROM britehousedeliverymanagement.VEHICLE";
	$query2 = "SELECT CUSTOMER.CUST_FNAME, CUSTOMER.CUST_LNAME, CUSTOMER.CUST_PHONE, CUSTOMER.CUST_EMAIL, CUSTOMER.CUST_ADDRESS FROM britehousedeliverymanagement.CUSTOMER";
	$query3 = "SELECT * FROM britehousedeliverymanagement.DRIVER";
	$query4 = "CALL select_delivery()";
	
	$result1 = mysqli_query($conn, $query1);
	$result2 = mysqli_query($conn, $query2);
	$result3 = mysqli_query($conn, $query3);
	$result4 = mysqli_query($conn, $query1);
	$result5 = mysqli_query($conn, $query4);

	session_start();

	$expireAfter = 30;
	$user = '';

	if(isset($_SESSION['login_user'])) {
		$myArray = explode('.', $_SESSION['login_user']);
		$user = $myArray[0];
		$id = $myArray[1];
		$secondsInactive = time() - $_SESSION['login_user'];
		$expireAfterSeconds = $expireAfter * 60;

		if($secondsInactive >= $expireAfterSeconds){
			session_unset();
			session_destroy();
			header("location: index.html");
		}
	}
?>

<!DOCTYPE html>
<html >
<head>
  	<meta charset="UTF-8">
 	<title>Admin | BriteHouse</title>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/calendar_style.css">
	<script src="https://use.fontawesome.com/484df5253e.js"></script>

	<link rel="stylesheet" href="css/jquery.popup.css" type="text/css">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.popup.js"></script>
	<script type="text/javascript">
	    $(function() {
	      $(".js__p_start").simplePopup();
	    });
	    $(function() {
	      $("#save_entry").click(function() {
	      	alert("TESTING");
	      });
	    });
	</script>
	<script type="text/javascript">
		$(function() {
		    $('#test').click(function(event) {
		        var value = document.getElementById('test').value;
		        $.post('test.php', {value: value}, function(response) {
		            alert(response);
		        });
		    );
		});
	</script>

  	<header>
		<div id="top-div" style="margin-left: 75.1%;">
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

<body onbeforeunload=”HandleBackFunctionality()”>
  	<head>
  		<script src="https://use.fontawesome.com/484df5253e.js"></script>
	</head>
	<!-- <div class="p_anch"> <a href="#" class="js__p_start">Click Here</a></div> -->
	<div class="p_body js__p_body js__fadeout"></div>
	<div id="customer-edit-div" class="popup js__popup js__slide_top" style="margin-bottom: 0px; background-color: lightblue; display: none;">
		<h2 style="margin-bottom: 25px; margin-top: 13px; position: absolute; font-size: 16px;">BRITEHOUSE DELIVERY MANAGEMENT SYSTEM</h2>
		<a href="#" class="p_close js__p_close" title="Close"></a>
	    <div class="p_content" style="background-color: lightblue; height: 500px;">
	    	<h2 style="margin-bottom: 25px; margin-top: 0px; text-align: left; border-bottom: 1px solid white;">EDIT CUSTOMER</h2>
	    	<table style="margin: 0 auto; width: 90%;">
	    		<tbody>
	    			<tr>
	    				<td style="width: 50%;">
	    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-right: none; border-top-right-radius: 0; border-bottom-right-radius: 0;">
								<div style="text-align: right;"><p><label for="cus_fname" class="floatLabel">FIRST NAME</label></p></div>
								<div style="text-align: right;"><p><label for="cus_lname" class="floatLabel">LAST NAME</label></p></div>
								<div style="text-align: right;"><p><label for="cus_phone" class="floatLabel">PHONE</label></p></div>
								<div style="text-align: right;"><p><label for="cus_email" class="floatLabel">EMAIL</label></p></div>
								<div style="text-align: right; height: 50px;"><p><label for="cus_address" class="floatLabel">ADDRESS</label></p></div>
							</div>
	    				</td>
	    				<td style="width: 50%; margin-left: 0;">
	    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;">
								<div><p><input type="text" id="cus_fname" name="cus_fname"></p></div>
								<div><p><input type="text" id="cus_lname" name="cus_lname"></p></div>
								<div><p><input type="text" id="cus_phone" name="cus_phone"></p></div>
								<div><p><input type="text" id="cus_email" name="cus_email"></p></div>
								<div style="height: 50px;"><p><textarea id="cus_address" name="cus_address" cols="20" rows="2"></textarea></p></div>
								<p><input type="button" name="" value="UPDATE" style="width: 100px; margin-left: 45%; border-radius: 2px; background-color: #00a651; border: none; -webkit-appearance: button; cursor: pointer; color: white; margin-top: 0px; margin-bottom: 10px;"></p>
							</div>
	    				</td>
	    			</tr>
	    		</tbody>
	    	</table>

				<?php 
					$hostname = "localhost";
					$username = "root";
					$password = "tl004";
					$databaseName = "britehousedeliverymanagement";

					$connect = mysqli_connect($hostname, $username, $password, $databaseName);
					$query5 = "SELECT CUSTOMER.CUST_FNAME, CUSTOMER.CUST_LNAME, CUSTOMER.CUST_PHONE, CUSTOMER.CUST_EMAIL, CUSTOMER.CUST_ADDRESS FROM britehousedeliverymanagement.CUSTOMER WHERE CUSTOMER.CUST_EMAIL ='strtolower($id)'";
					$result6 = mysqli_query($connect, $query5);
					$firstname = '';
					$lastname = '';
					$phone = '';
					$email = '';
					$address = '';


					if ($result6->num_rows > 0) {
				        // output data of each row
				        while($row = $result6->fetch_assoc()) {
				            $firstname = $row["CUST_FNAME"];
				            $lastname = $row["CUST_LNAME"];
				            $phone = $row["CUST_PHONE"];
				            $email = $row["CUST_EMAIL"];
				            $address = $row["CUST_ADDRESS"];
				        }
				    }
				?>
				<script type="text/javascript">
					document.getElementById('cus_fname').value ="<?php echo htmlentities($firstname)?>";
					document.getElementById('cus_lname').value ="<?php echo htmlentities($lastname)?>";
					document.getElementById('cus_phone').value ="<?php echo htmlentities($phone)?>";
					document.getElementById('cus_email').value ="<?php echo htmlentities($email)?>";
					document.getElementById('cus_address').value ="<?php echo htmlentities($address)?>";
				</script>

			</div>

	    </div>
	</div>
	
	<div id="delivery-edit-div" class="popup js__popup js__slide_top" style="margin-bottom: 0px; background-color: lightblue; display: none;">
		<form action="savevehicles.php" method="post">
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
									<div><p><label for="vehicle_type" class="floatLabel">VEHICLE TYPE</label></p></div>
									<div><p><label for="loadlimit" class="floatLabel">LOAD CAPABILITY</label></p></div>
									<div><p><label for="transportcost" class="floatLabel">COST</label></p></div>
									<div><p><label for="depot_range" class="floatLabel">DEPOT RANGE</label></p></div>
								</div>
		    				</td>
		    				<td style="width: 50%; margin-left: 0;">
		    					<div id="profile-edit-div2" style="margin: 0 auto; margin-left: 0; width: 100%; height: 400px; border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;">
									<div><p><input type="text" id="transportreg" name="transportreg"></p></div>
									<div><p><input type="text" id="transportype" name="transportype"></p></div>
									<div><p><input type="text" id="loadlimit" name="loadlimit"></p></div>
									<div><p><input type="text" id="transportcost" name="transportcost"></p></div>
									<div><p><input type="text" id="depotrange" name="depotrange"></p></div>
									<p><input id="vehicle_button" type="submit" name="" value="ADD" style="width: 100px; border-radius: 2px; background-color: #00a651; border: none; -webkit-appearance: button; cursor: pointer; color: white; margin-bottom: 10px; text-align: center; height: 30px;"></p>
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
											<img src="Images/admin" alt="britehouse_icon" style="width: 80px; height: 80px; border: 2px solid lightblue; border-radius: 40px; margin-left: 50px;">
											<label style="font-size: 14px; color: lightgrey; display: inline; margin-left: 60px;">Welcome, <p style="color: white; font-size: 16px; text-transform:capitalize; text-align: center; margin-left: 60px;"><?php echo $user;?></p></label>
											<li onclick="dashboard_display();"><a href="#" onclick="dashboard_display();">DASHBOARD</a></li>
											<li onclick="customermanagement_display();"><a href="#" onclick="customermanagement_display();">CUSTOMER MANGEMENT</a></li>
											<li onclick="deliverymanagement_display();"><a href="#" onclick="deliverymanagement_display();">DELIVERY MANGEMENT</a></li>
											<li ><a href="#">SCHEDULE MANGEMENT</a></li>
											<li ><a href="#">DRIVER MANGEMENT</a></li>
											<li onclick="truckmanagement_display();"><a href="#" onclick="truckmanagement_display();">TRUCK MANGEMENT</a></li>
											<li onclick="profilemanagement_display();"><a href="#" onclick="profilemanagement_display();">PROFILE</a></li>
											<li onclick="profilemanagement_display();"><a href="#" onclick="profilemanagement_display();">HELP</a></li>
											<li style="border-bottom: 1px solid rgba(69, 74, 84, 0.7);" onclick="logout();"><a href="#" onclick="logout();">LOGOUT</a></li>
										</ul>
									</div>
								</tr>
							</tbody>
						</table>		
					</td>
					<td id="dashboard-panel" style="width: 100%; margin-top: 0px; vertical-align: top; background-color: whitesmoke; height: 556px;">
						<table style="margin-left: 10px;">
							<tbody>
								<tr>
									<div id="dashboard" style="width: 100%; height: 50px; border-bottom: 1.5px solid grey; line-height: 50px; margin-bottom: 10px; ">
										<a style="color: grey; font-size: 20px; text-decoration: none; margin-right: 60%; margin-left: 10px;">ADMIN DASHBOARD</a>
										<a style="padding: 10px; color: grey; font-size: 12px; text-decoration: none; margin-right: 0px; border-right: 1px dotted grey; text-align: center;">DRIVER</a>
										<a style="padding: 10px; color: grey; font-size: 12px; text-decoration: none; margin-right: 10px; border-right: 1px dotted grey;">VEHICLE</a>
										<a style="color: grey; font-size: 12px; text-decoration: none;">DELIVERY</a>
									</div>
								</tr>
								<tr>
									<td style="vertical-align: top; margin-top: 10px; margin-right: 10px; width: 500px; margin-left: 3px;">
										<table>
										<tbody>
											<tr>
												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; border: 1px solid grey; border-radius: 3px;">
												<li onclick="driver_display();"><a href="#" onclick="driver_display();" style="font-size: 12px; color: grey; text-decoration: none;">DRIVER</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 30px; border: 1px solid grey; border-radius: 3px;">
												<li onclick="truck_display();"><a href='#'; onclick="truck_display();" style="font-size: 12px; color: grey; text-decoration: none;">TRUCK</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 30px; border: 1px solid grey; border-radius: 3px;">
												<li onclick="delivery_display();"><a href="#" onclick="delivery_display();" style="font-size: 12px; color: grey; text-decoration: none;">DELIVERY</a></li>
												</td>
											</tr>

											<tr>
												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; font-size: 0.9em; list-style: none; margin-left: 0px; margin-top: 30px; margin-right: 30px; border: 1px solid grey; border-radius: 3px;">
												<li><a href="#" onclick="inventory_display();" style="font-size: 12px; color: grey; text-decoration: none; line-height: 80px;">INVENTORY</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-top: 30px; border: 1px solid grey; border-radius: 3px;">
												<li><a href="#" style="font-size: 12px; color: grey; text-decoration: none;">OPERATION REPORT</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 30px; margin-top: 30px; border: 1px solid grey; border-radius: 3px;">
												<li><a href="#" style="font-size: 12px; color: grey; text-decoration: none;">SETTINGS</a></li>
												</td>
											</tr>

											<tr>
												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 0px; margin-top: 30px; border: 1px solid grey; border-radius: 3px;">
												<li><a href="#" style="font-size: 12px; color: grey; text-decoration: none;">NOTICEBOARD</a></li>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
									<!-- insert here -->
									<td id="dashboard_calendar" style="vertical-align: top;">
										<table>
											<tbody>
												<tr>
													<td>
														<table>
															<tbody>
																<tr>
																	<td>
																		<div id="noticeboard_header" style="background: #1A237E; height: 30px; margin-left: 10px; margin-right: 1px;"><a href="" style="line-height: 30px; font-size: 12px;">CALENDAR SCHEDULE</a></div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<div id="app"></div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>

													<td style="vertical-align: top; margin-top: 10px;" id="dashboard_notice">
														<table>
															<tbody>
																<tr>
																	<td>
																		<div id="noticeboard_header" style="background: #1A237E; height: 30px;"><a href="" style="line-height: 30px; font-size: 12px;">NOTICEBOARD</a></div>
																	</td>
																</tr>
																<tr>
																	<td>
																		<div id="noticeboard_content" style="height: 418px; width: 290px; border-top: none; border: 1px solid grey; background-color: whitesmoke; overflow-y: auto; -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);">
																			 <?php while($row1 = mysqli_fetch_array($result1)):;?>
																			 	<p>MEETING OF THE DAY<label>09/10/2015 11:00 AM</label></br></br><?php echo $row1[0];?></label></p></br>
																			 <?php endwhile;?>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
									
									<td id="truckdata_td" style="display: none; vertical-align: top; background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4); margin-right: 1px;">
										<section>
										  <!--for demo wrap-->
										  <h2 style="text-align: left; color: white;">TRUCK INFORMATION</h2>
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
														</tr>
													</thead>
												</table>
											</div>
										  <div id="tbl-content" style="height: 405px;">
										    <table cellpadding="0" cellspacing="0" border="0">
										      <tbody>
										        <?php while($row1 = mysqli_fetch_array($result1)):;?>
													<tr>
														<td><?php echo $row1[0];?></td>
														<td><?php echo $row1[1];?></td>
														<td><?php echo $row1[2];?></td>
														<td><?php echo $row1[3];?></td>
														<td><?php echo $row1[4];?></td>
														<td><?php echo $row1[5];?></td>
													</tr>
												<?php endwhile;?>
										      </tbody>
										    </table>
										  </div>
										</section>
									</td>

									<td id="driverdata_td" style="display: none; vertical-align: top; background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4); margin-right: 1px;">
										<section>
										  <!--for demo wrap-->
										  <h2 style="text-align: left; color: white;">DRIVER INFORMATION</h2>
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
														<td><?php echo $row1[5];?></td>
													</tr>
												<?php endwhile;?>
										      </tbody>
										    </table>
										  </div>
										</section>
									</td>

								</tr>
							</tbody>
						</table>				
					</td>

					<td id="truckmanagement-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">VEHICLE INFORMATION</h2>
						<input class="js__p_start"; type="button" id="addcustomer" onclick="document.getElementById('vehicle_button').value = 'ADD'" name="addcustomer" value="ADD VEHICLE" style="background-color: #00a651; color: white; border: none; border-radius: 2px; margin-bottom: 10px;text-align: right; margin-left: 89%; margin-right: 0; cursor: pointer;">
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
							        <?php while($row1 = mysqli_fetch_array($result4)):;?>
										<tr>
											<td><?php echo $row1[0];?></td>
											<td><?php echo $row1[1];?></td>
											<td><?php echo $row1[2];?></td>
											<td><?php echo $row1[3];?></td>
											<td><?php echo $row1[4];?></td>
											<td><?php echo $row1[5];?></td>
											<td style="text-align: left;"><input type="submit" id="truckid" name="truckid" value="<?php echo $row1[0];?>" style="width: 100px;"></td>
											<td style="text-align: right;">
											<input
												onclick="document.getElementById('delivery-edit-div').style.display = 'block'; document.getElementById('customer-edit-div').style.display = 'none'; document.getElementById('vehicle_button').value = 'UPDATE'" 
												class="js__p_start"; 
												type="button" value="EDIT" style="width: 100px;"
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

					<td id="deliverymanagement-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">DELIVERY INFORMATION</h2>
						<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
						  <!--for demo wrap-->
						  <div id="tbl-header">
								<table cellpadding="0" cellspacing="0" border="0">
									<thead>
										<tr>
											<th>ITEM NAME</th>
											<th>REQUESTED DATE</th>
											<th>EXPECTED DATE</th>
											<th>ARRIVAL TIME</th>
											<th>DELIVERY LOCATION</th>
											<th>STATUS</th>
											<th>VEHICLE REG</th>
											<th>CONTACT PERSON</th>
											<th></th>
											<th></th>		
										</tr>
									</thead>
								</table>
							</div>
						  <div id="tbl-content">
						    <table cellpadding="0" cellspacing="0" border="0">
						      <tbody>
						        <?php while($row1 = mysqli_fetch_array($result5)):;?>
									<tr>
										<td><?php echo $row1[0];?></td>
										<td><?php echo $row1[1];?></td>
										<td><?php echo $row1[2];?></td>
										<td><?php echo $row1[3];?></td>
										<td><?php echo $row1[4];?></td>
										<td><?php echo $row1[5];?></td>
										<td><?php echo $row1[6];?></td>
										<td><?php echo $row1[7];?></td>
										<td></td>
										<td style="text-align: right;"><input class="js__p_start" type="submit" value="EDIT" style="width: 100px; margin-bottom: 5px;"><input type="submit" value="DELETE" style="width: 100px;" onclick="document.getElementById('delivery-edit-div').style.display = 'block'" class="js__p_start"></td>
									</tr>
								<?php endwhile;?>
						      </tbody>
						    </table>
						  </div>
						</section>
					</td>

					<td id="customerdata-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">CUSTOMER INFORMATION</h2>
						<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
						  <!--for demo wrap-->
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
						        <?php while($row1 = mysqli_fetch_array($result2)):;?>
									<tr>
										<td><?php echo $row1[0];?></td>
										<td><?php echo $row1[1];?></td>
										<td><?php echo $row1[2];?></td>
										<td id="test" name="test"><?php echo $row1[3];?></td>
										<td><?php echo $row1[4];?></td>
										<td><input type="submit" value="DELETE" style="width: 100px;"></td>
									</tr>
								<?php endwhile;?>
						      </tbody>
						    </table>
						  </div>
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

	  			</tr>
	  		</tbody>
	  	</table>
	</div>

	<script>
		function truck_display() {
			document.getElementById('truckdata_td').style.display = 'block';
			document.getElementById('driverdata_td').style.display = 'none';
			document.getElementById('dashboard_calendar').style.display = 'none';
		}

		function driver_display() {
			document.getElementById('driverdata_td').style.display = 'block';
			document.getElementById('truckdata_td').style.display = 'none';
			document.getElementById('dashboard_calendar').style.display = 'none';
		}

		function dashboard_display() {
			document.getElementById('dashboard_calendar').style.display = 'block';
			document.getElementById('dashboard-panel').style.display = 'block';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('truckdata_td').style.display= 'none';
			document.getElementById('driverdata_td').style.display= 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
		}

		function customermanagement_display() {
			document.getElementById('customerdata-td').style.display = 'block'; 								
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';	
		}

		function truckmanagement_display() {
			document.getElementById('truckmanagement-td').style.display = 'block';
			document.getElementById('delivery-edit-div').style.display = 'block';
			document.getElementById('customer-edit-div').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
		}

		function deliverymanagement_display() {
			document.getElementById('deliverymanagement-td').style.display = 'block';
			document.getElementById('customer-edit-div').style.display = 'block';
			document.getElementById('delivery-edit-div').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
		}

		function profilemanagement_display() {
			document.getElementById('profile-td').style.display = 'block';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('truckmanagement-td').style.display = 'none';
			document.getElementById('deliverymanagement-td').style.display = 'none';
		}

		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}

		function logout() {
			window.location.href = 'index.html';
		}
	</script>
	<script src='https://npmcdn.com/react@15.3.0/dist/react.min.js'></script>
	<script src='https://npmcdn.com/react-dom@15.3.0/dist/react-dom.min.js'></script>
	<script src="js/calendar_index.js"></script>
</body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
</footer>
</html>
