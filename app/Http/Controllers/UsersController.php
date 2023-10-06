<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\File;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('user/index', compact('users'));
    }
    public function create()
    {
        return view('user/create');
    }
    public function store(UserValidation $request)
    {
        $path = public_path('images/');
        !is_dir($path) && mkdir($path, 0777, true);

        $name = time() . '.' . $request->photo->extension();
        ResizeImage::make($request->file('photo'))
            ->resize(100, 100)
            ->save($path . $name);

        $user = new User;
        $user->name = $request->input('name');
        $user->father_name = $request->input('father_name');
        $user->contact = $request->input('contact');
        $user->dob = $request->input('dob');
        $user->address = $request->input('address');
        $user->photo = $name;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('user/edit', compact('user', 'id'));
        } else {
            return redirect()->route('user.index')->with('error', 'user not found');
        }
    }
    public function update($id, Request $request)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'father_name' => 'required',
            'contact' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
            'email' => 'required|email',
        ]);
        $previousFile = "";
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $path = public_path('images/');
                $previousFile = $path . $user->photo;
                $name = time() . '.' . $request->photo->extension();
                ResizeImage::make($request->file('photo'))
                    ->resize(100, 100)
                    ->save($path . $name);
                $user->photo = $name;
            } else {
                $name = "File is not valid.";
            }
        } else {
            $name = "has no file";
        }

        $user->name = $request->input('name');
        $user->father_name = $request->input('father_name');
        $user->contact = $request->input('contact');
        $user->dob = $request->input('dob');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        if ($request->input('password') !== NULL) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->update();
        if ($previousFile) {
            File::delete($previousFile);
        }
        return redirect()->route('user.index');
    }
    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        return redirect()->route('user.index');
    }
}
