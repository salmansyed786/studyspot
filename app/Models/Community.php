<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = ['community_name', 'about', 'image', 'posts', 'members'];

    use HasFactory;
}
