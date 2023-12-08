<?php
include("conexion.php");
session_start();

//crear valores para obtener los valores de la caja de texto
//$nombre = $_POST["usuario"];  //este es el correo xd no confundirse

$nombre = NULL;
$gen = NULL;
$nom1 = NULL;
$nom2 = NULL;
$apP = NULL;
$apM = NULL;
$date = NULL;
$pais = NULL;
$tel = NULL;

if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] == 'si') {
    $codigoCliente = $_SESSION['codigoCliente'];
    $nombre = $_SESSION['correo'];
    $gen = $_SESSION['genero'];
    $nom1 = $_SESSION['nom1'];
    if (isset($_SESSION['iniciada']) && $_SESSION['iniciada'] == 'si' && $_SESSION['nom2'] != NULL) {
        $nom2 = $_SESSION['nom2'];
    } else if (!isset($_SESSION['iniciada']) || $_SESSION['iniciada'] == 'no' || $_SESSION['nom2'] = NULL) {
        $nom2 = NULL;
    }
    $apP = $_SESSION['app'];
    $apM = $_SESSION['apm'];
    $date = $_SESSION['fechaNac'];
    $pais = $_SESSION['paisOrigen'];

    $sqlgrabar = "SELECT * FROM `clientetelefono` WHERE `codigoCliente` = '$codigoCliente'";
    $resultado = $conn->query($sqlgrabar);
    $datosTelefono = $resultado->fetch_assoc();
    $resultado->free();

    $query = mysqli_query($conn, "SELECT * FROM `clientetelefono` WHERE `codigoCliente` = '$codigoCliente'");
    $nr = mysqli_num_rows($query);
    if ($nr == 1) //variable que cuente las filas, si la respuesta es 1 lo va deja avanzar
    {
        $_SESSION['tel'] = $datosTelefono["telefono"];
        $tel = $_SESSION['tel'];
    }
} else if (!isset($_SESSION['iniciada']) || $_SESSION['iniciada'] == 'no') {
    $nombre = NULL;
    $gen = NULL;
    $nom1 = NULL;
    $nom2 = NULL;
    $apP = NULL;
    $apM = NULL;
    $date = NULL;
    $pais = NULL;
    $tel = NULL;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aeropuerto AeroCaRi - Reservas</title>
    <link rel="stylesheet" href="css/CssFormulario.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/CssDestinos.css">
    <style>
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Para estar detrás del contenido */
        }
    </style>

</head>

<body>
    <section style="padding: 0.3rem">
        <header style="background-color: hsla(0, 0%, 0%, 0.2)">
            <h1 id="my-text">Aeropuerto AeroCaRi</h1>
            <p>Tu viaje comienza aquí</p>
        </header>
        <script src="https://unpkg.com/gsap@3"></script>
        <script>
        gsap.to("#my-text", { x: 250, duration: 1, ease: "power2.inOut", yoyo: true, repeat: -1 });
        </script>
    </section>

    <nav class="viñeta-principal contenedor">
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

    <div id="particles-js"></div>
    <script src="js/particles.min.js"></script>
    <script>
        particlesJS({
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#000000",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 9.6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        })
    </script>

    <script>
        function cargarDestinos() {
            var origenSelect = document.getElementById("origen");
            var destinoSelect = document.getElementById("destino");
            var origenSeleccionado = origenSelect.options[origenSelect.selectedIndex].value;

            // Realiza una solicitud AJAX al servidor para obtener las opciones de destino
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parsea la respuesta JSON y actualiza las opciones del destino
                    var destinos = JSON.parse(xhr.responseText);
                    destinoSelect.innerHTML = "<option disabled selected>Seleccione Lugar de destino</option>";
                    destinos.forEach(function(destino) {
                        var option = document.createElement("option");
                        option.value = destino;
                        option.text = destino;
                        destinoSelect.add(option);
                    });
                }
            };

            // Envía la solicitud al servidor con el origen seleccionado
            xhr.open("GET", "obtener_destinos.php?origen=" + encodeURIComponent(origenSeleccionado), true);
            xhr.send();
        }

        function enviarFormulario() {
            // Obtiene los valores seleccionados
            var origen = document.getElementById("origen").value;
            var destino = document.getElementById("destino").value;

            // Agrega los valores al segundo formulario como campos ocultos
            var segundoFormulario = document.forms["tuSegundoFormulario"];
            var campoOrigen = document.createElement("input");
            campoOrigen.type = "hidden";
            campoOrigen.name = "origen";
            campoOrigen.value = origen;
            segundoFormulario.appendChild(campoOrigen);

            var campoDestino = document.createElement("input");
            campoDestino.type = "hidden";
            campoDestino.name = "destino";
            campoDestino.value = destino;
            segundoFormulario.appendChild(campoDestino);

            // Envía el segundo formulario
            segundoFormulario.submit();
        }
    </script>

    <div class="ajuste3">
        <section class="ajuste4">
            <form class="formulario2" id="primerFormulario">
                <fieldset>
                    <legend>Búsqueda de vuelo</legend>
                    <div class="contenedor-campos">
                        <div class="ajuste2" style="margin-left: 2rem;color: rgb(42, 114, 115);font-size: 16px;">
                            Origen <br><br>
                        </div>

                        <div class="select ajuste">
                            <select name="origen" id="origen" onchange="cargarDestinos()">
                                <option disabled selected>Seleccione Pais de origen</option>
                                <?php
                                include("conexion.php");
                                // Consulta SQL para obtener los IDs de vuelo desde la base de datos

                                $sql = "SELECT `origen` FROM `vuelo`";
                                $result = mysqli_query($conn, $sql);

                                // Genera las opciones del select
                                while ($row = mysqli_fetch_assoc($result)) {
                                    //echo "<option disabled selected>Seleccione ID del Vuelo</option>";
                                    echo "<option value='" . $row['origen'] . "'>" . $row['origen'] . "</option>";
                                }

                                // Cierra la conexión a la base de datos
                                mysqli_close($conn);
                                ?>
                            </select><br>
                        </div>
                        <br>
                        <div class="ajuste2" style="margin-left: 2rem; color: rgb(42, 114, 115); font-size: 16px;">
                            Destino <br><br>
                        </div>
                        <div id="contenedorDestino" class="select ajuste">
                            <select name="destino" id="destino">
                                <option disabled selected>Seleccione Lugar de destino</option>
                            </select>
                        </div>

                        <div class="username" style="margin-left: 2rem; color: rgb(42, 114, 115); font-size: 16px;"> ¿Cuándo deseas viajar?
                            <br>
                            <input type="date" name="diaViaje" value="2023-09-23" min="2023-01-01" max="2025-01-01 " id="FechaVuelo" />
                            <br>
                        </div>
                    </div>
                </fieldset>
            </form>
        </section>

        <section style="margin-top: 3rem; margin-bottom: 3rem">
            <form class="formulario2" id="segundoFormulario" action="Cliente.php" method="post">
                <fieldset>
                    <legend>Información de contacto</legend>

                    <div class="contenedor-campos">
                        <br>
                        <div class="ajuste2" style="margin-left: 2rem; color: rgb(42, 114, 115); font-size: 16px;">
                            <label>Género</label>
                            <input type="radio" name="Genero" value="Hombre" <?php if ($gen == 'Hombre') echo 'checked'; ?> /> Hombre
                            <input type="radio" name="Genero" value="Mujer" <?php if ($gen == 'Mujer') echo 'checked'; ?> /> Mujer

                        </div>

                        <div class="username">
                            <input type="text" name="usuario" id="email" value="<?php echo $nombre ?>">
                            <label>Correo Electrónico</label>
                        </div>

                        <div class="username">
                            <input type="text" name="nomb1" id="name1" pattern="[a-zA-Z]+" value="<?php echo $nom1 ?>">
                            <label>Primer nombre</label>
                        </div>

                        <div class="username">
                            <input type="text" name="nomb2" id="name2" pattern="[a-zA-Z]+" value="<?php echo $nom2 ?>">
                            <label>Segundo nombre</label>
                        </div>

                        <div class="username">
                            <input type="text" name="apPat" id="apP" pattern="[a-zA-Z]+" value="<?php echo $apP ?>">
                            <label>Apellido Paterno</label>
                        </div>

                        <div class="username">
                            <input type="text" name="apMat" id="apM" pattern="[a-zA-Z]+" value="<?php echo $apM ?>">
                            <label>Apellido Materno</label>
                        </div>

                        <div class="username">
                            <label>Fecha de nacimiento</label><br><br>
                            <input type="date" name="fechaNac" value="<?php echo $date; ?>" min="1930-01-01" max="2023-09-24" />
                        </div>

                        <div>
                            <label style="margin-left: 2rem; color: rgb(42, 114, 115); font-size: 16px;">
                                Pais de procedencia
                            </label>
                            <br><br>
                        </div>

                        <div class="select ajuste">
                            <select name="pais" id="pais" data-pais="<?php echo $pais; ?>">
                                <option disabled selected="">Seleccione País de procedencia </option>
                                <option>México</option>
                                <option>Estados Unidos</option>
                                <option>Reino Unido</option>
                                <option>Irlanda</option>
                                <option>Australia</option>
                                <option>Cánada</option>
                                <option>Rusia</option>
                                <option>Japón</option>
                                <option>Italia</option>
                                <option>Francia</option>
                                <option>Brasil</option>
                                <option>Argentina</option>
                                <option>Chile</option>
                                <option>China</option>
                                <option>África</option>
                                <option>Álemania</option>
                                <option>España</option>
                            </select><br />
                        </div>

                        <div class="username">
                            <input type="number" name="telefono" id="tel" pattern="[0-9]+" value="<?php echo $tel ?>">
                            <label>Telefono</label>
                        </div>
                        <input type="submit" name="submit" value="Enviar" style="margin-left: 3.5rem;" onclick="return enviarFormAvion();" />

                        <p class="warnings" id="warnings"></p>
                        <script src="js/Validaciones.js"></script>
                </fieldset>
            </form>
        </section>
    </div>
    <script>
        window.onload = function() {
            // Obtiene el valor del país guardado en la variable PHP
            var paisSeleccionado = "<?php echo $pais; ?>";

            // Selecciona automáticamente la opción correspondiente en el segundo formulario
            var selectPais = document.getElementById('pais');
            for (var i = 0; i < selectPais.options.length; i++) {
                if (selectPais.options[i].value === paisSeleccionado) {
                    selectPais.options[i].selected = true;
                    break;
                }
            }
        };
    </script>


    <footer>
        <p>
            &copy; 2023 Aeropuerto AeroCaRi <br />
            Todos los derechos reservados a Valeria y Alejandro
        </p>
    </footer>
</body>

</html>