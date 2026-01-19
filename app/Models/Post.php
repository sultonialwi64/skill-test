<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Tambahkan ini agar fungsi store() tidak error "Mass Assignment"
    protected $fillable = ['title', 'content', 'is_draft', 'published_at', 'user_id'];

    public function scopeActive($query)
{
    return $query->where('is_draft', false)
                 ->where(function ($q) {
                     $q->whereNull('published_at')
                       ->orWhere('published_at', '<=', now());
                 });
}

    public function user()
    {
        return $this->belongsTo(User::class); //
    }
}
