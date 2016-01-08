<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top {{$navClass}}">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ get_option('sitename') }}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/articles">Articles</a>
                </li>
                <li>
                    <a href="/tags">Tags</a>
                </li>
                <li>
                    <a href="/users">Users</a>
                </li>
                @if(Auth::guest())
                    <li>
                        <a href="/auth/login">Login</a>
                    </li>
                    <li>
                        <a href="/auth/register">Register</a>
                    </li>
                @else
                    @can('article.create')
                        <li>
                            <a href="/articles/create">Add Article</a>
                        </li>
                    @endcan
                    @if(Auth::user()->hasRole('editor') || Auth::user()->isAdmin())
                        <li>
                            <a href="/admin/index">Admin</a>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="/user/{{auth()->id()}}"><i class="fa fa-user fa-fw"></i> User Center</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/user/{{auth()->id()}}/notifications"><i class="fa fa-bell-o fa-fw"></i> 通知 <span class="badge @if(App\User::noticeCount())grow bg-danger @endif">{{ App\User::noticeCount() }}</span></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/user/{{auth()->id()}}/edit"><i class="fa fa-edit fa-fw"></i> 编辑资料</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/user/{{auth()->id()}}/resetpwd"><i class="fa fa-gear fa-fw"></i> 修改密码</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>