<SCRIPT>
<!-- Comienza el script
   
var iscomplete=false

function verificarCampos() {
	iscomplete=true
	for (i=0;i<=document.agregarUsuario.elements.length-1;i++) {
		if (document.agregarUsuario.ficha.value=="")  {iscomplete=false}
		if (document.agregarUsuario.cedula.value=="") {iscomplete=false}
		if (document.agregarUsuario.nombre.value=="") {iscomplete=false}
		if (document.agregarUsuario.apellido.value=="") {iscomplete=false}
		if (document.agregarUsuario.extension.value=="") {iscomplete=false}
		if (document.agregarUsuario.cargo.value=="1") {iscomplete=false}
		if (document.agregarUsuario.gerencia.value=="1"){iscomplete=false}
		if (document.agregarUsuario.division.value=="1"){iscomplete=false}
		if (document.agregarUsuario.departamento.value=="1"){iscomplete=false}
		if (document.agregarUsuario.sitio.value=="1"){iscomplete=false}
		
	}
	if (!iscomplete) {
		window.status="Por Favor, Rellene Todos los Campos del Formulario"
		if (document.all) {
			submitbutton.style.visibility="HIDDEN"
			iscomplete=false
		}
		if (document.layers) {
			document.insertarUsuario.submitbutton.value="NOT YET"
			iscomplete=false
		}
	}
	if (iscomplete) {
		window.status="Estan rellenos todos los campos"
		if (document.all) {
			submitbutton.style.visibility="VISIBLE"
			iscomplete=true
		}
		if (document.layers) {
			document.insertarUsuario.submitbutton.value="NOW"
			iscomplete=true
		}
	}
	
	var timer= setTimeout("checkform()",200)
}
//Final del Script 
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Función para almacenar en el campo de texto solo numeros 
function soloNumero(){ 
var key=window.event.keyCode;//codigo de tecla. 
 if (key < 48 || key > 57){//si no es numero  
    window.event.keyCode=0;//anula la entrada de texto. 
 }
} 
//Función para almacenar en el campo de texto solo numeros 
function soloLetras(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[A-Za-z]/; // Solo acepta letras 
    te = String.fromCharCode(tecla); 
    return patron.test(te); 
} 

function suministrar() {
	return iscomplete
}
//Final del Script 

</SCRIPT>


