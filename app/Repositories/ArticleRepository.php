<?php
namespace App\Repositories;

use App\User;
use App\Tag;
use App\Article;
use Auth;
/*use Illuminate\Pagination\Paginator;
use Cache;*/

class ArticleRepository{

    public function allWithDelete()
    {
        $articles =  Article::withTrashed()->with('user')
                    ->Orderby('created_at', 'DESC')
                    ->paginate(10);
        return $articles;
    }

    public function onlyDeleted()
    {
        $articles =  Article::onlyTrashed()->with('user')
                    ->latest('deleted_at')
                    ->paginate(10);
        return $articles;
    }

    public function allWithNotActived($orderby = 'created_at')
    {
        $articles =  Article::with('user')
                    ->latest($orderby)
                    ->simplePaginate(10);
        return $articles;
    }

    public function all()
    {
        /*$currentPage = Paginator::resolveCurrentPage('page');
        $currentPage = $currentPage ? $currentPage : 1;
        if($articles =  Cache::get('articles-page-' . $currentPage))
            return $articles;*/

        $articles =  Article::with('user')
                    ->latest()
                    ->simplePaginate(10);
        // Cache::put('articles-page-' . $currentPage, $articles, 10);
        return $articles;
    }

    public function forUser($user_id)
    {
        return Article::with('user')->where('user_id', $user_id)
                    ->latest()
                    ->simplePaginate(10);
    }

    public function syncTags(Article $article, $tags = array(), $isNew = false){
        $tagall = Tag::all()->toArray();
        $newTagIds = $updateTagIds = $existingSlug = $existingTag = [];
        if(!empty($tagall)) foreach($tagall as $tag){
            $existingSlug[] = $tag['slug'];
            $existingTag[$tag['slug']] = $tag;
        }
        unset($tagall);
        if($tags) foreach($tags as $tag){
            if(!in_array(mb_strtolower($tag, 'UTF-8'), $existingSlug)){
                $name = filter_allowed_words($tag);
                $slug = preg_replace('/\s+/', '-', mb_strtolower($name, 'UTF-8'));
                if(in_array($slug, $existingSlug)){
                    if ($isNew) Tag::whereSlug($slug)->increment('count');
                    $updateTagIds[] = $existingTag[$slug]['id'];
                } else {
                    $firstLetter = getFirstLetter($name);
                    $newtag = Tag::create(array('name' => $name, 'slug' => $slug, 'letter' => $firstLetter));
                    $newId = $newtag->id;
                    $newTagIds[] = $newId;
                    $updateTagIds[] = $newId;
                }
            }else{
                if ($isNew) Tag::whereSlug($tag)->increment('count');
                $updateTagIds[] = $existingTag[$tag]['id'];
            }
        }
        $updateTagIds = array_unique($updateTagIds);
        if (!$isNew) {
            $oldTagIds = $article->tags->lists('id')->toArray();
            $delTagIds = array_diff($oldTagIds, $updateTagIds);
            $addTagIds = array_diff($updateTagIds, $oldTagIds);
            if (!empty($delTagIds)) {
                Tag::whereIn('id', $delTagIds)->decrement('count');
            }
            if (!empty($addTagIds)) {
                foreach($addTagIds as $addId){
                    if(!in_array($addId, $newTagIds))
                        Tag::whereId($addId)->increment('count');
                }
            }
        }
        $article->tags()->sync($updateTagIds);
        unset($newTagIds, $updateTagIds, $existingSlug, $existingTag);
    }

    public function delTags(Article $article)
    {
        $tagIds = $article->tags->lists('id');
        Tag::whereIn('id', $tagIds)->decrement('count');
    }

    public function restoreTags(Article $article)
    {
        $tagIds = $article->tags->lists('id');
        Tag::whereIn('id', $tagIds)->increment('count');
    }
}