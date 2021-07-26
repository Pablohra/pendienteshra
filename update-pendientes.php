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

if(isset($_POST["pendiente_new"])){
	$pendiente_new = $_POST["pendiente_new"];
	$id_pend = $_POST["id_pend"];
	$fecha_ulti_modifi = date("Y-m-d H:i:s");
	
	/*$dni_usu = $_COOKIE['usuario'];*/

	$sql = "UPDATE pendiente SET desc_pend='$pendiente_new',fecha_ulti_modifi='$fecha_ulti_modifi' WHERE id_pend='$id_pend'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT id_pend FROM pendiente WHERE id_pend='$id_pend' AND desc_pend = '$pendiente_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:registrar-pendientes.php#msgpend');
	}else{
		header('Location:registrar-pendientes.php#msgpend');
	}
}
if(isset($_POST["prioridad_new"])){
	$prioridad_new = $_POST["prioridad_new"];
	$id_pend = $_POST["id_pend"];
	$fecha_ulti_modifi = date("Y-m-d H:i:s");
	
	/*$dni_usu = $_COOKIE['usuario'];*/

	$sql = "UPDATE pendiente SET priori_pend='$prioridad_new',fecha_ulti_modifi='$fecha_ulti_modifi' WHERE id_pend='$id_pend'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT id_pend FROM pendiente WHERE id_pend='$id_pend' AND desc_pend = '$prioridad_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:registrar-pendientes.php#msgpend');
	}else{
		header('Location:registrar-pendientes.php#msgpend');
	}
}
?>
