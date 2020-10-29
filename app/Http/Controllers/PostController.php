<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('tag')) {

            $tag = Tag::where('name', $request->get('tag'))->first();

            $posts = $tag->posts;

            return fractal($posts, new PostTransformer())->toArray();
        }

        $posts = Post::latest()->paginate(2);

        return fractal()
            ->collection($posts)
            ->parseIncludes('tags')
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function store(Request $request)
    {
        $post = new Post();

        $post->title = $request->title;
        $post->content = $request->content;
        $post->status = $request->status;
        $post->published_at = $request->published_at;
        $post->user_id = $request->user_id;

        $post->save();

        $post->tags()->sync($request->tags);

        return fractal()
            ->item($post)
            ->parseIncludes(['tags'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->status = $request->status;
        $post->published_at = $request->published_at;

        $post->save();

        $post->tags()->sync($request->tags);

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
}
