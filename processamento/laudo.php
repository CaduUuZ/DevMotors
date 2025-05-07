<?php

// Inclui a biblioteca FPDF e FPDI
require_once '../FPDF/fpdf.php';
require_once '../vendor/autoload.php';

// Inclui a classe Paciente
require_once '../classes/Paciente.php';

// Inclui os dados
require_once 'pacienteDados.php';


    // Carrega o modelo de PDF (com um template existente)
    $pdf = new \setasign\Fpdi\Fpdi();
    
    // Adiciona uma página
    $pdf->AddPage();
    
    // Carrega a página do modelo existente
    $pdf->setSourceFile('../pdflab.pdf');
    $template = $pdf->importPage(1);
    
    // Usa o modelo importado
    $pdf->useTemplate($template);

    // Configura a fonte
    $pdf->SetFont('Arial', '', 12);
    
    // Preenche os campos do modelo com os dados do paciente
    // Ajuste as coordenadas X e Y conforme necessário
    // X sendo direita e esquerda
    // Y sendo altura

    // Nome Completo
    $pdf->SetXY(32, 28.8);
    $pdf->Cell(0, 10, $paciente->nomeCompleto);

    // Idade
    //$pdf->SetXY(50, 50);
    //$pdf->Cell(0, 10, $idade);

    // Sexo
    //$pdf->SetXY(50, 60);
    //$pdf->Cell(0, 10, $sexo);

    // Prontuário
    $pdf->SetXY(29, 42.3); 
    $pdf->Cell(0, 10, $paciente->registro);

    // Data 
    //$pdf->SetXY(118, 42.3);
    //$pdf->Cell(0, 10, $paciente->data);

    // Exame
    $pdf->SetXY(50, 80);
    $pdf->Cell(0, 10, $exame);

    // Material
    //$pdf->SetXY(50, 90);
    //$pdf->Cell(0, 10, $material);

    // Método
    //$pdf->SetXY(50, 100); 
    //$pdf->Cell(0, 10, $metodo);

    // Resultado
    //$pdf->SetXY(50, 110); 
    //$pdf->Cell(0, 10, $resultado);

    // Grupo Sanguíneo
    //$pdf->SetXY(50, 120);
    //$pdf->Cell(0, 10, $grupoSanguineo);

    // Fator Rh
    //$pdf->SetXY(50, 130); 
    //$pdf->Cell(0, 10, $fatorRh);

    // Data de liberação
    $pdf->SetXY(125, 42.3); 
    $pdf->Cell(0, 10, $dataLiberacao);

    // Finaliza a geração do PDF
    $pdf->Output();
