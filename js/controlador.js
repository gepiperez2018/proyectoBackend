//////////////////////////////////
/*
Elaborado por: Ing. Gabriel Pérez
Enero 2018
Caracas- Venezuela
*/
//////////////////////////////////


// Creamos Arreglo para guardar los datos de operacion //
contenido = new Array();


// Mostrando ////
function mostrarDatos(campo,arregloDatos)
{
	if(arregloDatos)
		{
    var l = arregloDatos.length;
	//Limpiamos la variable donde mostramos los resultados de entrada//
	 document.getElementById(campo).value ="";
    for (var i = 0; i < l; i++)
    {

        document.getElementById(campo).value = document.getElementById(campo).value + arregloDatos[i]+"\n";
    }
			
		}
   $('.materialize-textarea').trigger('autoresize');
   Materialize.updateTextFields();
	
}

// Funcion agregar caso de uso a vector//
function agregarCasoUso()
{
    var valor = document.getElementById("casos_uso").value;
    contenido.push(valor);
    mostrarDatos("entrada", contenido);

}

// Funcion agregar Operaciones//
function agregarOperaciones()
{
    var valorMatriz = document.getElementById("tamano_matrix").value;
    var valorOperaciones = document.getElementById("Operaciones").value;
    contenido.push(valorMatriz + "-" + valorOperaciones);
    mostrarDatos("entrada", contenido);

}


// Funcion agregar QUERY/ UPDATE//
function agregarOpcion() 
{
    var valorCordenadaA = document.getElementById("cordenadasA").value;
    var valorCordenadaB = document.getElementById("cordenadasB").value;	
	var tipo= document.getElementById("tipoOperacionSelect").value;
	
	
	if(document.getElementById("Valor").value>0)
		{			
			var valorAct= document.getElementById("Valor").value;
		}
	

			// SI ES QUERY DEBE TENER 2 CORDENADAS //
		if(tipo=="QUERY")
			{
					if(valorCordenadaA.length!=3)
		{
			
			mostrarAlert("Debe introducir una coordenada valida en A 000, 111, etc.!!!");
			
			
		}
	if(valorCordenadaB.length!=3)
		{
			
			mostrarAlert("Debe introducir una coordenada valida en B 000, 111, etc.!!!");
		
		
		}
	
    	if( (valorCordenadaA) &&  (valorCordenadaB) )
			{
				contenido.push("QUERY-"+valorCordenadaA+"-"+valorCordenadaB);
				
			}
    mostrarDatos("entrada", contenido);

			}
	
	
				// SI ES QUERY DEBE TENER 2 CORDENADAS //
		if(tipo=="UPDATE")
			{
					if(valorCordenadaA.length!=3)
		{
			
			mostrarAlert("Debe introducir una coordenada valida en A 000, 111, etc.!!!");			
			
		}
			
			
		if(!valorAct)
			{
				
				mostrarAlert("Debe introducir un valor numerico .!!!");
			}
	
			if( (valorCordenadaA) && (valorAct))
				{
					contenido.push("UPDATE-"+valorCordenadaA+"-"+valorAct);
				}
    
    mostrarDatos("entrada", contenido);

			}
}

function borrarTodo()
{
	contenido=[];
	mostrarDatos("entrada", contenido);

}

function mostrarAlert(texto)
{
	 swal({
    title: "Error",	
    text: texto,
    timer: 2000,
	 buttons: false,
    showConfirmButton: false
  });
	
}


// funcion para enviar arreglo a php y ejecutar las operacaiones //

function ejecutar()
{
	
	if(contenido.length<3)
		{
			mostrarAlert("Debe cargar valores de entrada para realizar una operacion.")
		}
	
	else
		{
			// Enviaremos el arreglo mediante una peticion AJAX a la pagina php operacion.php //
			
				  var xhr;
 if (window.XMLHttpRequest) 
 { // Mozilla, Safari, ...
    xhr = new XMLHttpRequest();
} 
else if (window.ActiveXObject) 
{ // IE 8 and older
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}
	var data = "entrada=" + contenido;
	 xhr.onreadystatechange=function() 
	 {
    if (this.readyState==4 && this.status==200) 
	{			
		respuestaCall= JSON.parse(this.responseText);
		
		document.getElementById("salida").value="";
		
		for (var k in respuestaCall) 
		{  				
			document.getElementById("salida").value=document.getElementById("salida").value+respuestaCall[k]+"\n";
		}
		  $('.materialize-textarea').trigger('autoresize');
   		  Materialize.updateTextFields();
    }	
	 }
     xhr.open("POST", "model/operacion.php", true); 
     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
     xhr.send(data);	 
			
			
		}
	
	
}

