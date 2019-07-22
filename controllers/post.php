<?php
 
require_once("../models/init.php");

$post = new Post;
$user = new User;

if($user->is_logged_in())
{
	$user_info = $user->is_logged_in();
	$uid = $user_info->id;
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
 	
 	$action = $_POST["action"];
 	
 	switch($action) {

 		case 'create': 
 			
 			$post_ = new stdClass;
			$post_->cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
			$post_->title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
			$post_->post = $_POST['post'];
			$post_->author_id = $uid;
			$post_->imgs = $_POST['imgs_id_in_array'];
			echo $post->create_post($post_);
			
			break; 

		case 'edit':

			$post_ = new stdClass;
			$post_->id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			$post_->cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
			$post_->title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
			$post_->post = $_POST['post'];
			$post_->imgs = $_POST['imgs_id_in_array'];
			echo $post->edit_post($post_);
			
			break;
	}
}

if(isset($_GET['action']) && isset($_GET['id']))
{
	$action = $_GET['action'];
	$id = $_GET['id'];
	if($post->pub_unpub_post($action, $id, $uid))
	{
		$_SESSION['pub_unpub_success'] = $action == "publish" ? "Post was published successful" : "Post was unpublished successful";
	} else
	{
		$_SESSION['pub_unpub_failed'] = md5(time());
	}
	header('Location: '. $base_url . 'cms/' .'posts');
}

?>