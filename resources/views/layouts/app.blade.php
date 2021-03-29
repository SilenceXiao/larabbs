<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'LaraBBS 爱好者社区')"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Larabbs') -- Laravel进阶</title>

    <!-- style -->
    <link rel="stylesheet" href=" {{ mix('css/app.css') }}">
    <!-- <link rel="stylesheet" href="css/app.css"> -->
    @yield('styles')
</head>

<body>
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts.header')
        <div class="container">
            @include('shared.messages')
            @yield('content')

        </div>
        @include('layouts.footer')
    </div>    
    <!-- script -->
    <script src="{{ mix('js/app.js')}}"></script>
    @yield('scripts')
</body>
</html>