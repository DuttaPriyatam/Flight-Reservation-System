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
        padding:10px 10px;;
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
                        <a href="http://127.0.0.1/cancel2.php">Booking Cancellation</a>
                        <a href="http://127.0.0.1/seatupgrade.php">Seat Upgradation</a>
                        <a href="#contact">Contact</a>
                        <a href="#aoutus">About us</a>
                </div>
</br>
<form style="text-align: center; display: block" method="post" action="<?php echo $_PHP_SELF;?>">
Enter Booking ID: <input type="text" minlength="6" maxlength="6" name="id"/>
</br>
</br>
<span style="color:red; text-align:center;">*Depends on avaialability</br>*Extra Rs. 100 would be charged as compared to the default price for First Class reservations(Total <i>Rs. 600</i>).</span>
</br>
</br>
<input type="checkbox" name="check" value="on" required>I have read and agree to the <a href="#cancel_terms_and_conditions">terms and conditions.</a>
</br>
</br>
<input type="submit" value="Upgrade">
</br>
</form>
<?php 
//Getting aprameter from the form
$id=$_POST["id"];
$xml=simplexml_load_file("/home/ibab/Applications/Project/XMLs/booking_details.xml");
$list=$xml->booking;
for($i=0; $i<count($list);$i++)
{
	//Accessing the seat type and trip type w.r.t booking id
	$bid_temp=$list[$i]->id;
	$triptp=$list[$i]->trip_type;
	$seattp=$list[$i]->seat_type;
	$total_str=$list[$i]->total;
	$total_num=(int)$total_str;
        if($id == $bid_temp)
	{
		if($seattp == "Economy")
		{
			//Accessing the object path and changing the seat type 
			$change=$xml->xpath("/user/booking[id = '".$id."']");
			//Making necessaty change in the amount depending on the trip type
			if($triptp=="One-way")
			{
				$new_total=$total_num + 600;
			}
			else
			{
				$new_total=$total_num + 1200;
			}
			$new_total_str=strval($new_total);
			$change[0]->total=$new_total_str;
			$change[0]->seat_type="First Class";
                	$dom= new DOMDocument('1.0');
                	$dom->preserveWhiteSpace=false;
			$dom->formatOutput=true;
			//Saving the newly formed xml file
                	$dom->loadXml($xml->asXML());
                	$dom->save("/home/ibab/Applications/Project/XMLs/booking_details.xml");
                	echo("</br>");
                	echo("Your seat has been successfully upgraded. Click <a href='http://127.0.0.1/Your_Bookings.php'>here</a> to be redicted to your Booking Information Page.");
			break;
		}
		else
		{
			echo("</br>");
			echo("Your reservation is already in First Class. There's no provision for upgradation.");
			break;
		}
        }
}
?>
</body>
</html> 

