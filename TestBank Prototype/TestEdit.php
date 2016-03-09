

<?php

echo '*Incomplete section...* <br/><br/>';

?>


<html>
<body>
<form action="UploadTest.php" method="post">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var max_fields      = 7; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 0; //initial text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            
            $(wrapper).append('<div><textarea name="questionEditor' + String(x) + '" rows="10" cols="100" placeholder="Enter a question..." maxlength="200"></textarea><br/><input type="text" name="newSubject" placeholder="<Subject>" maxlength="50"/><br/><input type="text" name="newVersion" placeholder="<Version>" maxlength="5"/><button class="remove_field">Remove Question</button></div>'); //add input box
            x++; //text box increment
		}
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

<div class="input_fields_wrap">
	<button class="add_field_button">Add Question</button>
	<!--<div><input type="button" name="Add Question Button"></div>-->
</div>

<input type="submit" value="Create and Upload Test"/>
</form>
</body>
</html>