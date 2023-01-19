<?php

use Illuminate\Database\Seeder;

class AirlinesCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\AirlinesCode::create([
            'code'=>'QZ',
            'name'=>'AirAsia',
            'icon'=>'airasia.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'QG',
            'name'=>'Citilink',
            'icon'=>'citilink.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'GA',
            'name'=>'Garuda Indonesia',
            'icon'=>'garudaindonesia.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'KD',
            'name'=>'Kalstar Aviation',
            'icon'=>'kalstar.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'JT',
            'name'=>'Lion Group (Lion Air, Batik Air, Wings Air)',
            'icon'=>'liongroup.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'SJ',
            'name'=>'Sriwijaya Air',
            'icon'=>'sriwijaya.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'MV',
            'name'=>'Transnusa',
            'icon'=>'transnusa.png'
        ]);
        \App\AirlinesCode::create([
            'code'=>'IL',
            'name'=>'Trigana Air',
            'icon'=>'trigana.png'
        ]);
    }
}
