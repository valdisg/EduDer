<?php

namespace App\Console\Commands;

use App\Models\Criteria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WriteCriteriaGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:write-criteria-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function addSubCriteria(array $ids, string $code, string $name, string $image){
        $criteria = Criteria::where('code', $code)->first();
        if ($criteria === null) {
            $criteria = new Criteria();
        }
        $criteria->code = $code;
        $criteria->name = $name;
        $criteria->overname = "Izglītības Ieguves Veidi";
        $criteria->type = "Izglības programma";
        $criteria->image = $image;
        $criteria->save();
        $criteria->children()->attach($ids);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $codes = ["AS", "AT", "AK", "AV", "AC", "0", "1", "2", "3", "4", "5", "6", "7", "8"];
        $names = ["Sports", "Tehniskā jaunrade", "Kultūra", "Vides interešu izglītība", "Citas intereses", "Vispārizglītojošā izglītība", "Izglītība", "Humanitārās zinātnes un māksla", "Sociālās zinātnes, komerczinības un tiesības", "Dabaszinātnes, matemātika un informācijas tehnoloģijas", "Inženierzinātnes, ražošana un būvniecība", "Lauksaimniecība", "Veselības aprūpe un sociālā labklājība", "Pakalpojumi"];
        $images = [
            "https://tv3cdn.lv/2023/05/ebd3-646fb8809ecf9-scaled.jpg",
            "https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/Falcon_Heavy_Demo_Mission_%2839337245145%29.jpg/1024px-Falcon_Heavy_Demo_Mission_%2839337245145%29.jpg",
            "https://images.csmonitor.com/csm/2014/06/opera.jpg?alias=standard_900x600nc",
            "https://www.artandobject.com/sites/default/files/styles/gallery_item/public/still-indiana-jones-and-raiders-lost-ark-official-trailer-paramount-movies_0.jpg?h=00267acb&itok=geb4B574",
            "https://img.freepik.com/premium-vector/various-hobbies-icons-selection-white-background-vector_532963-598.jpg?w=2000",
            "https://cdn.liepajniekiem.lv/lv/thumbnails/2000x2000x1/2021/01/1f85-6008165dbf1f7-scaled.jpg",
            "https://izglitiba.saldus.lv/wp-content/uploads/sites/4/2019/08/izglitiba.jpg",
            "http://vilaka.lv/wp-content/uploads/2021/05/IMG-20200725-WA0010.jpg",
            "https://www.plz.lv/wp-content/uploads/2021/08/tiesvediba-scaled.jpg",
            "https://www.jelgavasnovads.lv/sites/jelgavasnovads/files/styles/node_image_large/public/gallery_images/8507d0379b356ca386ae49dcfab80d9a.jpg?itok=nQQXbYkW",
            "https://img.building.lv/articles/open/1/5/media/users/article/galleries/150/423/15042333.jpg_15042333_860x566.jpg",
            "https://www.aprinkis.lv/media/k2/items/cache/3005cd269ae5db6f648e0e7072617f30_L.jpg",
            "https://www.retv.lv/media/29320/dakteris_freepik.jpg",
            "http://davv.lv/wp-content/uploads/2022/04/DSC_0670-1-2048x1362.jpg"
        ];
        $index = 0;
        while ($index < 14) {
            if ($index < 5) {
                $criteria = DB::select("SELECT id, code FROM criterias WHERE code LIKE '".$codes[$index]."%'");
            } else {
                $criteria = DB::select("SELECT id, code FROM criterias WHERE code LIKE '31".$codes[$index]."%' OR code LIKE '32".$codes[$index]."%' OR code LIKE '33".$codes[$index]."%'");
            }
            $ids = array_column($criteria, 'id');
            $this->addSubCriteria($ids, $codes[$index], $names[$index], $images[$index]);
            $index += 1;
        }

    }
}
