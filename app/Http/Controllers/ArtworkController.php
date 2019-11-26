<?php

namespace App\Http\Controllers;

use App\Image;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Image as InterventionImage;


class ArtworkController extends Controller {

    public function uploadArtwork(Request $request){

        $this->validate($request, [
            'artwork-title' => 'required|max:120',
            'artwork-description' => 'max:120|nullable',
            'artwork-medium' => 'max:120|nullable',
            'artwork-software' => 'max:120|nullable',
            'artwork-tags' => 'max:120|nullable',
            'files' => 'required',
            'files.*' =>  'required|max:4096',
        ]);

        $title = $request['artwork-title'];
        $description = $request['artwork-description'];
        $medium = $request['artwork-medium'];
        $software = $request['artwork-software'];
        $tagsRaw = $request->input('artwork-tags');
        $tags = explode(',', $tagsRaw);
        $categoryId = $request['artwork-category'];
        $userId = auth()->user()->id;
        $files = $request->file('files');
        $numberOfImages = count($files);

        $file = $files[0]->getClientOriginalName();
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $extension = $files[0]->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $fileNameToStore = str_replace(' ', '', $fileNameToStore);

        $files[0]->storeAs('public/uploads/images/',$fileNameToStore);
        $files[0]->storeAs('public/uploads/images/thumbnails/',$fileNameToStore);
        $files[0]->storeAs('public/uploads/images/specificImages/',$fileNameToStore);
        $files[0]->storeAs('public/uploads/images/miniImages/',$fileNameToStore);

        $thumbnail = InterventionImage::make('storage/uploads/images/thumbnails/'.$fileNameToStore )->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $thumbnail->save();

        $specificImage = InterventionImage::make('storage/uploads/images/specificImages/'.$fileNameToStore )->resize(2000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $specificImage->save();

        $miniImage = InterventionImage::make('storage/uploads/images/miniImages/'.$fileNameToStore )->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        });
        $miniImage->save();

        $image = new Image();
        $image->name = $title;
        $image->description = $description;
        $image->medium = $medium;
        $image->software = $software;
        $image->user_id = $userId;
        $image->image_file_name = $fileNameToStore;
        $image->category_id = $categoryId;

        $image->save();

        if (!empty($tagsRaw)) {
            foreach($tags as $tagName) {
                $tagExists = Tag::where('name', $tagName)->exists();
                if (!$tagExists) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                    $image->tags()->attach($tag);
                } else {
                    $existingTag = Tag::where('name', $tagName)->first();
                    $image->tags()->attach($existingTag);
                }
            }
        }

        if ($numberOfImages == 1) {
            return redirect()->route('home');
        } else {
            $parentId = $image->id;
            foreach(array_slice($files,1) as $files=>$file) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                $fileNameToStore = str_replace(' ', '', $fileNameToStore);

                $file->storeAs('public/uploads/images/',$fileNameToStore);
                $file->storeAs('public/uploads/images/thumbnails/',$fileNameToStore);
                $file->storeAs('public/uploads/images/specificImages/',$fileNameToStore);
                $file->storeAs('public/uploads/images/miniImages/',$fileNameToStore);

                $thumbnail = InterventionImage::make('storage/uploads/images/thumbnails/'.$fileNameToStore )->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnail->save();

                $specificImage = InterventionImage::make('storage/uploads/images/specificImages/'.$fileNameToStore )->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $specificImage->save();

                $miniImage = InterventionImage::make('storage/uploads/images/miniImages/'.$fileNameToStore )->fit(200, 200, function ($constraint) {
                    $constraint->upsize();
                });
                $miniImage->save();

                $image = new Image();
                $image->name = $title;
                $image->description = $description;
                $image->medium = $medium;
                $image->software = $software;
                $image->user_id = $userId;
                $image->image_file_name = $fileNameToStore;
                $image->parent_id = $parentId;

                $image->save();
            }
            return redirect()->route('home');
        }
    }

    public function DeleteArtwork($imageId){

        $image = Image::where('id', $imageId)->first();

        if (!Auth::user()->hasRole('Admin')) {
            if (Auth::user() != $image->user){
                return redirect()->back();
            }
        }

        $imageName = $image->image_file_name;
        $image->tags()->detach();
        $image->delete();
        Storage::delete('public/uploads/images/'.$imageName);
        Storage::delete('public/uploads/images/thumbnails/'.$imageName);
        Storage::delete('public/uploads/images/specificImages/'.$imageName);
        Storage::delete('public/uploads/images/miniImages/'.$imageName);
        $imageChildren = Image::where('parent_id', $image->id)->get();

        foreach ($imageChildren as $imageChild) {
            Storage::delete('public/uploads/images/'.$imageChild->image_file_name);
            Storage::delete('public/uploads/images/thumbnails/'.$imageChild->image_file_name);
            Storage::delete('public/uploads/images/specificImages/'.$imageChild->image_file_name);
            Storage::delete('public/uploads/images/miniImages/'.$imageChild->image_file_name);
            $imageChild->delete();
        }

        return redirect()->route('home');

    }

    public function updateArtwork(Request $request, $imageId){
        $this->validate($request, [
            'artwork-title' => 'required|max:120',
            'artwork-description' => 'max:120|nullable',
            'artwork-medium' => 'max:120|nullable',
            'artwork-software' => 'max:120|nullable',
            'artwork-tags' => 'max:120|nullable'
        ]);

        $tagsRaw = $request->input('artwork-tags');
        $tags = explode(',', $tagsRaw);

        $image = Image::where('id', $imageId)->first();
        $image->name = request('artwork-title');
        $image->description = request('artwork-description');
        $image->medium = request('artwork-medium');
        $image->software = request('artwork-software');
        $image->category_id = request('artwork-category');

        $image->save();

        if (!empty($tagsRaw)) {
            foreach($tags as $tagName) {
                $tagExists = Tag::where('name', $tagName)->exists();
                if (!$tagExists) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->save();
                    $image->tags()->attach($tag);
                } else {
                    $existingTag = Tag::where('name', $tagName)->first();
                    $image->tags()->attach($existingTag);
                }
            }
        }

        return back();
    }

}
