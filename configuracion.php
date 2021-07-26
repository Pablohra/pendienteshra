<?php
/*
 * @version 0.1
 */
define("server","localhost");
define("user","root");
define("pass","");
define("database","pendientesbd");
/*
 * Database Conection
 */
$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
/*
 * Select Database
 */
@mysqli_select_db($connect,database)or die('Database not found');
/*mysqli_query("SET NAMES 'utf8'");*/
mysqli_set_charset($connect, "utf8mb4");

/*filtra los strings*/
function textfilter($text){
	$text=strtolower(htmlentities(strip_tags(trim($text))));
	return $text;
	}
/*filtra las cadenas especiales*/
function textfilter_specialchars($text){
	$text = strip_tags(trim($text));
	$text = mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
	return $text;
	}
/*obtiene formato de fecha para almacenar en la base de datos*/
function orderfecha_bd($fecha){
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$año = substr($fecha,6,4);
	$fecha = $año.'-'.$mes.'-'.$dia;
	return $fecha;
	}
/*obtiene formato de fecha para mostrar en el front-end*/
function orderfecha($fecha){
	$dia = substr($fecha,8,2);
	$mes = substr($fecha,5,2);
	$año = substr($fecha,0,4);
	$fecha = $dia.'/'.$mes.'/'.$año;
	if($fecha == '//'){$fecha="--";}
	return $fecha;
}
/*obtiene formato de hora para mostrar en el front-end*/
function orderhora($fecha_hora){
	if($fecha_hora != NULL){
		$h = substr($fecha_hora,11,2);
		$m = substr($fecha_hora,14,2);
		if($h > 12){
			$h = $h - 12;
			if($h < 10){
				$h = '0'.$h;
			}
			$h = $h.':'.$m.' pm';		
		}else{
			if($h == 12){
				$h = $h.':'.$m.' m';
			}else{
				$h = $h.':'.$m.' am';
			}
		}
	}else{
		$h = "";
	}
	return $h;
}
/*validación de contraseña*/
function valcontra($cont){
	$cont=htmlentities(strip_tags(trim($cont)));
	return $cont;
}
/*genera mes*/
function generar_mes($num){
	if($num>12){
		$num = $num - 12;
	}
	switch ($num) {
		case 1: $m = "Enero"; break;
		case 2: $m = "Febrero"; break;
		case 3: $m = "Marzo"; break;
		case 4: $m = "Abril"; break;
		case 5: $m = "Mayo"; break;
		case 6: $m = "Junio"; break;
		case 7: $m = "Julio"; break;
		case 8: $m = "Agosto"; break;
		case 9: $m = "Setiembre"; break;
		case 10: $m = "Octubre"; break;
		case 11: $m = "Noviembre"; break;
		case 12: $m = "Diciembre"; break;
		default:
		print "<br/>Error: $num no tiene respuesta<br/>"; break;
	}
	return $m;
}
/*genera numero del mes*/
function generar_numdmes($m){
	switch ($m) {
		case "enero": $m = "01"; break;
		case "febrero": $m = "02"; break;
		case "marzo": $m = "03"; break;
		case "abril": $m = "04"; break;
		case "mayo": $m = "05"; break;
		case "junio": $m = "06"; break;
		case "julio": $m = "07"; break;
		case "agosto": $m = "08"; break;
		case "setiembre": $m = "09"; break;
		case "octubre": $m = "10"; break;
		case "noviembre": $m = "11"; break;
		case "diciembre": $m = "12"; break;
		default:
		print "<br/>Error: $m no tiene respuesta<br/>"; break;
	}
	return $m;
}
/*busca personal por nombres*/
function buscar_personal($names){
	$names_pers = textfilter_specialchars($names);
	$n = substr_count($names_pers, ",");
	if($n > 0){
		$names_pers = explode(", ",$names_pers);
		$apellidos = $names_pers[0];
		$nombres = $names_pers[1];
		$cons_dni = "SELECT dni FROM personal 
						WHERE apellidos='$apellidos' AND nombres='$nombres'";
		$resp_dni = mysql_query($cons_dni);
		$dni = 0;
		if($row = mysql_fetch_array($resp_dni)){
			$dni = $row[0];
		}else{
			$dni = 0;
		}
	}else{
		$dni = 0;
	}	
	return $dni;
}
/*busca personal por dni*/
function buscar_personalxdni($dni){
	$dni = textfilter_specialchars($dni);
	$cons_pers = "SELECT apellidos,nombres FROM personal WHERE dni='$dni'";
	$resp_pers = mysql_query($cons_pers);
	$name = "";
	if($row = mysql_fetch_array($resp_pers)){
		$apellidos = $row['apellidos'];
		$nombres = $row['nombres'];
		$name = $apellidos.", ".$nombres;
		$name = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");
	}else{
		$name = "Error";
	}
	return $name;
}
/*obtiene formato de hora meridiano*/
function get_hora_meridiano($hora){
	$hora = explode(":",$hora);
	$h = $hora[0];
	$m = $hora[1];
	if($h > 12){
		$h = $h - 12;
		if($h < 10){
			$h = '0'.$h;
		}
		$h = $h.':'.$m.' pm';		
	}else{
		if($h == 12){
			$h = $h.':'.$m.' m';
		}else{
			$h = $h.':'.$m.' am';
		}		
	}
	return $h;
}
/*obtiene formato de hora para almacenar en la base de datos*/
function get_hora_bd($hora){
	$h = substr($hora,0,2);
	$m = substr($hora,3,2);
	$meridiano = substr($hora,-2,2);
	if($meridiano == 'pm'){
		$h = $h + 12;
		$h = $h.':'.$m.':00';
	}else{
		$h = $h.':'.$m.':00';
	}
	return $h;
}
/*obtiene personal entrante*/
function get_pers_entrante(){
	$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
	@mysqli_select_db($connect,database)or die('Database not found');
	mysqli_set_charset($connect, "utf8mb4");
	
	$name = "";
	$nombres = "";
	$fecha = date('Y-m-d');
	$hora_actual = strtotime(date('H:i'));
	$hora_compare1 = strtotime('7:00');
	$hora_compare2 = strtotime('19:00');
	$i = 1;
	/*Personal entrante - hora actual menor a las 7:00 am*/
	if($hora_actual < $hora_compare1){
		$turno = 'mt';
		$turno2 = 'mm';
		$turno3 = 't';
		
		$cons_pers = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno'
			ORDER BY name";
		$resp_pers = mysqli_query($connect,$cons_pers);
		$resp_pers2 = mysqli_query($connect,$cons_pers);
		
		if($row2=mysqli_fetch_array($resp_pers2)){
			while($row=mysqli_fetch_array($resp_pers)){
				$dni = $row['dni'];
				$nombres = $row['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
					$i++;
			}
		}
		$cons_pers2 = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno2'
			ORDER BY name";
		$resp_pers2 = mysqli_query($connect,$cons_pers2);
		$resp_pers3 = mysqli_query($connect,$cons_pers2);
		
		if($row3=mysqli_fetch_array($resp_pers2)){
			while($row4=mysqli_fetch_array($resp_pers3)){
				$dni = $row4['dni'];
				$nombres = $row4['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
					$i++;		
				}
		}
		$cons_pers2 = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno3'
			ORDER BY name";
		$resp_pers2 = mysqli_query($connect,$cons_pers2);
		$resp_pers3 = mysqli_query($connect,$cons_pers2);
		
		if($row3=mysqli_fetch_array($resp_pers2)){
			while($row4=mysqli_fetch_array($resp_pers3)){
				$dni = $row4['dni'];
				$nombres = $row4['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
					$i++;		
				}
		}
	}
	/*Personal entrante - hora actual mayor igual a las 7:00 am y menor a 7:00 pm*/
	if($hora_actual >= $hora_compare1 && $hora_actual < $hora_compare2){
		$turno = 'tn';		
		$cons_pers = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno'
			ORDER BY name";
		$resp_pers = mysqli_query($connect,$cons_pers);
		
		while($row=mysqli_fetch_array($resp_pers)){
			$dni = $row['dni'];
			$nombres = $row['name'];
			if($i==1){
				$name = $nombres.":".$dni;
			}	
			$i++;		
		}
	}	
	/*Personal entrante - hora actual mayor igual a las 7:00 pm*/
	if($hora_actual >= $hora_compare2){
		$turno = 'mt';
		$turno2 = 'mm';
		$turno3 = 't';
		$fecha = strtotime('+1 day', strtotime($fecha));
		$fecha = date('Y-m-d', $fecha);
		
		$cons_pers = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno'
			ORDER BY name";
		$resp_pers = mysqli_query($connect,$cons_pers);
		$resp_pers2 = mysqli_query($connect,$cons_pers);
		
		if($row2=mysqli_fetch_array($resp_pers2)){
			while($row=mysqli_fetch_array($resp_pers)){
				$dni = $row['dni'];
				$nombres = $row['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
				$i++;
			}
		}
		$cons_pers2 = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno2'
			ORDER BY name";
		$resp_pers2 = mysqli_query($connect,$cons_pers2);
		$resp_pers3 = mysqli_query($connect,$cons_pers2);
		
		if($row2=mysqli_fetch_array($resp_pers2)){
			while($row3=mysqli_fetch_array($resp_pers3)){
				$dni = $row3['dni'];
				$nombres = $row3['name'];
				
				if($i==1){
					$name = $nombres.":".$dni;
				}
				$i++;		
			}
		}
		$cons_pers2 = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno3'
			ORDER BY name";
		$resp_pers2 = mysqli_query($connect,$cons_pers2);
		$resp_pers3 = mysqli_query($connect,$cons_pers2);
		
		if($row2=mysqli_fetch_array($resp_pers2)){
			while($row3=mysqli_fetch_array($resp_pers3)){
				$dni = $row3['dni'];
				$nombres = $row3['name'];
				
				if($i==1){
					$name = $nombres.":".$dni;
				}
				$i++;		
			}
		}
	}
		
	if($i > 2){
		$name = $name.":"."<br/>".$nombres.":".$dni;		
	}else{
		$name = $name;
	}
	
	$name = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");	
	
	return $name;
}
/*obtiene personal saliente*/
function get_pers_saliente(){
	$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
	@mysqli_select_db($connect,database)or die('Database not found');
	mysqli_set_charset($connect, "utf8mb4");
	
	$name = "";
	$nombres = "";
	$fecha = date('Y-m-d');
	$hora_actual = strtotime(date('H:i'));
	$hora_compare1 = strtotime('7:00');
	$hora_compare2 = strtotime('19:00');
	$i = 1;
	/*Personal saliente - hora actual menor a las 7:00 am*/
	if($hora_actual < $hora_compare1){
		$turno = 'tn';
		$fecha = strtotime('-1 day', strtotime($fecha));
		$fecha = date('Y-m-d', $fecha);
		
		$cons_pers = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno'
			ORDER BY name";
		$resp_pers = mysqli_query($connect,$cons_pers);
		
		while($row=mysqli_fetch_array($resp_pers)){
			$dni = $row['dni'];
			$nombres = $row['name'];
			if($i==1){
				$name = $nombres.":".$dni;
			}	
			$i++;
		}			
	}
	/*Personal saliente - hora actual mayor igual a 7:00 am y menor a 7:00pm*/
	if($hora_actual >= $hora_compare1 && $hora_actual < $hora_compare2){
		$turno = 'mt';
		$turno2 = 'mm';
		$turno3 = 't';
		$cons_pers = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno'
			ORDER BY name";
		$resp_pers2 = mysqli_query($connect,$cons_pers);
		$resp_pers = mysqli_query($connect,$cons_pers);
		
		if($row2=mysqli_fetch_array($resp_pers2)){
			while($row=mysqli_fetch_array($resp_pers)){
				$dni = $row['dni'];
				$nombres = $row['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
				$i++;
			}
		}
		
		$cons_pers2 = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
				FROM usuario as u INNER JOIN horario as h
				ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno2'
				ORDER BY name";
		$resp_pers3 = mysqli_query($connect,$cons_pers2);
		$resp_pers4 = mysqli_query($connect,$cons_pers2);
		
		if($row3=mysqli_fetch_array($resp_pers3)){
			while($row4=mysqli_fetch_array($resp_pers4)){
				$dni = $row4['dni'];
				$nombres = $row4['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
				$i++;
			}
		}
		$cons_pers2 = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
				FROM usuario as u INNER JOIN horario as h
				ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno3'
				ORDER BY name";
		$resp_pers3 = mysqli_query($connect,$cons_pers2);
		$resp_pers4 = mysqli_query($connect,$cons_pers2);
		
		if($row3=mysqli_fetch_array($resp_pers3)){
			while($row4=mysqli_fetch_array($resp_pers4)){
				$dni = $row4['dni'];
				$nombres = $row4['name'];
				if($i==1){
					$name = $nombres.":".$dni;
				}
				$i++;
			}
		}
	}
	/*Personal saliente - hora actual mayor igual a las 7:00 pm*/
	if($hora_actual >= $hora_compare2){
		$turno = 'tn';		
		$cons_pers = "SELECT u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora = '$turno'
			ORDER BY name";
		$resp_pers = mysqli_query($connect,$cons_pers);
		
		while($row=mysqli_fetch_array($resp_pers)){
			$dni = $row['dni'];
			$nombres = $row['name'];
			if($i==1){
				$name = $nombres.":".$dni;
			}
			$i++;		
		}			
	}
	if($i > 2){
		$name = $name.":"."<br/>".$nombres.":".$dni;		
	}else{
		$name = $name;
	}	
	$name = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");
	
	return $name;
}
/*Obtener permisos de usuario administrador*/
function get_permisos_admin($usuario_login){		
	$permisos_admin = false;

	switch ($usuario_login) {
		case "40682205": $permisos_admin = true; break;
		case "44740429": $permisos_admin = true; break;
		case "45670163": $permisos_admin = true; break;
		case "41682533": $permisos_admin = true; break;
	}
	if($permisos_admin == true){
		$activeadmin = "";
	}else{	
		$activeadmin = 'id="activeadmin"';
	}	
	return $activeadmin;
}
/*Obtener nombres del personal que realizo el pendiente*/
function get_realizado_pend_por($dni_usu){
	$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
	@mysqli_select_db($connect,database)or die('Database not found');
	mysqli_set_charset($connect, "utf8mb4");
	
	$cons_pers = "SELECT apellidos_usu,nombres_usu FROM usuario WHERE dni_usu='$dni_usu'";
	$resp_pers = mysqli_query($connect,$cons_pers);
	$name = "";
	if($row = mysqli_fetch_array($resp_pers)){
		$apellidos = $row['apellidos_usu'];
		$nombres = $row['nombres_usu'];
		$name = $nombres.' '.$apellidos;
		$name = mb_convert_case($name, MB_CASE_UPPER, "UTF-8");
	}else{
		$name = "--";
	}
	return $name;
}
/*Reporte de turnos por fecha*/
function generar_report_turnosxfecha($fecha){
	$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
	@mysqli_select_db($connect,database)or die('Database not found');
	mysqli_set_charset($connect, "utf8mb4");
	
	$con = "SELECT u.dni_usu AS dni,concat(apellidos_usu,', ',nombres_usu) AS name,turno_hora,fecha_hora
			FROM usuario as u INNER JOIN horario as h
			ON u.dni_usu=h.dni_usu WHERE activo_usu='si' AND fecha_hora = '$fecha' AND turno_hora <> '' AND turno_hora <> '--'
			ORDER BY turno_hora";
	$query = mysqli_query($connect,$con);		
	$query2 = mysqli_query($connect,$con);

	if($lista= mysqli_fetch_array($query)){
	/* cabecera de la tabla del reporte */
		$fecha_front = orderfecha($fecha);

		$dia = substr($fecha_front,0,2);
		$mes = generar_mes(substr($fecha_front,3,2));
		$anio = substr($fecha_front,6,4);
		
		$report = "
		<br/><center><h4 class='text-info'>Turnos asignados del día $dia de $mes de $anio </h4></center><br/>
		<table class='table table-bordered table-striped'>
			<thead>
				<tr class='alert alert-primary'>
					<th><center>N°</center></th>
					<th><center>Apellidos y Nombres</center></th>
					<th><center>Turno</center></th>
				</tr>
			</thead>
			<tbody>";
		$i = 1;
		while($row= mysqli_fetch_array($query2)){
			$dni = $row['dni'];
			$fecha = orderfecha($row['fecha_hora']);
			$names = $row['name'];			
			$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
			$turno = $row['turno_hora'];
			$turno = mb_convert_case($turno, MB_CASE_UPPER, "UTF-8");
			
			$report = $report."
			<tr>
				<td><center>".$i."</center></td>
				<td class='names'>".$names."</td>
				<td><center>".$turno."</center></td>
			</tr>";
			
			$i++;
		}
		$report = $report."</tbody></table>";
	}else{
		$report = "
		<tr>
			<td colspan='4'><h5 class='text-info'>No hay Registros.</h5><p class='text-info'>No se registraron turnos en esta fecha.</p></td>
		</tr>";
	}				
	return $report;
}
/*Reporte de pendientes por fecha*/
function generar_report_pendientesxfecha($fechadesde,$fechahasta){
	$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
	@mysqli_select_db($connect,database)or die('Database not found');
	mysqli_set_charset($connect, "utf8mb4");	
	
	$fechadesde = $fechadesde." 00:00:00";
	$fechahasta = $fechahasta." 23:59:59";
	
	$fecha_desde = orderfecha($fechadesde);
	$fecha_hasta = orderfecha($fechahasta);
	
	$con = "SELECT id_pend,u.dni_usu AS dni,concat(apellidos_usu,', ',nombres_usu) AS name,desc_pend,fecha_pend,priori_pend,realizado_pend,realizado_por_pend,fecha_realizado_por,fecha_ulti_modifi
			FROM usuario AS u INNER JOIN pendiente AS p
			ON u.dni_usu=p.dni_usu WHERE fecha_pend >= '$fechadesde' AND fecha_pend <= '$fechahasta'
			ORDER BY fecha_pend DESC";
	$query2 = mysqli_query($connect,$con);
	$query = mysqli_query($connect,$con);
	
	if($fila= mysqli_fetch_array($query2)){
		$i = 1;
		$report = "
		<br/><center><h4 class='text-info'>Pendientes del $fecha_desde al $fecha_hasta</h4></center><br/>
		<table class='table table-bordered table-striped'>
			<thead>
				<tr class='alert alert-primary'>
					<th><center>N°</center></th>
					<th><center>Descripción del pendiente</center></th>
					<th><center>Fecha Registrado</center></th>
					<th><center>Fecha Realizado</center></th>
					<th><center>Registrado por</center></th>
					<th><center>Realizado por</center></th>					
					<th><center>Fecha Última Modificación</center></th>
				</tr>
			</thead>
			<tbody>";
		
		while($row= mysqli_fetch_array($query)){
			$id_pend = $row['id_pend'];
			$names = $row['name'];
			$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
			$dni = $row['dni'];
			$desc_pend = $row['desc_pend'];
			//$desc_pend = mb_convert_case($desc_pend, MB_CASE_UPPER, "UTF-8");
			$fecha_pend = orderfecha($row['fecha_pend']);
			$hora_pend = orderhora($row['fecha_pend']);			
			$fecha_realizado_por = orderfecha($row['fecha_realizado_por']);
			$hora_realizado_por = orderhora($row['fecha_realizado_por']);
			$fecha_ulti_modifi = orderfecha($row['fecha_ulti_modifi']);			
			$hora_ulti_modifi = orderhora($row['fecha_ulti_modifi']);			
			$realizado_por_pend = $row['realizado_por_pend'];
			$realizado_por_pend = get_realizado_pend_por($realizado_por_pend);
			$report = $report."
				<tr>
					<th><center>$i</center></th>
					<td style='text-transform:uppercase;'>$desc_pend</td>
					<td><center><small>$fecha_pend<br/>$hora_pend</small></center></td>
					<td><center><small>$fecha_realizado_por<br/>$hora_realizado_por</small></center></td>
					<td><center><small>$names</small></center></td>
					<td><center><small>$realizado_por_pend</small></center></td>					
					<td><center><small>$fecha_ulti_modifi<br/>$hora_ulti_modifi</small></center></td>
				</tr>
			";
			$i++;
		}
		$report = $report."</tbody></table>";							
	}else{
		$report = "
		<tr>
			<td colspan='6'><h5 class='text-info'>No hay Registros.</h5><p class='text-info'>No se registraron pendientes en esta fecha.</p></td>
		</tr>";	
	}
	return $report;
}
/*Reporte de equipos revisados por fecha*/
function generar_report_equiposxfecha($fechadesde,$fechahasta){
	$connect=@mysqli_connect(server,user,pass) or die('Database connect error');
	@mysqli_select_db($connect,database)or die('Database not found');
	mysqli_set_charset($connect, "utf8mb4");
	
	$fecha_desde = orderfecha($fechadesde);
	$fecha_hasta = orderfecha($fechahasta);
	
	$con = "SELECT id_check_equipos,u.dni_usu AS dni,concat(nombres_usu,' ',apellidos_usu) AS name,desc_equipos,check_equipos,fech_asig_equipos,check_por_equipos,obs_equipos,fech_check_equipos
			FROM usuario AS u INNER JOIN equipos_check AS e
			ON u.dni_usu=e.check_por_equipos WHERE fech_asig_equipos >= '$fechadesde' AND fech_asig_equipos <= '$fechahasta'
			ORDER BY fech_asig_equipos DESC";
	$query2 = mysqli_query($connect,$con);
	$query = mysqli_query($connect,$con);
	
	if($fila= mysqli_fetch_array($query2)){
		$i = 1;
		$report = "
		<br/><center><h4 class='text-info'>Equipos revisados del $fecha_desde al $fecha_hasta</h4></center><br/>
		<table class='table table-bordered table-striped'>
			<thead>
				<tr class='alert alert-primary'>
					<th><center>N°</center></th>
					<th><center>Descripción de equipos</center></th>
					<th><center>Revisado</center></th>
					<th><center>Fecha asignado</center></th>
					<th><center>Fecha revisado</center></th>
					<th><center>Responsable</center></th>
					<th><center>Observaciones</center></th>					
				</tr>
			</thead>
			<tbody>";
		
		while($row= mysqli_fetch_array($query)){
			$id_check_equipos = $row['id_check_equipos'];
			$names = $row['name'];
			$check_equipos = $row['check_equipos'];
			$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
			$dni = $row['dni'];
			$desc_equipos = $row['desc_equipos'];
			$fech_asig_equipos = orderfecha($row['fech_asig_equipos']);
			$fecha_revisado_por = orderfecha($row['fech_check_equipos']);
			$hora_revisado_por = orderhora($row['fech_check_equipos']);
			$obs_equipos = $row['obs_equipos'];
			
			if($check_equipos == "no"){
				$active="class='table-danger'";
			}else{
				$active="";
			}
			
			$report = $report."
				<tr ".$active.">
					<th><center>$i</center></th>
					<td style='text-transform:uppercase;'>$desc_equipos</td>
					<td style='text-transform:uppercase;'><center>$check_equipos</center></td>
					<td><center><small>$fech_asig_equipos</small></center></td>
					<td><center><small>$fecha_revisado_por<br/>$hora_revisado_por</small></center></td>
					<td><center><small>$names</small></center></td>
					<td style='text-transform:uppercase;'>$obs_equipos</td>
				</tr>
			";
			$i++;
		}
		$report = $report."</tbody></table>";							
	}else{
		$report = "
		<tr>
			<td colspan='6'><h5 class='text-info'>No hay Registros.</h5><p class='text-info'>No se registraron equipos revisados en esta fecha.</p></td>
		</tr>";	
	}
	return $report;
}
function get_letraexcel($num){
	switch ($num){
		case 1: $m = "A"; break;
		case 2: $m = "B"; break;
		case 3: $m = "C"; break;
		case 4: $m = "D"; break;
		case 5: $m = "E"; break;
		case 6: $m = "F"; break;
		case 7: $m = "G"; break;
		case 8: $m = "H"; break;
		case 9: $m = "I"; break;
		case 10: $m = "J"; break;
		case 11: $m = "K"; break;
		case 12: $m = "L"; break;
		case 13: $m = "M"; break;
		case 14: $m = "N"; break;
		case 15: $m = "O"; break;
		case 16: $m = "P"; break;
		case 17: $m = "Q"; break;
		case 18: $m = "R"; break;
		case 19: $m = "S"; break;
		case 20: $m = "T"; break;
		case 21: $m = "U"; break;
		case 22: $m = "V"; break;
		case 23: $m = "W"; break;
		case 24: $m = "X"; break;
		case 25: $m = "Y"; break;
		case 26: $m = "Z"; break;
		case 27: $m = "AA"; break;
		case 28: $m = "AB"; break;
		case 29: $m = "AC"; break;
		case 30: $m = "AD"; break;
		case 31: $m = "AE"; break;
		case 32: $m = "AF"; break;
		case 33: $m = "AG"; break;
		case 34: $m = "AH"; break;
		case 35: $m = "AI"; break;
		case 36: $m = "AJ"; break;
	}
	return $m;
}
?>
