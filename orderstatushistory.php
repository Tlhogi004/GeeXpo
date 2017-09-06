<?php
	$hostname = "localhost";
	$username = "root";
	$password = "tl004";
	$databaseName = "britehousedeliverymanagement";

	$connect = mysqli_connect($hostname, $username, $password, $databaseName);
	$query = "SELECT transportation.TRANS_CODE, transportation.TRANS_TYPE, transportation.TRANS_TYPEPACK FROM britehousedeliverymanagement.transportation";
	$result1 = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Order Status And History | BriteHouse</title>
	
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
		<form action="registercustomer.php" method="get" id="signup-form">
		  <h2>LOGIN TO MY ACCOUNT</h2>
			<table>
				<tbody>
					<tr>
						<p><label for="fistname" class="floatLabel">USERNAME</label><input id="username" name="username" type="text"></p>
					</tr>

					<tr>
						<p><label for="password" class="floatLabel">PASSWORD</label><input id="password" name="password" type="password"></p>
					</tr>
				</tbody>
			</table>
			
			<p>
				<input type="submit" value="Login To My Account" id="submit" onclick="insert_customer();">
			</p>
		</form>
	</div>

	<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
	</footer>
</body>
</html>