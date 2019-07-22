<?php


require_once("../models/init.php");
include("../incs/auth.php");

$sub = new Subordinate;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];
	$uid = $_POST['uid'];
	switch($page):
		
		case 1: 
			$subs = $sub->getSubordinates($uid);
			$len = count($subs);
			echo '<thead>
				  <th style="width:20%;">Name</th>
				  <th style="width:20%;">Email</th>
				  <th style="width:17%;">Designation</th>
				  <th style="width:15%;">Date Created</th>
				  <th style="width: 7%;"></th>
				  </tr>
				  </thead>';
			if($subs) {
				for ($i = 0; $i < $len; $i++) {
					
					extract($subs[$i]);

					$editUser = $userLoggedIn->hasPrivilege("Manage Users") ? $baseURL .'user/edit/'. $id : 'javascript:permissionModal();';
					$firstName = $nameWithNoSpace[0];
					$lastName = $nameWithNoSpace[1];
					$nameWithNoSpace = strtolower($firstName.$lastName);
					
					echo '<tr class="data_row">
						  <td class="">'. $library->textTrunc($name, 20) .'</td>
						  <td class=""><a href="mailto:'. $email .'">'. $email .'</a></td>
						  <td class="">'. $designation .'</td>
						  <td class="">'. date('M d, Y h:i A', strtotime($date_assigned)) .'</td>
						  <td class="align_right">
							
							<button class="button default_button small" onclick="window.location=\''. $user->getUserURL($id)  .'\'">
							View 
							</button>
							
						  </td>
						  </tr>';
				}
			} else { echo '<tr><td colspan="6">No records on this table.</td></tr>'; }
		
		break;

	endswitch;

endif;

?>