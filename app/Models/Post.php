<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //this is better, but this is not a production app so no need
    //protected fillable

    //with this we ignore the mass assignment condition: 
        protected $guarded = [];
}
