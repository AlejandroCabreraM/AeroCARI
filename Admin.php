<?php
include("conexion.php");

$idVuelo = "";
$costoVuelo = "";
$origen = "";
$destino = "";
$TUA = "";
$fechaVuelo = "";

//crear un vuelo
if (isset($_POST["buscar"])) {
    $idVuelo = $_POST["idVuelo"];
    $query = "SELECT `numVuelo`, `costoVuelo`, `origen`, `destino`, `TUA`, `fechaVuelo` FROM `vuelo` WHERE `numVuelo` = '$idVuelo'";
    $resultado = $conn->query($query);

    // Verificar si la consulta fue exitosa
    if ($resultado) {
        // Obtener los datos de la consulta en un arreglo asociativo
        $datosVuelo = $resultado->fetch_assoc();
        $resultado->free();

        $idVuelo = $datosVuelo["numVuelo"];
        $costoVuelo = 1095;
        $origen = $datosVuelo["origen"];
        $destino = $datosVuelo["destino"];
        $TUA = $datosVuelo["TUA"];
        $fechaVuelo = $datosVuelo["fechaVuelo"];

        echo "<script> alert('Busqueda exitosa'); </script>";
    } else {
        echo "<script> alert('Error al buscar vuelo'); window.location='Admin.php'</script>";
    }
    $conn->close();
}

if (isset($_POST["Crear"])) {
    $origen = $_POST["origenc"];
    $destino = $_POST["destinoc"];
    $fecha = $_POST["fechac"];
    $tua = $_POST["tuac"];
    $coste = $_POST["costec"];

    $sqlgrabar = "INSERT INTO `vuelo`(`numVuelo`, `costoVuelo`, `origen`, `destino`, `TUA`, `fechaVuelo`) VALUES (null,'$coste','$origen','$destino','$tua','$fecha')";

    if (mysqli_query($conn, $sqlgrabar)) {
        echo "<script> alert('Vuelo registrado con éxito'); </script>";

        // Obtener el ID del vuelo recién insertado
        $idVueloInsertado = mysqli_insert_id($conn);

        // Generar automáticamente los asientos para el nuevo vuelo
        for ($i = 1; $i <= 60; $i++) {
            $numeroAsiento = $i;
            $costoAsiento = 200; // Puedes ajustar este valor según tus necesidades

            // Insertar el asiento en la tabla 'asiento'
            $sqlInsertarAsiento = "INSERT INTO `asiento`(`numeroAsiento`, `numVuelo`, `costoAsiento`) VALUES ('$numeroAsiento','$idVueloInsertado','$costoAsiento')";
            
            if (!mysqli_query($conn, $sqlInsertarAsiento)) {
                echo "<script> alert('Error al insertar asiento'); </script>";
            }
        }

        echo "<script> window.location='Admin.php'; </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "<script> alert('Error al registrar vuelo'); window.location='Admin.php'</script>";
    }
    $conn->close();
}

if (isset($_POST["Eliminar"])) {
    $idVuelo = $_POST["idVueloE"];

    // Eliminar los asientos asociados al vuelo
    $sqlEliminarAsientos = "DELETE FROM `asiento` WHERE `numVuelo` = '$idVuelo'";

    if (mysqli_query($conn, $sqlEliminarAsientos)) {
        // Asientos eliminados con éxito, ahora eliminar el vuelo
        $sqlEliminarVuelo = "DELETE FROM `vuelo` WHERE `numVuelo` = '$idVuelo'";

        if (mysqli_query($conn, $sqlEliminarVuelo)) {
            echo "<script> alert('Vuelo número $idVuelo y sus asientos asociados eliminados con éxito'); window.location='Admin.php'</script>";
        } else {
            echo "Error al eliminar el vuelo: " . $sqlEliminarVuelo . "<br>" . mysqli_error($conn);
            echo "<script> alert('Error al eliminar vuelo y sus asientos asociados'); window.location='Admin.php'</script>";
        }
    } else {
        echo "Error al eliminar los asientos: " . $sqlEliminarAsientos . "<br>" . mysqli_error($conn);
        echo "<script> alert('Error al eliminar asientos asociados al vuelo'); window.location='Admin.php'</script>";
    }

    $conn->close();
}


if (isset($_POST["Actualizar"])) {
    $idVuelo = $_POST["idVueloA"];
    $origen = $_POST["origenA"];
    $destino = $_POST["destinoA"];
    $fecha = $_POST["fechaA"];
    $tua = $_POST["tuaA"];
    $coste = $_POST["costeA"];

    $sqlgrabar = "UPDATE `vuelo` SET `costoVuelo`='$coste',`origen`='$origen',`destino`='$destino',`TUA`='$tua',`fechaVuelo`='$fecha' WHERE `numVuelo` = '$idVuelo'";

    if (mysqli_query($conn, $sqlgrabar)) {
        echo "<script> alert('Vuelo numero $idVuelo Actualizado con exito '); window.location='Admin.php'</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "<script> alert('Error al actualizar vuelo'); window.location='Admin.php'</script>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
</head>

<body>
    <section class="seccionTitulo">
        <header style="background-color: hsla(0, 0%, 0%, 0.2)">
            <h1>Aeropuerto AeroCaRi</h1>
            <p>Tu viaje comienza aquí</p>
        </header>
    </section>

    <nav>
        <a href="FormularioAvion.php">Reservar</a>
        <a href="index.html">Destinos</a>
        <a href="Promociones.html">Promociones</a>
        <details>
            <summary><img src="img/user.png" width="30" height="30" style="vertical-align: middle;"><br>Login</summary>
            <ul>
                <li><a href="FormularioInicio.html">Iniciar sesión</a></li>
                <li><a href="Registrarse.html">Registrarme</a></li>
                <li><a href="Logout.php">Cerrar sesión</a></li>
            </ul>
        </details>
    </nav>
    <br>


    <form name="CRATE" action="Admin.php" method="post">
        <h2>Crear Tabla Vuelo</h2>

        <input type="text" name="origenc" required />
        <label>Origen</label><br>

        <input type="text" name="destinoc" required />
        <label>Destino</label><br>

        <input type="date" name="fechac" required />
        <label>Fecha</label><br>

        <input type="text" name="tuac" required />
        <label>TUA</label><br>

        <input type="text" name="costec" required />
        <label>Coste de Avion</label><br>

        <br>
        <div>
            <input type="submit" name="Crear" value="Crear">
        </div>
    </form>
    <br><br><br>

    <form name="DELETE" action="Admin.php" method="post">
        <h2>Eliminar Tabla Vuelo</h2>
        <select name="idVuelo">
            <option value="" disabled selected>Seleccione ID del Vuelo</option>
            <?php
            include("conexion.php");
            // Consulta SQL para obtener los IDs de vuelo desde la base de datos

            $sql = "SELECT numVuelo FROM vuelo";
            $result = mysqli_query($conn, $sql);

            // Genera las opciones del select
            while ($row = mysqli_fetch_assoc($result)) {
                //echo "<option disabled selected>Seleccione ID del Vuelo</option>";
                echo "<option value='" . $row['numVuelo'] . "'>" . $row['numVuelo'] . "</option>";
            }
            ?>
        </select>
        <input type="text" name="idVueloE" value="<?php echo $idVuelo ?> " readonly>
        <label>Id Vuelos</label><br>

        <input type="text" name="origenE" value="<?php echo $origen ?> " readonly>
        <label>Origen</label><br>

        <input type="text" name="destinoE" value="<?php echo $destino ?> " readonly>
        <label>Destino</label><br>

        <input type="date" name="fechaE" id="fechaE" value="<?= $fechaVuelo ?>" readonly>
        <label>Fecha</label><br>

        <input type="text" name="tuaE" value="<?php echo $TUA ?> " readonly>
        <label>TUA</label><br>

        <input type="text" name="costeE" value="<?php echo $costoVuelo ?> " readonly>
        <label>Coste de Avion</label><br>

        <br>
        <div>
            <input type="submit" name="buscar" value="Buscar" />
            <input type="submit" name="Eliminar" value="Eliminar" />
        </div>
    </form>
    <br><br><br>

    <form name="UPDATE" action="Admin.php" method="post">
        <h2>Actualizar Tabla Vuelo</h2>
        <select name="idVuelo">
            <option value="" disabled selected>Seleccione ID del Vuelo</option>
            <?php
            include("conexion.php");
            // Consulta SQL para obtener los IDs de vuelo desde la base de datos

            $sql = "SELECT numVuelo FROM vuelo";
            $result = mysqli_query($conn, $sql);

            // Genera las opciones del select
            while ($row = mysqli_fetch_assoc($result)) {
                //echo "<option disabled selected>Seleccione ID del Vuelo</option>";
                echo "<option value='" . $row['numVuelo'] . "'>" . $row['numVuelo'] . "</option>";
            }

            // Cierra la conexión a la base de datos
            mysqli_close($conn);
            ?>
        </select>
        <input type="text" name="idVueloA" value="<?php echo $idVuelo ?> ">
        <label>Id Vuelos</label><br>

        <input type="text" name="origenA" value="<?php echo $origen ?> ">
        <label>Origen</label><br>

        <input type="text" name="destinoA" value="<?php echo $destino ?> ">
        <label>Destino</label><br>

        <input type="date" name="fechaA" id="fechaA" value="<?= $fechaVuelo ?>">

        <label>Fecha</label><br>

        <input type="text" name="tuaA" value="<?php echo $TUA ?> ">
        <label>TUA</label><br>

        <input type="text" name="costeA" value="<?php echo $costoVuelo ?> ">
        <label>Coste de Avion</label><br>

        <br>
        <div>
            <input type="submit" name="buscar" value="Buscar" />
            <input type="submit" name="Actualizar" value="Actualizar" />
        </div>
</body>

</html>