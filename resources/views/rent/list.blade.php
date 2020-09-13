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

                    @if ($list)
                        <div>
                            <form action="{{route('rent')}}" method="GET" name="filter">
                                Filter by finish rent
                                <select name="f" id="f">
                                    <option value="all" @if ( ($filter=='all') ) selected @endif>All</option>
                                    <option value="finished" @if ( ($filter=='finished') ) selected @endif>Finished</option>
                                    <option value="notfinished" @if ( ($filter=='notfinished') ) selected @endif>Not finished</option>
                                </select>
                            </form>
                        </div>

                        <table class="table mt-5">
                            <tr>
                                <th>User</th>
                                <th>Book</th>
                                <th>Count</th>
                                <th>Begin date</th>
                                <th>Finish date</th>
                            </tr>
                        @foreach ( $list as $l )
                            <tr>
                                <td>
                                    {{ $l->user->name }}
                                </td>
                                <td>
                                    {{ $l->book->title }}
                                </td>
                                <td>
                                    {{ $l->count }}
                                </td>
                                <td>
                                    {{ date("Y-m-d", strtotime($l->begin_date)) }}
                                </td>
                                <td>
                                    {{ date("Y-m-d", strtotime($l->finish_date)) }}
                                </td>
                            </tr>
                        @endforeach
                        </table>
                        {{ $list->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    document.addEventListener('change', function (event) {
        if (event.target.id == 'f') {
            document.forms['filter'].submit();
        }
    });
</script>
