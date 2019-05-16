function enviar(orden,pagina) {
    
    var cadena = "orden=" + orden + "&pagina=" + pagina;
    var peticion = ConstructorXMLHttpRequest();
    
    if(peticion){
        peticion.open('POST', "funcion.php",true);
        peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        peticion.setRequestHeader("Content-length", cadena.length);
        peticion.setRequestHeader("Connection", "close");
        
        peticion.send(cadena);
        
        peticion.onreadystatechange = function(){
            if(peticion.readyState==4)
                document.getElementById("table").innerHTML = peticion.responseText;
        }
        //peticion.send(null);
    }
    
}