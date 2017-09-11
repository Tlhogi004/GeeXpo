<?php
	$hostname = "localhost";
	$username = "root";
	$password = "tl004";
	$databaseName = "britehousedeliverymanagement";

	$truckid = 0;
	$connect = mysqli_connect($hostname, $username, $password, $databaseName);
	$query1 = "SELECT package.PACK_CODE, package.PACK_DESCR, transportation.TRANS_TYPE, transportation.TRANS_CODE 
				FROM britehousedeliverymanagement.transportation
				INNER JOIN britehousedeliverymanagement.delivery ON delivery.TRANS_CODE = transportation.TRANS_CODE
				INNER JOIN britehousedeliverymanagement.package ON package.DEL_CODE = delivery.DEL_CODE;";
	$result1 = mysqli_query($connect, $query1);

	$query2 = "SELECT * FROM britehousedeliverymanagement.LOCATION WHERE LOCATION.TRANS_CODE = " .$truckid;
	$result2 = mysqli_query($connect, $query2);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Map | BriteHouse</title>
	
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
						<td><input type="button" value="REGISTER" onclick="" style="background-color: grey; color: white; border-color: grey; border-radius: 3px;"></td>
						<td><input type="button" value="?" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 50px;"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="image-src">
			<table>
				<tbody>
					<tr>
						<td>
							<table>
								<tbody>
									<tr>
										<img src="Images/britehouse_icon.png" alt="britehouse_icon">
									</tr>
								</tbody>
							</table>	
						</td>
						<td style="width: 800px">
							<div id="map2"></div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</header>
</head>
<body>
	<div id="lightblue-bar"></div>
	<div id="map"></div>

	<script>
		var map, infoWindow;
		var carLatitude;
		var carLongitude;

		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}

		function calcCoordinates(carid) {
			carLatitude = -26.73352;
			carLongitude = 27.09118;
			initMap();
		}

		function initMap() {
	        map = new google.maps.Map(document.getElementById('map'), {
	          center: {lat: -4.397, lng: 150.644},
	          zoom: 20
	        });
	        infoWindow = new google.maps.InfoWindow;

	        // Try HTML5 geolocation.
	        if (navigator.geolocation) {
	          navigator.geolocation.getCurrentPosition(function(position) {
	            var pos = {
	              lat: -26.73352,
	              lng: 27.09118
	            };

	            infoWindow.setPosition(pos);
	            infoWindow.setContent('Location found.');
	            infoWindow.open(map);
	            map.setCenter(pos);
	          }, function() {
	            handleLocationError(true, infoWindow, map.getCenter());
	          });
	        } else {
	          // Browser doesn't support Geolocation
	          handleLocationError(false, infoWindow, map.getCenter());
	        }
	      }

	      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	        infoWindow.setPosition(pos);
	        infoWindow.setContent(browserHasGeolocation ?
	                              'Error: The Geolocation service failed.' :
	                              'Error: Your browser doesn\'t support geolocation.');
	        infoWindow.open(map);
	      }
	</script>
	<script async defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnlqOKVtgRfM3HEbT68NAsFn2HDJj5Vbg&callback=initMap">
    </script>

	<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
	</footer>
</body>
</html>