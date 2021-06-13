<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'reader_id',
        'book_id',
        'reader_message',
        'status',
        'request_processed_at',
        'request_managed_by',
        'request_processed_message',
        'deadline',
        'returned_at',
        'return_managed_by'
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function reader() {
        return $this->belongsTo(User::class);
    }

    public function request_managed_by() {
        return $this->belongsTo(User::class);
    }
}
