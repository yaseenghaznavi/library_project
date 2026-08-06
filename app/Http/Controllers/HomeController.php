<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;

class HomeController extends Controller
{
    //
    public function index()
    {
        $books = Book::paginate(4);
        return view('home.index', compact('books'));
    }

    public function borrow_books($id){
        $book = Book::find($id);
        $quantity = $book->quantity;
        $book_id = $id;

        if($quantity >= '1'){
            if(Auth::id()){
                $user_id = Auth::user()->id;
                $borrow = new Borrow();

                $borrow->book_id = $book_id;
                $borrow->user_id = $user_id;
                $borrow->status = 'Applied';

                $borrow->save();

                return redirect()->back()->with('message', "A request is sent to admin to borrow this book.");

            }
            else{
                return redirect('/login');
            }
        }

        else{
            return redirect()->back()->with('message', "Book Currenty Unavailable.");
        }
    }

    public function book_history(){
        if(Auth::id()){
            
            $user_id = Auth::user()->id;
            $book_requests = Borrow::with('book')->where('user_id', '=', $user_id)->get();
            return view('home.book_history', compact('book_requests'));
        
        }

    }

    public function cancel_request($id){
        $request = Borrow::find($id);
        $request->delete();
        return redirect()->back()->with('message', 'Book Borrow Request Cancelled.');
    }

    public function explore(){
        $books = Book::paginate(6);
        $categories = Category::all();
        return view('home.explore', compact('books', 'categories'));
    }

    public function search(Request $request){
        $search = $request->search;

        $categories = Category::all();

        $books = Book::where('title', 'LIKE', '%'.$search.'%')->orWhere('author_name', 'LIKE', '%'.$search.'%')->get();

        return view('home.explore', compact('books', 'categories'));
    }

    public function cat_search($id){
        
        $books = Book::where('category_id', $id)->get();
        $categories = Category::all();
        return view('home.explore', compact('books', 'categories'));
    }
}