<?php

use Illuminate\Database\Seeder;

class ChangeHotelAsset extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotels = \App\Hotel::all();
        foreach ($hotels as $hotel) {
            if ($hotel->url_image !== null) {
                $explodeAssets = explode('/', $hotel->url_image);
                $hotel->url_image = 'https://hotel.mysmartinpays.com/HotelImage/' . $explodeAssets[5] . '/' . $explodeAssets[6] . '/' . $explodeAssets[7];
                $hotel->save();
            } else {
                $hotel->url_image = 'https://hotel.mysmartinpays.com/storage/images/default-hotel/5q7VBhqDG1Kn9ZwX6fqGDrGQeDW7BtQNyLjHKLKs.jpeg';
                $hotel->save();
            }
        }
    }
}
