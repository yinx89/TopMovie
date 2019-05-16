<?php 

    require "conexion.php";

    $title=$_POST['clave'];
    $sql_buscador=mysql_query("SELECT title, id FROM movie WHERE title LIKE '".$title."%'");
    
    if(mysql_num_rows($sql_buscador)>0){
        while($row = mysql_fetch_assoc($sql_buscador)){
            
            $title = $row['title'];
            $id = $row['id'];
			
            echo "<li><a href='pelicula.php?id=$id'>$title</a></li>";
        }
    }
?>