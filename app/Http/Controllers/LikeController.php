<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Like a post
    public function likePost(Post $post) {
        // Check if user has already liked the post
        $like = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->where('isLike', true)
            ->first();

        $dislike = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->where('isLike', false)
            ->first();

        // find the post
        $post = Post::find($post->id);
        
        // If user has already liked the post, then unlike it
        if ($like) {
            $like->delete();
            // remove the like from post
            $post->likes--;
        } else if ($dislike) {
            $dislike->delete();
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => true
            ]);
            // remove the dislike from post and add a like to post
            $post->likes++;
            $post->dislikes--;
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => true
            ]);
            // add a like to post
            $post->likes++;
        }
        
        $post->save();

        return back();
    }

    // Dislike a post
    public function dislikePost(Post $post) {
        // Check if user has already liked the post
        $dislike = Like::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->where('isLike', false)
            ->first();

        $like = Like::where('user_id', auth()->id())
        ->where('post_id', $post->id)
        ->where('isLike', true)
        ->first();

        // find the post
        $post = Post::find($post->id);
        
        // If user has already liked the post, then unlike it
        if ($dislike) {
            $dislike->delete();
            // remove the dislike from post
            $post->dislikes--;
        } else if ($like) {
            $like->delete();
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => false
            ]);
            // remove the like from post and add a dislike to post
            $post->likes--;
            $post->dislikes++;
        }
        else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'isLike' => false
            ]);
            // add a dislike to post
            $post->dislikes++;
        }

        $post->save();

        return back();
    }
}