<?php
    
    require "conexion.php";
    
    $user = $_POST['user'];
    $password = sha1($_POST['pass']);

    $sql = "SELECT id FROM users WHERE name = '".$user."' and passwd = '".$password."'";
    $rec = mysql_query($sql);
    
    if(mysql_num_rows($rec)>0)
    {
        $row = mysql_result($rec,0);
        setcookie("mi_usuario", $row, time()+1800);
        header("Location:catalogo.php");
		
    }else{
        echo '	<script>
					alert("Usuario o contraseña incorrecto");
					window.location= "index.html";
				</script>';
        
    }
?> 