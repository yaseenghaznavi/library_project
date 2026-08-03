<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class AdminController extends Controller
{
    //
    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth::user()->usertype;

            if ($usertype == 'admin') {
                return view('admin.index');
            } else if ($usertype == 'user') {
                return view('home.index');
            } else {
                return redirect()->back();
            }
        }
    }

    public function category_page(){
        $data = Category::all();

        return view('admin.category', compact('data'));
    }
    
    public function add_category(Request $request){
         $data = new Category;
         $data -> cat_title = $request->category;
         $data -> save();
         return redirect()->back()->with('message', "Category Successfully Added");
    }

    public function category_delete($id){
        $data = Category::find($id);
        $data -> delete();
        return redirect() -> back()->with('message', 'Category Successfully Deleted');
    }

    public function edit_category($id){
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id){
        $data = Category::find($id);

        $data->cat_title = $request->cat_name;

        $data->save();

        return redirect('/category_page')->with('message', 'Category Successfully Updated');
    }
}
