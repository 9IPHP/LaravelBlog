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
                    ->simplePaginate(10);
    }

    public function forUser($user_id)
    {
        return Article::where('user_id', $user_id)->actived()
                    ->Orderby('created_at', 'DESC')
                    ->simplePaginate(10);
    }
    public function syncTags(Article $article, array $tags, $isNew = false){
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
                if(in_array($slug, $existingSlug)){
                    if ($isNew) Tag::whereSlug($slug)->increment('count');
                    $newTagIds[] = $existingTag[$slug]['id'];
                } else{
                    $newtag = Tag::create(array('name' => $name, 'slug' => $slug));
                    $newId = $newtag->id;
                    $newTagIds[] = $newId;
                }
            }else{
                if ($isNew) Tag::whereSlug($tag)->increment('count');
                $newTagIds[] = $existingTag[$tag]['id'];
            }
        }
        $newTagIds = array_unique($newTagIds);
        if (!$isNew) {
            $oldTagIds = $article->tags->lists('id')->toArray();
            $delTagIds = array_diff($oldTagIds, $newTagIds);
            if (!empty($delTagIds)) {
                foreach($delTagIds as $delId){
                    Tag::whereId($delId)->decrement('count');
                    /*$tagData = Tag::whereId($delId)->select('count')->first();
                    if ($tagData->count == 1) Tag::whereId($delId)->delete();
                    else Tag::whereId($delId)->decrement('count');*/
                }
            }
        }
        $article->tags()->sync($newTagIds);
    }
}