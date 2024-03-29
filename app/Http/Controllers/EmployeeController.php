<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;


class EmployeeController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return view('employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|numeric',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if(!empty($request->avatar)){
            $imageName = time().'.'.$request->avatar->extension();  
            $request->avatar->move(public_path('images'), $imageName);
        }
        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $imageName
        ]);

        return redirect('/employees')->with('completed', 'Employee created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.update', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|numeric',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if(!empty($request->avatar)){
            $imageName = time().'.'.$request->avatar->extension();  
            $request->avatar->move(public_path('images'), $imageName);
        }
        Employee::whereId($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $imageName
        ]);
        
        return redirect('/employees')->with('completed', 'Employee updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect('/employees')->with('completed', 'Employee deleted');
    }   
}