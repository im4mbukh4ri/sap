<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Hotel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $path_hotel_domestik = storage_path() . "/json/hotel_domestik.json";
      $path_hotel_international = storage_path() . "/json/hotel_international.json";
      if (!File::exists($path_hotel_domestik)) {
          throw new Exception("Invalid File");
      }
      if (!File::exists($path_hotel_international)) {
          throw new Exception("Invalid File");
      }
      $file_hotel_domestik = File::get($path_hotel_domestik);
      $hotel_domestik_decode = json_decode($file_hotel_domestik,true);
      $hotels=$hotel_domestik_decode;
      $file_hotel_international = File::get($path_hotel_international);
      $hotel_international_decode = json_decode($file_hotel_international,true);
      $internationals=$hotel_international_decode;
      foreach ($hotels as $hotel){
              \App\HotelCity::create([
              'id'=>$hotel['code'],
              'city'=>$hotel['city'],
              'international'=>0,
              'country'=>$hotel['country']
            ]);
      }
      foreach ($internationals as $hotel){
          $ext=\App\HotelCity::find($hotel['code']);
          if($ext){
              Log::info("Double code international and domestik. Code : ".$hotel['code']);
          }else{
              \App\HotelCity::create([
              'id'=>$hotel['code'],
              'city'=>$hotel['city'],
              'international'=>1,
              'country'=>$hotel['country']
          ]);
          }
      }
    }
}
