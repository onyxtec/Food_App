<?php

namespace App\Http\Middleware;

use App\Models\OffDay;
use App\Models\TimeSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifyOrderCreationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current_date_time = Carbon::now();
        $off_days = OffDay::all();

        foreach ($off_days as $off_day) {
            // $start_date = Carbon::parse($off_day->start_date)->format('Y-m-d');
            // $end_date = Carbon::parse($off_day->end_date)->format('Y-m-d');
            $start_date = Carbon::parse($off_day->start_date);
            $end_date = Carbon::parse($off_day->end_date);

            if ($current_date_time->between($start_date, $end_date)) {

                return redirect()->route('home')->with('error', 'Order creation is not allowed on off days.');
            }
        }

        $time_settings = TimeSetting::first();

        if ($time_settings) {
            $order_start_time = Carbon::parse($time_settings->order_start_time);
            $order_end_time = Carbon::parse($time_settings->order_end_time);

            if (!$current_date_time->between($order_start_time, $order_end_time)) {
                return redirect()->route('home')->with('error', 'Order creation is not allowed during off hours.');
            }
        }

        return $next($request);
    }
}
