<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCategory("category-1");
        $this->createCategory("category-2");
        $this->createCategory("category-3");
    }

    function createCategory($name)
    {
        $category = new Category();
        $category->name = $name;
        $category->save();
    }
}
