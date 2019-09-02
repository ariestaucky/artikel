<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class follow extends Model
{
        // Table Name
        protected $table = 'follow';

        protected $fillable = ['post_id', 'user_id', 'comment_id'];
}
