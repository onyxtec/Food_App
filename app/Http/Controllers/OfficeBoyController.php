<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficeBoyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::role('Office Boy')->get();
        return view('officeBoys.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('officeBoys.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);

        $user = new User;
        $user->name =  $request->name;
        $user->email =  $request->email;
        $user->password =  Hash::make($request->password);
        $user->assignRole('Office Boy');
        $user->save();
        return redirect()->route('officeBoy.index')->with('success', 'Office boy created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user){
            return view('officeBoys.form', compact('user'));
        }
        return redirect()->back()->with('error', 'OfficeBoy not found!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = User::find($id);
        if($user){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return redirect()->route('officeBoy.index')->with('success', 'OfficeBoy updated successfully.');
        }
        return redirect()->route('officeBoy.index')->with('error', 'OfficeBoy not found!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Office Boy deleted successfully.');
        }
        return redirect()->back()->with('error', 'Office Boy not found.');
    }
}
