<?php

session_start();

$_SESSION["selectedSubject"] = $_POST["subjectSelection"];
$_SESSION["versionDir"] = 'Subject/' . $_SESSION["selectedSubject"] . '/Version';
$versionFolders = scandir($_SESSION["versionDir"]);

echo '<b>You selected > ' . $_SESSION["selectedSubject"] . '<br/><br/><br/></b>';
	
echo '<form action="ChooseFile.php" method="post">';
echo 'Choose Version';
echo '<br/><br/>';
echo '<select name="versionSelection">';
for($i = $_SESSION["startIndex"]; $i < sizeof($versionFolders); $i++) {
	echo 	'<option value="' . $versionFolders[$i] . '">'
				. $versionFolders[$i]
			. '</option>';
}
echo '</select>';
echo '<input type="submit" name="submitVersion" value="Submit Choice">';
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