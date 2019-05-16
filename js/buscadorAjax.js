function buscar() {
    
    var clave = document.getElementById("clave").value;
    var cadena = "clave=" + clave;
    var peticion = ConstructorXMLHttpRequest();
    
    if(peticion){
        peticion.open('POST', "buscar.php",true);
        peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        peticion.setRequestHeader("Content-length", cadena.length);
        peticion.setRequestHeader("Connection", "close");
        
        peticion.send(cadena);
        
        peticion.onreadystatechange = function(){
            if(peticion.readyState==4)
                document.getElementById("hover1").innerHTML = peticion.responseText;
        }
        
    }
    
}