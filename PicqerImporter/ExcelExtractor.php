<?php
namespace PicqerImporter;

use PHPExcel_Reader_Excel2007;
use PHPExcel_Cell;

class ExcelExtractor {

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function processExcel($filename, $customernumbers_rule, $productcode_column, $start_row, $start_column)
    {
        $productcode_column = PHPExcel_Cell::columnIndexFromString($productcode_column) - 1;
        $start_row = $start_row - 1;
        $start_column = PHPExcel_Cell::columnIndexFromString($start_column) - 1;

        $excelreader = new PHPExcel_Reader_Excel2007();
        $phpexcel = $excelreader->load($filename);
        $phpexcel->setActiveSheetIndex(0);

        $lastcolumn = PHPExcel_Cell::columnIndexFromString($phpexcel->getActiveSheet()->getHighestColumn());
        $lastrow = $phpexcel->getActiveSheet()->getHighestRow();

        // Get customer id's from columns
        $customers = array();
        for ($i = $start_column; $i < $lastcolumn; $i++) {
            $celdata = $phpexcel->getActiveSheet()->getCellByColumnAndRow($i, $customernumbers_rule)->getValue();
            if (!empty($celdata)) {
                $customers[$i] = $celdata;
            }
        }

        // Get products from rows
        $products = array();
        for ($i = $start_row; $i < $lastrow; $i++) {
            $celdata = $phpexcel->getActiveSheet()->getCellByColumnAndRow($productcode_column, $i)->getValue();
            if (!empty($celdata)) {
                $products[$i] = $celdata;
            }
        }

        $orders = array();
        foreach ($customers as $columnIndex => $idcustomer) {
            foreach ($products as $rowIndex => $productcode) {
                $celdata = $phpexcel->getActiveSheet()->getCellByColumnAndRow($columnIndex, $rowIndex)->getValue();
                if (!empty($celdata)) {
                    $orders[$idcustomer][$productcode] = $celdata;
                }
            }
        }

        return $orders;
    }
}