<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'PT. Arah Melangkah Didepan',
            'address' => 'Jl. Galunggung Raya No. 2 Tangerang',
        ]);

        Company::create([
            'name' => 'PT. Fiernes Technology',
            'address' => 'Blok Selasa Desa Cibentar Kec. Jatiwangi Kab. Majalengka, Jawa Barat, 45454',
        ]);
    }
}
