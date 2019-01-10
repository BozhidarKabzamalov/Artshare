<?php

namespace App\Http\Controllers;

use App\Image;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeArtwork(Request $request){
        $id = $request['imageId'];

        $user = Auth::user();
        $liked = Like::where('user_id', $user->id)->where('image_id', $id)->first();

        if ($liked) {
            $liked->delete();
        } else {
            $like = new Like();
            $like->image_id = $id;
            $like->user_id = $user->id;

            $like->save();
        }

        $likes = Like::where('image_id', $id)->get();
        $numberOfLikes = count($likes);
        return response()->json(['numberOfLikes'=>$numberOfLikes]);
    }
}
