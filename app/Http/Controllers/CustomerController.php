<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = trim($request->keyword);

                $query->where(function ($q) use ($keyword) {
                    $q->where('full_name', 'like', '%' . $keyword . '%')
                      ->orWhere('phone', 'like', '%' . $keyword . '%')
                      ->orWhere('email', 'like', '%' . $keyword . '%')
                      ->orWhere('identity_number', 'like', '%' . $keyword . '%')
                      ->orWhere('address', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->get();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'identity_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên khách hàng.',
            'email.email' => 'Email không đúng định dạng.',
        ]);

        Customer::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'identity_number' => $request->identity_number,
            'address' => $request->address,
        ]);

        return redirect()->route('customers.index')->with('success', 'Thêm khách hàng thành công.');
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'identity_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên khách hàng.',
            'email.email' => 'Email không đúng định dạng.',
        ]);

        $customer->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'identity_number' => $request->identity_number,
            'address' => $request->address,
        ]);

        return redirect()->route('customers.index')->with('success', 'Cập nhật khách hàng thành công.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Xóa khách hàng thành công.');
    }
}