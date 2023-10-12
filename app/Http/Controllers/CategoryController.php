<?php

namespace App\Http\Controllers;

use App\Exports\ExportCategories;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CategoryValidation;
use Illuminate\Http\RedirectResponse;
use App\Traits\DdTrait;

class CategoryController extends Controller
{
    use DdTrait;
    public function index()
    {
        $categories = Categories::all();
        if ($categories) {
            return view('category/index', compact('categories'));
        } else {
            return redirect()->route('')->with('error', 'Category Fetching Error');
        }
    }

    public function create()
    {
        return view('category/create');
    }

    public function store(CategoryValidation $request): RedirectResponse
    {
        $category = new Categories;

        // Check if a file was uploaded
        if ($request->hasFile('photo')) {
            $name = time() . '.' . $request->photo->extension();
            $path = $request->file('photo')->storeAs('images/categories', $name, 'local');

            $category->fill([
                'name' => $request->input('category_name'),
                'number_of_items' => $request->input('number_of_items'),
                'status' => (bool) $request->input('category_status'),
                'photo' => $path,
            ]);

            $category->save();
        }

        return redirect()->route('category.index');
    }

    //* Image upload with Image Intervention
    //* Import this -> use Intervention\Image\Facades\Image;

    /*
    public function store(CategoryValidation $request): RedirectResponse
    {
        $category = new Categories;
        $path = public_path('images/categories/');
        !is_dir($path) && mkdir($path, 0777, true);

        $name = time() . '.' . $request->photo->extension();
        Image::make($request->file('photo'))
            ->resize(100, 100)
            ->save($path . $name);

        $category->fill([
            'name' => $request->input('category_name'),
            'number_of_items' => $request->input('number_of_items'),
            'status' => (bool)$request->input('category_status'),
            'photo' => $name,
        ]);
        $category->save();
        return redirect()->route('category.index');
    }
*/

    public function edit($id)
    {
        $category = Categories::find($id);

        if ($category) {
            return view('category/edit', compact('category', 'id'));
        } else {
            return redirect()->route('category.index')->with('error', 'Category not found');
        }
    }

    public function update($id, Request $request): RedirectResponse
    {
        $category = Categories::findOrFail($id);

        $request->validate([
            'category_name' => 'required',
            'number_of_items' => 'required',
        ]);

        $previousFile = $category->photo;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);

            $name = time() . '.' . $request->photo->extension();
            $path = $request->file('photo')->storeAs('images/categories', $name, 'local');

            $category->photo = $path;
        }

        $category->name = $request->input('category_name');
        $category->number_of_items = $request->input('number_of_items');
        $category->status = boolval($request->input('category_status'));
        $category->update();

        if ($previousFile && isset($path)) {
            Storage::disk('local')->delete($previousFile);
        }

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    public function delete($id): RedirectResponse
    {
        $category = Categories::find($id);

        if ($category) {
            $category->delete();
        } else {
            return redirect()->route('category.index')->with('error', 'Category not found, not able to delete');
        }

        return redirect()->route('category.index');
    }
    public function updateStatus(Request $request)
    {
        $categoryId = $request->input('category_id');
        $categoryStatus = $request->input('category_status');
        $category = Categories::find($categoryId);
        if (false) {
            $category->status = $categoryStatus;
            $category->update();
        } else {
            return response()->json(['error' => 'Status Update Failed'], 404);
        }
    }
    public function exportUsers()
    {
        return Excel::download(new ExportCategories, 'categories.xlsx');
    }
}
