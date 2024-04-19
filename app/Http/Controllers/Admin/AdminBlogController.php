<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Cat;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;


class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest('updated_at')->paginate(10);
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $savedImagePath = $request->file('image')->store('blogs', 'public');
        $blog = new Blog($request->validated());
        $blog->image = $savedImagePath;
        $blog->save();

        return to_route('admin.blogs.index')->with('success', 'ブログを投稿しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $cats = Cat::all();
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'categories' => $categories, 
            'cats' => $cats]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $updateData = $request->validated();

        if($request->has('image')){
            Storage::disk('public')->delete($blog->image);
            $updateData['image'] = $request->file('image')->store('blogs', 'public');
        }
        $blog->category()->associate($updateData['category_id']);
        $blog->update($updateData);
        $blog->cats()->sync($updateData['cats'] ?? []);
        return to_route('admin.blogs.index')->with('success', 'ブログを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog -> delete();
        Storage::disk('public') -> delete($blog -> image);
        return to_route('admin.blogs.index')->with('success', 'ブログを削除しました');
    }
}
