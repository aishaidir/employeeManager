<?php


require_once("../models/init.php");
include("../incs/auth.php");

$task = new Task;
$library = new Library;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];
	
	switch($page):
		
		case 1: 
			$tasks = $task->getTasks($uid);
			$len = count($tasks);
			
			if($tasks) {
				for ($i = 0; $i < $len; $i++) {
					
					extract($tasks[$i]);
					
					$authorId = $author_id;
					$authorFirstName = $firstname;
					$authorLastName = $lastname;
					$taskURL = "'".$baseURL."task/".$id."/".$library->cleanURL($title)."'";
					$taskStatus = $status == 1 ? "complete" : "pending";

					echo 
						'<div class="task">
							<div class="task_title_bar clearfix">
							<span class="task_arrow">
							<i class="ion ion-android-arrow-dropright"></i>
							</span>
							<span class="task_folder">
							<i class="fa fa-folder"></i>
							</span>
							<h3 class="task_title">'. $title .'</h3>
							<div class="task_post_info">
							<span class="author">Posted by <a href="'. $user->getUserURL($authorId) .'">'. $authorFirstName. " " .$authorLastName .'</a> on</span>
							<span class="task_status '. $taskStatus .'"></span>
							<span>Fri, 2 June 2016</span>
							</div>
							</div>
							<div class="task_info">
							<div class="row">
							<div class="column_6">
							<table class="table no_border">
							<tr>
							<th class="text_top">Description</th>
							<td>'. $description .'</td>
							</tr>
							<tr>
							<th>Start Date</th>
							<td>'. date("d M, Y", strtotime($start_date)) .'</td>
							</tr>
							<tr>
							<th>Due Date</th>
							<td>'. date("d M, Y", strtotime($due_date)) .'</td>
							</tr>
							<tr>
							<th>Priority</th>
							<td>'. $priority .'</td>
							</tr>
							</table>
							</div>
							<div class="column_6">
							<div class="participants_section">
							<h3>Participants</h3>
							<ul class="participants_list clearfix">'. $task->taskParticipants($id) .'</ul>
							</div>
							</div>
							</div>
							<div class="view_more">
							<button class="button default_button" onclick="window.location = '. $taskURL .'">View more</button>
							</div>
							</div>
						</div>';

					
				}
			} else { 
				echo '<div class="no_task">';
				echo '<img src="'. $baseURL .'imgs/flag.svg">';
				echo '<h3 class="title">No more tasks for today.</h3>';
				echo '<p class="desc">Enjoy your day!</p>';
				echo '<a href="'. $baseURL .'all_tasks"><i class="fa fa-archive"></i> View task archive</a>';
				echo '</div>';
			}
		
		break;

        case 2:
            $tasks = $task->getAllTasks($uid);
            $len = count($tasks);

            if($tasks) {
                for ($i = 0; $i < $len; $i++) {

                    extract($tasks[$i]);

                    $authorId = $author_id;
                    $authorFirstName = $firstname;
                    $authorLatName = $lastname;
                    $authorProfile = $baseURL."view/".strtolower($authorFirstName.$authorLatName)."/".$authorId;
                    $taskURL = "'".$baseURL."task/".$id."/".$library->cleanURL($title)."'";
                    $taskStatus = $status == 1 ? "complete" : "pending";

                    echo
                        '<div class="task">
							<div class="task_title_bar clearfix">
							<span class="task_arrow">
							<i class="ion ion-android-arrow-dropright"></i>
							</span>
							<span class="task_folder">
							<i class="fa fa-folder"></i>
							</span>
							<h3 class="task_title">'. $title .'</h3>
							<div class="task_post_info">
							<span class="author">Posted by <a href="'. $user->getUserURL($authorId) .'">'. $authorFirstName. " " .$lastname .'</a> on</span>
							<span class="task_status '. $taskStatus .'"></span>
							<span>Fri, 2 June 2016</span>
							</div>
							</div>
							<div class="task_info">
							<div class="row">
							<div class="column_6">
							<table class="table no_border">
							<tr>
							<th class="text_top">Description</th>
							<td>'. $description .'</td>
							</tr>
							<tr>
							<th>Start Date</th>
							<td>'. date("d M, Y", strtotime($start_date)) .'</td>
							</tr>
							<tr>
							<th>Due Date</th>
							<td>'. date("d M, Y", strtotime($due_date)) .'</td>
							</tr>
							<tr>
							<th>Priority</th>
							<td>'. $priority .'</td>
							</tr>
							</table>
							</div>
							<div class="column_6">
							<div class="participants_section">
							<h3>Participants</h3>
							<ul class="participants_list clearfix">'. $task->taskParticipants($id) .'</ul>
							</div>
							</div>
							</div>
							<div class="view_more">
							<button class="button default_button" onclick="window.location = '. $taskURL .'">View more</button>
							</div>
							</div>
						</div>';


                }
            } else {
                echo '<div class="no_task">';
                echo '<img src="'. $baseURL .'imgs/flag.svg">';
                echo '<h3 class="title">No more tasks for today.</h3>';
                echo '<p class="desc">Enjoy your day!</p>';
                echo '</div>';
            }

            break;

	endswitch;

endif;

?>