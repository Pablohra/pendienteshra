<?php
/*
 * Import generic data
 */
require_once('configuracion.php');
/*
 * registra los datos del nuevo usuario
 * recibe datos desde 'registrar-usuario.php'
 */ 
/*mysqli_query ("SET NAMES 'utf8'");*/
mysqli_set_charset($connect, "utf8");

$dni = textfilter($_POST['dni']);
$usuario = textfilter_specialchars($_POST['usuario']);
$password=md5(valcontra($_POST['contrasena']));
$nombres = textfilter_specialchars($_POST['nombres']);
$apellidos = textfilter_specialchars($_POST['apellidos']);
$celular = textfilter($_POST['celular']);
$correo=textfilter_specialchars($_POST['correo']);
$fecha_reg_usu = date('Y-m-d g:i:s');
$user_reg_usu = textfilter($_COOKIE['usuario']);
$activo = textfilter($_POST['activo']);

/* ingresa los datos a la BD */
$sql="INSERT INTO usuario (dni_usu,user_usu,passw_usu,nombres_usu,apellidos_usu,celular_usu,correo_usu,fecha_reg_usu,user_reg_usu,activo_usu) 
		VALUE ('$dni','$usuario','$password','$nombres','$apellidos','$celular','$correo','$fecha_reg_usu','$user_reg_usu','$activo')";
mysqli_query($connect,$sql);

/* verifica si se guardaron los datos */
$consulta="SELECT dni_usu FROM usuario WHERE dni_usu='$dni'";
$respuesta=mysqli_query($connect,$consulta);

if($fila=mysqli_fetch_array($respuesta)){
	header('Location:registrar-usuario.php?msg=ok#msg');
}else{
	header('Location:registrar-usuario.php?msg=error#msg');
}
?>
