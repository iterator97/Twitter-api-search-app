@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="list-group">
            <div class="font-weight-bold">New (for last 3 days)</div>
            @for ($i = 0; $i < count($keywords); $i++)

                @if($keywordsOccurrences[$i]->isNew==1)
                    <div class="pt-2">
                        <li class="list-group-item pt-2 d-flex  justify-content-between">
                            <div> Keyword : {{$keywords[$i]->name}}</div>
                            <div> Occurrencces : {{$keywordsOccurrences[$i]->count}}</div>

                            <div class="d-flex justify-content-between">
                                <div class="pl-4">
                                    <form action="/searchTweetsByKeyword/{{$keywords[$i]->id}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <button class="btn btn-primary ">Show tweets </button>
                                    </form>
                                </div>

                                <div class="pl-4">
                                    <form action="/removeKeyword/{{$keywords[$i]->id}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <button class="btn btn-danger ">Remove item</button>
                                    </form>
                                </div>
                            </div>

                        </li>


                    </div>
                @endif


            @endfor
            <div class="pt-4 font-weight-bold">Old</div>
            @for ($i = 0; $i < count($keywords); $i++)

                @if($keywordsOccurrences[$i]->isNew!=1)
                    <div class="pt-2">
                        <li class="list-group-item pt-2 d-flex  justify-content-between">
                            <div> Keyword : {{$keywords[$i]->name}}</div>
                            <div> Occurrencces : {{$keywordsOccurrences[$i]->count}}</div>

                            <div class="d-flex justify-content-between">
                                <div class="pl-4">
                                    <form action="/searchTweetsByKeyword/{{$keywords[$i]->id}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <button class="btn btn-primary ">Show tweets </button>
                                    </form>
                                </div>

                                <div class="pl-4">
                                    <form action="/removeKeyword/{{$keywords[$i]->id}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <button class="btn btn-danger ">Remove item</button>
                                    </form>
                                </div>
                            </div>

                        </li>


                    </div>
                @endif


            @endfor
        </ul>
    </div>
@endsection

