<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $user  = auth()->user();
       if($user){
            $orders = $user->orders;

            if ($orders->isEmpty()) {
                $this->info('No orders found for the user.');
                return;
            }

            $cart_items = $orders->products;

        }

    }
}
