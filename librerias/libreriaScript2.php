<SCRIPT>
function captTextMarc(){
document.agregarMarca.marc1.value=document.agregarMarca.marc.value;
}

function captTextCarg(){
document.agregarCargo.cargo1.value=document.agregarCargo.carg.value;
}

function captTextEstad(){
document.agregarInventEstado.estado1.value=document.agregarInventEstado.estad.value;
}

function comprobarEstado(str){	    
    if ((document.agregarInventEstado.estad.value=="")){
	document.agregarInventEstado.estad.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.agregarInventEstado.estad.style.backgroundColor="#ffffff";
	}   		
	if ((document.agregarInventEstado.estad.value!="100")&&(document.agregarInventEstado.estad.value!="")){		
	var respuesta=confirm("¿Seguro que Desea Agregar Este Inventario-Estado," + str + "?");	
    if (respuesta==true){	
	document.agregarInventEstado.funcionAgregar.value="1"; 	      
	document.agregarInventEstado.estad.value="";
    document.agregarInventEstado.submit()
	}
	else{
	document.agregarInventEstado.funcionAgregar.value="0"; 
	document.agregarInventEstado.submit()
	}	 
	}
}

function comprobTextModifEstado(){
if ((document.modificarInventEstado.modifiEstado.value=="100")){
	document.modificarInventEstado.modifiEstado.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.modificarInventEstado.modifiEstado.style.backgroundColor="#ffffff";
	}   
if ((document.modificarInventEstado.modifiEstado.value!="100")){
    document.modificarInventEstado.funcionModificar.value="1"; 	      
    document.modificarInventEstado.submit()	
    }
}

function ActualTextModifEstado(str){
if ((document.modifEstado.modifEst.value!="")){		
	var respuesta=confirm("¿Seguro que Desea actualizar el Inventario-Estado, " + str + "?");	
    if (respuesta==true){
	document.modifEstado.funcionModificar.value="2"; 		    
    document.modifEstado.submit()
	document.modifEstado.modifEst.value="";
	}
	else{
	document.modifEstado.funcionModificar.value="0"; 
	document.modifEstado.submit()	
	document.modifEstado.modifEst.value="";}	 
	}
	else{alert("Rellene el Campo");}
}

function EliminarEstado(){	    
    if ((document.eliminarInventEstado.elimEstad.value=="100")||(document.eliminarInventEstado.elimEstad.value==" ")){
	document.eliminarInventEstado.elimEstad.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.eliminarInventEstado.elimEstad.style.backgroundColor="#ffffff";
	}   		
	if ((document.eliminarInventEstado.elimEstad.value!="100")&&(document.eliminarInventEstado.elimEstad.value!=" ")){	
    var respuesta=confirm("¿Seguro que Desea Eliminar Este Inventario-Estado?");
    if (respuesta==true){	
	document.eliminarInventEstado.funcionEliminar.value="1";    	
	document.eliminarInventEstado.submit();
	document.eliminarInventEstado.elimEstad.value="";	
	}	
	else{
	document.eliminarInventEstado.elimEstad.value="";   	
	document.eliminarInventEstado.funcionEliminar.value="0";    	
	document.eliminarInventEstado.submit();
	}
	}
}

function captTextGerenc(){
document.agregarGerencia.gerencia1.value=document.agregarGerencia.gerenc.value;
}
function comprobTextModif(){
if ((document.modificarGerencia.modifiGerenc.value=="100")){
	document.modificarGerencia.modifiGerenc.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.modificarGerencia.modifiGerenc.style.backgroundColor="#ffffff";
	}   
if ((document.modificarGerencia.modifiGerenc.value!="100")){
    document.modificarGerencia.funcionModificar.value="1";     	      
    document.modificarGerencia.submit()	
    }
}
function comprobTextModifCargo(){
if ((document.modificarCargo.modifiCargo.value=="100")){
	document.modificarCargo.modifiCargo.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.modificarCargo.modifiCargo.style.backgroundColor="#ffffff";
	}   
if ((document.modificarCargo.modifiCargo.value!="100")){
    document.modificarCargo.funcionModificar.value="1"; 	      
    document.modificarCargo.submit()	
    }
}

function comprobTextModifMarca(){
if ((document.modificarMarca.modifiMarc.value=="100")){
	document.modificarMarca.modifiMarc.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.modificarMarca.modifiMarc.style.backgroundColor="#ffffff";
	}   
if ((document.modificarMarca.modifiMarc.value!="100")){
    document.modificarMarca.funcionModificar.value="1"; 	      
    document.modificarMarca.submit()	
    }
}

function comprobTextModifModelo(){
if ((document.modificarModelo.modifiModelo.value=="100")){
	document.modificarModelo.modifiModelo.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.modificarModelo.modifiModelo.style.backgroundColor="#ffffff";
	}   
if ((document.modificarModelo.modifiModelo.value!="100")){
    document.modificarModelo.funcionModificar.value="1"; 	      
    document.modificarModelo.submit()	
    }
}

function comprobarMarca(str){	    
    if ((document.agregarMarca.marc.value=="")){
	document.agregarMarca.marc.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.agregarMarca.marc.style.backgroundColor="#ffffff";
	}   		
	if ((document.agregarMarca.marc.value!="100")&&(document.agregarMarca.marc.value!="")){		
	var respuesta=confirm("¿Seguro que Desea Agregar Esta Marca," + str + "?");	
    if (respuesta==true){	
	document.agregarMarca.funcionAgregar.value="1"; 	      
	document.agregarMarca.marc.value="";
    document.agregarMarca.submit()
	}
	else{
	document.agregarMarca.funcionAgregar.value="0"; 
	document.agregarMarca.submit()
	}	 
	}
}

function ActualTextModifGerencia(str){
if ((document.modifGer.modifGeren.value!="")){		
	var respuesta=confirm("¿Seguro que Desea actualizar la Gerencia, " + str + "?");	
    if (respuesta==true){
	document.modifGer.funcionModificar.value="2"; 		    
    document.modifGer.submit()
	document.modifGer.modifGeren.value="";
	}
	else{
	document.modifGer.funcionModificar.value="0"; 
	document.modifGer.submit()	
	document.modifGer.modifGeren.value="";}	 
	}
	else{alert("Rellene el Campo");}
}


function ActualTextModifCargo(str){
if ((document.modifCargo.modifCar.value!="")){		
	var respuesta=confirm("¿Seguro que Desea actualizar Esta Gerencia," + str + "?");	
    if (respuesta==true){	
	document.modifCargo.funcionModificar.value="2";      	
    document.modifCargo.submit()
	document.modifCargo.modifCar.value="";
	}
	else{
	document.modifCargo.funcionModificar.value="0";
	document.modifCargo.submit()	
	document.modifCargo.modifCar.value="";}	 
	}
	else{alert("Rellene el Campo");}
}

function ActualTextModifMarca(str){
if ((document.modifMarc.modifMarca.value!="")){		
	var respuesta=confirm("¿Seguro que Desea actualizar Esta Marca," + str + "?");	
    if (respuesta==true){	
	document.modifMarc.funcionModificar.value="2";      	
    document.modifMarc.submit()
	document.modifMarc.modifMarca.value="";
	}
	else{
	document.modifMarc.funcionModificar.value="0";
	document.modifMarc.submit()	
	document.modifMarc.modifMarca.value="";}	 
	}
	else{alert("Rellene el Campo");}
}

function ActualTextModifModelo(str,str1,str2){
if ((document.modifModelo.modifMod.value!="")){		
	var respuesta=confirm("¿Seguro que Desea actualizar Este Modelo: " + str + "," + str1 + "," + str2 + "?");	
    if (respuesta==true){	
	document.modifModelo.funcionModificar.value="2";      	
    document.modifModelo.submit()
	document.modifModelo.modifMod.value="";
	document.modifModelo.modifCap_Vel.value="";
	document.modifModelo.modifUnid.value!="";
	}
	else{
	document.modifModelo.funcionModificar.value="0";
	document.modifModelo.submit()	
	document.modifModelo.modifMod.value="";
	document.modifModelo.modifCap_Vel.value="";
	document.modifModelo.modifUnid.value!="";
	}	 
	}
	else{alert("Rellene el Campo Modelo");}
}

function comprobarCargo(str){	    
    if ((document.agregarCargo.carg.value=="")){
	document.agregarCargo.carg.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.agregarCargo.carg.style.backgroundColor="#ffffff";
	}   		
	if ((document.agregarCargo.carg.value!="100")&&(document.agregarCargo.carg.value!="")){		
	var respuesta=confirm("¿Seguro que Desea Agregar Este Cargo," + str + "?");	
    if (respuesta==true){	
	document.agregarCargo.funcionAgregar.value="1"; 	      
	document.agregarCargo.carg.value="";
    document.agregarCargo.submit()
	}
	else{
	document.agregarCargo.funcionAgregar.value="0"; 
	document.agregarCargo.submit()
	}	 
	}
}

function comprobarGerencia(str){	    
    if ((document.agregarGerencia.gerenc.value=="")){
	document.agregarGerencia.gerenc.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.agregarGerencia.gerenc.style.backgroundColor="#ffffff";
	}   		
	if ((document.agregarGerencia.gerenc.value!="100")&&(document.agregarGerencia.gerenc.value!="")){		
	var respuesta=confirm("¿Seguro que Desea Agregar la Gerencia," + str + "?");	
    if (respuesta==true){
	//alert ("Gerencia Insertada"); 
	document.agregarGerencia.funcionAgregar.value="1";  	      
    document.agregarGerencia.submit()
	}
	else{	
	document.agregarGerencia.funcionAgregar.value="0"; 
	document.agregarGerencia.submit()
	}	 
	}
}

function comprobarModelo(str){	    
    if ((document.agregarModelo.agregDescrip.value=="100")||(document.agregarModelo.agregMarc.value=="100")||
        (document.agregarModelo.modelo.value=="")){		
    	alert("Existen Campos Vacios Rellenelos");	
	}   		
	 if ((document.agregarModelo.agregDescrip.value!="100")&&(document.agregarModelo.agregMarc.value!="100")&&
         (document.agregarModelo.modelo.value!="")){
	    var respuesta=confirm("¿Seguro que Desea Agregar Este Modelo," + str + "?");	
    if (respuesta==true){
	//alert ("Gerencia Insertada"); 
	document.agregarModelo.funcionAgregar.value="1";  	      
    document.agregarModelo.submit()
	}
	else{	
	document.agregarModelo.funcionAgregar.value="0"; 
	document.agregarModelo.submit()
	}	 
	}
}

function EliminarGerencia(){	    
    if ((document.eliminarGerencia.elimGerenc.value=="100")||(document.eliminarGerencia.elimGerenc.value==" ")){
	document.eliminarGerencia.elimGerenc.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.eliminarGerencia.elimGerenc.style.backgroundColor="#ffffff";
	}   		
	if ((document.eliminarGerencia.elimGerenc.value!="100")&&(document.eliminarGerencia.elimGerenc.value!=" ")){	
    var respuesta=confirm("¿Seguro que Desea Eliminar la Gerencia?");
    if (respuesta==true){
	document.eliminarGerencia.funcionEliminar.value="1";
	//alert ("Gerencia Eliminada"); 	    	
	document.eliminarGerencia.submit()
	document.eliminarGerencia.elimGerenc.value=="";		
	}  
	else{	
	document.eliminarGerencia.elimGerenc.value="";
	document.eliminarGerencia.funcionEliminar.value="0";
	document.eliminarGerencia.submit()
	}    	
	}		
}

function EliminarCargo(){	    
    if ((document.eliminarCargo.elimCarg.value=="100")||(document.eliminarCargo.elimCarg.value==" ")){
	document.eliminarCargo.elimCarg.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.eliminarCargo.elimCarg.style.backgroundColor="#ffffff";
	}   		
	if ((document.eliminarCargo.elimCarg.value!="100")&&(document.eliminarCargo.elimCarg.value!=" ")){	
    var respuesta=confirm("¿Seguro que Desea Eliminar Este Cargo?");
    if (respuesta==true){	
	document.eliminarCargo.funcionEliminar.value="1";    	
	document.eliminarCargo.submit();
	document.eliminarGerencia.elimCarg.value="";	
	}	
	else{
	document.eliminarCargo.elimCarg.value="";   	
	document.eliminarCargo.funcionEliminar.value="0";    	
	document.eliminarCargo.submit();
	}
	}
}

function EliminarMarca(){	    
    if ((document.eliminarMarca.elimMarc.value=="100")||(document.eliminarMarca.elimMarc.value==" ")){
	document.eliminarMarca.elimMarc.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.eliminarMarca.elimMarc.style.backgroundColor="#ffffff";
	}   		
	if ((document.eliminarMarca.elimMarc.value!="100")&&(document.eliminarMarca.elimMarc.value!=" ")){	
    var respuesta=confirm("¿Seguro que Desea Eliminar Esta Marca?");
    if (respuesta==true){	
	document.eliminarMarca.funcionEliminar.value="1";    	
	document.eliminarMarca.submit();
	document.eliminarMarca.elimMarc.value="";	
	}	
	else{
	document.eliminarMarca.elimMarc.value="";   	
	document.eliminarMarca.funcionEliminar.value="0";    	
	document.eliminarMarca.submit();
	}
	}
}

function EliminarModelo(){	    
    if ((document.eliminarModelo.elimMod.value=="100")||(document.eliminarModelo.elimMod.value=="")){
	document.eliminarModelo.elimMod.style.backgroundColor="#ccffff";	
	alert("Rellene el Campo");
	document.eliminarModelo.elimMod.style.backgroundColor="#ffffff";
	}   		
	if ((document.eliminarModelo.elimMod.value!="100")&&(document.eliminarModelo.elimMod.value!="")){	
    var respuesta=confirm("¿Seguro que Desea Eliminar Este Modelo?");
    if (respuesta==true){	
	document.eliminarModelo.funcionEliminar.value="1";    	
	document.eliminarModelo.submit();
	document.eliminarModelo.elimMod.value="";	
	}	
	else{
	document.eliminarModelo.elimMod.value="";   	
	document.eliminarModelo.funcionEliminar.value="0";    	
	document.eliminarModelo.submit();
	}
	}
}

function fecha(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[0-9/]/; // Solo acepta letras 
	te = String.fromCharCode(tecla); 
    return patron.test(te); 
}  
function Letras(e) { 
    tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[A-Za-z. ñÑ]/; // Solo acepta letras 
	te = String.fromCharCode(tecla); 
    return patron.test(te); 
}  

function Numero(e){ 
tecla = (document.all) ? e.keyCode : e.which; 
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar) 
    patron =/[0-9.A-Za-z ]/; // Solo numeros y el punto 
	te = String.fromCharCode(tecla); 
    return patron.test(te); 
}	
</SCRIPT>