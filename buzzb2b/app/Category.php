<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
class Category extends Model
{
  protected $table = 'categories';
  public  $fillable = ['id','name','slug','status','created_at','updated_at'];  
  
   public static  function GetAll(){
  	$categories = Category::orderBy('name','ASC')->get();
  	return $categories;
  }
}
