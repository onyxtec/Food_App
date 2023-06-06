<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class setWeekendOffDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offdays:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the current week saturday and sunday as off day';


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

    }
}
