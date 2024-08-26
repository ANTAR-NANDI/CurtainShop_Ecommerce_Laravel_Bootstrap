<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use App\Models\Setting;
use App\Rules\MatchOldPassword;
use Intervention\Image\Facades\Image;
class AdminController extends Controller
{
    // Admin Dashboard View
    public function index()
    {
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        return view('backend.index')->with('users', json_encode($array));
    }
    // Settings View
    public function settings()
    {
        $data = Setting::first();

        return view('backend.setting')->with('data', $data);
    }
    // Settings Update
    public function settingsUpdate(Request $request)
    {

        $data = Setting::first();

        $data->short_des = $request->short_des;
        $data->description = $request->description;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->phone = $request->phone;
        if ($request->hasfile('photo')) {
            if (file_exists(public_path() . '/uploads/thumbnail/settings/' . $data->photo)) {
                unlink(public_path() . '/uploads/thumbnail/settings/' . $data->photo);
            }
            if (file_exists(public_path() . '/uploads/images/settings/' . $data->photo)) {
                unlink(public_path() . '/uploads/images/settings/' . $data->photo);
            }
            $originalImage = $request->file('photo');
            $thumbnailImage = Image::make($originalImage);
            $time = time();
            $thumbnailPath = public_path() . '/uploads/images/settings/';
            $originalPath = public_path() . '/uploads/thumbnail/settings/';
            $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            $data->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $data->save();
        if ($status) {
            request()->session()->flash('success', 'Setting successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again');
        }
        return redirect()->route('settings');
    }

    // User / Admin Profile View
    public function profile()
    {
        $profile = Auth()->user();
        return view('backend.users.profile')->with('profile', $profile);
    }
    // Profile Update 
    public function profileUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        if ($request->hasfile('photo')) {
            if ($user->photo != null) {
                if (file_exists(public_path() . '/uploads/thumbnail/users/' . $user->photo)) {
                    unlink(public_path() . '/uploads/thumbnail/users/' . $user->photo);
                }
                if (file_exists(public_path() . '/uploads/images/users/' . $user->photo)) {
                    unlink(public_path() . '/uploads/images/users/' . $user->photo);
                }
            }
            $originalImage = $request->file('photo');
            $thumbnailImage = Image::make($originalImage);
            $time = time();
            $thumbnailPath = public_path() . '/uploads/images/users/';
            $originalPath = public_path() . '/uploads/thumbnail/users/';
            $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            $user->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $user->save();
        if ($status) {
            request()->session()->flash('success', 'Successfully updated your profile');
        } else {
            request()->session()->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }
    // Change Password View
    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    // Change Password Update
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'Password successfully changed');
    }



}
