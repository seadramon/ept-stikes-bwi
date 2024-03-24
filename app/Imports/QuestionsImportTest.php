<?php

namespace App\Imports;

use App\Models\Question;

// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionsImportTest implements WithStartRow, OnEachRow
{
    // use Importable;

    protected $part_id;

    public function __construct($part_id)
    {
        $this->part_id = $part_id;
    }

    public function onRow(Row $row)
    {
        $tmp = [];
        foreach($row->getCellIterator() as $cell) {
            $value = $cell->getValue();
            $styles = $this->getCellStyles($cell);

            $tmp[] = [$value => $styles];
        }
        dd($tmp);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    function getCellStyles($cell)
    {
        if ( ! method_exists($cell, 'getStyle') )
        {
            return false;
        }

        $getStyle = $cell->getStyle();

        $fill      = $getStyle->getFill();
        $font      = $getStyle->getFont();
        $borders   = $getStyle->getBorders();
        $alignment = $getStyle->getAlignment();

        return [
            'fill'      => [
                'color' => $fill->getFillType() == 'none' ? '' : $fill->getStartColor()->getRGB(),
                'filled' => $fill->getFillType(),
            ],
            'font'      => [
                'name'  => $font->getName(),
                'size'  => $font->getSize(),
                'color' => $font->getColor()->getRGB(),
            ],
            'borders'   => [
                'left'   => [
                    'color'     => $borders->getLeft()->getColor()->getRGB(),
                    'thickness' => $borders->getLeft()->getBorderStyle(),
                ],
                'right'  => [
                    'color'     => $borders->getRight()->getColor()->getRGB(),
                    'thickness' => $borders->getRight()->getBorderStyle(),
                ],
                'top'    => [
                    'color'     => $borders->getTop()->getColor()->getRGB(),
                    'thickness' => $borders->getTop()->getBorderStyle(),
                ],
                'bottom' => [
                    'color'     => $borders->getBottom()->getColor()->getRGB(),
                    'thickness' => $borders->getBottom()->getBorderStyle(),
                ],
            ],
            'alignment' => [
                'horizontal' => $alignment->getHorizontal(),
                'vertical'   => $alignment->getVertical(),
                'wrap'       => $alignment->getWrapText(),
                'shrink'     => $alignment->getShrinkToFit(),
                'indent'     => $alignment->getIndent(),
            ],
        ];
    }
}
