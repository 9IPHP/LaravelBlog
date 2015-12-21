<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>


    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                @can('article.create')
                    <p>Can</p>
                @else
                    <p>Can Not</p>
                @endcan
            </div>
        </div>
    </body>
</html>
