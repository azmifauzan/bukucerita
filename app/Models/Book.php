<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'judul',
        'pengarang',
        'sinopsis',
        'cover',
        'link',
        'status',
        'category_id',
        'user_id',
        'views',
        'age_min',
        'age_max',
    ];

    protected function casts(): array
    {
        return [
            'views' => 'integer',
            'age_min' => 'integer',
            'age_max' => 'integer',
        ];
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeForAge($query, int $age): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('age_min', '<=', $age)->where('age_max', '>=', $age);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
