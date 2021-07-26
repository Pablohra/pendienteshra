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

    <title>Reporte de pendientes por fecha</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">
  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->
			<br/>
			<h1><center>Reporte de pendientes por fecha</center></h1>
			<br/>
			<form class="form-horizontal" method="GET" action="reporte-pendientesxfecha.php">
				<div id="content-center">
					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Desde</b></label>
						<div class="col-sm-2">
							<input name="fechadesde" type="date" id="date" />
						</div>
						<br/>					
					</div>
					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-5 col-form-label"><b>Hasta</b></label>
						<div class="col-sm-2">
							<input name="fechahasta" type="date" id="date" />
						</div>
						<br/>					
					</div>
					<center>
						<button type="submit" class="btn btn-primary">Aceptar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
							<path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
							</svg>
						</button>
					</center>
				</div>
			</form>
			<br/>
			<?php
	/* recibe datos desde 'reporte-turnosxfecha.php'
	*/
					if(isset($_GET['fechadesde'])){
				?>
	<!--fecha y título del reporte-->
						<center>
							<?php
								$fechadesde = $_GET['fechadesde'];
								$fechahasta = $_GET['fechahasta'];
								print generar_report_pendientesxfecha($fechadesde,$fechahasta);
							?>
						</center>						
				<?php }?>
		</div>		
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
