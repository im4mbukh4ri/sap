<?php

use Illuminate\Database\Seeder;

class AirportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//         $path_airport = storage_path() . "/json/all_airports.json";
//         if (!File::exists($path_airport)) {
//             throw new Exception("Invalid File");
//         }
//         $file_airport = File::get($path_airport);
//         $airports_decode = json_decode($file_airport,true);
//         $airports=$airports_decode['airport'];
//
//         foreach ($airports as $airport){
// //            \App\Airport::create([
// //                'id'=>$airport['iata'],
// //                'name'=>$airport['bdrp'],
// //                'city'=>$airport['city']
// //            ]);
//             $port=\App\Airport::find($airport['iata']);
//             if($port){
//                 $port->name=$airport['bdrp'];
//                 $port->international=(int)$airport['port'];
//                 $port->city=$airport['city'];
//                 $port->save();
//             }else{
//                 \App\Airport::create([
//                 'id'=>$airport['iata'],
//                 'name'=>$airport['bdrp'],
//                 'city'=>$airport['city'],
//                 'international'=>(int)$airport['port']
//             ]);
//             }
//         }
          $airports=\App\Airport::all();
          foreach ($airports as $key => $airport) {
            $portExplode = explode(',',$airport->city);
            $count=count($portExplode);
            if($count==1){
              $airport->city=trim($portExplode[0]);
              $airport->country="Indonesia";
              $airport->save();
            }elseif($count==2){
              $airport->city=trim($portExplode[0]);
              $airport->country=trim($portExplode[1]);
              $airport->save();
            }else{
              $city="";
              for($i=1;$i<$count;$i++){
                if($i==1){
                  $city.=trim($portExplode[$i-1]);
                }else{
                  $city.=", ".trim($portExplode[$i-1]);
                }
              }
              $airport->city=$city;
              $airport->country=trim($portExplode[$count-1]);
              $airport->save();
            }
          }

    }
}
