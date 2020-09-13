<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book/create');
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter a title!'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('book/create')
                ->withErrors($validator)
                ->withInput();
        }

        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->count = $request->count;
        $book->appearance_date = null;
        $book->save();

        return redirect('/')->with('status', 'New book successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('book/create')->with('book', $book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('book.edit')
                ->with('book', $book)
                ->withErrors($validator)
                ->withInput();
        } else {
            $book = Book::find($request->book->id);
            if ($book) {
                $book->title = $request->title;
                $book->description = $request->description;
                $book->count = $request->count ?? 0;
                $book->appearance_date = null;
                $book->save();

                return redirect('/')->with('status', 'Book successfully updated!');
            } else {
                return redirect('/')->with('status', 'Something went wrong please try again later!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book) {
            $book->delete();
            return redirect('/')->with('status', 'Book successfully deleted!');
        } else {
            return redirect('/')->with('status', 'Something went wrong please try again later!');
        }
    }
}
