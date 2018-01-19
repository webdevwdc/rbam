<?php
include('conn.php');
error_reporting(E_ALL);
ini_set("display_errors", "ON");
require_once 'lib/PHPExcel.php';
require_once 'lib/PHPExcel/IOFactory.php';


//$xls_filename = 'Data' . date('d-m-Y') . '.xls'; // Define Excel (.xls) file name
$xls_filename = 'test_exprt.xls'; // Define Excel (.xls) file name

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


//$heading_cols = "SEGMENT,DISPLAY VALUE,DESCRIPTION,ROLLUP,ACTIVE FLAG,IN USE \r\n";
$heading = array(
		    'SEGMENT' => 'SEGMENT',
		    'DISPLAY_VALUE' => 'DISPLAY VALUE',
		    'DESCRIPTION' => 'DESCRIPTION',
		    'ROLLUP' => 'ROLLUP',
		    'ACTIVE_FLAG' => 'ACTIVE FLAG',
		    'IN_USE' => 'IN USE',
	 );
$columns = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ');


$sql = "SELECT * FROM cxs_wbs order by WBS_ID";
$res = mysql_query($sql);

$rw=1;
$objPHPExcel->setActiveSheetIndex(0);
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$col=0;
foreach($heading as $hd)
    {
	   $objPHPExcel->getActiveSheet()->getRowDimension($rw)->setRowHeight(20);
	   for($h=1;$h<=15;$h++)
	   {
		  $objPHPExcel->getActiveSheet()->getColumnDimension($columns[$col])->setWidth(15);
		  $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $hd.$h);
		  $col++;
	   }
	   
    }
while($row=mysql_fetch_array($res))
{
       
    
    $col=0;
    $rw++;
    $objPHPExcel->getActiveSheet()->getRowDimension($rw)->setRowHeight(22);
    for($i=1;$i<=15;$i++)
    {
	   $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $row['SEGMENT'.$i]);
	   $col++;
    }
    for($i=1;$i<=15;$i++)
    {
	   $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $row['DISPLAY_VALUE'.$i]);
	   $col++;
    }
    for($i=1;$i<=15;$i++)
    {
	   $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $row['DESCRIPTION'.$i]);
	   $col++;
    }
    for($i=1;$i<=15;$i++)
    {
	   $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $row['ROLLUP'.$i]);
	   $col++;
    }
    for($i=1;$i<=15;$i++)
    {
	   $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $row['ACTIVE_FLAG'.$i]);
	   $col++;
    }
    for($i=1;$i<=15;$i++)
    {
	   $objPHPExcel->getActiveSheet()->setCellValue($columns[$col].$rw, $row['IN_USE'.$i]);
	   $col++;
    }
	   
}
$objPHPExcel->getActiveSheet()->setTitle('WBS');

// Redirect output to a clients web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="download_AllWBS.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>