<?php namespace Peos\Api\Transformers;

use League\Fractal\TransformerAbstract;
use Peos\Tags\Tag;

class TagTransformer extends TransformerAbstract {

    public function transform(Tag $tag)
    {
        return [
			'name' => $tag->name,
			'slug' => $tag->slug,
        ];
    }
}