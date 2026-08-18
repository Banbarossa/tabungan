<?php

namespace Database\Seeders;

use App\Models\MetaSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetaSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data=[
            ['name'=>'nomor_rekening_jajan','value'=>'3006699012'],
            ['name'=>'nama_rekening_jajan','value'=>'PESANTREN IMAM SYAFII'],
            ['name'=>'nama_bank_jajan','value'=>'BSI'],
            ['name'=>'hp_konfirmasi_jajan','value'=>'082163904438'],
        ];
        foreach($data as $item){
            MetaSetting::create($item);
        }
    }
}
