<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@section('title')Admin - Laravel Blog @show</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="{{ asset('/js/html5shiv.js') }}"></script>
        <script src="{{ asset('/js/respond.min.js') }}"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/admin/index">{{ get_option('sitename') }} Admin</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li><a href="/">HOME</a></li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/user/{{auth()->id()}}/edit"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/user/{{auth()->id()}}/resetpwd"><i class="fa fa-gear fa-fw"></i> 修改密码</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="/admin/index"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        @can('article.manage')
                        <li>
                            <a href="javascript:;"><i class="fa fa-file-o fa-fw"></i> Articles<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/articles/index">文章列表</a>
                                </li>
                                <li>
                                    <a href="/admin/articles/trash">回收站</a>
                                </li>
                                <li>
                                    <a href="/admin/articles/tags">标签</a>
                                </li>
                                <li>
                                    <a href="/admin/articles/comments">评论</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('image.manage')
                        <li>
                            <a href="javascript:;"><i class="fa fa-image fa-fw"></i> Images<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/images/index">图片列表</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('user.manage')
                        <li>
                            <a href="javascript:;"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/users/index">用户列表</a>
                                </li>
                                <li>
                                    <a href="/admin/users/roles">用户组</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('system.manage')
                        <li>
                            <a href="javascript:;"><i class="fa fa-gear fa-fw"></i> Options<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/options/index">系统设置</a>
                                </li>
                                {{-- <li>
                                    <a href="/admin/options/create">添加系统变量</a>
                                </li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="fa fa-info-circle fa-fw"></i> Notificatins<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/notifications/index">系统消息</a>
                                </li>
                                <li>
                                    <a href="/admin/notifications/create">发布消息</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page-header')</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                @yield('content')
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script id="flash-template" type="text/template">
        <div class="Alert">
            <i class="fa fa-info-circle"></i>
            <span class="Alert__body"></span>
        </div>
    </script>

    <!-- jQuery -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('/js/metisMenu.min.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('/js/raphael-min.js') }}"></script>
    <script src="{{ asset('/js/morris.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('/js/sb-admin-2.js') }}"></script>

    @yield('footer')

</body>

</html>
