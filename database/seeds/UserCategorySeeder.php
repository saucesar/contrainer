<?php

use App\Models\UserCategory;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserCategory::class, 10)->create();
    }
}
