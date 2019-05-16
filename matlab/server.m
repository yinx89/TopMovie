import java.net.*;
import java.io.*;


serverSocket = ServerSocket(80);

display('Iniciando servidor');

try
    while(1)
        socket = serverSocket.accept();
        display('Nueva conexion entrante');
	in = BufferedReader(InputStreamReader(socket.getInputStream()));
            %Leemos datos
            pathstr = in.readLine();
            funcstr = in.readLine();

                display(char(pathstr));
                display(char(funcstr));
                out =PrintWriter(BufferedWriter(OutputStreamWriter(socket.getOutputStream())),true);
		%Codigo que atiende la peticion

		%Establece en path de los script matlab del usuario
        userpath(char(pathstr));
		%Ejecuta la funcion indicada por el usuario
		eval(char(funcstr));
        status = 'correcto';

		%Devolvemos status y cerramos
                out.println(strcat(int2str(status),char(0)));
                out.flush();
                socket.shutdownOutput();
                userpath('reset');


        display('cerrando conexion con cliente');
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
