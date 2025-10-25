<?php

namespace Database\Factories;

use App\Models\UserImageGCloud;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserImageGCloudFactory extends Factory
{
   protected $model = UserImageGCloud::class;

    public function definition(): array
    {
        $bucket = config('filesystems.disks.gcs.bucket', 'my-laravel-gcs-bucket');

        return [
            'user_id' => User::factory(),
            'path' => "https://storage.googleapis.com/{$bucket}/images/" . $this->faker->uuid . '.jpg',
        ];
    }
}