<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Book;

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
                $books = Book::all();
                return view('home.index', compact('books'));
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

    public function add_book(){
        $data = Category::all();

        return view("admin.add_book", compact('data'));
    }

    public function store_book(Request $request){
        $data = new Book();

        $data->title = $request->book_name;
        $data->author_name = $request->author_name;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->description = $request->description;
        $data->category_id = $request->category;
        $book_image = $request->book_img;
        $author_image = $request->author_img;

        if($book_image){
            $book_image_name = time().'.'.$book_image->getClientOriginalExtension();
            $book_image->move('book', $book_image_name);
            $data->book_img = $book_image_name;
        }

        if($author_image){
            $author_image_name = time().'.'.$author_image->getClientOriginalExtension();
            $author_image->move('author', $author_image_name);
            $data->author_img = $author_image_name;
        }

        $data->save();
        return redirect()->back();

    }

    public function show_book(){
        $book_data = Book::all();
        return view('admin.show_book', compact('book_data'));
    }

    public function book_delete($id){
        $data = Book::find($id);
        $data->delete();
        return redirect()->back()->with('message', "Book Deleted Successfully");
    }

    public function edit_book($id){
        $book = Book::find($id);
        $category = Category::all();

        return view('admin.edit_book', compact('book', 'category'));
    }

    public function update_book(Request $request, $id){
        $data = Book::find($id);
        $data->title = $request->title;
        $data->author_name = $request->author_name;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->description = $request->description;
        $data->category_id = $request->category;

        $book_image = $request->book_img;
        $author_image = $request->author_img;
        
        if($book_image){
            $book_image_name = time().'.'.$book_image->getClientOriginalExtension();
            $book_image->move('book', $book_image_name);
            $data->book_img = $book_image_name;
        }
        
        if($author_image){
            $author_image_name = time().'.'.$author_image->getClientOriginalExtension();
            $author_image->move('author', $author_image_name);
            $data->author_img = $author_image_name;
        }

        $data -> save();

        return redirect('/show_book')->with('message', 'Book Successfully Updated');
    }
}
