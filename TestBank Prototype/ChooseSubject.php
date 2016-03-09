<?php

session_start();

$subjectDir = 'Subject';
$subjectFolders = scandir($subjectDir);
$_SESSION["startIndex"] = 2;

echo 'Choose Subject<br/><br/>';
echo '<form action="ChooseVersion.php" method="post">';
echo '<select name="subjectSelection">';
for($i = $_SESSION["startIndex"]; $i < sizeof($subjectFolders); $i++) {
				echo 	'<option value="' . $subjectFolders[$i] . '">' 
							. $subjectFolders[$i]
						. '</option>';
}
echo '</select>';
echo '<input type="submit" name="submitSubject" value="Submit Choice">';
echo '</form>';

/*
 $fileToDownload = "tmp.txt";

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
 */

?>

<html>
<body>
<form action="ReturnToHTMLIndex.php" method="post">
<br/><br/><br/><br/><br/><br/><br/>
<input type="submit" name="submitHome" value="Return to home.">
</form>
</body>
</html>