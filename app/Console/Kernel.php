<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * 注册 Artisan 命令。
     *
     * @var array
     */
    protected $commands = [
        // 在这里注册自定义命令
    ];

    /**
     * 定义计划任务。
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 示例：每小时执行一次 inspire 命令
        // $schedule->command('inspire')->hourly();
    }

    /**
     * 注册 Artisan 的控制台命令。
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
