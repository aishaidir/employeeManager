<?php 

require_once('../models/init.php');

$file_obj = new File;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(!empty($_FILES["file"]))
	{
		$file = $_FILES['file'];
		$caption = $_POST['caption'];
		$file_ext = explode('/', $file_obj->get_extension($file));
		$new_filename = time().'.'.$file_ext[1];
		$file_obj->set_dir('../imgs/uploads/');
		$file_obj->set_allowed_extensions(array('image/jpeg', 'image/jpg', 'image/png'));
		$file_obj->set_filename($new_filename);
		
		if($file_obj->upload_file($file, $caption))
		{
			header("Location: ". $base_url ."cms/gallery");
		}
	}

	$page = $_POST['page'];

	switch($page) 
	{
		case 1:
			$id = $_POST['id'];
			echo $file_obj->get_file_details($id);
			break;
		case 2:
			echo json_encode(($file_obj->get_all_photos()));
			break;
	}
}

?>