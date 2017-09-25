<?php
	require_once __DIR__ . '/db_config.php';
	
	session_start();
	$user = "ldmolwana2@gmail.com";

	$query1 = "SELECT CONCAT(CUSTOMER.CUST_FNAME,', ',CUSTOMER.CUST_LNAME), CUSTOMER.CUST_ADDRESS, CUSTOMER.CUST_PHONE 
				FROM britehousedeliverymanagement.CUSTOMER 
				WHERE CUSTOMER.CUST_EMAIL='$user'";
	$query4 = "CALL select_delivery()";
	$result1 = mysqli_query($conn, $query1);
	$result5 = mysqli_query($conn, $query4);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Order Status And History | BriteHouse</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="css/timer_style.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

	<header>
		<div id="top-div">
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
						<td><input type="submit" value="LOGIN" onclick="login()" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 3px;"></td>
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

	<script>
		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}

		function login() {
			alert("txtusername");
		}

		function savecustomer() {
			var xmlhttp;
			xmlhttp=XMLHttpRequest();
			xmlhttp.open("GET", "registercustomer.php?fname="+document.getElementById("firstname").value+"&lname="+document.getElementById("lastname").value+"&phoneno="+document.getElementById("phonenumber").value+"&email="+document.getElementById("email").value+"&pcode="+document.getElementById("postalcode").value+"&street="+document.getElementById("street").value+"&province="+document.getElementById("province").value+"&country="+document.getElementById("country").value, false);
			xmlhttp.send(null);
		}
	</script>
</head>
<body>
	<div id="lightblue-bar"></div>
	<div id="map">  
		<table>
			<tbody>
				<tr>
					<td style="width: 50%;">
						<div style="width: 100%; background-color: lightgrey; height: 40px; margin-bottom: 10px; border: 0.5px solid lightgrey;">
							<strong style="font-size: 13.3333px; font-family: Arial; font-weight: 500; line-height: 40px;">ORDER</strong>
						</div>
						<div style="width: 100%; background-color: lightgrey; height: 40px; border: 0.5px solid lightgrey;">
							<strong style="font-size: 13.3333px; font-family: Arial; font-weight: 500; line-height: 40px;">ORDER INFORMATION</strong>
						</div>
						<div style="width: 100%; background-color: whitesmoke; height: 100px; margin-bottom: 10px; border: 0.5px solid whitesmoke;">
							<table>
								<tbody>
									<tr>
										<td>
											<table>
												<tbody>
													<tr>
														<td>
															<table>
																<tbody>
																	<div style="text-align: right; margin-bottom: 10px; margin-top: 10px;"><label>ORDER NO:</label></div>
																	<div style="text-align: right; margin-bottom: 10px;"><label>ORDER DATE:</label></div>
																	<div style="text-align: right; margin-bottom: 10px;"><label>ORDER STATUS:</label></div>
																	<div style="text-align: right; margin-bottom: 10px;"><label>ASSIGNED TO:</label></div>
																</tbody>
															</table>
														</td>
														<td>
															<table style="margin-left: 10px;">
																<tbody>
																	<div style="text-align: left; margin-bottom: 10px;">
																		<label style="margin-left: 5px;">ORD#101701</label>
																	</div>
																	<div style="text-align: left; margin-bottom: 10px;">
																		<label style="margin-left: 5px;">2017-09-19 14:05</label>
																	</div>
																	<div style="text-align: left; margin-bottom: 10px;">
																		<label style="margin-left: 5px;">ASSEMBLING</label>
																	</div>
																	<div style="text-align: left; margin-bottom: 10px;">
																		<?php if($row1 = mysqli_fetch_array($result5)):;?>
																		<label style="margin-left: 5px;"><?php echo $row1[7];?></label>
																		<?php endif;?>
																	</div>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
										<td>
											<table style="margin-left: 50%; width: 100%;">
												<tbody>
													<tr>
														<td>
															<table>
																<tbody style="margin-top: 5px; margin-bottom: 5px;">
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
																		<?php if($row1 = mysqli_fetch_array($result1)):;?>
																			<div style="text-align: left; margin-bottom: 10px;">
																				<label style="margin-left: 5px; text-transform: uppercase;"><?php echo $row1[0];?></label>
																			</div>
																			<div style="text-align: left; margin-bottom: 10px;">
																				<label style="margin-left: 5px; text-transform: uppercase;"><?php echo $row1[1];?></label>
																			</div>
																			<div style="text-align: left; margin-bottom: 10px;">
																				<label style="margin-left: 5px;"><?php echo $row1[2];?></label>
																			</div>
																		<?php endif;?>
																		<div style="text-align: left; margin-bottom: 10px;">
																			<label style="margin-left: 5px;">ldmolwana@gmail.com</label>
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
						</div>
							<section style="background: -webkit-linear-gradient(left, #25c481, #25b7c4);background: linear-gradient(to right, #25c481, #25b7c4);">
							  <!--for demo wrap-->
							  <div id="tbl-header">
									<table cellpadding="0" cellspacing="0" border="0">
										<thead>
											<tr>
												<th>ORDER ITEM</th>
												<th>ORDER QTY</th>
												<th>SHIPPING CHARGE</th>
												<th>CONTACT VEHICLE</th>
												<th></th>		
											</tr>
										</thead>
									</table>
								</div>
							  <div id="tbl-content" style="height: 272px;">
							    <table cellpadding="0" cellspacing="0" border="0">
							      <tbody>
							        <?php while($row1 = mysqli_fetch_array($result5)):;?>
										<tr>
											<td><?php echo $row1[0];?></td>
											<td><?php echo $row1[2];?></td>
											<td>R 150.00</td>
											<td><?php echo $row1[6];?></td>
											<td><input type="submit" value="VIEW DETAILS" style="width: 100px;"></td>
										</tr>
									<?php endwhile;?>
							      </tbody>
							    </table>
							  </div>
							</section>	
					</td>
					<td>
						<h1><strong>ORDER DELIVERED IN</strong></h1>

					  	<div class="countdown">
					    <div class="bloc-time hours" data-init-value="24">
					      <span class="count-title">Hours</span>

					      <div class="figure hours hours-1">
					        <span class="top">2</span>
					        <span class="top-back">
					          <span>2</span>
					        </span>
					        <span class="bottom">2</span>
					        <span class="bottom-back">
					          <span>2</span>
					        </span>
					      </div>

					      <div class="figure hours hours-2">
					        <span class="top">4</span>
					        <span class="top-back">
					          <span>4</span>
					        </span>
					        <span class="bottom">4</span>
					        <span class="bottom-back">
					          <span>4</span>
					        </span>
					      </div>
					    </div>

					    <div class="bloc-time min" data-init-value="0">
					      <span class="count-title">Minutes</span>

					      <div class="figure min min-1">
					        <span class="top">0</span>
					        <span class="top-back">
					          <span>0</span>
					        </span>
					        <span class="bottom">0</span>
					        <span class="bottom-back">
					          <span>0</span>
					        </span>        
					      </div>

					      <div class="figure min min-2">
					       <span class="top">0</span>
					        <span class="top-back">
					          <span>0</span>
					        </span>
					        <span class="bottom">0</span>
					        <span class="bottom-back">
					          <span>0</span>
					        </span>
					      </div>
					    </div>

					    <div class="bloc-time sec" data-init-value="0">
					      <span class="count-title">Seconds</span>

					        <div class="figure sec sec-1">
					        <span class="top">0</span>
					        <span class="top-back">
					          <span>0</span>
					        </span>
					        <span class="bottom">0</span>
					        <span class="bottom-back">
					          <span>0</span>
					        </span>          
					      </div>

					      <div class="figure sec sec-2">
					        <span class="top">0</span>
					        <span class="top-back">
					          <span>0</span>
					        </span>
					        <span class="bottom">0</span>
					        <span class="bottom-back">
					          <span>0</span>
					        </span>
					      </div>
					    </div>
					</div>
					</td>
				</tr>
			</tbody>
		</table>
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js'></script>
		<script  src="js/timer_index.js"></script>
	</div>

	<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
	</footer>
</body>
</html>