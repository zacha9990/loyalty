<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Point;

class PointExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:point-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Point::expirePoints();
    }
}
