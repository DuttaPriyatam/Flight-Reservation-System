<html>
<head>
<title>Your Bookings Page</title>
<style>
div.logo{
        position:center;
        text-align:center;
}
div.menu{
        margin: 0;
        overflow: hidden;
        background-color: #1B1C75;
        padding:10px 10px;
}
div.menu a{
        float: auto;
        color: white;
        text-align: center;
        padding: 30px 30px;;
        font-size: 17px;
}
div.menu a:hover{
        background-color: snow;
        color: black;
}
div.menu a:active{
        background-color: springgreen;
        color: white;
}
</style>
</head>
<body style="background-color:antiquewhite">
<div class="logo">
                        <img src="logo4.jpg">
                        <h3>Levitate and Elevate<h3>
                </div>
<div class="menu">
                        <a class="active" href="http://127.0.0.1:8080/home.html">Home</a>
                        <a href="#profile">Profile</a>
                        <a href="http://127.0.0.1/Your_Bookings.php">Booking Information</a>
                        <a href="http://127.0.0.1/cancel.php">Booking Cancellation</a>
                        <a href="http://127.0.0.1/seatupgrade.php">Seat Upgradation</a>
                        <a href="#contact">Contact</a>
                        <a href="#aoutus">About us</a>
                </div>
</br>
<form style="text-align: center; display: block" method="post" action="<?php echo $_PHP_SELF;?>">
Enter Booking ID: <input type="text" minlength="6" maxlength="6" name="id"/>
</br>
</br>
<input type="checkbox" name="check" value="on" required>I have read and agree to the <a href="#cancel_terms_and_conditions">terms and conditions.</a>
</br>
</br>
<input type="submit" value="Cancel">
</br>
</form>
<?php 
$keep=0;
//Getting the parameter from the form
$id=$_POST["id"];
//Loading the xml onto an object
$xml=simplexml_load_file("/home/ibab/Applications/Project/XMLs/booking_details.xml");
$list=$xml->booking;
for($i=0; $i<count($list);$i++)
{
	//Searching for status w.r.t to booking id 
        $bid_temp=$list[$i]->id;
        $stat=$list[$i]->status;
        if($id == $bid_temp)
	{
		//Changing the status of the booking
                $change=$xml->xpath("/user/booking[id = '".$id."']");
		$change[0]->status="Cancelled";
		$dom= new DOMDocument('1.0');
		$dom->preserveWhiteSpace=false;
		$dom->formatOutput=true;
		$dom->loadXml($xml->asXML());
		$dom->save("/home/ibab/Applications/Project/XMLs/booking_details.xml");
		echo("</br>");
		echo("Successfully cancelled. Click <a href='http://127.0.0.1/Your_Bookings.php'>here</a> to be redicted to your Booking Information Page."); 
                break;
        }
}
?>
</body>
</html> 

