<?php
	session_start();
	$user = $_SESSION['login_user'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home | BriteHouse</title>
	
	<!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" /> -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<header>
		<div id="top-div">
			<select id="mylist" onchange="favlang()" style="color: black; height: 18.8px; width: 67.6px; margin-left: 50px; font-size: 13.3333; font-family: Arial; margin: 0.5px;">
				<option>English</option>
			</select>

			<input type="text" placeholder="SEARCH" style="border-radius: 10px;">
		</div>

		<div id="green-bar"></div>
		<div id="exception" style="display: none;">
			<div id="message" style="background-color: red; width: 200px; text-align: center; margin-left: 65.5%; height: 30px;">
				<label style="color: black;">Invalid login</label>
			</div>
			<div id="message-body" style="background-color: darkorange; width: 200px; text-align: center; margin-left: 65.5%; height: 30px;">
				<label style="color: black;">Please enter correct email and password!</label>
			</div>
		</div>
		<div id="log-bar">
			<form onsubmit="return validatePasswords(this);" action="login.php" method="post">
				<table>
				<tbody>
					<tr>
						<td>Username:</td><td><input type="text" name="txtusername" id="txtusername"></td>
						<td>Password:</td><td><input type="password" name="txtpassword" id="txtpassword"></td>
						<td><input type="submit" value="LOGIN" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 3px;"></td>
						<td><input type="button" value="?" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 50px;"></td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>

		<div id="image-src">
			<img src="Images/britehouse_icon.png" alt="britehouse_icon">
		</div>
	</header>
	<a href="register.html" id="registerpage" name="registerpage"></a>
	<script type="text/javascript">
		function favlang() {
			var mylist=document.getElementById("mylist");
			document.getElementById("favorite").value=mylist.options(mylist.selectedIndex).text;

		}
	</script>
</head>
<body>
	<div id="lightblue-bar"></div>

	<div id="body-nav" style="z-index: 5000;">
		<ul>
			<li><a href="index.html">HOME</a></li>
			<li><a href="about.html">ABOUT</a></li>
			<li><a href="#">ORDER CENTER</a>
				<ul>
					<li><a href="orderentry.html">ORDER ENTRY</a></li>
					<li><a href="orderstatushistory.php">ORDER STATUS AND HISTORY</a></li>
					<li><a href="productsearch.html">PRODUCT SEARCH</a></li>
				</ul>
			</li>
			<li><a href="#">FORUMS</a></li>
			<li><a href="contacts.html">CONTACT US</a></li>
			<li><a href="updates.html">UPDATES</a></li>
		</ul>
	</div>

	<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin: 0 auto; width: 90%; height: 500px; z-index: 500; position: relative; margin-top: 40px;"> 
		  <!-- Indicators -->
		  
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner">
		    <div class="item active"> <img src="images/slide/flowers-chest-womens-girls-tattoos-sexy-girls-rib_25252Btattoo000" style="width:100%; height:500px;" data-src="" alt="First slide">
		      <div class="container">
		        <div class="carousel-caption">
		          <p>Aenean a rutrum nulla. Vestibulum a arcu at nisi tristique pretium.</p>
		          <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
		        </div>
		      </div>
		    </div>
		    <div class="item"> <img src="images/slide/feather-tattoo-designs-for-womens-back" style="width:100%; height:500px;" data-src="" alt="Second    slide">
		      <div class="container">
		        <div class="carousel-caption">
		          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae egestas purus. </p>
		          <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
		        </div>
		      </div>
		    </div>
		    <div class="item"> <img src="images/slide/feminine-floral-tattoo-vine-flower-stylized-curls-swirls-pretty-design-for-gilrs-women-chest-cleavage-tat000" style="width:100%; height: 500px" data-src="" alt="Third slide">
		      <div class="container">
		        <div class="carousel-caption">
		          <p>Donec sit amet mi imperdiet mauris viverra accumsan ut at libero.</p>
		          <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
		        </div>
		      </div>
		    </div>
		  </div>
		  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a> </div>
			<script>
			    function validatePasswords(form) {
			        if (form.txtusername.value == '' || form.txtpassword.value == '') {
			            document.getElementById('exception').style.display = 'block';
			            return false;
			        } 
			        return true;
			    }
			 
			</script>

	<footer>
		<div id="bottom">
			Britehouse Inc. &copy; Copyright 2017 | Terms and Conditions Apply
		</div>
	</footer>
</body>
</html>