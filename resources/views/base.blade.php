<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>API Integrations</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>
</head>
<body>
<div id="app" class="position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            API Integrations
        </div>

        <div class="links">
            <router-link tag="a" to="/adwords">
                Adwords
            </router-link>
            <router-link tag="a" to="/adwords">
                Facebook API (In Progress)
            </router-link>
        </div>
    </div>

    <router-view></router-view>
</div>
</body>
</html>

<script src="{{ mix('js/app.js') }}"></script>
