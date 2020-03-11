@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center"><b>Order Details</b></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                                <div class="card-body">
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col"><b>Question title</b></th>
                                            <th scope="col"><b>Pages</b></th>
                                            <th scope="col"><b>Category</b></th>
                                            <th scope="col"><b>Level</b></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>{{ $question->title }}</td>
                                            <td>{{ $question->pages }}</td>
                                            <td>{{ $question->subject }}</td>
                                            <td>{{ $question->level }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <br />
                                    <hr />
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5><b>More Instructions</b></h5>
                                                {{ $question->details }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row justify-content-end">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Price:${{$question->price}}</h4>
                    </div>
                    <div class="card-body justify-content-end" style="align-content: center;">
                        <form action="{{ route('create-payment') }}" method="post">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $question->price }}">

                            <input type="submit" value="Pay Now">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
