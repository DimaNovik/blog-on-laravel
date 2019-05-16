<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    //
    use Sluggable;

    protected $fillable = ['title', 'parent', 'link'];

    public function sub_category() {
        return $this->belongsToMany(
            Category::class,
            'category_table',
            'category_id',
            'parent_id'
        );
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
