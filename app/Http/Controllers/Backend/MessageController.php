<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'string|required|min:2',
        //     'email' => 'email|required',
        //     'message' => 'required|min:20|max:200',
        //     'subject' => 'string|required',
        //     'phone' => 'numeric|required'
        // ]);
        $data = new Message();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->message = $request->message;
        $data->subject = $request->subject;
        $data->phone = $request->phone;
        $status = $data->save();
        if ($status) {
            request()->session()->flash('success', 'Thanks for Contact with us !');
        } else {
            request()->session()->flash('error', 'Error occurred while sending Message !');
        }
        return redirect()->route('contact');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
