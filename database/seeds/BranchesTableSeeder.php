<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'name' => 'Cabang Tangerang',
            'address' => 'Jl. Galunggung Raya No. 2 Tangerang',
            'business_unit_id' => 1
        ]);

        Branch::create([
            'name' => 'Cabang Jakarta 1',
            'address' => 'Jl. Kramat Jati No. 10',
            'business_unit_id' => 1
        ]);

        Branch::create([
            'name' => 'Cabang Jakarta 2',
            'address' => 'Jl. Kemayoran Raya No. 3',
            'business_unit_id' => 1
        ]);

        Branch::create([
            'name' => 'Cabang Tangerang',
            'address' => 'jl. Beo II No. 10, Pasar Kemis, Tangerang',
            'business_unit_id' => 2
        ]);

        Branch::create([
            'name' => 'Cabang Bekasi',
            'address' => 'Jl. Proyek Bekasi Timur No. 5, Bekasi',
            'business_unit_id' => 2
        ]);

        Branch::create([
            'name' => 'Headquarter',
            'address' => 'Blok Selasa Desa Cibentar Kec Jatiwangi Kab. Majalengka, 45454',
            'business_unit_id' => 3
        ]);

        Branch::create([
            'name' => 'headquarter',
            'address' => 'Blok Selasa Desa Cibentar Kec Jatiwangi Kab. Majalengka, 45454',
            'business_unit_id' => 4
        ]);
    }
}
