<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blogs extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'status',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public static function active()
    {
        $posts = Blogs::all();
        $posts = $posts->where('status' , '=', 1);
        return $posts;
    }

    public static function activePagination()
    {
        $posts = Blogs::where('status' , '=', 1)->paginate(1);
        return $posts;
    }

    public static function getActive($id)
    {
        $post = Blogs::find($id);
        if ($post->status === 1) {
            return $post;
        } else return false;
    }

    /*
     * $id parameter can be both ID / SLUG
     */
    public function getActiveWithSlug($id)
    {
        /*
         * Statement 1 (WITH ID)
         */
        $post = Blogs::find($id);
        $postWithSlug = Blogs::where('slug', '=', $id)->first();
        if ($post && $post->status === 1) {
            return $post;
        }
        /*
         * Statement 2 (WITH SLUG)
         */
        else if ($postWithSlug && $postWithSlug->status === 1) {
                return $postWithSlug;
        } else {
            return false;
        }
    }

}
