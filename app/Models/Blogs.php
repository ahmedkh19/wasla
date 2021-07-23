<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Blogs extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
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

}
