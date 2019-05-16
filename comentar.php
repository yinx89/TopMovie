<?php 

    include "conexion.php";
    
    $comment = $_POST['comment'];
    $id = $_POST['id'];
    $user = $_COOKIE['mi_usuario'];
    $sql_registro = "INSERT INTO moviecomments VALUES ('$id','$user','$comment')";
    
    if(mysql_query($sql_registro)){
        echo '	<script>
					alert("Comentario realizado con éxito.");
					window.location= "pelicula.php?id='.$id.'";
				</script>';
    }else{ 
        echo "	<script>
					alert('Error en el registro. Intentelo otra vez');
					window.location= 'pelicula.php?id=".$id."';
				</script>";
    }
?>