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

$realizado=$_POST["realizado"];
$count = count($realizado);

for ($i = 0; $i < $count; $i++) {
	/*echo $realizado[$i];*/
	/* ingresa los datos a la BD */
	$id_pend = $realizado[$i];
	$fecha_realizado_por = date('Y-m-d H:i:s');
	$dni_usu = $_COOKIE['usuario'];	
	
	$sql = "UPDATE pendiente SET realizado_pend='no',fecha_realizado_por='$fecha_realizado_por',fecha_ulti_modifi='$fecha_realizado_por' WHERE id_pend='$id_pend'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT id_pend,realizado_pend FROM pendiente WHERE id_pend='$id_pend' AND realizado_pend = 'no'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:update-pend-realizados.php?msg=ok#msg');
	}else{
		header('Location:update-pend-realizados.php?msg=error#msg');
	}
}

?>
