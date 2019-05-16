<?php
	require "conexion.php";

	if(!isset($_POST['name'])){
        $name ='';
    }else {$name=$_POST['name'];}

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
        $nombreFichero = $_POST['pic'];
    }

    $sql_registro = "UPDATE users SET name='".$name."', edad='".$edad."', sex='".$sexo."', ocupacion='".$ocupacion."', pic='".$nombreFichero."', passwd='".$pwd."' WHERE id=".$_COOKIE['mi_usuario'];


    if(mysql_query($sql_registro) ){
        echo '<script>
            window.location= "usuario.php";
        </script>';
    }else{
        echo '<script>
			alert("Error");
            window.location= "usuario.php";
        </script>';
    }

?>
