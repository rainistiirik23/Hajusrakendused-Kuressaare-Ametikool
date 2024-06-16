<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function render(User $user)
    {

        return Inertia::render('Blog/Blogs', ['blogs' => new BlogResource(Blog::all())]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Blog/Blog-Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $validatedRequestData = $request->safe();
        Blog::create([
            'userId' => Auth::id(),
            'title' => $validatedRequestData->title,
            'description' => $validatedRequestData->description,
            'added_at' => now(),

        ]);
        return redirect('/Blogs');
    }

    /**
     * Display the specified resource.
     */
    public function showUsersBlogs()
    {

        return Inertia::render('Blog/Users-Blogs', ['usersBlogs' => Blog::where('userId', Auth::id())->with('user', 'comments.user')->get()]);
    }
    public function showAdminBlogEditView()
    {
        if (Gate::denies('blog-admin-edit-view')) {
            abort(403);
        }
        return Inertia::render('Blog/Blog-Admin', ['blogs' => new BlogResource(Blog::all())]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request)
    {
        $validatedRequestData = $request->safe();
        Blog::where('id', $validatedRequestData->id)->update(['title' => $validatedRequestData->title, 'description' => $validatedRequestData->description]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $blog = Blog::find($request->input('blogId'));
        $blog->comments()->delete();
        $blog->delete();
        return redirect()->back();
    }
}
