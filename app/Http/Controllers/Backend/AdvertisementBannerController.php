<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdvertisementBanner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
class AdvertisementBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = AdvertisementBanner::orderBy('id', 'DESC')->paginate(10);
        return view('backend.advertisement-banner.index')->with('banners', $banner);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.advertisement-banner.create');
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
        $data = new AdvertisementBanner();
        $title = $request->title;
        $slug = Str::slug($request->title);
        $count = AdvertisementBanner::where('slug', $title)->count();
        if ($count > 0) {
            $slug = $request->title . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data->slug = $slug;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = $request->status;
        //upload image
        if ($request->hasfile('photo')) {
            $originalImage = $request->file('photo');
            $thumbnailImage = Image::make($originalImage);
            $time = time();
            $thumbnailPath = public_path() . '/uploads/thumbnail/advertisement-banners/';
            $originalPath = public_path() . '/uploads/images/advertisement-banners/';
            $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            $data->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $data->save();
        if ($status) {
            request()->session()->flash('success', 'Advertisement Banner successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding banner');
        }
        return redirect()->route('advertisement-banner.index');
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
        $banner = AdvertisementBanner::findOrFail($id);
        return view('backend.advertisement-banner.edit')->with('banner', $banner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = AdvertisementBanner::findOrFail($id);
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
        $count = AdvertisementBanner::where('slug', $title)->count();
        if ($count > 0) {
            $slug = $request->title . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $banner->slug = $slug;
        if ($request->hasfile('photo')) {
            if (file_exists(public_path() . '/uploads/thumbnail/advertisement-banners/' . $banner->photo)) {
                unlink(public_path() . '/uploads/thumbnail/advertisement-banners/' . $banner->photo);
            }
            if (file_exists(public_path() . '/uploads/images/advertisement-banners/' . $banner->photo)) {
                unlink(public_path() . '/uploads/images/advertisement-banners/' . $banner->photo);
            }
            $originalImage = $request->file('photo');
            //dd($originalImage);
            $thumbnailImage = Image::make($originalImage);
            $time = time();
            $thumbnailPath = public_path() . '/uploads/images/advertisement-banners/';
            $originalPath = public_path() . '/uploads/thumbnail/advertisement-banners/';
            $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            $banner->photo = $time . $originalImage->getClientOriginalName();
        }
        // dd($banner);
        $status = $banner->save();
        if ($status) {
            request()->session()->flash('success', 'Advertisement Banner successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred while updating banner');
        }
        return redirect()->route('advertisement-banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = AdvertisementBanner::findOrFail($id);
        $status = $banner->delete();
        if ($status) {
            request()->session()->flash('success', 'Banner successfully deleted');
        } else {
            request()->session()->flash('error', 'Error occurred while deleting banner');
        }
        return redirect()->route('advertisement-banner.index');
    }
}
