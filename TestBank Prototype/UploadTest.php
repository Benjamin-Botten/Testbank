<?php

echo '*Incomplete section...*<br/><br/>';

for($i = 0; $i < 7; $i++)
	if(isset($_POST["questionEditor" . $i])) {
		echo 'Question ' . $i . ' > <br/><b>' .
				$_POST["questionEditor" . $i] . '</b><br/>';
	} 
	/*else {
		echo 'Found no question editor to get question from<br/>';
	}*/

echo '<b><i>Successfully created and uploaded test!</i></b>';

?>