<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('frontend.pages.registration');
    }
    public function signupSubmit(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|required|min:2',
            'mobile' => 'required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        Session::put('user', $data['email']);
        Session::put('name', $data['first_name'] . " " . $data['last_name']);
        if ($check) {
            request()->session()->flash('success', 'Successfully Registered');
            return redirect()->route('/');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }
    public function create(array $data)
    {
        // dd($data);
        return User::create([
            'name' => $data['first_name'] . " " . $data['last_name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
}
