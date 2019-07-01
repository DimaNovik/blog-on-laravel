<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Documents extends Model
{
    //
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    protected $fillable = ['title', 'file', 'category', 'status'];

    public function category()
    {
        return $this->hasOne(Documents::class);
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {

        $document = new static;
        $document->fill($fields);
        $document->save();

        return $document;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function setCategory($id)
    {
        if($id === null) { return; }
        $this->category_id = $id;
        $this->save();
    }

    public function uploadImage($image)
    {
        if($image === null) { return; }

        $this->removeImage();
        $filename = $image->getClientOriginalName();
        $image->storeAs('uploads/files', $filename);
        $this->file = $filename;
        $this->save();
    }

    public function removeImage() {
        if($this->file != null) {
            Storage::delete('uploads/files/' . $this->file);
        }
    }

    public function getImage()
    {
        if($this->file == null) {
            return '/images/unnamed.jpg';
        }
        return '/uploads/files/' . $this->file;
    }

    public function setPublic()
    {
        $this->status = Documents::IS_PUBLIC;
        $this->save();
    }
}
