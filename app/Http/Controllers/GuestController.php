<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Items;

class GuestController extends Controller
{
	public function index()
	{
		$categories = Categories::where('status', 1)->get();
		return view('welcome', compact('categories'));
	}
	public function fetch_items($id)
	{
		$items = Items::where('category_id', $id)->where('status', 1)->get();
		return view('item_guest', compact('items'));
	}
	public function show_category(Request $request)
	{
		$searchInput = $request->input('CategoryName');
		$categories = Categories::where('name', 'LIKE', '%' . $searchInput . '%')->where('status', 1)->select('id', 'name', 'photo')->get();
		$baseURL = url('/');
		$data = compact('categories', 'baseURL');
		$response = json_encode($data);
		return response($response, 200)->header('Content-Type', "application/json");
	}
	public function show_items_on_search(Request $request)
	{
		$searchInput = $request->input('ItemName');
		$items = Items::where('name', 'LIKE', '%' . $searchInput . '%')->where('status', 1)->select('id', 'name', 'photo', 'description', 'price')->get();
		$baseURL = url('/');
		$data = compact('items', 'baseURL');
		$response = json_encode($data);
		return response($response, 200)->header('Content-Type', "application/json");
	}
}
