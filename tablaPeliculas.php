
<?php
    
    require "conexion.php";
	set_time_limit(0);
    
    $filtro = $_POST['orden'];
    $filtro2 = "'".$filtro."'";
    $pagina = $_POST['pagina'];
    $pagina_inicio = ($pagina-1) * 10; 
    
    switch ($filtro){
        case "nombre":
            $datos = mysql_query ("SELECT * FROM movie ORDER BY title ASC LIMIT $pagina_inicio, 10") or die ("Error en la conslta SQL");
            $result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");
			break;
		case "puntuacion":
            $datos = mysql_query ("SELECT * FROM media ORDER BY ponderada DESC LIMIT $pagina_inicio, 10") or die ("Error en la conslta SQL");
            $result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");	
			break;
        case "por defecto":
            $datos = mysql_query ("SELECT * FROM movie LIMIT $pagina_inicio, 10" ) or die("Error en la consulta SQL");
             $result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");
			break;
        case "fecha":
            $datos = mysql_query ("SELECT * FROM movie ORDER BY DATE_FORMAT(date,'%Y-%m-%d') ASC LIMIT $pagina_inicio, 10" ) or die("Error en la consulta SQL");
            $result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");
            break;
        default:
			$datos = mysql_query ("SELECT * FROM movie LIMIT $pagina_inicio, 10" ) or die("Error en la consulta SQL");
            $result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");
			break;
    }
			echo "<table><tr></tr>
			<th height='25%'>Poster</th>
			<th width='10%'>Título</th>
			<th width='5%'>Estreno</th>
			<th width='20%'>Descripción</th>
			<th width='15%'>Puntuaciones</th>
			</tr>";
					
			$cont = mysql_fetch_assoc($result); 

			$cont = $cont['COUNT(id)'];
			$totalpelis = $cont;
			$num_pag = ceil($totalpelis/ 10);
			$prev = $pagina - 1;
			$sig = $pagina + 1; 
			$prev2 = "'".$prev."'";
			$sig2 = "'".$sig."'";
		   
			while ($row= mysql_fetch_assoc($datos)){

				if($filtro=="puntuacion"){
					
					$id=$row['id_movie'];
					$ponderada = $row['ponderada'];
							
					$datos2 = mysql_query ("SELECT * FROM movie WHERE id=".$id) or die("Error en la consulta SQL");		
							
					while ($row= mysql_fetch_assoc($datos2)){	

						$title=$row['title'];
						$date=$row['date'];
						$url=$row['url_imdb'];
						$pic=$row['url_pic'];
						$desc=$row['desc'];
						$id = $row['id'];
							
					};
				}
				else{
					$title=$row['title'];
					$date=$row['date'];
					$url=$row['url_imdb'];
					$pic=$row['url_pic'];
					$desc=$row['desc'];
					$id = $row['id'];
				}

				$score = mysql_query("SELECT score FROM user_score WHERE id_movie=".$id);
  
				$contador=0;
				$suma=0;
				$media=0;
			  
				while($puntos = mysql_fetch_assoc($score)){
						
					$suma = $suma + $puntos["score"];
					$contador++;
				}
				$media=$suma/$contador;
		  
				$datos2 = mysql_query ("SELECT * FROM valores") or die("Error en la consulta SQL");				
					while ($row= mysql_fetch_assoc($datos2)){	
						$media_pelis=$row['media_pelis'];
					};
					
				$ponderada=(($totalpelis * $media_pelis) + ($contador * $media)) / ($totalpelis + $contador);
					
					
					echo "<tr ><td width='12%'> <img id='foto' src='images/".$pic."'></td>";
					echo "<td > <b><a href= 'pelicula.php?id=".$id."'\>".$title."</a></b></td>";
					echo "<td>".$date."</td>"; 
					echo "<td>".$desc."</td>"; 
					echo "<td><b>Valoración media: ".round($media,5)."/5 <br>Media ponderada: ".round($ponderada,5)."/5<br>Valoraciones: ".$contador."</b></td>";
					echo "</tr>";
			}; 

        echo "</table>
                </div>
            <div class = 'pagina'>";
      

        echo "<h5>Página $pagina de $num_pag</h5></a> <br/>" ;

        if ($prev >= 1){
          echo "<a onclick=\"enviar($filtro2,$prev2);\" class='round button'>Anterior</a>"; 
        }else{
          echo "<a class='round button'>Anterior</a>";
        }

        if ($sig <= $num_pag) {
            echo "<a onclick=\"enviar($filtro2,$sig2);\" class='round button' >Siguiente</a>";
        }else{
        
            echo " - <a class='round button'>Siguiente </a>";     
        }

        echo "</div>";
?>