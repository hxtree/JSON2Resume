<?php

/**
 * This file is part of the JSON2Resume package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ . '/../vendor/autoload.php';

use Hxtree\Json2Resume\Resume;

define('FPDF_FONTPATH', __DIR__ . '/font');

// create resume object
$pdf = new Resume();

// load fonts
$pdf->AddFont('PragatiNarrow', '', 'PragatiNarrow-Regular.php');
$pdf->AddFont('PragatiNarrow', 'B', 'PragatiNarrow-Bold.php');
$pdf->AddFont('PragatiNarrow', 'I', 'OpenSans-LightItalic.php');
$pdf->AddFont('San', 'B', 'archivob.php');

// init page
$pdf->SetMargins($pdf->margin['left'], $pdf->margin['top'], $pdf->margin['right']);
$pdf->AddPage();

// render career profile section
$pdf->CareerProfile();

// render other sections
$pdf->Sections();

// output PDF
$pdf->Output();
