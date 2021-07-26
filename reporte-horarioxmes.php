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
	<title>Reporte horario por mes</title>
</head>
<body>
	<div class="container-fluid">
		<!-- Content here -->
		<div class="container-fluid">  
	<!-- Start Menu Principal	-->
		<?php include("menu-cabecera.php");?>
	<!-- End Menu Principal	-->
			<br/>
			<h1><center>Reporte horario por mes</center></h1>
			<br/>
			<form class="form-horizontal" method="GET" action="reporte-horarioxmes.php#msg">
				<div id="content-center">
					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-5 col-form-label"><b>MES</b></label>
						<div class="col-sm-4">
							<select class="form-control" name="mes">
								<?php
									$mes_actual = date('m');
									
									for($x = 1;$x <= 12;$x++){										
										if($mes_actual > 12){
											$mes_actual= $mes_actual - 12;
										}
										if($mes_actual < 10 && $x == 1){
											$mes_actual= substr($mes_actual,1,1);
										}
										if($x == $mes_actual){
											print "
											<option value='$mes_actual' selected='selected'>";print generar_mes($mes_actual)."</option>";
											$mes_actual++;
										}else{
											print "
											<option value='$mes_actual'>";print generar_mes($mes_actual)."</option>";
											$mes_actual++;
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-5 col-form-label"><b>AÑO</b></label>
						<div class="col-sm-3">
							<select class="form-control" name="anio">
								<?php
									$anio = 2020;
									$anio_actual = date('Y');
									$i = 1;
									while($i <= 5){
										if($anio == $anio_actual){
											print "<option value='$anio' selected='selected'>$anio</option>";
											$anio = $anio + 1;
										}else{
											print "<option value='$anio'>$anio</option>";
											$anio = $anio + 1;
										}										
										$i++;
									}
								?>
							</select>
						</div>
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
		</div>
	</div>	
			<?php
	/* recibe datos desde 'reporte-turnosxfecha.php'
	*/
					if(isset($_GET['mes'])){
				?>
	<!--fecha y título del reporte-->
					<center>
						
					<?php
						$mes = $_GET['mes'];
						$anio = $_GET['anio'];
						$numdias = date('t',mktime(0,0,0,$mes,1,$anio));//cantidad de dias en el mes
						$n = $numdias + 2;
						$nommes = generar_mes($mes);
						
						$fecha_ini = $_GET['anio']."-".$_GET['mes']."-01";
						$fecha_fin = $_GET['anio']."-".$_GET['mes']."-".$numdias;
						mysqli_set_charset($connect, "utf8");
						$con = "SELECT dni_usu FROM horario
								WHERE fecha_hora >= '$fecha_ini' AND fecha_hora <= '$fecha_fin'";
						$query = mysqli_query($connect,$con);
						$i = 1;
						if($row= mysqli_fetch_array($query)){
								?>
								<center>
									<?php
									print "<h4 class='text-primary'>Cronograma del Mes de $nommes de $anio</h4>";
									?>
								</center>
						<table class="table-striped" border="2px" id="msg">
							<thead>
								
								<tr class="table-primary">
									<th rowspan="2"><center>N°</center></th>
									<th rowspan="2"><center>A / N</center></th>
									<?php
										$i = 1;
										$numdias = date('t',mktime(0,0,0,$mes,1,$anio));//cantidad de dias en el mes
										while($i <= $numdias){
											print "<th><center>$i</center></th>";
											$i++;
										}
									?>
								</tr>
								<tr class="table-primary">
									<?php
										$i = 1;
										$running_day = date('w',mktime(0,0,0,$mes,1,$anio));//numero de dia que inicia el mes
										$days_in_month = date('t',mktime(0,0,0,$mes,1,$anio));//cantidad de dias en el mes
										
										while($i <= $days_in_month){
											switch ($running_day){  // Obtenemos el nombre en castellano del dia
												case 0 : $day_name = "D";
													break;
												case 1 : $day_name = "L";
													break;
												case 2 : $day_name = "M";
													break;
												case 3 : $day_name = "M";
													break;
												case 4 : $day_name = "J";
													break;
												case 5 : $day_name = "V";
													break;
												case 6 : $day_name = "S";
													break;
											}
											print "<th><center>$day_name</center></th>";
											$i++;
											$running_day++;
											if($running_day > 6 ){
												$running_day = 0;
											}
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
									mysqli_set_charset($connect, "utf8");
									$con = "SELECT u.dni_usu,concat(apellidos_usu,', ',nombres_usu) AS name FROM horario AS h
											INNER JOIN usuario AS u 
											ON h.dni_usu=u.dni_usu
											WHERE fecha_hora >= '$fecha_ini' AND fecha_hora <= '$fecha_fin' 
											GROUP BY u.dni_usu
											ORDER BY name ASC";
									$query = mysqli_query($connect,$con);
									$i = 1;
									
									while($row= mysqli_fetch_array($query)){
										$dni = $row["dni_usu"];
										$names = $row["name"];
										$names = mb_convert_case($names, MB_CASE_UPPER, "UTF-8");
										print "
											<tr>
												<th class='table-primary'><small><center><b>$i</b></center></small></th>
												<td class='table-primary'><small><b>$names</b></small></td>";												
										$con2 = "SELECT dni_usu,turno_hora,fecha_hora
												FROM horario WHERE dni_usu='$dni' AND fecha_hora >= '$fecha_ini' AND fecha_hora <= '$fecha_fin' ORDER BY fecha_hora ASC";
										$query2 = mysqli_query($connect,$con2);

										while($row2= mysqli_fetch_array($query2)){
											$turno_hora = $row2["turno_hora"];
											$turno_hora = mb_convert_case($turno_hora, MB_CASE_UPPER, 'UTF-8');
											if($turno_hora == "--"){$turno_hora ="";}											
											print "
												<td width='40px'><center>$turno_hora</center></td>";
										}
										print "
											</tr>";
										$i++;
									}
								?>							
							</tbody>
					</table>	
					<?php }else{
							print "
							<tr>
								<td colspan='4'><h5 class='text-info'>No hay Registros</h5><p class='text-info'>No se registró el horario del mes de $nommes de $anio</p></td>
							</tr>";
						}
					}?>						
					</center>
		<br/>
	<div class="container-fluid">
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
