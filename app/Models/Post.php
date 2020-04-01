<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
     use SoftDeletes;
     protected $fillable =['user_id','body'];
     protected $hidden = ['deleted_at'];

     public function user()
     {
         return $this->belongsTo(User::class);
     }

     public function comments()
     {
         return $this->hasMany(Comment::class);
     }

     public function images()
     {
         return $this->morphMany(Image::class , 'imageable');
     }


}
