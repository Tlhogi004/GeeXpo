<?php
	require_once __DIR__ . '/db_config.php';
	
	session_start();
	$myArray = explode('|', $_SESSION['login_user']);

		$user_name = $myArray[0];
		if(!$myArray[1]){header("Location:index.php");}
		$user_address = $myArray[1];
		if(!$myArray[2]){header("Location:index.php");}
		$user_phone = $myArray[2];
		if(!$myArray[3]){header("Location:index.php");}
		$user_email = $myArray[3];

	//Connect to our MySQL database using the PDO extension.
	$pdo = new PDO('mysql:host=localhost;dbname=britehousedeliverymanagement', 'root', 'tl004');

	/*===================RETRIEVE ALL NOTICE COMENTS===================*/
	$retrieveNoticeComments = "CALL select_all_notice_comments()";
	$stmt = $pdo->prepare($retrieveNoticeComments);
	$stmt->execute();
	$noticeinfo = $stmt->fetchAll();
	/*=================================================================*/

	/*======================RETRIEVE CUSTOMER INFO=====================*/
	$retrieveCustomerInfo = "CALL select_customer('$user_email')";
	$stmt = $pdo->prepare($retrieveCustomerInfo);
	$stmt->execute();
	$customerinfo = $stmt->fetchAll();
	/*=================================================================*/

	$expireAfter = 30;

	if(isset($_SESSION['login_user'])) {
		$secondsInactive = time() - $_SESSION['login_user'];
		$expireAfterSeconds = $expireAfter * 60;

		if($secondsInactive >= $expireAfterSeconds){
				
		}
	}
?>

<!DOCTYPE html>
<html >
<head>
  	<meta charset="UTF-8">
 	<title>User Account | BriteHouse</title>
	<link rel="stylesheet" type="text/css" href="css/calendarbootstrapstylemin.css">

	<link rel="stylesheet" href="css/noncalendarfunctionstyle.css">
	<link rel="stylesheet" href="css/timer_style.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="css/jquery.popup.css" type="text/css">

	<script type="text/javascript">
		
	</script>

  	<header>
		<div id="top-div" style="color: black; height: 40px; width: 100px; font-size: 13.3333px; margin-left: 75.1%;">
			<input type="submit" value="Client Panel" id="inserttransport" style="background: linear-gradient(#64B5F6, #1A237E); border-width: 0px; color: white;">
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
		<form action="insertorder2.php" method="get">
			<h2 style="margin-bottom: 25px; margin-top: 13px; position: absolute; font-size: 16px;">BRITEHOUSE DELIVERY MANAGEMENT SYSTEM</h2>
			<a href="#" class="p_close js__p_close" title="Close"></a>
		    <div class="p_content" style="background-color: lightblue; height: 550px; border-radius: 10px;">
		    	<h2 style="margin-bottom: 25px; margin-top: 0px; text-align: left; border-bottom: 1px solid white;">PLACE ORDER</h2>
				<table style="margin: 0 auto; width: 90%;">
		    		<tbody>
		    			<tr>
		    				<td style="width: 50%;">
		    					<div id="profile-edit-div2" style="border-right: none;">
									<div style="height: 40px;"><p><label for="deliveryitem" class="floatLabel">DELIVERY ITEM</label></p></div>
									<div style="height: 40px;"><p><label for="expecteddate" class="floatLabel">EXPECTED DATE</label></p></div>
									<div style="height: 40px;"><p><label for="billingaddress" class="floatLabel">BILLING ADDRESS</label></p></div>
								</div>
		    				</td>
		    				<td style="width: 50%; margin-left: 0;">
		    					<div id="profile-edit-div2" style="border-left: none;">
									<div style="height: 40px;"><p><input type="text" id="deliveryitem" name="deliveryitem" style="height: 25px;"></p></div>
									<div style="height: 40px;"><p><input type="text" id="expecteddate" name="expecteddate" style="height: 25px;"></p></div>
									<div style="height: 40px;"><p><input type="text" id="billingaddress" name="billingaddress" style="height: 25px;"></p></div>
									<input type="hidden" id="email1" name="email1" value="<?php echo $user_email; ?>" style="height: 25px;">
									<p><input id="vehicle_button" type="submit" name="" value="CONTINUE" style="background: limegreen; text-align: center;"></p>
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
											<label style="font-size: 16px; color: lightgrey; display: inline; margin-left: 60px;">Welcome, <p style="color: white; font-size: 13.3333px; text-transform:capitalize;width:100px;margin-left: 60px;">Mr. <?php echo $user_name;?></p></label>
											<li onclick="dashboard_display();"><a href="#" onclick="dashboard_display();">DASHBOARD</a></li>
											<li onclick="ordermanagement_display();"><a href="#" onclick="ordermanagement_display();">ORDER MANGEMENT</a></li>
											<li onclick="profilemanagement_display();"><a href="#" onclick="profilemanagement_display();">PROFILE</a></li>
											<li onclick="profilemanagement_display();"><a href="#" onclick="profilemanagement_display();">HELP</a></li>
											<li style="border-bottom: 1px solid rgba(69, 74, 84, 0.7);" onclick="location.href='sessionlogout.php';"><a href="sessionlogout.php">LOGOUT</a></li>
										</ul>
									</div>
								</tr>
							</tbody>
						</table>		
					</td>
					<td id="profile-td" style="display: none; width: 100%; vertical-align: top; background: white; margin-top: 0; height: auto;">
	  					<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;"><h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">PROFILE INFORMATION</h2>
						<form id="signup-form" style="margin-left: 0px; margin-right: 0px; margin-top: 10px; width: 100%; max-width: 1090px;">
							<table>
								<tbody>
									<tr>
										<div id="profile-changepassword-div">
											<h2 style="margin-bottom: 25px; color: grey;">EDIT PROFILE</h2>
											<div><p><label for="profilename" class="floatLabel">NAME</label><input type="text" id="profilename" name="profilename" value="<?php echo $user_name ?>"></p></div>
											<div><p><label for="profileemail" class="floatLabel">EMAIL</label><input type="text" id="profileemail" name="profileemail" value="<?php echo $user_email ?>"></p></div>
											<div><p><label for="profileaddress" class="floatLabel">ADDRESS</label><input type="text" id="profileaddress" name="profileaddress" value="<?php echo $user_address ?>"></p></div>
											<div><p><label for="profilephone" class="floatLabel">PHONE</label><input type="text" id="profilephone" name="profilephone" value="<?php echo $user_phone ?>" ></p></div>
											<p><input type="button" name="" value="UPDATE" style="margin-left: 45%; font-weight: bold; font-size: 16px;"></p>
										</div>
									</tr>
									<tr>
										<p>
											<div id="profile-changepassword-div">
												<h2 style="color: grey;">CHANGE PASSWORD</h2>
												<div><p><label for="profileoldpassword" class="floatLabel">OLD PASSWORD</label><input type="password" id="profileoldpassword" name="profileoldpassword"></p></div>
												<div><p><label for="profilenewpassword" class="floatLabel">NEW PASSWORD</label><input type="password" id="profilenewpassword" name="profilenewpassword"></p></div>
												<div><p><label for="profileconfirmpassword" class="floatLabel">CONFIRM PASSWORD</label><input type="password" id="profileconfirmpassword" name="profileconfirmpassword"></p></div>
												<p><input type="button" id="updatepassword" name="updatepassword" value="UPDATE" style="margin-left: 45%; 	font-weight: bold; font-size: 16px;" onclick="funChangePassword();"></p>
											</div>
										</p>
									</tr>

								</tbody>
							</table>
						</form>
	  				</td>
					<td id="customerdata-td" style="display: none; width: 100%; margin-top: 10.8px; vertical-align: top; margin-right: 5px;">
						<h1>Britehouse Delivery Management System</h1>
						<img src="images/right arrow.png" style="width: 30px;">
						<h2 style="display: inline; vertical-align: top; line-height: 34px; margin-left: 10px;">ORDER INFORMATION</h2>
						<input style="margin-left: 685px; font-weight: bold; font-size: 16px;" class="js__p_start"; type="button" id="addcustomer" value="PLACE ORDER">
						<table>
							<tbody>
								<tr>
									<td style="width: 50%;">
									<div style="width: 99.9%; background-color: whitesmoke; height: 310px; margin-bottom: 10px; border: 0.5px solid whitesmoke;">
										<table>
											<tbody>
												<tr>
													<td style="vertical-align: top; width: 60%;">
														<table>
															<tbody>
																<tr>
																	<td>
																		<table style="width: 300px;">
																			<tbody>
																				<tr>
																					<td>
																						<table>
																							<tbody>
																								<div style="text-align: right; margin-bottom: 10px; margin-top: 10px;"><label>ORDER NO:</label></div>
																								<div style="text-align: right; margin-bottom: 10px;"><label>ORDER ITEM:</label></div>
																								<div style="text-align: right; margin-bottom: 10px;"><label>ORDER DATE:</label></div>
																								<div style="text-align: right; margin-bottom: 10px;"><label>ORDER EXPECTED:</label></div>
																								<div style="text-align: right; margin-bottom: 10px;"><label>ORDER STATUS:</label></div>
																								<div style="text-align: right; margin-bottom: 10px;"><label>ASSIGNED TO:</label></div>
																							</tbody>
																						</table>
																					</td>
																					<td>
																						<table style="margin-left: 10px;">
																							<tbody>
																								<div style="text-align: left; margin-bottom: 10px; margin-top: 10px;">
																									<label id="orderno" style="margin-left: 5px;">
																									</label>
																								</div>

																								<div style="text-align: left; margin-bottom: 10px;">
																									<label id="orderitem1" style="margin-left: 5px;">
																										
																									</label>
																								</div>
																								<div style="text-align: left; margin-bottom: 10px;">
																									<label id="orderdate" style="margin-left: 5px;">
																										
																									</label>
																								</div>
																								<div style="text-align: left; margin-bottom: 10px;">
																									<label id="orderexpecteddate" style="margin-left: 5px;">
																										
																									</label>
																								</div>
																								<div style="text-align: left; margin-bottom: 10px;">
																									<label id="orderstatus" style="margin-left: 5px;">
																										
																									</label>
																								</div>
																								<div style="text-align: left; margin-bottom: 10px;">
																									<label id="orderassignedto" style="margin-left: 5px;">
																										
																									</label>
																								</div>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																	<td style="vertical-align: top;">
																		<table style="width: 300px; margin-top: 10px;">
																			<tbody>
																				<tr>
																					<td>
																						<table>
																							<tbody>
																								<tr>
																									<div style="text-align: right; margin-bottom: 10px;"><label>CUSTOMER NAME:</label></div>
																									<div style="text-align: right; margin-bottom: 10px;"><label>BILLING ADDRESS:</label></div>
																									<div style="text-align: right; margin-bottom: 10px;"><label>PHONE:</label></div>
																									<div style="text-align: right; margin-bottom: 10px;"><label>EMAIL:</label></div>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																					<td>
																						<table style="margin-left: 10px;">
																							<tbody>
																								<tr>
																									<div style="text-align: left; margin-bottom: 10px;">
																										<label style="margin-left: 5px; text-transform: uppercase;"><?php echo $user_name?></label>
																									</div>
																									<div style="text-align: left; margin-bottom: 10px;">
																										<label style="margin-left: 5px; text-transform: uppercase;"><?php echo $user_address?></label>
																									</div>
																									<div style="text-align: left; margin-bottom: 10px;">
																										<label style="margin-left: 5px;"><?php echo $user_phone?></label>
																									</div>
																									<div style="text-align: left; margin-bottom: 10px;">
																										<label style="margin-left: 5px;"><?php echo $user_email?></label>
																									</div>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td>
														<table style="width: 500px;
														background-image: -webkit-linear-gradient(285deg, rgba(194, 233, 221, 0.5) 3%, rgba(104, 119, 132, 0.5) 100%);
  														background-image: linear-gradient(165deg, rgba(194, 233, 221, 0.5) 3%, rgba(104, 119, 132, 0.5) 100%);">
															<tbody>
																<tr>
																	<td>
																		<h1><strong>DELIVERED IN</strong></h1>
																		  <div class="countdown" id="js-countdown">
																		    <div class="countdown__item countdown__item--large">
																		      <div class="countdown__timer js-countdown-days" aria-labelledby="day-countdown">
																		        
																		      </div>
																		      
																		      <div class="countdown__label" id="day-countdown">Days</div>
																		    </div>
																		    
																		    <div class="countdown__item">
																		      <div class="countdown__timer js-countdown-hours" aria-labelledby="hour-countdown">
																		        
																		      </div>
																		      
																		      <div class="countdown__label" id="hour-countdown">Hours</div>
																		    </div>
																		    
																		    <div class="countdown__item">
																		      <div class="countdown__timer js-countdown-minutes" aria-labelledby="minute-countdown">
																		        
																		      </div>
																		      
																		      <div class="countdown__label" id="minute-countdown">Minutes</div>
																		    </div>
																		    
																		    <div class="countdown__item">
																		      <div class="countdown__timer js-countdown-seconds" aria-labelledby="second-countdown">
																		        
																		      </div>
																		      
																		      <div class="countdown__label" id="second-countdown">Seconds</div>
																		    </div>
																		  </div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
										<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
										  <div id="tbl-header">
												<table cellpadding="0" cellspacing="0" border="0">
													<thead>
														<tr>
															<th>ORDER ITEM</th>
															<th>SHIPPING ADDRESS</th>
															<th>SHIPPING CHARGE</th>
															<th>COMMENTS</th>
															<th>CONTACT VEHICLE</th>
															<th>OTHER OPTIONS</th>		
														</tr>
													</thead>
												</table>
											</div>
										  <div id="tbl-content" style="height: 200px;">
										  	<form action="map.php" method="post">
											    <table cellpadding="0" cellspacing="0" border="0">
											      <tbody>
											      	<input type="hidden" id="truckid" name="truckid">
											        <?php foreach($customerinfo as $info):?>
											        	<script type="text/javascript">
											        		document.getElementById('orderno').innerHTML = '<?= $info['ORD_NUM'];?>';
															document.getElementById('orderitem1').innerHTML = '<?= $info['PROD_DESCR'];?>';
															document.getElementById('orderdate').innerHTML = '<?= $info['PROD_REQ_DATE'];?>';
															document.getElementById('orderexpecteddate').innerHTML = '<?= $info['PROD_EXP_DATE'];?>';
															document.getElementById('orderstatus').innerHTML = '<?= $info['PROD_STATUS'];?>';
															document.getElementById('orderassignedto').innerHTML = '<?= $info['ASSIGNED_DRIVER'];?>';
											        	</script>
											        	<input type="hidden" id="test" name="test" value="<?= $info['PROD_EXP_DATE'];?>">
														<tr>
															<td><?= $info['ORD_NUM'];?></td>
															<td><?= $info['SHIPPING_ADDRESS'];?></td>
															<td>R 150.00</td>
															<td style="text-align: justify;"><?= $info['COMMENTS'];?></td>
															<td><input type="submit" value="LOCATE"
																		style="width: 100px;" 
																		onclick="
																			document.getElementById('truckid').value='<?= $info['VEH_CODE'];?>';
																		">
															</td>
															<td style="width: 175px;"><input type="button" value="VIEW FULL DETAILS" 
																onclick="
																setNewData('<?= $info['ORD_NUM'];?>', '<?= $info['PROD_DESCR'];?>', '<?= $info['PROD_REQ_DATE'];?>', '<?= $info['PROD_STATUS'];?>', '<?= $info['ASSIGNED_DRIVER'];?>','<?= $info['PROD_EXP_DATE'];?>');" style="width: 150px;
																">
															</td>
														</tr>
													<?php endforeach;?>
											      </tbody>
											    </table>
											</form>
										  </div>
										</section>	
									</td>
								</tr>
							</tbody>
						</table>
	  				</td>
					<td id="dashboard-panel" style="width: 100%; margin-top: 0px; vertical-align: top; background-color: whitesmoke; height: 556px;">
						<table style="margin-left: 10px;">
							<tbody>
								<tr>
									<div id="dashboard" style="width: 100%; height: 50px; border-bottom: 1.5px solid grey; line-height: 50px; margin-bottom: 10px; ">
										<a style="color: grey; font-size: 20px; text-decoration: none; margin-right: 55%; margin-left: 10px;">USER DASHBOARD</a>

										<label style="position: absolute; font-size: 14px; color: lightgrey; display: inline; line-height: 40px;">DRIVER
											<p style="color: lightblue; font-size: 16px; text-transform:capitalize; text-align: center; line-height: 0px;">5</p>
										</label>

										<a style="padding-left: 80px; padding-top: 15px; padding-bottom: 10px; text-decoration: none; border-right: 1px dotted grey;"></a>

										<label style="position: absolute; font-size: 14px; color: lightgrey; display: inline; line-height: 40px; margin-left: 30px">VEHICLE
											<p style="color: green; font-size: 16px; text-transform:capitalize; text-align: center; line-height: 0px;">5</p>
										</label>

										<a style="padding-left: 120px; padding-top: 15px; padding-bottom: 10px; text-decoration: none; border-right: 1px dotted grey;"></a>

										<label style="position: absolute; font-size: 14px; color: lightgrey; display: inline; line-height: 40px; margin-left: 30px;">DELIVERY
											<p style="color: red; font-size: 16px; text-transform:capitalize; text-align: center; line-height: 0px;">5</p>
										</label>
									</div>
								</tr>
								<tr>
									<td id="dashboard_calendar" style="vertical-align: top;">
									<table>
										<tbody>
											<tr>
												<td style="vertical-align: top; margin-top: 10px;" id="dashboard_notice">
													<table>
														<tbody>
															<tr>
																<td>
																	<div id="noticeboard_header" style="border-top: 1px solid lightgrey;border: 1px solid lightgrey;height: 30px;s">
																		<a href="" style="line-height: 30px; font-size: 13.3333px; font-weight: bold;">
																			DAILY NOTIFICATIONS
																		</a>
																	</div>
																</td>
															</tr>
															<tr>
																<td>
																	<div id="noticeboard_content" style="height: 440px; width: 745px;border: 1px solid lightgrey;border-top: none; background-color: whitesmoke; overflow-y: auto;font-size: 13.333px; font-family: Arial;">
																		<?php foreach($noticeinfo as $info):?>
																			<p style="font-size: 16.3333px; font-weight: bold;"><?= $info['TITLE'];?>
																				<label style="border-top: 1px solid grey; width: 96%; line-height: 50px; font-size: 13.3333px; font-weight: normal;"><?= $info['DESCRIPTION'];?>. The event will take trace from <?= $info['STARTDATE'];?><?= $info['ENDDATE'];?></label></br>
																				<label style="background: white; color: grey; margin-left: 78%; width: 150px; font-size: 13.3333px;"><?= $info['POSTDATE'];?></label></label>
																			</p></br>
																		<?php endforeach;?>		 
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
												<td>
													<html ng-app="myApp" ng-controller="AppCtrl" lang="en">
													    <head>
													      	<meta charset="utf-8">
													      	<title>Circle</title>
													    </head>
													    <div class="calendarholder" style="margin-top: -10px;">
													    	<div calendar class="calendar" id="calendar"></div>
													    </div>
													</html>
													<script src='https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.8/angular.min.js'></script>
													<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
													<script src="js/noncalendarfunctionindex.js"></script>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
	  						</tr>
						</tbody>
					</table>		
	  			</tr>
	  		</tbody>
	  	</table>
	</div>

	<script>
		function dashboard_display() {
			document.getElementById('dashboard_calendar').style.display = 'block';
			document.getElementById('dashboard-panel').style.display = 'block';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';
		}

		function ordermanagement_display() {
			document.getElementById('customerdata-td').style.display = 'block';
			document.getElementById('delivery-edit-div').style.display = 'block';
			document.getElementById('customer-edit-div').style.display = 'none'; 								
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('profile-td').style.display = 'none';	
		}

		function profilemanagement_display() {
			document.getElementById('profile-td').style.display = 'block';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('dashboard-panel').style.display = 'none';
		}

		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}

		function setNewData(receive_orderno, receive_orderitem,receive_orderdate, receive_orderstatus, receive_orderassignedto, receive_orderexpected) {
			document.getElementById('orderno').innerHTML = receive_orderno;
			document.getElementById('orderitem1').innerHTML = receive_orderitem;
			document.getElementById('orderdate').innerHTML = receive_orderdate;
			document.getElementById('orderexpecteddate').innerHTML = receive_orderexpected;
			document.getElementById('orderstatus').innerHTML = receive_orderstatus;
			document.getElementById('orderassignedto').innerHTML = receive_orderassignedto;

			initClock(receive_orderexpected);
		}
		function funChangeProfile() {
			var email = document.getElementById('profileemail').value;
			var oldpassword = document.getElementById('profileoldpassword').value;
			var newpassword = document.getElementById('profilenewpassword').value;
			var confirmpassword = document.getElementById('profileconfirmpassword').value;

			var dataString = 'customeremail='+email+'&oldpassword='+oldpassword+'&newpassword='+newpassword;
			if(email==''||oldpassword==''||newpassword==''||confirmpassword=='') {
				alert('Please fill in all fields then try again...');
			} else if(newpassword==confirmpassword) {
				$.ajax({
					type: 'POST',
					url: 'updatepassword.php',
					data: dataString,
					cache: false,
					success: function(result) {
						alert('Password is successfully changed.');
					}
				});
			} else {
				document.getElementById('profilenewpassword').value='';
				document.getElementById('profileconfirmpassword').value='';
				alert('Passwords does not match. Please try again...');
				$('#profilenewpassword').focus();
			}
		}

		function funChangePassword() {
			var email = document.getElementById('profileemail').value;
			var oldpassword = document.getElementById('profileoldpassword').value;
			var newpassword = document.getElementById('profilenewpassword').value;
			var confirmpassword = document.getElementById('profileconfirmpassword').value;

			var dataString = 'customeremail='+email+'&oldpassword='+oldpassword+'&newpassword='+newpassword;
			if(email==''||oldpassword==''||newpassword==''||confirmpassword=='') {
				alert('Please fill in all fields then try again...');
			} else if(newpassword==confirmpassword) {
				$.ajax({
					type: 'POST',
					url: 'updatepassword.php',
					data: dataString,
					cache: true,
					success: function(result) {
						alert('Password is successfully changed.');
					}
				});
			} else {
				document.getElementById('profilenewpassword').value='';
				document.getElementById('profileconfirmpassword').value='';
				alert('Passwords does not match. Please try again...');
				$('#profilenewpassword').focus();
			}
		}
	</script>
	<script src="js/calendar_index.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="js/jquery.popup.js"></script>
	<script type="text/javascript" src="js/timer_index.js"></script>
	<script type="text/javascript">
	    $(function() {
	      $(".js__p_start").simplePopup();
	    });
	</script>
</body>
<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
</footer>
</html>
