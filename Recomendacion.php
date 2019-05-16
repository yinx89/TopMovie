<!doctype html>
<?php
  require "conexion.php";     
  require "cabecera.php";
    require "pie.php";
	set_time_limit(0);
?>

<html class="no-js" lang="en">
    <head>
    	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>TopMovie</title>
		
    	<link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/estilo.css" />
        <link rel="stylesheet" href="css/estilo_recomendacion.css" />
        <script type="text/javascript" src="js/Ajax.js"></script>
        <script type="text/javascript" src="js/buscadorAjax.js"></script>
    	<script src="js/vendor/modernizr.js"></script>
  	</head>
	<body>
		<?php 
			if(!isset($_COOKIE["mi_usuario"])){
		?>
			<script>
				alert("Tiempo de la sesion ha expirado");
			</script>
		<?php
			header("Location:index.html");
			}   
	
			$sql_nombre="SELECT name FROM users WHERE id ='".$_COOKIE['mi_usuario']."' ";
			$result = mysql_query($sql_nombre);
			$nombre_usuario = mysql_result($result,0);
			
			
			
			
			$barrasuperior = cabecera($nombre_usuario)
		?> 	
		<?php
			$sql_nombre="SELECT id FROM users WHERE id ='".$_COOKIE['mi_usuario']."' ";
			$result = mysql_query($sql_nombre);
			$user = mysql_result($result,0);
        
            $datos = mysql_query ("SELECT * FROM recs WHERE user_id=$user ORDER BY rec_score DESC LIMIT 10") or die ("Error en la conslta SQL1");
			
			echo "<center><a name=\"recomendar\" href='./dorec.php' onClick=\"alert('Recomendación en curso. En breve estará disponible.')\" class='round button'>Generar Recomendación</a><div class=\"datagrid\"><table ><tr></tr><th height='25%'>Poster</th><th width='10%'>Título</th><th width='5%'>Estreno</th><th width='22%'>Descripción</th><th width='10%'>Puntuación de recomendación</th></tr>";

			while ($row= mysql_fetch_assoc($datos)){
			
				$user_id=$row['user_id'];
				$movie_id=$row['movie_id'];
				$rec_score=$row['rec_score'];
				$time=$row['time'];
		  
				$datos2 = mysql_query ("SELECT * FROM movie WHERE id=".$movie_id) or die("Error en la consulta SQL4");		
							
				while ($row= mysql_fetch_assoc($datos2)){	

					$title=$row['title'];
					$date=$row['date'];
					$url=$row['url_imdb'];
					$pic=$row['url_pic'];
					$desc=$row['desc'];
					$id = $row['id'];
						
				};
				echo "<tr ><td width='12%'> <img width='98%' id='foto' src='images/".$pic."'></td>";
				echo "<td > <a href= 'pelicula.php?id=".$movie_id."'\>".$title."</a></td>";
				echo "<td>".$date."</td>"; 
				echo "<td>".$desc."</td>"; 
				echo "<td>".round($rec_score,5)."</td>";
				echo "</tr>"; 

			}; 
			echo "</table></div></center></div></div>";

		?>
        <?php $pie = pie(); ?>
        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script> $(document).foundation();</script>
 	</body>
</html>