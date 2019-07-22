<?php


require_once("../models/init.php");


if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$partners = $partner->get_partners();
			$len = count($partners);
			echo '<thead>
				  <th style="width:30%;">Name</th>
				  <th style="width:20%;">Email</th>
				  <th style="width:10%;">Phone</th>
				  <th style="width:20%;">Website</th>
				  <th style="width:15%;">Date Created</th>
				  <th style="width: 5%;"></th>
				  </tr>
				  </thead>';
			if($partners)
			{
				for ($i = 0; $i < $len; $i++) {
					
					extract($partners[$i]);

					$edit_partner = $u_manage_company ? $base_url .'cms/company/partner/edit/'. $id : 'javascript:permissionModal();';

					if($website != '') {
						$website = '<td><a href="'. $website .'" target="_blank">'. $website .'</a></td>';
					} else {
						$website = '<td></td>';
					}
					
					echo '<tr class="data_row">
						  <td>'. $library->text_trunc($name, 50) .'</td>
						  <td><a href="mailto:'. $email .'">'. $email .'</a></td>
						  <td>'. $phone .'</td>
						  '. $website .'
						  <td>'. date('M d, Y h:i A', strtotime($date_created)) .'</td>
						  <td class="relative align_right has_menu td_menu">
								<a class="dotted_widget" href="javascript:;"></a>
								<div class="menu small" style="min-width: 170px;left: -110px;top: 43px;">
									<div class="menu_content">
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a href="'. $edit_partner .'">													
													<span>Edit partner</span>
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
														data-entity-model="partners">
														Delete partner
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