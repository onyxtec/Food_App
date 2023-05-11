<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            foreach($validator->errors()->messages() as $image_errors){
                return session()->flash('error', $image_errors[0]);
            }
        }

        $user = auth()->user();

        if($user->image !== null){
            $imagePath = $user->image;
            $imagePath = explode('storage/', $imagePath);
            $imagePath = $imagePath[1];

            if ($imagePath && Storage::disk('local')->exists('public/' . $imagePath)) {
                Storage::disk('local')->delete('public/' . $imagePath);
            }
        }

        if ($request->hasFile('image')) {
            $destination_path = 'public/images/profile';
            $image = $request->file('image');
            $image_name = uniqid() . '_' . $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destination_path, $image_name);
            $url = Storage::url($path);
            $user->image = $url;
            $user->save();

            return $request->session()->flash('success', 'Profile image updated successfully.');
        }

        return $request->session()->flash('error', 'Something went wrong. Please try again.');
    }

    public function removeProfileImage(){
        $user = auth()->user();

        if($user->image!== null){
            $imagePath = $user->image;
            $imagePath = explode('storage/', $imagePath);
            $imagePath = $imagePath[1];

            if ($imagePath && Storage::disk('local')->exists('public/' . $imagePath)) {
                Storage::disk('local')->delete('public/' . $imagePath);
            }
        }

        $user->image = null;
        $user->save();

        return session()->flash('success', 'Image removed successfully');
    }

    public function updateName(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
        ]);

        $user = auth()->user();
        $user->name = $request->input('name');
        $user->save();

        return redirect()->back()->with('success', 'Name updated successfully');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:password|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->withErrors(['password' => 'The old password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->input('new_password'))
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
