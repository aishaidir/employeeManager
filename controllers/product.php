<?php
 
require_once("../models/init.php");

$product = new Product;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
 	
 	$action = $_POST["action"];
 	
 	switch($action) {

 		case 'create': 
 			
 			$product_ = new stdClass;
			$product_->cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
			$product_->name = filter_var($_POST['p_name'], FILTER_SANITIZE_STRING);
			$product_->acronym = filter_var($_POST['p_acronym'], FILTER_SANITIZE_STRING);
			$product_->desc = $_POST['p_desc'];
			$product_->imgs = $_POST['imgs_id_in_array'];
			echo $product->create_product($product_);
			
			break; 

		case 'edit':

			$product_ = new stdClass;
			$product_->id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$product_->cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
			$product_->name = filter_var($_POST['p_name'], FILTER_SANITIZE_STRING);
			$product_->acronym = filter_var($_POST['p_acronym'], FILTER_SANITIZE_STRING);
			$product_->desc = $_POST['p_desc'];
			$product_->imgs = $_POST['imgs_id_in_array'];
			echo $product->edit_product($product_);
			
			break;
	}
}

?>