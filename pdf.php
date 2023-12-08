<?php
    //require 'fpdf/fpdf.php';
    include 'plantilla.php';
    require 'conexion.php';

    $query= "SELECT `correo`, `primerNombre`, `segundoNombre`, `apellidoPaterno`, `apellidoMaterno`, `paisOrigen`
    FROM `cliente`";

    $resultado = $conn->query($query);

    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFillColor(232,232,232);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(70,6,'CORREO',1,0,'C','1');
    $pdf->Cell(20,6,'NOMBRE1',1,0,'C','1');
    $pdf->Cell(70,6,'NOMBRE2',1,1,'C','1');


    $pdf->SetFont('Arial', '', 10);

    while($row = $resultado->fetch_assoc())
    {
        $pdf->Cell(70,6,$row['correo'],1,0,'C',1);
        $pdf->Cell(70,6,$row['primerNombre'],1,0,'C',1);
        $pdf->Cell(70,6,$row['segundoNombre'],1,1,'C',1);
    }

    $pdf->Output();

?>    