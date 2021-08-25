<?php require_once '../../config.php';


// Include and initialize ZipArchive class
require_once 'ZipArchiver.class.php';
$zipper = new ZipArchiver;

// Path of the directory to be zipped
$dirPath = DIR;

// Path of output zip file
$zipPath = __DIR__.'/mvc.zip';

// Create zip archive
$zip = $zipper->zipDir($dirPath, $zipPath);

if($zip){
	header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($zipPath).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zipPath));
    flush(); // Flush system output buffer
    readfile($zipPath);
    die();
}else{
    echo 'Failed to create ZIP.';
}