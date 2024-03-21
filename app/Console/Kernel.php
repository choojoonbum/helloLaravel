<?php

namespace App\Console;

use App\Http\Middleware\Locale;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SendEmails::class
    ];

    protected $middlewareGroups = [
        'web' => [
            Locale::class
        ]
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('mail:send --queue=emails')
            ->weeklyOn(Schedule::MONDAY, '8:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
