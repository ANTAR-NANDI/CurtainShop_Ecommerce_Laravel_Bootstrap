<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::getAllPost();
        return view('backend.post.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PostCategory::get();
        $tags = PostTag::get();
        $users = User::get();
        return view('backend.post.create')->with('users', $users)->with('categories', $categories)->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'quote' => 'string|nullable',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'nullable',
            'tags' => 'nullable',
            'added_by' => 'nullable',
            'post_cat_id' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->quote = $request->quote;
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;
        $post->added_by = $request->added_by;
        $post->status = $request->status;

        $slug = Str::slug($request->title);
        $count = Post::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $post->slug = $slug;

        $tags = $request->tags;
        if ($tags) {
            $post->tags = implode(',', $tags);
        } else {
            $post->tags = '';
        }
        //upload image
        if ($request->hasfile('photo')) {
            // $originalImage = $request->file('photo');
            // $thumbnailImage = Image::make($originalImage);
            // $time = time();
            // $thumbnailPath = public_path() . '/uploads/thumbnail/posts/';
            // $originalPath = public_path() . '/uploads/images/posts/';
            // $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            // $thumbnailImage->resize(150, 150);
            // $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            // $post->photo = $time . $originalImage->getClientOriginalName();
            $image = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $name_gen = time() . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img = $img->resize(600, 600);
            $img->toJpeg(80)->save(base_path('public/uploads/thumbnail/posts/' . $name_gen));
            $img->toJpeg(80)->save(base_path('public/uploads/images/posts/' . $name_gen));
            $post->photo = $name_gen;
        }
        // return $data;

        $status =
            $post->save();
        if ($status) {
            request()->session()->flash('success', 'Post Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = PostCategory::get();
        $tags = PostTag::get();
        $users = User::get();
        return view('backend.post.edit')->with('categories', $categories)->with('users', $users)->with('tags', $tags)->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        // return $request->all();
        $this->validate($request, [
            'title' => 'string|required',
            'quote' => 'string|nullable',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|nullable',
            'tags' => 'nullable',
            'added_by' => 'nullable',
            'post_cat_id' => 'required',
            'status' => 'required|in:active,inactive'
        ]);

        $post->title = $request->title;
        $post->quote = $request->quote;
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;
        $post->added_by = $request->added_by;
        $post->status = $request->status;

        $slug = Str::slug($request->title);
        $count = Post::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $post->slug = $slug;

        $tags = $request->tags;
        if ($tags) {
            $post->tags = implode(',', $tags);
        } else {
            $post->tags = '';
        }
        if ($request->hasfile('photo')) {
            // dd("Test");
            if (file_exists(public_path() . '/uploads/thumbnail/posts/' . $post->photo)) {
                unlink(public_path() . '/uploads/thumbnail/posts/' . $post->photo);
            }
            if (file_exists(public_path() . '/uploads/images/posts/' . $post->photo)) {
                unlink(public_path() . '/uploads/images/posts/' . $post->photo);
            }
            // $originalImage = $request->file('photo');
            // //dd($originalImage);
            // $thumbnailImage = Image::make($originalImage);
            // $time = time();
            // $thumbnailPath = public_path() . '/uploads/images/products/';
            // $originalPath = public_path() . '/uploads/thumbnail/products/';
            // $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            // $thumbnailImage->resize(150, 150);
            // $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            // $post->photo = $time . $originalImage->getClientOriginalName();
            $image = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $name_gen = time() . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img = $img->resize(600, 600);
            $img->toJpeg(80)->save(base_path('public/uploads/thumbnail/posts/' . $name_gen));
            $img->toJpeg(80)->save(base_path('public/uploads/images/posts/' . $name_gen));
            $post->photo = $name_gen;
        }

        $status = $post->save();
        if ($status) {
            request()->session()->flash('success', 'Post Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('post.index');
    }
    /**              
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $status = $post->delete();

        if ($status) {
            request()->session()->flash('success', 'Post successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting post ');
        }
        return redirect()->route('post.index');
    }
}
