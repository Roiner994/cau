<?php
/*echo "<form name=\"form1\" method=\"post\" action=\"\">
<table width=\"340\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"1\">
<tr> 
<td width=\"12\" bgcolor=\"#E3E3E3\"><input type=\"checkbox\" name=\"checkbox\" value=\"checkbox\">&nbsp;Musica</td>
</tr>
<tr> 
<td bgcolor=\"#F0F0F0\"><input type=\"checkbox\" name=\"checkbox2\" value=\"checkbox\">&nbsp;Cine</td>
</tr>
<tr> 
<td bgcolor=\"#E3E3E3\"><input type=\"checkbox\" name=\"checkbox3\" value=\"checkbox\">&nbsp;Television</td>
</tr>
<tr> 
<td bgcolor=\"#F0F0F0\"><input type=\"checkbox\" name=\"checkbox4\" value=\"checkbox\">&nbsp;Teatro </td>
</tr>
<tr> 
<td bgcolor=\"#E3E3E3\"><input type=\"checkbox\" name=\"checkbox5\" value=\"checkbox\">&nbsp;Tecnologia</td>
</tr>
<tr> 
<td bgcolor=\"#F0F0F0\"><input type=\"checkbox\" name=\"checkbox6\" value=\"checkbox\">&nbsp;Entretenimiento</td>
</tr>
<tr> 
<td bgcolor=\"#E3E3E3\"><input type=\"checkbox\" name=\"checkbox7\" value=\"checkbox\">&nbsp;Literatura</td>
</tr>
<tr> 
<td bgcolor=\"#F0F0F0\"><input type=\"checkbox\" name=\"checkbox8\" value=\"checkbox\">&nbsp;Internet</td>
</tr>
<tr> 
<td bgcolor=\"#E3E3E3\"><input type=\"checkbox\" name=\"checkbox9\" value=\"checkbox\">&nbsp;Video Juegos</td>
</tr>
<tr> 
<td bgcolor=\"#F0F0F0\"><input type=\"checkbox\" name=\"checkbox10\" value=\"checkbox\">&nbsp;Turismo </td>
</tr>
<tr> 
<td bgcolor=\"#FFFFCC\"><input type=\"checkbox\" name=\"checkbox11\" value=\"checkbox\" onClick=\"ChequearTodos(this);\">&nbsp;Todos</td>
</tr>
</table>
</form>
<td bgcolor=\"#FFFFCC\"><input type=\"checkbox\" name=\"checkbox11\" value=\"checkbox\" onClick=\"ChequearTodos(this);\">&nbsp;Todos</td>";
*/?>

<script language="javascript">
/*function ChequearTodos(chkbox){
for (var i=0;i < document.forms[0].elements.length;i++){
var elemento = document.forms[0].elements[i];
if (elemento.type == "checkbox"){
elemento.checked = chkbox.checked
}
}
}*/
</script>

<script language="JavaScript">
function A(ff)
{
var data, err=0, num="", inum="", errTx="Fechas no validas.",errL;
errL=errTx.length;
var f=new Array;
var g=new Array;
f[0]=ff.f1.value;f[1]=ff.f2.value;
/*f[0]="01/08/2004";f[1]="13/08/2004";
f[2]="16/08/2004";f[3]="29/08/2004";*/
for(var i=0;i<f.length;i++)
 {
 data=f[i];
 for(var k=0;k<=data.length;k++)
  {
  if(data.substring(k,k+1)*1 == data.substring(k,k+1))
   {
   inum+=data.substring(k,k+1);
   }
  else
   {
   num=inum+num;
   inum="";
   }
  }
 num=inum+num;
 g[i]=num;
 num="";inum="";
 }
/*
if(g[0] < g[1] && g[1] < g[2] && g[2] < g[3])
 {alert("valido");}
else {alert("no valido");}
*/
for(i=0;i<g.length;i++)
 {
 if(g[i+1] && (g[i] > g[i+1]))
  {
  errTx+=f[i]+" mayor que "+f[i+1]+".";
  }
 }
if(errTx.length > errL)
 {alert(errTx);}
else
 {alert("validas");}
}
</script>


<?php 
echo "<html><head>
</head><body><form name=\"a\"><pre>
Fecha 1:
<input type=\"text\" name=\"f1\" value=\"01/08/2004\">
Fecha 2:
<input type=\"text\" name=\"f2\" value=\"13/08/2004\">
<input type=\"button\" name=\"comp\" value=\"COMPARAR\" onClick=\"A(this.form);\">
</pre></form></body></html>";
?>
