<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Items;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    public function index()
    {
        $items = Items::all();
        return view('item/index', compact('items'));
    }
    public function create()
    {
        $categories = Categories::where('status', 1)->get();
        return view('item/create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'item_price' => 'required',
            'item_description' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);
        $category = Categories::find($request['category_id']);
        $item = new Items;
        $path = public_path('images/items/');
        !is_dir($path) && mkdir($path, 0777, true);

        $name = time() . '.' . $request->photo->extension();
        ResizeImage::make($request->file('photo'))
            ->resize(100, 100)
            ->save($path . $name);

        $categoryId = $category->id;
        $categoryName = $category->name;
        $currentNumberOfItems = Items::where('category_id', $categoryId)->count();

        if ($currentNumberOfItems >= $category->number_of_items) {
            return redirect()->route('item.create')->with('error', 'Item limit exceeded for ' . $categoryName . '.');
        }

        $item->name = $request->input('item_name');
        $item->category_id = $request->input('category_id');
        $item->price = $request->input('item_price');
        $item->description = $request->input('item_description');
        $item->photo = $name;
        $item->status = boolval($request->input('item_status'));
        $item->save();

        return redirect()->route('item.index');
    }
    public function edit($id)
    {
        $categories = Categories::where('status', 1)->get();
        $item = Items::find($id);

        if ($item) {
            return view('item/edit', compact('item', 'id', 'categories'));
        } else {
            return redirect()->route('item.index')->with('error', 'Item not found');
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'item_price' => 'required',
            'item_description' => 'required',
        ]);
        $item = Items::find($id);
        $previousFile = "";
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $request->validate([
                    'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
                ]);
                $path = public_path('images/items/');
                $previousFile = $path . $item->photo;
                $name = time() . '.' . $request->photo->extension();
                ResizeImage::make($request->file('photo'))
                    ->resize(100, 100)
                    ->save($path . $name);
                $item->photo = $name;
            } else {
                $name = "File is not valid.";
            }
        } else {
            $name = "has no file";
        }
        $item->name = $request->input('item_name');
        $item->category_id = $request->input('category_id');
        $item->price = $request->input('item_price');
        $item->description = $request->input('item_description');
        $item->status = boolval($request->input('item_status'));
        $item->update();
        if ($previousFile) {
            File::delete($previousFile);
        }

        return redirect()->route('item.index');
    }
    public function delete($id)
    {
        $item = Items::find($id);

        if ($item) {
            $item->delete();
        }

        return redirect()->route('item.index');
    }
    public function updateStatus(Request $request)
    {
        $itemId = $request->input('item_id');
        $itemStatus = $request->input('item_status');
        $item = Items::find($itemId);

        if ($item) {
            $item->status = $itemStatus;
            $item->save();

            return redirect()->route('item.index');
        }
        return redirect()->route('item.index');
    }
}
