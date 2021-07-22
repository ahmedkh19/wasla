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
}
