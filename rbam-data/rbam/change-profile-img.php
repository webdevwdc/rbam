<?php
include("conn.php");
if(isset($_FILES["photoimg"]) && $_FILES["photoimg"]["name"] != "")
{
	$userId = $_POST['hdn-profile-id'];
	
	if ($_FILES["photoimg"]["error"] > 0)
	{
		$msg = "Return Code: " . $_FILES["photoimg"]["error"] . "<br />";
	}
	else
	{
	 
		$ext = pathinfo($_FILES["photoimg"]["name"], PATHINFO_EXTENSION);
		
		$info   = getimagesize($_FILES['photoimg']['tmp_name']);
		$width  = $info[0];      // width as integer for ex. 512
		$height = $info[1];      // height as integer for ex. 384
		
		if (!file_exists('img/uploads/user_images/'.$userId)) {
			mkdir('img/uploads/user_images/'.$userId, 0777, true);
		}
		$photo_name = $_FILES["photoimg"]["name"];
		$ds = move_uploaded_file($_FILES["photoimg"]["tmp_name"], "img/uploads/user_images/".$userId."/".$photo_name) or die('error');
		
		
		
		$updArr['PHOTO'] = $photo_name;
				    
		updatedata("cxs_users",$updArr," Where USER_ID = $userId");
		echo "<img id='photo' src='img/uploads/user_images/".$userId."/".$photo_name."' class='preview' style='max-width: 600px;'/>|img/uploads/user_images/".$userId."/".$photo_name;
	}
}

/*********************************************************************
     Purpose            : update image.
     Parameters         : null
     Returns            : char
     ***********************************************************************/
/*	 $post = isset($_POST) ? $_POST: array();
	 //print_R($post);die;
	 switch($post['action']) {
	  case 'save' :
		saveAvatarTmp();
	  break;
	  default:
		changeAvatar();
		
	 }
*/	
	 function changeAvatar() {
        $post = isset($_POST) ? $_POST: array();
        $max_width = "500"; 
        $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
        $path = 'images/tmp';

        $valid_formats = array("jpg","jpeg"); //array("jpg", "png", "gif", "bmp","jpeg");
        $name = $_FILES['photoimg']['name'];
        $size = $_FILES['photoimg']['size'];
        if(strlen($name))
        {
		  list($txt, $ext) = explode(".", $name);
		  if(in_array($ext,$valid_formats))
		  {
			 if($size<(1024*1024)) // Image size max 1 MB
			 {
				$actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
				$filePath = $path .'/'.$actual_image_name;
				$tmp = $_FILES['photoimg']['tmp_name'];
        
				if(move_uploaded_file($tmp, $filePath))
				{
				    $width = getWidth($filePath);
				    $height = getHeight($filePath);
            //Scale the image if it is greater than the width set above
            if ($width > $max_width){
                $scale = $max_width/$width;
                $uploaded = resizeImage($filePath,$width,$height,$scale);
            }else{
                $scale = 1;
                $uploaded = resizeImage($filePath,$width,$height,$scale);
            }
        /*$res = saveAvatar(array(
                        'userId' => isset($userId) ? intval($userId) : 0,
                                                'avatar' => isset($actual_image_name) ? $actual_image_name : '',
                        ));*/
                        
        //mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
        echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".$filePath.'?'.time()."' class='preview'/>";
        }
        else
        echo "failed";
        }
        else
        echo "Image file size max 1 MB"; 
        }
        else
        echo "Invalid file format.."; 
        }
        else
        echo "Please select image..!";
        exit;
        
        
    }
/*********************************************************************
     Purpose            : update image.
     Parameters         : null
     Returns            : integer
***********************************************************************/
function saveAvatarTmp() {
    $post = isset($_POST) ? $_POST: array();
    $userId = isset($post['id']) ? intval($post['id']) : 0;
    $path ='\images\uploads\tmp';
    $t_width = 300; // Maximum thumbnail width
    $t_height = 300;    // Maximum thumbnail height
		
    if(isset($_POST['t']) && $_POST['t'] == "ajax")
    {
        extract($_POST);
        
        $imagePath = 'images/tmp/'.$_POST['image_name'];
        $ratio = ($t_width/$w1); 
        $nw = ceil($w1 * $ratio);
        $nh = ceil($h1 * $ratio);
        $nimg = imagecreatetruecolor($nw,$nh);
        $im_src = imagecreatefromjpeg($imagePath);
        imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
        imagejpeg($nimg,$imagePath,90);
        
	   
	   move_uploaded_file($imagePath, $_POST['image_name']);
    }
    echo $imagePath.$nimg;
    //echo $imagePath.'?'.time();
    exit(0);    
}
    
    /*********************************************************************
     Purpose            : resize image.
     Parameters         : null
     Returns            : image
     ***********************************************************************/
    function resizeImage($image,$width,$height,$scale)
    {
	   $newImageWidth = ceil($width * $scale);
	   $newImageHeight = ceil($height * $scale);
	   $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	   
	   
	   
	   $source = imagecreatefromjpeg($image);
	   imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	   imagejpeg($newImage,$image,90);
	   
	   
	   chmod($image, 0777);
	   return $image;
    }
/*********************************************************************
     Purpose            : get image height.
     Parameters         : null
     Returns            : height
     ***********************************************************************/
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/*********************************************************************
     Purpose            : get image width.
     Parameters         : null
     Returns            : width
     ***********************************************************************/
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}
?>
