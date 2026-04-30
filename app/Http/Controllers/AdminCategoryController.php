<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories', ['categories' => Category::latest()->get()]);
    }

    public function store(Request $request)
    {
        Category::create($request->validate(['name' => ['required', 'string', 'max:255']]));
        return back();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
