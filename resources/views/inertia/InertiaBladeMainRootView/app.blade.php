<!--  Used for Inertia only. eg for example for  App\Http\Controllers\Inertia\InertiaController -->
<!--   It is Inertia main root Blade view, it renders other components, must include  @vite('resources/js/inertia.js') -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inertia Page</title>
    <style>
        .inertia-info-card {
            background: linear-gradient(135deg, #e0f2fe, #ede9fe);
            border-left: 6px solid #6366f1;
            padding: 16px 18px;
            border-radius: 14px;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.6;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
    </style>

    @vite('resources/js/inertia.js')
    @inertiaHead
</head>
<body>
    <div class="inertia-info-card" style="word-break: break-word;">
        Inertia works as a bridge between Laravel and a JavaScript UI framework. You have to use any front-end framework along with Inertia, for example Vue or React

        Laravel controllers return JS components instead of Blade
        The frontend framework renders the page. <br>

        Inertia uses root Blade view which renders other components. By default it is views/app.blade.php
         My  custom Root blade is resources/views/inertia/InertiaBladeMainRootView/app.blade.php. It is set in in App/Providers/AppServiceProvider.php
    </div>


    <!-- Inertia component is rendered here -->
    @inertia
    <!-- End Inertia component is rendered here -->

</body>
</html>