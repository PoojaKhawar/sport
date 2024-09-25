<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Excel
{
    public static function download(array $data, array $headers = [], $fileName = 'data.xlsx', $headers2 = [])
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Show gridlines
        $sheet->setShowGridlines(true);

        // Set border style and color for all cells to make gridlines darker
        $borderStyle = Border::BORDER_THIN;
        $borderColor = '000000';

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => $borderStyle,
                    'color' => ['argb' => $borderColor],
                ],
            ],
        ];


        if(isset($headers) && $headers)
        {
            for($i = 0, $l = sizeof($headers); $i < $l; $i++)
            {
                $sheet->setCellValueByColumnAndRow($i + 1, 1, $headers[$i]);
                $sheet->getStyle('A' . 1 . ':' . getNameFromNumber($i) . 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C2D69A');
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->applyFromArray($styleArray);
            }
        }

        for($i = 0, $l = sizeof($data); $i < $l; $i++)
        { 
            // row $i
            $j = 0;
            if(isset($data[$i]) && $data[$i])
            {
                foreach($data[$i] as $k => $v)
                { 
                    // column $j
                    $sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1), $v);
                    $j++;
                }
            }
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }

    public static function read($path, $fileType = 'Xlsx')
    {
        if(file_exists($path))
        {
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            $spreadsheet = new Spreadsheet();

            $inputFileType = $fileType;
            $inputFileName = $path;

            /**  Create a new Reader of the type defined in $inputFileType  **/
            $reader = IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($inputFileName);

            $worksheet = $spreadsheet->getActiveSheet();
            return $worksheet->toArray();
        }
        else
        {
            return null;
        }
    }

    public static function download2(array $data, array $headers = [], $fileName = 'data.xlsx', array $headers2 = [])
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Show gridlines
        $sheet->setShowGridlines(true);

        // Set border style and color for all cells to make gridlines darker
        $borderStyle = Border::BORDER_THIN;
        $borderColor = '000000';

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => $borderStyle,
                    'color' => ['argb' => $borderColor],
                ],
            ],
        ];

        if (!empty($headers)) {
            $headerCount = count($headers);
            $currentColumn = 1;

            for ($i = 0; $i < $headerCount; $i++) {
                $header = $headers[$i];

                // Set header value
                $sheet->setCellValueByColumnAndRow($currentColumn, 1, $header);

                if ($header === 'Time') {
                    // Merge cells for the "Time" column
                    $sheet->mergeCellsByColumnAndRow($currentColumn, 1, $currentColumn + 1, 1);

                    // Center align content in the "Time" column
                    $sheet->getStyleByColumnAndRow($currentColumn, 1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    
                    // Skip the next column as it's part of the "Time" section
                    $currentColumn += 2;
                } else {
                    $currentColumn++;
                }

                // Set background color for the entire row
                $sheet->getStyle('A' . 1 . ':' . getNameFromNumber($currentColumn) . 1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C2D69A');

                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . 1)->applyFromArray($styleArray);
            }
        }

        if(isset($headers2) && $headers2)
        {
            $currentColumn = 1;
            for($i = 0, $l = sizeof($headers2); $i < $l; $i++)
            {
                $sheet->setCellValueByColumnAndRow($i + 1, 2, $headers2[$i]);
                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . 2)->applyFromArray($styleArray);
            }
        }

        for($i = 0, $l = sizeof($data); $i < $l; $i++)
        { 
            // row $i
            $j = 0;
            $currentColumn = 1;
            if(isset($data[$i]) && $data[$i])
            {
                foreach($data[$i] as $k => $v)
                {
                    // column $j
                    
                    // Set background color for specific cells

                    $dataKeyName = $k ? explode('-',$k) : '';
                    if(isset($dataKeyName[3]) && ($dataKeyName[3] == 'in' || $dataKeyName[3] == 'out'))
                    {
                        $valueExplode = $v ? explode('-',$v) : '';
                        if(isset($valueExplode[1]) && $valueExplode[1])
                        {
                            $sheet->getStyleByColumnAndRow($j + 1, ($i + 1 + 1 + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($valueExplode[1]);
                            $v = '';
                        }
                    }

                    $sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1 + 1), $v);

                    if($v && $v == "W/o")
                    {
                        $sheet->getStyleByColumnAndRow($j + 1, ($i + 1 + 1 + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9fc5e8');
                    }
                    elseif($v && $v == "P")
                    {
                        $sheet->getStyleByColumnAndRow($j + 1, ($i + 1 + 1 + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('00FF00');
                    }
                    elseif($v && $v == "A")
                    {
                        $sheet->getStyleByColumnAndRow($j + 1, ($i + 1 + 1 + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('db1818');
                    }
                    elseif($v && $v == "H")
                    {
                        $sheet->getStyleByColumnAndRow($j + 1, ($i + 1 + 1 + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff9900');
                    }
                    elseif($v && ($v == "L" || $v == "1HD" || $v == "2HD" || $v == "1SL" || $v == "2SL" || $v == "3SL" || $v == "4SL"))
                    {
                        $sheet->getStyleByColumnAndRow($j + 1, ($i + 1 + 1 + 1))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
                    }

                    $sheet->getStyle('A' . ($i + 4) . ':' . $sheet->getHighestColumn() . ($i + 4))->applyFromArray($styleArray);

                    $j++;
                }
            }
        }

        // Ensure all rows are visible
        foreach ($sheet->getRowIterator() as $row) {
            $row->getWorksheet()->getRowDimension($row->getRowIndex())->setVisible(true);
        }

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

}