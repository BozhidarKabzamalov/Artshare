<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Image as InterventionImage;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $this->validate($request, [
            'categoryName' => 'required|max:120',
            'categoryImage' => 'required'
        ]);

        $name = $request['categoryName'];
        $file = $request->file('categoryImage')->getClientOriginalName();
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $extension = $request->file('categoryImage')->getClientOriginalExtension();
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
        $fileNameToStore = str_replace(' ', '', $fileNameToStore);

        $request->file('categoryImage')->storeAs('public/uploads/categories', $fileNameToStore);
        $request->file('categoryImage')->storeAs('public/uploads/categories/thumbnails', $fileNameToStore);

        $thumbnailImage = InterventionImage::make('storage/uploads/categories/thumbnails/'.$fileNameToStore )->fit(400, 400, function ($constraint) {
            $constraint->upsize();
        });

        $thumbnailImage->save();

        $category = new category();
        $category->name = $name;
        $category->image_file_name = $fileNameToStore;

        $category->save();

        return redirect()->back();
    }

    public function deleteCategories(Request $request){

        if (!Auth::user()->hasRole('Admin')) {
                return redirect()->back();
        } else if (Auth::user()->hasRole('Admin')) {
            $categories = $request['categories'];
            $categoryFiles = $request['categoryFiles'];
            foreach ($categories as $key => $category) {
                Storage::delete('public/uploads/categories/'.$categoryFiles[$key]);
                Storage::delete('public/uploads/categories/thumbnails/'.$categoryFiles[$key]);
            }
            Category::whereIn('id', $categories)->delete();
            return redirect()->back();
        }

    }

}
