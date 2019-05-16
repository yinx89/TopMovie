<!doctype html>
<?php
    require "conexion.php";  
    require "cabecera.php";
    require "pie.php";
?>

<html class="no-js" lang="en">
    <head>
	
    	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>TopMovie</title>
		
    	<link rel="stylesheet" href="css/foundation.css"/>
        <link rel="stylesheet" href="css/estilo.css"/>
        <link rel="stylesheet" href="css/estilo_usuario.css"/>
        <script type="text/javascript" src="js/Ajax.js"></script>
        <script type="text/javascript" src="js/buscadorAjax.js"></script>
        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
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
			
			$sql_nombre="SELECT id FROM users WHERE id ='".$_COOKIE['mi_usuario']."' ";
			$result = mysql_query($sql_nombre);
			$user = mysql_result($result,0);
        
            $sql_nombre="SELECT * FROM users WHERE id ='".$_COOKIE['mi_usuario']."' ";
        
            $result = mysql_query($sql_nombre);
            $row = mysql_fetch_assoc($result);
                
            $name = $row['name'];
            $ocupacion = $row['ocupacion'];
            $edad = $row['edad'];
            $sexo = $row['sex'];
            $img = $row['pic'];

            $barrasuperior = cabecera($name);
        ?> 
		
        <div class="user">
			<div class="row">
				<center>
					<img width ="200px" heigth= "300px" src='img/<?php echo $img;?>'>
					<?php 
						echo "<h6>Nombre: ".$name."</h6>";
						echo "<h6>Profesión: ".$ocupacion."</h6>"; 
						echo "<h6>Sexo: ".$sexo."</h6>";
						echo "<h6>Edad: ".$edad."</h6>";
						
						
					?>
					<a name="modificar" href='./modificar_datos.php'  class='round button'>Modificar Datos</a>
				</center>
			</div> 
			<div class="row">
				<br><br><center><h2>Comentarios publicados:</h2></center>
				<div class = "large-12 columns">
					<div class = "datagrid">
						<ul id="ule">
							<?php
								$sql_score = "SELECT comment,movie_id FROM moviecomments WHERE user_id=".$_COOKIE['mi_usuario'];
								$puntos = mysql_query($sql_score);
								while ($res1 = mysql_fetch_assoc($puntos)){
									$movie_id = $res1['movie_id'];
									$comment = $res1['comment'];
									
									$sql_movie = "SELECT title, url_pic FROM movie WHERE id=".$movie_id;
									$movie =mysql_query($sql_movie);
									while ($res2 = mysql_fetch_assoc($movie)){
							
										$title= $res2['title'];
										echo "<li><a href='pelicula.php?id=$movie_id'>$title :</a>   $comment</li><br>";
									}
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<center><h2>Puntuaciones publicadas:</h2></center>
				<div class = "large-12 columns">
					<div class = "datagrid">
						<ul id="ule">
							<?php
								$sql_score = "SELECT id_movie, score FROM user_score WHERE id_user=".$_COOKIE['mi_usuario'];
								$puntos = mysql_query($sql_score);
								while ($res1 = mysql_fetch_assoc($puntos)){
									$score = $res1['score'];
									$id_movie = $res1['id_movie'];
									
									$sql_movie = "SELECT title, url_pic FROM movie WHERE id=".$id_movie;
									$movie =mysql_query($sql_movie);
									while ($res2 = mysql_fetch_assoc($movie)){
										
										$title= $res2['title'];
										$url_pic = $res2['url_pic'];
										echo "<li><a href='pelicula.php?id=$id_movie'>$title:  </a>  $score</li><br>";
									}
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			
			<center><a name="recomendar" href='./dorec.php' onClick="alert('Recomendación en curso. En breve estará disponible.')"  class='round button'>Generar Recomendación</a></center>
		
			<div class="row">
				<center><h2>Recomendaciones:</h2></center>
				<div class = "large-12 columns">
					<div class = "datagrid">
						<ul id="ule">
							<?php
								
							
								$datos = mysql_query ("SELECT * FROM recs WHERE user_id=$user ORDER BY rec_score DESC LIMIT 10") or die ("Error en la conslta SQL1");
								
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
								echo "<li><a href='pelicula.php?id=$movie_id'>$title</a></li><br>";
								};
							?>
						</ul>
					</div>
				</div>
			</div>
        </div>
		
        <?php $pie = pie(); ?>
        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        </script>
		
 	</body>
</html>