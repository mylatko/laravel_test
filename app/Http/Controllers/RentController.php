<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List of rented books
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filter = $request->f;
        $list = [];
        switch ($filter) {
            case 'finished':
                $list = \App\Models\Rent::where('finish_date', '<=', date("Y-m-d", time()))->paginate(5);
                break;
            case 'notfinished':
                $list = \App\Models\Rent::where('finish_date', '>', date("Y-m-d", time()))->paginate(5);
                break;
            default:
                $list = \App\Models\Rent::paginate(5);
                break;
        }


        return view('rent/list', [
            'list' => $list,
            'filter' => $filter
        ]);
    }

    /**
     * Make rent for book
     * @param int $bookId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function rent(int $bookId)
    {
        $book = Book::find($bookId);

        if (!$book || ($book->count == 0) ) {
            return redirect('/')->with('status', 'Book doesn\'t exists or doesn\'t enough!');
        }

        $user = Auth::user();

        $rent = Rent::where('user_id', $user->id)->where('book_id', $book->id)->first();
        if ($rent ) {
            return redirect('/')->with('status', 'Book already in rent!');
        }

        $rent = new Rent();
        $rent->book_id = $book->id;
        $rent->user_id = $user->id;
        $rent->count++;
        $rent->begin_date = date("Y-m-d");
        $rent->finish_date = date("Y-m-d", strtotime("+2 weeks"));
        $rent->save();

        $book->count--;
        $book->save();

        return redirect('/')->with('status', 'Book in a rent!');
    }

    public function prolong(Request $request)
    {
        $book = Book::find($request->book);
        if (!$book) {
            return redirect('/')->with('status', 'Book doesn\'t exists!');
        }

        $user = Auth::user();
        $rent = Rent::where('user_id', $user->id)->where('book_id', $book->id)->first();

        if (!$rent) {
            return redirect('/')->with('status', 'Book not in rent!');
        }

        $rent->finish_date = date("Y-m-d", strtotime("+2 weeks"));
        $rent->save();

        return redirect('/')->with('status', 'Rent successfully prolong!');
    }
}
