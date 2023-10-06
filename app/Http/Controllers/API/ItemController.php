<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    public function index()
    {
        $items = Items::get();
        return response($items);
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'item_price' => 'required',
            'item_description' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);
        $path = public_path('images/items/');
        !is_dir($path) && mkdir($path, 0777, true);
        $name = time() . '.' . $request->photo->extension();
        ResizeImage::make($request->file('photo'))->resize(500, 500)->save($path . $name);

        $item = new Items;
        $item->name = $request->input('item_name');
        $item->category_id = $request->input('category_id');
        $item->price = $request->input('item_price');
        $item->description = $request->input('item_description');
        $item->photo = $name;
        $item->status = boolval($request->input('item_status'));
        $item->save();

        return response($item, 201);
    }
    public function edit($id)
    {
        $item = Items::find($id);

        if ($item) {
            return response($item);
        } else {
            return response("No category found with this id", 404);
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
                    ->resize(500, 500)
                    ->save($path . $name);
                $item->photo = $name;
            } else {
                return response("File upload error", 409);
            }
        }
        $item->name = $request->input('item_name');
        $item->category_id = $request->input('category_id');
        $item->description = $request->input('item_description');
        $item->price = $request->input('item_price');
        $item->status = boolval($request->input('item_status'));
        $item->update();
        if ($previousFile) {
            File::delete($previousFile);
        }
        return response($item, 201);
    }
    public function delete($id)
    {
        $item = Items::find($id);

        if ($item) {
            $item->delete();
        }

        return response($item->name . " : Item Deleted");
    }
}
