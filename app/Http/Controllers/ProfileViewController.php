<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile-view');
    }

    public function update(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('image')) {

            $destination_path = 'public/images/profile';

            $image = $request->file('image');

            $image_name = uniqid() . '_' . $image->getClientOriginalName();

            $path = $request->file('image')->storeAs($destination_path, $image_name);

            $url = Storage::url($path);

            $user = Auth::user();

            $user->image = $url;

            $user->save();

            return response()->json(['success' => true, 'image' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'Image not uploaded']);
    }

    public function remove(){

        $user = Auth::user();

        $user->image = null;

        $user->save();

        return response()->json(['success' => true]);
    }

    public function updateName(Request $request, $id){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::find($id);

        $user->name = $validatedData['name'];

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function updatePassword(Request $request){

        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8|different:password|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'The old password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->input('new_password'))
        ]);

        return redirect()->route('home')->with('success', 'Password updated successfully.');

    }
}
