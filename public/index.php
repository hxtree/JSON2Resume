<?php

/**
 * This file is part of the JSON2Resume package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
require __DIR__.'/../vendor/autoload.php';

use Hxtree\Json2Resume\Resume;

define('FPDF_FONTPATH', __DIR__.'/font');

$pdf = new Resume();

$pdf->AddFont('PragatiNarrow', '', 'PragatiNarrow-Regular.php');
$pdf->AddFont('PragatiNarrow', 'B', 'PragatiNarrow-Bold.php');
$pdf->AddFont('PragatiNarrow', 'I', 'OpenSans-LightItalic.php');
$pdf->AddFont('San', 'B', 'archivob.php');

$pdf->SetMargins($pdf->margin['left'], $pdf->margin['top'], $pdf->margin['right']);

$pdf->AddPage();
$pdf->CareerProfile();
$pdf->Sections();

$pdf->Output();
