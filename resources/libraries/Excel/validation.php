<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

session_start();
$lastValidation = $_SESSION['lastValidation'];

$estiloHeader = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '26A69A',
        ],
    ],
];
$estiloBody = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ]
];
$estiloCentro = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

    ]
];
$fecha = date('d-m-Y');
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
//$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
$spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);
$spreadsheet->getActiveSheet()->mergeCells('A1:E1');
$spreadsheet->getActiveSheet()->getStyle('A1:E2')->applyFromArray($estiloHeader);
$sheet->getColumnDimension('A')->setWidth(10);
$spreadsheet->getActiveSheet()->getStyle('A')->applyFromArray($estiloCentro);
$spreadsheet->getActiveSheet()->getStyle('B')->applyFromArray($estiloCentro);
$spreadsheet->getActiveSheet()->getStyle('D')->applyFromArray($estiloCentro);
$spreadsheet->getActiveSheet()->getStyle('E')->applyFromArray($estiloCentro);

$sheet->setCellValue('A1', 'OBSERVACIONES - ' . $fecha);
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$sheet->setCellValue('A2', '#');
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->setCellValue('B2', 'CPMS');
$sheet->getColumnDimension('C')->setWidth(100);
$sheet->setCellValue('C2', 'DESCRIPCIÓN CPMS');
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->setCellValue('D2', 'ID_ATENCIÓN');
$sheet->getColumnDimension('E')->setWidth(35);
$sheet->setCellValue('E2', 'RESPONSABLE');
$spreadsheet->getActiveSheet()->getStyle('D2')
    ->getFill()->getStartColor()->setARGB('C00000');
$filaExcel = 3;

foreach ($lastValidation as $k => $v) {
    $sheet->setCellValue('A' . $filaExcel, $k + 1);
    $sheet->setCellValue('B' . $filaExcel, $v['idCpms']);
    $sheet->setCellValue('C' . $filaExcel, $v['cpms']);
    $sheet->setCellValue('D' . $filaExcel, $v['idAtencion']);
    $sheet->setCellValue('E' . $filaExcel, $v['responsable']);
    $filaExcel++;
}
$filaExcel--;
$spreadsheet->getActiveSheet()->getStyle('A3:E' . $filaExcel)->applyFromArray($estiloBody);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="validate' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
