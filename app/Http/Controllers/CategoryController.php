<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function postCategories(Request $request){
        $categories = Category::all();
        return view('user.categories', compact('categories'));

    }

    public function addCategory(Request $request){

        try {
            $categories = Category::create([
                'name'=>$request->catname,
                'slug'=>$request->catslug
            ]);
            return response()->json(['success'=>true,'msg'=>'Category added successfully!!!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function editCategory(Request $request){

        try {
            $category = Category::find($request->id);
            $category->name = $request->catname;
            $category->slug = $request->catslug;
            $category->save();

            return response()->json(['success'=>true,'msg'=>'Category updated successfully!!!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
}
