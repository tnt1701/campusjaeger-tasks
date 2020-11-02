<?php

namespace App\Filters;

use App\Models\Tag;
use App\Models\Post;

class PostFilters extends Filters
{
    protected $filters = ['tag'];

    protected function tag($tag)
    {
        $tagObject = Tag::where('name', $tag)->firstOrFail();

        return $this->builder->whereHas('tags', function($query) use ($tagObject) {
            $query->where('name', $tagObject->name);
        })->get();
    }
}
