<?php namespace App\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Categories\Category;

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