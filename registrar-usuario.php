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

		<title>Registrar Nuevo Usuario</title>
	</head>
	<body onload="FocusText()">
		<div class="container-fluid">
			<div class="container-fluid">
		
		<!-- Start Menu Principal	-->
			<?php include("menu-cabecera.php");?>
		<!-- End Menu Principal	-->
				<br/>
					<h1><center>Registrar nuevo usuario</center></h1>
					<hr/>
					<form method="post" action="reg-usuario.php" name="frmUsuario">
						<div id="content-center">
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>DNI</b></label>
								<div class="col-sm-4">
									<input type="text" name="dni" class="form-control" id="colFormLabel" placeholder="DNI">
								</div>
							</div>
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Nombres</b></label>
								<div class="col-sm-6">
									<input type="text" name="nombres" class="form-control" id="colFormLabel" placeholder="Nombres">
								</div>
							</div>
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Apellidos</b></label>
								<div class="col-sm-6">
									<input type="text" name="apellidos" class="form-control" id="colFormLabel" placeholder="Apellidos">
								</div>
							</div>
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Usuario</b></label>
								<div class="col-sm-4">
									<input type="text" name="usuario" class="form-control" id="colFormLabel" placeholder="Usuario">
								</div>
							</div>
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Contraseña</b></label>
								<div class="col-sm-6">
									<input type="password" name="contrasena" class="form-control" id="colFormLabel" placeholder="Contraseña">
								</div>
							</div>  
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Celular</b></label>
								<div class="col-sm-4">
									<input type="text" name="celular" class="form-control" id="colFormLabel" placeholder="Celular">
								</div>
							</div>
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Correo</b></label>
								<div class="col-sm-6">
									<input type="text" name="correo" class="form-control" id="colFormLabel" placeholder="Correo">
								</div>
							</div>
							<div class="form-group row">
								<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Habilitado para Horario</b></label>
								<div class="col-sm-3">
									<select class="form-control" name="activo">
										<option value="si">Si</option>
										<option value="no">No</option>
									</select>
								</div>
							</div>							
						</div>	
						<br/>
						<center>
							<button type="reset" class="btn btn-info"><i class="icon-repeat"></i> Restaurar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
								<path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
								</svg>
							</button><small> &nbsp;&nbsp;&nbsp;</small>
							<button type="submit" class="btn btn-primary">Guardar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
								<path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
								</svg>
							</button><small> &nbsp;&nbsp;&nbsp;</small>
							<a type="button" class="btn btn-secondary" href="index.php">Cancelar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
								<path fill-rule="evenodd" d="M4 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5A.5.5 0 0 0 4 8z"/>
								</svg>
							</a>
						</center>
					</form>
				
			
			</div>
			<br/>
			<?php
	/* muestra los mensajes deacuerdo a la respuesta de 'reg-usuario.php'
	 */
				if(isset($_GET['msg'])){
					if($_GET['msg'] == 'ok'){
						print 
						'<div class="alert alert-success alert-dismissible fade show" role="alert" id="msg">
							<center><h5>Guardado</h5><h6>Nuevo Usuario Registrado</h6></center>
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
			var dni=document.forms["frmUsuario"]["dni"];
			dni.focus();
		}
	</script>
	</body>
</html>
<?php
}
?>
