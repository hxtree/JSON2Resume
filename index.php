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

error_reporting(-1);
ini_set('display_errors', 'On');

class Resume extends FPDF
{
    public $margin = [
        'left' => 10,
        'top' => 10,
        'right' => 10,
    ];
    public $indent = 10;
    public $content_width;
    public $column_width;
    public $data;
    private $page_count = 0;

    /**
     * Resume constructor.
     *
     * @param string $orientation
     * @param string $unit
     * @param string $size
     */
    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);

        // load data
        $json_file = file_get_contents('resume.json');
        $this->data = json_decode($json_file);

        // calculate margins
        $this->content_width = $this->GetPageWidth() - $this->margin['left'] - $this->margin['right'];
        $this->column_width = $this->content_width / 3;

    }

    /**
     * Determines which header to render and renders it
     */
    function Header()
    {
        $this->page_count++;
        if ($this->page_count == 1) {
            $this->HeaderInitialPage();
        } else {
            $this->HeaderNotInitialPage();
        }
    }

    /**
     * Renders the first pages header
     */
    function HeaderInitialPage()
    {

        // print name
        $this->SetFont('San', 'B', 16);
        $this->MultiCell($this->content_width, 5, $this->data->name, 0, 'C');

        $this->ln(2);

        $this->column_width = $this->content_width / 3 - 1; //count($this->data->social) - 1;
        $count = 0;

        foreach ($this->data->social as $social) {
            // envelope
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Image('images/' . $social->icon, $x + 1, $y + 1, 3, 3);
            $this->SetX($x + 4);

            // print email
            $this->SetFont('PragatiNarrow', '', 11);
            @$this->Cell($this->column_width, 5, $social->value, 0, 0, 'L', 0, $this->data->email);

            $count++;
            if ($count % 3 == 0) {
                $this->ln();
            }
        }

        $this->ln(2);

        // print thick line
        $this->ThickLine('up');

    }

    /**
     * Renders a header for not the first page
     */
    function HeaderNotInitialPage()
    {
        // Move to the right
        $this->SetFont('San', 'B', 16);
        $this->Cell($this->content_width / 2, 6, $this->data->name, 0, 0, 'L');

        $this->SetFont('PragatiNarrow', '', 11);
        $this->Cell($this->content_width / 2, 6, 'Page ' . $this->page_count, 0, 0, 'R');
        $this->ln();
        $this->ThickLine('up');
    }

    /**
     * Renders a thick line
     *
     * @param string $direction
     * @param int $width
     */
    function ThickLine($direction = 'up', $width = 100)
    {
        // print line
        $x = $this->GetX() + ($this->content_width * (1 - $width / 100)) / 2;
        $y = $this->GetY();
        $this->ln(1.71);
        $width = $this->content_width * $width / 100;
        switch ($direction) {
            case 'up':
                $this->SetFillColor(0, 0, 0);
                $this->Rect($x, $y, $width, 0.61, 'F');
                $this->SetFillColor(96, 96, 96);
                $this->Rect($x, $y + 0.61, $width, 1, 'F');
                $this->SetFillColor(192, 192, 192);
                $this->Rect($x, $y + 1.61, $width, 0.61, 'F');
                break;
            case 'down':
                $this->SetFillColor(192, 192, 192);
                $this->Rect($x, $y, $width, 0.61, 'F');
                $this->SetFillColor(96, 96, 96);
                $this->Rect($x, $y + 0.61, $width, 1, 'F');
                $this->SetFillColor(0, 0, 0);
                $this->Rect($x, $y + 1.61, $width, 0.61, 'F');
                break;
        }
        $this->ln(1.71);
    }

    /**
     * Renders career profile section
     */
    function CareerProfile()
    {
        $this->SetFont('San', 'B', 12);
        $this->MultiCell($this->content_width, 6, 'CAREER PROFILE:  ', 0, 'C');
        $this->SetFont('PragatiNarrow', '', 10);

        foreach ($this->data->profile as $sentence) {
            $this->MultiCell($this->content_width, 5, $sentence, 0, 'L');
            $this->ln(2);
        }
        $this->ThickLine('down');
    }

    /**
     * Renders each resume section
     */
    function Sections()
    {
        foreach ($this->data->sections as $section) {
            $this->Section($section);
        }
    }

    /**
     * Renders a resume section
     *
     * @param $section1
     */
    function Section($section1)
    {

        $this->SetFont('San', 'B', 12);
        $this->MultiCell($this->content_width, 7, strtoupper($section1->title) . ':', 0, 'L');

        if (isset($section1->list)) {
            $length = count($section1->list);
            $i = 1;
            foreach ($section1->list as $array) {
                $this->SetFont('PragatiNarrow', '', 11);
                $this->Cell($this->indent, 4, chr(149), '', 0, 'R');
                $this->Cell($this->column_width - $this->indent, 4, $array, '', 0, 'L');
                if ($i == 1) {
                } else if ($i == $length) {
                } else if (($i % 3) == 0) {
                    $this->ln(4.4);
                }
                $i++;
            }
            $this->ln(4);
        } else {
            foreach ($section1->array as $section2) {
                $this->SetFont('PragatiNarrow', 'B', 10);
                $this->BulletItem(1, ' ', $section2->title, $section2->date);
                $this->SetFont('PragatiNarrow', 'I', 8.5);
                $this->BulletItem(1, ' ', $section2->description);
                $this->ln(0.4);
                if (!array_key_exists('array', $section2) || !is_array($section2->array)) {
                    continue;
                }

                foreach ($section2->array as $section3) {
                    $this->SetFont('PragatiNarrow', 'B', 10);
                    $this->BulletItem(2, NULL, $section3->title);
                    if (!array_key_exists('array', $section3)) {
                        $this->ln(0.4);
                        continue;
                    }
                    foreach ($section3->array as $section4) {
                        $this->SetFont('PragatiNarrow', '', 10);
                        $this->BulletItem(3, '—', $section4);
                    }
                    $this->ln(0.4);
                }
                $this->ln(0.4);
            }
        }
    }

    /**
     * Renders a single bullet item in a list
     *
     * @param $indent_amount
     * @param $char
     * @param $array
     * @param null $date
     */
    function BulletItem($indent_amount, $char, $array, $date = NULL)
    {

        // print bullet
        if ($char == NULL) {
            $char = chr(149);
        } else {
            $char = iconv('UTF-8', 'windows-1252', $char);
        }
        $this->Cell($this->indent * $indent_amount, 4, $char, '', 0, 'R');

        // print indented list
        $indent_total = $this->indent * $indent_amount + $this->margin['left'];
        $this->SetX($indent_total);
        if ($date == NULL) {
            $this->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $array), 0, 'J', false);
        } else {
            $column_width = ($this->content_width - $this->indent * $indent_amount) / 2;

            $this->SetFont('PragatiNarrow', 'B', 10);
            $this->Cell($column_width, 4, iconv('UTF-8', 'windows-1252', $array), '', 0, 'L');
            $this->SetFont('PragatiNarrow', '', 10);
            $this->Cell($column_width, 4, $date, '', 0, 'R');
            $this->ln();
        }
    }
}

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