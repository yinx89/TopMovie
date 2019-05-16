<?php
	require "conexion.php";

    $name = $_POST['name'];
    $ocupacion = $_POST['ocupacion'];
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $pwd = sha1($_POST['pwd']);
    
    if (is_uploaded_file($_FILES['img']  ['tmp_name'])){
        
        $nombreDirectorio = "img/";
        $nombreFichero = $_FILES['img']['name'];
        $nombreCompleto = $nombreDirectorio. $nombreFichero;
        
        if (is_file($nombreCompleto)){
            $idUnico = time();
            $nombreFichero = $idUnico . "-" . $nombreFichero;
        }
        move_uploaded_file($_FILES['img']['tmp_name'], $nombreDirectorio.$nombreFichero);
    }else{
        print ("No se ha podido subir el fichero");
    }

    $sql_registro = "INSERT INTO users VALUES (NULL,'$name','$edad','$sexo','$ocupacion','$nombreFichero','$pwd')";
    $sql_id= "SELECT id FROM users WHERE name = '".$name."' and passwd = '".$pwd."'";
    
    if(mysql_query($sql_registro)){
        $result = mysql_query($sql_id);
        $creden = mysql_result($result,0);
        setcookie("mi_usuario", $creden, time()+1800);
        header("Location:catalogo.php");
    }
    else{ 
        echo '	<script>
					alert("Error al realizar el registro. Inténtelo de nuevo.");
					window.location= "index.html";
				</script>';
        
    }

?>