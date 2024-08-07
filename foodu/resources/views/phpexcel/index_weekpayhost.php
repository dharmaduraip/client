<?php
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$mm=$date->format('m');
$yy=$date->format('Y');
$dd=$date->format('d');
/** Error reporting */
error_reporting(E_ALL);
/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');
/** PHPExcel */
include 'exce_api/PHPExcel.php';
/** PHPExcel_Writer_Excel2007 */
include 'exce_api/PHPExcel/Writer/Excel2007.php';
include 'exce_api/PHPExcel/Writer/CSV.php';
// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();
// $this->_objZip = new ZipArchive();
$objPHPExcel->getProperties()->setCreator("test");
$objPHPExcel->getProperties()->setLastModifiedBy("Abservetech");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document"); 
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

$objPHPExcel->setActiveSheetIndex(0);

$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);

$sty = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    )
);	
$styleArray = array(
  'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
      )
  )
);
   //$objPHPExcel->getDefaultStyle()->applyFromArray($style);
$objPHPExcel->getDefaultStyle("A4:H4")->applyFromArray($style);
$objPHPExcel->getDefaultStyle("A1:H1")->applyFromArray($style);
$objPHPExcel->getDefaultStyle("A2:H2")->applyFromArray($style);
$objPHPExcel->getDefaultStyle("A3:H3")->applyFromArray($style);
$objPHPExcel->getDefaultStyle("A5:H5")->applyFromArray($style);
$objPHPExcel->getDefaultStyle("A6:H6")->applyFromArray($sty);



$objPHPExcel->getActiveSheet()->SetCellValue('A1', "MAIN");
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*Report Details*/
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Restaurant Product Items []');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G4:N4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(19);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true);
		// $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Sl.no');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Name');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Price');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Shops');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Payable Amount');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Status');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->SetCellValue('G3', "Unit / Variation ( -/unit/variation )"); 
// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Unit/Variation - Unit/Color');   
// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true); 
// $objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Unit/Variation - Quantity/Unit');   
// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Unit/Variation - Price');    
// $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Image');  
// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);     
// $objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Hiking Price');  
// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
// $objPHPExcel->getActiveSheet()->SetCellValue('M3', 'Strike Price');  
// $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$i=5;
$from   = request()->has('from') ? request()->get('from') : '';
$to=date('Y-m-d', strtotime('-1 days'));
if(count($users)>0){
  foreach($users as $key=>$row){
      // print_r($row->id);exit();
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, (string)($i-4));
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, (string)$row->username);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, (string)$row->email);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, \AbserveHelpers::Partnerrestaurants($row->id));
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, \AbserveHelpers::getPartner_payable_weekly_amt($row->id,$from,$to));
    $data= \AbserveHelpers::getWeekly_payable_status($row->id,$from,$to,'1');
    $v = explode('~', $data);
    $str_status = $v[1] == "<span class='label label-danger'>Not-paid</span>" ? 'Not Paid' : 'Paid' ;
    $objPHPExcel->getActiveSheet()->SetCellValue('f'.$i, $str_status);

    // $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, (string)($row->item_status==1) ? '1' : '0');
    // $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, (string)$row->adon_type);
    // $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, );
    // $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, );
    // $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, );
    // $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, (string)$row->image);
    // $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, (string)$row->hiking);
    // $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, (string)$row->strike_price);

    $i++;
  
    
}

}

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('User Details');

$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);

// Save Excel 2007 file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');

// $objWriter->save(str_replace('.php', '_'.$vacat.'.xlsx', __FILE__));

$time=time()."-".date('Y-m-d-H:i:s');
// echo base_path();die();
$objWriter->save(str_replace('report_excel.php', '.csv',base_path().'/resources/views/phpexcel/file/weekpayhost_report_'.$time.'.xlsx'));

echo json_encode("0~".$time);
?>