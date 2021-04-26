<?php
require 'vendor/autoload.php'; 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

$spreadsheet = new Spreadsheet(); //create object using Spreadsheet class
$sheet = $spreadsheet->getActiveSheet();

//set default font
$spreadsheet -> getDefaultStyle()
			 -> getFont()
			 -> setName('Arial')
			 -> setSize(10);

//set column dimension to auto size
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('A1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('B1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('C1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('D1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('E1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('F1')
			 -> setAutoSize(true);			 
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('G1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('H1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('I1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('J1')
			 -> setAutoSize(true);
$spreadsheet -> getActiveSheet()
			 -> getColumnDimension('K1')
			 -> setAutoSize(true);

//simple text data
$spreadsheet ->setCellValue('A1', 'Member ID')
			 ->setCellValue('B1', 'Member Name')
			 ->setCellValue('C1', 'Email')
			 ->setCellValue('D1', 'Phone Number')
			 ->setCellValue('E1', 'Address')
             ->setCellValue('F1', 'State')
			 ->setCellValue('G1', 'Postcode')
			 ->setCellValue('H1', 'Country')
			 ->setCellValue('I1', 'Member Since')
			 ->setCellValue('J1', 'First Time Login')
			 ->setCellValue('K1', 'Last Login');


$writer = new Xlsx($spreadsheet);
$writer->save('export_files/Test.xlsx');
?>