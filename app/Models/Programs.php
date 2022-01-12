<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Programs extends Model
{
    use HasFactory;
    use HasSlug;
    
    protected $fillable = [
    	'status',
        'title',
        'slug',
        'description',
        'thumbnail',
        'content',
        'units',
        'duration',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }


    public static function active()
    {
        $posts = Programs::all();
        $posts = $posts->where('status' , '=', 1);
        return $posts;
    }

    public static function activePagination()
    {
        $posts = Programs::where('status' , '=', 1)->paginate(1);
        return $posts;
    }

    public static function getActive($id)
    {
        $post = Programs::find($id);
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
        $post = Programs::find($id);
        $postWithSlug = Programs::where('slug', '=', $id)->first();
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
