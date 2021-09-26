@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="font-weight-bold">
            Tweets with this keyword {{$keyWord}}
        </div>
        <di>

        <ul class="list-group">
            <div class="pt-4 font-weight-bold">Interesting</div>
            @for ($i = 0; $i < count($returnTweets); $i++)
                @if($returnTweets[$i]->ok==1)
                    <div class="pt-2 d-flex" >
                        <li class="list-group-item pt-2   justify-content-between">
                            <div>
                                <div>Content:</div>
                                <div>{{$returnTweets[$i]->content}}</div>
                                <div>Author:</div>
                                <div>{{$returnTweets[$i]->author}}</div>

                            </div>
                            <form action="/tweets/{{$keywordId}}/setTweetToNotInteresting/{{$returnTweets[$i]->id}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="row pt-4">
                                    <button class="btn btn-danger">Change to not interesting</button>
                                </div>
                            </form>
                        </li>
                @endif
                </div>

            @endfor
        </ul>
        </di>
        <di>
            <ul class="list-group">
                <div class="pt-4 font-weight-bold pl-2">Not interesting</div>
                @for ($i = 0; $i < count($returnTweets); $i++)
                    @if($returnTweets[$i]->ok!=1)
                        <div class="pt-2 d-flex" >
                            <li class="list-group-item pt-2   justify-content-between">
                                <div>
                                    <div>Content:</div>
                                    <div>{{$returnTweets[$i]->content}}</div>
                                    <div>Author:</div>
                                    <div>{{$returnTweets[$i]->author}}</div>

                                </div>

                                <form action="/tweets/{{$keywordId}}/setTweetToInteresting/{{$returnTweets[$i]->id}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="row pt-4">
                                        <button class="btn btn-primary">Change to interesting</button>
                                    </div>
                                </form>
                            </li>
                            @endif
                        </div>

                        @endfor
            </ul>
        </di>


    </div>
@endsection

