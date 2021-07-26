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
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link href="images/fav.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/custom.css">

		<title>Registrar Nuevo Horario</title>
	</head>
	<body onload="FocusText()">
		<div class="container-fluid">
			<div class="container-fluid">
		
		<!-- Start Menu Principal-->
			<?php include("menu-cabecera.php");?>
		<!-- End Menu Principal	-->
		
			</div>
		</div>
				<br/>
				<center>
					<h1>Registrar nuevo horario</h1>
					<hr/>
					<form method="post" action="reg-horario.php" name="frmHorario">
						<div id="content-center">
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-1 col-form-label"><b>MES</b></label>
								<div class="col-sm-4">
									<select class="form-control" name="mes">
										
										<?php
											$mes = date('m');
											$i = 1;
											while($i <= 12){
												$mes = $mes + 1;
												$mesvalue = $mes;
												if($mes > 12){
													$mesvalue= $mes - 12;
												}													
												print "
													<option value='$mesvalue'>";print generar_mes($mes)."</option>";
												$i++;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="content-center">
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-1 col-form-label"><b>AÑO</b></label>
								<div class="col-sm-4">
									<select class="form-control" name="anio">
										
										<?php
											$anio = date('Y');
											$i = 1;
											while($i <= 5){
												print "<option value='$anio'>";print $anio."</option>";
												$anio = $anio + 1;
												$i++;
											}
										?>
									</select>
								</div>
							</div>
						</div>					
					<table class="table-striped table table-bordered">
						<thead>
							<tr class="table-primary">
								<th><center>N°</center></th>
								<th><center>A / N</center></th>
								<?php
									$mes = date('m');
									$i = 1;
									while($i <= 31){
										print "<th><center>$i</center></th>";
										$i++;
									}
								?>								
							</tr>
						</thead>
						<tbody>
							<?php
								mysqli_set_charset($connect, "utf8");
								$con = "SELECT dni_usu,concat(apellidos_usu,', ',nombres_usu) AS name
										FROM usuario WHERE activo_usu='si'
										ORDER BY name";
								$query = mysqli_query($connect,$con);
								$i = 1;								
								while($row= mysqli_fetch_array($query)){
									$names = $row['name'];
									$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
									$dni = $row['dni_usu'];
									$m = 1;
									print "
										<tr>
											<th class='table-primary'><center>$i</center></th>
											<td class='table-primary'>$names</td>";
											while($m <= 31){
												print "
													<td>
														<select name='$dni"."$m'>
															<option value='--".$dni.$m."'>--</option>
															<option value='mt".$dni.$m."'>MT</option>
															<option value='tn".$dni.$m."'>TN</option>
															<option value='mm".$dni.$m."'>MM</option>
														</select>
													</td>";
												$m++;
											}
									print "</tr>";
									
									print "
									<thead>
										<tr>
											<th class='table-primary'><center></center></th>
											<th class='table-primary'><center></center></th>";
											$n = 1;
											while($n <= 31){
												print "<th><center>$n</center></th>";
												$n++;
											}
									print "</tr>
									</thead>";							
									$i++;
								}
							?>
							
						</tbody>
					</table>
				<center/>
				<br/>
					<center><button type="reset" class="btn btn-info"><i class="icon-repeat"></i> Restaurar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
						<path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
						</svg>
					</button><small> &nbsp;&nbsp;&nbsp;</small>
					<button type="submit" class="btn btn-primary">Guardar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-all" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M12.354 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
						<path d="M6.25 8.043l-.896-.897a.5.5 0 1 0-.708.708l.897.896.707-.707zm1 2.414l.896.897a.5.5 0 0 0 .708 0l7-7a.5.5 0 0 0-.708-.708L8.5 10.293l-.543-.543-.707.707z"/>
						</svg>
					</button><small> &nbsp;&nbsp;&nbsp;</small>
					<a type="button" class="btn btn-secondary" href="index.php">Cancelar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
						<path fill-rule="evenodd" d="M4 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5A.5.5 0 0 0 4 8z"/>
						</svg>
					</a></center>
				</form>			
			<br/>
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-horario.php'
	 */
				if(isset($_GET['msg'])){
					if($_GET['msg'] == 'ok'){
						print 
						'<div class="alert alert-success alert-dismissible fade show" role="alert" id="msg">
							<center><h5>Guardado</h5><h6>Nuevo Horario Registrado</h6></center>
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
	<div class="container-fluid">
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
			var dni=document.forms["frmUsu"]["mes"];
			dni.focus();
		}
	</script>
	</body>
</html>
<?php
}
?>
