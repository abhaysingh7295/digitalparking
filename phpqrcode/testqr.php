<?php  
    
    echo "<h1>PHP QR Code</h1><hr/>";
    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!




    $errorCorrectionLevel = 'H';
    $matrixPointSize = 10;
    $data = 'r3ePpuj8Lk';

    $filename = $PNG_TEMP_DIR.$data.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    

        
    //display generated file
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
        
    // benchmark
   // QRtools::timeBenchmark();    

    