<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $i = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$i++;
        }

        return $slug.'-'.Str::random(5);
    }

    public function definition()
    {
        // $name = $this->faker->unique()->words(3, true);
        $brands = ['Pioneer DJ', 'Denon DJ', 'Numark', 'Native Instruments', 'Rane', 'Allen & Heath', 'Gemini', 'Roland', 'Hercules', 'Vestax', 'AKAI Professional', 'Behringer', 'Korg', 'Technics', 'Novation', 'Mackie', 'Audio-Technica', 'Soundcraft', 'Serato', 'DJ Tech'];
        $brandName = fake()->unique($reset = true)->randomElement($brands);

        return [
            'name' => $brandName, // $name,
            'slug' => $this->generateUniqueSlug($brandName), // Str::slug($productBrand),
            'description' => $this->faker->sentence(15),
            'sku' => strtoupper($this->faker->bothify('SKU-####??')),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'discount_price' => $this->faker->optional()->randomFloat(2, 1, 400),
            'stock' => $this->faker->numberBetween(0, 100),
            // 'category_id' => Category::factory(), // Uncomment if you have Category factory

            // image' => "https://picsum.photos/id/" .fake()->unique()->numberBetween(1, 10000) . "/200/150",
            'image' => 'https://picsum.photos/200/150?random='.fake()->unique()->numberBetween(1, 10000),  // works, but generate new image on F5// width/height 200/150
            // 'image' => json_decode(file_get_contents('https://randomuser.me/api/'), true)['results'][0]['picture']['large'], //works
            // 'image' => 'https://source.unsplash.com/400x300/?people&sig=' . fake()->unique()->numberBetween(1, 10000),
            // 'image' => 'https://loremflickr.com/400/300/people?random=' . fake()->randomNumber(5, true),

            // 'image' => $this->faker->imageUrl(640, 480, 'products', true), //not working
            'gallery' => json_encode([
                $this->faker->imageUrl(640, 480, 'products', true),
                $this->faker->imageUrl(640, 480, 'products', true),
            ]),
            'is_active' => $this->faker->boolean(100), // The chance of true is 100%.
            'views' => $this->faker->numberBetween(0, 1000),
            'details' => json_encode([
                'color' => $this->faker->colorName(),
                'material' => $this->faker->word(),
                'warranty' => $this->faker->numberBetween(1, 5).' years',
            ]),
        ];
    }
}
