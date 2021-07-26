<?php
require_once('configuracion.php');

/* inicia sesión creando una cookie */
/*$login = textfilter($_POST["usuario"]);*/

$dni_usu = $_COOKIE["usuario"];
$passw_ant = $_POST["passw_ant"];
$passw_new = $_POST["passw_new"];
$passw_new_re = $_POST["passw_new_re"];

if($passw_new <> $passw_new_re){
	header('Location:update-password.php?msg=passdif#msg');	
}else{
	$passw_ant = md5(valcontra($passw_ant));
	
	$consulta="SELECT dni_usu FROM usuario WHERE dni_usu='$dni_usu' AND passw_usu='$passw_ant'";
	$respuesta=mysqli_query($connect,$consulta);

	if($fila=mysqli_fetch_array($respuesta)){
		$passw_new = md5(valcontra($passw_new));
		$sql = "UPDATE usuario SET passw_usu='$passw_new' WHERE dni_usu='$dni_usu'";
		mysqli_query($connect,$sql);
				
		/* verifica si se aplicaron los cambios */
		
		$cons = "SELECT dni_usu,passw_usu FROM usuario WHERE dni_usu='$dni_usu' AND passw_usu = '$passw_new'";
		$resp = mysqli_query($connect,$cons);
		if($row = mysqli_fetch_array($resp)){
			header('Location:update-password.php?msg=ok#msg');
		}else{
			header('Location:update-password.php?msg=errordif#msg');
		}
	}else{
		header('Location:update-password.php?msg=error#msg');
	}
}

?>
