var Conexion=false; // Variable que manipula la conexion.
	var Servidor="consulta.php"; // Determina la pagina donde buscar
	var Palabra=""; //Determina la ultima palabra buscada.

	// funcion que realiza la conexion con el objeto XMLHTTP...
	function Conectar()
	{
		if(window.XMLHttpRequest)
			Conexion=new XMLHttpRequest(); //mozilla
		else if(window.ActiveXObject)
			Conexion=new ActiveXObject("Microsoft.XMLHTTP"); //microsoft
	}

	function Contenido(idContenido)
	{
		/* readyState devuelve el estado de la conexion. puede valer:
		 *	0- No inicializado (Es el valor inicial de readyState)
		 *	1- Abierto (El método "open" ha tenido éxito)
		 *	2- Enviado (Se ha completado la solicitud pero ningun dato ha sido recibido todavía)
		 *	3- Recibiendo
		 *	4- Respuesta completa (Todos los datos han sido recibidos)
		 */

		// En espera del valor 4
		if(Conexion.readyState!=4) return;
		/* status: contiene un codigo enviado por el servidor
		 *	200-Completado con éxito
		 *	404-No se encontró URL
		 *	414-Los valores pasados por GET superan los 512
		 * statusText: contiene el texto del estado
		 */
		if(Conexion.status==200) // Si conexion HTTP es buena !!!
		{
			//si recibimos algun valor a mostrar...
			if(Conexion.responseText)
			{
				/* Modificamos el identificador temp con el valor recibido por la consulta
				*	Podemos recibir diferentes tipos de datos:
				*	responseText-Datos devueltos por el servidor en formato cadena
				*	responseXML-Datos devueltos por el servidor en forma de documento XML
				*/
				document.getElementById(idContenido).style.display="block";
				document.getElementById(idContenido).innerHTML=Conexion.responseText;
			}else
				document.getElementById(idContenido).style.display="none";
		}else{
			document.getElementById(idContenido).innerHTML=Conexion.status+"-"+Conexion.statusText;
		}

		// Deshabilitamos la visualización del reloj
		//document.getElementById("reloj").style.visibility="hidden";

		Conexion=false;
	}

	function Solicitud(idContenido,Cadena,accion)
	{
		// si no recibimos cadena, no hacemos nada.
		// Cadena=la cadena a buscar en la base de datos
		/* Si cadena es igual a Palabra, no se realiza la busqueda. Puede ser que pulsen la tecla tabulador,
		 * y no interesa que vuelva a verificar...*/
		if(Cadena && Cadena!=Palabra)
		{
			// Si ya esta conectado, cancela la solicitud en espera de que termine
			if(Conexion) return; // Previene uso repetido del boton.
			
			// Realiza la conexion
			Conectar();
			
			// Si la conexion es correcta...
			if(Conexion)
			{
				// Habilitamos la visualización del reloj
				//document.getElementById("reloj").style.visibility="visible";

				// Esta variable, se utiliza para igualar con la cadena a buscar.
				Palabra=Cadena;

				/* Preparamos una conexion con el servidor:
				*	POST|GET - determina como se envian los datos al servidor
				*	true - No sincronizado. Ello significa que la página WEB no es interferida en su funcionamiento
				*	por la respuesta del servidor. El usuario puede continuar usando la página mientras el servidor
				*	retorna una respuesta que la actualizará, usualmente, en forma parcial.
				*	false - Sincronizado */
				Conexion.open("POST",Servidor,true);

				// Añade un par etiqueta/valor a la cabecera HTTP a enviar. Si no lo colocamos, no se pasan los parametros.
				Conexion.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		
				// Cada vez que el estado de la conexión (readyState) cambie se ejecutara el contenido de esta "funcion()"
				Conexion.onreadystatechange=function()
				{
					Contenido(idContenido);
				}
				
				date=new Date();
				/* Realiza la solicitud al servidor. Puede enviar una cadena de caracteres, o un objeto del tipo XML
				 * Si no deseamos enviar ningun valor, enviariamos null */
				Conexion.send("idContenido="+idContenido+"&word="+Cadena+"&accion="+accion+"&"+date.getTime());
			}else
				document.getElementById(idContenido).innerHTML="No disponible";
		}
	}

	// Funcion que inicia la busqueda.
	// Tiene que recibir el identificador donde mostrar el listado, y la cadena a buscar
	function autocompletar(idContenido,Cadena,accion)
	{
		//alert(idContenido);
		// Comprobamos que la longitud de la cadena sea superior o igual a 1 caracteres
		if(Cadena.length>=1)
		{
			if(Conexion!=false)
			{
				// Deshabilitamos la visualización del reloj
				//document.getElementById("reloj").style.visibility="hidden";
				//si esta en medio de una conexion, la cancelamos
				Conexion.abort();
				Conexion=false;
			}
			Solicitud(idContenido,Cadena,accion);
		}else
			document.getElementById(idContenido).style.display="none";
	}

	// Funcion que se ejecuta cuando seleccionamos un valor del desplegable
	function selectItem(campo,value,monprc,descripcion)
	{	
		//alert(value); el valor seleccionado
		// Cuando pulsamos sobre el desplegable, colocamos el valor en el cuadro de texto
		document.getElementById("word").value=value;
		document.getElementById("desc").value=descripcion;
		document.getElementById("monprc").value=monprc;
		//document.getElementById('lista').style.visibility="hidden";
		document.getElementById('lista').style.display="none";
		document.getElementById("reloj").style.visibility="hidden";
		Conexion.abort();
		Conexion=false;
		//volvemos a indicar que actualice el listado con el nuevo valor
		autocompletar(campo,value);
	}
function cierra(div)
{
		document.getElementById(div).style.display='none';
}
function messagebox2(cadena)
{	alert(cadena);
	window.opener.location.reload();
	window.close();
	//redireccionar(pagina);
}
//:::::::::::::::::::::::::guardar personas:::::::::::::::::::::::::::::::://

function cd(){
	if (document.getElementById('per_cedula').value == 0){
		}else
		{ced=document.getElementById('per_cedula').value
		autocompletar('respuesta', ced,'cedula');
		}
}

function cd_acta(){
	if (document.getElementById('per_cedula').value == 0){
		}else
		{ced=document.getElementById('per_cedula').value
		autocompletar('ced_acta', ced,'cedula_acta');
		}
}
function num_a(){
	if (document.getElementById('n_acta').value == 0){
		}else
		{ced=document.getElementById('n_acta').value
		autocompletar('num_acta', ced,'numero_acta');
		}
}

function persona(){
	var ced=document.getElementById('per_cedula').value;
	var nom=document.getElementById('per_nom_ape').value;
	var tlf=document.getElementById('per_telf').value;
	var cel=document.getElementById('per_celular').value;
	var dir=document.getElementById('direc').value;
	var mun=document.getElementById('municipio').value;
	if (ced!="" && nom!="" && tlf!="" && cel!="" && dir!="" && mun!=""){
		cadena=	ced+"@"+nom+"@"+tlf+"@"+cel+"@"+dir+"@"+mun;
		//alert(''+cadena);
		autocompletar('respuesta1',cadena,'persona');
		}else{
			alert ('Faltan datos!!!');	
			
			}
	}
	function RIF(){
	if (document.getElementById('rif').value == 0){
		}else
		{riff=document.getElementById('rif').value
		autocompletar('respuesta', riff,'rif');
		}
}

function soloNumeros(evt){
//asignamos el valor de la tecla a keynum
if(window.event){// IE
keynum = evt.keyCode;
}else{
keynum = evt.which;
}
//comprobamos si se encuentra en el rango
if(keynum>47 && keynum<58){
return true;
}else{
return false;
}
}
	function nombre(){
	if (document.getElementById('persona').value == 0){
		}else
		{nomb=document.getElementById('persona').value
		autocompletar('respuesta', nomb,'person');
		}
		}
	function materiales(pos){
		var todo='';
		id_acta=document.getElementById('id_acta').value;
		//alert(pos)
		var elementos=0;
		for(var i = 1; i < pos ; i++ )
		{
			//alert('dentro'+1);
			
			if(document.getElementById('cantidad'+i).value!='')
			{	
				id=document.getElementById('cob_id'+i).value;
				cantidad = document.getElementById('cantidad'+i).value;
				costo = document.getElementById('bs_cover'+i).value;
				total=document.getElementById('total'+i).value;
				cadena=id+'@'+cantidad+'@'+costo+'@'+total;
				todo=todo + '@' + cadena;
			}
		}
		todo=id_acta+todo;
		//alert(todo);
		autocompletar('gua_mat',todo,'gua_materiales');
	}
		
function agregar_material()
{ 	var id_usu=58;
	var acu = document.getElementById('n_mat').value;
	acu = parseFloat(acu) + parseFloat(1);
	document.getElementById('n_mat').value = acu;
	if(acu!=0){
	alert('Los materiales anteriores serán borrados ');
	serial=acu+'@'+id_usu;
	//alert(serial);
	autocompletar('prestamo'+acu , serial ,'prest');
	}
}
//desde aqui comienzan las funciones control_oficios	::::::::::::::::::::::::::::
function buscar_local(){
	if (document.getElementById('sede').value == 0){
		}else
		{loc=document.getElementById('sede').value
		autocompletar('divlocal', loc,'id_sede'); 
		}
}
function proveedor(){
	
	//var ced=document.getElementById('id_prov').value;
	var rif1=document.getElementById('rif').value;
	var nom1=document.getElementById('nombre').value;
	var dir1=document.getElementById('dir').value;
	var tlf1=document.getElementById('tlf').value;
	var tlf2=document.getElementById('tlf2').value;
	if (rif1!="" && nom1!="" && dir1!="" && tlf1!="" && tlf2!=""){
		cadena2=	rif1+"@"+nom1+"@"+dir1+"@"+tlf1+"@"+tlf2;
		//alert(''+cadena2);
		autocompletar('respuesta1',cadena2,'proveedor');
		}else{
			alert ('Faltan datos!!!');	
			
			}
	}
	function ver_ser(){
	if (document.getElementById('ser').value == 0){
		}else
		{riff=document.getElementById('ser').value
		autocompletar('ver_ser2', riff,'servicio_ver');
		}
}