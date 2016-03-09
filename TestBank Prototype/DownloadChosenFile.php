<?php

session_start();

$fileToDownload = $_SESSION["fileDir"] . '/' . $_POST["fileSelection"];

//echo "File to download > " . $fileToDownload . '<br/>';

if(file_exists($fileToDownload)) {
	header("Content-Description: File Transfer");
	header("Content-Type: text/plain; charset=eu-ascii");
	header('Content-Disposition: attachment; filename="' . basename($fileToDownload) . '"');
	header("Expires: 0");
	header("Cache-Control: must-revalidate");
	header("Pragma: public");
	header("Conent-Length: " . filesize($fileToDownload));

	readfile($fileToDownload);
	exit;
}

?>