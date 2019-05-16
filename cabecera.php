<?php

  function cabecera ($nombre_usuario) {
      
    echo '
			<div class = "fixed">
				<nav class= "top-bar">
					<section class="top-bar-section">
						<ul class="right">
							<li class="active"><a href="usuario.php">'.$nombre_usuario.'</a></li>
							<li class="active"><a href="cerrar_sesion.php">Cerrar sesión</a></li>
						</ul>
						<ul class="left">
							<li class="has-form"> 
								<div class="row collapse" left = "50%"> 
									<div class="large-8 columns"> 
										<input id="clave" type="text" placeholder="Búsqueda por título" onkeyup="buscar();" data-dropdown="hover1" data-options="is_hover:true; hover_timeout:5000">
										<ul id="hover1" class="f-dropdown" data-dropdown-content></ul>
									</div> 
								</div> 
							</li>
							<li class = "active"><a href="catalogo.php">  Volver a Catálogo  </a></li>
							<li class = "active"><a href="Recomendacion.php">  Recomendaciones  </a></li>
						</ul>
						<center>
							<img height="50px" width="280px" src="img/logo_index.png">
						</center>
					</section>
				</nav> 
			</div> ';
  }
  ?>