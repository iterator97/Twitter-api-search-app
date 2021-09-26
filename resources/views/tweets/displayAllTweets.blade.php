@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="container">

                @for ($i = 0; $i < count($tweets); $i++)
                    <div class="pt-4">
                    <div class=" list-group-item  font-weight-bold"> Author: {{$tweets[$i]->author}}</div>

                    <div class="list-group-item d-flex justify-content-between pt-2 font-weight-bold" >
                        <div> Tweet content: </div>
                    </div>
                    <div class="list-group-item d-flex justify-content-between pt-2">
                        <div> {{$tweets[$i]->content}}</div>
                    </div>
                    </div>

                @endfor

        </div>

        <form action="/searchTweets" enctype="multipart/form-data" method="post">
            @csrf
            <div class="pt-3">
            <button class="btn btn-primary  ">Szukaj nowych</button>
            </div>
        </form>
    </div>
@endsection
