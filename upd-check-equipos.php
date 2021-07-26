<?php
/*
 * Import generic data
 */
require_once('configuracion.php');
mysqli_set_charset($connect, "utf8mb4");

$desc_equipos = $_POST["desc_equipos"];
$fech_asig_equipos = $_POST["fech_asig_equipos"];
$check_equipos = "si";
$check_por_equipos = $_COOKIE['usuario'];
$fech_check_equipos = date('Y-m-d H:i:s');
$id_check_equipos = $_POST["id_check_equipos"];

if($id_check_equipos == ""){
	$realizado = $_POST["realizado"];
	$count = count($realizado);
	
	for ($i = 0; $i < $count; $i++){
		$fech_asig_id = $realizado[$i];
		$cantcarac = strlen($fech_asig_id);
		
		if($cantcarac > 10){
			$fech_asig_equipos = substr($fech_asig_id,0,10);
			$id_check_equipos = substr($fech_asig_id,10,14);
			$asig_equipos = substr($fech_asig_id,10,8);
			
			$sql = "UPDATE equipos_check SET check_equipos='$check_equipos',fech_check_equipos='$fech_check_equipos' WHERE id_check_equipos='$id_check_equipos'";
			mysqli_query($connect,$sql);
	
			$sql2 = "INSERT INTO equipos_no_check (id_check_equipos,check_por_equipos,asig_equipos)
				VALUE ('$id_check_equipos','$check_por_equipos','$asig_equipos')";
			mysqli_query($connect,$sql2);

			$cons = "SELECT id_check_equipos,check_equipos FROM equipos_check WHERE id_check_equipos='$id_check_equipos' AND check_equipos = '$check_equipos'";
			$resp = mysqli_query($connect,$cons);
			if($row = mysqli_fetch_array($resp)){
				header('Location:equipos-revisados.php?msg=ok#msg');
			}else{
				header('Location:equipos-revisados.php?msg=error#msg');
			}
		}else{
			$fech_asig_equipos = $fech_asig_id;
			$dia = substr($fech_asig_equipos,8,2);
			$mes = substr($fech_asig_equipos,5,2);
			$anio_small = substr($fech_asig_equipos,2,2);
			$id_check_equipos = $check_por_equipos.$dia.$mes.$anio_small;
			
			$sql="INSERT INTO equipos_check (id_check_equipos,desc_equipos,fech_asig_equipos,check_equipos,check_por_equipos,fech_check_equipos,obs_equipos) 
				VALUE ('$id_check_equipos','$desc_equipos','$fech_asig_equipos','$check_equipos','$check_por_equipos','$fech_check_equipos',NULL)";
			mysqli_query($connect,$sql);
			
			$cons = "SELECT id_check_equipos FROM equipos_check WHERE id_check_equipos='$id_check_equipos'";
			$resp = mysqli_query($connect,$cons);
			if($row = mysqli_fetch_array($resp)){
				header('Location:equipos-revisados.php?msg=ok#msg');
			}else{
				header('Location:revisar-equipos.php?msg=error#msg');
			}
		}
	}
}else{
	$obs_equipos = $_POST["obs_equipos"];
	$sql = "UPDATE equipos_check SET obs_equipos='$obs_equipos' WHERE id_check_equipos='$id_check_equipos'";
	mysqli_query($connect,$sql);

	$cons = "SELECT id_check_equipos,obs_equipos FROM equipos_check WHERE id_check_equipos='$id_check_equipos' AND obs_equipos = '$obs_equipos'";
	$resp = mysqli_query($connect,$cons);
	if($row = mysqli_fetch_array($resp)){
		header('Location:equipos-revisados.php?msg=ok#msg');
	}else{
		header('Location:equipos-revisados.php?msg=error#msg');
	}
}
?>
