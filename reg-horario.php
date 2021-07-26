<?php
/*
 * Import generic data
 */
require_once('configuracion.php');
/*
 * registra los datos del nuevo usuario
 * recibe datos desde 'registrar-usuario.php'
 */ 
mysqli_set_charset($connect, "utf8");


$mes = textfilter($_POST['mes']);
$anio = textfilter($_POST['anio']);
$fecha_reg_hora = date('Y-m-d g:i:s');
$user_reg_hora = textfilter($_COOKIE['usuario']);

$anio_small = substr($anio,2);

/* ingresa los datos a la BD */

$con = "SELECT dni_usu FROM usuario WHERE activo_usu='si' order by dni_usu";
$query = mysqli_query($connect,$con);

$dni_usu = "";
$turno_comp = "";

while($row= mysqli_fetch_array($query)){
	$dni_usu = $row['dni_usu'];
	$i = 1;
	while($i <= 31){
		$dia = $i;
		$turno_comp = $dni_usu.$i;
		$turno_comp = textfilter($_POST[$turno_comp]);		

		$fecha_hora = $anio.'-'.$mes.'-'.$dia;
		$turno = substr($turno_comp,0,2);
		
		$id_hora = $dni_usu.$dia.$mes.$anio_small;
		/*id_hora está compuesto por dni + dia + mes + anio (fecha actual)*/		
		
		$sql="INSERT INTO horario (id_hora,dni_usu,fecha_hora,turno_hora,fech_reg_hora,user_reg_hora) 
			VALUE ('$id_hora','$dni_usu','$fecha_hora','$turno','$fecha_reg_hora','$user_reg_hora')";
		mysqli_query($connect,$sql);

		$i++;
	}
}
/* verifica si se guardaron los datos */
$consulta="SELECT dni_usu FROM horario WHERE dni_usu='$dni_usu'";
$respuesta=mysqli_query($connect,$consulta);

if($fila=mysqli_fetch_array($respuesta)){
	header('Location:registrar-horario.php?msg=ok#msg');
}else{
	header('Location:registrar-horario.php?msg=error#msg');
}

?>
