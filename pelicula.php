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
        <link rel="stylesheet" href="css/estilo_peli.css" />
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

            $id = $_GET["id"];
            $datos = mysql_query ("SELECT * FROM movie WHERE id=".$id) or die("Error en la consulta SQL");
            $datos3 = mysql_query ("SELECT genre FROM moviegenre WHERE movie_id=".$id)or die("Error en la consulta SQL");	
            $row= mysql_fetch_assoc($datos);
            
            $title=$row['title'];
            $date=$row['date'];
            $url=$row['url_imdb'];
            $pic=$row['url_pic'];
            $desc=$row['desc'];
            $imdb=$row['url_imdb'];
			
			$result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");
			$cont = mysql_fetch_assoc($result); 
			$cont = $cont['COUNT(id)'];
			$totalpelis = $cont;

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

        ?>
        <div class="row peli">
            <div class="datagrid">
				<div class = "large-3 columns ">
					<img width ="200px" heigth= "300px" src='images/<?php echo $pic;?>'>
				</div>
				<div class = "large-9 columns ">
					<?php 
						echo "<h2>".$title."</h2>";
						echo "<hr>";
						echo "<p>Fecha de estreno: ".$date.". <br> ".$desc."</p>"; 
						echo "<p>Genero/s: "; 
							while($gen = mysql_fetch_assoc($datos3)){
								$datos4 = mysql_query ("SELECT name FROM genre WHERE id=".$gen['genre'])or die("Error en la consulta aaaSQL");
								while($genero= mysql_fetch_assoc($datos4)){
									echo $genero['name'].", ";
								}
							} 
						echo "<br><a href='$imdb'>Enlace a IMDB</a>";
					?>
					<div class="row">
						<div class="large-4 columns">
							<p text-align="center"> <?php echo "<b>Media:".round($media,5)."/5<br>Ponderada:".round($ponderada,5)."/5";?> <br>(<?php echo $contador;?> votos)</b></p>
						</div>
						<div class= "large-4 columns">
							<form method="post" action="valorar.php">
								<label>Valora <?php echo $title;?></label>
								<div class = "large-6 columns">
									<select name="valor" id="valor">
										<script>
											var valor = document.getElementById("valor");
											var total = 5;
											var cont = 0;
											while (cont<=total){
												var option = document.createElement("option");
												option.setAttribute("value",cont);
												option.innerHTML=cont;
												valor.appendChild(option);
												cont++;  
										}
										</script>
									</select>
								</div>
								<input type="hidden" name="id" value="<?php echo $id;?>">
								<div class = "large-6 columns">
									<input type="submit" value="Votar" onClick="alert('Puntuación realizada. En breve será contabilizada.');"> 
								</div>
							</form>
						</div>
						<div  class= "large-4 columns">
							<?php
								$votacion = mysql_query("SELECT score FROM user_score WHERE id_movie=".$id." AND id_user=".$_COOKIE['mi_usuario']);
								if(mysql_num_rows($votacion)>0){
									
									$voto = mysql_result($votacion,0);
									echo "<h4>Tu Puntuacion: $voto</h4>";
								}else
									echo "<h4>No votada</h4>"
							?>
						</div>
					</div>
                </div>
			</div>
		</div>
        <div class="row">
            <div class = "large-12 columns">
                <div class= "coments">
                    <h4>Escribe tu comentario:</h4>
                    <form method = "post" action="comentar.php">
                        <input name="comment" type="text" required="required" >
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" value="Comentar">
                    </form>
                    <ul>
                         <?php
							$comments = mysql_query("SELECT * FROM moviecomments WHERE movie_id=".$id);

							while ($row= mysql_fetch_assoc($comments)){

								$comentario=$row['comment'];
								$user=$row['user_id'];
								$us = mysql_query("SELECT name, pic FROM users WHERE id=".$row['user_id']);
								$u = mysql_fetch_assoc($us);
								$usuario = $u['name'];
								$pic = $u['pic'];
								echo "<li><img src='img/".$pic."'> ".$usuario.": ".$comentario."</li>";

							}   
                         ?> 
                    </ul>
                </div>                
            </div>
        </div>
        <?php $pie = pie(); ?>
        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script> $(document).foundation();</script>
 	</body>
</html>