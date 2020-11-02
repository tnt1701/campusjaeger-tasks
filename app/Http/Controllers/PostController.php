<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Filters\PostFilters;
use App\Transformers\PostTransformer;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Tag $tag, PostFilters $filters)
    {
        $posts = $this->getPosts($tag, $filters);

        return fractal()
            ->collection($posts)
            ->parseIncludes('tags')
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function store(PostStoreRequest $request)
    {
        $post = Post::create([
            'title' => request('title'),
            'content' => request('content'),
            'status' => request('status'),
            'published_at' => request('published_at'),
            'user_id'=> request('user_id')
        ]);

        $post->tags()->sync(request('tags'));

        return fractal()
            ->item($post)
            ->parseIncludes(['tags'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'title' => request('title'),
            'content' => request('content'),
            'status' => request('status'),
            'published_at' => request('published_at')
        ]);

        $post->tags()->sync(request('tags'));

        return fractal()
            ->item($post)
            ->parseIncludes(['tags'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function show($id)
    {
        $post = Post::find($id);

        if ($post === null) {
            return response(null, 404);
        }

        return fractal($post, new PostTransformer)->toArray();
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return response('Deleted Sucessfully', 200);
    }

    protected function getPosts(Tag $tag, PostFilters $filters)
    {
        $posts = Post::latest()->filter($filters);

        if ($tag->exists) {
            $posts->whereHas('tag_id', $tag->id);
        }

        return $posts->get();
    }
}
