<?php
if(!isset($_COOKIE['usuario'])){
	header('Location:index.php');
}else{
	require_once('configuracion.php');
?>
<!doctype html>
<html lang="en">
<head>
    <title>Registrar nuevo pendiente</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
	<link href="images/fav.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script type="text/javascript" src="highslide/highslide-with-html.js"></script>
    <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
    	
	<link rel="stylesheet" href="css/summernote-bs4.css">
	<script type="text/javascript">
		hs.graphicsDir = 'highslide/graphics/';
		hs.outlineType = 'rounded-white';
		hs.showCredits = false;
		hs.wrapperClassName = 'draggable-header';
	</script>
</head>
<body onload="FocusText()">
	<!-- Create the editor container -->
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">
			<!-- Start Menu Principal	-->
			<?php include("menu-cabecera.php");?>
			<!-- End Menu Principal	-->
				<br/>
				<h1><center>Registrar nuevo pendiente</center></h1>
				<br/>
				<form class="was-validated" method="post" action="reg-pendientes.php" name="frmPendiente1">
					<div>
						<div class="form-group row" id="id-div">
							<label for="colFormLabel" class="col-sm-2 col-form-label"><b>Fecha y Hora</b></label>
							<label for="colFormLabel" style="text-align:left; margin-top:6px;"><?php echo date("d/m/Y - g:i a"); ?></label>
						</div>
						<div class="form-group row">
							<label for="colFormLabel" class="col-sm-2 col-form-label"><b>Personal Saliente</b></label>
							<label for="colFormLabel" style="text-align:left;">
								<?php
									$names = get_pers_saliente();
									$names = explode(":",$names);
									if(isset($names[0])){
										print $names[0];
									}
									if(isset($names[2])){
										print $names[2];
									}
								?>
							</label>
							<input type="hidden" name="dni_usu" value="<?php if(isset($_COOKIE['usuario'])){print $_COOKIE['usuario'];}?>" >
							<label for="colFormLabel" style="margin-left:20px;text-align:left;" class="col-sm-2 col-form-label"><b>Personal Entrante</b></label>
							<label for="colFormLabel" style="text-align:left;">
								<?php
									$names = get_pers_entrante();
									$names = explode(":",$names);
									if(isset($names[0])){
										print $names[0];
									}
									if(isset($names[2])){
										print $names[2];
									}
								?>
							</label>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label" for="validationTextarea"><b>Descripción del Pendiente</b></label>
							<div>
								<textarea name="pendiente" id="summernote" rows="5" class="form-control is-invalid col-sm-7" placeholder="Descripción del Pendiente" required></textarea>
							</div>
						</div>
						<!--<div class="form-group row">
							<label for="colFormLabel" class="col-sm-2 col-form-label"><b>Prioridad</b></label>
							<select class="form-control col-sm-2" name="prioridad">
								<option value="media">Media</option>
								<option value="alta">Alta</option>
								<option value="baja">Baja</option>
							</select>
						</div>-->
						<center>
							<small> &nbsp;&nbsp;&nbsp;</small>
							<button type="submit" class="btn btn-primary">Guardar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
								<path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
								</svg>
						</center>
					</div>
				</form><br/>
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-usuario.php'
	 */
				if(isset($_GET['msg'])){
					if($_GET['msg'] == 'ok'){
						print 
						'<div class="alert alert-success alert-dismissible fade show" role="alert" id="msg">
							<center><h6>Nuevo Pendiente Registrado</h6></center>
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
		<table class="table table-striped table-bordered">
			<thead>
				<tr class="alert alert-secondary" id="msgpend">
					<th scope="col"><center>N°</center></th>
					<th scope="col"><center>Descripción del Pendiente</center></th>
					<!--<th scope="col"><center>Prioridad</center></th>-->
				</tr>
			</thead>
			<tbody>
				<?php
					mysqli_set_charset($connect, "utf8mb4");
					$con = "SELECT id_pend,u.dni_usu AS dni,concat(apellidos_usu,', ',nombres_usu) AS name,desc_pend,fecha_pend,priori_pend,realizado_pend
							FROM usuario as u INNER JOIN pendiente as p
							ON u.dni_usu=p.dni_usu WHERE realizado_pend = 'no'
							ORDER BY fecha_pend DESC";
					$query = mysqli_query($connect,$con);
					$query2 = mysqli_query($connect,$con);
					$i = 1;
					if($fila= mysqli_fetch_array($query2)){
						while($row= mysqli_fetch_array($query)){
							$id_pend = $row['id_pend'];
							$names = $row['name'];
							$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
							$dni = $row['dni'];
							$desc_pend = $row['desc_pend'];
							//$desc_pend = mb_convert_case($desc_pend, MB_CASE_UPPER, "UTF-8");
							$fecha_pend = orderfecha($row['fecha_pend']);
							$hora_pend = orderhora($row['fecha_pend']);
							$priori_pend = ucwords($row['priori_pend']);
							$usuario_login = $_COOKIE['usuario'];
							$active_edit_pend = "no";
							$active_edit_priori = "no";
							$fecha_actual = date("d/m/Y");
							
							if($dni == $usuario_login && $fecha_pend == $fecha_actual){
								$active_edit_pend = "si";
								$active_edit_priori = "si";
							}
							if($active_edit_pend == "si"){
								$desc_pend2 = 
								'<td>
									<div>
										'.$desc_pend.' 
									</div>									
									<a class="text-decoration-none" data-toggle="modal" data-target="#exampleModal'.$i.'" href="#">
										Editar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
										</svg>
									</a>
									<div class="modal fade" id="exampleModal'.$i.'" tabindex="-1" aria-labelledby="exampleModalLabel'.$i.'" aria-hidden="true">
										<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel'.$i.'">Editar Pendiente</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form method="POST" action="update-pendientes.php">
													<div class="modal-body">
														<input type="hidden" name="id_pend" value="'.$id_pend.'"/>
														<textarea id="summernote'.$i.'" rows="6" name="pendiente_new" placeholder="Descripción del Pendiente">'.$desc_pend.'</textarea>
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
								</td>';
							}else{
								$desc_pend2 = 
								"<td>
									$desc_pend
								</td>";
							}/*							
							switch ($priori_pend){
								case "Media": $color_alert = "warning"; break;
								case "Alta": $color_alert = "danger"; break;
								case "Baja": $color_alert = "success"; break;
								default:
								print "<br/>Error: $num no tiene respuesta<br/>"; break;
							}
							if($active_edit_priori == "si"){
								$priori_pend2 = "
									<td class='table-$color_alert'><center>
										<small>
											$priori_pend
											<a href='#' title='Editar Pendiente' onclick=\"return hs.htmlExpand(this,{ headingText:'Editar Prioridad'});\">
												<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
												<path fill-rule='evenodd' d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
												</svg>
											</a>
											<div class='highslide-maincontent'>
												<center>
													<form method='POST' name='FrmPrioridad' action='update-pendientes.php'>
														<input type='hidden' name='id_pend' value='$id_pend'/>
														<div>
															<select class='form-control col-sm-3' name='prioridad_new'>
																<option value='media'>Media</option>
																<option value='alta'>Alta</option>				
																<option value='baja'>Baja</option>
															</select>
														</div>
														<br/>
														<button type='submit' class='btn btn-primary'>Guardar
															<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-layers' viewBox='0 0 16 16'>
															<path fill-rule='evenodd' d='M3.188 8L.264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l-1.063.567L14.438 10 8 13.433 1.562 10 4.25 8.567 3.187 8z'/>
															<path fill-rule='evenodd' d='M7.765 1.559a.5.5 0 0 1 .47 0l7.5 4a.5.5 0 0 1 0 .882l-7.5 4a.5.5 0 0 1-.47 0l-7.5-4a.5.5 0 0 1 0-.882l7.5-4zM1.563 6L8 9.433 14.438 6 8 2.567 1.562 6z'/>
															</svg>
														</button>
													</form>
												</center>
											</div>
										</small></center>
									</td>
								";
							}else{
								$priori_pend2 = 
								"<td class='table-$color_alert'><center>
									<small>
										$priori_pend
									</small></center>
								</td>";
							}*/
							print "
								<tr>
									<th><center>$i</center></th>
									$desc_pend2
								</tr>";							
							$i++;	
							/*/<td><center><small>$fecha_pend<br/>$hora_pend</small></center></td>
							<td><center><small>$names</small></center></td>	*/
						}
					}else{
						print "
							<tr>
								<td class='alert alert-info' colspan='3'><center>No se tienen pendientes registrados</center></td>
							</tr>";	
					}
				?>
			</tbody>
		</table>
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
    
    <!--cambia foco al cargar el body al input del DNI-->
	<script language="javascript">
		function FocusText(){
			var dni=document.forms["frmPendiente1"]["pendiente"];
			dni.focus();
		}
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
	</script>
</body>
</html>
<?php
}
?>

