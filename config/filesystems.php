<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

        // Google cloud storage
        'gcs' => [
            'driver' => 'gcs',
            'project_id' => env('GCS_PROJECT_ID', 'your-project-id'),
            // 'key_file_path' => storage_path(env('GOOGLE_CLOUD_KEY_FILE')),  //storage_path('app/gcs/service-account.json'), // path to key file     storage_path(env('GCS_KEY_FILE')), //
            // 'key_file_path' => env('GOOGLE_CLOUD_KEY_FILE', null), // optional: /path/to/service-account.json
            'key_file_path' => env('GOOGLE_CLOUD_KEY_FILE') ? storage_path(env('GOOGLE_CLOUD_KEY_FILE')) : null,
            'bucket' => env('GCS_BUCKET', 'your-bucket-name'), // my-laravel-gcs-bucket
            'path_prefix' => env('GCS_PATH_PREFIX', null), // optional
            // 'storage_api_uri' => env('GCS_STORAGE_API_URI', null), // optional
            'visibility' => 'public', // or 'private'
            // 'visibility_handler' is MEGA FIX, was not uploading images to Google Cloud Storage without giving any error
            'visibility_handler' => \League\Flysystem\GoogleCloudStorage\UniformBucketLevelAccessVisibility::class, // was null  //to enable uniform bucket level access

        ],
        // End Google cloud storage

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
