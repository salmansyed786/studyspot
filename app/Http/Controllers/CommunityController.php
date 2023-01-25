<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Community;
use App\Models\Membership;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    // Show all community posts (HOME PAGE)
    public function index() {
        return view('communities.index', [
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
    
        return view('communities.show', [
            'communities' => Community::latest()->get(),
            'cmty' => $community,
            'posts' => Post::where('community_id', '=', $community->id)->filter(request(['tag', 'search']))->latest()->paginate(9)
        ]);
    }

    // Store a new community
    public function storeCmty(Request $request) {
        $attributes = request()->validate([
            'community_name' => 'required',
            'about' => 'required',
            'user_id' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images', 'public');
        }

        Community::create($attributes);
        Membership::create([
            'user_id' => $attributes['user_id'],
            'community_id' => Community::where('community_name', $attributes['community_name'])->first()->id
        ]);

        return redirect('/c/' . $attributes['community_name'])->with('message', 'community created successfully! 🎉');
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

    // search for a community
    public function search(Request $request) {
        $search = $request->get('community');
        $community = Community::where('community_name', 'like', '%' . $search . '%')->first();

        if (!$community) {
            abort(404);
        }

        return $this->show($community->community_name);
    }    
}