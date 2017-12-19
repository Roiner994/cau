<?
switch($funcion) {	
	case 1:	
	if (isset($_POST[textarea1]) && (empty($_POST[textarea1])) {		
		if ($sw==1) {			
			$mensaje=$mensaje."<b>,</b>";
		}		
		$mensaje=$mensaje."<b>Área</b>";
		$i++;
		$sw=1;
	}
?>
<form method="post" action="">
<input name="funcion" type="hidden" value="1">
<textarea name="textarea1" rows=2 cols=15>$_POST[textareal]</textarea>
<input type="submit" value="prueba">
</form>

<input name="rer" type="text" size="10" maxlength="5">

<p>&nbsp;</p>
<p>&nbsp;</p>
