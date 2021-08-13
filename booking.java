import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.annotation.WebServlet;
import java.util.*;
@WebServlet("/Books")

public class booking extends HttpServlet
{
	private int i;
	public void MakeXml(ArrayList<String> info)
	{
		try
		{
			//Creating object for the xml file
			File file=new File("/home/ibab/Applications/Project/XMLs/booking_details.xml");
			//Making new file if the file object doesn't exist
			if(!file.exists())
                        {
				FileOutputStream f1=new FileOutputStream(file);
				byte b1[]=new byte[200];

				//Start for making xml file
				String prologue="<?xml version='1.0' encoding='UTF-8'?>\n";
				b1=prologue.getBytes();
				f1.write(b1);

				//Randomly generating a 6 character booking id
                                int leftLimit = 48; // numeral '0'
    				int rightLimit = 122; // letter 'z'
    				int targetStringLength = 6;
    				Random random = new Random();

    				String generatedString = random.ints(leftLimit, rightLimit + 1)
      				.filter(i -> (i <= 57 || i >= 65) && (i <= 90 || i >= 97))
      				.limit(targetStringLength)
      				.collect(StringBuilder::new, StringBuilder::appendCodePoint, StringBuilder::append)
      				.toString();
				
				//Putting tag information into an array
				ArrayList<String> gen_info=new ArrayList<String>();
				gen_info.add("from");
                		gen_info.add("to");
                		gen_info.add("trip_type");
                		gen_info.add("departure");
                		gen_info.add("return");
                		gen_info.add("airline");
                		gen_info.add("seats");
                		gen_info.add("seat_type");
                		gen_info.add("total");
					
				//Parent node
				String user="<user>\n";
				b1=user.getBytes();
				f1.write(b1);

				//Each booking child node
                                String booking="<booking>\n";
				b1=booking.getBytes();
				f1.write(b1);

				//Adding information to all the attributes pertaining to each child node, here booking details
                                String id="<id>"+generatedString+"</id>\n";
				b1=id.getBytes();
				f1.write(b1);

				for(i=0; i<info.size(); i++)
                        	{
                                	String feat="<"+gen_info.get(i)+">"+info.get(i)+"</"+gen_info.get(i)+">\n";
                                	b1=feat.getBytes();
                                	f1.write(b1);
                        	}
				String status="<status>Active</status>";
				b1=status.getBytes();
				f1.write(b1);

                                String booking_end="</booking>\n";
                                b1=booking_end.getBytes();
                                f1.write(b1);

                                String user_end="</user>\n";
                                b1=user_end.getBytes();
                                f1.write(b1);
				f1.close();
                //To give read write permission to the file since it is created in root
				String cmd="sudo chmod 666 /home/ibab/Applications/Project/XMLs/booking_details.xml";
                                Runtime run= Runtime.getRuntime();
                                Process pr=run.exec(cmd);

			}
			//If the file already exists it will update it
			else
                        {
                                File tempfile= new File("/home/ibab/Applications/Project/XMLs/tempfile.xml");
                                BufferedReader reader= new BufferedReader(new FileReader(file));
                                BufferedWriter bw= new BufferedWriter(new FileWriter(tempfile));
                                String toremove="</user>";
                                String line;

				int leftLimit = 48; // numeral '0'
                                int rightLimit = 122; // numeral 'z'
                                int targetStringLength = 6;
                                Random random = new Random();

                                String generatedString = random.ints(leftLimit, rightLimit + 1)
                                .filter(i -> (i <= 57 || i >= 65) && (i <= 90 || i >= 97))
                                .limit(targetStringLength)
                                .collect(StringBuilder::new, StringBuilder::appendCodePoint, StringBuilder::append)
                                .toString();
				
				//Removing the last line where we were closing the parent node tag
                                while((line=reader.readLine()) != null)
                                {
                                        if(line.equals(toremove)) continue;
                                        bw.write(line);
                                        bw.write("\n");
                                }
                                reader.close();
				
				bw.write("<booking>\n"); 
				bw.write("<id>"+generatedString+"</id>\n");
                                bw.write("<from>"+info.get(0)+"</from>\n");
                                bw.write("<to>"+info.get(1)+"</to>\n");
                                bw.write("<trip_type>"+info.get(2)+"</trip_type>\n");
                                bw.write("<departure>"+info.get(3)+"</departure>\n");
                                if((info.get(2)).equals("Round"))
                                {
                                        bw.write("<return>"+info.get(4)+"</return>\n");
                                }
                                else
                                {
                                        bw.write("<return>"+info.get(4)+"</return>\n");
                                }
                                bw.write("<airline>"+info.get(5)+"</airline>\n");
                                bw.write("<seats>"+info.get(6)+"</seats>\n");
                                bw.write("<seat_type>"+info.get(7)+"</seat_type>\n");
                                bw.write("<total>"+info.get(8)+"</total>\n");
                                bw.write("<status>Active</status>\n");
                                bw.write("</booking>\n");
			 	bw.write("</user>\n");	
                                bw.close();
                                boolean successful = tempfile.renameTo(file);
                    //To give read write permission to the file since it is created in root
			        String cmd="sudo chmod 666 /home/ibab/Applications/Project/XMLs/booking_details.xml";
                                Runtime run= Runtime.getRuntime();
                                Process pr=run.exec(cmd);	
                        }
		}
		catch(Exception e1)
		{
			System.out.println("Error in creating file!");
		}
	}
	//Using post so that it is not visible in the url, better security
	public void doPost(HttpServletRequest request, HttpServletResponse response)
                throws ServletException, IOException{
		//Obtaining all the params from the form
		String ret=new String();
                String from=request.getParameter("from");
                String to=request.getParameter("to");
                String trip_type=request.getParameter("trip_type");
                String departure=request.getParameter("departure");
                if(trip_type.equals("Round"))
                {
                        ret=request.getParameter("ret");
                }
                String airline=request.getParameter("airline");
                String seats=request.getParameter("seats");
                String seat_type=request.getParameter("seat_type");
                String total=request.getParameter("total");
		
		//Adding the parameters into an array
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
		info.add(total);

		PrintWriter out=response.getWriter();
			
			//Passing the array to the function responsible to make the xml
			MakeXml(info);

			out.println("<html>");
			out.println("<body style='background-color: antiquewhite'>");
			out.println("<h2>Your flight ticket has been successfully booked</h2>");
			out.println("</br>");
			out.println("<a href='http://127.0.0.1/Your_Bookings.php'>Click here</a> to be redirected to your Booking Information page.</b>");
			out.println("</body>");
			out.println("</html>");
	}
};
