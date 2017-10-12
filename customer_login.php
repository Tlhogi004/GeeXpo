<!DOCTYPE html>
<html >
<header>
  <meta charset="UTF-8">
  <title>Login | BriteHouse</title>
   	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
    <link rel="stylesheet" href="css/login_style.css">
    <link rel="stylesheet" href="css/style.css">

  	<div id="top-div" style="color: black; height: 40px; width: 100px; font-size: 13.3333px;">
			<select id="mylist" onchange="favlang()">
				<option>English</option>
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
		<div id="log-bar" style="margin-left: 59%; color: black; height: 30px; width: 100px; font-size: 13.3333px;">
			<form onsubmit="return validatePasswords(this);" action="customer_loggedin.php" method="post">
				<table>
					<tbody>
						<tr>
							<td>Username:</td><td><input type="text" name="txtusername" id="txtusername"></td>
							<td>Password:</td><td><input type="password" name="txtpassword" id="txtpassword"></td>
							<td><input type="submit" value="LOGIN" onclick="login()" style="background-color: darkblue; color: white; border-color: darkblue; border-radius: 3px;"></td>
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
	
<body>
	<div id="lightblue-bar"></div>

	<div id="body-nav" style="margin-top: 0;">
		<ul style="z-index: 6000">
			<li><a href="index.html">HOME</a></li>
			<li><a href="about.html">ABOUT</a></li>
			<li><a href="#">ORDER CENTER</a>
				<ul>
					<li><a href="#">ORDER ENTRY</a></li>
					<li><a href="#">ORDER STATUS AND HISTORY</a></li>
					<li><a href="productsearch.html">PRODUCT SEARCH</a></li>
				</ul>
			</li>
			<li><a href="#">FORUMS</a></li>
			<li><a href="#">CONTACT US</a></li>
		</ul>
	</div>

	<div id="body-middle-div">
		<div class="login-wrap">
			<div class="login-html">
				<input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
				<input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Recover Password</label>
				<div class="login-form">
					<form action="customer_loggedin.php" method="post">
						<div class="sign-in-htm">
							<div class="group">
								<label for="user" class="label">Username</label>
								<input id="username" name="username" type="text" class="input">
							</div>
							<div class="group">
								<label for="pass" class="label">Password</label>
								<input id="password" name="password" type="password" class="input" data-type="password">
							</div>
							<div class="group">
								<input type="submit" class="button" value="Sign In">
							</div>
							<div class="hr"></div>
						</div>
					</form>
					<div class="sign-up-htm">
						<div class="group">
							<label for="user" class="label">Username</label>
							<input id="user" type="text" class="input">
						</div>
						<div class="group">
							<label for="pass" class="label">Password</label>
							<input id="pass" type="password" class="input" data-type="password">
						</div>
						<div class="group">
							<label for="pass" class="label">Repeat Password</label>
							<input id="pass" type="password" class="input" data-type="password">
						</div>
						<div class="group">
							<label for="pass" class="label">Email Address</label>
							<input id="pass" type="text" class="input">
						</div>
						<div class="group">
							<input type="submit" class="button" value="Sign Up">
						</div>
						<div class="hr"></div>
						<div class="foot-lnk">
							<label for="tab-1">Already Member?</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/index.js"></script>
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
