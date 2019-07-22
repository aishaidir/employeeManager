<?php


require_once("../models/init.php");
include("../incs/auth.php");

$report = new Report;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];
	$uid = $_POST['uid'];
	$rating = "-";
	switch($page):
		
		case 1: 
			$reports = $report->getWeekReport($uid);
			$len = count($reports);
			echo '<thead>
				  <th style="width:12%;">Month/Year</th>
				  <th class="align_center" style="width:10%;">Week</th>
				  <th style="width:30%;">Status</th>
				  <th style="width:20%;">Rating</th>
				  <th style="width:15%;">Date Created</th>
				  <th style="width: 13%;"></th>
				  </tr>
				  </thead>';
			if($reports) {
				for ($i = 0; $i < $len; $i++) {
					
					extract($reports[$i]);

					$status = $report->checkSubmitStatus($id) ? "Submitted" : "Not submitted";

					if($report->reviewStatus($id)) {
						$review = $report->getReportSummary($id);
						$rating = $review["rating"];
					}
					
					
					echo '<tr class="data_row">
						  <td class="">'. $month . '/'. $year .'</td>
						  <td class="align_center">'. $week .'</td>
						  <td class="">'. $status .'</td>
						  <td class="">'. $rating .'</td>
						  <td class="">'. $date_created .'</td>
						  <td class="align_right">
							
							<button class="button default_button small" onclick="window.location=\''. $baseURL .'report/'. strtolower($month) .'/'. $year .'/'. $week .'/'. $id .'\'">View 
							</button>
							
						  </td>
						  </tr>';
				}
			} else { echo '<tr><td colspan="6">No records on this table.</td></tr>'; }
		
		break;

	endswitch;

endif;

?>