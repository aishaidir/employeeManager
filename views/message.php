<?php


require_once("../models/init.php");

$message = new Message;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$messages = $message->get_messages();
			$len = count($messages);
			echo '<thead>
				  <th style="width:20%;">Name</th>
				  <th style="width:20%;">Email</th>
				  <th style="width:35%;">Message</th>
				  <th style="width:20%;">Date Posted</th>
				  <th style="width: 5%;"></th>
				  </tr>
				  </thead>';
			if($messages)
			{
				for ($i = 0; $i < $len; $i++) {
					
					extract($messages[$i]);
					
					echo '<tr class="data_row">
						  <td class="">'. $first_name . ' ' . $last_name .'</td>
						  <td class="">'. $email .'</td>
						  <td class="">'. $library->text_trunc($message, 50) .'</td>
						  <td class="">'. date('M d, Y h:i A', strtotime($date_posted)) .'</td>
						  <td class="relative align_right has_menu td_menu">
								<a class="dotted_widget" href="javascript:;"></a>
								<div class="menu small" style="min-width: 170px;left: -110px;top: 43px;">
									<div class="menu_content">
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a href="'. $base_url .'cms/message/view/'. $id .'">													
													<span>View message</span>
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
														data-entity-model="messages">
														Delete message
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</td>
						  </tr>';
				}
			} else { echo '<tr><td colspan="5">No records on this table.</td></tr>'; }
		
		break;

	endswitch;

endif;

?>