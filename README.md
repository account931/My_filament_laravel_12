
> Laravel 12.18, PHP 8.4.8 , Filament  mysql 5.6, db: '',
Visual Studio Code ()
     -> VS package extension -> 
           -> PHP Namespace Resolver (to import class -> RMC -> import class)(https://marketplace.visualstudio.com/items?itemName=MehediDracula.php-namespace-resolver)
           -> Git History, GitLense, Php Intellisense, Prittier, Highlight Matching Tag, GitLens — Git supercharged, Notepad VS theme





main page =>  http://localhost:8000/     (u screwed ports with phpmyadmin)





### Content
- [1. Install Laravel 12](#1-install-laravel-12)
- [2. Docker sail](#2-docker-sail)
- [3. Filament3](#3-filament3)


- [103. Screenshots](#2-screenshots)







<p> ----------------------------------------------------------------------------------------- </p>

## 1. Install Laravel 12

<p>1. Install => <code> composer create-project --prefer-dist laravel/laravel my-app "^12.0"  </code> </p>
<p>2. Install dependencies => <code> composer install </code> </p>
<p>3. Generates the APP_KEY and writes it to .env => <code> php artisan key:generate </code> </p>

<p>4. In browser can navigate to http://localhost:8000/  => the project should open </p>
<p>5. In console CLI <code> cd NAME_HERE </code> , and <code>git init   git add.   git commit</code> if necessary </p>
<p>6. Create DB and set in <code>.env (DB_DATABASE)</code> </p>

<p>7. Install auth Breeze  <code> composer require laravel/breeze --dev </code> 
          Scaffold the auth system  <code> php artisan breeze:install </code>  and run migratations

 </p>



















<p> ----------------------------------------------------------------------------------------- </p>

## 2. Docker sail

<code> ./vendor/bin/sail up </code>
<code> ./vendor/bin/sail shell </code>
<code> ./vendor/bin/sail down </code>

<code> docker exec -it my_filament_laravel_12-laravel.test-1 /bin/bash  </code>






<p> ----------------------------------------------------------------------------------------- </p>

## 3. Filament3



<code> composer require livewire/livewire:^3.0</code>

composer require filament/filament:"^3.3" -W
php artisan filament:install --panels
php artisan make:filament-user

php artisan vendor:publish --tag=filament-config

php artisan vendor:publish --tag=filament-config     //optional to modify
 


<p> Relation-manager</p> 
php artisan make:filament-relation-manager OwnerResource venues owner_id








<p> ----------------------------------------------------------------------------------------- </p>


<p> ----------------------------------------------------------------------------------------- </p>

## 103. Screenshots
![Screenshot](public/img/screenshots/owner2.png)






<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
