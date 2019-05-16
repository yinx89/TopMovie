<?php

include "conexion.php";
set_time_limit(0);

$datos = mysql_query ("SELECT * FROM movie" ) or die("Error en la consulta SQL");
$result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");

$cont = mysql_fetch_assoc($result); 
$cont = $cont['COUNT(id)'];
$totalpelis = $cont;

	$pelicula=1;
	$media1=0;
	$media2=0;
	$media_peli=0;
	while($pelicula <= $totalpelis){

        $score2 = mysql_query("SELECT score FROM user_score WHERE id_movie=".$pelicula);
  
        $contador2=0;
        $suma2=0;
      
        while($puntos2 = mysql_fetch_assoc($score2)){
                
            $suma2 = $suma2 + $puntos2["score"];
            $contador2++;
        }
        $media_peli=$suma2/$contador2;
		$media1 = $media1 + $media_peli;
		$media2 = $media1/$totalpelis;
   
		$pelicula++;
	};


	while ($row= mysql_fetch_assoc($datos)){
    
        $title=$row['title'];
        $date=$row['date'];
        $url=$row['url_imdb'];
        $pic=$row['url_pic'];
        $desc=$row['desc'];
        $id = $row['id'];
                
        $sql3 = "SELECT score FROM user_score WHERE id_movie=".$id;
        $score = mysql_query("SELECT score FROM user_score WHERE id_movie=".$id);
  
        $contador=0;
        $suma=0;
		$media=0;
      
        while($puntos = mysql_fetch_assoc($score)){
                
            $suma = $suma + $puntos["score"];
            $contador++;
        }
        $media=$suma/$contador;
		
         
		$ponderada=(($totalpelis * $media2) + ($contador * $media)) / ($totalpelis + $contador);
        
		mysql_query("INSERT INTO media VALUES ($id, ".round($ponderada,5).")") or die ("Error en la consulta SQL");

    }; 
	



?>