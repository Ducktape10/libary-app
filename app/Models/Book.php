<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'description',
        'released_at',
        'cover_image',
        'pages',
        'isbn',
        'in_stock'
    ];

    public function genres() {
        return $this->belongsToMany(Genre::class);
    }

    public function borrows() {
        return $this->hasMany(Borrow::class);
    }
}
