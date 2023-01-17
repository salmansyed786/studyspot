<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'tags', 'description', 'user_id', 'community_id', 'image', 'color', 'views', 'likes', 'dislikes', 'comments', 'textColor'];

    public function scopeFilter($query, array $filters) {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if ($filters['search'] ?? false) {
            $community = Community::where('community_name', 'like', '%' . request('search') . '%')->first();

            $query->where('title', 'like', '%' . request('search')  . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%')
                ->orWhere('community_id', 'like', '%' . $community->id . '%')
                ->orWhere('user_id', 'like', '%' . request('search') . '%');
        }
    }

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship To Community
    public function community() {
        return $this->belongsTo(Community::class, 'community_id');
    }

}