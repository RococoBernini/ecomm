<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Shop;
class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$shop = Shop::factory(1)->create(['user_id'=>2]);
		$shop = Shop::factory(1)->create(['user_id'=>3]);
        //
    }
}
