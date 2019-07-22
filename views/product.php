<?php

require_once("../models/init.php");
include("../incs/auth.php");

$product = new Product;

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$products = $product->get_products();
			$len = count($products);
			echo '<thead>
				  <th style="width:40%;">Name</th>
				  <th style="width:20%;">Category</th>
				  <th style="width:20%;">Author</th>
				  <th style="width:15%;">Date Created</th>
				  <th style="width: 5%;"></th>
				  </tr>
				  </thead>';
			if($products)
			{
				for ($i = 0; $i < $len; $i++) {
					
					extract($products[$i]);

					$edit_product = $u_manage_products ? $base_url .'cms/product/edit/'. $id : 'javascript:permissionModal();';
					
					echo '<tr class="data_row">
						  <td class="">'. $name .'</td>
						  <td class="">'. $category .'</td>
						  <td class="">'. $author .'</td>
						  <td class="">'. date('M d, Y h:i A', strtotime($date_created)) .'</td>
						  <td class="relative align_right has_menu td_menu">
								<a class="dotted_widget" href="javascript:;"></a>
								<div class="menu small" style="min-width: 170px;left: -110px;top: 43px;">
									<div class="menu_content">
										<div class="menu_section">
											<ul class="menu_list">
												<li>
													<a href="'. $edit_product .'">													
													<span>Edit product</span>
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
														data-entity-model="products">
														Delete product
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