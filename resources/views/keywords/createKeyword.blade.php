@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/keywords/create" enctype="multipart/form-data" method="post">
            @csrf

            <div class="row">
                <div class="col-8 offset-2">

                    <div class="row">
                        <h1>Add new keyword</h1>
                    </div>
                    <div class="form-group row">
                        <label for="keyword" class="col-md-4 col-form-label">Keyword caption</label>

                        <input id="name"
                               type="text"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name"
                               value="{{ old('name') }}"
                               autocomplete="name" autofocus>
                    </div>

                    <div class="row pt-4">
                        <button class="btn btn-primary">Add new keyword</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
