


<?php

                        echo "iniciando";
                        /* Get the port for the WWW service. */
                        $service_port =getservbyname('www', 'tcp');;

                        /* Get the IP address for the target host. */
                        $address = gethostbyname('localhost');
                        #$address='192.168.6.2';

			/* Create a TCP/IP socket. */

                        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                        if ($socket === false) {
                                show_error("Imposible conectar con servidor de Recomendacion. Motivo: socket_create " . socket_strerror(socket_last_error()) . "\n");
                        } else {
                                        echo "OK.\n";
                        }

                        echo "Attempting to connect to '$address' on port '$service_port'...";
                        $result = socket_connect($socket, $address, $service_port);
                        if ($result === false) {
                                echo("Imposible conectar con servidor de Recomendacion. Motivo: socket_connect" . socket_strerror(socket_last_error()) . "\n");
                        } else {
                                        echo "OK.\n";
                        }
                        //$pathtomat="/cambiapathparamatlab\r\n";
						$pathtomat="C:\\\\xampp\htdocs\subiragithub\TopMovie\matlab\r\n"; /* /home/alumnos/ai6/public_html/videoGMA/matlab */
						echo $_COOKIE['mi_usuario']."\n";
                        $funcall="recommendation(".$_COOKIE['mi_usuario'].")\r\n";
                        $info=$pathtomat.$funcall.chr(0);

                        $sent=socket_write($socket, $info, strlen($info));
                        if ($sent!==FALSE) {
                                echo $sent."enviado";
                        }
                        echo "Reading reply:\n\n";
                        $data['resultado']='';
                        while ($out = @socket_read($socket, 2048,PHP_NORMAL_READ )) {
                                echo $out;
                                //$data['resultado']=$data['resultado'].$out;
                        }
                        echo 'Finalizado';
                        socket_close($socket);
?>
