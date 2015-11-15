<?php
namespace App\Repositories;

use App\User;
use App\Tag;
use App\Article;

class ArticleRepository{

    public function all()
    {
        return Article::actived()
                    ->Orderby('created_at', 'DESC')
                    ->paginate(10);
    }

    public function forUser($user_id)
    {
        return Article::where('user_id', $user_id)->actived()
                    ->Orderby('created_at', 'DESC')
                    ->simplePaginate(10);
    }
    public function syncTags(Article $article, array $tags){
        // $tags = $requests['tag_list'];
        $tagall = Tag::all()->toArray();
        $existingSlug = $existingTag = [];
        if(!empty($tagall)) foreach($tagall as $tag){
            $existingSlug[] = $tag['slug'];
            $existingTag[$tag['slug']] = $tag;
        }
        foreach($tags as $tag){
            if(!in_array(mb_strtolower($tag, 'UTF-8'), $existingSlug)){
                $name = filter_allowed_words($tag);
                $slug = preg_replace('/\s+/', '-', mb_strtolower($name, 'UTF-8'));
                if(in_array($slug, $existingSlug))
                    $tagIds[] = $existingTag[$slug]['id'];
                else{
                    $newId = Tag::insertGetId(array('name' => $name, 'slug' => $slug));
                    $tagIds[] = $newId;
                }
            }else
                $tagIds[] = $existingTag[$tag]['id'];
        }
        $tagIds = array_unique($tagIds);
        $article->tags()->sync($tagIds);
    }
}