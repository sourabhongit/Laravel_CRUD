<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Categories;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::get();
        return response($categories);
    }
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

            $token = $user->createToken('my-app-token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'number_of_items' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);
        $path = public_path('images/categories/');
        !is_dir($path) && mkdir($path, 0777, true);

        $name = time() . '.' . $request->photo->extension();
        ResizeImage::make($request->file('photo'))
            ->resize(500, 500)
            ->save($path . $name);

        $category = new Categories;
        $category->name = $request->input('category_name');
        $category->number_of_items = $request->input('number_of_items');
        $category->status = boolval($request->input('category_status'));
        $category->photo = $name;
        $category->save();
        $response = $category;
        return response($response, 201);
    }
    public function edit($id)
    {
        $category = Categories::find($id);

        if ($category) {
            return response($category);
        } else {
            return response("No category found");
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'number_of_items' => 'required',
        ]);
        $category = Categories::find($id);
        $previousFile = "";
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $request->validate([
                    'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
                ]);
                $path = public_path('images/categories/');
                $previousFile = $path . $category->photo;
                $name = time() . '.' . $request->photo->extension();
                ResizeImage::make($request->file('photo'))
                    ->resize(500, 500)
                    ->save($path . $name);
                $category->photo = $name;
            } else {
                $name = "File is not valid.";
            }
        } else {
            $name = "has no file";
        }
        $category->name = $request->input('category_name');
        $category->number_of_items = $request->input('number_of_items');
        $category->status = boolval($request->input('category_status'));
        $category->update();
        if ($previousFile) {
            File::delete($previousFile);
        }
        $response = $category;
        return response($response, 201);
    }
    public function delete($id)
    {
        $category = Categories::findOrFail($id);

        $category->delete();

        return response($category->name . " : Category Deleted");
    }

    public function updateStatus(Request $request)
    {
        $categoryId = $request->input('category_id');
        $categoryStatus = $request->input('category_status');
        $category = Categories::find($categoryId);

        if ($category) {
            $category->status = $categoryStatus;
            $category->save();
            return redirect()->route('category.index');
        }
        return redirect()->route('category.index');
    }
}
