<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ],[
            'name.required' => 'Nama pelanggan wajib diisi',
            'latitude.required' => 'Lokasi belum dipilih',
            'longitude.required' => 'Lokasi belum dipilih'
        ]);

        $customer = Customer::create($validated);

        return response()->json($customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ],[
            'name.required' => 'Nama pelanggan wajib diisi',
            'latitude.required' => 'Latitude wajib ada',
            'longitude.required' => 'Longitude wajib ada'
        ]);

        $customer->update($validated);

        return response()->json([
            'success'=>true,
            'customer'=>$customer
        ]);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => true
        ]);
    }
}