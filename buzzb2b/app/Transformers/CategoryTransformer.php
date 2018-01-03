<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Category;

class CategoryTransformer extends TransformerAbstract {

    public function transform(Category $category)
    {
        return [
			'id' => $category->id,
			'name' => $category->name,
			'slug' => $category->slug,
        ];
    }
}