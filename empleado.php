<!DOCTYPE html>
<html>
<head>
	<title>PHP y MariaDB</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>Taller PHP y MySQL</h2><br>
		<form class="was-validated" method="post">
			<div class="form-group">
		      <label for="cedula">Cédula:</label>
		      <input type="text" class="form-control" id="cedula" name="cedula" pattern="[0-9]{10}" required>
		    </div>
		    <div class="form-group">
		      <label for="nombre">Nombre Completo:</label>
		      <input type="text" class="form-control" id="nombre" name="nombre" pattern="[a-zA-ZñÑ\s]{5,100}" required>
		    </div>
		    <div class="form-group">
		      <label for="direccion">Dirección de Residencia:</label>
		      <input type="text" class="form-control" id="direccion" name="direccion" pattern="^.*(?=.*[0-9])(?=.*[a-zA-ZñÑ\s]).*$" required>
		    </div>
		    <div class="form-group">
		      <label for="correo">Correo Electrónico:</label>
		      <input type="email" class="form-control" id="correo" name="correo" pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required>
		    </div>
		    <div class="form-group">
		      <label for="celular">Celular:</label>
		      <input type="tel" class="form-control" id="celular" name="celular" pattern="[0-9]{10}" required>
		    </div>
		    <button type="submit" class="btn btn-success">Enviar</button>
		</form>
	</div>
	<?php
		$server = "localhost:3306";
	    $user = "root";
	    $pwd = "";
	    $bd = "dbempleados";

	    $conn = new mysqli($server,$user,$pwd, $bd);

	    if ($conn->connect_errno) {
	        ?> <p>ERROR: Ha ocurrido un error en la conexión. <?=$mysqli->connect_error ?></p> <?php
	        exit;
	    }else {
	        ?> <p>La conexión es exitosa!!</p> <?php
	    }

	    if (isset($_POST["cedula"], $_POST["nombre"], $_POST["direccion"], $_POST["correo"], $_POST["celular"]) and $_POST["cedula"] !="" and $_POST["nombre"]!="" and $_POST["direccion"]!="" and $_POST["correo"]!="" and $_POST["celular"]!=""){
	    	$cedula = $_POST["cedula"];
	    	$nombre = $_POST["nombre"];
			$direccion = $_POST["direccion"];
			$correo = $_POST["correo"];
			$celular = $_POST["celular"];

			$existente = "SELECT cedula_empleado from empleados WHERE cedula_empleado = $cedula";
			if (!$result = $conn->query($existente)) {
				echo "Error al consultar la base de datos.";
				echo "Error: " . $mysqli->error . "\n";
				exit;
			}

			if($result->num_rows>0){ 
				$actualizar = "UPDATE empleados SET nombre_empleado = '$nombre', direccion_empleado = '$direccion', email_empleado='$correo', celular_empleado = '$celular' WHERE cedula_empleado = '$cedula'";
				if ($result = $conn->query($actualizar)) {
					echo "Empleados existente, se actualizaron sus datos";
				}

			}else{
				$sql = "INSERT INTO empleados (cedula_empleado,nombre_empleado,direccion_empleado,email_empleado,celular_empleado) VALUES ('$cedula','$nombre','$direccion','$correo','$celular')";
				if($result = $conn->query($sql)){
					echo "Empleado Agregado!";
				} 

			}
		}else{
			echo "Por favor complete el formulario!";
		}

	    $conn->close();
	?>
</body>
</html>