<?php 

    include "conexion.php";
	set_time_limit(0);
	ignore_user_abort(true);

    $voto = $_POST['valor'];
    $id = $_POST['id'];
    $user = $_COOKIE['mi_usuario'];
    $hora = date("Y-m-d H:i:s");

    $sql_comprobacion="SELECT score FROM user_score WHERE id_movie=".$id." AND id_user=".$user;
    
    $query = mysql_query($sql_comprobacion);
    if(mysql_num_rows($query)>0){
        $sql_valorar = "UPDATE user_score SET score='".$voto."', time='".$hora."' WHERE id_movie='".$id."' AND id_user='".$user."'";
    }else{
        $sql_valorar = "INSERT INTO user_score VALUES ('$user','$id','$voto','$hora')";
    }
	
	mysql_query($sql_valorar);
	
	$datos = mysql_query ("SELECT * FROM movie" ) or die("Error en la consulta SQL");
	$result = mysql_query ("SELECT COUNT(id) FROM movie" ) or die("Error en la consulta SQL");
	
	$cont = mysql_fetch_assoc($result); 
	$cont = $cont['COUNT(id)'];
	$totalpelis = $cont;

	$pelicula=1;
	$media1=0;
	$media2=0;
	$media_peli=0;
	
	while($pelicula <= $totalpelis){

        $score2 = mysql_query("SELECT score FROM user_score WHERE id_movie=".$pelicula);
  
        $contador2=0;
        $suma2=0;
      
        while($puntos2 = mysql_fetch_assoc($score2)){
                
            $suma2 = $suma2 + $puntos2["score"];
            $contador2++;
        }
		
        $media_peli=$suma2/$contador2;
		$media1 = $media1 + $media_peli;
		$media2 = $media1/$totalpelis;
		
		$sql_comprobacion="SELECT media_pelis FROM valores";
		$query = mysql_query($sql_comprobacion);
		$row= mysql_fetch_assoc($query);
		$media_pelis=$row['media_pelis'];
		
		$ponderada=(($totalpelis * $media_pelis) + ($contador2 * $media_peli)) / ($totalpelis + $contador2);
		mysql_query("UPDATE media SET ponderada='".$ponderada."' WHERE id_movie='".$pelicula."'") or die ("Error en la consulta SQL");
		$pelicula++;
	};

	$sql_comprobacion="SELECT * FROM valores";
    $query = mysql_query($sql_comprobacion);
	
	while ($row= mysql_fetch_assoc($query)){
		$hora = date("Y-m-d H:i:s");
		if($row['time']<$hora){
			mysql_query("DELETE FROM valores WHERE time = '".$row['time']."'") or die ("Error en la consulta SQL");;
		}
	}
	mysql_query("INSERT INTO valores VALUES ('$user','$media2','$hora')") or die ("Error en la consulta SQL");
	

?>