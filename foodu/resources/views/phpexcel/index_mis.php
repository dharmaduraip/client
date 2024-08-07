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



$objPHPExcel->getActiveSheet()->SetCellValue('A1', "MY GROZO");
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setSize(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*Report Details*/
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'MIS Report');
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
$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Order Date');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Order ID');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Customer ID');  
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Customer Name');  
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Customer Mobile');  
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'Customer Mail');  
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('H3', 'Delivery Address');  
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('I3', 'Store ID');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('J3', 'Store Name');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('K3', 'Store Address');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('L3', 'Store Price');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('M3', 'GST');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('N3', 'Hiked Percent');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('O3', 'Amount Hiked');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('P3', 'Hiked Price');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('Q3', 'GST');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('R3', 'Delivery Fees');
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('S3', 'Delivery Tax');
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('T3', 'Conv. Fee');
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('U3', 'Conv. Tax');
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('V3', 'Total Cost');
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('W3', "Promo Code"); 
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('X3', 'Promo Amount');   
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->SetCellValue('Y3', 'Order Value');   
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('Z3', 'Commission Percentage');    
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AA3', 'Commission Value');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AB3', 'Net Payable to Shop');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AC3', 'Total Earning');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AD3', 'Payment Mode');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AE3', 'Delivery Boy Name');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AF3', 'Pickup Travel in KM');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AG3', 'Delivery Travel In KM');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AH3', 'Total Travel');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AI3', 'Rate Per KM');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AJ3', 'TA Earned');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AK3', 'Order Placed time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AL3', 'Accepted Time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AM3', 'Dispatched time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AN3', 'Completed time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);

$i=5;
if(count(array($order_detail))>0){
  foreach($order_detail as $key=>$row){

    if($row->coupon_id>0){
     $coupon_code=\DB::table('abserve_promocode')->where('id',$row->coupon_id)->first();
     if($coupon_code){
         $Ccode=$coupon_code->promo_code;
     }else{
        $Ccode='';
    }

}else{
    $Ccode='';
}
$distance = \AbserveHelpers::getBoyTravelledReport($row->id);

$objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, (string)($i-4));
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, date('d-m-Y',strtotime($row->date)));
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, (string)$row->id);
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, (string)$row->cust_id);
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, (string)\AbserveHelpers::getuname($row->cust_id));
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, (string)$row->getumobile);
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, (string)\AbserveHelpers::getuemail($row->cust_id));
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, $row->address);
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, (string)$row->res_id);
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, (string)$row->res_name);
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $row->res_address);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, number_format($row->total_price,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, number_format($row->gst,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, number_format($row->hiking,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, number_format($row->hiking,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, number_format($row->hiking,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, number_format($row->hiking,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, number_format($row->del_charge,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, number_format($row->del_charge_tax_price,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$i, number_format(0,2));
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$i, number_format(0,2));
$objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, number_format($row->grand_total,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('W'.$i, $Ccode);
$objPHPExcel->getActiveSheet()->SetCellValue('X'.$i, number_format($row->accept_coupon_price,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i, number_format((($row->total_price+$row->del_charge)-$row->accept_coupon_price),2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$i, number_format($row->comsn_percentage,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$i, number_format($row->fixedCommission,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$i, number_format($row->host_amount,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$i, number_format($row->admin_camount,2, '.', ''));
$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$i, $row->delivery_type);
$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$i,   \AbserveHelpers::getboyname($row->id));
$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i,   $distance['pickup'].'KM');
$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$i,   number_format($distance['delivery'],2,'.','').'KM');
$del_dist = number_format($distance['total'],2,'.','');
$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i,   $del_dist.'KM');
$api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first(); 
$rate = $api_settings->delivery_boy_charge_per_km ;
$ta_earn = ($api_settings->delivery_boy_charge_per_km * $del_dist);     
$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$i, number_format($rate,2,'.','').'KM');
$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$i, number_format($ta_earn,2,'.',''));
$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$i,  date('d-m-Y h:i a',$row->time));
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
$objWriter->save(str_replace('report_excel.php', '.xlsx',base_path().'/resources/views/phpexcel/file/mis_report_'.$time.'.xlsx'));

echo json_encode("0~".$time);
?>