<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Items;
use Illuminate\support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Items::all();
        if ($items) {
            return view('item/index', compact('items'));
        } else {
            return redirect()->route('dashboard')->with('error', 'Items not found');
        }
    }

    public function create()
    {
        $categories = Categories::where('status', 1)->get();
        if ($categories) {
            return view('item/create', compact('categories'));
        }
        return redirect()->route('item.create')->with('error', 'Categories not found');
    }

    public function store(Request $request)
    {
        $category = Categories::findOrFail($request['category_id']);
        $item = new Items;
        $request->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'item_price' => 'required',
            'item_description' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);
        if ($request->hasFile('photo')) {
            $name = time() . '.' . $request->photo->extension();
            $path = $request->file('photo')->storeAs('images/items', $name, 'local');

            $categoryId = $category->id;
            $categoryName = $category->name;
            $currentNumberOfItems = Items::where('category_id', $categoryId)->count();

            if ($currentNumberOfItems >= $category->number_of_items) {
                return redirect()->route('item.create')->with('error', 'Item limit exceeded for ' . $categoryName . '.');
            }

            $item->fill([
                'name' => $request->input('item_name'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('item_price'),
                'description' => $request->input('item_description'),
                'photo' => $path,
                'status' => boolval($request->input('item_status')),
            ]);
            $item->save();
        }
        return redirect()->route('item.index')->with('success', 'Item created successfully');
    }

    public function edit($id)
    {
        $categories = Categories::where('status', 1)->get();
        $item = Items::findOrFail($id);

        if ($categories) {
            if ($item) {
                return view('item/edit', compact('item', 'id', 'categories'));
            } else {
                return redirect()->route('item.index')->with('error', 'Item not found');
            }
        }
        return redirect()->route('item.index')->with('error', 'Category not found');
    }

    public function update($id, Request $request)
    {
        $item = Items::findOrFail($id);
        $previousFile = $item->photo;
        $request->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'item_price' => 'required',
            'item_description' => 'required',
        ]);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);
            $name = time() . '.' . $request->photo->extension();
            $path = $request->file('photo')->storeAs('images/items', $name, 'local');
            $item->photo = $path;
        }

        $item->name = $request->input('item_name');
        $item->category_id = $request->input('category_id');
        $item->price = $request->input('item_price');
        $item->description = $request->input('item_description');
        $item->status = boolval($request->input('item_status'));
        $item->update();
        if ($previousFile && isset($path)) {
            Storage::disk('local')->delete($previousFile);
        }
        return redirect()->route('item.index')->with('success', 'Item updated successfully');
    }

    public function delete($id)
    {
        $item = Items::find($id);

        if ($item) {
            $item->delete();
        }

        return redirect()->route('item.index')->with('error', 'Item not found, not able to delete.');
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
