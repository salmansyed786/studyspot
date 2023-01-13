<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = ['community_name', 'about', 'image', 'posts', 'members', 'user_id'];

    // public function scopeFilter($query, array $filters) {
    //     if ($filters['search'] ?? false) {
    //         $query->where('community_name', 'like', '%' . request('search') . '%')
    //                     ->orWhere('about', 'like', '%' . request('search') . '%');
    //     }
    // }

    use HasFactory;

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship With Posts
    public function posts() {
        return $this->hasMany(Post::class, 'community_id');
    }
}