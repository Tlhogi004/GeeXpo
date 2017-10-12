<?php
	session_start();
    $_SESSION['login_user'] = "loggedout";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home | BriteHouse</title>
	
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<header>
		<div id="top-div" style="color: black; height: 40px; width: 100px; font-size: 13.3333px;">
			<select id="mylist" onchange="favlang()" style="height: 25px;">
				<option>English</option>
				<option>Test</option>
			</select>

			<input type="text" placeholder="SEARCH" style="border-radius: 10px;">
		</div>

		<div id="green-bar"></div>
		<div id="exception" style="display: none;">
			<div id="message" style="background-color: red; width: 200px; text-align: center; margin-left: 65.5%;">
				<label style="color: black;">Invalid login</label>
			</div>
			<div id="message-body" style="background-color: darkorange; width: 200px; text-align: center; margin-left: 65.5%; height: 30px;">
				<label style="color: black;">Please enter correct email and password!</label>
			</div>
		</div>
		<div id="image-src" style="position: relative; display: block;">
			<img src="Images/britehouse_icon.png" alt="britehouse_icon">
		</div>
		<div id="body-nav" style="height: 80px;">
		<ul>
			<li><a href="">HOME</a></li>
			<li><a href="about.html">ABOUT</a></li>
			<li><a href="#">FORUMS</a></li>
			<li><a href="contactus.html">CONTACT US</a></li>
		</ul>
		<div id="log-bar" style="margin-left: 56%; color: black; vertical-align: top; width: 100px; font-size: 13.3333px;">
			<form onsubmit="return validatePasswords(this);" action="login.php" method="post">
				<table>
				<tbody>
					<tr>
						<td>Username:</td><td><input type="text" name="txtusername" id="txtusername" style="margin-left: 3px; margin-right: 3px;"></td>
						<td>Password:</td><td><input type="password" name="txtpassword" id="txtpassword" style="margin-left: 3px;"></td>
						<td><input type="submit" value="LOGIN" style="margin: 3px;width: 100px;"></td>
						<td><input type="button" value="?" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 50px; margin-left: 3px;"></td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
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
	<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin: 0 auto; width: 90%; height: 550px; z-index: 500; position: relative;"> 
		  <!-- Indicators -->
		  
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner">
		    <div class="item active"> <img src="images/slide/slide1" style="width:100%; height:550px;" data-src="" alt="First slide">
		      <div class="container">
		        <div class="carousel-caption">
		          <p></p>
		          <p><a class="btn btn-lg btn-primary" href="orderentry.html" role="button">PLACE ORDER</a></p>
		        </div>
		      </div>
		    </div>
		    <div class="item"> <img src="images/slide/slide3" style="width:100%; height:550px;" data-src="" alt="Second    slide">
		      <div class="container">
		        <div class="carousel-caption">
		          <p></p>
		          <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
		        </div>
		      </div>
		    </div>
		    <div class="item"> <img src="images/slide/slide2" style="width:100%; height: 550px" data-src="" alt="Third slide">
		      <div class="container">
		        <div class="carousel-caption">
		          <p></p>
		          <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
		        </div>
		      </div>
		    </div>
		  </div>
		  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a> </div>
		  <script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-36251023-1']);
			  _gaq.push(['_setDomainName', 'jqueryscript.net']);
			  _gaq.push(['_trackPageview']);

			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();

			</script>
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