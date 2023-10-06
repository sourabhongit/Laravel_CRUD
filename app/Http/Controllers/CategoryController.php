<?php

namespace App\Http\Controllers;

use App\Exports\ExportCategories;
use Illuminate\Http\Request;
use App\Models\Categories;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        if ($categories) {
            return view('category/index', compact('categories'));
        } else {
            return redirect()->route('')->with('error', 'Item limit exceeded for ');
        }
    }

    public function create()
    {
        return view('category/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'number_of_items' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);
        $path = public_path('images/categories/');
        !is_dir($path) && mkdir($path, 0777, true);

        $name = time() . '.' . $request->photo->extension();
        ResizeImage::make($request->file('photo'))
            ->resize(100, 100)
            ->save($path . $name);

        $category = new Categories;
        $category->name = $request->input('category_name');
        $category->number_of_items = $request->input('number_of_items');
        $category->status = boolval($request->input('category_status'));
        $category->photo = $name;
        $category->save();
        return redirect()->route('category.index');
    }

    public function edit($id)
    {
        $category = Categories::find($id);

        if ($category) {
            return view('category/edit', compact('category', 'id'));
        } else {
            return redirect()->route('category.index')->with('error', 'Category not found');
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
                    ->resize(400, 400)
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

        return redirect()->route('category.index');
    }
    public function delete($id)
    {
        $category = Categories::find($id);

        if ($category) {
            $category->delete();
        }

        return redirect()->route('category.index');
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
    public function exportUsers()
    {
        return Excel::download(new ExportCategories, 'categories.xlsx');
    }
}
