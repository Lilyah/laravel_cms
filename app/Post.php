<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    //
    protected $fillable = ['title', 'description', 'content', 'image', 'published_at', 'category_id'];



    /**
     * 
     * Delete post image from storage
     * @return void
     * 
     */
    public function deleteImage()
    {

    Storage::delete($this->image);

    }



    public function category() //category is the name of the model but with small cases
    {

        // this is the same as return $this->belongsTo('App\Category');
        return $this->belongsTo(Category::class); // Laravel reads "$this model actually belongsTo Category model" and then try to find the $tablle->integer('category_id'); in create_posts_table migration

    }


}
