<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icon.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    </head>
    <body class="loading">
        <div id="wrapper">
            @include('layouts.partials.header')
            @include('layouts.partials.sidebar')
            <div class="content-page">
                <div class="content">
                    @include('layouts.partials.messages')
                    @yield('content')
                </div>
                @include('layouts.partials.footer')
            </div>
        </div>

        <!-- App js -->
        <script src="{{ asset('js/vendor.min.js') }}"></script>
        <script src="{{ asset('js/app.min.js') }}"></script>
        <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
        <script>
            const beamsClient = new PusherPushNotifications.Client({
                instanceId: '54bd92a7-c38b-4e3f-b148-2d89a80e9a83',
            });
            beamsClient
            .start()
            .then((beamsClient) => beamsClient.getDeviceId())
            .then((deviceId) =>
                console.log("Successfully registered with Beams. Device ID:", deviceId)
            )
            .then(() => beamsClient.addDeviceInterest("logs"))
            .then(() => beamsClient.getDeviceInterests())
            .then((interests) => console.log("Current interests:", interests))
            .catch(console.error);
        </script>
        <script src="{{ asset('service-worker.js') }}"></script>


        @yield('js')

        

  

    </body>
</html>
