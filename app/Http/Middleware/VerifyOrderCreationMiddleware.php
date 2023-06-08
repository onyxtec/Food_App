<?php

namespace App\Http\Middleware;

use App\Models\OffDay;
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
        // $current_date_time = Carbon::now();
        $current_date_time = Carbon::parse('2023-06-16');
        // $current_date = $current_date_time->format('Y-m-d');
        $off_days = OffDay::all();

        foreach ($off_days as $off_day) {
            // $start_date = Carbon::parse($off_day->start_date)->format('Y-m-d');
            // $end_date = Carbon::parse($off_day->end_date)->format('Y-m-d');
            $start_date = Carbon::parse($off_day->start_date);
            $end_date = Carbon::parse($off_day->end_date);

            if ($current_date_time->between($start_date, $end_date)) {

                // if (Auth::check()) {
                //     Auth::logout();
                // }
                // return redirect()->route('login')->with('error', 'Order creation is not allowed on off days.');

                return redirect()->route('home')->with('error', 'Order creation is not allowed on off days.');
            }
        }

        return $next($request);
    }
}
