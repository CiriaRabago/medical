var ___d = "0369CF";
function ponColor(r,g,b)	{
	return "#" + ___d.charAt(r) + ___d.charAt(r) + ___d.charAt(g) + ___d.charAt(g) + ___d.charAt(b) + ___d.charAt(b);
}

function asignaColor(elemento)	{
	donde = elemento.substr(0, elemento.length - 6);
	color = elemento.substr(donde.length);
	window["metodo" + donde](color);
	__elemento = window["color" + donde];
	if (document.getElementById(donde + __elemento.substr(1)))
		document.getElementById(donde + __elemento.substr(1)).style.borderStyle = "solid";
	window["color" + donde] = "#" + color;
	document.getElementById(elemento).style.borderStyle = "inset";
	document.getElementById("muestra" + donde).style.backgroundColor = "#" + color;
	if (document.all)	event.returnValue = false;
}

function activaColor(idBase, color)	{
	document.getElementById(idBase + window["color" + idBase].substr(1)).style.borderStyle = "solid";
	document.getElementById(idBase + color.substr(1)).style.borderStyle = "inset";
	document.getElementById("muestra" + idBase).style.backgroundColor = color;
	window["color" + idBase] = color;
}

function ponerPaleta(idBase, tamCelda, color)	{
	var tamCeldaMax = tamCelda + 4;// añadimos 2 pixeles por lado para el borde
	var alto = tamCeldaMax * 6;
	var ancho = alto * 7;
	var digitos = "0369CF";
	var estilosContenedor = "margin: auto; border: 1px solid gray; position: relative; width:" + (ancho + 8);
	estilosContenedor += "px; height: " + (alto + 4) + "px";
	document.writeln("<div style='" + estilosContenedor + "' >");
	var estilosCelda = "position: absolute; overflow: hidden; cursor: pointer; ";
	estilosCelda += "; margin: 0; width: " + tamCeldaMax + "px; height: " + tamCeldaMax + "px; ";
	for (var i = 0, total = digitos.length; i < total; i ++)
		for (var j = 0; j < total; j ++)
			for (var k = 0; k < total; k ++)	{
			esteColor = ponColor(i, j, k);
			esteBorde = (esteColor == color) ? "2px inset #eeeeee" : "2px solid #eeeeee";
			document.writeln("<div style='" + estilosCelda);
			document.writeln("; left: " + (((i * total) + j) * tamCeldaMax) + "px;");
			document.writeln("top: " + (k * tamCeldaMax) + "px;");
			document.writeln(" border: " + esteBorde);
			document.writeln("; background-color: " + esteColor);

			document.write("' title='");
			document.write(esteColor.substr(1));
			document.write("' onclick='asignaColor(this.id)'");
			document.write(" id='" + idBase + esteColor.substr(1) + "'");
			document.writeln("></div>\n");
	}
	var estilosMuestra = "width: " + (alto - 2) + "px; height:" + (alto - 2) + "px; background-color: ";
	estilosMuestra += color + "; top: 2px; left: " + (ancho - alto + 6) + "px; border: 1px solid black; position: absolute";
	document.writeln("<div id='muestra" + idBase + "' style='" + estilosMuestra + "'></div>");
	document.writeln("</div>");
}
/*
function tipoPaleta(columnas, proporcional)	{
	// proporcional = true: rectangular ... false: del ancho del bloque
	columnasTemp = (columnas > 6) ? 6 : columnas
	this.filas = parseInt(6 / columnasTemp);
	this.columnas = 6 / this.filas;
	this.proporcional = proporcional;
}
*/

function ponerPaleta2(idBase, tamCelda, color, columnas, proporcional, mostrar)	{

	function tipoPaleta(columnas, proporcional)	{
		// proporcional = true: rectangular ... false: del ancho del bloque
		columnasTemp = (columnas > 6) ? 6 : columnas
		this.filas = parseInt(6 / columnasTemp);
		this.columnas = 6 / this.filas;
		this.proporcional = proporcional;
	}

	tipo = new tipoPaleta(columnas, proporcional);
	var tamCeldaMax = tamCelda + 4;// añadimos 2 pixeles por lado para el borde
	var bloque = tamCeldaMax * 6;
	var alto = bloque * tipo.filas;
	var ancho = bloque * tipo.columnas + 4;

	var estilosContenedor = "margin: auto; border: 1px solid gray; position: relative; width: ";
	estilosContenedor += (!mostrar) ? ancho : (tipo.proporcional) ? (ancho + alto + 2) : (ancho + bloque + 4);
	estilosContenedor += "px; height: ";
	estilosContenedor += (alto + 4) + "px";

	var estilosVisor = (mostrar) ? "display: block; " : "display: none; ";
	estilosVisor += "position: absolute; border: 1px solid gray; background-color: ";
	estilosVisor += color;
	estilosVisor += "; width: ";
	estilosVisor += (tipo.proporcional) ? (alto - 2) : bloque;
	estilosVisor += "px; height: ";
	estilosVisor += (true) ? (alto - 2) : bloque;
	estilosVisor += "px; top: ";
	estilosVisor += (true) ? 2 : bloque;
	estilosVisor += "px; left: ";
	estilosVisor += (true) ? ancho : bloque;
	estilosVisor += "px; ";
	var salida = "";
	var posX, posY, _i, _j;
	var digitos = "0369CF";
	salida += "<div style='" + estilosContenedor + "' >";
	var estilosCelda = "position: absolute; overflow: hidden; cursor: pointer; ";
	estilosCelda += "margin: 0; width: " + tamCeldaMax + "px; height: " + tamCeldaMax + "px; ";
	for (var i = 0, total = digitos.length; i < total; i ++)	{

		_j = (i % tipo.filas);
		_i = parseInt(i / tipo.filas);

		for (var j = 0; j < total; j ++)	{
			for (var k = 0; k < total; k ++)	{

				posX = (k * tamCeldaMax) + _i * bloque;
				posY = (j * tamCeldaMax) + (_j * bloque);
				esteColor = ponColor(5 - i, 5 -  j, 5 - k);
				esteBorde = (esteColor == color) ? "2px inset #eeeeee" : "2px solid #eeeeee";
				salida += "\n<div style='" + estilosCelda;
				salida += "left: " + posX + "px; ";
				salida += "top: " + posY + "px;";
				salida += " border: " + esteBorde;
				salida += "; background-color: " + esteColor;

				salida += "' title='";
				salida += esteColor.substr(1);
				salida += "' onclick='asignaColor(this.id)'";
				salida += " id='" + idBase + esteColor.substr(1) + "'";
				salida += "></div>\n";
			}
		}
	}
	salida += "<div id='muestra" + idBase + "' style='" + estilosVisor + ";'></div>";
	salida += "</div>";
	return salida;
}
