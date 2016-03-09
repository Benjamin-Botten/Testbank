<?php

session_start();

$questionText = $_POST["questionEditor"];
$questionSubject = $_POST["newSubject"];
$questionVersion = $_POST["newVersion"];

if(!strlen(trim($questionSubject)) || !strlen(trim($questionVersion))) {
	echo "Error uploading question, subject and version not set!";
	$_SESSION["missingData"] = true;
	header("Location: QuestionEdit.php");
	exit;
} else {
	$_SESSION["missingData"] = false;
}

if(file_exists('Subject/' . $questionSubject)) {
	if(file_exists('Subject/' . $questionSubject . '/Version/' . $questionVersion)) {
	} else {
		if(file_exists('Subject/' . $questionSubject . '/Version') !== true) {
			mkdir('Subject/' . $questionSubject . '/Version');
			mkdir('Subject/' . $questionSubject . '/Version/' . $questionVersion);
		} else {
			mkdir('Subject/' . $questionSubject . '/Version/' . $questionVersion);
		}
	}
} else {
	mkdir('Subject/' . $questionSubject);
	mkdir('Subject/' . $questionSubject . '/Version');
	mkdir('Subject/' . $questionSubject . '/Version/' . $questionVersion);
}

$filename = 'Subject/' . $questionSubject . '/Version/' . $questionVersion . '/' . 'testitem' . date('Y-m-d H-i-s') . '.txt';

echo "Created a file with contents > <br/><br/>" . $questionText . "<br/></br> In Subject > " . $questionSubject . " with Version " 
		. $questionVersion;

echo "<br/>Filepath > " . $filename;

if(file_put_contents($filename, $questionText) !== false) {
	echo "<br/><br/><b>Successfully uploaded question</b><br/>";
}

?>

<html>
<body>
<form action="ReturnToHTMLIndex.php" method="post">
<br/><br/><br/><br/><br/><br/><br/>
<input type="submit" name="submitHome" value="Return to home.">
</form>
</body>
</html>