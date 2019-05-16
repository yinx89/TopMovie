import java.net.*;
import java.io.*;


serverSocket = ServerSocket(80);

display('Initialize server');

try
    while(1)
        socket = serverSocket.accept();
        display('New incoming connection');
	in = BufferedReader(InputStreamReader(socket.getInputStream()));
            %Read data
            pathstr = in.readLine();
            funcstr = in.readLine();

                display(char(pathstr));
                display(char(funcstr));
                out =PrintWriter(BufferedWriter(OutputStreamWriter(socket.getOutputStream())),true);
		%Code that attends the petition

		%Sets the path of the user's matlab script
        userpath(char(pathstr));
		%Executes the function indicated by the user
		eval(char(funcstr));
        status = 'correcto';

		%We return status and close
                out.println(strcat(int2str(status),char(0)));
                out.flush();
                socket.shutdownOutput();
                userpath('reset');


        display('close connection with client');
        socket.close()
    end
catch e
    e.message
    if(isa(e, 'matlab.exception.JavaException'))
        ex = e.ExceptionObject;
        ex.printStackTrace;
    end
    display('excepcion')
    socket.close();
    serverSocket.close();
end
serverSocket.close();
