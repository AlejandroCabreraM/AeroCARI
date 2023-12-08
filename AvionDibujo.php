<?php
include("conexion.php");
session_start();

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

echo "correo: $nombre, Nombre 1: $nom1, Apellido Paterno: $apP, Apellido Materno: $apM, Genero: $gen, Nacimiento: $date, Pais: $pais, Telefono: $tel";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Avion</title>
  <!--<link rel="stylesheet" href="css/Draw.css">-->
  <link rel="stylesheet" href="css/CssDestinos.css">
  <link rel="stylesheet" href="css/Draw.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />


</head>

<body style="background: #92CDE5 !important;">
  <script src="js/jquery-3.6.0.min.js"></script>

  <section class="seccionTitulo">
    <header style="background-color: hsla(0, 0%, 0%, 0.2)">
      <h1 id="my-text">Aeropuerto AeroCaRi</h1>
      <p>Tu viaje comienza aquí</p>
    </header>
    <script src="https://unpkg.com/gsap@3"></script>
    <script>
      gsap.to("#my-text", {
        x: 250,
        duration: 1,
        ease: "power2.inOut",
        yoyo: true,
        repeat: -1
      });
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
        <li><a href="FormularioInicio.html">Cerrar sesión</a></li>
      </ul>
    </details>
  </nav>

  <div class="contenedor">

    <h1 style="text-align: center;">Ticket de compra</h1>
    <div class="project">
      <div class="shop">
      </div>
      <div class="entrada"></div>
      <div class="salida"></div>

      <div class="barra">
        <p><span>Tarifa de Avión</span> <span>$1095</span></p>
        <hr>

        <p><span>Selección de asiento</span>
        <div class="amount" id="seleccionAsiento">0</div> pesos </p>
        <span> <span class="count" name="nSeats">0</span> Asientos </span>
        <hr>

        <p><span>Equipaje</span> <span>$1020</span></p>
        <hr>
        <p><span>Gastos adicionales</span> <span>$0</span></p>
        <hr>
        <p><span>Tarifa de uso de aeropuerto (TUA)</span> <span>$551</span></p>
        <hr>
        <p><span>Total</span> <span id="total"></span></p>

        <button onclick="actualizarTotal()">Actualizar Total</button>

        <div class="btn-area">
          <input type="button">
          <a href="pdf.php">Finalizar compra</a>
        </div> <br>

        <script src="https://www.paypal.com/sdk/js?client-id=Ad4A6yw45jG4kgSPYXTEXqsvT1TI7nYBjUobavXrKpGuO1OUSjwkDbSsOCK4v3azS6uCcFRx1bfodCpG&currency=MXN">
        </script>

        <div id="paypal-button-container"></div>

        <!--Inicializacion javascript-->
        <script>
          paypal.Buttons({
            createOrder: function(data, actions) {
              // Obtener el monto desde el elemento 'total' en tu página
              const total = document.getElementById('total').textContent.replace('$', '');
              return actions.order.create({
                purchase_units: [{
                  amount: {
                    value: total
                  }
                }]
              });
            },

            onApprove: function(data, actions) {
              actions.order.capture().then(function(details) {
                console.log(details);
                alert("Gracias por su compra");
              });
            },

            onCancel: function(data) {
              alert("Pago cancelado");
              console.log(data);
            }
          }).render('#paypal-button-container');
        </script>

      </div>
    </div>
  </div>

  <div class="tickets">
    <div class="ticket-selector">
      <div class="head">
        <div class="title">Elija asiento</div>
      </div>


      <div class="seats">

        <div class="status">
          <br><br>
          <div class="item">Seleccionado</div>
          <div class="item">Ocupado</div>
          <div class="item">Libre</div>
          <br><br><br><br><br><br>
        </div>
        <div class="all-seats">

          <input type="checkbox" name="tickets" id="s1" />
          <label for="s1" class="seat booked"></label>
        </div>
      </div>
      <img src="img/baños.png" margin-left: 5px;>
    </div>

    <!--<div class="price">
          <div class="total">
            <span> <span class="count">0</span> Asientos </span>
            <div class="amount">0</div>
          </div>
        </div>-->

  </div>


  <script>
    let seats = document.querySelector(".all-seats");
    for (var i = 0; i < 59; i++) {
      // Establecer booked como una cadena vacía para que ningún asiento esté reservado
      let booked = "";
      seats.insertAdjacentHTML("beforeend",'<input type="checkbox" name="tickets" id="s' + (i + 2) +'" /> <label for="s' +(i + 2) +'" class="seat ' + booked + '"></label>');
    }

    let tickets = seats.querySelectorAll("input");
    tickets.forEach((ticket) => {
      ticket.addEventListener("change", () => {
        let amount = document.querySelector(".amount").innerHTML;
        let count = document.querySelector(".count").innerHTML;
        amount = Number(amount);
        count = Number(count);

        if (ticket.checked) {
          count += 1;
          amount += 200;
        } else {
          count -= 1;
          amount -= 200;
        }
        document.querySelector(".amount").innerHTML = amount;
        document.querySelector(".count").innerHTML = count;
      });
    });
  </script>

  <script>
    function actualizarTotal() {
      // Obtener el valor actual del amount
      const amount = parseInt(document.getElementById('seleccionAsiento').textContent);

      // Obtener los otros valores y calcular el total
      const tarifaAvion = 1095;
      const equipaje = 1020;
      const gastosAdicionales = 0;
      const TUA = 551;

      const total = tarifaAvion + amount + equipaje + gastosAdicionales + TUA;

      // Actualizar el total en el elemento correspondiente
      document.getElementById('total').textContent = '$' + total;

    }
  </script>

  <script>
    $(document).ready(function() {
      $(".seat").on("click", function() {
        if ($(this).hasClass("seat") && !$(this).hasClass("selectedOcupado-innerColor")) {
          $(this).toggleClass("selected-innerColor");
          $(this).parent().toggleClass("selected-outerColor");

          var inputElement = document.getElementById("asiento");
          var num = $(this).attr('numasiento');

          var currentValues = inputElement.value.split(',').map(function(item) {
            return item.trim();
          });

          var index = currentValues.indexOf(num);
          if (index !== -1) {
            currentValues.split(index, 1);
          } else {
            currentValues.push(num);
          }

          currentValues.sort(function(a, b) {
            return a - b;
          });

          inputElement.value = currentValues.join(',');
        }
      });
    });
  </script>

</body>

</html>