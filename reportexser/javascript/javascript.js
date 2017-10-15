// JavaScript Document
//FUNCION PARA DIRECCIONAR PAGINAS
function redireccionar(page)
{
location.href=page;
}
//FUNCION PARA CAJA DE MENSAJES
function messagebox(cadena,pagina)
{	alert(cadena);
	redireccionar(pagina);
}
function messagebox2(cadena)
{	alert(cadena);
	window.opener.location.reload();
	window.close();
	//redireccionar(pagina);
}
function messagebox3(cadena)
{	alert(cadena);
	window.close();
	//redireccionar(pagina);
}
//FUNCION DE MENSAJERIA
function mensaje(mensaje)
{
	alert(mensaje);
	return;
}
//COMPARA LOS VALORES DEL PASSWORD
function compara_password(valor1,valor2)
{
	if (valor1.value != valor2.value)
	{
			mensaje(mensajeError['diferentes']);
			valor1.value="";
			valor1.focus();
			valor1.select();
			valor2.value="";
			valor2.focus();
			valor2.select();
	}
}
//**************************************************
//VALIDACION DEL FORMULARIO SECUNDARIO
//**************************************************
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' Debe ser Numérico por Favor Corrija.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es Necesario.\n'; }
  } if (errors) alert('Han Ocurrido Los Siguientes Errores:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
//**************************************************
/*function modificar_tabla_a(ide){ 
var url='pop_modificar_tabla_a.php?ide='+ide; 
window.open(url,'','top=455,left=820,width=238,height=104'); 
}*/
/*function agregar_tabla_a(){ 
var url='pop_agregar_tabla_a.php'; 
window.open(url,'','top=455,left=420,width=238,height=104'); 
}
function agregar_tabla_b(){ 
var url='pop_agregar_tabla_b.php'; 
window.open(url,'','top=455,left=420,width=238,height=104'); 
}
function ver_curriculum(id){
var url='rpt_curriculum.php?id='+id;
window.open(url,'','top=250,left=180');
}*/
function imprimir(objeto){
	
	mostrar(objeto,0);
	window.print();
	mostrar(objeto,1);

}
/*function mostrar(objeto,accion)
{
	if(accion)
		document.getElementById(objeto).style.visibility="visible";
	else
		document.getElementById(objeto).style.visibility="hidden";
}*/
function Validar_Combos (combo1,combo2,combo3,combo4,combo5)
{
	if(combo1.value == 0 || combo2.value == 0 || combo3.value == 0 || combo4.value == 0 || combo5.value == "--SELECCIONE--")
	{
		messagebox("Quedaron Elementos Sin Seleccionar Por Favor Corrija...","frm_moto_caracteristicas.php")
	}
}

/*function validar_caracter(campo)
{
	if (campo.value == "Ñ" || campo.value == "I" || campo.value == "O" || campo.value == "Q")
	{
		campo.value = "";
		campo.focus();
		campo.select();
		alert("Caracter Invalido Porfavor Corrija...");
	}
	
}*/
//****************SCRIPT DEL MENU DE DIRECTORIOS***********************
/*img1=new Image()
img1.src="../imagenes/fold.gif"
img2=new Image()
img2.src="../imagenes/open.gif"
ns6_index=0*/

/*function change(e){

if(!document.all&&!document.getElementById)
return

if (!document.all&&document.getElementById)
ns6_index=1

var source=document.getElementById&&!document.all? e.target:event.srcElement
if (source.className=="folding"){
var source2=document.getElementById&&!document.all? source.parentNode.childNodes:source.parentElement.all
if (source2[2+ns6_index].style.display=="none"){
source2[0].src="../imagenes/open.gif"
source2[2+ns6_index].style.display=''
}
else{
source2[0].src="../imagenes/fold.gif"
source2[2+ns6_index].style.display="none"
}
}
}
document.onclick=change
//*************************
*/
