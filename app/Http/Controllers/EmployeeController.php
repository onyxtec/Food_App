<?php

namespace App\Http\Controllers;

use App\Models\BalanceHistory;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $users = User::role('Employee')->get();
        return view('employee-listing', compact('users'));

    }

    public function updateBalance(Request $request, $id){
        $request->validate([
            'add_balance' => 'nullable|numeric|min:0|required_without:sub_balance',
            'sub_balance' => 'nullable|numeric|min:0',
        ]);

        $user = User::find($id);
        if($user){
            if($request->add_balance){
                $user->balance += $request->add_balance;
                $user->save();
                $this->balanceHistory($request->add_balance, null, $user->balance, $id);
                return redirect()->route('employee.index')->with('success', 'User balance added successfully');
            }

            if($request->sub_balance){
                if($user->balance < $request->sub_balance){
                    return redirect()->route('employee.index')->with('error', 'User\'s balance is less than the deducted amount.');
                }

                $user->balance -= $request->sub_balance;
                $user->save();
                $this->balanceHistory(null, $request->sub_balance, $user->balance, $id);

                return redirect()->route('employee.index')->with('success', 'User balance deducted successfully');
            }

            return redirect()->route('employee.index')->with('error', 'Balance must either be added or deducted');
        }

        return redirect()->route('employee.index')->with('error', 'User not found!');
    }

    private function balanceHistory($amount_added = null, $amount_deducted = null, $updated_balance, $user_id) {
        $balance_history = new BalanceHistory();
        if ($amount_added) {
            $balance_history->amount_added = $amount_added;
        }

        if($amount_deducted){
            $balance_history->amount_deducted = $amount_deducted;
        }
        $balance_history->updated_balance = $updated_balance;
        $balance_history->user_id = $user_id;
        $balance_history->save();
    }
}
