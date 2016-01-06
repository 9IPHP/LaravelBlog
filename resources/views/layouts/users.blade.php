@include('layouts._header')
    <script>
        var webConfig = {
            navScroll: false,
            canUpload: @can('image.upload') true @else false @endcan ,
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

    @include('layouts._nav', ['navClass' => 'navbar-cunstom'])

    <header class="intro-header" style="background-image: url(/img/about-bg.jpg @show)">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>User Center</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mg-75">
        <div class="row">
            <div class="col-md-3">
                <div class="ucard">
                    <div class="bg" style="background-image: url(http://img.t.sinajs.cn/t6/skin/skinvip037/images/body_bg.jpg);"></div>
                    <div class="body">
                        <p class="avatar-area"><a href="/user/{{ $user->id }}"><img src="{{ getAvarar($user->email, 100) }}" class="avatar-100"></a></p>
                        <h4><a href="/user/{{ $user->id }}">{{ $user->name }}</a></h4>
                        @if($user->description)<p class="des">{{ $user->description }}</p>@endif
                        <hr>
                        <div class="user-meta">
                            @if($user->website)<p><i class="fa fa-globe"></i> <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></p>@endif
                            @if($user->weibo)<p><i class="fa fa-weibo"></i> <a href="{{ $user->weibo }}" target="_blank">{{ $user->weibo }}</a></p>@endif
                            @if($user->github)<p><i class="fa fa-github-alt"></i> <a href="{{ $user->github }}" target="_blank">{{ $user->github }}</a></p>@endif
                            @if($user->qq)<p><i class="fa fa-qq"></i> {{ $user->qq }}</p>@endif
                        </div>
                        @can('update', $user)
                            <a href="/user/{{ $user->id }}/edit" class="btn btn-primary btn-sm" data-original-title="" title=""><span class="fa fa-edit"></span> 编辑个人资料</a>
                            <a href="/user/{{ $user->id }}/resetpwd" class="btn btn-warning btn-sm" data-original-title="" title=""><span class="fa fa-edit"></span> 修改密码</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default panel-user-info">
                    {{-- <div class="panel-body "> --}}

                        @yield('container')
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>

    <hr>

    @include('layouts._footer')

</body>

</html>
