<?php

namespace App\Http\Controllers;

use App\Mail\NewTimingsNotification;
use App\Models\TimeSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(){
        $time_settings = TimeSetting::first();
        $order_start_time = $time_settings->order_start_time;
        $order_end_time = $time_settings->order_end_time;

        return view('time-settings.edit-time-settings', compact('order_start_time','order_end_time'));
    }

    public function updateTimeSettings(Request $request){

        $validator = Validator::make($request->all(), [
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s',
        ],[
            'start_time.required' => 'The start time field is required.',
            'start_time.date_format' => 'Invalid start time format.',
            'end_time.required' => 'The end time field is required.',
            'end_time.date_format' => 'Invalid end time format.',
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
                Mail::to($employee->email)->send(new NewTimingsNotification($time_setting));
                sleep(1); //testing purpose
            }
            return redirect()->back()->withInput()->with('success', 'Time has been updated successfully');
        }
    }
}
