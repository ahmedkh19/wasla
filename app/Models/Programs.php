<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Programs extends Model
{
    use HasFactory;
    use Sluggable;
    
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
}
