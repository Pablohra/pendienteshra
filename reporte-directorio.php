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

    <title>Reporte Directorio</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">
  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->

			<br/>
			<h1><center>Reporte Directorio</center></h1>
			<br/>
			<table class="table table-striped">
				<thead>
					<tr class="alert alert-secondary">
						<th scope="col"><center>N°</center></th>
						<th scope="col"><center>Apellidos y Nombres</center></th>
						<th scope="col"><center>Celular</center></th>
						<th scope="col"><center>Correo</center></th>
					</tr>
				</thead>
				<tbody>
					<?php
						mysqli_set_charset($connect, "utf8");
						$con = "SELECT dni_usu,concat(apellidos_usu,', ',nombres_usu) AS name,celular_usu,correo_usu
								FROM usuario ORDER BY name ASC";
						$query = mysqli_query($connect,$con);
						$query2 = mysqli_query($connect,$con);
						$i = 1;
						
						if($fila= mysqli_fetch_array($query2)){
							while($row= mysqli_fetch_array($query)){
								$dni_usu = $row['dni_usu'];
								$names = $row['name'];
								$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
								
								$correo_usu = $row['correo_usu'];
								$celular_usu = $row['celular_usu'];
								
								print "
									<tr>
										<th><center>$i</center></th>
										<td>$names</td>
										<td><center>$celular_usu</center></td>
										<td>$correo_usu</td>
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
