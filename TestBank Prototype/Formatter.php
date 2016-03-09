<?php

class Formatter {
	function formatQTI($textFile) {
	}
}

$uploadPath = getcwd() . "\\tmp.txt";
$uploadedFile = $_FILES["uploadFileTest"]["name"];
$fileString;

if(isset($uploadedFile) && $uploadedFile !== "") {
	print "A file was chosen before submitting > " . $uploadedFile;
	
	//$fileContents = file_get_contents($uploadedFile);
	
	if(move_uploaded_file($_FILES["uploadFileTest"]["tmp_name"], $uploadPath)) {
		echo "<br/>The file " . $uploadedFile . " has been uploaded to > " . $uploadPath;
		echo "<br/>Displaying contents... > <br/><br/>";
		echo "<font color=\"green\" size=\"2\"><p><b><i>" . file_get_contents($uploadPath) . "</i></b></p></font>";
	} else {
		echo "Error uploading file";
	}
} else {
	echo "No file was chosen before submitting";
}