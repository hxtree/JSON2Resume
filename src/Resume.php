<?php

namespace Hxtree\Json2Resume;

use FDPF;

/**
 * Class Resume
 */
class Resume extends \FPDF
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
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);

        // load data
        $json_file = file_get_contents(__DIR__ . '/../resume.json');
        $this->data = json_decode($json_file);

        // calculate margins
        $this->content_width = $this->GetPageWidth() - $this->margin['left'] - $this->margin['right'];
        $this->column_width = $this->content_width / 3;
    }

    /**
     * Determines which header to render and renders it
     */
    public function Header()
    {
        $this->page_count++;

        if ($this->page_count == 1) {
            $this->HeaderInitialPage();

            return;
        }

        $this->HeaderNotInitialPage();

        return;
    }

    /**
     * Renders the first pages header
     */
    public function HeaderInitialPage()
    {
        // print name
        $this->SetFont('San', 'B', 16);
        $this->MultiCell($this->content_width, 5, $this->data->name, 0, 'C');

        $this->ln(2);

        $this->column_width = $this->content_width / 3 - 1; //count($this->data->social) - 1;
        $count = 0;

        foreach ($this->data->social as $social) {
            // envelope
            $x_pos = $this->GetX();
            $y_pos = $this->GetY();
            $this->Image('images/' . $social->icon, $x_pos + 1, $y_pos + 1, 3, 3);
            $this->SetX($x_pos + 4); // TODO ?

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
    public function HeaderNotInitialPage()
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
    public function ThickLine($direction = 'up', $width = 100)
    {
        // print line
        $x_pos = $this->GetX() + ($this->content_width * (1 - $width / 100)) / 2;
        $y_pos = $this->GetY();
        $this->ln(1.71);
        $width = $this->content_width * $width / 100;
        switch ($direction) {
            case 'up':
                $this->SetFillColor(0, 0, 0);
                $this->Rect($x_pos, $y_pos, $width, 0.61, 'F');
                $this->SetFillColor(96, 96, 96);
                $this->Rect($x_pos, $y_pos + 0.61, $width, 1, 'F');
                $this->SetFillColor(192, 192, 192);
                $this->Rect($x_pos, $y_pos + 1.61, $width, 0.61, 'F');
                break;
            case 'down':
                $this->SetFillColor(192, 192, 192);
                $this->Rect($x_pos, $y_pos, $width, 0.61, 'F');
                $this->SetFillColor(96, 96, 96);
                $this->Rect($x_pos, $y_pos + 0.61, $width, 1, 'F');
                $this->SetFillColor(0, 0, 0);
                $this->Rect($x_pos, $y_pos + 1.61, $width, 0.61, 'F');
                break;
        }
        $this->ln(1.71);
    }

    /**
     * Renders career profile section
     */
    public function CareerProfile()
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
    public function Sections()
    {
        foreach ($this->data->sections as $section) {
            $this->Section($section);
        }
    }

    /**
     * Renders a resume section
     *
     * @param $section
     */
    public function Section($section)
    {
        $this->SetFont('San', 'B', 12);
        $this->MultiCell($this->content_width, 7, strtoupper($section->title) . ':', 0, 'L');

        if (isset($section->list)) {
            $length = count($section->list);
            $counter = 1;
            foreach ($section->list as $array) {
                $this->SetFont('PragatiNarrow', '', 11);
                $this->Cell($this->indent, 4, chr(149), '', 0, 'R');
                $this->Cell($this->column_width - $this->indent, 4, $array, '', 0, 'L');
                if ($counter == 1) {
                } elseif ($counter == $length) {
                } elseif (($counter % 3) == 0) {
                    $this->ln(4.4);
                }
                $counter++;
            }
            $this->ln(4);

            return;
        }

        foreach ($section->array as $section2) {
            $this->SetFont('PragatiNarrow', 'B', 10);
            $this->BulletItem(1, ' ', $section2->title, $section2->date);
            $this->SetFont('PragatiNarrow', 'I', 8.5);
            $this->BulletItem(1, ' ', $section2->description);
            $this->ln(0.4);
            if (!property_exists($section2, 'array') || !is_array($section2->array)) {
                continue;
            }

            foreach ($section2->array as $section3) {
                $this->SetFont('PragatiNarrow', 'B', 10);
                $this->BulletItem(2, null, $section3->title);
                if (!property_exists($section3, 'array')) {
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

    /**
     * Renders a single bullet item in a list
     *
     * @param $indent_amount
     * @param $char
     * @param $array
     * @param null $date
     */
    public function BulletItem($indent_amount, $char, $array, $date = null)
    {
        // print bullet
        $char = ($char === null) ? chr(149) : iconv('UTF-8', 'windows-1252', $char);

        $this->Cell($this->indent * $indent_amount, 4, $char, '', 0, 'R');

        // print indented list
        $indent_total = $this->indent * $indent_amount + $this->margin['left'];
        $this->SetX($indent_total);
        if ($date === null) {
            $this->MultiCell(0, 4, iconv('UTF-8', 'windows-1252', $array), 0, 'J', false);

            return;
        }

        $column_width = ($this->content_width - $this->indent * $indent_amount) / 2;

        $this->SetFont('PragatiNarrow', 'B', 10);
        $this->Cell($column_width, 4, iconv('UTF-8', 'windows-1252', $array), '', 0, 'L');
        $this->SetFont('PragatiNarrow', '', 10);
        $this->Cell($column_width, 4, $date, '', 0, 'R');
        $this->ln();

        return;
    }
}
