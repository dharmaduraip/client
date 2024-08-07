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

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G2');


$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'MIS Report');
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(16);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:G4');
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5:AN5')->getFont()->setBold(true);
        // $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Sl.no');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Order Date');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Order ID');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Customer ID');  
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Customer Name');  
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Customer Mobile');  
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Customer Mail');  
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Delivery Address');  
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Store ID');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Store Name');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Store Address');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Store Price');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Total Base Price');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Gst Amount(of the item)');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Total Amount Hiked');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('P5', 'GST on Hiked Amount');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Final Product Price');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Delivery Fees');
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('S5', 'Delivery Tax');
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('T5', 'Conv. Fee');
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('U5', 'Conv. Tax');
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('V5', 'Total Cost');
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('W5', "Promo Code Discount"); 
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('X5', 'Promo Amount');   
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true); 
$objPHPExcel->getActiveSheet()->SetCellValue('Y5', 'Order Value');   
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('Z5', 'Commission Percentage');    
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AA5', 'Commission Value');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AB5', 'Net Payable to Shop');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AC5', 'Total Earning');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AD5', 'Payment Mode');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AE5', 'Delivery Boy Name');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AF5', 'Pickup Travel in KM');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AG5', 'Delivery Travel In KM');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AH5', 'Total Travel');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AI5', 'Rate Per KM');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AJ5', 'TA Earned');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AK5', 'Order Placed time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AL5', 'Accepted Time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AM5', 'Dispatched time');    
$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('AN5', 'Completed time');  
$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);  


/*Order Report Details*/
$objPHPExcel->getActiveSheet()->SetCellValue('A8', 'MIS Order Report');
$objPHPExcel->getActiveSheet()->getStyle('A8:G9')->getFont()->setSize(16);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A8:G9');
$objPHPExcel->getActiveSheet()->getStyle('A8:G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A10:S10')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A8:G9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:G9')->getFont()->setSize(19);
        // $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(12);
// $objPHPExcel->getActiveSheet()->SetCellValue('A10', 'Sl.no');
// $objPHPExcel->getActiveSheet()->getColumnDimension('A10')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('B10', 'Item Name');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('C10', 'Quantity Ordered');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('D10', 'MRP ( Shop Price )');  
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('E10', 'GST % APPLICABLE');  
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('F10', 'BASE PRICE (OF THE ITEM)');  
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('G10', 'GST AMOUNT (OF THE ITEM)');  
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('H10', 'BASE PRICE * QUANTITY ORDERED');  
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('I10', 'GST * QUANTITY ORDERED');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('J10', 'TOTAL VALUE');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('K10', 'ADMIN COMM. %');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('L10', 'ADMIN COMM. AMOUNT');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('M10', 'PAYANLE AMOUNT TO VENDOR / SHOP');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('N10', 'GST ON PAYABLE AMOUNT TO VENDOR / SHOP');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('O10', 'NET PAYABLE TO VENDOR / SHOP');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('P10', 'HIKED %');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('Q10', 'AMOUNT HIKED * Qnty.');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('R10', 'GST AMOUNT');
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->SetCellValue('S10', 'TOTAL COST OF THE ITEM DISPLAYED (to cutomer)');

$order_items = \DB::table('abserve_order_items')->select(\DB::Raw('sum((price / (100+gst))*100) as baseprice'),\DB::Raw('sum((price - (price / (100+gst))*100)) as gst_amount'),\DB::Raw('sum(price) as store_price'),\DB::Raw('sum(hiking_gst_price * quantity) as hikingGstPrice'),\DB::Raw('sum(admin_cmsn_amt * quantity) as admin_cmsn_value'),\DB::Raw('sum(((base_price - admin_cmsn_amt) + vendor_gstamount) * quantity) as netPayableShop'),\DB::Raw('sum((hiking_price) * quantity) as totalHikingPrice'),\DB::Raw('sum((hiking_gst_price) * quantity) as totalHikingGST'),\DB::Raw('sum((base_price + base_price_gst + hiking_price + hiking_gst_price) * quantity) as finalPPrice'),'food_item','quantity')->where('orderid',$orderData->id)->where('check_status','yes')->first();

$i = 6;
if(count(array($orderData))>0)
{
  $distance = \AbserveHelpers::getBoyTravelledReport($orderData->id);
  if($orderData->coupon_id>0){
       $coupon_code=\DB::table('abserve_promocode')->where('id',$orderData->coupon_id)->first();
        if($coupon_code){
       $Ccode=$coupon_code->promo_code;
        }else{
            $Ccode='';
        }
   }
     

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, (string)($i-5));
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, date('d-m-Y',strtotime($orderData->date)));
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, (string)$orderData->id);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i,  (string)$orderData->cust_id);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i,  (string)\AbserveHelpers::getuname($orderData->cust_id));
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i,  (string)\AbserveHelpers::getumobile($orderData->cust_id));
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i,  (string)\AbserveHelpers::getuemail($orderData->cust_id));
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i,   (string)$orderData->address);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, (string)$orderData->res_id);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, (string)\AbserveHelpers::restsurent_name($orderData->res_id));
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, (string)\AbserveHelpers::restsurent_address($orderData->res_id));
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i, number_format($order_items->store_price,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i, number_format($order_items->baseprice,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$i, number_format($order_items->gst_amount,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i, number_format($order_items->totalHikingPrice,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, number_format($order_items->totalHikingGST,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, number_format($order_items->finalPPrice,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, number_format($orderData->del_charge,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$i, number_format($orderData->del_charge_tax_price,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$i,'0');
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$i,'0');
    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$i, number_format($orderData->accept_grand_total,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$i, number_format($orderData->coupon_value,2, '.',''));
    $objPHPExcel->getActiveSheet()->SetCellValue('X'.$i, number_format($orderData->accept_coupon_price,2, '.',''));
    $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$i,(string)$orderData->accept_grand_total);
    $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$i, number_format($orderData->comsn_percentage,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$i, number_format($order_items->admin_cmsn_value,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$i, number_format($order_items->netPayableShop,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$i, number_format($orderData->accept_grand_total - $order_items->netPayableShop,2, '.', ''));
    $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$i, (string)$orderData->delivery_type);
    $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$i,   (string)\AbserveHelpers::getboyname($orderData->id));
    $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$i,   (string)$distance['pickup'].'KM');
    $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$i,   number_format($distance['delivery'],2,'.','').'KM');
    $del_dist = number_format($distance['total'],2,'.','');
    $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$i,$del_dist.'KM');
    $api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first();
    $rate = $api_settings->delivery_boy_charge_per_km ;
    $ta_earn = ($api_settings->delivery_boy_charge_per_km * $del_dist);    
    $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$i, number_format($rate,2,'.','').'KM');
    $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$i, number_format($ta_earn,2,'.',''));
    $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$i,  date('d-m-Y h:i a',$orderData->time));
    $objPHPExcel->getActiveSheet()->SetCellValue('AL'.$i,  (string)($orderData->accepted_time!=='') ? date('d-m-Y h:i a',$orderData->accepted_time) : '');
    $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$i,  (string)($orderData->dispatched_time!=='') ? date('d-m-Y h:i a',$orderData->dispatched_time) : '' );
    $objPHPExcel->getActiveSheet()->SetCellValue('AN'.$i,  (string)($orderData->completed_time!=='') ? date('d-m-Y h:i a',$orderData->completed_time) : '' );
    $i++;
  }
$i = 11;

  $order_items = \DB::table('abserve_order_items')->select('*')->where('orderid',$orderData->id)->where('check_status','yes')->get();
  $rest=\DB::table('abserve_restaurants')->select('commission')->find($orderData->res_id);
  if(!empty($order_items))
  {

    foreach($order_items as $k => $v)
    {
     $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, (string)($i-10));
     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, (string)$v->food_item);
     $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, (string)$v->quantity);
     $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, (string)$v->price);
     $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, (string)$v->gst);
     $original= ($v->price / (100 + $v->gst)) * 100;
     $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, number_format($original,2,'.',''));
     $gst_price = ($original * ($v->gst / 100));
     $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, number_format($gst_price,2,'.',''));
     $base=($v->quantity * $original);
     $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i,number_format($base,2,'.',''));
     $gst_quan = ($v->quantity * $gst_price);
     $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i,number_format($gst_quan,2,'.',''));
     $tot_val=($v->quantity * $original) + ($v->quantity * $gst_price);
     $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, number_format($tot_val,2, '.', ''));
     $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, $rest->commission);
     $admin_com_amt = ($original * ($rest->commission / 100));
     $admin_com=($v->quantity * $admin_com_amt);
     $objPHPExcel->getActiveSheet()->SetCellValue('L'.$i,number_format($admin_com,2, '.', ''));
     $payanle=(($v->quantity * $original) - $admin_com);
     $objPHPExcel->getActiveSheet()->SetCellValue('M'.$i,number_format($payanle,2,'.',''));
     $gst_payable=(($v->gst/100)*$payanle);
     $objPHPExcel->getActiveSheet()->SetCellValue('N'.$i,number_format($gst_payable,2,'.',''));
     $net_payable = ($payanle + $gst_payable);
     $objPHPExcel->getActiveSheet()->SetCellValue('O'.$i,number_format($net_payable,2,'.',''));
     $objPHPExcel->getActiveSheet()->SetCellValue('P'.$i, number_format($v->hiking,2,'.',''));
     $amt_hike = ($v->quantity * $original * $v->hiking/100);
     $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$i, number_format ($amt_hike,2, '.', ''));
     $gst_amt=(($v->gst/100)*$amt_hike);
     $objPHPExcel->getActiveSheet()->SetCellValue('R'.$i, number_format($gst_amt,2, '.', ''));
     $tot= (($v->price* $v->quantity) + $amt_hike + $gst_amt) ;
     $objPHPExcel->getActiveSheet()->SetCellValue('S'.$i,number_format($tot,2, '.', '' ));
     $i++;
     $quant = 0;$price = 0;$base_p = 0;$base_pr = 0;$tot_v = 0;
     $gst_qu = 0;$tot_v = 0;$base_p_gst = 0;$ac=0;$pay=0;$gst_pay=0;$net_pay = 0;$amt_hi = 0;$gstamt = 0;$tot_price = 0;
     $col=$i;
     $quant += $v->quantity;
     $price += $v->price;
     $base_p += $v->base_price;
     $base_p_gst += $v->base_price_gst;
     $base_pr += $base;
     $gst_qu += $gst_quan;
     $tot_v +=$tot_val;
     $ac +=$admin_com;
     $pay += $payanle;
     $gst_pay += $gst_payable;
     $net_pay +=$net_payable;
     $amt_hi +=$amt_hike;
     $gstamt += $gst_amt;
     $tot_price += $tot;
     
     
     $objPHPExcel->getActiveSheet()->SetCellValue('C'.$col, (string)$quant);
     
     $objPHPExcel->getActiveSheet()->SetCellValue('D'.$col, (string)$price);
        
         $objPHPExcel->getActiveSheet()->SetCellValue('F'.$col, (string)$base_p);
         
         $objPHPExcel->getActiveSheet()->SetCellValue('G'.$col, (string)$base_p_gst);
         
         $objPHPExcel->getActiveSheet()->SetCellValue('H'.$col, number_format($base_pr,2,'.',''));
         
         $objPHPExcel->getActiveSheet()->SetCellValue('I'.$col, number_format($gst_qu,2,'.',''));
          
         $objPHPExcel->getActiveSheet()->SetCellValue('J'.$col, number_format($tot_v,2,'.',''));
          
         $objPHPExcel->getActiveSheet()->SetCellValue('L'.$col, number_format($ac,2,'.',''));
          
         $objPHPExcel->getActiveSheet()->SetCellValue('M'.$col, number_format($pay,2,'.',''));
          
         $objPHPExcel->getActiveSheet()->SetCellValue('N'.$col, number_format($gst_pay,2,'.',''));
          
         $objPHPExcel->getActiveSheet()->SetCellValue('O'.$col, number_format($net_pay,2,'.',''));
         
         $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$col, number_format($amt_hi,2,'.',''));
          
         $objPHPExcel->getActiveSheet()->SetCellValue('R'.$col, number_format($gstamt,2,'.',''));
         
         $objPHPExcel->getActiveSheet()->SetCellValue('S'.$col, number_format($tot_price,2,'.',''));

       }  
  
}

// echo "<pre>";print_r($orderData->id);exit();
// Save Excel 2007 file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
//$objWriter->save(str_replace('.php', '_'.$vacat.'.xlsx', __FILE__));

$time=time()."-".date('Y-m-d-H:i:s');
$order_id = $orderData ->id;
// echo base_path();die();
$objWriter->save(str_replace('report_excel.php', '.xlsx',base_path().'/resources/views/phpexcel/file/'.$order_id.'mis_report_.xlsx'));

echo json_encode("0~".$time);
?>