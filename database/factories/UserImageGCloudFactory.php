<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserImageGCloud;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'path' => "https://storage.googleapis.com/{$bucket}/images/".$this->faker->uuid.'.jpg',
        ];
    }
}
