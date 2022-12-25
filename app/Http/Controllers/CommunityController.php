<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    // Show all community posts (HOME PAGE)
    public function index() {
        return view('Communities.index', [
            'communities' => Community::latest()->get(),
            'posts' => Post::latest()->filter(request(['tag', 'search']))->paginate(9)
        ]);
    }

    // Show a specific community's posts (COMMUNITY PAGE)
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

    // Create a new post (CREATE POST PAGE)
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
            'color' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        list($r, $g, $b) = sscanf($attributes['color'], "#%02x%02x%02x");
        $brightness = round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
        $attributes['textColor'] = ($brightness > 125) ? '#000000' : '#FFFFFF';

        Post::create($attributes);
        $community = Community::where('id', $community_id)->first();

        return redirect('/c/' . $community->community_name)->with('message', 'post created successfully! 🎉   ');
    }

    // Edit a post (EDIT POST PAGE)
    public function editPost($communityName, Post $post) {
        $community = Community::where('community_name', $communityName)->first();

        return view('communities.editPost', [
            'communities' => Community::latest()->get(),
            'cmty' => Community::where('id', $community->id)->first(),
            'post' => $post
        ]);
    }

    // Store updated post
    public function updatePost(Request $request, $communityName, Post $post) {
        $community_id = $request->input('community_id');

        $attributes = request()->validate([
            'title' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'community_id' => 'required',
            'author' => 'required',
            'color' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        list($r, $g, $b) = sscanf($attributes['color'], "#%02x%02x%02x");
        $brightness = round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
        $attributes['textColor'] = ($brightness > 125) ? '#000000' : '#FFFFFF';

        $post->update($attributes);
        $community = Community::where('id', $community_id)->first();

        return redirect('/c/' . $community->community_name)->with('message', 'post updated successfully! 🧚‍♀️  ');
    }

    // Delete a post
    public function destroyPost($communityName, Post $post) {
        $post->delete();

        return redirect('/c/' . $communityName)->with('message', 'post deleted successfully! 🗑️  ');
    }

    // Store a new community
    public function storeCmty(Request $request) {
        $attributes = request()->validate([
            'community_name' => 'required',
            'about' => 'required',
            'image' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        Community::create($attributes);

        return redirect('/c/' . $attributes['community_name'])->with('message', 'community created successfully! 🎉  ');
    }

    // Update a community
    public function updateCmty(Request $request, $communityName) {
        $community = Community::where('community_name', $communityName)->first();

        $attributes = request()->validate([
            'community_name' => 'required',
            'about' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        $community->update($attributes);

        return redirect('/c/' . $attributes['community_name'])->with('message', 'community updated successfully! 🧚‍♀️  ');
    }

    // Delete a community
    public function destroyCmty($communityName) {
        $community = Community::where('community_name', $communityName)->first();
        $community->delete();

        return redirect('/')->with('message', 'community deleted successfully! 🗑️  ');
    }
}
