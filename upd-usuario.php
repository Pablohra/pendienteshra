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

if(isset($_POST["dni_new"])){
	$dni_usu = $_POST["dni_usu"];
	$dni_new = $_POST["dni_new"];	

	$sql = "UPDATE usuario SET dni_usu='$dni_new' WHERE dni_usu='$dni_usu'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT dni_usu FROM usuario WHERE dni_usu='$dni_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:update-usuario.php#msgupdusu');
	}else{
		header('Location:update-usuario.php#msgupderror');
	}
}
if(isset($_POST["names_new"])){
	$dni_usu = $_POST["dni_usu"];
	$names_pers = textfilter_specialchars($_POST["names_new"]);	
	$n = substr_count($names_pers, ",");
	if($n > 0){
		$names_pers = explode(", ",$names_pers);
		$apellidos_new = $names_pers[0];
		$nombres_new = $names_pers[1];		
		$cons_dni = "UPDATE usuario SET apellidos_usu='$apellidos_new',nombres_usu='$nombres_new' WHERE dni_usu='$dni_usu'";
		$resp_dni = mysqli_query($connect,$cons_dni);
	}	
	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT dni_usu FROM usuario WHERE dni_usu='$dni_usu' AND apellidos_usu='$apellidos_new' AND nombres_usu='$nombres_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:update-usuario.php#msgupdusu');
	}else{
		header('Location:update-usuario.php#msgupderror');
	}
}
if(isset($_POST["celular_new"])){
	$dni_usu = $_POST["dni_usu"];
	$celular_new = $_POST["celular_new"];

	$sql = "UPDATE usuario SET celular_usu='$celular_new' WHERE dni_usu='$dni_usu'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT dni_usu FROM usuario WHERE dni_usu='$dni_usu' AND celular_usu='$celular_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:update-usuario.php#msgupdusu');
	}else{
		header('Location:update-usuario.php#msgupderror');
	}
}
if(isset($_POST["correo_new"])){
	$dni_usu = $_POST["dni_usu"];
	$correo_new = $_POST["correo_new"];

	$sql = "UPDATE usuario SET correo_usu='$correo_new' WHERE dni_usu='$dni_usu'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT dni_usu FROM usuario WHERE dni_usu='$dni_usu' AND correo_usu='$correo_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:update-usuario.php#msgupdusu');
	}else{
		header('Location:update-usuario.php#msgupderror');
	}
}
if(isset($_POST["activo_new"])){
	$dni_usu = $_POST["dni_usu"];
	$activo_new = $_POST["activo_new"];

	$sql = "UPDATE usuario SET activo_usu='$activo_new' WHERE dni_usu='$dni_usu'";
	mysqli_query($connect,$sql);

	/* verifica si se aplicaron los cambios
	 */
	$cons = "SELECT dni_usu FROM usuario WHERE dni_usu='$dni_usu' AND activo_usu='$activo_new'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:update-usuario.php#msgupdusu');
	}else{
		header('Location:update-usuario.php#msgupderror');
	}
}
?>
