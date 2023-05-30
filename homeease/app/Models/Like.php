<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public function blogger()
    {
        return $this->belongsTo(Blogger::class);
    }

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
