<?php
namespace App\Repositories;

use App\User;
use App\Article;

class ArticleRepository{

    public function all()
    {
        return Article::actived()
                    ->Orderby('created_at', 'DESC')
                    ->paginate(1);
    }

    public function forUser(User $user)
    {
        return Article::where('user_id', $user->id)->actived()
                    ->Orderby('created_at', 'DESC')
                    ->simplePaginate(2);
    }
}