<?php

use App\Business_unit;
use Illuminate\Database\Seeder;

class BusinessUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business_unit::create([
            'name' => 'The Boba Time Indonesia',
            'business_type' => 'Food & Beverages',
            'company_id' => 1
        ]);

        Business_unit::create([
            'name' => 'Telor Gulung Ciamik',
            'business_type' => 'Food & Beverages',
            'company_id' => 1
        ]);

        Business_unit::create([
            'name' => 'Jasa Web Developers',
            'business_type' => 'Technology',
            'company_id' => 2
        ]);

        Business_unit::create([
            'name' => 'Jasa Pembuatan Aplikasi',
            'business_type' => 'Technology',
            'company_id' => 2
        ]);
    }
}
