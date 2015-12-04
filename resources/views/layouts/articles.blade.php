@include('layouts._header')
    <script>
        @section('headerScript')
        var webConfig = {
            navScroll: true,
        }
        @show
    </script>
    @yield('head')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    @include('layouts._nav', ['navClass' => 'navbar-cunstom'])

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url(@section('bgimg') /img/home-bg.jpg @show)"data-bg="@if(isset($article) && $article->thumb){{$article->thumb}} @else /img/home-bg.jpg @endif">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    @yield('site-heading')
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 main-content">
                @include('flash::message')
                @yield('container')
            </div>
        </div>
    </div>

    <hr>

    @include('layouts._footer')



</body>

</html>
