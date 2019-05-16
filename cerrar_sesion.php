<?php

    $user = $_COOKIE['mi_usuario'];
    setcookie("mi_usuario", $user, time()-1800);
	
    echo '	<script>
	
				alert("Sesión cerrada con éxito");
				window.location= "index.html";
			
			</script>';
?>