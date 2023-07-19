<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beat extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'premium_file', 'free_file'];

    public function like()
    {
        return $this->morphOne(Like::class, 'likeable');
    }
}
