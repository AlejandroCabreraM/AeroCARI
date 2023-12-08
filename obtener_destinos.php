<?php
include("conexion.php");

if (isset($_GET['origen'])) {
    $origen = $_GET['origen'];
    $sql = "SELECT DISTINCT `destino` FROM `vuelo` WHERE `origen` = '$origen'";
    $result = mysqli_query($conn, $sql);

    $destinos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $destinos[] = $row['destino'];
    }

    echo json_encode($destinos);
}
?>
