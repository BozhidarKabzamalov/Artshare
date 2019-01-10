<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use App\Comment;
use App\Category;
use App\Tag;
use App\Like;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index(Request $request){
        $images = Image::where('parent_id', NULL)->orderBy('created_at', 'desc')->get();
        return view('home', ['images' => $images]);
    }

    public function specificImage($id){
        $similarImages = null;
        $image = Image::with('category')->find($id);
        Image::find($id)->increment('views');
        $imageCategoryId = $image->category_id;
        $subImages = Image::where('parent_id', $id)->get();
        $authorId = $image->user_id;
        $author = User::find($authorId);
        $comments = Comment::with('user')->where('image_id', $id)->orderBy('created_at', 'desc')->limit(10)->get();
        $commentsCount = count($comments);
        $recentImages = Image::where('parent_id', NULL)->where('user_id', $authorId)->where('id', '!=', $id)->orderBy('created_at', 'desc')->limit(9)->get();
        $similarImages = Image::where('category_id', $imageCategoryId)->where('id', '!=', $id)->where("category_id","!=",'')->orderBy('created_at', 'desc')->limit(9)->get();
        $liked = Like::where('user_id', $authorId)->where('image_id', $id)->first();
        $likes = Like::where('image_id', $id)->get();
        $numberOfLikes = count($likes);
        $tags = Tag::whereHas('images', function($q) use ($id) {
            return $q->where('taggable_id', $id);
        })->limit(6)->get();
        return view('specificImage', ['image' => $image,'subImages' => $subImages, 'recentImages' => $recentImages, 'commentsCount' => $commentsCount ,'tags' => $tags, 'similarImages' => $similarImages, 'author' => $author, 'comments' => $comments, 'liked' => $liked, 'numberOfLikes' => $numberOfLikes,]);
    }

    public function profile($username){
        $user = User::where('username', $username)->first();
        $id = $user->id;
        $images = Image::where('parent_id', NULL)->where('user_id', $id)->orderBy('created_at', 'desc')->limit(9)->get();
        $likedImages = Image::whereHas('likes', function($likes) use ($id){
            $likes->where('user_id', $id);
        })->orderBy('created_at', 'desc')->limit(9)->get();
        return view('profile', ['user' => $user, 'images' => $images, 'likedImages' => $likedImages]);
    }

    public function settings(){
        $user = Auth::user();
        return view('settings', ['user' => $user]);
    }

    public function upload(){
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('upload', ['categories' => $categories]);
    }

    public function admin(){
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin', ['categories' => $categories]);
    }

    public function categories(){
        $categories = Category::withCount('images')->orderBy('images_count', 'desc')->get();
        return view('categories', ['categories' => $categories]);
    }

    public function specificCategory($name){
        $category = Category::where('name', $name)->first();
        $images = Image::where('parent_id', NULL)->where('category_id', $category->id)->orderBy('created_at', 'desc')->get();
        return view('Home', ['images' => $images]);
    }

    public function signUp(){
        return view('signUp');
    }

    public function signIn(){
        return view('signIn');
    }

    public function updateArtwork($id){
        $image = Image::where('id', $id)->first();
        $categoryId = $image->category_id;

        //$categories = Category::orderBy('created_at', 'desc')->get();
        //$categories = $categories->where('id', $categoryId)->merge($categories);

        if ($categoryId) {
            $categories = Category::where('id', '!=', $categoryId)->orderByDesc('created_at')->get();
            $categories->prepend(Category::find($categoryId));
        } else {
            $categories = Category::orderByDesc('created_at')->get();
        }

        $tags = Tag::whereHas('images', function($q) use ($id) {
            return $q->where('taggable_id', $id);
        })->get();

        $tagString = $tags->implode('name', ',');

        return view('updateArtwork', ['image' => $image, 'categories' => $categories, 'tagString' => $tagString]);
    }

    public function search(Request $request){
        $query = $request->get('q');
        if ($query) {
            $images = Image::where('name', 'like', '%'.$query.'%')
            ->orWhereHas('tags', function($q) use ($query) {
                return $q->where('name', 'like', '%'.$query.'%');
            })->orWhereHas('category', function($q) use ($query) {
                return $q->where('name', 'like', '%'.$query.'%');
            })->latest()->get();

            return view('home', ['images' => $images]);
        } else {
            return redirect()->back();
        }
    }

}
