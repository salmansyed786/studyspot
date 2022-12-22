<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    // Show all community posts
    public function index() {
        return view('Communities.index', [
            'communities' => Community::latest()->get(),
            'posts' => Post::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    // Show a specific community's posts
    public function show($community) {
        $community = Community::where('community_name', $community)->first();

        if (!$community) {
            abort(404);
        }
    
        return view('Communities.show', [
            'communities' => Community::latest()->get(),
            'cmty' => $community,
            'posts' => Post::where('community_id', '=', $community->id)->filter(request(['tag', 'search']))->get()
        ]);
    }

    // Create a new post
    public function createPost($community = null) {
        $community = Community::where('community_name', $community)->first();
        return view('communities.createPost', [
            'communities' => Community::latest()->get(),
            'selectedCmty' => $community
        ]);
    }

    // Store a new post
    public function storePost() {
        $attributes = request()->validate([
            'title' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'community_id' => 'required',
            'author' => 'required',
        ]);

        Post::create($attributes);

        return redirect('/' );
    }
}
