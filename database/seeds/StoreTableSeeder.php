<?php

use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pegar stores
        $stores = \App\Store::all();

        // percorrer stores
        foreach ($stores as $store) {
            // salvar produto faker fabricado correspondente para cada store
            $store->products()->save(factory(\App\Product::class)->make());
        }
    }
}
