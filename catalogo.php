<!doctype html>

<html class="no-js" lang="en">
	<head>
	
    	<meta charset="utf-8" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    	<title>TopMovie</title>
		
    	<link rel="stylesheet" href="css/foundation.css" />
		<link rel="stylesheet" href="css/estilo.css" />
        <link rel="stylesheet" href="css/estilo_peliculas.css" />
		<script type="text/javascript" src="js/vendor/modernizr.js"></script>
        <script type="text/javascript" src="js/Ajax.js"></script>
        <script type="text/javascript" src="js/peticionAjax.js"></script>
        <script type="text/javascript" src="js/buscadorAjax.js"></script>
		
  	</head>
    
    <?php
        require "conexion.php";  
        require "cabecera.php";
        require "pie.php";

        if(!isset($_COOKIE["mi_usuario"])){
    ?>
            <script> alert("Tiempo de la sesion ha expirado"); </script>		   
    <?php
            header("Location:index.html");
        }
        
        $sql_nombre="SELECT name FROM users WHERE id ='".$_COOKIE['mi_usuario']."' ";
        $result = mysql_query($sql_nombre);
        $nombre_usuario = mysql_result($result,0);
        
        $p = 1;
        $pagina= "'".$p."'";

    ?>
	<body>
	
	     <?php $barrasuperior = cabecera($nombre_usuario)?> 	
		 
		<center>
			<form>
				<select name="orden_sel" onchange="enviar(this.value,<?php echo $pagina ?>);">
					<option selected value='por defecto'>-Ordenar-
					<option value='por defecto'>Por defecto
					<option value='nombre'>Nombre
					<option value='fecha'>Fecha
					<option value='puntuacion'>Puntuación
				</select>
			</form>
			<div class="peliculas">
				<div class = "large-10 columns ">
					<div class = 'tabla' id = "table"> 
						<script> enviar('por defecto',<?php echo $pagina?>);</script>
					</div>
				</div>
			</div>
		</center>
		
        <?php $pie = pie(); ?>
        
        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script> $(document).foundation(); </script>
    </body>
</html>