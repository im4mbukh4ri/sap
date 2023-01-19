<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\AirlinesStatus::class,
        Commands\PulsaStatus::class,
        Commands\AutodebitPayment::class,
        Commands\PlnPraStatus::class,
        Commands\PlnPascaStatus::class,
        Commands\VoucherStatus::class,
        Commands\RefreshUniqueCode::class,
        Commands\AirlinesTimelimit::class,
        Commands\UserUnverifiedDepositLimit::class,
        Commands\UserVerifiedDepositLimit::class,
        Commands\PulsaReplication::class,
        Commands\PlnPrabayarReplication::class,
        Commands\PlnPascabayarReplication::class,
        Commands\TelephoneReplication::class,
        Commands\PdamReplication::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
//        $schedule->command('cron:airlines_status')->everyMinute();
//        $schedule->command('cron:airlines_timelimit')->everyFiveMinutes();
        $schedule->command('cron:autodebit_payment')->dailyAt('02:00');
        // $schedule->command('cron:autodebit_payment')->everyMinute();
        $schedule->command('cron:pulsa_replication')->everyMinute();
        $schedule->command('cron:pln_prabayar_replication')->everyMinute();
        $schedule->command('cron:pdam_replication')->everyMinute();
        // $schedule->command('cron:pln_pascabayar_replication')->everyMinute();
        // $schedule->command('cron:telephone_replication')->everyMinute();
        $schedule->command('cron:pulsa_status')->everyMinute();
        $schedule->command('cron:pln_pra_status')->everyFiveMinutes();
        $schedule->command('cron:pln_pasca_status')->everyFiveMinutes();
        $schedule->command('cron:voucher_status')->everyFiveMinutes();
        $schedule->command('cron:refresh_unique_code')->dailyAt('00:01');
        $schedule->command('cron:user_verified_deposit_debit')->dailyAt('23:55');
        $schedule->command('cron:user_unverified_deposit_debit')->dailyAt('23:57');
    }
}
