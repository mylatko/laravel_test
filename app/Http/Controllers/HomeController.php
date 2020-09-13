<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = \App\Models\Book::paginate(5);

        $user = Auth::user();
        $rentList = [];
        if ($user) {
            $rents = Rent::where('user_id', $user->id)->get();
            foreach ($rents as $rent) {
                $rentList[$rent->book_id] = $rent->finish_date;
            }
        }

        return view('home', [
            'books' => $books,
            'rentList' => $rentList
        ]);
    }
}
