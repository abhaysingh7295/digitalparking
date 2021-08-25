<?php  require_once '../config.php';


$vendorid = $_REQUEST['id'];

$PNG_TEMP_DIR = '../qrcodes/'.$vendorid.'/';
if (!file_exists($PNG_TEMP_DIR)){
   mkdir($PNG_TEMP_DIR,0777, true); 
}


$qr_code = substr( str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 15 );

$qrcode_file = $qr_code.'.png';


$select_qr = $con->query("SELECT * FROM `vendor_qr_codes` Where vendor_id='".$vendorid."'"); 
$numrows_qr = $select_qr->num_rows;
if($numrows_qr==0){
	//include "../phpqrcode/qrlib.php";
	$errorCorrectionLevel = 'S';
	$matrixPointSize = 10;

	$qrcodeData = $qr_code;
	$qrcodeno = $qr_code.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
	$qrcodegenratedata = $qrcodeData.md5($qr_code.'|'.$errorCorrectionLevel.'|'.$matrixPointSize);
	QRcode::png($qrcodeData, $PNG_TEMP_DIR.$qrcode_file, $errorCorrectionLevel, $matrixPointSize, 2);
	$con->query("INSERT INTO vendor_qr_codes(vendor_id,qr_code) VALUES('$vendorid','$qr_code')");
} else {
	$qr_code_row = $select_qr->fetch_assoc();
	$qrcode_file = $qr_code_row['qr_code'].'.png';
}

?>


<img src="<?php echo $PNG_TEMP_DIR.$qrcode_file; ?>" width="400" />