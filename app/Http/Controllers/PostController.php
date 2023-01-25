<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use Illuminate\Http\Request;

class PostController extends Controller
{
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

        $messages = [
            'title.required' => 'A title is required!',
            'tags.required' => 'Tags are required!',
            'description.required' => 'A description is required!',
            'community_id.required' => 'Please select a community!',
            'image.required' => 'Image is required!',
        ];

        $attributes = request()->validate([
            'title' => 'required|string',
            'tags' => 'required|string',
            'description' => 'required|string',
            'community_id' => 'required|integer',
            'color' => 'required|string',
        ], $messages);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        list($r, $g, $b) = sscanf($attributes['color'], "#%02x%02x%02x");
        $brightness = round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
        $attributes['textColor'] = ($brightness > 125) ? '#000000' : '#FFFFFF';
        $attributes['user_id'] = auth()->id();

        Post::create($attributes);
        $community = Community::where('id', $community_id)->first();

        return redirect('/c/' . $community->community_name)->with('message', 'post created successfully! 🎉   ');
    }

    // Edit a post (EDIT POST PAGE)
    public function editPost($communityName, Post $post) {
        // Check if the user is authorized to delete the post
        if (auth()->user()->id !== $post->user_id) {
            return back()->with('message', 'You are not authorized to update this post! 🚫');
        }
        
        $community = Community::where('community_name', $communityName)->first();

        return view('communities.editPost', [
            'communities' => Community::latest()->get(),
            'cmty' => Community::where('id', $community->id)->first(),
            'post' => $post
        ]);
    }

    // Store updated post
    public function updatePost(Request $request, $communityName, Post $post) {
        // Check if the user is authorized to delete the post
        if (auth()->user()->id !== $post->user_id) {
            return redirect()->with('message', 'You are not authorized to update this post! 🚫');
        }

        $community_id = $request->input('community_id');

        $messages = [
            'title.required' => 'A title is required!',
            'tags.required' => 'Tags are required!',
            'description.required' => 'A description is required!',
            'community_id.required' => 'Please select a community!!',
            'image.required' => 'Image is required!',
        ];

        $attributes = request()->validate([
            'title' => 'required|string',
            'tags' => 'required|string',
            'description' => 'required|string',
            'community_id' => 'required|integer',
            'color' => 'required|string',
        ], $messages);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        list($r, $g, $b) = sscanf($attributes['color'], "#%02x%02x%02x");
        $brightness = round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
        $attributes['textColor'] = ($brightness > 125) ? '#000000' : '#FFFFFF';
        $attributes['user_id'] = auth()->id();

        $post->update($attributes);
        $community = Community::where('id', $community_id)->first();

        return redirect('/c/' . $community->community_name)->with('message', 'post updated successfully! 🧚‍♀️  ');
    }

    // Delete a post
    public function destroyPost($communityName, Post $post) {
        // Check if the user is authorized to delete the post
        if (auth()->user()->id !== $post->user_id) {
            return back()->with('message', 'You are not authorized to update this post! 🚫');
        }
        
        $post->delete();

        return redirect('/c/' . $communityName)->with('message', 'post deleted successfully! 🗑️');
    }

    // Manage Post
    public function managePosts() {
        return view('posts.manage', [
            'posts' =>  auth()->user()->posts()->get()
        ]);
    }
}