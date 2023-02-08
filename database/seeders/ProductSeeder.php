<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createProduct("product-1", "insert an image", 230, "description-1...", 1);
        $this->createProduct("product-2", "insert an image", 120, "description-2...", 1);
        $this->createProduct("product-3", "insert an image", 400, "description-3...", 2);
        $this->createProduct("product-4", "insert an image", 860, "description-4...", 2);
        $this->createProduct("product-5", "insert an image", 940, "description-5...", 3);
        $this->createProduct("product-6", "insert an image", 113, "description-6...", 1);
    }

    function createProduct($name, $image, $price, $description, $category_id)
    {
        $product = new Product;
        $product->name = $name;
        $product->image = $image;
        $product->price = $price;
        $product->description = $description;
        $product->category_id = $category_id;
        $product->save();
    }
}
