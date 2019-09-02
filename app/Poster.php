<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
        // Table Name
        protected $table = 'poster';

        protected $fillable = ['post_id', 'post_owner', 'notifiable_id'];
}