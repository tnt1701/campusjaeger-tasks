<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostStoreRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request, [
                'title' => 'required',
                'content' => 'required',
                'status' => 'required',
                'published_at' => 'required',
                'user_id' => 'required'
            ]
        );

        parent::__construct($request);
    }
}
