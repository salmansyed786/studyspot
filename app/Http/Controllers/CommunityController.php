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
            'posts' => Post::latest()->filter(request(['tag', 'search']))->paginate(9)
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
            'posts' => Post::where('community_id', '=', $community->id)->filter(request(['tag', 'search']))->latest()->paginate(9)
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
    public function storePost(Request $request) {
        $community_id = $request->input('community_id');

        $attributes = request()->validate([
            'title' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'community_id' => 'required',
            'author' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        Post::create($attributes);
        $community = Community::where('id', $community_id)->first();

        return redirect('/c/' . $community->community_name)->with('message', 'post created successfully 🎉   ');
    }
}
