<?php

include_once("models/init.php");
include_once('incs/auth.php');

$task = new Task;

if(isset($_GET["id"]) && isset($_GET["title"])) {
	$taskId = $_GET["id"];
	$taskInfo = $task->getTaskDetails($taskId, $uid);
	if($taskInfo == 0) {
		Header("Location: ". $baseURL ."");
	} else {
		$authorId = $taskInfo["author_id"];
		$title = $taskInfo["title"];
		$description = $taskInfo["description"];
		$startDate = $taskInfo["start_date"];
		$dueDate = $taskInfo["due_date"];
		$priority = $taskInfo["priority"];
		$status = $taskInfo["status"] == 1 ? "checked='checked'" : "";
		$isAuthor = !$task->isAuthor($taskId, $uid) ? "disabled" : "";
	}
} 

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $siteTitle; ?></title>
		<meta name="description" content="">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="0"/>
		<?php include_once("incs/src_links.php"); ?>
		<script type="text/javascript">
        $(function() {
        	$("body").on("change", "#task_status", function() {
        		var status = 0, taskId = "<?php echo $taskId; ?>";
        		var promptMsg = $('.prompt_msg');
        		var promptMsgTxt = "Task has been completed.";
        		if ( $('input[name="task_status"]').is(':checked') ) {
        			status = 1;
        		}
        		$.ajax({
        			url: baseURL()+"controllers/task.php",
					type: "POST",
					data: "action=update_status&status="+status+"&task_id="+taskId,
					beforeSend: function() {},
					success: function(response) {
						if(response == 100) {
							promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Success</h2><p>'+ promptMsgTxt +'</p>');
						} else if(response == 200) {
							promptMsgTxt = "Task has been set as  uncomplete.";
							promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Success</h2><p>'+ promptMsgTxt +'</p>');
						} else {
							promptMsgTxt = "Oops! An unknown error has occured.";
							promptMsg.html('<div class="close_prompt_msg"><i class="fa fa-close"></i></div><h2 class="prompt_msg_header">Error</h2><p>'+ promptMsgTxt +'</p>');
						}
						promptMsg.addClass('success').css({'visibility':'visible', 'opacity':1});
					},
					complete: function(response) {
						setTimeout(function(){
							promptMsg.css({'visibility':'hidden', 'opacity':0});
							promptMsg.removeClass('success');
							promptMsg.removeClass('error');
						}, 3000);
					},
					error: function(response) {},
					timeout: 30000
        		});
        	});

        	disableFormButton('participant_update_form', 'participant_update_form_button'); 
        	disableFormButton('review_participant_form', 'review_participant_form_button'); 
        });
        </script>
	</head>
	
	<body>
		
		<!-- light_overlay -->
		<div class="light_overlay"></div>
		<!-- /light_overlay -->
		
		<!-- page_container -->
		<div class="page_container">
			
			<!-- aside -->
			<?php include_once("incs/aside.php"); ?>
			<!-- /aside -->
			
			<!-- header -->
			<header cleafix>
				<div class="mobile_navicon pull_left">
					<i class="ion ion-navicon"></i>
				</div>
				<h3 class="page_title clearfix">
					<span><?php echo $title ?></span>
				</h3>
				<!-- header_widgets -->
				<?php include_once("incs/header_widgets.php"); ?>
				<!-- header_widgets -->
			</header>
			<!-- /header -->
			
			<!-- page_content -->
			<div class="page_content">
				<div class="prompt_msg"></div>
				<!-- task_section -->
				<div class="task_section">
					
					<div class="row">
						<div class="column_6">
							<table class="table no_border">
								<tr>
									<th class="text_top">Description</th>
									<td><?php echo $description; ?></td>
								</tr>
								<tr>
									<th>Start Date</th>
									<td><?php echo date("d F, Y", strtotime($startDate))?></td>
								</tr>
								<tr>
									<th>Due Date</th>
									<td><?php echo date("d F, Y", strtotime($dueDate))?></td>
								</tr>
								<tr>
									<th>Priority</th>
									<td><?php echo $priority; ?></td>
								</tr>
								<tr>
									<th>Status</th>
									<td class="relative">
										<div style="position: absolute;top: 8px;">
											<label class="switch">
												<input type="checkbox" id="task_status" name="task_status" <?php echo $status. " " .$isAuthor; ?>>
												<div class="slider round"></div>
											</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="column_6">
							<div class="participants_section">
								<h3>Participants</h3>
								<ul class="participants_list clearfix">
									<?php
										echo $task->taskParticipantForReview($taskId, $uid);
									?>
								</ul>
							</div>
						</div>
					</div>
				
				</div>
				<!-- /task_section -->

				<?php
					if($task->isParticipant($taskId, $uid)) {
						$participantDetails = $task->getParticipantDetails($taskId, $uid);
						$disableTextarea = $participantDetails["status"] == 1 ? 'disabled' : '';
						$disableInput = $participantDetails["status"] == 1 ? 'disabled' : '';
						$participantStatus = $participantDetails["status"] == 1 ? 'checked' : '';
						echo '<div class="participant_area">';
					    echo '<h3>Participant Area</h3>';
						echo '<form action="javascript:void(0)" id="participant_update_form" data-controller="task" form-type="participant_update">';
						echo '<input type="hidden" name="task_id" value="'. $taskId .'">';
						echo '<input type="hidden" name="author_id" value="'. $authorId .'">';
						echo '<div class="form_group">';
						echo '<label>Status</label>';
						echo '<label class="switch">';
						echo '<input type="checkbox" class="form_val required" name="participant_status" '. $participantStatus .' '. $disableInput .'>';
						echo '<div class="slider round"></div>';
						echo '</label>';
						echo '</div>';
						echo '<div class="form_group">';
						echo '<label>Remarks</label>';
						echo '<textarea class="form_val" id="participant_remarks" name="participant_remarks" '. $disableTextarea .'>'. $participantDetails["remarks"] .'</textarea>';
						echo '</div>';
						echo '<div class="form_action no_padding">';
						echo '<button type="button" class="button primary_button small process" data-form="participant_update_form" id="participant_update_form_button" disabled="disabled" onclick="javascript:processForm(\'participant_update_form\', \'Save\')">Save</button>';
						echo '</div>';
						echo '</form>';
						echo '</div>';
					}
				?>
			
			</div>
			<!-- /page_content -->
			
		</div>
		<!-- /page_container -->

		<div class="modal small" id="review_participant">
	        <div class="modal_backdrop"></div>
	        <div class="modal_dialogue">
	        <form action="javascript:void(0)" id="review_participant_form" data-controller="task" form-type="review_participant">
	            <input type="hidden" id="task_id" name="task_id" value="<?php echo $taskId; ?>">
	            <input type="hidden" id="participant_id" name="participant_id">
	            <div class="modal_content">
	                <div class="modal_header">
	                    <h4 id="participant_name">John Doe</h4>
	                </div>
	                
	                <div class="modal_body">	
	                    <table class="table no_border">
	                    	<tr>
	                    		<th>Status</th>
	                    		<td id="participant_status">-</td>
	                    	</tr>
	                    	<tr>
	                    		<th>Remarks</th>
	                    		<td id="participant_remarks">-</td>
	                    	</tr>
	                    	<tr>
	                    		<th>Date</th>
	                    		<td id="participant_date_updated"></td>
	                    	</tr>
	                    	<tr>
	                    		<th>Rate</th>
	                    		<td>
	                    			<div class="form_item clearfix">
										<div class="radio_option">
											<label for="bad">
												<input type="radio" class="form_val" id="bad" name="rating" value="Bad"> 
												<span>Bad</span>
											</label>
										</div>
										<div class="radio_option">
											<label for="good">
												<input type="radio" class="form_val" id="good" name="rating" value="Good"> 
												<span>Good</span>
											</label>
										</div>
										<div class="radio_option">
											<label for="awesome">
												<input type="radio" class="form_val" id="awesome" name="rating" value="Awesome"> 
												<span>Awesome</span>
											</label>
										</div>
									</div>
	                    		</td>
	                    	</tr>
	                    	<tr>
	                    		<th>Remarks</th>
	                    		<td>
	                    			<input type="text" class="form_val" id="author_remarks" name="author_remarks">
	                    		</td>
	                    	</tr>
	                    </table>
	                </div>
	                
	                <div class="modal_footer">
	                    <button type="button" class="button small cancel_button cancel_delete">Cancel</button>
	                    <button 
							type="button" 
							class="button primary_button small process"
							data-form="review_participant_form"
							id="review_participant_form_button" 
							disabled="disabled" 
							onclick="javascript:processForm('review_participant_form', 'Save')">Save</button>
	                </div>
	            </div>
	            </form>
	        </div>
    	</div>
		
	</body>

</html>
