<?php

require_once("../models/init.php");
include("../incs/auth.php");

$user= new User();
$userArr = $user->getUsers();

$length = count($userArr);

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$users = $user->getUsers();
			$len = count($users);
			echo '
				<thead>
				<tr>
				<th style="width:15%;">Staff ID</th>
				  <th style="width:30%;">Name</th>
				  <th style="width:30;">Email</th>
				  <th style="width:15%;">Designation</th>
				  <th style="width: 10%;"></th>
				  </tr>
				 </thead>';
				  echo "<tbody>";
                if($length > 0) {
                    for ($i = 0; $i < $length; $i++) {
                        extract($userArr[$i]);


					$username = strtolower(str_replace(' ', '', $name));
					 // <th style="width:20%;">Supervisor</th>
//<td class=""><a href="'. $user->getUserURL($supervisorId) .'">'. $supervisorName .'</a></td>
					// $supervisor = $user->getSupervisor($id) != NULL ? $user->getSupervisor($id) : "";
					// $supervisorId = $supervisor["id"];
					// $supervisorName = $supervisor["firstname"]. " ".$supervisor["lastname"];
					// $supervisorName_ = strtolower(str_replace(" ", "",$supervisor["firstname"].$supervisor["lastname"]));
					
					echo '<tr class="data_row">
						 <td class="">'. $staffid .'</td>
						  <td class="">'. $library->textTrunc($name, 20) .'</td>
						  <td class=""><a href="mailto:'. $email .'">'. $email .'</a></td>
						  <td class="">'. $designation .'</td>
						  <td class="clearfix relative align_right has_menu td_menu">
								<a class="dotted_widget" href="javascript:;"></a>
								<div class="menu small" style="min-width: 170px;left: -58px;top: 43px;">
									<div class="menu_content">
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a href="'. $user->getUserURL($id) .'">													
													<span>View user</span>
													</a>
												</li>
												<li>
													<a href="'. $baseURL .'user/edit/'. $id .'">													
													<span>Edit user</span>
													</a>
												</li>
											</ul>
										</div>
										<div class="menu_divider"></div>
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a 
														class="delete_item delete" 
														href="javascript:;" 
														data-entity-id="'. $id .'"
														data-entity-model="services">
														Delete user
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</td>
						  </tr>';
				}
			} else { echo '<tr><td colspan="6">No records on this table.</td></tr>'; }
			echo "</tbody>";
		
		break;

	endswitch;

endif;

?>