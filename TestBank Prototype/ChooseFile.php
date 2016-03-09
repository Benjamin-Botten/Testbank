<?php

session_start();

$_SESSION["selectedVersion"] = $_POST["versionSelection"];
$_SESSION["fileDir"] = 'Subject/' . $_SESSION["selectedSubject"] . '/Version/' . $_SESSION["selectedVersion"] . '/';
$files = scandir($_SESSION["fileDir"]);

echo '<b>You selected subject > ' . $_SESSION["selectedSubject"] . ' and version > ' . $_SESSION["selectedVersion"] . '<br/><br/><br/></b>';

echo '<form action="DownloadChosenFile.php" method="post">';
echo 'Choose File';
echo '<br/><br/>';
echo '<select name="fileSelection">';
for($i = $_SESSION["startIndex"]; $i < sizeof($files); $i++) {
	echo 	'<option value="' . $files[$i] . '">'
				. $files[$i]
			. '</option>';
}
echo '</select>';
echo '<input type="submit" name="submitFile" value="Download File">';
echo '</form>';

?>

<html>
<body>
<form action="ReturnToHTMLIndex.php" method="post">
<br/><br/><br/><br/><br/><br/><br/>
<input type="submit" name="submitHome" value="Return to home.">
</form>
</body>
</html>