<?php
if(!isset($_COOKIE['usuario'])){
	header('Location:index.php');
}else{
	require_once('configuracion.php');
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8mb4">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="images/fav.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/summernote-bs4.css">
    <title>Revisar equipos</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->
			<br/>
			<h1><center>Revisar equipos</center></h1>
			<br/>
			<a href="equipos-revisados.php">Ver equipos revisados</a>
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-horario.php'
	 */
				if(isset($_GET['msg'])){
					if($_GET['msg'] == 'ok'){
						print 
						'<div class="alert alert-success alert-dismissible fade show" role="alert" id="msg">
							<center><h6>Se guardaron los datos</h6></center>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>';
					}
					if($_GET['msg'] == 'error'){
						print 
						'<div class="alert alert-danger alert-dismissible fade show" role="alert" id="msg">
							<center><h5>¡Error!</h5><h6>Los datos no fueron guardados</h6></center>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>';
					}
				}
			?>
			<form method="post" action="upd-check-equipos.php" name="frmEquipos">
				<br/>
				<table class="table table-striped table-bordered">
					<thead>
						<tr class="alert alert-primary">
							<th scope="col"><center>N°</center></th>
							<th scope="col"><center>Responsable</center></th>
							<th scope="col"><center>Descripción de Equipos</center></th>
							<th scope="col"><center>Fecha</center></th>
							<th scope="col"><center>Revisar</center></th>
							<th scope="col"><center>Guardar</center></th>
						</tr>
					</thead>
					<tbody>
						<?php
							mysqli_set_charset($connect, "utf8mb4");
							$con = "SELECT * FROM equipos";
							$query = mysqli_query($connect,$con);
							$usuario_login = $_COOKIE['usuario'];
							$activeadmin = get_permisos_admin($usuario_login);
							$i = 1;
							$fecha_actual = date("Y-m-d");
							$hora_actual = strtotime(date('H:i'));
							$hora_compare1 = strtotime('7:00');
							$hora_compare2 = strtotime('19:00');

							if($fila= mysqli_fetch_array($query)){
								$x = 1;
								$id_equipos = $fila['id_equipos'];
								$desc_equipos = $fila['desc_equipos'];
								/*$names = get_pers_entrante();
								$names = explode(":",$names);

								if(isset($names[1])){
									$dnicomp[] = $names[1];
								}

								if(isset($names[3])){
									$dnicomp[] = $names[3];
								}*/

								$names = get_pers_saliente();
								$names = explode(":",$names);

								if(isset($names[1])){
									$dnicomp[] = $names[1];
								}

								if(isset($names[3])){
									$dnicomp[] = $names[3];
								}
								$totalpers = count($dnicomp);
								
								for($i = 0;$i < $totalpers;$i++){
									$dni = $dnicomp[$i];

									if($hora_actual > $hora_compare2){
										$con = "SELECT u.dni_usu AS dni,concat(nombres_usu,' ',apellidos_usu) AS name,fecha_hora,turno_hora
											FROM usuario as u INNER JOIN horario as h
											ON u.dni_usu=h.dni_usu WHERE u.dni_usu = '$dni' AND fecha_hora ='$fecha_actual'";
										$query2 = mysqli_query($connect,$con);

										if($row= mysqli_fetch_array($query2)){
											$names = $row['name'];
											$turno_hora = $row['turno_hora'];
											
											$con2 = "SELECT id_check_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND fech_asig_equipos='$fecha_actual' AND check_equipos='si'";
											$query3 = mysqli_query($connect,$con2);
											$oculto = "no";
											
											if($fila3= mysqli_fetch_array($query3)){
												$oculto = "si";

											}else{
												$fecha2 = date("Y-m-d",strtotime($fecha_actual."- 1 days"));
												$con2 = "SELECT id_check_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND fech_asig_equipos='$fecha2' AND check_equipos='si'";
												$query3 = mysqli_query($connect,$con2);
												$oculto = "no";
												
												if($fila3= mysqli_fetch_array($query3)){
													$oculto = "si";
												}
											}											
											$resalt = "";
											
											if($dni == $usuario_login){
												$resalt = "class='table-primary'";
												$active = "";
												$activebutton = "";
											
											}else{
												$active = "disabled";
												$activebutton = "id='activeadmin'";
											}
											
											if($oculto == "no"){
												$con = "SELECT id_check_equipos,desc_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND check_equipos ='no' AND fech_asig_equipos = '$fecha_actual'";
												$query = mysqli_query($connect,$con);
												
												if($fila2= mysqli_fetch_array($query)){
													$id_check_equipos = $fila2['id_check_equipos'];
													$desc_equipos2 = $fila2["desc_equipos"];
													$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos2."</td>";
												}else{
													$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos."</td>";
												}
												
												$id_check_equipos = "";

												print "
													<input type='hidden' name='id_check_equipos' value=''/>
													<input type='hidden' name='fech_asig_equipos' value='".$fecha_actual."'/>
													<input type='hidden' name='desc_equipos' value='".$desc_equipos."'/>
													<tr ".$resalt." >
														<th><center>$x</center></th>
														<td style='text-transform:uppercase;'>$names<div id='descpend'></div></td>
														$detallequipos
														<td><center>".orderfecha($fecha_actual)."</center></td>														
														<td>
															<center>
																<div class='custom-control custom-checkbox mr-sm-2'>
																	<div class='form-check'>
																		<input name='realizado[]' value='".$fecha_actual.$id_check_equipos."' type='checkbox' ".$active." class='custom-control-input' id='customControlAutosizing$x'>
																		<label class='custom-control-label text-primary' for='customControlAutosizing$x'><b>OK</b></label>
																	</div>
																</div>
															</center>
														</td>
														<td>
															<button type='submit' class='btn btn-primary'".$activebutton.">Guardar 
															</button>
														</td>
													</tr>";
											}
											$x++;
										}
									}

									if($hora_actual < $hora_compare1){
										$con = "SELECT u.dni_usu AS dni,concat(nombres_usu,' ',apellidos_usu) AS name,fecha_hora,turno_hora
											FROM usuario as u INNER JOIN horario as h
											ON u.dni_usu=h.dni_usu WHERE u.dni_usu = '$dni' AND fecha_hora ='$fecha_actual'";
										$query2 = mysqli_query($connect,$con);

										if($row= mysqli_fetch_array($query2)){
											$names = $row['name'];
											$turno_hora = $row['turno_hora'];
											
											$con2 = "SELECT id_check_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND fech_asig_equipos>='$fecha_actual' AND check_equipos='si'";
											$query3 = mysqli_query($connect,$con2);
											$oculto = "no";
											
											if($fila3= mysqli_fetch_array($query3)){
												$oculto = "si";
											}else{
												$fecha2 = date("Y-m-d",strtotime($fecha_actual."- 1 days"));
												$con2 = "SELECT id_check_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND fech_asig_equipos>='$fecha2' AND check_equipos='si'";
												$query3 = mysqli_query($connect,$con2);
												$oculto = "no";											
												
												if($fila3= mysqli_fetch_array($query3)){
													$oculto = "si";
													$fecha_actual = $fecha2;
												}else{
													
												}
											}
							
											$resalt = "";	
															
											if($dni == $usuario_login){
												$resalt = "class='table-primary'";
												$active = "";
												$activebutton = "";
												
											}else{
												$active = "disabled";
												$activebutton = "id='activeadmin'";
											}
											
											if($oculto == "no"){
												$con = "SELECT id_check_equipos,desc_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND check_equipos ='no' AND fech_asig_equipos = '$fecha_actual'";
												$query = mysqli_query($connect,$con);
												
												if($fila2= mysqli_fetch_array($query)){
													$id_check_equipos = $fila2['id_check_equipos'];
													$desc_equipos2 = $fila2["desc_equipos"];
													$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos2."</td>";
												}else{
													$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos."</td>";
												}
												
												$id_check_equipos = "";

												print "
													<input type='hidden' name='id_check_equipos' value=''/>
													<input type='hidden' name='fech_asig_equipos' value='".$fecha_actual."'/>
													<input type='hidden' name='desc_equipos' value='".$desc_equipos."'/>
													<tr ".$resalt." >
														<th><center>$x</center></th>
														<td style='text-transform:uppercase;'>$names<div id='descpend'></div></td>
														$detallequipos
														<td><center>".orderfecha($fecha_actual)."</center></td>														
														<td>
															<center>
																<div class='custom-control custom-checkbox mr-sm-2'>
																	<div class='form-check'>
																		<input name='realizado[]' value='".$fecha_actual.$id_check_equipos."' type='checkbox' ".$active." class='custom-control-input' id='customControlAutosizing$x'>
																		<label class='custom-control-label text-primary' for='customControlAutosizing$x'><b>OK</b></label>
																	</div>
																</div>
															</center>
														</td>
														<td>
															<button type='submit' class='btn btn-primary'".$activebutton.">Guardar 
															</button>
														</td>
													</tr>";
											}
											$x++;
										}
									}

									
									if($hora_actual >= $hora_compare1 && $hora_actual < $hora_compare2){
										$con = "SELECT u.dni_usu AS dni,concat(nombres_usu,' ',apellidos_usu) AS name,fecha_hora,turno_hora
											FROM usuario as u INNER JOIN horario as h
											ON u.dni_usu=h.dni_usu WHERE u.dni_usu = '$dni' AND fecha_hora ='$fecha_actual'";
										$query2 = mysqli_query($connect,$con);
										
										if($row= mysqli_fetch_array($query2)){
											$names = $row['name'];
											$turno_hora = $row['turno_hora'];
											
											$con2 = "SELECT id_check_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND fech_asig_equipos>='$fecha_actual' AND check_equipos='si'";
											$query3 = mysqli_query($connect,$con2);
											$oculto = "no";
											
											if($fila3= mysqli_fetch_array($query3)){
												$oculto = "si";
											}else{
												if($turno_hora == "mt"){
													$oculto = "no";
												}else{
													$fecha2 = date("Y-m-d",strtotime($fecha_actual."- 1 days"));
													
													$con2 = "SELECT id_check_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND fech_asig_equipos>='$fecha2' AND check_equipos='si'";
													$query3 = mysqli_query($connect,$con2);
													$oculto = "no";											
													
													if($fila3= mysqli_fetch_array($query3)){
														$oculto = "si";
													}else{
														
													}
												}
											}
							
											$resalt = "";	
															
											if($dni == $usuario_login){
												$resalt = "class='table-primary'";
												$active = "";
												$activebutton = "";
												
											}else{
												$active = "disabled";
												$activebutton = "id='activeadmin'";
											}
											
											if($oculto == "no"){
												$con = "SELECT id_check_equipos,desc_equipos FROM equipos_check WHERE check_por_equipos='$dni' AND check_equipos ='no' AND fech_asig_equipos = '$fecha_actual'";
												$query = mysqli_query($connect,$con);
												
												if($fila2= mysqli_fetch_array($query)){
													$id_check_equipos = $fila2['id_check_equipos'];
													$desc_equipos2 = $fila2["desc_equipos"];
													$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos2."</td>";
												}else{
													$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos."</td>";
												}
												
												$id_check_equipos = "";

												print "
													<input type='hidden' name='id_check_equipos' value=''/>
													<input type='hidden' name='fech_asig_equipos' value='".$fecha_actual."'/>
													<input type='hidden' name='desc_equipos' value='".$desc_equipos."'/>
													<tr ".$resalt." >
														<th><center>$x</center></th>
														<td style='text-transform:uppercase;'>$names<div id='descpend'></div></td>
														$detallequipos
														<td><center>".orderfecha($fecha_actual)."</center></td>														
														<td>
															<center>
																<div class='custom-control custom-checkbox mr-sm-2'>
																	<div class='form-check'>
																		<input name='realizado[]' value='".$fecha_actual.$id_check_equipos."' type='checkbox' ".$active." class='custom-control-input' id='customControlAutosizing$x'>
																		<label class='custom-control-label text-primary' for='customControlAutosizing$x'><b>OK</b></label>
																	</div>
																</div>
															</center>
														</td>
														<td>
															<button type='submit' class='btn btn-primary'".$activebutton.">Guardar 
															</button>
														</td>
													</tr>";
											}
											$x++;
										}
									}
								}
							}else{
								print "
									<tr>
										<td class='alert alert-info' colspan='6'><center>No se tienen equipos o turnos registrados</center></td>
									</tr>";
							}
						
						for($i = 1;$i <= 30;$i++){
							if($i < 10){
								$i = '0'.$i;
							}
							$fecha = date('Y-m')."-".$i;
							
							if($fecha_actual >= $fecha){
								$activemsg = "class='table-danger'";
								$con = "SELECT dni_usu,fecha_hora,turno_hora FROM horario WHERE fecha_hora='$fecha' AND turno_hora<>''";
								$query = mysqli_query($connect,$con);

								while($fila= mysqli_fetch_array($query)){
									$turno_hora = $fila["turno_hora"];
									$dni2 = $fila["dni_usu"];

									if($turno_hora == "mt"){
										$con2 = "SELECT id_check_equipos,check_por_equipos,fech_asig_equipos,check_equipos FROM equipos_check 
												WHERE check_por_equipos='$dni2' AND fech_asig_equipos ='$fecha'";
										$query4 = mysqli_query($connect,$con2);
										
										//print $turno_hora;

										if($fila2= mysqli_fetch_array($query4)){
										}else{
											if($hora_actual > $hora_compare2){

												$check_por_equipos = $dni2;
												$fech_asig_equipos = $fecha;
												$dia = substr($fech_asig_equipos,8,2);
												$mes = substr($fech_asig_equipos,5,2);
												$anio_small = substr($fech_asig_equipos,2,2);
												$id_check_equipos = $check_por_equipos.$dia.$mes.$anio_small;
												$fech_check_equipos = date('Y-m-d H:i:s');
												$check_equipos = "no";
												
												$sql="INSERT INTO equipos_check (id_check_equipos,desc_equipos,fech_asig_equipos,check_equipos,check_por_equipos,fech_check_equipos,obs_equipos) 
													VALUE ('$id_check_equipos','$desc_equipos','$fech_asig_equipos','$check_equipos','$check_por_equipos','$fech_check_equipos',NULL)";
												mysqli_query($connect,$sql);
											}
										}
									}

									if($turno_hora == "tn"){
										$con2 = "SELECT id_check_equipos,check_por_equipos,fech_asig_equipos,check_equipos FROM equipos_check 
												WHERE check_por_equipos='$dni2' AND fech_asig_equipos ='$fecha'";
										$query4 = mysqli_query($connect,$con2);
										
										if($fila2= mysqli_fetch_array($query4)){
										}else{
											$fecha2 = date("Y-m-d",strtotime($fecha."+ 1 days"));

											$con3 = "SELECT id_check_equipos,check_por_equipos,fech_asig_equipos,check_equipos FROM equipos_check 
													WHERE check_por_equipos='$dni2' AND fech_asig_equipos ='$fecha2'";
											$query5 = mysqli_query($connect,$con3);
											
											if($fila2= mysqli_fetch_array($query5)){
											}else{
												if($fecha_actual > $fecha && $hora_actual > $hora_compare1){
													$check_por_equipos = $dni2;
													$fech_asig_equipos = $fecha;
													$dia = substr($fech_asig_equipos,8,2);
													$mes = substr($fech_asig_equipos,5,2);
													$anio_small = substr($fech_asig_equipos,2,2);
													$id_check_equipos = $check_por_equipos.$dia.$mes.$anio_small;
													$fech_check_equipos = date('Y-m-d H:i:s');
													$check_equipos = "no";
													
													$sql="INSERT INTO equipos_check (id_check_equipos,desc_equipos,fech_asig_equipos,check_equipos,check_por_equipos,fech_check_equipos,obs_equipos) 
														VALUE ('$id_check_equipos','$desc_equipos','$fech_asig_equipos','$check_equipos','$check_por_equipos','$fech_check_equipos',NULL)";
													mysqli_query($connect,$sql);
												}												
											}
										}
									}
								}

							}else{
								$activemsg="";
							}							
						}
						?>
					
						<?php
							mysqli_set_charset($connect, "utf8mb4");
							$con = "SELECT * FROM equipos_check where check_equipos = 'no'";
							$query = mysqli_query($connect,$con);
							$usuario_login = $_COOKIE['usuario'];
							$activeadmin = get_permisos_admin($usuario_login);
							$resalt = "class='table-danger'";
							$id_check_equipos = "";

							while($fila= mysqli_fetch_array($query)){
								$id_check_equipos = $fila['id_check_equipos'];								
								$desc_equipos = $fila['desc_equipos'];
								$dni2 = $fila['check_por_equipos'];
								$fecha2 = $fila['fech_asig_equipos'];

								$con2 = "SELECT dni_usu,concat(nombres_usu,' ',apellidos_usu) AS name
										FROM usuario WHERE activo_usu='si' AND dni_usu = '$dni2'";
								$query2 = mysqli_query($connect,$con2);
								
								if($row= mysqli_fetch_array($query2)){
									$names = $row['name'];
								}

								if($activeadmin == ""){
									$active = "";
									$activebutton = "";
								}else{
									$active = "disabled";
									$activebutton = "id='activeadmin'";
								}
								//print $active."gg";
								$detallequipos = "<td style='text-transform:uppercase;'>".$desc_equipos."</td>";
								
								print "
									<input type='hidden' name='id_check_equipos' value=''/>
									<input type='hidden' name='fech_asig_equipos' value='".$fecha2."'/>
									<input type='hidden' name='desc_equipos' value='".$desc_equipos."'/>
									<tr ".$resalt." >
										<th><center>$x</center></th>
										<td style='text-transform:uppercase;'>$names<div id='descpend'></div></td>
										$detallequipos
										<td><center>".orderfecha($fecha2)."</center></td>														
										<td>
											<center>
												<div class='custom-control custom-checkbox mr-sm-2'>
													<div class='form-check'>
														<input name='realizado[]' value='".$fecha2.$id_check_equipos."' type='checkbox' ".$active." class='custom-control-input' id='customControlAutosizing$x'>
														<label class='custom-control-label text-primary' for='customControlAutosizing$x'><b>OK</b></label>
													</div>
												</div>
											</center>
										</td>
										<td>
											<button type='submit' class='btn btn-primary'".$activebutton.">Guardar 
											</button>
										</td>
									</tr>";									
									$x++;
							}
						?>
					</tbody>
				</table>
			</form>

		</div>
		<br/>		
		<?php include("pie-pagina.php");?>
	</div>
    <!-- Optional JavaScript-->
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <script src="js/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>    
    <script src="js/summernote-bs4.js"></script>
	<script language="javascript">	
		$('form').submit(function(e){
			// si la cantidad de checkboxes "chequeados" es cero,
			// entonces se evita que se envíe el formulario y se
			// muestra una alerta al usuario
			if ($('input[type=checkbox]:checked').length === 0) {
				e.preventDefault();
				alert('Debe seleccionar al menos un valor');
			}
		});
	</script>	
</body>
</html>
<?php
}
?>
