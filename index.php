<?php
/**
 * This file is part of the JSON2Resume package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require('fpdf/fpdf.php');

class PDF extends FPDF
{
    private $pagecount = 0;

    function Header()
    {
        $this->pagecount++;
        if ($this->pagecount == 1) {
            $this->HeaderFirst();
        } else {
            $this->HeaderNotFirst();
        }
    }

    function HeaderFirst()
    {
        global $data;
        global $content_width;

        // print name
        $this->SetFont('San', 'B', 16);
        $this->MultiCell($content_width, 5, $data->name, 0, 'C');

        $this->ln(2);

        $column_width = $content_width / 3 - 1; //count($data->social) - 1;
        $count = 0;
        foreach ($data->social as $social) {
            // envelope
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Image('images/' . $social->icon, $x + 1, $y + 1, 3, 3);
            $this->SetX($x + 4);

            // print email
            $this->SetFont('PragatiNarrow', '', 11);
            $this->Cell($column_width, 5, $social->value, 0, 0, 'L', 0, $data->email);

            $count++;
            if ($count % 3 == 0) {
                $this->ln();
            }
        }

        $this->ln(2);

        // print thick line
        $this->ThickLine('up');

    }

    function ThickLine($direction = 'up', $width = 100)
    {
        global $content_width;
        // print line
        $x = $this->GetX() + ($content_width * (1 - $width / 100)) / 2;
        $y = $this->GetY();
        $this->ln(1.71);
        $width = $content_width * $width / 100;
        switch ($direction) {
            case 'up':
                $this->SetFillColor(0, 0, 0);
                $this->Rect($x, $y, $width, 0.61, F);
                $this->SetFillColor(96, 96, 96);
                $this->Rect($x, $y + 0.61, $width, 1, F);
                $this->SetFillColor(192, 192, 192);
                $this->Rect($x, $y + 1.61, $width, 0.61, F);
                break;
            case 'down':
                $this->SetFillColor(192, 192, 192);
                $this->Rect($x, $y, $width, 0.61, F);
                $this->SetFillColor(96, 96, 96);
                $this->Rect($x, $y + 0.61, $width, 1, F);
                $this->SetFillColor(0, 0, 0);
                $this->Rect($x, $y + 1.61, $width, 0.61, F);
                break;
        }
        $this->ln(1.71);
    }

    function HeaderNotFirst()
    {
        global $data;
        global $content_width;

        // Move to the right
        $this->SetFont('San', 'B', 16);
        $this->Cell($content_width / 2, 6, $data->name, 0, 0, 'L');

        $this->SetFont('PragatiNarrow', '', 11);
        $this->Cell($content_width / 2, 6, 'Page ' . $this->pagecount, 0, 0, 'R');
        $this->ln();
        $this->ThickLine('up');
    }
}

// print awards
function li($indent_amount, $char, $array, $date = NULL)
{
    global $pdf;
    global $indent;
    global $content_width;
    global $column_width;
    global $margin;

    // print bullet
    if ($char == NULL) {
        $char = chr(149);
    } else {
        $char = iconv('UTF-8', 'windows-1252', $char);
    }
    $pdf->Cell($indent * $indent_amount, 4, $char, '', 0, 'R');

    // print indented list
    $indent_total = $indent * $indent_amount + $margin['left'];
    $pdf->SetX($indent_total);
    if ($date == NULL) {
        $pdf->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $array), 0, 'J', false);
    } else {
        $column_width2 = ($content_width - $indent * $indent_amount) / 2;

        $pdf->SetFont('PragatiNarrow', 'B', 10);
        $pdf->Cell($column_width2, 4, iconv('UTF-8', 'windows-1252', $array), '', 0, 'L');
        $pdf->SetFont('PragatiNarrow', '', 10);
        $pdf->Cell($column_width2, 4, $date, '', 0, 'R');
        $pdf->ln();
    }
}

$pdf = new PDF();

$pdf->AddFont('PragatiNarrow', '', 'PragatiNarrow-Regular.php');
$pdf->AddFont('PragatiNarrow', 'B', 'PragatiNarrow-Bold.php');
$pdf->AddFont('PragatiNarrow', 'I', 'OpenSans-LightItalic.php');
$pdf->AddFont('San', 'B', 'archivob.php');

$margin = array(
    'left' => 10,
    'top' => 10,
    'right' => 10,
);
$content_width = $pdf->GetPageWidth() - $margin['left'] - $margin['right'];
$column_width = $content_width / 3;
$indent = 10;

$json_file = file_get_contents('resume.json');
$data = json_decode($json_file);

// init page
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->AddPage();

// career profile
$pdf->SetFont('San', 'B', 12);
$pdf->MultiCell($content_width, 6, 'CAREER PROFILE:  ', 0, 'C');

$pdf->SetFont('PragatiNarrow', '', 10);

foreach ($data->profile as $sentence) {
    $pdf->MultiCell($content_width, 5, $sentence, 0, 'L');
    $pdf->ln(2);
}

$pdf->ThickLine('down');

// print misc.
foreach ($data->sections as $section1) {
    $pdf->SetFont('San', 'B', 12);
    $pdf->MultiCell($content_width, 7, strtoupper($section1->title) . ':', 0, 'L');
    if (isset($section1->list)) {
        // TODO: change from horizontal to veritical
        $length = count($section1->list);
        $i = 1;
        foreach ($section1->list as $array) {
            $pdf->SetFont('PragatiNarrow', '', 11);
            $pdf->Cell($indent, 4, chr(149), '', 0, 'R');
            $pdf->Cell($column_width - $indent, 4, $array, '', 0, 'L');
            if ($i == 1) {
            } else if ($i == $length) {
            } else if (($i % 3) == 0) {
                $pdf->ln(4.4);
            }
            $i++;
        }
        $pdf->ln(4);
    } else {
        foreach ($section1->array as $section2) {
            $pdf->SetFont('PragatiNarrow', 'B', 10);
            li(1, ' ', $section2->title, $section2->date);
            $pdf->SetFont('PragatiNarrow', 'I', 8.5);
            li(1, ' ', $section2->description);
            $pdf->ln(0.4);
            foreach ($section2->array as $section3) {
                $pdf->SetFont('PragatiNarrow', 'B', 10);
                li(2, NULL, $section3->title);
                foreach ($section3->array as $section4) {
                    $pdf->SetFont('PragatiNarrow', '', 10);
                    li(3, '—', $section4);
                }
                $pdf->ln(0.4);
            }
            $pdf->ln(0.4);
        }
    }
}

$pdf->Output();
