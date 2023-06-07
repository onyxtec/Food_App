<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeeklyOrderReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        $employees = User::role('Employee')->get();

        if($employees){
            foreach ($employees as $employee){

                $employee->notify(new WeeklyOrderReportMail($employee));
            }
        }
        Log::info('weekly order report sent successfully');
    }
}
