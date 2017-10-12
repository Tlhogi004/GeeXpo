<?php
	require_once __DIR__ . '/db_config.php';

	$location_latitude = '0';
	$location_longitude = '0';

	if($_SERVER["REQUEST_METHOD"] == "POST") {
	    // username and password sent from form

	    $truckid =  mysqli_real_escape_string($conn,$_POST['truckid']);
	    $defaultlocation = 'loggedinadmin.php';

	    $sql = "SELECT LOCATION.LOC_LATITUDE, LOCATION.LOC_LONGITUDE FROM LOCATION WHERE LOCATION.LOC_ID = '$truckid'";

	    $result = mysqli_query($conn,$sql);
	    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	    $count = mysqli_num_rows($result);

	    $result1 = $conn->query($sql);

	    if ($result1->num_rows > 0) {
	        // output data of each row
	        while($row = $result1->fetch_assoc()) {
	            $location_latitude = $row["LOC_LATITUDE"];
            	$location_longitude = $row["LOC_LONGITUDE"];
	        }
	        session_start();      
	    }
	}
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

		<div id="log-bar"></div>

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
	<div id="map" style="height: 550px; color: black; font-size: 13.3333; font-style: Arial; font-family: Arial;"></div>

	<script>
		var map, infoWindow;
		var carLatitude;
		var carLongitude;

		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}

		function calcCoordinates() {
			carLatitude = <?php echo htmlentities($location_latitude)?>;
			carLongitude = <?php echo htmlentities($location_longitude)?>;
			initMap();
		}

		calcCoordinates();

		function initMap() {
	        map = new google.maps.Map(document.getElementById('map'), {
	          center: {lat: -4.397, lng: 150.644},
	          zoom: 15
	        });
	        infoWindow = new google.maps.InfoWindow;

	        // Try HTML5 geolocation.
	        if (navigator.geolocation) {
	        	var timeoutVal = 10 * 1000 * 1000;
	          navigator.geolocation.getCurrentPosition(function(position) {
	            var pos = {
	              lat: carLatitude,
	              lng: carLongitude
	            };

	            infoWindow.setPosition(pos);
	            infoWindow.setContent("<?php echo htmlentities($truckid)?>");
	            infoWindow.open(map);
	            map.setCenter(pos);
	          }, function() {
	            handleLocationError(true, infoWindow, map.getCenter());
	          }, {enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0});
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