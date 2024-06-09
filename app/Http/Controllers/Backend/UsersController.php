<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        //dd($users);
        return view('backend.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required|unique:users',
                'password' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable',
            ]
        );
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->role = $request->role;
        $data->status = $request->status;
        //upload image
        if ($request->hasfile('photo')) {
            $image = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $name_gen = time() . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img = $img->resize(600, 600);
            $img->toJpeg(80)->save(base_path('public/uploads/thumbnail/categories/' . $name_gen));
            $img->toJpeg(80)->save(base_path('public/uploads/images/categories/' . $name_gen));
            $data->photo = $name_gen;
            // $originalImage = $request->file('photo');
            // $thumbnailImage = Image::make($originalImage);
            // $time = time();
            // $thumbnailPath = public_path() . '/uploads/thumbnail/users/';
            // $originalPath = public_path() . '/uploads/images/users/';
            // $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            // $thumbnailImage->resize(150, 150);
            // $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            // $data->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $data->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully added user');
        } else {
            request()->session()->flash('error', 'Error occurred while adding user');
        }
        return redirect()->route('users.index');
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
        $user = User::findOrFail($id);
        return view('backend.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //dd($user);
        $this->validate(
            $request,
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable',
            ]
        );
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;
        // $user->phone = $request->phone;
        if ($request->hasfile('photo')) {
            // dd("Test");
            if ($user->photo != null) {
                if (file_exists(public_path() . '/uploads/thumbnail/users/' . $user->photo)) {
                    unlink(public_path() . '/uploads/thumbnail/users/' . $user->photo);
                }
                if (file_exists(public_path() . '/uploads/images/users/' . $user->photo)) {
                    unlink(public_path() . '/uploads/images/users/' . $user->photo);
                }
            }
            $image = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $name_gen = time() . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img = $img->resize(600, 600);
            $img->toJpeg(80)->save(base_path('public/uploads/thumbnail/users/' . $name_gen));
            $img->toJpeg(80)->save(base_path('public/uploads/images/users/' . $name_gen));
            $user->photo = $name_gen;

            // $originalImage = $request->file('photo');
            // //dd($originalImage);
            // $thumbnailImage = Image::make($originalImage);
            // $time = time();
            // $thumbnailPath = public_path() . '/uploads/images/users/';
            // $originalPath = public_path() . '/uploads/thumbnail/users/';
            // $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            // $thumbnailImage->resize(150, 150);
            // $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            // $user->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $user->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated');
        } else {
            request()->session()->flash('error', 'Error occured while updating');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = User::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            request()->session()->flash('success', 'User Successfully deleted');
        } else {
            request()->session()->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
