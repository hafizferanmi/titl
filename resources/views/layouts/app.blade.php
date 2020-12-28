<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script>
        var map;

        function haversine_distance(mk1, mk2) {
            var R = 3958.8; // Radius of the Earth in miles
            var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
            var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
            var difflat = rlat2-rlat1; // Radian difference (latitudes)
            var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

            var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
            return d;
        }

        var x = document.getElementById("demo");
        const getLocation = () => {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(showPosition, errorHandler ,{ enableHighAccuracy: true, maximumAge: 10000 });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        const errorHandler = () => console.log('There is an error')

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;

            // const currentPositionLatitude = position.coords.latitude;
            // const currentPositionLongitde = position.coords.longitude;
            const currentPositionLatitude = 7.487413;
            const currentPositionLongitde = 4.544809;

            const center = { lat: currentPositionLatitude, lng: currentPositionLongitde };
            const options = { zoom: 15, scaleControl: true, center: center };
            const map = new google.maps.Map(document.getElementById('map'), options);

            // Locations of landmarks
            const currentPositonCoordinate =  { lat: currentPositionLatitude, lng: currentPositionLongitde };

            const meters = 100
            const coef = meters * 0.0000089;
            const secondPostionLatitude = currentPositonCoordinate.lat + coef;

            const secondPostionLongitude = currentPositonCoordinate.lng + coef / Math.cos(currentPositonCoordinate.lat * 0.018);
            const secondPostionCoordinate = { lat: secondPostionLatitude, lng: secondPostionLongitude};


            var mk1 = new google.maps.Marker({position: currentPositonCoordinate, map: map});
            var mk2 = new google.maps.Marker({position: secondPostionCoordinate, map: map});

            var line = new google.maps.Polyline({path: [currentPositonCoordinate, secondPostionCoordinate], map: map});

            var distance = haversine_distance(mk1, mk2);
            // document.getElementById('msg').innerHTML = "Distance between markers: " + distance.toFixed(2) + " mi.";


            console.log('Lat', position.coords.latitude)
            console.log('Lat', position.coords.longitude)


        }

        function initMap() {
            getLocation();
        }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSgA6QSBVxJ-ZDy_xHG4vtrT65l4PGG8c">
    </script>
</body>
</html>
