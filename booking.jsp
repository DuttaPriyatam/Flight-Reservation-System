<!DOCTYPE html>
<%@ page import ="java.util.*"%>
<html>
	<head>
		<title>Home page</title>
<style>
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
div.block_head{
	border: 2px solid black;
	text-align: center;
	margin-top: 20px;
	margin-right: 200px;
	margin-left: 200px;
	color: white;
	padding: 10px;
	background-color: indianred;
}

div.block{
	border: 2px solid black;
	background-color: lavender;
	margin-right: 200px;
        margin-left: 200px;
	padding: 10px;
}
input[type=text] {
	border: 1px solid lavender;
	padding: 2px;
	background: lavender;
	color: black;
	font-weight: bold;
	font-size: large;
}
div.logo{
        position:center;
        text-align:center;
}
</style>
	</head>
	<body style="background-color:antiquewhite">
		<div class="logo">
                        <img src="logo4.jpg">
                        <h3>Levitate and Elevate<h3>
                </div>
                        <%! int i, j; %>
			<%--Function to calculate the money pertaining to each travel based on km and base prices--%> 
			<%! public int CalculateMoney(ArrayList<String> info)
			{
			int seat_val;
                	int total=0;
                	String seatt=new String();


			//Setting list for all the possible destinations
                	ArrayList<String> places= new ArrayList<String>();
                	places.add("Bengaluru(BLR)");
                	places.add("Kolkata(CCU)");
                	places.add("Chennai(MAA)");
                	places.add("Mumbai(BOM)");
                	places.add("Delhi(DEL)");

                	ArrayList<String> airline=new ArrayList<String>();
                	airline.add("Jet Airways");
                	airline.add("IndiGo");
                	airline.add("Air India");
                	airline.add("Spicejet");
                	airline.add("Vistara");

			//Setting base prices for airlines
                	HashMap<String, Integer> cost_airline=new HashMap<String, Integer>();
                	cost_airline.put("Jet Airways",2750);
                	cost_airline.put("IndiGo", 1250);
                	cost_airline.put("Air India", 1550);
                	cost_airline.put("Spicejet", 1200);
                	cost_airline.put("Vistara", 2850);

                	ArrayList<String> from_to=new ArrayList<String>();

                	for(i=0;i<places.size();i++)
                	{
                        	for(j=i+1;j<places.size();j++)
                        	{
                                	String travel=places.get(i)+"-"+places.get(j);
                                	String travel_rev=places.get(j)+"-"+places.get(i);
                                	from_to.add(travel);
                                	from_to.add(travel_rev);
                        	}
                	}

			//Setting destination prices depending on the distance      
                	HashMap<String, Integer> km_from_to=new HashMap<String, Integer>();
                	km_from_to.put(from_to.get(0),1561);
			km_from_to.put(from_to.get(1),1561);
                	km_from_to.put(from_to.get(2),290);
                	km_from_to.put(from_to.get(3),290);
                	km_from_to.put(from_to.get(4),845);
                	km_from_to.put(from_to.get(5),845);
                	km_from_to.put(from_to.get(6),1740);
                	km_from_to.put(from_to.get(7),1740);
                	km_from_to.put(from_to.get(8),1358);
                	km_from_to.put(from_to.get(9),1358);
                	km_from_to.put(from_to.get(10),1655);
                	km_from_to.put(from_to.get(11),1655);
                	km_from_to.put(from_to.get(12),1304);
                	km_from_to.put(from_to.get(13),1304);
                	km_from_to.put(from_to.get(14),1033);
                	km_from_to.put(from_to.get(15),1033);
                	km_from_to.put(from_to.get(16),1756);
                	km_from_to.put(from_to.get(17),1756);
                	km_from_to.put(from_to.get(18),1148);
                	km_from_to.put(from_to.get(19),1148);

                	String from_to_info=info.get(0)+"-"+info.get(1);
                	String oorr=info.get(2);
			
			//Calculating for each travel information depending on trip type
                	if(oorr.equals("One-way"))
                	{
                        	seatt=info.get(7);
                        	if(seatt.equals("First Class"))
                        	{
                                	seat_val=1250;
                                	total=(cost_airline.get(info.get(5))+ (km_from_to.get(from_to_info) * 2) + seat_val) * Integer.parseInt(info.get(6));
                        	}
                        	else if(seatt.equals("Economy"))
                        	{
                                	seat_val=750;
                                	total=(cost_airline.get(info.get(5))+ (km_from_to.get(from_to_info) * 2) + seat_val) * Integer.parseInt(info.get(6));

                        	}
                	}
                	else if(oorr.equals("Round"))
                	{
                        	seatt=info.get(7);
                        	if(seatt.equals("First Class"))
                        	{
                                	seat_val=1250;
                                	total=(((cost_airline.get(info.get(5))+ (km_from_to.get(from_to_info) * 2) + seat_val) * Integer.parseInt(info.get(6)))*2);
                        	}
                        	else if(seatt.equals("Economy"))
                        	{
                                	seat_val=750;
					total=(((cost_airline.get(info.get(5))+ (km_from_to.get(from_to_info) * 2) + seat_val) * Integer.parseInt(info.get(6)))*2);
                        	}
                	}
                	System.out.println(total);
                	return(total);
			}
			%>
			<%
			//Obtaining parameters from the form
			int total;
                	String ret=new String();
                	String from=request.getParameter("from");
                	String to=request.getParameter("to");
                	String trip_type=request.getParameter("trip_type");
			String departure=request.getParameter("departure"); 
			%>
                	<%if(trip_type.equals("Round"))
			{
                        	ret=request.getParameter("ret");
				}%>
                	<%String airline=request.getParameter("airline");
                	String seats=request.getParameter("seats");
                	String seat_type=request.getParameter("seat_type");
			
			//Putting the params into an array list
                	ArrayList<String> info=new ArrayList<String>();
                	info.add(from);
                	info.add(to);
                	info.add(trip_type);
                	info.add(departure);
                	if(trip_type.equals("Round"))
                	{
                        	info.add(ret);
                	}
                	else
                	{
				ret="NULL";
                        	info.add(ret);
                	}
                	info.add(airline);
                	info.add(seats);
                	info.add(seat_type);
			
			//Catching the return value(total cost) from the function 
                	total=CalculateMoney(info);
                	String tot_str=Integer.toString(total);
                	info.add(tot_str);
			%>
			 <div class="menu">
				 <a class="active" href="http://127.0.0.1:8080/home.html">Home</a>
                        <a href="#profile">Profile</a>
                        <a href="http://127.0.0.1/Your_Bookings.php">Booking Information</a>
                        <a href="http://127.0.0.1/cancel2.php">Booking Cancellation</a>
                        <a href="http://127.0.0.1/seatupgrade.php">Seat Upgradation</a>
                        <a href="#contact">Contact</a>
                        <a href="#aboutus">About us</a>

                	</div>
			<div class="block_head">
                        	<h3>Travel Details</h3>
			</div>
			<div class="block">
				<form method="post" action="/myApp/Books">
					<b>From: </b>
					<% out.println("<b>"+from+"</b>"); %>
					<% out.println("<input type='hidden' name='from' value='"+from+"' />");%>
					<b>To: </b>
					<% out.println("<b>"+to+"</b>"); %>
					<% out.println("<input type='hidden' name='to' value='"+to+"' />");%>
					<hr>
					<b>Trip Type: </b>
					<% out.println("<b>"+seat_type+"</b>"); %>
					<% out.println("<input type='hidden' name='trip_type' value='"+trip_type+"' />");%>
					<hr>
					<b>Departure: </b>
					<% out.println("<b>"+departure+"</b>"); %>
					<% out.println("<input type='hidden' name='departure' value='"+departure+"' />");%>
					<b>Return: </b>
					<% out.println("<b>"+ret+"</b>"); %>
					<% out.println("<input type='hidden' name='ret' value='"+ret+"' />");%>
					<hr>
					<b>Airline: </b>
					<% out.println("<b>"+airline+"</b>"); %>
					<% out.println("<input type='hidden' name='airline' value='"+airline+"' />");%>
					<hr>
					<b>Seats: </b>
					<% out.println("<b>"+seats+"</b>"); %>
					<% out.println("<input type='hidden' name='seats' value='"+seats+"' />");%>
					<hr>
					<b>Seat Type: </b>
					<% out.println("<b>"+seat_type+"</b>"); %>
					<% out.println("<input type='hidden' name='seat_type' value='"+seat_type+"' />");%>
					<hr>
					<% out.println("<span><b>Total: </b></span><span style='color: red'><i>Rs. "+tot_str+"</span>");%>
					<% out.println("<input type='hidden' name='total' value='"+tot_str+"' />"); %>
					<div style="text-align:center; display:block">
					<input type="submit" value="Book!"/>
					</div>
					<div style="text-align: center; margin: 3px">
					<a href="http://127.0.0.1:8080/home.html">
						<input type="button" value="Cancel"/>
					</a>
					</div>
			</div>
				</form>
	</body>
</html>
