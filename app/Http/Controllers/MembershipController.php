<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    // join a community
    public function joinCmty(Request $request, $communityName) {
        $community = Community::where('community_name', $communityName)->first();

        Membership::create([
            'user_id' => $request->user()->id,
            'community_id' => $community->id
        ]);

        // update the community's member count
        $community->members++;
        $community->save();

        return redirect('/c/' . $communityName)->with('message', 'joined community successfully! 🎉  ');
    }

    // leave a community
    public function leaveCmty(Request $request, $communityName) {
        $community = Community::where('community_name', $communityName)->first();

        Membership::where('user_id', $request->user()->id)->where('community_id', $community->id)->delete();

        $community->members--;
        $community->save();

        return redirect('/c/' . $communityName)->with('message', 'left community successfully! 🎉  ');
    }
}