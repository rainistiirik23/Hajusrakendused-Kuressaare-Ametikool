<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return object
     */
    public function toArray(Request $request): object
    {
        return Blog::with('user', 'comments.user')->get();

    }
}
