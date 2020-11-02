<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $tag = new Tag();

        $tag->name = $request->name;
        $tag->save();

        return fractal()
            ->item($tag)
            ->transformWith(new TagTransformer)
            ->toArray();
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $this->validate($request, [
            'name' => 'required'
        ]);        

        $tag->name = $request->name;
        $tag->save();

        return fractal()
            ->item($tag)
            ->transformWith(new TagTransformer)
            ->toArray();
    }

    public function destroy($id)
    {
        Tag::findOrFail($id)->delete();

        return response('Deleted Sucessfully', 200);
    }
}
