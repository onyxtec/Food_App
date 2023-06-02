<?php

namespace App\Console\Commands;

use App\Mail\OrderReport;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeeklyOrderReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly report to employees to tell them about their orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */

     public function __construct()
     {
       parent::__construct();
     }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $users = User::with('orders.products')->get();
        $employees = User::role('Employee')->get();
        if($employees){
            foreach ($employees as $employee){
                $orders = $employee->orders;
                if($orders && $employee->email === 'ali@onyxtec.co'){
                    Mail::to($employee->email)->send(new OrderReport($orders));
                    $this->info('Command completed successfully');
                }
            }

        }
        $this->info('Command not completed');


    }
}
