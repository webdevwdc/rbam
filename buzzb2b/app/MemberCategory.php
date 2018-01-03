<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCategory extends Model
{
    protected $fillable = ['member_id', 'category_id'];
	protected $table = 'member_categories';

	public function category()
	{
		return $this->belongsTo('App\Category');
	}
}
