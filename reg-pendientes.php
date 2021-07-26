<?php
/*
 * Import generic data
 */
require_once('configuracion.php');
/*
 * registra los datos del nuevo usuario
 * recibe datos desde 'registrar-usuario.php'
 */ 
mysqli_set_charset($connect, "utf8mb4");

$dni_usu = textfilter($_POST['dni_usu']);
$fecha_pend = date("Y-m-d H:i:s");
$desc_pend = $_POST['pendiente'];
//$priori_pend = textfilter($_POST['prioridad']);
$priori_pend = "";
$realizado_pend = "no";

/* ingresa los datos a la BD */

$sql="INSERT INTO pendiente (id_pend,dni_usu,fecha_pend,desc_pend,priori_pend,realizado_pend,realizado_por_pend) 
		VALUE (NULL,'$dni_usu','$fecha_pend','$desc_pend','$priori_pend','$realizado_pend',NULL)";
mysqli_query($connect,$sql);

/* verifica si se guardaron los datos */
$consulta="SELECT dni_usu FROM pendiente WHERE dni_usu='$dni_usu' AND fecha_pend='$fecha_pend'";
$respuesta=mysqli_query($connect,$consulta);

if($fila=mysqli_fetch_array($respuesta)){
	header('Location:registrar-pendientes.php?msg=ok#msg');
}else{
	header('Location:registrar-pendientes.php?msg=error#msg');
}
?>
