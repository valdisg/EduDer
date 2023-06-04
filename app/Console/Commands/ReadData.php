<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SchoolService;

class ReadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:read-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reads data from an API to write to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $schoolService = new SchoolService();
        $data = $schoolService->execute();
        $this->info(var_dump($data));
    }
}
