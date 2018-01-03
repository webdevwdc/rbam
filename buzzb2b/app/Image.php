<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use File;

class Image extends Model{
	protected $table = 'images';
	public $fillable = ['imageable_id','image_type','filename',];
    
    /**
    *upload image
    *@param $file is file name 
    *@param $user user details for which you are uploading this image 
    */
	public static function UploadImage($file,$user){
		$path = public_path().'/upload/members/'.$user->image;
    	File::delete($path);
		$extension = $file->getClientOriginalExtension();
	    $file_name = time().'.'.$extension;
		$path = public_path().'/upload/members';
		$upload = $file->move($path,$file_name);
		return $user->update(['image'=>$file_name]);
	}
}
