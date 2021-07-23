<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

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
        'image'
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
}
