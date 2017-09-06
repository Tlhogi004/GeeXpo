<?php
	$hostname = "localhost";
	$username = "root";
	$password = "tl004";
	$databaseName = "britehousedeliverymanagement";

	$connect = mysqli_connect($hostname, $username, $password, $databaseName);
	
	$query1 = "SELECT * FROM britehousedeliverymanagement.TRANSPORTATION";
	$query2 = "SELECT CUSTOMER.CUST_FNAME, CUSTOMER.CUST_LNAME, CUSTOMER.CUST_PHONE, CUSTOMER.CUST_EMAIL, CONCAT(CUSTOMER.CUST_STREET, ',', CUSTOMER.CUST_CITY, ',', CUSTOMER.CUST_PROVINCE) FROM britehousedeliverymanagement.CUSTOMER";
	$query3 = "SELECT * FROM britehousedeliverymanagement.DRIVER";
	
	$result1 = mysqli_query($connect, $query1);
	$result2 = mysqli_query($connect, $query2);
	$result3 = mysqli_query($connect, $query3);
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

	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css'>

      <link rel="stylesheet" href="css/style.css">

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
				<tbody>
					<tr>
						<td>Username:</td><td><input type="text" name="txtusername" id="txtusername"></td>
						<td>Password:</td><td><input type="password" name="txtpassword" id="txtpassword"></td>
						<td><input type="submit" value="LOGOUT" onclick="location.href='index.html';" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 3px;"></td>
						<td><input type="button" value="REGISTER" style="background-color: grey; color: white; border-color: grey; border-radius: 3px;"></td>
						<td><input type="button" value="?" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 50px;"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="image-src">
			<img src="Images/britehouse_icon.png" alt="britehouse_icon">
		</div>
	</header>
</head>

<body>
  	<head>
  		<script src="https://use.fontawesome.com/484df5253e.js"></script>
	</head>
	<div id="lightblue-bar"></div>
	<div id="side-left-panel">
		<table>
			<tbody>
				<tr>
					<td style="width: 10%; vertical-align: top; margin-top: 10.8px; background: #1A237E;">
						<table style="margin-left: 0px;">
							<tbody>
								<tr>
									<div id="side-bar-left" style="margin-top: 10.8px; margin-left: 1px; margin-right: 1px; text-decoration: none; width: 10%;">
										<ul>
											<!-- <img src="Images/britehouse_icon.png" alt="britehouse_icon"> -->
											<li style="border-top: 0.5px solid white;"><a href="#" onclick="dashboard_display();">DASHBOARD</a></li>
											<li style="border-top: 0.5px solid white;""><a href="#" onclick="customermanagement_display();">CUSTOMER MANGEMENT</a></li>
											<li style="border-top: 0.5px solid white;""><a href="#">PACKAGE MANGEMENT</a></li>
											<li style="border-top: 0.5px solid white;"><a href="#">SCHEDULE MANGEMENT</a></li>
											<li style="border-top: 0.5px solid white;"><a href="#">TRUCK MANGEMENT</a></li>
											<li style="border-top: 0.5px solid white;"><a href="map.php">TRACKING</a></li>
											<li style="border-top: 0.5px solid white;"><a href="#">SETTINGS</a></li>
											<li style="border-top: 0.5px solid white; border-bottom: 0.5px solid white;"><a href="#">PROFILE</a></li>
										</ul>
									</div>
								</tr>
							</tbody>
						</table>		
					</td>
					<td id="dashboard-panel" style="width: 100%; margin-top: 0px; vertical-align: top; background-color: whitesmoke; height: 556px;">
						<table>
							<tbody>
								<tr>
									<div id="dashboard" style="width: 100%; height: 50px; border-bottom: 1.5px solid grey; margin-top: 10px; margin-bottom: 10px;">
										<a style="color: grey; font-size: 20px; text-decoration: none; margin-right: 60%;">ADMIN DASHBOARD</a>
										<a style="padding: 10px; color: grey; font-size: 12px; text-decoration: none; margin-right: 0px; border-right: 1px dotted grey;">DRIVER</a>
										<a style="padding: 10px; color: grey; font-size: 12px; text-decoration: none; margin-right: 10px; border-right: 1px dotted grey;">VEHICLE</a>
										<a style="color: grey; font-size: 12px; text-decoration: none;">DELIVERY</a>
									</div>
								</tr>
								<tr>
									<td style="vertical-align: top; margin-top: 10px; margin-right: 10px; width: 500px;">
										<table>
										<tbody>
											<tr>
												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; border: 1px solid grey;">
												<li><a href="#" onclick="driver_display();" style="font-size: 12px; color: grey; text-decoration: none;">DRIVER</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 30px; border: 1px solid grey;">
												<li><a href='#'; onclick="truck_display();" style="font-size: 12px; color: grey; text-decoration: none;">TRUCK</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 30px; border: 1px solid grey;">
												<li><a href="#" onclick="delivery_display();" style="font-size: 12px; color: grey; text-decoration: none;">DELIVERY</a></li>
												</td>
											</tr>

											<tr>
												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; font-size: 0.9em; list-style: none; margin-left: 0px; margin-top: 30px; margin-right: 30px; border: 1px solid grey;">
												<li><a href="#" onclick="inventory_display();" style="font-size: 12px; color: grey; text-decoration: none; line-height: 80px;">INVENTORY</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-top: 30px; border: 1px solid grey;">
												<li><a href="#" style="font-size: 12px; color: grey; text-decoration: none;">OPERATION REPORT</a></li>
												</td>

												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 30px; margin-top: 30px; border: 1px solid grey;">
												<li><a href="#" style="font-size: 12px; color: grey; text-decoration: none;">SETTINGS</a></li>
												</td>
											</tr>

											<tr>
												<td style="text-align: center; float: left; width: 130px; height: 80px; background-color: white; line-height: 80px; font-size: 0.9em; list-style: none; margin-left: 0px; margin-top: 30px; border: 1px solid grey;">
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
																		<div style="height: 418px; width: 290px; border-top: none; border: 1px solid grey;"></div>
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
										  <h1>TRUCK INFORMATION</h1>
										  <div id="tbl-header">
												<table cellpadding="0" cellspacing="0" border="0">
													<thead>
														<tr>
															<th>TRUCK REG</th>
															<th>TRUCK TYPE</th>
															<th>LOAD CAPABILITY</th>
															<th>PACKAGE CAPABILITY</th>
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
														<td><?php echo $row1[6];?></td>
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
										  <h1>DRIVER INFORMATION</h1>
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

					<td id="signup-form-td" style="width: 80%;  display: none;">
						<form action="savevehicles.php" method="get" id="signup-form" style="margin-left: 0px; margin-top: 10px; width: 100%;">
						  <h2>VEHICLE REGISTRATION</h2>
							<table>
								<tbody>
									<tr>
										<td><p><label for="transportreg" class="floatLabel">TRANSPORT REG</label><input id="transportreg" name="transportreg" type="text"></p></td>
										<td><p><label for="transportreg" class="floatLabel">TRANSPORT TYPE</label><input id="transportype" name="transportype" type="text"></p></td>
										<td><p><label for="loadlimit" class="floatLabel">LOAD LIMIT</label><input id="loadlimit" name="loadlimit" type="text"></p></td>
									</tr>

									<tr>
										<td><p><label for="packagetype" class="floatLabel">PACKAGE TYPE</label><input id="packagetype" name="packagetype" type="text"></p></td>
										<td><p><label for="transportcost" class="floatLabel">TRANSPORT COST</label><input id="transportcost" name="transportcost" type="text"></p></td>
										<td><p><label for="depotrange" class="floatLabel">DEPOT RANGE</label><input id="depotrange" name="depotrange" type="text"></p></td>
									</tr>
								</tbody>
							</table>
							
							<p>
								<table>
									<tbody>
										<tr>
											<td style="width: 20%;"><input type="submit" value="CREATE" id="inserttransport"></td>
											<td style="width: 20%;"><input type="submit" value="MODIFY" id="inserttransport"></td>
											<td style="width: 20%;"><input type="submit" value="DELETE" id="inserttransport"></td>
										</tr>
									</tbody>
								</table>
							</p>
						</form>
					</td>

					<td id="customerdata-td" style="width: 100%; margin-top: 10.8px; vertical-align: top; display: none; background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4); margin-right: 5px;">
						<section>
						  <!--for demo wrap-->
						  <h1>CUSTOMER INFORMATION</h1>
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
										<td><?php echo $row1[3];?></td>
										<td><?php echo $row1[4];?></td>
										<td style="text-align: right;"><input type="submit" value="UPDATE" style="width: 100px;"></td>
										<td><input type="submit" value="DELETE" style="width: 100px;"></td>
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
			document.getElementById('signup-form-td').style.display = 'none';
			document.getElementById('customerdata-td').style.display = 'none';
			document.getElementById('truckdata_td').style.display= 'none';
			document.getElementById('driverdata_td').style.display= 'none';
		}

		function customermanagement_display() {
			document.getElementById('customerdata-td').style.display = 'block';
			document.getElementById('dashboard-panel').style.display = 'none';
			document.getElementById('signup-form-td').style.display = 'none';	
		}

		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}
	</script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  	<script src="js/index.js"></script>
	<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
	<script src='https://npmcdn.com/react@15.3.0/dist/react.min.js'></script>
	<script src='https://npmcdn.com/react-dom@15.3.0/dist/react-dom.min.js'></script>
	<script src="js/calendar_index.js"></script>

	  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src='https://npmcdn.com/react@15.3.0/dist/react.min.js'></script>
<script src='https://npmcdn.com/react-dom@15.3.0/dist/react-dom.min.js'></script>

    <script src="js/index.js"></script>
	<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
	</footer>
</body>
</html>
