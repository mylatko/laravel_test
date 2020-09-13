@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome to Library!') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                        @if (Auth::user()->isAdmin())
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('book.create') }}" method="get" class="mr-2">
                                    @method('GET')
                                    @csrf
                                    <input type="submit" value="Create new book">
                                </form>
                                <form action="{{ route('rent') }}" method="get">
                                    @method('GET')
                                    @csrf
                                    <input type="submit" value="Rent list">
                                </form>
                            </div>
                        @endif
                    @endauth

                    @if ($books)
                        <table class="table mt-5">
                            <tr>
                                <th>Title</th>
                                <th>Books count</th>
                                <th>Appearance date</th>
                                <th></th>
                            </tr>
                        @foreach ( $books as $book )
                            <tr @if (in_array($book->id, array_keys($rentList))) {{__('class=table-active')}} @endif>
                                <td>
                                    {{ $book->title }}
                                </td>
                                <td>
                                    {{ $book->count }}
                                </td>
                                <td>
                                    {{ $book->appearance_date }}
                                </td>
                                <td>
                                    @auth
                                        @if (Auth::user()->isAdmin())
                                            <div class="d-flex flex-row">
                                                <form action="{{ route('book.edit', $book) }}" method="GET" class="mr-2">
                                                    @method('GET')
                                                    @csrf
                                                    <input type="submit" value="Edit book">
                                                </form>
                                                <form action="{{ route('book.delete', $book->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="submit" value="Delete book">
                                                </form>
                                            </div>
                                        @else
                                            <div class="d-flex flex-row">
                                                @if (in_array($book->id, array_keys($rentList)) && ($rentList[$book->id] <= date("Y-m-d", time())))
                                                    <form action="{{ route('rent.prolong', $book->id) }}" method="POST">
                                                        @method('patch')
                                                        @csrf
                                                        <input type="submit" value="Prolong book">
                                                    </form>
                                                @elseif (($book->count > 0) && (!in_array($book->id, array_keys($rentList))))
                                                    <form action="{{ route('rent.create', $book->id) }}" method="POST" class="mr-2">
                                                        @method('patch')
                                                        @csrf
                                                        <input type="submit" value="Rent book">
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                        </table>
                        {{ $books->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
