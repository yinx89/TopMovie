<?php

	error_reporting(E_ALL ^ E_DEPRECATED);

	if (!$link = mysql_connect('localhost', 'root', '')) { echo 'No pudo conectarse a mysql';
		exit;
	}

	if (!mysql_select_db('ai6', $link)) { echo 'No se pudo seleccionar la base de datos';
		exit;
	}

  return $link;

?>
