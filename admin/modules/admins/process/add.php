<?php
if($_POST){
	if($form->empty_control($_POST,$empty)){
		$_POST["password"] = $core->password($_POST["password"]);
		$username_dedect = $core->get_row("admins","*","WHERE username='".$_POST["username"]."'");
		if($username_dedect){
			$core->message("error","Bu kullanıcı Adı Daha Önce Kaydedilmiş.");
		}else{
		
			if($_FILES["image"]["name"]!=""){
				$file_name = "avatars_".$core->file_name($_FILES["image"]["name"]);
				$file_type = strtolower(strrchr($_FILES["image"]["name"],"."));

				$thumbs = array(
					array("width"=>120, "height"=>120, "ratio_crop"=>1, "upload_folder"=>"uploads/pictures/", "name_pre"=>"image_",),
				);
				if($core->image_upload("image","uploads/pictures/",$thumbs,$file_name)){
					$_POST["avatar"] = "uploads/pictures/image_".$file_name.$file_type;
					$image_upload = 1;
				}
			}

			if($sql->quick_add(Module_Table,$_POST)) unset($data);
			elseif($image_upload==1){
				@unlink($_POST["avatar"]); 
				@unlink(str_replace("image_","",$_POST["avatar"]));
			}
		}
	}
}
?>