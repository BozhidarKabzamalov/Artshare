<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use Image as InterventionImage;

class UsersController extends Controller {

    public function signUp(Request $request){
        $this->validate($request, [
            'firstName' => 'required|max:120',
            'lastName' => 'required|max:120',
            'username' => 'required|max:120|unique:users',
            'password' => 'required|min:5|max:12',
            'email' => 'required|email|unique:users'
        ]);

        $firstName = $request['firstName'];
        $lastName = $request['lastName'];
        $username = $request['username'];
        $password = bcrypt($request['password']);
        $email = $request['email'];
        $role_user = Role::where('name', 'User')->first();

        $user = new User();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->username = $username;
        $user->password = $password;
        $user->email = $email;
        $user->image_file_name = 'default.jpg';

        $user->save();
        $user->roles()->attach($role_user);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function signIn(Request $request){
        $this->validate($request, [
            'username' => 'required|max:120',
            'password' => 'required|min:5|max:12'
        ]);

        $username = $request['username'];
        $password = $request['password'];

        if (Auth::attempt(['username' => $username, 'password' => $password])){
            return redirect()->route('home');
        } else {
            return redirect()->back();
        }
    }

    public function logOut(){
        Auth::logout();
        return redirect()->back();
    }

    public function updateProfile(Request $request, User $user){

        $this->validate($request, [
            'first_name' => 'max:120|required',
            'last_name' => 'max:120|required',
            'email' => 'email|required|unique:users,email,'.$user->id,
            'file' => 'max:1999|nullable'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $fileNameToStore = str_replace(' ', '', $fileNameToStore);

            $user->image_file_name = $fileNameToStore;

            $request->file('file')->storeAs('public/uploads/profile_pictures/', $fileNameToStore);
            $request->file('file')->storeAs('public/uploads/profile_pictures/edited/', $fileNameToStore);

            $img = InterventionImage::make('storage/uploads/profile_pictures/edited/'.$fileNameToStore)->fit(100);

            $img->save();
        }

        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->email = request('email');

        $user->save();

        return back();
    }

}
