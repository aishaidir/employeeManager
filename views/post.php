<?php


require_once("../models/init.php");
include("../incs/auth.php");

$post = new Post;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$posts = $post->get_posts();
			$len = count($posts);
			echo '<thead>
			      <th class="align_center" style="width:10%;">Status</th>
				  <th style="width:25%;" class="">Title</th>
				  <th style="width:20%;">Category</th>
				  <th style="width:20%;">Author</th>
				  <th style="width:15%;">Date Posted</th>
				  <th style="width: 5%;"></th>
				  </tr>
				  </thead>';
			if($posts)
			{
				//$delete_post = $u_delete_post ? $base_url .'cms/post/edit/'. $id : 'javascript:permissionModal();';
				
				for ($i = 0; $i < $len; $i++) {
					extract($posts[$i]);

					$edit_post = $u_edit_post ? $base_url .'cms/post/edit/'. $id : 'javascript:permissionModal();';

					$pub_or_unpub = '<li>';
					if($status == "Published")
					{
						$status = "<span class='status success'></span>";
						$pub_unpub_perm = $u_publish_post ? $base_url .'cms/post/unpublish/'. $id : 'javascript:permissionModal();';
						$pub_or_unpub .= '<a href="'. $pub_unpub_perm .'"><span>Unpublish post</span></a>';
					} else
					{
						$status = "<span class='status pending'></span>";
						$pub_unpub_perm = $u_publish_post ? $base_url .'cms/post/publish/'. $id : 'javascript:permissionModal();';
						$pub_or_unpub .= '<a href="'. $pub_unpub_perm .'"><span>Publish post</span></a>';
					}
					$pub_or_unpub .= '</li>';
		
					echo '<tr class="data_row">
						  <td class="">'. $status .'</td>
						  <td class="">'. $library->text_trunc($title, 30) .'</td>
						  <td class="">'. $category .'</td>
						  <td class="">'. $author .'</td>
						  <td class="">'. date('M d, Y h:i A', strtotime($date_posted)) .'</td>
						  <td class="relative align_right has_menu td_menu">
								<a class="dotted_widget" href="javascript:;"></a>
								<div class="menu small" style="min-width: 170px;left: -110px;top: 43px;">
									<div class="menu_content">
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a href="'. $edit_post .'">													
													<span>Edit post</span>
													</a>
												</li>
												'. $pub_or_unpub .'
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
														data-entity-model="posts">
														Delete post
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