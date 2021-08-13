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
	padding: 10px 10px;
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
table{
width:100%
}
caption{
background-color: indianred;
font-size: 20px;
padding: 3px 3px;
border: 1px solid black;
}
table, th, td{
border:1px solid black;
border-collapse: collapse;
}
th{
background-color:lightcoral;
}
tr:nth-child(even){
background-color:#DFA5DF;
}
tr:nth-child(odd){
background-color:#E9C1E9;
}
th,td{
text-align: center;
}
td{
margin: auto;
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


<?php
//To access today's date
$date=date('Y-m-d');
//Saving xml into php object
$xml=simplexml_load_file("/home/ibab/Applications/Project/XMLs/booking_details.xml");
$list=$xml->booking;
echo("<table>");
echo("</br>");
        echo("<caption><b>Bookings<b></caption>");
        echo("<tr>");
        echo("<th>Booking Id</th>");
        echo("<th>From</th>");
        echo("<th>To</th>");
        echo("<th>Date</th>");
        echo("<th>Airline</th>");
        echo("<th>Seat Type</th>");
        echo("<th>Seats</th>");
        echo("<th>Total</th>");
	echo("<th>Status</th>");
	echo("<th>Cancellation</th>");
	echo("<th>Seat Upgradation</th>");
	echo("</tr>");

//Iterator to access all the data present in the xml database
for($i=0; $i<count($list); $i++)
{
	$bid=$list[$i]->id;
	$from=$list[$i]->from;
	$to=$list[$i]->to;
	$departure=$list[$i]->departure;
	$return=$list[$i]->return;
	$airline=$list[$i]->airline;
	$seat_type=$list[$i]->seat_type;
	$seats=$list[$i]->seats;
	$trip_type=$list[$i]->trip_type;
	$total=$list[$i]->total;
	$status=$list[$i]->status;

	if($trip_type=="One-way")
	{
	echo("<tr>");
	echo("<td>".$bid."</td>");
	echo("<td>".$from."</td>");
	echo("<td>".$to."</td>");
	echo("<td>".$departure."</td>");
	echo("<td>".$airline."</td>");
	echo("<td>".$seat_type."</td>");
	echo("<td>".$seats."</td>");
	echo("<td> Rs. ".$total."</td>");
	//Comparing date to update the status
	if($status=="Active")
	{
		if($date<$departure)
		{
			echo("<td>".$status."</td>");
		}
		else if($date>$departure)
		{
			echo("<td>Completed</td>");
			$change=$xml->xpath("/user/booking[id = '".$bid."']");
                        $change[0]->status="Completed";
		}
	}
	else
	{
		echo("<td>".$status."</td>");
	}
	echo("<td>
		<a href='http://127.0.0.1/cancel2.php' style='color:red' >Cancel</a>
		</td>");
	echo("<td>
                <a href='http://127.0.0.1/seatupgrade.php' style='color:blue'>Upgrade</a>
		</td>");
		echo("</tr>");
	}
	else
	{
	echo("<tr>");
	echo("<td>".$bid."</td>");
	echo("<td>".$from."</br>".$to."</td>");
	echo("<td>".$to."</br>".$from."</td>");
	echo("<td>".$departure."</br>".$return."</td>");
	echo("<td>".$airline."</td>");
        echo("<td>".$seat_type."</td>");
        echo("<td>".$seats."</td>");
	echo("<td> Rs. ".$total."</td>");
	//Updating status w.r.t current date
	if($status=="Active")
        {
                if($date<$departure)
                {
			echo("<td>".$status."</td>");
                }
                else if($date>=$departure && $date<=$return)
                {
			echo("<td>Ongoing</td>");
			$change=$xml->xpath("/user/booking[id = '".$bid."']");
                        $change[0]->status="Ongoing";
		}
		else if($date>$departure && $date>$departure)
		{
			echo("<td>Completed</td>");
			$change=$xml->xpath("/user/booking[id = '".$bid."']");
                        $change[0]->status="Completed";
		}
        }
        else
        {
                echo("<td>".$status."</td>");
        }
        echo("<td>
                <a href='http://127.0.0.1/cancel2.php' style='color:red'>Cancel</a>
                </td>");
        echo("<td>
                <a href='http://127.0.0.1/seatupgrade.php' style='color:blue'>Upgrade</a>
                </td>");
                echo("</tr>");
	}
}
echo("</table>");
$dom= new DOMDocument('1.0');
                $dom->preserveWhiteSpace=false;
                $dom->formatOutput=true;
                $dom->loadXml($xml->asXML());
                $dom->save("/home/ibab/Applications/Project/XMLs/booking_details.xml");
?>

</body>
</html>
