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
		<script type="text/javascript" src="js/filestyle.min.js"> </script>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/custom.css">
		<title>Registrar Nuevo Horario Desde Excel</title>
	</head>
	<body>
		<div class="container-fluid">
			<div class="container-fluid">
		<!-- Start Menu Principal-->
			<?php include("menu-cabecera.php");?>
		<!-- End Menu Principal	-->	
			<br/>
			<center>
			<h1>Registrar nuevo horario desde Excel</h1>
			<hr/>
			<form class="was-validated" name="importa" method="post" action="" enctype="multipart/form-data" >
				<div class="col-xs-4">
					<div class="form-group">
						<input type="file" class="filestyle" name="excel" required>
					</div>
				</div><br/>
				<div>
					<button class="btn btn-primary" type="submit" name="enviar"  value="Importar">Importar
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
						<path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
						</svg>
					</button><small> &nbsp;&nbsp;&nbsp;</small>
					<a type="button" class="btn btn-secondary" href="index.php">Cancelar <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
						<path fill-rule="evenodd" d="M4 8a.5.5 0 0 0 .5.5h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5A.5.5 0 0 0 4 8z"/>
						</svg>
					</a>
				</div>
				<input type="hidden" value="upload" name="action" />
				<input type="hidden" value="usuarios" name="mod">
				<input type="hidden" value="masiva" name="acc">
			</form>
			<br/>
		</div>
	</div>
<!-- PROCESO DE CARGA Y PROCESAMIENTO DEL EXCEL-->
<?php 
extract($_POST);
if (isset($_POST['action'])) {
	$action=$_POST['action'];
}
if (isset($action)== "upload"){
	//cargamos el fichero
	$archivo = $_FILES['excel']['name'];
	$tipo = $_FILES['excel']['type'];
	$destino = "cop_".$archivo;//Le agregamos un prefijo para identificarlo el archivo cargado
	if (copy($_FILES['excel']['tmp_name'],$destino)) echo "<center><p><b>Archivo Cargado Con Éxito</b></p></center>";
	
	else echo "Error Al Cargar el Archivo";
		if (file_exists ("cop_".$archivo)){
			/** Llamamos las clases necesarias PHPEcel */
			require_once('Classes/PHPExcel.php');
			require_once('Classes/PHPExcel/Reader/Excel2007.php');
			// Cargando la hoja de excel
			$objReader = new PHPExcel_Reader_Excel2007();
			$objPHPExcel = $objReader->load("cop_".$archivo);
			$objFecha = new PHPExcel_Shared_Date();
			// Asignamon la hoja de excel activa
			$objPHPExcel->setActiveSheetIndex(0);

			// Importante - conexión con la base de datos

			// Rellenamos el arreglo con los datos  del archivo xlsx que ha sido subido
			$columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
			$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
			
			//Obtenemos el mes y anio del horario en el excel
			$mesanio = textfilter($objPHPExcel->getActiveSheet()->getCell('K3')->getCalculatedValue());
			$mesanio = explode(" ",$mesanio);
			$anio = $mesanio[6];
			$mes = generar_numdmes($mesanio[5]);
			$anio_small = substr($anio,2);
			
			$fecha_reg_hora = date('Y-m-d g:i:s');
			$user_reg_hora = textfilter($_COOKIE['usuario']);
			
			//$filas = Cantidad días del mes + el campo dni
			$days_in_month = date('t',mktime(0,0,0,$mes,1,$anio));//cantidad de dias en el mes
			$row = $days_in_month + 3;
			//$filas = $filas - 1;
			
			for ($y = 7;$y <= $filas;$y++){
				$dni_usu = $objPHPExcel->getActiveSheet()->getCell('B'.$y)->getCalculatedValue();
				$x = 1;
				for($i = 4;$i <= $row;$i++){
					$dia = $x;
					$id_hora = $dni_usu.$dia.$mes.$anio_small;
					$fecha_hora = $anio.'-'.$mes.'-'.$dia;
					$letraexcel = get_letraexcel($i);
					$turno = $objPHPExcel->getActiveSheet()->getCell($letraexcel.$y)->getCalculatedValue();
					$_DATOS_EXCEL[$i]['id_hora']= $id_hora;
					$_DATOS_EXCEL[$i]['dni_usu']= $dni_usu;
					$_DATOS_EXCEL[$i]['fecha_hora'] = $fecha_hora;
					$_DATOS_EXCEL[$i]['turno_hora'] = textfilter($turno);
					$_DATOS_EXCEL[$i]['fecha_reg_hora'] = $fecha_reg_hora;
					$_DATOS_EXCEL[$i]['user_reg_hora'] = $user_reg_hora;
					$x++;
				}
				$errores=0;
				
				foreach($_DATOS_EXCEL as $campo => $valor){
					$sql = "INSERT INTO horario(id_hora,dni_usu,fecha_hora,turno_hora,fech_reg_hora,user_reg_hora)  VALUES ('";
					foreach ($valor as $campo2 => $valor2){
						$campo2 == "user_reg_hora" ? $sql.= $valor2."');" : $sql.= $valor2."','";
					}
					$result = mysqli_query($connect, $sql);
					if (!$result){ echo "Error al insertar registro ".$campo;$errores+=1;}
				}
			}		
			echo "<hr> <div class='col-xs-12'>
					<div class='form-group'>";
				echo "<strong><center>ARCHIVO IMPORTADO CON ÉXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
			echo "</div>
			</div> ";
				//Borramos el archivo que esta en el servidor con el prefijo cop_
				unlink($destino);
		}
				//si por algun motivo no cargo el archivo cop_
		else{
			echo "Primero debes cargar el archivo con extencion .xlsx";
		}
}
		?>
<?php 
			if (isset($action)) {
					$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				}
			if (isset($filas)) {
					$columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
				}
			if (isset($filas)) {
					$filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				}

if (isset($action)== "upload"){
	echo '<table width="100%"class="table-striped" border="2px">';
		echo '<thead>';
			echo '<tr>';
				$title = $objPHPExcel->getActiveSheet()->getCell('K3')->getCalculatedValue();
				echo '<th class="table-primary" colspan="'.$row.'"><center>'.$title.'</center></th>';
			echo '</tr>';
			echo '<tr class="table-primary">';
				
				echo '<th><center>N°</center></th>';
				echo '<th><center>DNI</center></th>';
				echo '<th><center>Apellidos y Nombres</center></th>';
				$row = $row-3;
				for($i=1;$i<=$row;$i++){
					echo '<th><center>'.$i.'</center></th>';
				}
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
	//$count=0;
	/*foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row){
		$count++;
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		echo '<tr>';
		foreach ($cellIterator as $cell){
			if (!is_null($cell)){
				$value = $cell->getCalculatedValue();
				echo '<td>';
				echo $value . ' ';
				echo '</td>';
			}
		}
		echo '</tr>';
	}*/
	$row = $row+3;
	for ($y = 7;$y <= $filas;$y++){
		$num = $objPHPExcel->getActiveSheet()->getCell('A'.$y)->getCalculatedValue();
		$dni_usu = $objPHPExcel->getActiveSheet()->getCell('B'.$y)->getCalculatedValue();
		$name_usu = $objPHPExcel->getActiveSheet()->getCell('C'.$y)->getCalculatedValue();
		$x = 1;
		echo '<tr>';
			echo '<td>'.$num.'</td>';
			echo '<td>'.$dni_usu.'</td>';
			echo '<td>'.$name_usu.'</td>';
		for($i = 4;$i <= $row;$i++){
			$dia = $x;
			$id_hora = $dni_usu.$dia.$mes.$anio_small;
			$fecha_hora = $anio.'-'.$mes.'-'.$dia;
			$letraexcel = get_letraexcel($i);
			$turno = $objPHPExcel->getActiveSheet()->getCell($letraexcel.$y)->getCalculatedValue();
			$_DATOS_EXCEL[$i]['id_hora']= $id_hora;
			$_DATOS_EXCEL[$i]['dni_usu']= $dni_usu;
			$_DATOS_EXCEL[$i]['fecha_hora'] = $fecha_hora;
			$_DATOS_EXCEL[$i]['turno_hora'] = textfilter($turno);
			$_DATOS_EXCEL[$i]['fecha_reg_hora'] = $fecha_reg_hora;
			$_DATOS_EXCEL[$i]['user_reg_hora'] = $user_reg_hora;
			$x++;
			echo '<td>'.$turno.'</td>';
		}
		echo '</tr>';		
	}
		echo '</tbody>';
	echo '</table>';
}
?>			
	<div class="container-fluid">
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
