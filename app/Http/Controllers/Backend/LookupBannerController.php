<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LookupBanner;
use Illuminate\Support\Str;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
class LookupBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = LookupBanner::orderBy('id', 'DESC')->paginate(10);
        return view('backend.lookup-banner.index')->with('banners', $banner);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.lookup-banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'string|nullable|max:50',
            'description' => 'string|nullable',
            'photo' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        $data = new LookupBanner();
        $title = $request->title;
        $slug = Str::slug($request->title);
        $count = LookupBanner::where('slug', $title)->count();
        if ($count > 0) {
            $slug = $request->title . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data->slug = $slug;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = $request->status;
        //upload image
        if ($request->hasfile('photo')) {
            $image = $request->file('photo');
            $img = Image::make($image);
            $name_gen = time().hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $img->resize(80, 80);
            $img->save(base_path('public/uploads/thumbnail/lookup-banners/' . $name_gen));
            $img->save(base_path('public/uploads/images/lookup-banners/' . $name_gen));
            $data->photo = $name_gen;
        }
        $status = $data->save();
        if ($status) {
            request()->session()->flash('success', 'Lookup Banner successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding banner');
        }
        return redirect()->route('lookup-banner.index');
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
        $banner = LookupBanner::findOrFail($id);
        return view('backend.lookup-banner.edit')->with('banner', $banner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = LookupBanner::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|nullable|max:50',
            'description' => 'string|nullable',
            // 'photo' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->status = $request->status;
        $title = $request->title;
        $slug = Str::slug($request->title);
        $count = LookupBanner::where('slug', $title)->count();
        if ($count > 0) {
            $slug = $request->title . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $banner->slug = $slug;
        if ($request->hasfile('photo')) {
            if (file_exists(public_path() . '/uploads/thumbnail/lookup-banners/' . $banner->photo)) {
                unlink(public_path() . '/uploads/thumbnail/lookup-banners/' . $banner->photo);
            }
            if (file_exists(public_path() . '/uploads/images/lookup-banners/' . $banner->photo)) {
                unlink(public_path() . '/uploads/images/lookup-banners/' . $banner->photo);
            }
            $originalImage = $request->file('photo');
            //dd($originalImage);
            $thumbnailImage = Image::make($originalImage);
            $time = time();
            $thumbnailPath = public_path() . '/uploads/images/lookup-banners/';
            $originalPath = public_path() . '/uploads/thumbnail/lookup-banners/';
            $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            $banner->photo = $time . $originalImage->getClientOriginalName();
        }
        // dd($banner);
        $status = $banner->save();
        if ($status) {
            request()->session()->flash('success', 'Lookup Banner successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred while updating banner');
        }
        return redirect()->route('lookup-banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = LookupBanner::findOrFail($id);
        $status = $banner->delete();
        if ($status) {
            request()->session()->flash('success', 'Banner successfully deleted');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting banner');
        }
        return redirect()->route('lookup-banner.index');
    }
}
