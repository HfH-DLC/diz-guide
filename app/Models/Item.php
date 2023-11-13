<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mediaType()
    {
        return $this->belongsTo(MediaType::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
