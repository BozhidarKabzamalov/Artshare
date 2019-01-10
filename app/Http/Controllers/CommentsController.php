<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Image;

class CommentsController extends Controller
{
    public function postComment(Request $request){
        $userId = $request['userId'];
        $imageId = $request['imageId'];
        $commentText = $request['comment'];
        $image = Image::with('user')->find($imageId);

        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->image_id = $imageId;
        $comment->comment = $commentText;
        $comment->save();

        return response()->json(['comment'=>$comment, 'image'=>$image]);
    }

    public function deleteComment(Request $request){
        $commentId = $request['commentId'];
        $imageId = $request['imageId'];

        $comment = Comment::find($commentId);
        $comment->delete();

        $comments = Comment::get();
        $commentsCount = count($comments);

        return response()->json(['commentsCount'=>$commentsCount]);
    }
}
