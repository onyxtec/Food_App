<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AmountTopUpController extends Controller
{
    public function index()
    {
        $users = User::role('Employee')->get();
        return view('employee-listing', compact('users'));

    }

    public function update(Request $request, $id){
        $request->validate([
            'add_balance' => 'nullable|numeric|min:0',
            'sub_balance' => 'nullable|numeric|min:0',
        ]);

        $user = User::find($id);
        if($user){
            if($request->add_balance){
                $user->balance += $request->add_balance;
                $user->save();

                return redirect()->route('amount-top-up.index')->with('success', 'User balance added successfully');
            }

            if($request->sub_balance){
                if($user->balance < $request->sub_balance){
                    return redirect()->route('amount-top-up.index')->with('error', 'User\'s balance is less than deducted amount.');
                }

                $user->balance -= $request->sub_balance;
                $user->save();

                return redirect()->route('amount-top-up.index')->with('success', 'User balance deducted successfully');
            }

            return redirect()->route('amount-top-up.index')->with('error', 'Balance can be either added or deducted');
        }

        return redirect()->route('amount-top-up.index')->with('error', 'User not founded!');
    }
}
