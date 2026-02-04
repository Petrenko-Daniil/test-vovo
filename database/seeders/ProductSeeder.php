<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Electronics' => [
                'iPhone 15',
                'Samsung Galaxy S24',
                'MacBook Pro M3',
                'Sony WH-1000XM5',
                'iPad Air',
            ],
            'Clothing' => [
                'Nike Air Max',
                'Adidas Hoodie',
                'Levi’s 501 Jeans',
                'Polo T-Shirt',
                'North Face Jacket',
            ],
            'Books' => [
                'Clean Code',
                'The Pragmatic Programmer',
                'Design Patterns',
                'Refactoring',
                'Domain-Driven Design',
            ],
            'Furniture' => [
                'Ikea Desk',
                'Office Chair Pro',
                'Wooden Dining Table',
                'Modern Sofa',
                'Bookshelf Classic',
            ],
            'Toys' => [
                'Lego Star Wars',
                'Hot Wheels Set',
                'Barbie Dreamhouse',
                'RC Car',
                'Puzzle 1000 Pieces',
            ],
            'Sports' => [
                'Football Ball',
                'Tennis Racket',
                'Basketball Hoop',
                'Yoga Mat',
                'Dumbbell Set',
            ],
        ];

        foreach ($data as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($products as $productName) {
                Product::updateOrCreate(
                    [
                        'name' => $productName,
                        'category_id' => $category->id,
                    ],
                    [
                        'price' => fake()->randomFloat(2, 10, 2000),
                        'in_stock' => fake()->boolean(),
                        'rating' => fake()->randomFloat(1, 1, 5),
                    ]
                );
            }
        }
    }
}
