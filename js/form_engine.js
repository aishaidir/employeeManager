function processForm(form, init) {
	var valid = true;	

	$('#'+form+' .form_val').each(function(index, value) {
		var id = $(this).attr('id'), post,
		    value = $(this).val();

		if(form == 'task_form') {
			var currentDate = new Date();
				currentDate.setHours(1);
			    currentDate.setMinutes(0);
			    currentDate.setSeconds(0);
			    currentDate = currentDate.getDate();
			    currentDate_ = parseInt(currentDate);
			var startDate = $("#start_date").val();
				startDate = new Date(startDate).getDate();
				startDate_ = parseInt(startDate);
			var dueDate = $("#due_date").val();
				dueDate = new Date(dueDate).getDate();
				dueDate_ = parseInt(dueDate);
			if(startDate < currentDate) {
				$('span.validation_error#start_date_error').html('Start date cannot be lesser than current date').show();
				$("#start_date").addClass('validation_error').focus();
				valid = false;
			} else if(startDate > dueDate) {
				$('span.validation_error#due_date_error').html('Start date cannot be greater than due date').show();
				$("#due_date").addClass('validation_error').focus();
				valid = false;
			}
		}


		if($(this).hasClass('required') && !value.length) {
			$('span.validation_error#'+ id +'_error').html('This is a required field.').show();
			$(this).addClass('validation_error');
			this.focus();
			valid = false;
		} 
		else {
			$(this).removeClass('validation_error');
			$('span.validation_error#'+ id +'_error').hide();	
		}
	
	});

	if(valid) {
		var url, controller, dataString, formType, formData, button, promptMsg;
			button = $('#'+form+' .process');
			promptMsg = $('.prompt_msg');
			controller = $('#' + form).attr('data-controller'); 
			formType = $('#' + form).attr('form-type'); 
			formData = new FormData($('#'+form)[0]);
            formData.append('action', formType);
			
            if(form == 'role_form') {  
            	
            }

            url = baseURL()+'controllers/'+controller+'.php';
		$.ajax({
			url: url,
			type: 'POST',
			data: formData,
			beforeSend: function() {
				if(form != 'login_form') {
					button.html('<i class="ion ion-load-b fa-spin"></i> Saving...');
				} 
				else {
					button.html('<i class="ion ion-load-b fa-spin"></i> Signing in...');
				} 
				
				button.attr('disabled', true);
				
			},
			success: function(response) { 
				
				scrollWindow();
				var promptMsgTxt;
				
				button.html(init);
				
				if(response == 100) {
					
					if(formType == 'create') {
						
						button.attr('disabled', true);
						
						$('#'+form+' .form_val').val('');
						
						if($("input:checkbox").is(":checked")) {
							$("input:checkbox").prop("checked", false);
						}

					} else if(formType == "create_weekly_report") {
						$('#'+form+' .form_val').attr("disabled", true);
						$("#weekly_report_form_button").remove();
						$(".report_submitted").html("You have submitted this week's report").show();
					} else if(formType == "edit") {
						if(form == 'user_form') {
							promptMsgTxt = "User has been modified successfully.";
						}

					}

					if(form == 'role_form') {
						promptMsgTxt = "Role has been created successfully.";
					}
					if(form == 'user_form') {
						promptMsgTxt = "User has been created successfully.";
					}
					if(form == 'profile_form') {
						promptMsgTxt = "Your profile has been modified successfully.";
					}
					if(form == 'password_form') {
						promptMsgTxt = "Your password has been changed successfully.";
						$('#'+form+' .form_val').val('');
					}
					if(form == 'report_form') {
						window.location = baseURL()+"reports"
					}
					if(form == 'edit_day_report_form') {
						var edittedActivity = $("#edit_activity").val();
						var edittedMilestone = $("#edit_milestone").val();
						var dailyId = $("#edit_daily_id").val();
						$("#activity"+dailyId).val(edittedActivity), 
            			$("#milestone"+dailyId).val(edittedMilestone),
						$("span#activity"+dailyId).html(edittedActivity);
						$("span#milestone"+dailyId).html(edittedMilestone);
						$('.modal#edit_report').css({'visibility':'hidden', 'opacity':0});
						promptMsgTxt = "Report has been edited successfully.";
					}
					if(form == 'submit_report_form') {
						button.attr('disabled', false);
						location.reload();
					}
					if(form == "rating_form" || form == "participant_update_form") {
						location.reload();
					}
					if(form == 'task_form') {
						window.location = baseURL()+"tasks";
					}	
					if(form == 'login_form') {
						window.location = baseURL()+"reports";
					}
					if(form != 'login_form' 
						&& form != "task_form"
						&& form != "submit_report_form" 
						&& form != "create_daily_report" 
						&& form != "report_form" 
						&& form != "rating_form"
						&& form != "participant_update_form"
						&& form != "review_participant_form") {
						promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Success</h2><p>'+ promptMsgTxt +'</p>');
						promptMsg.addClass('success').css({'visibility':'visible', 'opacity':1});
					}
				
				} else if(response == 101) {
					button.attr('disabled', false);
					
					if(form == 'login_form') {
						promptMsgTxt = "Invalid Phone Number/Email and/or Password."
					}

					promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Error</h2><p>'+ promptMsgTxt +'</p>');
					promptMsg.addClass('error').css({'visibility':'visible', 'opacity':1});
				} else if(response == 201) {
					button.attr('disabled', false);

					if(form == 'report_form') {
						promptMsgTxt = "Oops... Seems you have already submitted today's report";
					}

					if(form == 'user_form' || form == 'profile_form') {
						promptMsgTxt = "Phone number is already in use."
					}

					if(form == 'password_form') {
						promptMsgTxt = "Invalid password."
					}

					promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Error</h2><p>'+ promptMsgTxt +'</p>');
					promptMsg.addClass('error').css({'visibility':'visible', 'opacity':1});
				} 
				else if(response == 202) {
					button.attr('disabled', false);

					if(form == 'user_form' || form == 'profile_form')
					{
						promptMsgTxt = "Email is already in use."
					}

					if(form == 'password_form')
					{
						promptMsgTxt = "Passwords do not match."
					}

					promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Error</h2><p>'+ promptMsgTxt +'</p>');
					promptMsg.addClass('error').css({'visibility':'visible', 'opacity':1});
				}	
			},
			timeout: 50000,
			complete: function(){
				setTimeout(function(){
					promptMsg.css({'visibility':'hidden', 'opacity':0});
					promptMsg.removeClass('success');
					promptMsg.removeClass('error');
				}, 3000);
			},
			error: function(){
				scrollWindow();
				promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Error</h2><p>An unknown error has occured. Please try again.</p>');
				promptMsg.addClass('error').css({'visibility':'visible', 'opacity':1});
				button.html(init);
				button.attr('disabled', false);
			},
			//Options to tell jQuery not to process data or worry about content-type.
			cache: false,
			contentType: false,
			processData: false
		});
	}
}



$('body').on('click', '.process', function(){
	var form = $(this).attr('data-form');
		processForm(form);
});