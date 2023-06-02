<?php

namespace App\Http\Controllers;

use App\Mail\OrderTimingsUpdated;
use App\Models\TimeSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TimeSettingController extends Controller
{
    public function index(){
        $time_setting = TimeSetting::first();
        return view('time-settings.edit', compact('time_setting'));
    }

    public function update(Request $request){

        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
        ],[
            'start_time.required' => 'The start time field is required.',
            'start_time.date_format' => 'Invalid start time format.',
            'end_time.required' => 'The end time field is required.',
            'end_time.date_format' => 'Invalid end time format.',
            'end_time.after' => 'The end time must be greater than the start time.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $time_setting = TimeSetting::first();

        if($time_setting){
            $time_setting->order_start_time = $request->start_time;
            $time_setting->order_end_time = $request->end_time;
            $time_setting->save();

            $employees = User::role('Employee')->get();
            foreach ($employees as $employee) {
                Mail::to($employee->email)->send(new OrderTimingsUpdated($time_setting));
            }
            return redirect()->back()->withInput()->with('success', 'Time has been updated successfully');
        }
    }
}
