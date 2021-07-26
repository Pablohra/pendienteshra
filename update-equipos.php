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

if(isset($_POST["equipos_new"])){
	$equipos_new = $_POST["equipos_new"];
	$id_equipos = $_POST["id_equipos"];
	$fech_ult_modif_equipos = date("Y-m-d H:i:s");
	
	/*$dni_usu = $_COOKIE['usuario'];*/

	$sql = "UPDATE equipos SET desc_equipos='$equipos_new',fech_ult_modif_equipos='$fech_ult_modif_equipos' WHERE id_equipos='$id_equipos'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT id_equipos FROM equipos WHERE id_equipos='$id_equipos' AND desc_equipos = '$equipos_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:actualizar-equipos.php?msg=ok#msg');
	}else{
		header('Location:actualizar-equipos.php?msg=error#msg');
	}
}
?>
