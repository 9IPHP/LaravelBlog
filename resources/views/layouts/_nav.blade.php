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
            <a class="navbar-brand" href="/">Laravel博客</a>
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
                    <li>
                        <a href="/auth/logout">LogOut</a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>