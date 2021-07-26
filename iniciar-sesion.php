<?php
require_once('configuracion.php');

/* inicia sesión creando una cookie */
$login = textfilter($_POST[usuario]);
$password = md5(valcontra($_POST[contrasena]));

$consulta="SELECT dni_usu FROM usuario WHERE user_usu='$login' AND passw_usu='$password'";
$respuesta=mysqli_query($connect,$consulta);

if($fila=mysqli_fetch_array($respuesta)){
	$id = $fila[0];
	setcookie('usuario',$id,time() + 3*86400);
	header('Location:index.php#selname');
}else{
	header('Location:index.php?msg=error');
}
?>
