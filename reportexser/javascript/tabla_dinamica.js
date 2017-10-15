// JavaScript Document
function addRow(){
  //get the table
  var table = document.getElementById('coberturas');
  
  //get the number of rows currently in the table
  var numRows = table.rows.length;
  //insert a new row at the bottom
  var newRow = table.insertRow(numRows);  
  //pos = numRows + 1;
  pos = parseInt(document.form1.posicion.value) + 1;
  document.form1.posicion.value = pos;
  //create new cells
  var newCell0 = newRow.insertCell(0);
  var newCell1 = newRow.insertCell(1);
  var newCell2 = newRow.insertCell(2);
  var newCell3 = newRow.insertCell(3);
  var newCell4 = newRow.insertCell(4);
 // alert(pos);
  //set the cell text
  newCell0.innerHTML = "&nbsp;";
  newCell1.innerHTML = "<input name=\"dsc_cover"+pos+"\" type=\"text\" class=\"cuadros_de_texto\" id=\"dsc_cover"+pos+"\" size=\"70\" />";
  newCell2.innerHTML = "<div align=\"center\"><input name=\"bs_cover"+pos+"\" type=\"text\" class=\"input_numerico\" id=\"bs_cover"+pos+"\" size=\"14\" onBlur=\"this.value = NumberFormat(this.value, '2', '.', ',')\"/></div>"; 
  newCell3.innerHTML = "<div align=\"center\"><input name=\"deducible"+pos+"\" type=\"text\" class=\"input_numerico\" id=\"deducible"+pos+"\" size=\"14\" onBlur=\"this.value = NumberFormat(this.value, '2', '.', ',')\"/></div>";
  newCell4.innerHTML = "<img src=\"../imagenes/quitar.jpeg\" width=\"22\" height=\"22\" style=\"cursor:pointer\" onclick=\"javascript:deleteRow("+pos+");\" />";
}
function deleteRow(position){
  //get the table
  
  var table = document.getElementById('coberturas');  
  posi = parseInt(document.form1.posicion.value);  
  pos = parseInt(document.form1.posicion.value) - 1;
  if(pos >= 0)
	 	  document.form1.posicion.value = pos;
  //delete the last row
  if(position > 1)
  {
  	/*  var union = 'cantidad'+posi;
	  cantidad = document.getElementById(union).value;	
	  var union2 = 'desequi'+posi;
	  costo = document.getElementById(union2).value;	*/
	//alert(table.rows.length);
	if(table.rows.length <= position )
	{
		position = table.rows.length - 1;
		}
		
      table.deleteRow(position);
  }else
  {
  	alert("NO PUEDE ELIMINAR MAS FILAS");
  }	
}
//--------------------------------------------------------------//--------------------------------------------------------------------
function addfila(ultimo){

  var table = document.getElementById('coberturas');
  
  //get the number of rows currently in the table
  var numRows = table.rows.length - 1;
  //insert a new row at the bottom
  var newRow = table.insertRow(numRows);  
  //pos = numRows + 1;
  pos = document.getElementById('posicion').value;
  //document.form1.posicion.value = pos;
  
  
  //create new cells
  var newCell0 = newRow.insertCell(0);
  var newCell1 = newRow.insertCell(1);
  var newCell2 = newRow.insertCell(2);
  var newCell3 = newRow.insertCell(3);
  var newCell4 = newRow.insertCell(4);

 // alert(pos);
  //set the cell text
  newCell0.innerHTML = "&nbsp;";
  newCell1.innerHTML = "<input type=\"hidden\" name=\"cob_id"+pos+"\" id=\"cob_id"+pos+"\"/><input name=\"dsc_cover"+pos+"\" type=\"text\" class=\"cuadros_de_texto\" id=\"dsc_cover"+pos+"\" size=\"70\" />";
  newCell2.innerHTML = "<div align=\"center\"><input name=\"unidad"+pos+"\" type=\"text\" class=\"cuadros_de_texto\" id=\"unidad"+pos+"\" size=\"14\" onBlur=\"this.value = NumberFormat(this.value, '2', '.', ',')\"/></div>";
  newCell3.innerHTML = "<div align=\"center\"><input name=\"bs_cover"+pos+"\" type=\"text\" class=\"input_numerico\" id=\"bs_cover"+pos+"\" size=\"14\" onBlur=\"this.value = NumberFormat(this.value, '2', '.', ',')\"/></div>"; 
  newCell4.innerHTML = "<img src=\"../imagenes/quitar.jpeg\" width=\"22\" height=\"22\" style=\"cursor:pointer\" onclick=\"javascript:borrarLinea("+pos+");\" />";
}
function deletefila(tabla)
{
  var table = document.getElementById(tabla);
  var ultima_fila = table.rows.length;
 //pos = parseInt(document.getElementById('posicion').value);
  //document.getElementById('posicion').value = pos - 1;
  if(table.rows.length > 1)
    table.deleteRow(ultima_fila-2);
}
function borrarLinea(pos)
{ 	
	var table = document.getElementById('coberturas');
	var numRowsT = table.rows.length;
	var numRowsP = numRowsT - 3;
	if(numRowsP > 2)
	//alert(numRowsP); //tinene +2 al numero de la ultima fila
	{
	posotro = parseInt(pos);
    for(var i = posotro; i < numRowsP - 1; i++)
	{
	var desde = parseFloat(i) + 1;
	var hasta = parseFloat(i);
	var unionCambiarDesde1 = 'cob_id'+desde;
	var unionCambiarHasta1 = 'cob_id'+hasta;
	document.getElementById(unionCambiarHasta1).value = document.getElementById(unionCambiarDesde1).value;
	
	unionCambiarDesde1 = 'dsc_cover'+desde;
	unionCambiarHasta1 = 'dsc_cover'+hasta;
	document.getElementById(unionCambiarHasta1).value = document.getElementById(unionCambiarDesde1).value;
	
	unionCambiarDesde1 = 'bs_cover'+desde;
	unionCambiarHasta1 = 'bs_cover'+hasta;
	document.getElementById(unionCambiarHasta1).value = document.getElementById(unionCambiarDesde1).value;
	}
	deletefila('coberturas');
	}
}
function actualiza_posicion()
{
	var table = document.getElementById('coberturas');
	var filas = table.rows.length - 2;
	document.form1.posicion.value = filas;
	
	}
