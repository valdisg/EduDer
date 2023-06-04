<?php

namespace App\Console\Commands;

use App\Models\Criteria;
use App\Models\School;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SchoolCollection;

class ShowData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-data';

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

//        $criteria = new Criteria();
//        $criteria->code = '1';
//        $criteria->image = 'http://fakeur.lv';
//        $criteria->save();
//        $criteria->school()->attach([237]);

        print_r(json_encode(new SchoolCollection(School::all())));
    }
}
