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
    <title>Pendientes</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->
			<br/>
			<h1><center>Pendientes</center></h1>
			<br/>	
			<div>					
				<div class="form-group row">
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
				<a href="update-pend-realizados.php">Ver pendientes realizados</a>
				<!--<a href="update-pend-realizados.php">Ver pendientes realizados</a>-->
			</div><br/>
			<form method="post" action="upd-pendientes-dia.php" name="frmHorario">
				<table class="table table-striped table-bordered">
					<thead>
						<tr class="alert alert-primary">
							<th scope="col"><center>N°</center></th>
							<th scope="col"><center>Descripción del Pendiente</center></th>
							<!--<th scope="col"><center>Prioridad</center></th>-->
							<th scope="col"><center>Registrado por</center></th>
							<th scope="col"><center>Fecha Registrado</center></th>							
							<th scope="col"><center>Realizado</center></th>
						</tr>
					</thead>
					<tbody>
						<?php
							mysqli_set_charset($connect, "utf8mb4");
							$con = "SELECT id_pend,u.dni_usu AS dni,concat(nombres_usu ,' ',apellidos_usu) AS name,desc_pend,fecha_pend,priori_pend,realizado_pend
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
									
									/*if($priori_pend == "Media"){
										$priori_pend =
										"<td class='table-warning'>
											<center>
												<small>
													$priori_pend
												</small>
											</center>
										</td>";
									}else{
										if($priori_pend == "Alta"){
										$priori_pend =
										"<td class='table-danger'>
											<center>
												<small>
													$priori_pend
												</small>
											</center>
										</td>";
										}else{
											$priori_pend =
											"<td class='table-success'>
												<center>
													<small>
														$priori_pend
													</small>
												</center>
											</td>";
										}
									}*/									
									print "
										<tr>
											<th><center>$i</center></th>
											<td><div id='descpend'>$desc_pend</div></td>
											<td><center><small>$names</small></center></td>
											<td><center>$fecha_pend<br/><small>$hora_pend</small></center></td>											
											<td>
												<center>
													<div class='custom-control custom-checkbox mr-sm-2'>
														<div class='form-check'>
															<input name='realizado[]' value='$id_pend' type='checkbox' class='custom-control-input' id='customControlAutosizing$i'>
															<label class='custom-control-label text-primary' for='customControlAutosizing$i'><b>OK</b></label>
														</div>
													</div>
												</center>
											</td>
										</tr>";							
									$i++;
								}
							}else{
								print "
									<tr>
										<td class='alert alert-info' colspan='6'><center>No se tienen pendientes registrados</center></td>
									</tr>";	
							}
						?>
					</tbody>
				</table>
				<center>
					<button type="submit" class="btn btn-primary">Guardar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
						<path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
						</svg>
					</button>
				</center>
			</form>
		<br/>			
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-horario.php'
	 */
				if(isset($_GET['msg'])){
					if($_GET['msg'] == 'ok'){
						print 
						'<div class="alert alert-success alert-dismissible fade show" role="alert" id="msg">
							<center><h6>Pendiente Realizado</h6></center>
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
		</div>
		<br/>		
		<?php include("pie-pagina.php");?>
	</div>
    <!-- Optional JavaScript-->

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <!--cambia foco al cargar el body al input del DNI-->
	<script language="javascript">
		function FocusText(){ 
			var dni=document.forms["frmPendiente"]["pendiente"];
			dni.focus();
		}
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
