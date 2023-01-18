<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Like a post
    public function likePost(Request $request, $post_id) {
        // Get the post from the request where id is the post id
        $post = Post::where('id', $post_id)->first();
        
        // Check if user has already liked the post
        $like = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->where('isLike', true)
            ->first();

        $dislike = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->where('isLike', false)
            ->first();
                
        // If user has already liked the post, then unlike it
        if ($like) {
            $like->delete();
            // Remove the like from post
            $post->likes--;
            $post->save();
            // send response to ajax like was removed
            return response()->json(['like' => 'like removed', "post-id" => $post->id]);
        } else if ($dislike) {
            $dislike->delete();
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => true
            ]);
            // Remove the dislike from post and add a like to post
            $post->likes++;
            $post->dislikes--;
            $post->save();
            // send response to ajax like was added and dislike was removed
            return response()->json(['like' => 'like added', 'dislike' => 'dislike removed', "post-id" => $post->id]);
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => true
            ]);
            // Add a like to post
            $post->likes++;
            $post->save();
            // send response to ajax like was added
            return response()->json(['like' => 'like added', "post-id" => $post->id]);
        }
    }

    // Dislike a post
    public function dislikePost(Request $request, $post_id) {
        // Get the post from the request
        $post = Post::where('id', $post_id)->first();
        
        // Check if user has already liked the post
        $dislike = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->where('isLike', false)
            ->first();

        $like = Like::where('user_id', auth()->id())
        ->where('post_id', $post->id)
        ->where('isLike', true)
        ->first();
        
        // If user has already liked the post, then unlike it
        if ($dislike) {
            $dislike->delete();
            // Remove the dislike from post
            $post->dislikes--;
            $post->save();
            // send response to ajax dislike was removed
            return response()->json(['dislike' => 'dislike removed', "post-id" => $post->id]);

        } else if ($like) {
            $like->delete();
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => false
            ]);
            // Remove the like from post and add a dislike to post
            $post->likes--;
            $post->dislikes++;
            $post->save();
            // send response to ajax dislike was added and like was removed
            return response()->json(['dislike' => 'dislike added', 'like' => 'like removed', "post-id" => $post->id]);
        }
        else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => false
            ]);
            // Add a dislike to post
            $post->dislikes++;
            $post->save();
            // send response to ajax dislike was added
            return response()->json(['dislike' => 'dislike added', "post-id" => $post->id]);
        }
    }
}