<?php

require_once("../models/init.php");

$file = new File;
$img_url = $base_url.'imgs/uploads/';

if($_SERVER['REQUEST_METHOD'] == "POST"):
	$page = $_POST["page"];

	switch($page):
		
		case 1: 
			$all_photos = $file->get_all_photos();
			$len = count($all_photos);
			
			if($all_photos)
			{
				for ($i = 0; $i < $len; $i++) 
				{
					extract($all_photos[$i]);
					echo '<div class="column_2">
						  <div class="photo">
						  <a class="mini_callout_button delete" data-entity-id="'. $id .'" data-entity-model="photos">
						  	<i class="ion ion-trash-b"></i>
						  </a>
						  <div class="photo_overlay"></div>
						  <div class="bg_photo" style="background-image: url('. $img_url . $filename. ')"></div>
						  </div>
					      </div>';
				}
			} else 
			{  
				echo '<div class="display_table">
					  <div class="display_table_cell">
					  	<div class="no_contents">No photos has been uploaded yet.</div>
					  </div>
					  </div>';
			}
		
		break;

	endswitch;

endif;

?>