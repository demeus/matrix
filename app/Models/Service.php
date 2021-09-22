<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Service extends Model
{
    use HasFactory;
    use Sluggable;
    use AsSource;
    use Filterable;


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
        'title', 'slug', 'description', 'content', 'image', 'position',  'author_id', 'active', 'price'
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::saving(function ($model) {
            $model->author_id = auth()->id();
        });
    }

    protected $casts = [
        'active' => 'boolean',
        'price' => 'array',
    ];
}
