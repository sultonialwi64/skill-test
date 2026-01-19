<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'is_draft', 'published_at', 'user_id'];

    // WAJIB: Cast published_at agar Carbon bisa membandingkan waktu dengan akurat
    protected $casts = [
        'published_at' => 'datetime',
        'is_draft' => 'boolean',
    ];

    public function scopeActive($query)
    {
        // Syarat 4-1 & 4-4: Bukan draft DAN sudah masuk waktu publikasi
        return $query->where('is_draft', false)
                     ->whereNotNull('published_at') // Pastikan ada tanggalnya
                     ->where('published_at', '<=', now());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}