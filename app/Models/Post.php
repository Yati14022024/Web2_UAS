<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post'; // Sesuaikan dengan nama tabel yang benar

    protected $fillable = [
        'title',
        'content',
        'image',
    ];

    public $timestamps = true; // Aktifkan timestamps (created_at dan updated_at)
}
