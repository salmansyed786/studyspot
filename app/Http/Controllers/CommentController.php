<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Add Comment
    public function storeComment(Request $request)
    {
        // post from post id
        $post = Post::where('id', $request->post_id)->first();

        $request->validate([
            'description' => 'required',
        ]);
        
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->description = $request->description;
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->save();

        // update number of comments on post
        $post->comments++;
        $post->save();
        

        // get username of user who posted
        $username = User::where('id', $comment->user_id)->first()->username;

        return response()->json(array(
            'success' => true,
            'comment' => $comment,
            'username' => $username,
            200,
            array( 'allow origin' => 'Access-Control-Allow-Origin')
        ));
    }

    // View all comments on a post
    public function viewComments(Request $request)
    {        
        $comments = Comment::where('post_id', $request->post_id)->get();
        // get username of user who posted the comment
        foreach ($comments as $comment) {
            $comment->username = User::where('id', $comment->user_id)->first()->username;
        }

        return response()->json(array(
            'success' => true,
            'comments' => $comments,
            200,
            array( 'allow origin' => 'Access-Control-Allow-Origin')
        ));
    }
}