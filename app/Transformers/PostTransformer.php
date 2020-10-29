<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['tag'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'published_at' => $post->published_at,
            'created_at' => $post->created_at->diffForHumans()
        ];
    }

    public function includeTag(Post $post)
    {
        return $this->collection($post->tags, new TagTransformer);
    }
}
