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
				<div class = "large-8 columns">
					<fieldset>
						<form method="POST" action="update_user.php" enctype="multipart/form-data">
							<label for="name">Nombre</label>
							<input type="text" name="name" value="<?php echo $name; ?>" required>
							<label for="ocupacion">Ocupación</label>
							<select name="ocupacion" selected="">
								<option value="<?php echo $ocupacion;?>" selected><?php echo $ocupacion;?></option>
								<option value="administrator">administrator</option>
								<option value="student">student</option>
								<option value="educator">educator</option>
								<option value="engineer">engineer</option>
								<option value="technician">technician</option>
								<option value="programer">programer</option>
								<option value="entertaiment">entertaiment</option>
								<option value="executive">executive</option>
								<option value="scientist">scientist</option>
								<option value="other">other</option>
							</select>
							<div class="large-6 columns">
								<label for="edad">Edad</label>
								<select name="edad" id="edad" >
									<option value="<?php echo $edad;?>" selected><?php echo $edad;?></option>
									<script>
										var edad = document.getElementById("edad");
										var total = 100;
										var cont = 1;
										while (cont<100){
											var option = document.createElement("option");
											option.setAttribute("value",cont);
											option.innerHTML=cont;
											edad.appendChild(option);
											cont++;
										}
									</script>
								</select>
							</div>
							<div class = "large-6 columns">
								<label for="sexo">Sexo</label>
								<select name="sexo">
									<option value="<?php echo $sexo;?>" selected><?php echo $sexo;?></option>
									<option value="M">M</option>
									<option value="F">F</option>
								</select>
							</div>
							<label for="pwd">Contraseña</label>
							<input type="password" name="pwd" placeholder="Contraseña">
							<label for="img">Foto</label>
							<input type="hidden" value="<?php echo $img; ?>" name="pic">
							<input type="file" name="img">
							<div  id="submit">
								<input type="submit" value="Modificar">
							</div>
						</form>
					</fieldset>
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