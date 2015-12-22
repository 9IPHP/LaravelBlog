@include('layouts._header')
    <script>
        var webConfig = {
            navScroll: false,
        }
    </script>
    @yield('head')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="{{ asset('/js/html5shiv.js') }}"></script>
        <script src="{{ asset('/js/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body>

    @include('layouts._nav', ['navClass' => 'is-fixed is-visible'])

    <!-- Main Content -->
    <div class="container mg-75">
        111
    </div>

    <hr>

    @include('layouts._footer')

</body>

</html>
