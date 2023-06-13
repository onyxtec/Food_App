<?php

namespace App\Http\Middleware;

use App\Models\OffDay;
use App\Models\TimeSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckOffTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current_date_time = Carbon::now();
        $off_days = OffDay::where('start_date', '<=', $current_date_time)
        ->where('end_date', '>=', $current_date_time)
        ->get();

        if ($off_days->count() > 0) {
            return redirect()->route('home')->with('error', 'You cannot order during off days.');
        }

        $time_settings = TimeSetting::first();

        if ($time_settings) {
            $order_start_time = Carbon::parse($time_settings->order_start_time);
            $order_end_time = Carbon::parse($time_settings->order_end_time);

            if (!$current_date_time->between($order_start_time, $order_end_time)) {
                return redirect()->route('home')->with('error', 'You cannot order during off hours.');
            }
        }

        return $next($request);
    }
}
