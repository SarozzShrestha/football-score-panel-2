<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::whereNull('deleted_at')->orderBy('name', 'ASC')->get();
        return view('staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        Staff::create([
            'name' => $request->name,
            'role' => $request->role,
            'image' => $request->image,
            'status' => isset($request->status) ? '1' : '0',
        ]);

        return redirect()->route('admin.staffs.index')->with('success', 'New Staff added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return response()->json($staff->toJson());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('staffs.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $request->merge(['status' => (string)(int)$request->has('status')]);

        $staff->update($request->all());

        return redirect()->route('admin.staffs.index')->with('success', 'Staff information updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->back()->with('success', 'Staff Deleted.');
    }
}
