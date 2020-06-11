<?php

use App\Helpers\ImageUploader;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = App\Category::all();
        $imageUploader = new ImageUploader();
            factory(App\Business::class, 10)->create()->each(function ($business) use ($country, $imageUploader) {
                $business->categories()->save($country->random());
                $upload = $imageUploader->upload($imageUploader::DEFAULT_IMAGE, $business->business_name);
                $business->image()->create(['image' => $upload[1]]);
            });

    }
}
