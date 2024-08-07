<?php
use App\Http\Controllers\SystemuserstatusController; 
// $hostname_Cable = "localhost";
// $database_Cable = "saicable";
// $username_Cable = "saiadmin1";
// $password_Cable = "ES@sai2020";
// $Cable = mysqli_connect($hostname_Cable, $username_Cable, $password_Cable) or trigger_error(mysqli_error(),E_USER_ERROR);

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
// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();
// $this->_objZip = new ZipArchive();
// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Roja Mani");
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



$objPHPExcel->getActiveSheet()->SetCellValue('A1', "MYGROZO");
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*Report Details*/
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'DeliveryBoy Report');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:N2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G4:N4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setSize(19);
$objPHPExcel->getActiveSheet()->getStyle('A3:AF3')->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Sl.no');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Delivery Boy');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Order ID');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Date');  
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Shop');  
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Order Value');  
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Pickup Distance');  
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Delivery Distance');  
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Total Distance & Charge');  
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Payment Type');  
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Total Delivery Charge');  
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

$i=5;
if(count(array($order_detail))>0){
  foreach($order_detail as $key=>$row){
    
    $distance = \AbserveHelpers::getBoyTravelledReport($row->id);

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, (string)($i-4));
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, SiteHelpers::getboyname($row->id));
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, (string)$row->id);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, date('d-m-Y',strtotime($row->date)));
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, SiteHelpers::restsurent_name($row->res_id));
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, number_format($row->del_charge,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i,   $distance['pickup'].'KM');
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i,   $distance['delivery'].'KM');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i,   $distance['total'].'KM');
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, $row->delivery_type);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, (string)SiteHelpers::getDeliveryChargeForBoy($distance['total']));
    
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
//$objWriter->save(str_replace('.php', '_'.$vacat.'.xlsx', __FILE__));

$time=time()."-".date('Y-m-d-H:i:s');
// echo base_path();die();
$objWriter->save(str_replace('report_excel.php', '.xlsx',base_path().'/resources/views/phpexcel/file/delboy_report_'.$time.'.xlsx'));

echo json_encode("0~".$time);
?>