var empty;

function disableFormButton(form, button) {
    
    "use strict"
	
    $('#'+form+' .form_val').keyup(function() {
        empty = false;

        $('#'+form+' .form_val.required').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        if(empty) {
            $('#'+button).attr('disabled', 'disabled'); 
        } 
		else {
            $('#'+button).removeAttr('disabled'); 
        }

    });

    $('#'+form+' .form_val').change(function() {
        empty = false;

        $('#'+form+' .form_val.required').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        if(empty) {
            $('#'+button).attr('disabled', 'disabled'); 
        } 
        else {
            $('#'+button).removeAttr('disabled'); 
        }

    });
}