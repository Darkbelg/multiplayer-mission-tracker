<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Storage;

class Findmissionname extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'findmission
                            {name : The name of the log file (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Find all names of mission played.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $search = "SOG co@ 45 We was out walking like always v02";
        $filename = 'storage/ZA3_No3VN_7216.log';
        echo "executing: ";
      //  $handle = file($filename,"r");
        $contents = file($filename);
    //    fclose($handle);
//        var_dump($contents);
        foreach ($contents as $key => $line){
            if (str_contains($line, "Game finished.")){
                echo explode("\"",$contents[$key +3])[1];
            }
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
