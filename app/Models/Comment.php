<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
      use SoftDeletes;
      protected $fillable =['post_id','user_id' ,'body'];
      protected $hidden = ['deleted_at'];

      public function post()
      {
          return $this->belongsTo(Post::class);
      }
}
