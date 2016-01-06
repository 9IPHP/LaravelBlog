<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="list-inline text-center">
                    @if(get_option('weibo'))
                        <li>
                            <a href="{{ get_option('weibo') }}" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-weibo fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    @endif
                    @if(get_option('github'))
                        <li>
                            <a href="{{ get_option('github') }}" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    @endif
                    @if(get_option('twitter'))
                        <li>
                            <a href="{{ get_option('twitter') }}" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    @endif
                    @if(get_option('facebook'))
                        <li>
                            <a href="{{ get_option('facebook') }}" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
                <p class="copyright text-muted">Copyright &copy; {{ get_option('sitename') }} since 2016  {!! get_option('site_analytics') !!}</p>
            </div>
        </div>
    </div>
</footer>
<script id="flash-template" type="text/template">
    <div class="Alert">
        <i class="fa fa-info-circle"></i>
        <span class="Alert__body"></span>
    </div>
</script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('/js/clean-blog.js') }}"></script>
@yield('footer')