<?php
$usr=$_POST["uname"];
$pas=$_POST["pass"];
?>
<html>
	<head>
		<title>Flight Reservation System</title>
		<style>
div.Heading {
	text-align: center;
	position: center;
}

div.Login {
	background-size: auto;
	font-size: 20px;
	width: auto;
	height: auto;
	padding: 10px;
	margin-top:8px ;
	margin-left:37%;
	margin-right:37%;
	border: 1px solid black;
	display: inline-block;
	box-sizing: border-box;
}
div.Submit {
	text-align: center;
	color: white;
	font-size: 15px;
	background-color: royalblue;
	padding: 5px;
	margin: 8px 0;
	display: inline-block;
	border: none;
	box-sizing: border-box;
	cursor: pointer;
	width: 100%;
}
div.Remember {
	font-size: 18px;
}
div.Register {
	font-size: 16px;
	text-align: right;
}

		</style>
	</head>
	<body style="background-color:antiquewhite">
		<div class="Heading">
		<img src="logo4.jpg">
		<h3>Leviatate and Elevate</h3>
		</div>
		<div class="Login">
		<form method="post" action="<?php echo $PHP_SELF;?>">
			<b>Login Id(Email):</b><br><input type="text" placeholder="Enter username" size=30 name="uname" required/>
			<br>
			<b>Password:</b><br><input type="password" placeholder="Enter password" size=30 name="pass" required/>
			<br>
		<div class="Submit">
			<input type="submit" value="Login"/>
			<br>
		</div>
		<div class="Remember">
			<input type="checkbox" name="Remember me" value="on">Remember me
		</div>
		</form>
		<div class="Register">
		<a href="http://127.0.0.1:8080/forgot.html">Forgot password?</a>
		<br/>
		<a href="http://127.0.0.1:8080/register.html">New User? Create account</a>
		</div>
		</div>
<?php
//Using SimpleXml module to acess the xml file into a php object
$xml = simplexml_load_file('/home/ibab/Applications/Project/XMLs/UserInfo.xml');
$list=$xml->user;
for($i=0; $i<count($list); $i++)
{
	//Acessing the password from xml w.r.t to user names, so as to validate the login
	$temp_usr=$list[$i]->Id;
	$temp_pass=$list[$i]->Password;
	if($temp_usr==$usr)
                {
                        if($temp_pass==$pas)
			{
                                echo("<meta http-equiv = 'refresh' content='0; url=http://127.0.0.1:8080/home.html'/>");
                        }
			else 
			{
				echo("</br>");
                                echo("<br/><div style='color:red;text-align:center; font-size:17px'><b><u>Check your password and try again</u></b></div>");
                        }
                }
}
?>
	</body>
</html>
