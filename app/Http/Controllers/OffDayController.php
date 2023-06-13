<?php

namespace App\Http\Controllers;

use App\Models\OffDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OffDayController extends Controller
{
    public function index(){
        $off_days = OffDay::all();
        return view('off-days.index', compact('off_days'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => $request->pick_range ? 'required|date|after:start_date' : 'nullable|date',
    ]);

    $off_days = new OffDay();

        if($off_days) {

            if($request->pick_range) {
                $off_days->end_date = $request->end_date;
            } else {
                $off_days->end_date = $request->start_date;
            }

            $off_days->start_date = $request->start_date;
            $off_days->save();

            if($off_days) {

                if($request->pick_range) {
                    $off_days->end_date = $request->end_date;
                } else {
                    $off_days->end_date = $request->start_date;
                }

                $off_days = new OffDay();

                if($off_days) {
                    $off_days->start_date = $request->start_date;
                    $off_days->end_date = $request->end_date;
                    $off_days->save();

                    return redirect()->back()->withInput()->with('success', 'Off day added successfully');
                }
            }

            return redirect()->back()->withInput()->with('error', 'Something went wrong');
        }
    }


    public function create()
    {
        return view('off-days.form');
    }

    public function destroy($id)
    {
        $off_days = OffDay::find($id);

        if ($off_days){
            $off_days->delete();

            return redirect()->back()->withInput()->with('success', 'Off Day deleted successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

}
