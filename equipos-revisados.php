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
    <title>Equipos revisados</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->
			<br/>
			<h1><center>Equipos revisados</center></h1>
			<br/>
			<a href="revisar-equipos.php">Revisar equipos</a><br/><br/>			
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-horario.php'
	 */
				if(isset($_GET['msg'])){
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
				<table class="table table-striped table-bordered">
					<thead>
						<tr class="alert alert-success">
							<th scope="col"><center>N°</center></th>
							<th scope="col"><center>Responsable</center></th>
							<th scope="col"><center>Equipos a revisar</center></th>
							<th scope="col"><center>Observaciones</center></th>
							<th scope="col"><center>Fecha revisado</center></th>
							<th scope="col"><center>Fecha asignado</center></th>							
						</tr>
					</thead>
					<tbody>
						<?php
							mysqli_set_charset($connect, "utf8mb4");							
							$con = "SELECT * FROM equipos";
							$query = mysqli_query($connect,$con);
							$i = 1;
							$usuario_login = $_COOKIE['usuario'];
							
							if($fila= mysqli_fetch_array($query)){
								$fecha_actual = date("Y-m-d");
								$fecha_actual = strtotime('-2 day', strtotime($fecha_actual));
								$fecha_actual = date('Y-m-d', $fecha_actual);
								$x = 1;
									
								$con = "SELECT id_check_equipos,fech_check_equipos,u.dni_usu AS dni,concat(nombres_usu,' ',apellidos_usu) AS name,desc_equipos,check_equipos,obs_equipos,fech_check_equipos,fech_asig_equipos
										FROM usuario as u INNER JOIN equipos_check as e
										ON u.dni_usu=e.check_por_equipos WHERE fech_check_equipos>='$fecha_actual' AND check_equipos='si'
										ORDER BY fech_check_equipos DESC";
								$query2 = mysqli_query($connect,$con);

								while($row= mysqli_fetch_array($query2)){
									$names = $row['name'];
									$dni = $row['dni'];
									$fech_check_equipos = $row['fech_check_equipos'];
									$desc_equipos = $row['desc_equipos'];
									$fech_asig_equipos = $row['fech_asig_equipos'];
									$fech_check_equipos2 = substr($fech_check_equipos,0,10);
									
									$obs_equipos = $row['obs_equipos'];
									$id_check_equipos = $row['id_check_equipos'];
									
									/*$con = "SELECT * FROM equipos_check WHERE check_por_equipos = '$dni'";
									$query3 = mysqli_query($connect,$con);
									
									if($fila2= mysqli_fetch_array($query3)){
										$obs_equipos = $fila2['obs_equipos'];
										$id_check_equipos = $fila2['id_check_equipos'];
									}else{
										$obs_equipos = "";
										$id_check_equipos = "";
									}*/
									//print $id_check_equipos;
									
									$active_edit_equip = "no";
									$fecha_actual = date("Y-m-d");
									
									if($dni == $usuario_login && $fech_check_equipos2 == $fecha_actual){
										$active_edit_equip = "si";
										$resalt = "class='table-primary'";
									}
									if($dni == $usuario_login){
										$resalt = "class='table-primary'";
									}else{
										$resalt = "";
									}
									if($active_edit_equip == "si"){
										$active = "";
										$obs_equipos2 =
											'<td>
												<div style="text-transform:uppercase;">
													'.$obs_equipos.' 
												</div>
												<a class="text-decoration-none" data-toggle="modal" data-target="#exampleModal'.$x.'" href="#">
													Editar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
													</svg>
												</a>
												<div class="modal fade" id="exampleModal'.$x.'" tabindex="-1" aria-labelledby="exampleModalLabel'.$x.'" aria-hidden="true">
													<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel'.$x.'">Editar Observaciones</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<form method="POST" action="upd-check-equipos.php">
																<div class="modal-body" style="text-transform:uppercase;">
																	<input type="hidden" name="id_check_equipos" value="'.$id_check_equipos.'"/>
																	<input type="hidden" name="fech_asig_equipos" value="'.$fech_check_equipos.'"/>
																	<textarea id="summernote'.$x.'" rows="6" name="obs_equipos" placeholder="Observaciones">'.$obs_equipos.'</textarea>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar 
																		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
																			<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
																			<path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
																		</svg>
																	</button>
																	<button type="submit" class="btn btn-primary">Guardar Cambios 
																		<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																			<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
																			<path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
																		</svg>
																	</button>
																</div>																
															</form>
														</div>
													</div>
												</div>
											</td>
											';	
										}else{
											$active = "disabled";
											$obs_equipos2 = 
											"<td style='text-transform:uppercase;'>
												$obs_equipos
											</td>";
										}
										print "
											<tr ".$resalt.">
												<th><center>$x</center></th>
												<td style='text-transform:uppercase;'>$names<div id='descpend'></div></td>
												<td style='text-transform:uppercase;'>$desc_equipos</td>
												$obs_equipos2
												<td><center>".orderfecha($fech_check_equipos)."<br/><small>".orderhora($fech_check_equipos)."</small></center></td>
												<td><center>".orderfecha($fech_asig_equipos)."</center></td>
											</tr>
											";
										$x++;
									}
							}else{
								
								print "
									<tr>
										<td class='alert alert-info' colspan='6'><center>No se tienen equipos revisados registrados</center></td>
									</tr>";	
							}
						?>
					</tbody>
				</table>
		<br/>			
		</div>
		<br/>		
		<?php include("pie-pagina.php");?>
	</div>
    <!-- Optional JavaScript-->
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>    
    <script src="js/summernote-bs4.js"></script>
	<script language="javascript">
		$('#summernote').summernote({
			height: 250,
			width: 850
		});
		$('#summernote1').summernote({
			height: 250
		});
		$('#summernote2').summernote({
			height: 250
		});
		$('#summernote3').summernote({
			height: 250
		});
		$('#summernote4').summernote({
			height: 250
		});
		$('#summernote5').summernote({
			height: 250
		});
		$('#summernote6').summernote({
			height: 250
		});
		$('#summernote7').summernote({
			height: 250
		});
	</script>	
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
