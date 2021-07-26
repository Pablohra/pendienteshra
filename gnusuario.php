<?php
/* genera el nombre del usuario para mostrarlo en el front-end */
require_once('configuracion.php');
if(isset($_COOKIE['usuario'])){	
	$consulta="SELECT user_usu FROM usuario WHERE dni_usu='$_COOKIE[usuario]'";
	$respuesta=mysqli_query($connect,$consulta);
	if($fila=mysqli_fetch_array($respuesta)){
		$login = $fila[0];
	}
	print $login;
}else{
	header('location:index.php');
	}
?>
