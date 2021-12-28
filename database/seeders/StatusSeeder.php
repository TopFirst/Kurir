<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuss = [
            'Proses',
            'Selesai',
            'Cancel'            
         ];
         foreach ($statuss as $status) {
            Status::create(['name' => $status]);
       }
    }
}
