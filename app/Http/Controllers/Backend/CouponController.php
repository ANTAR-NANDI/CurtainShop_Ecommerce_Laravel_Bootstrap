<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupon = Coupon::orderBy('id', 'DESC')->paginate('10');
        return view('backend.coupon.index')->with('coupons', $coupon);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();
        $status = Coupon::create($data);
        if ($status) {
            request()->session()->flash('success', 'Coupon Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('coupon.index');
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
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('backend.coupon.edit')->with('coupon', $coupon);
        } else {
            return view('backend.coupon.index')->with('error', 'Coupon not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::find($id);
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();
        $coupon->fill($data);
        $status = $coupon->save();
        if ($status) {
            request()->session()->flash('success', 'Coupon Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $status = $coupon->delete();
            if ($status) {
                request()->session()->flash('success', 'Coupon successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('coupon.index');
        } else {
            request()->session()->flash('error', 'Coupon not found');
            return redirect()->back();
        }
    }
    public function couponStore(Request $request)
    {
        // return $request->all();
        $coupon = Coupon::where('code', $request->code)->first();
        // dd($coupon);
        if (!$coupon) {
            request()->session()->flash('error', 'Invalid coupon code, Please try again');
            return back();
        }
        if ($coupon) {
            $total_price = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->sum('price');
            // dd($total_price);
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price)
            ]);
            request()->session()->flash('success', 'Coupon successfully applied');
            return redirect()->back();
        }
    }
}
