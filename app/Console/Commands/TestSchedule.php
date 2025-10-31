<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class TestSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test the schedule for user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();
        Log::info('hello ' . $user->name);
    }
}
