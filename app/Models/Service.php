<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'content',
        'status',
        'image',
        'slug'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];

    public static function active()
    {
        $posts = Service::all();
        $posts = $posts->where('status' , '=', 1);
        return $posts;
    }

    public static function activePagination()
    {
        $posts = Service::where('status' , '=', 1)->paginate(1);
        return $posts;
    }

    public static function getActive($id)
    {
        $post = Service::find($id);
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
        $post = Service::find($id);
        $postWithSlug = Service::where('slug', '=', $id)->first();
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

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

}
