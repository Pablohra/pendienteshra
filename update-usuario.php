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
    <link rel="stylesheet" href="css/bootstrap.css">
    
    <script type="text/javascript" src="highslide/highslide-with-html.js"></script>
	<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
	
	<script type="text/javascript">
		hs.graphicsDir = 'highslide/graphics/';
		hs.outlineType = 'rounded-white';
		hs.showCredits = false;
		hs.wrapperClassName = 'draggable-header';
	</script>

    <title>Actualizar datos de usuario</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">
  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->

			<br/>
			<h1><center>Actualizar datos de usuario</center></h1>
			<br/>
			<table class="table table-striped" id="msgupdusu">
				<thead>
					<tr class="alert alert-secondary">
						<th scope="col"><center>N°</center></th>
						<th scope="col"><center>DNI</center></th>
						<th scope="col"><center>Apellidos y Nombres</center></th>
						<th scope="col"><center>Celular</center></th>
						<th scope="col"><center>Correo</center></th>
						<th scope="col"><center>Horario</center></th>
					</tr>
				</thead>
				<tbody>
					<?php
						mysqli_set_charset($connect, "utf8");
						$con = "SELECT dni_usu,concat(apellidos_usu,', ',nombres_usu) AS name,celular_usu,correo_usu,activo_usu
								FROM usuario ORDER BY name ASC";
						$query = mysqli_query($connect,$con);
						$query2 = mysqli_query($connect,$con);
						$i = 1;
						
						if($fila= mysqli_fetch_array($query2)){
							while($row= mysqli_fetch_array($query)){
								$dni_usu = $row['dni_usu'];
								$activo_usu = ucwords($row['activo_usu']);
								$names = $row['name'];
								$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
								
								$correo_usu = $row['correo_usu'];
								$celular_usu = $row['celular_usu'];								
								print "
									<tr>
										<th><center>$i</center></th>
										<td>
											$dni_usu 
											<a href='#' title='Editar DNI' onclick=\"return hs.htmlExpand(this,{ headingText:'Editar DNI'});\">
												<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
												<path fill-rule='evenodd' d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
												</svg>
											</a>
											<div class='highslide-maincontent'>
												<center>
													<form method='POST' action='upd-usuario.php'>
														<input type='hidden' name='dni_usu' value='$dni_usu'/>
														<div class='col-sm-5'>
															<input type='text' name='dni_new' class='form-control' placeholder='DNI' value='$dni_usu'>
														</div>
														<br/>
														<button type='submit' class='btn btn-primary'>Actualizar
															<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-inbox' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
															<path fill-rule='evenodd' d='M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z'/>
															</svg>
														</button>
													</form>
												</center>
											</div>
										</td>
										<td>
											$names
											<a href='#' title='Editar Apellidos y Nombres' onclick=\"return hs.htmlExpand(this,{ headingText:'Editar Apellidos y Nombres'});\">
												<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
												<path fill-rule='evenodd' d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
												</svg>
											</a>
											<div class='highslide-maincontent'>
												<center>
													<form method='POST' action='upd-usuario.php'>
														<input type='hidden' name='dni_usu' value='$dni_usu'/>														
														<input type='text' name='names_new' class='form-control' placeholder='Apellidos y Nombres' value='$names'>														
														<br/>
														<button type='submit' class='btn btn-primary'>Actualizar
															<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-inbox' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
															<path fill-rule='evenodd' d='M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z'/>
															</svg>
														</button>
													</form>
												</center>
											</div>
										</td>
										<td>
											$celular_usu
											<a href='#' title='Editar Celular' onclick=\"return hs.htmlExpand(this,{ headingText:'Editar Celular'});\">
												<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
												<path fill-rule='evenodd' d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
												</svg>
											</a>
											<div class='highslide-maincontent'>
												<center>
													<form method='POST' action='upd-usuario.php'>
														<input type='hidden' name='dni_usu' value='$dni_usu'/>
														<div class='col-sm-5'>
															<input type='text' name='celular_new' class='form-control' placeholder='DNI' value='$celular_usu'>
														</div>
														<br/>
														<button type='submit' class='btn btn-primary'>Actualizar
															<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-inbox' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
															<path fill-rule='evenodd' d='M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z'/>
															</svg>
														</button>
													</form>
												</center>
											</div>
										</td>
										<td>
											$correo_usu
											<a href='#' title='Editar Correo' onclick=\"return hs.htmlExpand(this,{ headingText:'Editar Correo'});\">
												<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
												<path fill-rule='evenodd' d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
												</svg>
											</a>
											<div class='highslide-maincontent'>
												<center>
													<form method='POST' action='upd-usuario.php'>
														<input type='hidden' name='dni_usu' value='$dni_usu'/>
														<input type='text' name='correo_new' class='form-control' placeholder='DNI' value='$correo_usu'>														
														<br/>
														<button type='submit' class='btn btn-primary'>Actualizar
															<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-inbox' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
															<path fill-rule='evenodd' d='M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z'/>
															</svg>
														</button>
													</form>
												</center>
											</div>
										</td>
										<td>
											$activo_usu
											<a href='#' title='Editar Habilitado' onclick=\"return hs.htmlExpand(this,{ headingText:'Editar Habilitado'});\">
												<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
												<path fill-rule='evenodd' d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
												</svg>
											</a>
											<div class='highslide-maincontent'>
												<center>
													<form method='POST' action='upd-usuario.php'>
														<input type='hidden' name='dni_usu' value='$dni_usu'/>
														<div>
															<select class='form-control col-sm-3' name='activo_new'>
																<option value='si'>Si</option>
																<option value='no'>No</option>				
															</select>
														</div>
														<br/>
														<button type='submit' class='btn btn-primary'>Actualizar
															<svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-inbox' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
															<path fill-rule='evenodd' d='M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.933 9zM3.809 3.563A1.5 1.5 0 0 1 4.981 3h6.038a1.5 1.5 0 0 1 1.172.563l3.7 4.625a.5.5 0 0 1 .105.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625z'/>
															</svg>
														</button>
													</form>
												</center>
											</div>
										</td>
									</tr>";							
								$i++;
							}
						}else{
							print "
								<tr>
									<td class='alert alert-info' colspan='6'><center>No se tienen usuarios registrados</center></td>
								</tr>";	
						}
					?>
				</tbody>
			</table>
			<br/>
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-horario.php'
	 */
				if(isset($_GET['msg'])){
					if($_GET['msg'] == 'ok'){
						print 
						'<div class="alert alert-success alert-dismissible fade show" role="alert" id="msg">
							<center><h5>Guardado</h5><h6>Pendiente Realizado</h6></center>
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
    
</body>
</html>
<?php
}
?>
