import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.annotation.WebServlet;
import java.util.*;
@WebServlet("/Registration")

public class register extends HttpServlet
{
	private int i;
	public void MakeXml(ArrayList<String> info)
	{
		try
		{
			//Making a generic attribute list for the xml
			ArrayList<String> gen_info=new ArrayList<String>();
                	gen_info.add("Id");
                	gen_info.add("FirstName");
                	gen_info.add("LastName");
                	gen_info.add("DateofBirth");
                	gen_info.add("PhoneNumber");
                	gen_info.add("Password");

			//Creating object for the xml file
			File file=new File("/home/ibab/Applications/Project/XMLs/UserInfo.xml");
			//Making new file if the file object doesn't exist
			if(!file.exists())
			{
				FileOutputStream f1=new FileOutputStream(file);
				//Start for making xml file
				String prologue="<?xml version='1.0' encoding='UTF-8'?>\n";
				byte b1[]=new byte[200];
				b1=prologue.getBytes();
				f1.write(b1);

				//Creating the parent node into an xml file
				String root_node="<UserInfo>\n";
				b1=root_node.getBytes();
				f1.write(b1);
				
				//Creating child nodes
				String user="<user>\n";
				b1=user.getBytes();
				f1.write(b1);

				//Adding attribute information pertaining to each child node
				for(i=0; i<info.size(); i++)
				{
					String feat="<"+gen_info.get(i)+">"+info.get(i)+"</"+gen_info.get(i)+">\n";
					b1=feat.getBytes();
					f1.write(b1);
				}

				String user_end="</user>\n";
                        	b1=user_end.getBytes();
                        	f1.write(b1);

				String close_root_node="</UserInfo>\n";
                        	b1=close_root_node.getBytes();
                        	f1.write(b1);

				f1.close();

                //To give read write permission to the file since it is created in root
				String cmd="sudo chmod 666 /home/ibab/Applications/Project/XMLs/UserInfo.xml";
				Runtime run= Runtime.getRuntime();
				Process pr=run.exec(cmd);
			}
			//If the file already exist we update the file
			else
                        {
                                File tempfile= new File("/home/ibab/Applications/Project/XMLs/tempfile.xml");
                                BufferedReader reader= new BufferedReader(new FileReader(file));
                                BufferedWriter bw= new BufferedWriter(new FileWriter(tempfile));

				//Removing the last line where we were closing the parent node
                                String toremove="</UserInfo>";
				String line;
				while((line=reader.readLine()) != null)
                                {
                                        if(line.equals(toremove)) continue;
                                        bw.write(line);
                                        bw.write("\n");
                                }
				reader.close();
				bw.write("<user>\n");
				for(i=0; i<info.size(); i++)
                                {
                                        bw.write("<"+gen_info.get(i)+">"+info.get(i)+"</"+gen_info.get(i)+">\n");
                                }
				bw.write("</user>\n");
				bw.write("</UserInfo>\n");
				bw.close();
				boolean successful=tempfile.renameTo(file);
                //To give read write permission to the file since it is created in root
				String cmd="sudo chmod 666 /home/ibab/Applications/Project/XMLs/UserInfo.xml";
				Runtime run= Runtime.getRuntime();
				Process pr=run.exec(cmd);
			}
		}
		catch(Exception e1)
		{
			System.out.println("Error in creating file!");
		}
	}
	
	//Using post so that info is not visible in the url, better security
	public void doPost(HttpServletRequest request, HttpServletResponse response)
                throws ServletException, IOException{
		//Obtaining all the params from the form
		String fname=request.getParameter("fname");
		String mname=request.getParameter("mname");
		String lname=request.getParameter("lname");
		String DOB=request.getParameter("DOB");
		String Id=request.getParameter("Id");
		String phno=request.getParameter("phno");
		String pwd1=request.getParameter("pwd1");
		String pwd2=request.getParameter("pwd2");
		String agreed=request.getParameter("agreed");
		
		//Adding the parameters into an array
		ArrayList<String> info=new ArrayList<String>();
		info.add(Id);
		info.add(fname);
		info.add(lname);
		info.add(DOB);
		info.add(phno);
		info.add(pwd1);
		
		PrintWriter out=response.getWriter();

		out.println("<html>");
		out.println("<head>");
		out.println("<title>Registration</title>");
		out.println("</head>");
		out.println("<body style='background-color: antiquewhit'>");
		//If passwords match
		if(pwd1.equals(pwd2))
		{
			out.println("<h4>Congrats "+fname+", your account has been created</h3>");
			out.println("<a href='http://127.0.0.1/login.php'>Click here to be redirected to login page</a>");
			out.println("</body>");
			out.println("</html>");
			//Passing the array to the function responsible to make the xml
			MakeXml(info);
		}
		//If passwords don't match
		else
		{
			out.println("<p style='color: red'> The passwords don't match. Check and try again!</p>");
			out.println("</body>");
                        out.println("</html>");
		}
	}
};

