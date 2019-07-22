<?php


require_once("../models/init.php");
//include("../incs/auth.php");

$role = new Role;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$roles = $role->getRoles();
			$len = count($roles);
			echo '<thead>
				  <th style="width:20%;">Role</th>
				  <th style="width:35%;">Description</th>
				  <th style="width:20%;">Author</th>
				  <th style="width:20%;">Date Created</th>
				  <th style="width: 5%;"></th>
				  </tr>
				  </thead>';
			if($roles) {
				for ($i = 0; $i < $len; $i++) {
					
					extract($roles[$i]);

					//$edit_service = $u_manage_services ? $baseURL .'cms/service/edit/'. $id : 'javascript:permissionModal();';
					
					echo '<tr class="data_row">
						  <td class="">'. $role .'</td>
						  <td class="">'. $library->textTrunc($description, 50) .'</td>
						  <td class="">Ismaila</td>
						  <td class="">'. date('M d, Y h:i A', strtotime($date_created)) .'</td>
						  <td class="clearfix relative align_right has_menu td_menu">
								<a class="dotted_widget" href="javascript:;"></a>
								<div class="menu small" style="min-width: 170px;left: -110px;top: 43px;">
									<div class="menu_content">
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a href="">													
													<span>Edit role</span>
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
														Delete role
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
		
		break;

	endswitch;

endif;

?>