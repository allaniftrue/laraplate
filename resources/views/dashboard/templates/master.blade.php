<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>{{ $title or 'Administration Panel' }}</title>
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
        @yield('styles')
        @yield('jsHeader')
    </head>
    <body>
        @include('dashboard.menu')
        <div class="container">
            @yield('content')
        </div>
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
        var csrfToken = '{{ csrf_token() }}',
            baseUrl = '{{ url('/') }}/';
        </script>
        @yield('jsFooter')
    </body>
</html>
